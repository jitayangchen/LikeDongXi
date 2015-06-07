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

// 生成Token
function createUserToken($phoneNumber, $password)
{
	$str = $phoneNumber . '_' . $password . '_' . time() . '_' . rand(1000,10000);
	$token = md5(base64_decode($str));
	return $token;
}

function isValidToken($con, $token)
{
	$isValid = false;
	$tokenCreateTime;
	$sql = "select * from user where token = '$token'";
	$res = mysql_query($sql, $con);

	if($row = mysql_fetch_array($res))
	{
		$tokenCreateTime = $row['token_create_time'];
		if((time() - strtotime($tokenCreateTime)) > 360)
		{
			$isValid = false;
		}
		else
		{
			$isValid = true;
		}
	}
	else
	{
		$isValid = false;
	}

	mysql_free_result($res);
	return $isValid;
}


?>