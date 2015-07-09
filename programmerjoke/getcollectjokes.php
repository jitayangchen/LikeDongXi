<?php
require_once('function.php');

$userId = $_GET['userId'];
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

function getCollectJoke($con, $userId, $offset, $limit)
{
	$sql = "SELECT * FROM pj_jokes LEFT JOIN pj_collect_joke ON pj_jokes.joke_id = pj_collect_joke.joke_id WHERE pj_collect_joke.user_id = $userId ORDER BY pj_collect_joke.id DESC LIMIT $offset, $limit";
	
	return mysql_query($sql, $con);
	
}

$con = connectDB();

$result = getCollectJoke($con, $userId, $offset, $limit);
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

	$jokesArr = array('jokeId' => $jokeId,
						'jokeContent' => $jokeContent,
						'createTime' => $createTime,
						'userId' => $userId,
						'nickName' => $nickName,
						'avatar' => $avatar);
	$jokesList[$i++] = $jokesArr;
}
$totalCount = mysql_num_rows($result);

echo json_encode(array('status' => '1', 'totalCount' => $totalCount, 'jokesList' => $jokesList, 'function' => 'getcollectjokes.php'));

mysql_close($con);
mysql_free_result($result);

?>