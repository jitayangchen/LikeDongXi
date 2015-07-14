<?php
require_once('function.php');

$content = $_POST['content'];
$jokeId = $_POST['jokeId'];
$userId = $_POST['userId'];

function addComment($con, $content, $jokeId, $userId, $createTime)
{
	$sql = "INSERT INTO pj_comment (content, joke_id, user_id, create_time) VALUES ('$content', '$jokeId', '$userId', '$createTime')";
	
	mysql_query($sql, $con);
}


	$con = connectDB();
	$createTime = date("Y-m-d H:i:s");
	$content = iconv("UTF-8", "GBK", $content);
	$jokeId = iconv("UTF-8", "GBK", $jokeId);
	$userId = iconv("UTF-8", "GBK", $userId);
	addComment($con, $content, $jokeId, $userId, $createTime);
	echo json_encode(array('status' => '1', 'function' => 'comment'));
	mysql_close($con);


?>