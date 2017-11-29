<?php
require dirname(__FILE__) . '/../../ENMOL/tools/GetHeaders.php';
$header = GetTheHeaders();
$post_data = $_POST;
$ret = array();
$ret['post'] = $post_data;
$ret['header'] = $header;

header('content-type:application/json;charset=utf8');
echo json_encode($ret, JSON_UNESCAPED_UNICODE|JSON_PRETTY_PRINT);
