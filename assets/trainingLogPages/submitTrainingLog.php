<?php
if (!isset($_SESSION)) {
	session_start();
}
ob_start();
ini_set('memory_limit', '1024M');
include("../include/connection.php");
if (isset($_POST)) {
	$logData = json_decode($_POST["empTraining"], true);
	$logId=(isset($logData['logId']) && !empty($logData['logId']))? $logData['logId']:'';
	$causationEvent=(isset($logData['causationEvent']) && !empty($logData['causationEvent']))? addslashes(trim($logData['causationEvent'])):'';
	$issue=(isset($logData['issue']) && !empty($logData['issue']))? addslashes(trim($logData['issue'])):'';
	$type=(isset($logData['type']) && !empty($logData['type']))? addslashes(trim($logData['type'])):'';
	$enteredBy=(isset($logData['enteredBy']) && !empty($logData['enteredBy']))? addslashes(trim($logData['enteredBy'])):'';
	$ctc=(isset($logData['ctc']) && !empty($logData['ctc']))? addslashes(trim($logData['ctc'])):'';
	$desc=(isset($logData['desc']) && !empty($logData['desc']))? addslashes(trim($logData['desc'])):'';
	$empId=(isset($logData['empId']) && !empty($logData['empId']))? $logData['empId']:'';
	$fileLog=(isset($logData['fileLog']) && !empty($logData['fileLog']))? $logData['fileLog']: array();
	$admin_id=$_SESSION['admin_id'];
	$logTime=(isset($logData['logTime']) && !empty($logData['logTime']))? $logData['logTime']:'';
	$editlogTime=(isset($logData['editlogTime']) && !empty($logData['editlogTime']))? $logData['editlogTime']:'';
	if (strpos($logTime, '/')!==false) {
		$logTime=$editlogTime ;
	}
	if (!empty($logTime) && !empty($empId) && !empty($causationEvent) && !empty($issue)) {
		if ($logId>0) {
			$updateSql="UPDATE tblemptraininglog 
					SET logtime='".$logTime."',
					empId='".$empId."',
					causation_event='".$causationEvent."',
					log_issue='".$issue."',
					log_type='".$type."',
					entered_by='".$enteredBy."',
					ctc='".$ctc."',
					log_desc='".$desc."',
					updated_on='". date('Y-m-d H:i:s') ."',
					updated_by='". $admin_id ."',
					is_deleted='0' WHERE id='".$logId."'";
			mysqli_query($con,$updateSql) or die(mysqli_error());
			$fileArray=array(); 
			if (!empty($fileLog)) {
				$i=0;
				foreach ($fileLog as $filekey=>$fileVal) {
					if (isset($fileVal['fileActualName']) && !empty($fileVal['fileActualName']) && isset($fileVal['fileDisplayName']) && !empty($fileVal['fileDisplayName'])) {
						$fileArray[]=array('displayName'=>$fileVal['fileDisplayName'], 'actualName'=>$fileVal['fileActualName']);
						$i++ ;
					} else if(isset($fileVal['fileActualName']) && empty($fileVal['fileActualName']) && isset($fileVal['fileDisplayName']) && !empty($fileVal['fileDisplayName'])) {
						if (isset($_FILES['trainingFiles']['tmp_name'][$filekey]) && !empty($_FILES['trainingFiles']['tmp_name'][$filekey])) {
							$fileName=$_FILES['trainingFiles']['name'][$filekey];
							$fileType=$_FILES['trainingFiles']['type'][$filekey];
							$fileTempName=$_FILES['trainingFiles']['tmp_name'][$filekey];
							$fileError=$_FILES['trainingFiles']['error'][$filekey];
							if (empty($fileError) && !empty($fileTempName)) {
								$temp = explode(".", $fileName);
								$newfilename = $logId."_".$i."_". substr(md5(time()), 0, 10) .'.'. end($temp);
								if (move_uploaded_file($fileTempName, '../uploads/trainingLogs/' . $newfilename)) {
									$fileArray[]=array('displayName'=>$fileName, 'actualName'=>$newfilename);	
									$i++ ;
								}		
							}
						}
					}
				}
			}
			$jsonString='';
			if (!empty($fileArray)) {
				$jsonString=json_encode($fileArray);
			}
			$updateFileSql="UPDATE tblemptraininglog SET attachments='".$jsonString."' WHERE id='".$logId."'";
			mysqli_query($con,$updateFileSql) or die(mysqli_error());
		} else {
			$insertSql="INSERT INTO tblemptraininglog 
					SET logtime='".$logTime."',
					empId='".$empId."',
					causation_event='".$causationEvent."',
					log_issue='".$issue."',
					log_type='".$type."',
					entered_by='".$enteredBy."',
					ctc='".$ctc."',
					log_desc='".$desc."',
					created_on='". date('Y-m-d H:i:s') ."',
					created_by='". $admin_id ."',
					is_deleted='0'";
			if ($con->query($insertSql)) {
				$logId = $con -> insert_id;
			} else {
				echo "Failed to connect to MySQL: " . $con -> connect_error;
				exit();
			}
			$fileArray=array();
			if (isset($_FILES['trainingFiles']['tmp_name']) && !empty($_FILES['trainingFiles']['tmp_name'])) {
				$i=0;
				foreach ($_FILES['trainingFiles']['tmp_name'] as $trainKey=>$trainVal) {
					$fileName=$_FILES['trainingFiles']['name'][$trainKey];
					$fileType=$_FILES['trainingFiles']['type'][$trainKey];
					$fileTempName=$trainVal;
					$fileError=$_FILES['trainingFiles']['error'][$trainKey];
					if (empty($fileError) && !empty($fileTempName)) {
						$temp = explode(".", $fileName);
						$newfilename = $logId."_".$i."_". substr(md5(time()), 0, 10) .'.'. end($temp);
						if (move_uploaded_file($fileTempName, '../uploads/trainingLogs/' . $newfilename)) {
							$fileArray[]=array('displayName'=>$fileName, 'actualName'=>$newfilename);	
							$i++ ;
						}			
					}
				}
			}
			if (!empty($fileArray)) {
				$jsonString=json_encode($fileArray);
				$updateSql="UPDATE tblemptraininglog SET attachments='".$jsonString."' WHERE id='".$logId."'";
				mysqli_query($con,$updateSql) or die(mysqli_error());
			}
		}
	}
	print $logId ;
}
die();
ob_end_flush();
?>