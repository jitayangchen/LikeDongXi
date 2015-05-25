<?php 

function connectDB()
{
	$con = mysql_connect("qdm163657130.my3w.com", "qdm163657130", "yc6881090");
	if(!$con)
	{
		die('数据库连接失败：' . mysql_error());
	}
	mysql_select_db("qdm163657130_db", $con);

	return $con;
}


?>