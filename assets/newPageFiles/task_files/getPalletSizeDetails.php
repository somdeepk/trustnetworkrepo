<?php
ini_set('memory_limit', '1024M');
include("../../include/connection.php");
$sizeSql="SELECT a.id, a.pallet_size FROM tblpalletsize AS a WHERE a.is_deleted='0' ORDER BY a.pallet_size DESC";
$sizeSqlQuery=mysqli_query($sizeSql);
$sizeArray=array();
while ($sizeData=mysqli_fetch_array($sizeSqlQuery)) {
	$pId=(isset($sizeData['id']) && !empty($sizeData['id']))? $sizeData['id'] : 0;
	$pSize=(isset($sizeData['pallet_size']) && !empty($sizeData['pallet_size']))? $sizeData['pallet_size'] : '';
	if (!empty($pId) && !empty($pSize)) {
		$parray=explode('X', $pSize);
		$height=$parray[0];
		$width=$parray[1];
		$length=$parray[2];
		$sizeArray[]=array('pId'=>$pId, 'pSize'=>$pSize, 'isEdit'=>0, 'isDelete'=>0, 'height'=>$height, 'width'=>$width, 'length'=>$length);
	}
}
$sizeArray[]=array('pId'=>0, 'pSize'=>'', 'isEdit'=>0, 'isDelete'=>0, 'height'=>0, 'width'=>0, 'length'=>0);
echo json_encode(array('sizeList'=>$sizeArray)); die();