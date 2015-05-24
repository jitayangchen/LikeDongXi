<!DOCTYPE html>
<html>
<title>获取数据</title> 
        <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
<body>

<?php 

function connectDB()
{
	$con = mysql_connect("qdm163657130.my3w.com", "qdm163657130", "yc6881090");
	if(!$con)
	{
		die('数据库连接失败：' . mysql_error());
	}
	mysql_select_db("qdm163657130_db", $con);

	$res = mysql_query("select * from goods");
	while($row = mysql_fetch_array($res))
	{
		//echo $row['post_content'];
		echo mb_convert_encoding($row['goods_name'], "UTF-8", "GBK");
		echo '<br/>';
	}
	
	mysql_close($con);
}

connectDB();

?>  
</body>
</html>