<?php
require_once('function.php');

$content = $_POST['content'];
$user_id = $_POST['user_id'];
$images_url = $_POST['images_url'];

function addJoke($con, $content, $create_time, $user_id, $images_url)
{
	$sql = "insert into pj_jokes (content, create_time, user_id, images_url) values ('$content', '$create_time', '$user_id', '$images_url')";
	
	mysql_query($sql, $con);
}

if (isset($content) && isset($user_id)) {
	$con = connectDB();
	$create_time = date("Y-m-d H:i:s");
	addJoke($con, $content, $create_time, $user_id, $images_url);
	mysql_close($con);
}

?>