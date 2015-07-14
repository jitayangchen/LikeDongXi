<?php
require_once('function.php');

$content = $_POST['content'];
$user_id = $_POST['user_id'];
$images_url = $_POST['images_url'];

function addJoke($con, $content, $create_time, $user_id, $images_url)
{
	$sql = "INSERT INTO pj_jokes (content, create_time, user_id, images_url) VALUES ('$content', '$create_time', '$user_id', '$images_url')";
	
	mysql_query($sql, $con);
}

if (isset($content) && isset($user_id)) {
	$con = connectDB();
	$create_time = date("Y-m-d H:i:s");

	$content = iconv("UTF-8", "GBK", $content);
	$user_id = iconv("UTF-8", "GBK", $user_id);
	$images_url = iconv("UTF-8", "GBK", $images_url);

	addJoke($con, $content, $create_time, $user_id, $images_url);
	echo json_encode(array('status' => '1', 'function' => 'addjoke'));
	mysql_close($con);
}

?>