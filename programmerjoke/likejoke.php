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

function likeJoke($con, $jokeId, $userId, $islike, $likeTime)
{
	$sql;
	if(isExist($con, $jokeId, $userId))
	{
		$sql = "UPDATE pj_collect_and_like SET islike = '$islike', time = '$likeTime' WHERE joke_id = '$jokeId' AND user_id = '$userId'";
	}
	else
	{
		$sql = "INSERT INTO pj_collect_and_like (joke_id, user_id, islike, time) VALUES ('$jokeId', '$userId', '$islike', '$likeTime')";
	}
	
	mysql_query($sql, $con);
}

if (isset($jokeId) && isset($userId)) {
	$con = connectDB();
	$likeTime = date("Y-m-d H:i:s");

	likeJoke($con, $jokeId, $userId, 1, $likeTime);
	echo json_encode(array('status' => '1', 'function' => 'likejoke.php'));
	mysql_close($con);
}

?>