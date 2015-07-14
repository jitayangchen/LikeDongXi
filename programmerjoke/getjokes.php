<?php
require_once('function.php');

$page = $_GET['page'];
$limit = $_GET['limit'];

if (!isset($page))
{
	$page = 1;
}
if (!isset($limit))
{
	$limit = 20;
}

$offset = ($page -1) * $limit;

function getJoke($con, $offset, $limit)
{
	$sql = "SELECT * FROM pj_jokes LEFT JOIN pj_user ON pj_jokes.user_id = pj_user.user_id ORDER BY pj_jokes.joke_id DESC LIMIT $offset, $limit";
//	$sql = "select * from pj_jokes order by create_time desc";
	
	return mysql_query($sql, $con);
	
}

$con = connectDB();

$result = getJoke($con, $offset, $limit);
$jokesList = array();

$i = 0;
while($row = mysql_fetch_array($result))
{
	$jokeId = iconv("GBK", "UTF-8", $row['joke_id']);
	$jokeContent = iconv("GBK", "UTF-8", $row['content']);
	$createTime = iconv("GBK", "UTF-8", $row['create_time']);
	$userId = iconv("GBK", "UTF-8", $row['user_id']);
	$nickName = iconv("GBK", "UTF-8", $row['nick_name']);
	$avatar = iconv("GBK", "UTF-8", $row['avatar']);

//	$userId = '';
//	$nickName = '';
//	$avatar = '';

	$jokesArr = array('jokeId' => $jokeId,
						'jokeContent' => $jokeContent,
						'createTime' => $createTime,
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