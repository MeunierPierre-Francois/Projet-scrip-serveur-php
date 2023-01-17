<?php 
include_once("lib/home.php");
include_once("lib/shape.php");
include_once("lib/designer.php");
include_once("lib/manufacturer.php");
include_once("lib/categories.php");


$url_page = "home";



$get_id     = isset($_GET["id"])    ? filter_input(INPUT_GET, 'id', FILTER_SANITIZE_SPECIAL_CHARS)      : null;





$articles_par_page = 30;
$articles_total_sql = "SELECT count(ad_id) as nombre FROM ad;";
$articles_total_sql_resultat =  requeteResultat($articles_total_sql);
$articles_total = $articles_total_sql_resultat[0]["nombre"];
$page_total = ceil($articles_total / $articles_par_page);

if(isset($_GET['page']) AND !empty($_GET['page'])){
    $_GET['page'] = intval( $_GET['page']);
    $page_courrante = $_GET['page'];
}else{
    $page_courrante = 1;
}

$depart = ($page_courrante-1) * $articles_par_page;

$result = getHome(0,$depart,$articles_par_page);

$page_view = "home";

?>