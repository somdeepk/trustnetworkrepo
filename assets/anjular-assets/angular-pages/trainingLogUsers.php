<?php
ini_set('memory_limit', '1024M');
include("../include/connection.php");

$userSqlStr="SELECT tbladmin.adminid, CONCAT(tbladmin.First_Name,' ',tbladmin.Last_Name) AS userFullName FROM tbladmin WHERE tbladmin.Delete_Flag='N' AND tbladmin.is_feedback='1' ORDER BY tbladmin.First_Name ASC"; 
$userSqlQuery=mysqli_query($con,$userSqlStr);
$tempArray=array();
$tempArray['adminid']='';
$tempArray['userFullName']='¿';
$userArray=array();
$userArray[]=$tempArray ;
while ($userArrayVal=mysqli_fetch_assoc($userSqlQuery)) {
	$userArray[]=$userArrayVal ;
}

$issueArray=array('Unmarked Defect', 'Not Following SOP');
$issueSqlStr="SELECT log_issue FROM `tblemptraininglog` GROUP BY log_issue ORDER BY log_issue"; 
$issueQuery=mysqli_query($con,$issueSqlStr);
while ($issueArrayVal=mysqli_fetch_assoc($issueQuery)) {
	if (!empty($issueArrayVal['log_issue']) && !in_array($issueArrayVal['log_issue'], $issueArray)) {
		$issueArray[]=$issueArrayVal['log_issue'] ;
	}
}
sort($issueArray);
array_unshift($issueArray,"¿");
$causationArray=array('¿','Customer Complaint', 'Employee Complaint', 'Internal Audit');
$typeArray=array('¿','Retraining', 'Training', 'Warning', 'Writeup');


$return_data = array('userList'=>$userArray, 'issueList'=>$issueArray, 'causationList'=>$causationArray, 'typeList'=>$typeArray);
echo json_encode($return_data); die() ;