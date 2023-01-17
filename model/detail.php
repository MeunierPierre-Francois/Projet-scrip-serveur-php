<?php

include_once("lib/detail.php");


$result = getDetail();
$get_id     = isset($_GET["id"])    ? filter_input(INPUT_GET, 'id', FILTER_SANITIZE_SPECIAL_CHARS)      : null;

$url_page = "detail";

$result_detail = getDetail($get_id);



$id = $result_detail[0]["id"];
$title = $result_detail[0]["ad_title"];
$description_breve = $result_detail[0]["ad_description"];
$description_longue = $result_detail[0]["ad_description_detail"];
$level1 = $result_detail[0]["level_1"];
$level2 = $result_detail[0]["level_2"];


$page_view = "detail";
?>
