<?php 
require_once('function.php');

$con = connectDB();

$sql = "select * from tr_goods order by id desc";
$result = mysql_query($sql, $con);

$goodsList = array();

$i = 0;

while($row = mysql_fetch_array($result))
{
	$goodsId = $row['id'];
	$price = $row['price'];
	$goodsUrl = $row['goods_url'];
	$createTime = $row['create_time'];
	$fromSource = $row['from_source'];
	$type = $row['type'];
	$subType = $row['sub_type'];
	$likeNumber = $row['like_number'];
	$commentNumber = $row['comment_number'];
	$goodsImageUrl = $row['goods_image_url'];
	$goodsName = mb_convert_encoding($row['goods_name'], "UTF-8", "GBK");
	//echo 'goodsId = ' . $goodsId . '<br/>';
	$goodsArr = array('goodsId' => $goodsId, 
		'price' => $price,
		'goodsUrl' => $goodsUrl,
		'createTime' => $createTime,
		'fromSource' => $fromSource,
		'type' => $type,
		'subType' => $subType,
		'likeNumber' => $likeNumber,
		'commentNumber' => $commentNumber,
		'goodsImageUrl' => $goodsImageUrl,
		'goodsName' => $goodsName);

	$goodsList[$i++] = $goodsArr;
}
$totalCount = mysql_num_rows($result);

mysql_close($con);
mysql_free_result($result);

echo json_encode(array('status' => '1', 'totalCount' => $totalCount, 'goodsList' => $goodsList));

?>