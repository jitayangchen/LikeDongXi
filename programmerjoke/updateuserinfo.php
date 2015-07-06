<?php
require_once('function.php');

function updateAvatar($con, $avatar, $userId)
{
	$sql = "update pj_user set avatar='$avatar' where user_id='$userId'";
	mysql_query($sql, $con);
}

$userId = $_GET["userId"];
$avatar = $_GET["avatar"];

if (isset($userId) && !empty($userId))
{
	$con = connectDB();

	updateAvatar($con, $avatar, $userId);
	echo json_encode(array('status' => '1', 'function' => 'updateuserinfo'));
	mysql_close($con);
}
	
?>