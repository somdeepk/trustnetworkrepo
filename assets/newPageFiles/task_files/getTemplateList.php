<?php
ob_start();
session_start();
ini_set('memory_limit', '1024M');
include("../../include/connection.php");

$main_count=0;
$orderColumnId=0;
$orderColumnDir='DESC';
$displayStart=0;
$displayLength=10;

if (!empty($_POST)) {
	$post_data = $_POST;
	$postData = array();
	if (isset($post_data['iColumns'])) {
		$new_array=array();
		for ($i=0; $i<$post_data['iColumns']; $i++) {
			$new_array[$i]['data']=$i ;
			$new_array[$i]['name']=$post_data['mDataProp_'.$i] ;
			$new_array[$i]['orderable']=$post_data['bSortable_'.$i] ;
		}
		$postData['columns']=$new_array ;
		$orderColumnId=$post_data['iSortCol_0'] ;
		$orderColumnDir=$post_data['sSortDir_0'] ;
		$displayStart=$post_data['iDisplayStart'] ;
		$displayLength=$post_data['iDisplayLength'] ;
	}
}
$searchStr="";
$sort_str="";
$limit_str="";
$havingStr="";

$searchTemplateName=(isset($post_data['searchTemplateName']) && trim($post_data['searchTemplateName'])!='')? addslashes(trim($post_data['searchTemplateName'])) : '' ;
if (!empty($searchTemplateName)) {
	$searchStr.=" AND t.template_name LIKE '%".$searchTemplateName."%'";
}
$sort_str=" ORDER BY t.id DESC";
if ($orderColumnId==0) {
	$sort_str=" ORDER BY t.id ". $orderColumnDir ;
} else if ($orderColumnId==1) {
	$sort_str=" ORDER BY t.template_name ". $orderColumnDir;
} else if ($orderColumnId==2) {
	$sort_str=" ORDER BY templateTaskCount ". $orderColumnDir;
} else if ($orderColumnId==3) {
	$sort_str=' ORDER BY workOrderCount '. $orderColumnDir;
}
$limit_str="";
if (isset($displayStart) && !empty($displayLength)) {
	$limit_str=" LIMIT ".$displayStart." , ".$displayLength;
}

$primarySql="SELECT t.id AS templateId, t.template_name AS templateName, (SELECT COUNT(id) FROM tbltasktemplatedetails WHERE template_id=t.id AND is_deleted='0') AS templateTaskCount, (SELECT GROUP_CONCAT(DISTINCT(CONCAT_WS('|-|', COALESCE(a.task_order, '0'), COALESCE(a.id, '0'), COALESCE(b.specification_name, ''), COALESCE(b.id, '0'), COALESCE(b.is_behave, '0')))  SEPARATOR '|~|') FROM tbltasktemplatedetails AS a LEFT JOIN tbltaskspecification AS b ON a.shortdesc_id=b.id WHERE a.is_deleted='0' AND a.template_id=t.id GROUP BY a.template_id ORDER BY `a`.`task_order` ASC) AS taskDetails, (SELECT COUNT(DISTINCT(module_id)) FROM tblworkordertask WHERE template_id=t.id AND is_deleted='0') AS workOrderCount FROM `tbltasktemplate` AS t WHERE t.is_deleted='0' $searchStr";

$rowDataArr=array();
$main_count=mysqli_num_rows(mysqli_query($primarySql));
$genSql=mysqli_query($primarySql.$sort_str.$limit_str) ;

while($rowData=mysqli_fetch_array($genSql)) {
		$templateId=(isset($rowData['templateId']) && !empty($rowData['templateId']))? $rowData['templateId'] : 0 ;
		$templateName=(isset($rowData['templateName']) && !empty($rowData['templateName']))? trim(addslashes($rowData['templateName'])) : '' ;
		$templateTaskCount=(isset($rowData['templateTaskCount']) && !empty($rowData['templateTaskCount']))? $rowData['templateTaskCount'] : 0 ;
		$taskDetails=(isset($rowData['taskDetails']) && !empty(trim($rowData['taskDetails'])))? trim(addslashes($rowData['taskDetails'])) : '' ;
		$workOrderCount=(isset($rowData['workOrderCount']) && !empty($rowData['workOrderCount']))? $rowData['workOrderCount'] : 0 ;
		$rowDataArr[]=array(
			'tid'=>$templateId, 
			'taskName'=>$templateName,
			'numOfTask'=>$templateTaskCount,
			'numOfTimeUsed'=>$workOrderCount,
			'viewTask'=>'<input type="hidden" id="tempData_'.$templateId.'" value="'.$taskDetails.'"><input type="hidden" id="tempName_'.$templateId.'" value="'.$templateName.'"><button class="btn btn-primary btn-sm" type="button" ng-click="createTemplate('.$templateId.');" data-target="#createTemplateDialog" data-toggle="modal" >View Task</button>', 
			'useTemplate'=>'<button class="btn btn-success btn-sm" type="button" data-target="#confirmAssignTemplateDialog" data-toggle="modal" ng-click="assignTemplate('.$templateId.');">Use Template</button>'
		);
	}
	$json_data =array(
			"jsonData"		  => array(
				"draw"            => intval($post_data['sEcho']), // Just a Random Number for Draw
				"recordsTotal"    => intval($main_count), // Total records count without searching and limit
				"recordsFiltered" => intval($main_count), //records count after searching
				"aaData"          => $rowDataArr,
				"retSql"		  => $primarySql
				) //This array contains all the datatable rows which will be shown in the front end
			);
    echo json_encode($json_data); die();