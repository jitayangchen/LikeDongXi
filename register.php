<?php
require_once('function.php');

// 用户注册 添加用户
function addUser($con, $phoneNumber, $passWord, $city, $registerTime, $loginTime, $token, $tokenCreateTime)
{
	$sql = "insert into user (phone_number, password, city, register_time, login_time, token, token_create_time) values ('$phoneNumber', '$passWord', '$city', '$registerTime', '$loginTime', '$token', '$tokenCreateTime')";
	
	mysql_query($sql, $con);
}

$phoneNumber = $_POST["phone_number"];
$passWord = $_POST["password"];

if (isset($phoneNumber) && isset($passWord)) 
{
	$con = connectDB();

	$city = mb_convert_encoding('北京', "GBK", "UTF-8");;
	$registerTime = date("Y-m-d H:i:s");
	$loginTime = $registerTime;
	$token = createUserToken($phoneNumber, $passWord);
	$tokenCreateTime = $registerTime;
	addUser($con, $phoneNumber, $passWord, $city, $registerTime, $loginTime, $token, $tokenCreateTime);
	$id = mysql_insert_id($con);
	$userId = $id + 1000000;

	echo json_encode(array('status' => '1', 'userId' => $userId, 'loginTime' => $loginTime, 'token' => $token));

	mysql_close($con);
}
	
?>