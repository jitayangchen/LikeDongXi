<!DOCTYPE html>
<html>
<title>程序员笑话</title> 
<meta http-equiv="Content-Type" content="text/html; charset=gbk" />
<meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=0" />
<body>
	<font size=4pt, color='#2a2a2a' style="line-height:150%;"> 
		<?php
		require_once('function.php');

		$jokeId = $_GET['joke_id'];

		function getJoke($con, $jokeId)
		{
			$sql = "SELECT * FROM pj_jokes WHERE joke_id = '$jokeId'";
			
			return mysql_query($sql, $con);
			
		}

		$con = connectDB();

		$result = getJoke($con, $jokeId);
		if($row = mysql_fetch_array($result))
		{
		//	$jokeContent = iconv("GBK", "UTF-8", $row['content']);
			$jokeContent = str_replace(chr(32), '&nbsp;', $row['content']);
			echo str_replace(chr(10), '<br>', $jokeContent);
		}
		mysql_close($con);
		mysql_free_result($result);

		?>
	</font>
</body>
</html>