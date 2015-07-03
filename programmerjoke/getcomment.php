<?php
require_once('function.php');

function getcomment($con, $jokeId)
{
	$sql = "SELECT pj_comment.comment_id, pj_comment.content, pj_comment.user_id, pj_comment.create_time, pj_comment.like_num, pj_user.nick_name, pj_user.avatar FROM pj_comment LEFT JOIN pj_user ON pj_comment.user_id = pj_user.user_id WHERE pj_comment.joke_id = '$jokeId' order by pj_comment.create_time desc";
//	$sql = "select * from pj_jokes order by create_time desc";
	
	return mysql_query($sql, $con);
	
}
$jokeId = $_GET['jokeId'];
$con = connectDB();

$result = getcomment($con, $jokeId);
$commentList = array();

$i = 0;
while($row = mysql_fetch_array($result))
{
	$commentId = iconv("GBK", "UTF-8", $row['comment_id']);
	$content = iconv("GBK", "UTF-8", $row['content']);
	$createTime = iconv("GBK", "UTF-8", $row['create_time']);
	$likeNum = iconv("GBK", "UTF-8", $row['like_num']);
	$userId = iconv("GBK", "UTF-8", $row['user_id']);
	$nickName = iconv("GBK", "UTF-8", $row['nick_name']);
	$avatar = iconv("GBK", "UTF-8", $row['avatar']);

	$commentArr = array('commentId' => $commentId,
						'content' => $content,
						'createTime' => $createTime,
						'likeNum' => $likeNum,
						'userId' => $userId,
						'nickName' => $nickName,
						'avatar' => $avatar);
	$commentList[$i++] = $commentArr;
}
$totalCount = mysql_num_rows($result);

echo json_encode(array('status' => '1', 'totalCount' => $totalCount, 'function' => 'getcomment.php', 'commentList' => $commentList));

mysql_close($con);
mysql_free_result($result);

?>