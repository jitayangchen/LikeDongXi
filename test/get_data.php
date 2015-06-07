<!DOCTYPE html>
<html>
<title>获取数据</title> 
        <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
<body>

<?php 
require_once('../function.php');

$token = $_GET["token"];

if(isset($token))
{
	$con = connectDB();
	if(isValidToken($con, $token))
	{
		$res = mysql_query("select * from goods order by create_time desc");
		while($row = mysql_fetch_array($res))
		{
			//echo $row['post_content'];
			echo $row['id'] . ' ------ ' . mb_convert_encoding($row['goods_name'], "UTF-8", "GBK");
			echo '<br/><br/>';
		}

		mysql_free_result($res);
	}
	else
	{
		echo 'token not Valid';
	}

	mysql_close($con);
}
else
{
	echo 'token null';
}

?>  
</body>
</html>