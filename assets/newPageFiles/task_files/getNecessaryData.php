<?php
ini_set('memory_limit', '1024M');
include("../../include/connection.php");

$userSqlStr="SELECT tbladmin.adminid, CONCAT(tbladmin.First_Name,' ',tbladmin.Last_Name) AS userFullName FROM tbladmin WHERE tbladmin.Delete_Flag='N' AND tbladmin.is_inspection='1' ORDER BY tbladmin.First_Name ASC"; 
$userSqlQuery=mysqli_query($con,$userSqlStr);
$tempArray=array();
$tempArray['adminid']='';
$tempArray['userFullName']='¿';
$userArray=array();
$userArray[]=$tempArray ;
while ($userArrayVal=mysqli_fetch_assoc($userSqlQuery)) {
	$userArray[]=$userArrayVal ;
}
$specArray=array();
$specArray[]=array('descId'=>'', 'descName'=>'¿', 'isBehave'=>0);
$specSql="SELECT id, specification_name, is_behave FROM `tbltaskspecification` WHERE is_deleted='0' ORDER BY specification_name"; 
$specQuery=mysqli_query($con,$specSql);
while ($specVal=mysqli_fetch_assoc($specQuery)) {
	if (!empty($specVal['id'])) {
		$specArray[]=array('descId'=>$specVal['id'], 'descName'=>$specVal['specification_name'], 'isBehave'=>$specVal['is_behave']);
	}
}
$return_data = array('userList'=>$userArray, 'descList'=>$specArray);
echo json_encode($return_data); die();