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
//	$sql = "SELECT * FROM pj_jokes LEFT JOIN pj_user ON pj_jokes.user_id = pj_user.user_id WHERE pj_jokes.user_id = '$userId' ORDER BY pj_jokes.joke_id DESC LIMIT $offset, $limit";



$sql = "SELECT Q3.joke_id, Q3.content, Q3.create_time, Q3.user_id, pj_user.nick_name, pj_user.avatar, Q3.islike, Q3.iscollect, Q3.like_count, Q3.collect_count 
FROM (

SELECT Q2.joke_id, Q2.content, Q2.create_time, Q2.user_id, IFNULL(Q1.islike, 0) AS islike, IFNULL(Q1.iscollect, 0) AS iscollect, IFNULL(Q2.like_count, 0) AS like_count, IFNULL(Q2.collect_count, 0) AS collect_count
FROM
(SELECT joke_id, user_id, islike, iscollect FROM pj_collect_and_like WHERE user_id = $userId) AS Q1

RIGHT JOIN

(
SELECT pj_jokes.joke_id, pj_jokes.content, pj_jokes.create_time, pj_jokes.user_id, P2.like_count, P2.collect_count FROM pj_jokes
LEFT JOIN 
(	SELECT joke_id, COUNT(iscollect) AS collect_count, COUNT(islike) AS like_count  
	FROM pj_collect_and_like 
	GROUP BY joke_id
) AS P2
ON pj_jokes.joke_id = P2.joke_id WHERE pj_jokes.user_id = '$userId'
)

AS Q2

ON Q1.joke_id = Q2.joke_id
)
AS Q3

LEFT JOIN pj_user ON Q3.user_id = pj_user.user_id ORDER BY Q3.joke_id DESC LIMIT $offset, $limit";


	
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
	$islike = $row['islike'];
	$iscollect = $row['iscollect'];
	$likeCount = $row['like_count'];
	$collectCount = $row['collect_count'];

	$jokesArr = array('jokeId' => $jokeId,
						'jokeContent' => $jokeContent,
						'createTime' => $createTime,
						'userId' => $userId,
						'nickName' => $nickName,
						'avatar' => $avatar,
						'islike' => $islike,
						'iscollect' => $iscollect,
						'likeCount' => $likeCount,
						'collectCount' => $collectCount);
	$jokesList[$i++] = $jokesArr;
}
$totalCount = mysql_num_rows($result);

echo json_encode(array('status' => '1', 'totalCount' => $totalCount, 'jokesList' => $jokesList, 'function' => 'getpublishedjokes.php'));

mysql_close($con);
mysql_free_result($result);

?>
