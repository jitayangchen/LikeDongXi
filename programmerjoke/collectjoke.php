<?php
require_once('function.php');

$jokeId = $_GET['jokeId'];
$userId = $_GET['userId'];

function isExist($con, $jokeId, $userId)
{
	$sql = "SELECT * FROM pj_collect_and_like WHERE joke_id = '$jokeId' AND user_id = '$userId'";

	$res = mysql_query($sql, $con);

	if($row = mysql_fetch_array($res))
	{
		return true;
	}
	else
	{
		return false;
	}
}

function collectJoke($con, $jokeId, $userId, $iscollect, $collectTime)
{
	$sql;
	if(isExist($con, $jokeId, $userId))
	{
		$sql = "UPDATE pj_collect_and_like SET iscollect = '$iscollect', time = '$collectTime' WHERE joke_id = '$jokeId' AND user_id = '$userId'";
	}
	else
	{
		$sql = "INSERT INTO pj_collect_and_like (joke_id, user_id, iscollect, time) VALUES ('$jokeId', '$userId', '$iscollect', '$collectTime')";
	}
	
	mysql_query($sql, $con);
}

if (isset($jokeId) && isset($userId)) {
	$con = connectDB();
	$collectTime = date("Y-m-d H:i:s");

	collectJoke($con, $jokeId, $userId, 1, $collectTime);
	echo json_encode(array('status' => '1', 'function' => 'collectjoke.php'));
	mysql_close($con);
}

?>