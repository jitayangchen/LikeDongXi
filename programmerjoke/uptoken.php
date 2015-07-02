<?php
require_once('qiniu_php_sdk/qiniu/rs.php');

$key = $_POST['key'];
$bucket = 'findfine';

$putPolicy = new Qiniu_RS_PutPolicy("$bucket:$key");
$upToken = $putPolicy->Token(null);

echo json_encode(array('status' => '1', 'upToken' => $upToken));

	
?>