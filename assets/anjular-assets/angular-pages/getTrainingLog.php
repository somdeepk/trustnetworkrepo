<?php
ini_set('memory_limit', '1024M');
include("../include/connection.php");
$post_data=$_POST ;
$postData = array();
if(isset($post_data['iColumns'])) {
    $searchArrStr=$post_data['searchArrStr'];
    $searchArr=explode('!~!',$searchArrStr);
    $new_array=array();
    for ($i=0; $i<$post_data['iColumns']; $i++) {
        $new_array[$i]['data']=$i ;
        $new_array[$i]['name']=$post_data['mDataProp_'.$i] ;
        $new_array[$i]['searchable']=$post_data['bSearchable_'.$i] ;
        $new_array[$i]['orderable']=$post_data['bSortable_'.$i] ;
		$new_array[$i]['search']['value']=(isset($searchArr[$i]))? $searchArr[$i] : '' ;
        $new_array[$i]['search']['regex']=$post_data['bRegex_'.$i] ;
    }
    $postData['columns']=$new_array ;
    $postData['order'][0]['column']=$post_data['iSortCol_0'] ;
    $postData['order'][0]['dir']=$post_data['sSortDir_0'] ;
    $postData['start']=$post_data['iDisplayStart'] ;
    $postData['length']=$post_data['iDisplayLength'] ;
}
$search_str='';
$having_str='';
$limit_str='';
$sort_str=' ORDER BY a.id DESC';
if (!empty($postData)) {
	$limit_str='';
	if(isset($postData['start']) && !empty($postData['length'])) {
		$limit_str=' LIMIT '.$postData['start'].' , '.$postData['length'];
	}
	if (!empty($postData['columns'])) {
		$columns=$postData['columns'] ;
		foreach ($columns as $colkey=>$colval) {
			$colm_name=$colval['name'];
			$search_value=$colval['search']['value'];
			// Preparing the Searching SQL Part
			if ($colval['searchable']== true && $search_value!='') {
				if ($colm_name=='logTime') {
					$search_str.='AND DATE_FORMAT(a.logtime, "%m/%d/%Y %h:%i %p") LIKE "%'.$search_value.'%" ';
				} else if ($colm_name=='empName') {
					$search_str.='AND CONCAT(b.First_Name," ", b.Last_Name) LIKE "%'.$search_value.'%" ';
				} else if ($colm_name=='causationEvent') {
					$search_str.='AND a.causation_event LIKE "%'.$search_value.'%" ';
				} else if ($colm_name=='logissue') {
					$search_str.='AND a.log_issue LIKE "%'.$search_value.'%" ';
				} else if ($colm_name=='logtype') {
					$search_str.='AND a.log_type LIKE "%'.$search_value.'%" ';
				} else if ($colm_name=='enteredBy') {
					$search_str.='AND a.entered_by LIKE "%'.$search_value.'%" ';
				} else if ($colm_name=='ctc') {
					$search_str.='AND a.ctc LIKE "%'.$search_value.'%" ';
				} else if ($colm_name=='desc') {
					$search_str.='AND a.log_desc LIKE "%'.$search_value.'%" ';
				}
			}
			if ($colval['orderable']== true && $postData['order'][0]['column']!='') {
				if ($postData['order'][0]['column']==0) {
					$sort_str=' ORDER BY a.id '. $postData['order'][0]['dir'];
				} else if ($postData['order'][0]['column']==1) {
					$sort_str=' ORDER BY a.logtime '. $postData['order'][0]['dir'];
				} else if ($postData['order'][0]['column']==2) {
					$sort_str=' ORDER BY empName '. $postData['order'][0]['dir'];
				} else if ($postData['order'][0]['column']==3) {
					$sort_str=' ORDER BY a.log_issue '. $postData['order'][0]['dir'];
				} else if ($postData['order'][0]['column']==4) {
					$sort_str=' ORDER BY a.causation_event '. $postData['order'][0]['dir'];
				} else if ($postData['order'][0]['column']==5) {
					$sort_str=' ORDER BY a.log_type '. $postData['order'][0]['dir'];
				} else if ($postData['order'][0]['column']==6) {
					$sort_str=' ORDER BY a.entered_by '. $postData['order'][0]['dir'];
				} else if ($postData['order'][0]['column']==7) {
					$sort_str=' ORDER BY a.ctc '. $postData['order'][0]['dir'];
				} else if ($postData['order'][0]['column']==8) {
					$sort_str=' ORDER BY a.log_desc '. $postData['order'][0]['dir'];
				}
			}
		}
	}
}
$returnArray=array();
$masterSql='SELECT a.*, CONCAT(b.First_Name," ", b.Last_Name) AS empName, DATE_FORMAT(a.logtime, "%m/%d/%Y %h:%i %p") AS formattedLogDate
		FROM `tblemptraininglog` AS a 
		LEFT JOIN tbladmin AS b ON a.empId=b.adminid
		WHERE a.is_deleted="0" '.$search_str.' GROUP BY a.id'; 
			
$numRecords=mysqli_num_rows(mysqli_query($con,$masterSql));
$dataSql=$masterSql.$sort_str.$limit_str;
$dataQuery=mysqli_query($con,$dataSql);
while($rowData=mysqli_fetch_array($dataQuery)) {
	$nlcomments=$rowData['log_desc'];
	$sub_comm=(strlen($rowData['log_desc'])<=50)? $comments : substr($rowData['log_desc'],0,50).'&nbsp; <a href="#" data-toggle="tooltip" data-placement="left" title="'.$nlcomments.'">More...</a>';
	$returnArray[]=array(
	'ID'=>(isset($rowData['id']) && !empty($rowData['id'])) ? $rowData['id'] : '',
	'logTime'=>(isset($rowData['formattedLogDate']) && !empty($rowData['formattedLogDate'])) ? $rowData['formattedLogDate'] : '',
	'empName'=>(isset($rowData['empName']) && !empty($rowData['empName'])) ? $rowData['empName'] : '',
	'causationEvent'=>(isset($rowData['causation_event']) && !empty($rowData['causation_event'])) ? $rowData['causation_event'] : '',
	'logissue'=>(isset($rowData['log_issue']) && !empty($rowData['log_issue'])) ? $rowData['log_issue'] : '',
	'logtype'=>(isset($rowData['log_type']) && !empty($rowData['log_type'])) ? $rowData['log_type'] : '',
	'enteredBy'=>(isset($rowData['entered_by']) && !empty($rowData['entered_by'])) ? $rowData['entered_by'] : '',
	'ctc'=>(isset($rowData['ctc']) && !empty($rowData['ctc'])) ? $rowData['ctc'] : '',
	'desc'=>(isset($sub_comm) && !empty($sub_comm)) ? $sub_comm : '',
	'action'=>"<a href='javascript:void(0);' data-toggle='modal' data-target='#trainingLogDialog' ng-click='manageTrainingLog(".$rowData['id'].");'>[ Edit ]</a>"
	);
}
$totcount=(!empty($numRecords)) ? $numRecords : 0;

$json_data = array('jsonData'=> array(
        "draw"            => intval($post_data['sEcho']),  // Just a Random Number for Draw
        "recordsTotal"    => intval($totcount), // Total records count without searching and limit
        "recordsFiltered" => intval($totcount), //records count after searching(if not search then equals totalcount)
        "aaData"          => $returnArray //This array contains all the datatable rows which will be shown in the front end
        ));
echo json_encode($json_data); die();