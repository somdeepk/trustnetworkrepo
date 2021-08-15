<?php
ob_start();
session_start();
ini_set('memory_limit', '1024M');
include("../../include/connection.php");
$sessionAdminId=(isset($_SESSION['admin_id']) && !empty($_SESSION['admin_id']))? $_SESSION['admin_id'] : 0 ;
$retId=0;
$workOrderId=(isset($_POST['workOrderId']) && !empty($_POST['workOrderId']))? $_POST['workOrderId'] : 0 ;
$moduleType=(isset($_POST['moduleType']) && !empty($_POST['moduleType']))? $_POST['moduleType'] : '' ;
$taskDetails=(isset($_POST['taskDetails']) && !empty($_POST['taskDetails']))? $_POST['taskDetails'] : array() ;
$delAllTask="DELETE FROM tblworkordertask WHERE module_id='".$workOrderId."' AND module_type='".$moduleType."'";
$iCount=0;
if (mysqli_query($delAllTask)) {
	if (!empty($taskDetails)) {
		foreach ($taskDetails as $taskKey=>$taskVal) {
			$torder=$taskKey+1 ;
			$tid=(isset($taskVal['tid']) && !empty($taskVal['tid']))? $taskVal['tid'] : 0 ;
			$templateId=(isset($taskVal['templateId']) && !empty($taskVal['templateId']))? $taskVal['templateId'] : 0 ;
			$descId=(isset($taskVal['descId']['descId']) && !empty($taskVal['descId']['descId']))? $taskVal['descId']['descId'] : 0 ;
			$descName=(isset($taskVal['descName']) && !empty($taskVal['descName']))? $taskVal['descName'] : '' ;
			$specification=(isset($taskVal['specification']) && !empty($taskVal['specification']))? $taskVal['specification'] : '' ;
			$assignToId=(isset($taskVal['assignToId']['adminid']) && !empty($taskVal['assignToId']['adminid']))? $taskVal['assignToId']['adminid'] : 0 ;
			$startTimeStr=(isset($taskVal['startTimeStr']) && !empty($taskVal['startTimeStr']))? "start_time='".$taskVal['startTimeStr']."', " : "start_time=NULL, " ;
			$finishTimeStr=(isset($taskVal['finishTimeStr']) && !empty($taskVal['finishTimeStr']))? "finish_time='".$taskVal['finishTimeStr']."', " : "finish_time=NULL, " ;
			if (!empty($descId) && !empty($specification)) {
				$upSql="INSERT INTO tblworkordertask SET module_id='".$workOrderId."', module_type='".$moduleType."', template_id='".$templateId."', task_order='".$torder."', short_desc_id='".$descId."', short_desc_name='".$descName."', specification='".$specification."', assign_to_id='".$assignToId."',".$startTimeStr.$finishTimeStr." created_on='". date('Y-m-d H:i:s') ."', created_by='".$sessionAdminId."', is_deleted='0'";
				// if (empty($tid)) {
					// $upSql="INSERT INTO tblworkordertask SET module_id='".$workOrderId."', module_type='".$moduleType."', template_id='".$templateId."', task_order='".$torder."', short_desc_id='".$descId."', short_desc_name='".$descName."', specification='".$specification."', assign_to_id='".$assignToId."',".$startTimeStr.$finishTimeStr." created_on='". date('Y-m-d H:i:s') ."', created_by='".$sessionAdminId."', is_deleted='0'";
				// } else {
					// $upSql="UPDATE tblworkordertask SET task_order='".$torder."', short_desc_id='".$descId."', short_desc_name='".$descName."', specification='".$specification."', assign_to_id='".$assignToId."',".$startTimeStr.$finishTimeStr." updated_on='". date('Y-m-d H:i:s') ."', updated_by='".$sessionAdminId."', is_deleted='0' WHERE id='".$tid."'";
				// }
				if (mysqli_query($upSql)) {
					$iCount++ ;
				}
			}
		}
	}
}
echo $iCount ; die();