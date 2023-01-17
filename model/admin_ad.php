<?php
adminProtection();
include_once("lib/ad.php");
include_once("lib/shape.php");
include_once("lib/designer.php");
include_once("lib/manufacturer.php");
include_once("lib/categories.php");

$url_page = "admin_ad";

$get_action = isset($_GET["action"]) ? filter_input(INPUT_GET, 'action', FILTER_SANITIZE_SPECIAL_CHARS) : "liste";
$get_alpha = isset($_GET["alpha"]) ? filter_input(INPUT_GET, 'alpha', FILTER_SANITIZE_SPECIAL_CHARS)   : "A";
$get_id     = isset($_GET["id"])    ? filter_input(INPUT_GET, 'id', FILTER_SANITIZE_SPECIAL_CHARS)      : null;




switch ($get_action) {
    case 'liste':
        $result = getAd(0, $get_alpha);
        $alphabet = range('A', 'Z');
        $page_view = "ad_liste";
        break;

    case "add":
        $post_category_level_2_id    = isset($_POST["category_level_2_id"])   ? filter_input(INPUT_POST, 'category_level_2_id', FILTER_VALIDATE_INT)           : null;
        $post_shape_id      = isset($_POST["shape_id"])   ? filter_input(INPUT_POST, 'shape_id', FILTER_VALIDATE_INT)           : null;
        $post_designer_id       = isset($_POST["designer_id"])   ? filter_input(INPUT_POST, 'designer_id', FILTER_VALIDATE_INT)           : null;
        $post_manufacturer_id       = isset($_POST["manufacturer_id"])   ? filter_input(INPUT_POST, 'manufacturer_id', FILTER_VALIDATE_INT)           : null;
        $post_ad_title       = isset($_POST["ad_title"])      ? filter_input(INPUT_POST, 'ad_title', FILTER_SANITIZE_SPECIAL_CHARS)    : null;
        $post_ad_description       = isset($_POST["ad_description"])      ? filter_input(INPUT_POST, 'ad_description', FILTER_SANITIZE_SPECIAL_CHARS)    : null;
        $post_ad_description_detail       = isset($_POST["ad_description_detail"])      ? filter_input(INPUT_POST, 'ad_description_detail', FILTER_SANITIZE_SPECIAL_CHARS)    : null;
        $post_price_htva       = isset($_POST["price_htva"])      ? filter_input(INPUT_POST, 'price_htva', FILTER_SANITIZE_SPECIAL_CHARS)    : null;
        $post_price_delivery       = isset($_POST["price_delivery"])      ? filter_input(INPUT_POST, 'price_delivery', FILTER_SANITIZE_SPECIAL_CHARS)    : null;



        $categorie = [0 => "=== choix ==="] + array_column(getAd(0, ""), "categorie");
        $shape = [0 => "=== choix ==="] + array_column(getShape(0, ""), "shape_title");
        $designer = [0 => "=== choix ==="] + array_column(getDesigner(0, ""), "full_name");
        $manufacturer = [0 => "=== choix ==="] + array_column(getManufacturer(0, ""), "manufacturer");




        // initialisation du array qui contiendra la définitions des différents champs du formulaire
        $input = [];
        // ajout des différents champs du formulaire
        $input[] = addLayout("<h4>Ajouter un article</h4>");
        $input[] = addLayout("<div class='row'>");
        $input[] = addSelect("Catégorie associée", ["name" => "category_level_2_id", "class" => "u-full-width"], $categorie, $post_category_level_2_id, true, "twelve columns");
        $input[] = addSelect("Etat de l'objet", ["name" => "shape_id", "class" => "u-full-width"], $shape, $post_shape_id, true, "twelve columns");
        $input[] = addSelect("Designer", ["name" => "designer_id", "class" => "u-full-width"], $designer, $post_designer_id, true, "twelve columns");
        $input[] = addSelect("Manufacturer", ["name" => "manufacturer_id", "class" => "u-full-width"], $manufacturer, $post_manufacturer_id, true, "twelve columns");
        $input[] = addInput("Nom de l'objet", ["type" => "text", "value" => $post_ad_title, "name" => "ad_title", "class" => "u-full-width"], true, "twelve columns");
        $input[] = addTextarea('Brève description', array("name" => "ad_description", "class" => "u-full-width"), $post_ad_description, true, "twelve columns");
        $input[] = addTextarea('Description complète', array("name" => "ad_description_detail", "class" => "u-full-width"), $post_ad_description_detail, true, "twelve columns");
        $input[] = addInput("Prix HTVA", ["type" => "number", "value" => $post_price_htva, "name" => "price_htva", "class" => "u-full-width"], true, "five columns");
        $input[] = addInput("Prix de la livraison", ["type" => "number", "value" => $post_price_delivery, "name" => "price_delivery", "class" => "u-full-width"], true, "five columns");
        $input[] = addLayout("</div>");
        $input[] = addSubmit(["value" => "envoyer", "name" => "submit"], "\t\t<br />\n");

        $show_form = form("form_contact", "index.php?p=" . $url_page . "&action=add", "post", $input);

        if ($show_form != false) {

            $page_view = "ad_form";
        } else {

            $data_values = array();
            $data_values["category_level_2_id"]  = $post_category_level_2_id;
            $data_values["shape_id"]  = $post_shape_id;
            $data_values["designer_id"]  = $post_designer_id;
            $data_values["manufacturer_id"]  = $post_manufacturer_id;
            $data_values["ad_title"]  = $post_ad_title;
            $data_values["ad_description"]  = $post_ad_description;
            $data_values["ad_description_detail"]  = $post_ad_description_detail;
            $data_values["price_htva"]  = $post_price_htva;
            $data_values["price_delivery"]  = $post_price_delivery;



            if (insertAd($data_values)) {

                $msg = "<p>données insérées avec succès</p>";
                $msg_class = "success";
            } else {

                $msg = "<p>erreur lors de l'insertion des données</p>";
                $msg_class = "error";
            }

            $alphabet = range('A', 'Z');
            $result = getAd(0, $get_alpha);
            $page_view = "ad_liste";
        }
        break;

    case "update":
        $get_ad_id = isset($_GET["ad_id"]) ? filter_input(INPUT_GET, 'ad_id', FILTER_SANITIZE_NUMBER_INT) : null;

        $categorie = [0 => "=== choix ==="] + array_column(getAd(0, ""), "categorie");
        $shape = [0 => "=== choix ==="] + array_column(getShape(0, ""), "shape_title");
        $designer = [0 => "=== choix ==="] + array_column(getDesigner(0, ""), "full_name");
        $manufacturer = [0 => "=== choix ==="] + array_column(getManufacturer(0, ""), "manufacturer");

        if (empty($_POST)) {
            $result = getAd($get_ad_id);

            $category_level_2_id       = $result[0]["category_level_2_id"];
            $shape_id                  = $result[0]["shape_id"];
            $designer_id               = $result[0]["designer_id"];
            $manufacturer_id           = $result[0]["manufacturer_id"];
            $ad_title                  = $result[0]["ad_title"];
            $ad_description            = $result[0]["ad_description"];
            $ad_description_detail     = $result[0]["ad_description_detail"];
            $price_htva                = $result[0]["price_htva"];
            $price_delivery            = $result[0]["price_delivery"];
        } else {
            $category_level_2_id       = null;
            $shape_id                  = null;
            $designer_id               = null;
            $manufacturer_id           = null;
            $ad_title                  = null;
            $ad_description            = null;
            $ad_description_detail     = null;
            $price_htva                = null;
            $price_delivery            = null;
        }
        // récupération / initialisation des données qui transitent via le formulaire
        $post_category_level_2_id    = isset($_POST["category_level_2_id"])   ? filter_input(INPUT_POST, 'category_level_2_id', FILTER_VALIDATE_INT)           : $category_level_2_id;
        $post_shape_id      = isset($_POST["shape_id"])   ? filter_input(INPUT_POST, 'shape_id', FILTER_VALIDATE_INT)           : $shape_id;
        $post_designer_id       = isset($_POST["designer_id"])   ? filter_input(INPUT_POST, 'designer_id', FILTER_VALIDATE_INT)           : $designer_id;
        $post_manufacturer_id       = isset($_POST["manufacturer_id"])   ? filter_input(INPUT_POST, 'manufacturer_id', FILTER_VALIDATE_INT)           : $manufacturer_id;
        $post_ad_title       = isset($_POST["ad_title"])      ? filter_input(INPUT_POST, 'ad_title', FILTER_SANITIZE_SPECIAL_CHARS)    : $ad_title;
        $post_ad_description       = isset($_POST["ad_description"])      ? filter_input(INPUT_POST, 'ad_description', FILTER_SANITIZE_SPECIAL_CHARS)    : $ad_description;
        $post_ad_description_detail       = isset($_POST["ad_description_detail"])      ? filter_input(INPUT_POST, 'ad_description_detail', FILTER_SANITIZE_SPECIAL_CHARS)    : $ad_description_detail;
        $post_price_htva       = isset($_POST["price_htva"])      ? filter_input(INPUT_POST, 'price_htva', FILTER_SANITIZE_SPECIAL_CHARS)    : $price_htva;
        $post_price_delivery       = isset($_POST["price_delivery"])      ? filter_input(INPUT_POST, 'price_delivery', FILTER_SANITIZE_SPECIAL_CHARS)    : $price_delivery;

        

        $input = [];
        // ajout des différents champs du formulaire
        $input[] = addLayout("<h4>Modifier un article</h4>");
        $input[] = addLayout("<div class='row'>");
        $input[] = addSelect("Catégorie associée", ["name" => "category_level_2_id", "class" => "u-full-width"], $categorie, $post_category_level_2_id, true, "twelve columns");
        $input[] = addSelect("Etat de l'objet", ["name" => "shape_id", "class" => "u-full-width"], $shape, $post_shape_id, true, "twelve columns");
        $input[] = addSelect("Designer", ["name" => "designer_id", "class" => "u-full-width"], $designer, $post_designer_id, true, "twelve columns");
        $input[] = addSelect("Manufacturer", ["name" => "manufacturer_id", "class" => "u-full-width"], $manufacturer, $post_manufacturer_id, true, "twelve columns");
        $input[] = addInput("Nom de l'objet", ["type" => "text", "value" => $post_ad_title, "name" => "ad_title", "class" => "u-full-width"], true, "twelve columns");
        $input[] = addTextarea('Brève description', array("name" => "ad_description", "class" => "u-full-width"), $post_ad_description, true, "twelve columns");
        $input[] = addTextarea('Description complète', array("name" => "ad_description_detail", "class" => "u-full-width"), $post_ad_description_detail, true, "twelve columns");
        $input[] = addInput("Prix HTVA", ["type" => "number", "value" => $post_price_htva, "name" => "price_htva", "class" => "u-full-width"], true, "five columns");
        $input[] = addInput("Prix de la livraison", ["type" => "number", "value" => $post_price_delivery, "name" => "price_delivery", "class" => "u-full-width"], true, "five columns");
        $input[] = addLayout("</div>");
        $input[] = addSubmit(["value" => "envoyer", "name" => "submit"], "\t\t<br />\n");

        $show_form = form("form_contact", "index.php?p=" . $url_page . "&action=update&ad_id=" . $get_ad_id . "&id=" . $get_ad_id . "&alpha=" . $get_alpha, "post", $input);


        if ($show_form != false) {

            $page_view = "ad_form";
        } else {

            $data_values = array();
            $data_values["category_level_2_id"]  = $post_category_level_2_id;
            $data_values["shape_id"]  = $post_shape_id;
            $data_values["designer_id"]  = $post_designer_id;
            $data_values["manufacturer_id"]  = $post_manufacturer_id;
            $data_values["ad_title"]  = $post_ad_title;
            $data_values["ad_description"]  = $post_ad_description;
            $data_values["ad_description_detail"]  = $post_ad_description_detail;
            $data_values["price_htva"]  = $post_price_htva;
            $data_values["price_delivery"]  = $post_price_delivery;



            if (updateAd($get_ad_id, $data_values)) {

                $msg = "<p>données insérées avec succès</p>";
                $msg_class = "success";
            } else {

                $msg = "<p>erreur lors de l'insertion des données</p>";
                $msg_class = "error";
            }

            $alphabet = range('A', 'Z');
            $result = getAd(0, $get_alpha);
            $page_view = "ad_liste";
        }
        break;

    case "showHide":
        $get_ad_id = isset($_GET["ad_id"]) ? filter_input(INPUT_GET, 'ad_id', FILTER_SANITIZE_NUMBER_INT) : null;

        if (showHideAd($get_ad_id)) {
            // message de succes qui sera affiché dans le <body>
            $msg = "<p>mise à jour de l'état réalisée avec succès</p>";
            $msg_class = "success";
        } else {
            // message d'erreur qui sera affiché dans le <body>
            $msg = "<p>erreur lors de la mise à jour de l'état</p>";
            $msg_class = "error";
        }
        $page_view = "ad_liste";
        $alphabet = range('A', 'Z');
        $result = getAd(0, $get_alpha);
        break;
}
