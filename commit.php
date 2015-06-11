<!DOCTYPE html>
<html>
<title>添加商品</title> 
        <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
<body>

<?php 

include('simple_html_dom_master_sdk/simple_html_dom.php');
require_once('qiniu_php_sdk/qiniu/rs.php');
require_once('qiniu_php_sdk/qiniu/conf.php');
require_once('function.php');

//echo $showtime=date("Y-m-d H:i:s");

// 获取商品图片
function getImgs($html)
{
	$e = $html->find('ul[id=J_UlThumb]', 0);
	$imgArr = array();
	$i = 0;
	foreach($e->children as $m)
	{
		$img_html = $m->children[0];
		$img = $img_html->find('img', 0);
		$imgTemp = str_replace('60x60q90', '430x430q90', $img->src);
		$imgArr[$i++] = str_replace('//', '', $imgTemp);
	}
	return $imgArr;
}

// 获取商品名称
function getGoodsName($html)
{
	$e = $html->find('meta[name=keywords]', 0);
	return $e->content;
}

// 添加商品
function addGoods($con, $price, $goods_url, $create_time, $goods_name, $from_source, $type, $sub_type, $goods_id)
{
	$sql = "insert into tr_goods (price, goods_url, create_time, goods_name, from_source, type, sub_type, goods_id) values ('$price', '$goods_url', '$create_time', '$goods_name', '$from_source', '$type', '$sub_type', '$goods_id')";
	
	mysql_query($sql, $con);
}

function updateGoodsImgUrl($con, $goods_image_url, $id)
{
	$sql = "update tr_goods set goods_image_url='$goods_image_url' where id='$id'";
	mysql_query($sql, $con);
}

// 添加商品图片
function addGoodsImg($con, $goods_id, $image_url, $save_source, $create_time)
{
	$sql = "insert into tr_goods_images (goods_id, image_url, save_source, create_time) values ('$goods_id', '$image_url', '$save_source', '$create_time')";
	
	mysql_query($sql, $con);
}

if (isset($_POST['action']) && $_POST['action'] == 'Upload') {
	$goods_url = $_POST["goods_url"];
	$goods_price = $_POST["goods_price"];

	if(!empty($goods_url) && !empty($goods_price))
	{
		$html = file_get_html($goods_url);

		$imgArr = getImgs($html);
		$goods_name = getGoodsName($html);
		//$goods_name = mb_convert_encoding(getGoodsName($html), "UTF-8", "GBK"); 
		echo $imgArr[0] . '<br/>';
		//echo $goods_name . '<br/>';
		echo mb_convert_encoding($goods_name, "UTF-8", "GBK") . '<br/>';
		echo $goods_price . '<br/>';

		$con = connectDB();

		$goods_id = time() . rand(1000,10000);
		$createTime = date("Y-m-d H:i:s");
		$from_source = 2; // 1为淘宝  2为天猫
		$type = $sub_type = 0;
		addGoods($con, $goods_price, $goods_url, $createTime, $goods_name, $from_source, $type, $sub_type, $goods_id);
		$id = mysql_insert_id($con);

		// 创建七牛client
		$client = new Qiniu_MacHttpClient(null);
		$bucket = 'findfine';
	
		$j = 0;

		$result;
		foreach ($imgArr as $value) 
		{
			$key = $goods_id . '_' . $j++ . '.jpg';

			echo $value . '<br/>';
			$result = $ret = Qiniu_RS_Fetch($client, $value, $bucket, $key);
			if ($ret === 200) 
			{
				echo $key . ' ------ upload success <br/>';
				$createTime = date("Y-m-d H:i:s");
				$save_source = 1; // 1：为七牛的服务器
				addGoodsImg($con, $id, $key, $save_source, $createTime);
			} 
			else 
			{
				echo 'error !!! <br/>';
				var_dump($ret);
			}
		}

		$fristKey = $goods_id . '_0.jpg';
		updateGoodsImgUrl($con, $fristKey, $id);

		mysql_close($con);
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
		商品URL :  <input type="text" name="goods_url"><br> 
		商品价格:  <input type="text" name="goods_price"><br>
		<input type="submit" name="action" value="Upload" > 
	  
	</form>

	<?php 
} 
?>  
</body>
</html>