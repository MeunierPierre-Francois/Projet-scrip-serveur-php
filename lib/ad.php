<?php
function getAd($id = 0, $alpha = "")
{

    if (!is_numeric($id)) {
        return false;
    }

    $cond = !empty($alpha) ? " ad_title LIKE '" . $alpha . "%' " : " 1 ";
    $cond .= $id > 0 ? " AND a.ad_id = " . $id : "";

    $sql = "SELECT a.ad_id as id, a.ad_title,CONCAT(c.level_1,' > ',t.level_2) as categorie ,CONCAT(UPPER(d.firstname),' ', d.lastname) as full_name, m.manufacturer, a.is_visible,
                    t.category_level_2_id,a.shape_id,d.designer_id,m.manufacturer_id,a.ad_description,a.ad_description_detail,a.price_htva,a.price_delivery

    FROM ad as a
    INNER JOIN category_level_2 as t ON t.category_level_2_id = a.category_level_2_id
    INNER JOIN category_level_1 as c ON t.category_level_1_id = c.category_level_1_id  
    INNER JOIN designer as d ON d.designer_id = a.designer_id
    INNER JOIN manufacturer as m ON m.manufacturer_id = a.manufacturer_id
    WHERE " . $cond . "
    group by categorie
    ORDER by categorie ASC 
    ";

    return requeteResultat($sql);
}

function insertAd($data)
{
    $category_level_2_id   = $data["category_level_2_id"];
    $shape_id               = $data["shape_id"];
    $designer_id            = $data["designer_id"];
    $manufacturer_id        = $data["manufacturer_id"];
    $ad_title               = $data["ad_title"];
    $ad_description         = $data["ad_description"];
    $ad_description_detail  = $data["ad_description_detail"];
    $price_htva             = $data["price_htva"];
    $price_delivery         = $data["price_delivery"];

    $price = $price_delivery + $price_htva;
    $amount_tva = round($price_htva * 0.21, 2);


    $sql = "INSERT INTO ad (category_level_2_id,shape_id, designer_id, manufacturer_id, ad_title, ad_description, ad_description_detail,price, price_htva,amount_tva, price_delivery,admin_id,date_add) 
    VALUES($category_level_2_id, $shape_id, $designer_id, $manufacturer_id, '$ad_title', '$ad_description', '$ad_description_detail',$price, $price_htva,$amount_tva, $price_delivery," . $_SESSION['admin_id'] . ",NOW());";

    return ExecRequete($sql);
}

function updateAd($id, $data)
{
    if (!is_numeric($id)) {
        return false;
    }
    $category_level_2_id    = $data["category_level_2_id"];
    $shape_id               = $data["shape_id"];
    $designer_id            = $data["designer_id"];
    $manufacturer_id        = $data["manufacturer_id"];
    $ad_title               = $data["ad_title"];
    $ad_description         = $data["ad_description"];
    $ad_description_detail  = $data["ad_description_detail"];
    $price_htva             = $data["price_htva"];
    $price_delivery         = $data["price_delivery"];

    $amount_tva = round($price_htva * 0.21, 2);
    $price = $price_htva + $amount_tva;

    $sql = "UPDATE ad 
                SET
                    category_level_2_id = $category_level_2_id, 
                    shape_id = $shape_id, 
                    designer_id = $designer_id, 
                    manufacturer_id = $manufacturer_id, 
                    ad_title = '$ad_title', 
                    ad_description = '$ad_description', 
                    ad_description_detail = '$ad_description_detail', 
                    price = $price, 
                    price_htva = $price_htva, 
                    amount_tva = $amount_tva, 
                    price_delivery = $price_delivery 
            WHERE ad_id = " . $id . " ;
            ";

    return ExecRequete($sql);
}

function showHideAd($id)
{
    if (!is_numeric($id)) {
        return false;
    }
    // récupération de l'état avant mise à jour
    $sql = "SELECT is_visible FROM ad WHERE ad_id = " . $id . ";";
    $result = requeteResultat($sql);
    if (is_array($result)) {
        $etat_is_visble = $result[0]["is_visible"];

        $nouvel_etat = $etat_is_visble == "1" ? "0" : "1";
        // mise à jour vers le nouvel état
        $sql = "UPDATE ad SET is_visible = '" . $nouvel_etat . "' WHERE ad_id = " . $id . ";";
        // exécution de la requête
        return ExecRequete($sql);
    } else {
        return false;
    }
}
