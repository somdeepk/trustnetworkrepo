<?php
ini_set('memory_limit', '1024M');
include("../../include/connection.php");
$retId=0; 
$newDesc=(isset($_POST['newDesc']) && !empty(trim(addslashes($_POST['newDesc']))))? trim(addslashes($_POST['newDesc'])) : '';

if (!empty($newDesc)) {
	$sql = "SELECT id FROM tbltaskspecification WHERE LOWER(specification_name)='".strtolower($newDesc)."' AND is_deleted='0'";	
	echo"<pre>"; print_r($sql); die();
	$checkSQl=mysqli_fetch_array(mysqli_query($con,$sql));
	
	$specIdVal=(isset($checkSQl['id']) && !empty($checkSQl['id']))? $checkSQl['id'] : 0 ;
	if (empty($specIdVal)) {
		$inSql="INSERT INTO tbltaskspecification SET specification_name='". $newDesc ."', is_behave='0', created_on='". date('Y-m-d H:i:s') ."', is_deleted='0'";
		if ($con->query($inSql)) {
			$retId = $con -> insert_id;
		} else {
			echo "Failed to connect to MySQL: " . $con -> connect_error;
			exit();
		}
	} else {
		$retId=$specIdVal ;
	}
}
echo $retId ; die();