<?php

require_once('../qiniu/rs.php');
require_once('../qiniu/conf.php');

$bucket = 'findfine';
$key

$client = new Qiniu_MacHttpClient(null);
$ret = Qiniu_RS_Fetch($client, 'http://rwxf.qiniucdn.com/1.jpg', $bucket, 'qiniu.jpg');

//var_dump($ret);
if ($ret === 200) {
	echo 'upload success';
} else {
	echo 'error !!!';
}

