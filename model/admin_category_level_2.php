<?php
adminProtection();
include_once("lib/categories.php");
include_once("lib/shape.php");

$url_page = "admin_category_level_2";

$get_action = isset($_GET["action"]) ? filter_input(INPUT_GET, 'action', FILTER_SANITIZE_SPECIAL_CHARS) : "liste";
$get_category_level_2_id   = isset($_GET["category_level_2_id"]) ? filter_input(INPUT_GET, 'category_level_2_id', FILTER_SANITIZE_NUMBER_INT) : null;
$get_alpha                 = isset($_GET["alpha"]) ? filter_input(INPUT_GET, 'alpha', FILTER_SANITIZE_SPECIAL_CHARS)   : "A";

switch ($get_action) {
    case "liste":
        // récupération des item correspondant
        $result = getCategoryLevel2();

        $page_view = "category_level_2_liste";
        break;

    case "add":
        
        $post_level_2       = isset($_POST["level_2"])      ? filter_input(INPUT_POST, 'level_2', FILTER_SANITIZE_SPECIAL_CHARS)    : null;
        $post_level_1_id    = isset($_POST["level_1_id"])   ? filter_input(INPUT_POST, 'level_1_id', FILTER_VALIDATE_INT)           : null;


        $level_1 = [0 => "=== choix ==="] + array_column(getCategoryLevel1(0, "1"), "level_1", "category_level_1_id");


        // initialisation du array qui contiendra la définitions des différents champs du formulaire
        $input = [];
        // ajout des différents champs du formulaire
        $input[] = addLayout("<h4>Ajouter une sous-catégorie</h4>");
        $input[] = addLayout("<div class='row'>");
        $input[] = addSelect("Catégorie associée", ["name" => "level_1_id", "class" => "u-full-width"], $level_1, $post_level_1_id, true, "twelve columns");
        $input[] = addInput("Nom de la sous-catégorie", ["type" => "text", "value" => $post_level_2, "name" => "level_2", "class" => "u-full-width"], true, "twelve columns");
        $input[] = addLayout("</div>");
        $input[] = addSubmit(["value" => "envoyer", "name" => "submit"], "\t\t<br />\n");

        $show_form = form("form_contact", "index.php?p=" . $url_page . "&action=add", "post", $input);

        if ($show_form != false) {

            $page_view = "category_level_2_form";
        } else {

            $data_values = array();
            $data_values["level_2"]     = $post_level_2;
            $data_values["level_1_id"]  = $post_level_1_id;

            if (insertCategoryLevel2($data_values)) {

                $msg = "<p>données insérées avec succès</p>";
                $msg_class = "success";
            } else {

                $msg = "<p>erreur lors de l'insertion des données</p>";
                $msg_class = "error";
            }
  $result = getCategoryLevel2();
          $page_view = "category_level_2_liste";
        }
        break;

    case "update":
        $level_1 = [0 => "=== choix ==="] + array_column(getCategoryLevel1(0, "1"), "level_1", "category_level_1_id");
        
        if (empty($_POST)) {
            $result = getCategoryLevel2($get_category_level_2_id);

            $post_level_2         = $result[0]["level_2"];
            $post_level_1_id      = $result[0]["category_level_1_id"];
        } else {
            // récupération / initialisation des données qui transitent via le formulaire
            $post_level_2         = isset($_POST["level_2"])                ? filter_input(INPUT_POST, 'level_2', FILTER_SANITIZE_SPECIAL_CHARS)    : null;
            $post_level_1_id      = isset($_POST["category_level_1_id"])    ? filter_input(INPUT_POST, 'category_level_1_id', FILTER_VALIDATE_INT)  : null;
        }



        // initialisation du array qui contiendra la définitions des différents champs du formulaire
        $input = [];

        $input[] = addLayout("<h4>Modifier une catégorie</h4>");
        $input[] = addLayout("<div class='row'>");
        $input[] = addSelect("Catégorie associée", ["name" => "category_level_1_id", "class" => "u-full-width"], $level_1, $post_level_1_id, true, "twelve columns");
        $input[] = addInput("Nom de la sous-catégorie", ["type" => "text", "value" => $post_level_2, "name" => "level_2", "class" => "u-full-width"], true, "twelve columns");
        $input[] = addLayout("</div>");
        $input[] = addSubmit(["value" => "envoyer", "name" => "submit"], "\t\t<br />\n");

        $show_form = form("form_contact", "index.php?p=" . $url_page . "&action=update&category_level_2_id=" . $get_category_level_2_id, "post", $input);

        if ($show_form != false) {

            $page_view = "category_level_2_form";
        } else {
            $data_values = array();
            $data_values["level_2"]     = $post_level_2;
            $data_values["level_1_id"]  = $post_level_1_id;

            // exécution de la requête
            if (updateLevel2($get_category_level_2_id, $data_values)) {
                // message de succes qui sera affiché dans le <body>
                $msg = "<p>données modifiées avec succès</p>";
                $msg_class = "success";
            } else {
                // message d'erreur qui sera affiché dans le <body>
                $msg = "<p>erreur lors de la modification des données</p>";
                $msg_class = "error";
            }

            // récupération des item correspondant
            $result = getCategoryLevel2();

            $page_view = "category_level_2_liste";
        }


        break;

        case "showHide":
            if(showHideCategoryLevel2($get_category_level_2_id)){
                // message de succes qui sera affiché dans le <body>
                $msg = "<p>mise à jour de l'état réalisée avec succès</p>";
                $msg_class = "success";
            }else{
                // message d'erreur qui sera affiché dans le <body>
                $msg = "<p>erreur lors de la mise à jour de l'état</p>";
                $msg_class = "error";
            }
    
            // récupération des item correspondant
            $result = getCategoryLevel2();
    
            $page_view = "category_level_2_liste";
    
            break;    
}
?>