<?php
require_once('function.php');

$phone_number = $_POST['phone_number'];
$password = $_POST['password'];
$nickName = $_POST['nickName'];

function register($con, $phone_number, $password, $nickName, $register_time)
{
	$sql = "insert into pj_user (phone_num, password, nick_name, register_time) values ('$phone_number', '$password', '$nickName', '$register_time')";
	
	mysql_query($sql, $con);
}

if (isset($phone_number) && isset($password)) {
	$con = connectDB();
	$register_time = date("Y-m-d H:i:s");

	$phone_number = iconv("UTF-8", "GBK", $phone_number);
	$password = iconv("UTF-8", "GBK", $password);
	$nickName = iconv("UTF-8", "GBK", $nickName);

	register($con, $phone_number, $password, $nickName, $register_time);
	$userId = mysql_insert_id($con);
	echo json_encode(array('status' => '1', 'userId' => $userId));
	mysql_close($con);
}

?>