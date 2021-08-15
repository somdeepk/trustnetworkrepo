<?php
ob_start();
session_start();
ini_set('memory_limit', '1024M');
include("../../include/connection.php");
$sessionAdminId=(isset($_SESSION['admin_id']) && !empty($_SESSION['admin_id']))? $_SESSION['admin_id'] : 0 ;
$retData=array();
$workOrderId=(isset($_POST['workOrderId']) && !empty($_POST['workOrderId']))? $_POST['workOrderId'] : 0 ;
$moduleType=(isset($_POST['moduleType']) && !empty($_POST['moduleType']))? $_POST['moduleType'] : '' ;
$templateId=(isset($_POST['templateData']['templateId']) && !empty($_POST['templateData']['templateId']))? $_POST['templateData']['templateId'] : 0 ;
$templateName=(isset($_POST['templateData']['templateName']) && !empty(trim($_POST['templateData']['templateName'])))? trim($_POST['templateData']['templateName']) : '' ;
$templateList=(isset($_POST['templateData']['templateList']) && !empty($_POST['templateData']['templateList']))? $_POST['templateData']['templateList'] : array() ;
if (!empty($templateName) && !empty($templateList)) {
	$checkData="SELECT COUNT(id) AS tempCount FROM tbltasktemplate WHERE LOWER(template_name)='". strtolower($templateName) ."' AND id<>'".$templateId."'";
	$sqlData=mysqli_fetch_array(mysqli_query($checkData));
	$tempCount=(isset($sqlData['tempCount']) && !empty($sqlData['tempCount']))? $sqlData['tempCount'] : 0;
	if ($tempCount>0) {
		$retData['status']='duplicate';
	} else {
		if (empty($templateId)) {
			$inQuery="INSERT INTO tbltasktemplate SET template_name='".$templateName."', created_on='". date('Y-m-d H:i:s') ."', created_by='".$sessionAdminId."', is_deleted='0'";
			if (mysqli_query($inQuery)) {
				$tempId=mysql_insert_id();
				if (!empty($tempId)) {
					$i=0;
					foreach ($templateList as $tempKey=>$tempList) {
						$descId=(isset($tempList['descId']) && !empty($tempList['descId']))? $tempList['descId'] : 0 ;
						if (!empty($descId)) {
							$newVal=$tempKey+1 ;
							$inDescQuery="INSERT INTO tbltasktemplatedetails SET template_id='".$tempId."', shortdesc_id='". $descId ."', task_order='".$newVal."', is_deleted='0'";
							if (mysqli_query($inDescQuery)) {
								$i++ ;
							}
						}
					}
					if ($i>0) {
						if (!empty($workOrderId) && !empty($moduleType)) {
							$upSql="UPDATE tblworkordertask SET template_id='".$tempId."' WHERE module_id='".$workOrderId."' AND module_type='".$moduleType."'";
							if (mysqli_query($upSql)) {
								$i++ ;
							}
						}
						$retData['status']='success';
						$retData['retTempId']=$tempId;
					}
				} else {
					$retData['status']='error';
				}
			} else {
				$retData['status']='error';
			}
		}
	}
} else {
	$retData['status']='error';
}
echo json_encode($retData); die();