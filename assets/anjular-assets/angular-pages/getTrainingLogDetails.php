<?php
ini_set('memory_limit', '1024M');
include("../include/connection.php");
$post_data=$_POST ;
$returnArray=array();
if (isset($post_data['logId']) && !empty($post_data['logId'])) {
	//print $post_data['logId']; die();
	$masterSql='SELECT a.*, CONCAT(b.First_Name," ", b.Last_Name) AS empName, DATE_FORMAT(a.logtime, "%m/%d/%Y %h:%i %p") AS formattedLogDate
		FROM `tblemptraininglog` AS a LEFT JOIN tbladmin AS b ON a.empId=b.adminid WHERE a.id="'.$post_data['logId'].'"'; 
	$result=mysqli_fetch_assoc(mysqli_query($con,$masterSql));
	$returnArray['causationEvent']=(isset($result['causation_event']) && !empty($result['causation_event']))? $result['causation_event'] : '' ;
	$returnArray['issue']=(isset($result['log_issue']) && !empty($result['log_issue']))? $result['log_issue'] : '' ;
	$returnArray['type']=(isset($result['log_type']) && !empty($result['log_type']))? $result['log_type'] : '' ;
	$returnArray['enteredBy']=(isset($result['entered_by']) && !empty($result['entered_by']))? $result['entered_by'] : '' ;
	$returnArray['ctc']=(isset($result['ctc']) && !empty($result['ctc']))? $result['ctc'] : '' ;
	$returnArray['desc']=(isset($result['log_desc']) && !empty($result['log_desc']))? $result['log_desc'] : '' ;
	$returnArray['displogTime']=(isset($result['formattedLogDate']) && !empty($result['formattedLogDate']))? $result['formattedLogDate'] : '' ;
	$returnArray['logTime']=(isset($result['logtime']) && !empty($result['logtime']))? $result['logtime'] : '' ;
	$returnArray['empName']=(isset($result['empId']) && !empty($result['empId']))? array('adminid'=>$result['empId'], 'userFullName'=>$result['empName']) : array('adminid'=>'', 'userFullName'=>'');
	if (isset($result['attachments']) && !empty($result['attachments'])) {
		$attachments=$result['attachments'] ;
		$attachmentArray=json_decode($attachments);
		$returnArray['attachment']=$attachmentArray ;
	}
}
//print_r($returnArray); die();
echo json_encode($returnArray); die() ;