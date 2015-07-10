<?php
require_once('function.php');

$jokeId = $_GET['jokeId'];
$userId = $_GET['userId'];

function addJoke($con, $jokeId, $userId, $islike, $collectTime)
{
	$sql = "insert into pj_collect_and_like (joke_id, user_id, islike, time) values ('$jokeId', '$userId', '$islike', '$collectTime')";
	
	mysql_query($sql, $con);
}

if (isset($jokeId) && isset($userId)) {
	$con = connectDB();
	$collectTime = date("Y-m-d H:i:s");

	addJoke($con, $jokeId, $userId, 1, $collectTime);
	echo json_encode(array('status' => '1', 'function' => 'likejoke.php'));
	mysql_close($con);
}

?>