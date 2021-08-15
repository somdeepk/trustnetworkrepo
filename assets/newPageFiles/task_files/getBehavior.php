<?php
ini_set('memory_limit', '1024M');
include("../../include/connection.php");

$specSql="SELECT id, specification_name, behavior_details FROM `tbltaskspecification` WHERE is_deleted='0' AND is_behave='1' ORDER BY specification_name"; 
$specQuery=mysqli_query($specSql);
$behaveArray=array();
while ($specVal=mysqli_fetch_assoc($specQuery)) {
	if (!empty($specVal['id'])) {
		$behaveArray[]=array('behaveId'=>$specVal['id'], 'behaveName'=>$specVal['specification_name'], 'behaveDetails'=>$specVal['behavior_details']);
	}
}
$return_data = array('behaveList'=>$behaveArray);
echo json_encode($return_data); die() ;