<?php
require_once('function.php');

function getJoke($con)
{
	$sql = "select * from pj_jokes order by create_time desc";
	
	return mysql_query($sql, $con);
	
}

$con = connectDB();

$result = getJoke($con);
$jokesList = array();

$i = 0;
while($row = mysql_fetch_array($result))
{
	$jokeContent = iconv("GBK", "UTF-8", $row['content']);

	$jokesArr = array('jokeContent' => $jokeContent);
	$jokesList[$i++] = $jokesArr;
}
$totalCount = mysql_num_rows($result);

echo json_encode(array('status' => '1', 'totalCount' => $totalCount, 'jokesList' => $jokesList));

mysql_close($con);
mysql_free_result($result);

?>