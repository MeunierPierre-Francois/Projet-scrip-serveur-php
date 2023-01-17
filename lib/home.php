<?php
function getHome($id = 0, $depart, $articles_par_page)
{



    $cond = !empty($alpha) ? " ad_title LIKE '" . $alpha . "%' " : " 1 ";
    $cond .= $id > 0 ? " AND a.ad_id = " . $id : "";

    $sql = "SELECT a.ad_id as id, a.ad_title,CONCAT(c.level_1,' > ',t.level_2) as categorie ,CONCAT(UPPER(d.firstname),' ', d.lastname) as full_name, m.manufacturer, a.is_visible,
    t.category_level_2_id,a.shape_id,d.designer_id,m.manufacturer_id,a.ad_description,a.ad_description_detail,a.price

FROM ad as a
INNER JOIN category_level_2 as t ON t.category_level_2_id = a.category_level_2_id
INNER JOIN category_level_1 as c ON t.category_level_1_id = c.category_level_1_id  
INNER JOIN designer as d ON d.designer_id = a.designer_id
INNER JOIN manufacturer as m ON m.manufacturer_id = a.manufacturer_id
ORDER by a.ad_title ASC 
LIMIT " . $depart . "," . $articles_par_page . ";
";

    return requeteResultat($sql);


}



