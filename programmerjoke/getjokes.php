<?php
require_once('../function.php');

$content = $_POST['content'];

function addJoke($con, $content, $comment_num, $like_num, $collection_num, $create_time, $user_id, $images_url)
{
	$sql = "insert into pj_jokes (content, comment_num, like_num, collection_num, create_time, user_id, images_url) values ('$content', '$comment_num', '$like_num', '$collection_num', '$create_time', '$user_id', '$images_url')";
	
	mysql_query($sql, $con);
}
?>