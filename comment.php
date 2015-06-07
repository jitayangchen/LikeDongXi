<?php
require_once('function.php');

$commentContent = $_POST["comment_content"];
$goodsId = $_POST["goods_id"];
$commentUserId = $_POST["comment_user_id"];
$commentUserNickname = $_POST["comment_user_nickname"];
$commentUserAvatar = $_POST["comment_user_avatar"];

function addComment($commentId, $commentContent, $goodsId, $commentUserId, $commentUserNickname, $commentUserAvatar, $commentTime)
{
	$sql = "insert into comments (comment_id, comment_content, goods_id, comment_user_id, comment_user_nickname, comment_user_avatar, comment_time) values ('$commentId', '$commentContent', '$goodsId', '$commentUserId', '$commentUserNickname', '$commentUserAvatar', '$commentTime')";
	
	mysql_query($sql, $con);
}

$con = connectDB();
$commentId = time() . rand(1000,10000);
$commentTime = date("Y-m-d H:i:s");
addComment($commentId, $commentContent, $goodsId, $commentUserId, $commentUserNickname, $commentUserAvatar, $commentTime);
echo json_encode(array('status' => '1', 'info' => 'comment success'));
mysql_close($con);

?>