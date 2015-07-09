<?php
require_once('function.php');

$jokeId = $_GET['jokeId'];
$userId = $_GET['userId'];

function addJoke($con, $jokeId, $userId, $collectTime)
{
	$sql = "insert into pj_collect_joke (joke_id, user_id, collect_time) values ('$jokeId', '$userId', '$collectTime')";
	
	mysql_query($sql, $con);
}

if (isset($jokeId) && isset($userId)) {
	$con = connectDB();
	$collectTime = date("Y-m-d H:i:s");

	addJoke($con, $jokeId, $userId, $collectTime);
	echo json_encode(array('status' => '1', 'function' => 'collectjoke.php'));
	mysql_close($con);
}

?>