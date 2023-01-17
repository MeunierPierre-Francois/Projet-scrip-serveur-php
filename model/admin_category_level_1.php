<?php
adminProtection();
include_once("lib/categories.php");

$url_page = "admin_category_level_1";

$get_action = isset($_GET["action"]) ? filter_input(INPUT_GET, 'action', FILTER_SANITIZE_SPECIAL_CHARS) : "liste";
$get_alpha  = isset($_GET["alpha"]) ? filter_input(INPUT_GET, 'alpha', FILTER_SANITIZE_SPECIAL_CHARS)   : "A";
$get_category_level_1_id = isset($_GET["category_level_1_id"]) ? filter_input(INPUT_GET, 'category_level_1_id', FILTER_SANITIZE_NUMBER_INT) : null;

switch ($get_action) {

    case "liste":
        $page_view = "category_level_1_liste";
        $result = getCategoryLevel1();
        break;

    case "add":
        $post_level_1  = isset($_POST["level_1"])   ? filter_input(INPUT_POST, 'level_1', FILTER_SANITIZE_SPECIAL_CHARS)             : null;


        // initialisation du array qui contiendra la définitions des différents champs du formulaire
        $input = [];
        // ajout des différents champs du formulaire
        $input[] = addLayout("<h4>Ajouter une catégorie</h4>");
        $input[] = addLayout("<div class='row'>");
        $input[] = addInput('Nom de la catégorie', ["type" => "text", "value" => $post_level_1, "name" => "level_1", "class" => "u-full-width"], true, "twelve columns");
        $input[] = addLayout("</div>");
        $input[] = addSubmit(["value" => "envoyer", "name" => "submit"], "\t\t<br />\n");

        $show_form = form("form_contact", "index.php?p=" . $url_page . "&action=add", "post", $input);

        if ($show_form != false) {
            $page_view = "category_level_1_form";
        } else {
            $data_values = array();
            $data_values["level_1"] = $post_level_1;

            if (insertCatergoryLevel1($data_values)) {
                $msg = "<p>données insérées avec succès</p>";
                $msg_class = "success";
            } else {
                $msg = "<p>erreur lors de l'insertion des données</p>";
                $msg_class = "error";
            }
            $page_view = "category_level_1_liste";
            $result = getCategoryLevel1();
        }
        break;


    case "update":
       

        if (empty($_POST)) {
            $result = getCategoryLevel1($get_category_level_1_id);

            $level_1 = $result[0]["level_1"];
        } else {
            $level_1 = null;
        }

        $post_level_1 = isset($_POST["level_1"])   ? filter_input(INPUT_POST, 'level_1', FILTER_SANITIZE_SPECIAL_CHARS)             : $level_1;


        $input = [];
        $input[] = addLayout("<h4>Modifier une catégorie</h4>");
        $input[] = addLayout("<div class='row'>");
        $input[] = addInput('Nom de la catégorie', ["type" => "text", "value" => $post_level_1, "name" => "level_1", "class" => "u-full-width"], true, "twelve columns");
        $input[] = addLayout("</div>");
        $input[] = addSubmit(["value" => "envoyer", "name" => "submit"], "\t\t<br />\n");
        $show_form = form("form_contact", "index.php?p=" . $url_page . "&action=update&category_level_1_id=" . $get_category_level_1_id, "post", $input);

        if ($show_form != false) {
            $page_view = "category_level_1_form";
        } else {
            $data_values                 = array();
            $data_values["level_1"] = $post_level_1;


            if (updateCategoryLevel1($get_category_level_1_id, $data_values)) {
                // message de succes qui sera affiché dans le <body>
                $msg = "<p>données modifiée avec succès</p>";
                $msg_class = "success";
            } else {
                // message d'erreur qui sera affiché dans le <body>
                $msg = "<p>erreur lors de la modification des données</p>";
                $msg_class = "error";
            }
            $page_view = "category_level_1_liste";



            $result = getCategoryLevel1();
        }
        break;

    case "showHide":
        

        if (showHideCategoryLevel1($get_category_level_1_id)) {
            // message de succes qui sera affiché dans le <body>
            $msg = "<p>mise à jour de l'état réalisée avec succès</p>";
            $msg_class = "success";
        } else {
            // message d'erreur qui sera affiché dans le <body>
            $msg = "<p>erreur lors de la mise à jour de l'état</p>";
            $msg_class = "error";
        }
        $page_view = "category_level_1_liste";

        $result = getCategoryLevel1();

        break;
}
?>
