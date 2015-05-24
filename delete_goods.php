<!DOCTYPE html>
<html>
<title>删除商品</title> 
        <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
<body>

<?php 

require_once('qiniu_php_sdk/qiniu/rs.php');


// 连接数据库
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

function queryGoodsImageKeyByGoodsId($con, $goods_id)
{
	$sql = "SELECT * FROM goods_images WHERE goods_id='$goods_id'";
	$result = mysql_query($sql, $con);

	$imgKeyArr = array();
	$i = 0;
	while($row = mysql_fetch_array($result))
	{
		$imgKey = mb_convert_encoding($row['image_url'], "UTF-8", "GBK");
		$imgKeyArr[$i++] = $imgKey;
		echo '查询到 七牛image_key：' . $imgKey;
		echo '<br/>';
	}

	return $imgKeyArr;
}

function deleteGoodsImageByGoodsId($con, $goods_id)
{
	$sql = "DELETE FROM goods_images WHERE goods_id='$goods_id'";
	$result = mysql_query($sql, $con);
	echo 'deleteGoodsImageByGoodsId___  ' . $result . '<br/>';
	return $result;
}

function deleteGoodsByGoodsId($con, $goods_id)
{
	$sql = "DELETE FROM goods WHERE id='$goods_id'";
	$result = mysql_query($sql, $con);
	echo 'deleteGoodsByGoodsId___  ' . $result . '<br/>';
	return $result;
}


if (isset($_POST['action']) && $_POST['action'] == 'execute_delete') {
	$goods_id = $_POST["goods_id"];

	if(!empty($goods_id))
	{
		$con = connectDB();
		$imgKeyArr = queryGoodsImageKeyByGoodsId($con, $goods_id);
		deleteGoodsImageByGoodsId($con, $goods_id);
		deleteGoodsByGoodsId($con, $goods_id);

		mysql_close($con);

		$bucket = 'findfine';
		$client = new Qiniu_MacHttpClient(null);
		foreach ($imgKeyArr as $image_key)
		{
			$ret = Qiniu_RS_Delete($client, $bucket, $image_key);
			if ($ret === 200) {
				echo $image_key . '   delete success <br/>';
			} else {
				echo 'error !!! <br/>';
				var_dump($ret);
			}
		}
	}
	else
	{
		echo '<br/>参数不能为空';
	}


	echo '<br/>';
	echo '<a href="'. $_SERVER['PHP_SELF'] .'">返回</a>';

} else { 

	?> 

	<form action="<?php echo $_SERVER['PHP_SELF']; ?>" method="POST"> 
		商品 ID :  <input type="text" name="goods_id"><br> 
		<input type="submit" name="action" value="execute_delete" > 
	  
	</form>

	<?php 
} 
?>  
</body>
</html>