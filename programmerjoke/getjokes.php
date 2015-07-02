<?php
require_once('function.php');

function getJoke($con)
{
	$sql = "SELECT pj_jokes.content, pj_user.user_id, pj_user.nick_name, pj_user.avatar FROM pj_jokes LEFT JOIN pj_user ON pj_jokes.user_id = pj_user.user_id order by pj_jokes.create_time desc";
//	$sql = "select * from pj_jokes order by create_time desc";
	
	return mysql_query($sql, $con);
	
}

$con = connectDB();

$result = getJoke($con);
$jokesList = array();

$i = 0;
while($row = mysql_fetch_array($result))
{
	$jokeContent = iconv("GBK", "UTF-8", $row['content']);
	$userId = iconv("GBK", "UTF-8", $row['user_id']);
	$nickName = iconv("GBK", "UTF-8", $row['nick_name']);
	$avatar = iconv("GBK", "UTF-8", $row['avatar']);

	$jokesArr = array('jokeContent' => $jokeContent,
						'userId' => $userId,
						'nickName' => $nickName,
						'avatar' => $avatar);
	$jokesList[$i++] = $jokesArr;
}
$totalCount = mysql_num_rows($result);

echo json_encode(array('status' => '1', 'totalCount' => $totalCount, 'jokesList' => $jokesList));

mysql_close($con);
mysql_free_result($result);

?>