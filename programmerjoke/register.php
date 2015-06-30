<?php
require_once('function.php');

$phone_number = $_POST['phone_number'];
$password = $_POST['password'];

function register($con, $phone_number, $password, $register_time)
{
	$sql = "insert into pj_user (phone_num, password, register_time) values ('$phone_number', '$password', '$register_time')";
	
	mysql_query($sql, $con);
}

if (isset($phone_number) && isset($password)) {
	$con = connectDB();
	$register_time = date("Y-m-d H:i:s");
	register($con, $phone_number, $password, $register_time);
	echo json_encode(array('status' => '1'));
	mysql_close($con);
}

?>