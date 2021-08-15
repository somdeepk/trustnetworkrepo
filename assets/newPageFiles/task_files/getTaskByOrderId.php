<?php
ini_set('memory_limit', '1024M');
include("../../include/connection.php");
$workOrderId=(isset($_POST['workOrderId']) && !empty($_POST['workOrderId']))? $_POST['workOrderId'] : 0 ;
$moduleType=(isset($_POST['moduleType']) && !empty($_POST['moduleType']))? $_POST['moduleType'] : '' ;
$retArray=array();
if (!empty($workOrderId) && !empty($moduleType)) {
	$getSql="SELECT a.*, b.specification_name, b.is_behave, CONCAT(c.First_Name,' ',c.Last_Name) AS userFullName FROM tblworkordertask AS a LEFT JOIN tbltaskspecification AS b ON a.short_desc_id=b.id LEFT JOIN tbladmin AS c ON a.assign_to_id=c.adminid WHERE a.module_id='".$workOrderId."' AND a.module_type='".$moduleType."' AND a.is_deleted='0' ORDER BY a.task_order ASC";
	$getSqlQuery=mysqli_query($con,$getSql);
	if ($getSqlQuery) {
		while ($getRow=mysqli_fetch_array($getSqlQuery)) {
			if (isset($getRow['id']) && !empty($getRow['id'])) {
				$retArray[]=array(  'tid'=>$getRow['id'],
									'templateId'=>(isset($getRow['template_id']) && !empty($getRow['template_id']))? $getRow['template_id'] : 0,
									'tOrder'=>(isset($getRow['task_order']) && !empty($getRow['task_order']))? $getRow['task_order'] : 0,
									'descId'=>(isset($getRow['short_desc_id']) && !empty($getRow['short_desc_id']))? array('descId'=>$getRow['short_desc_id'], 'descName'=>$getRow['specification_name'], 'isBehave'=>$getRow['is_behave']) : '',
									'descName'=>(isset($getRow['short_desc_name']) && !empty($getRow['short_desc_name']))? $getRow['short_desc_name'] : '',
									'specification'=>(isset($getRow['specification']) && !empty($getRow['specification']))? $getRow['specification'] : '',
									'assignToId'=>(isset($getRow['assign_to_id']) && !empty($getRow['assign_to_id']))? array('adminid'=>$getRow['assign_to_id'], 'userFullName'=>$getRow['userFullName']) : '',
									'startTime'=>(isset($getRow['start_time']) && !empty($getRow['start_time']))? date('m/d/Y H:i A', strtotime($getRow['start_time'])) : '',
									'startTimeStr'=>(isset($getRow['start_time']) && !empty($getRow['start_time']))? $getRow['start_time'] : '',
									'finishTime'=>(isset($getRow['finish_time']) && !empty($getRow['finish_time']))? date('m/d/Y H:i A', strtotime($getRow['finish_time'])) : '',
									'finishTimeStr'=>(isset($getRow['finish_time']) && !empty($getRow['finish_time']))? $getRow['finish_time'] : '' );
			}
		}
	}
}
echo json_encode(array('taskDetails'=>$retArray)); die() ;