<?php
function getDetail($id = 0)
{
    $sql = "SELECT a.ad_id as id, a.ad_title,a.ad_description,a.ad_description_detail,t.category_level_2_id,c.level_1,t.level_2

            FROM ad as a
            INNER JOIN category_level_2 as t ON t.category_level_2_id = a.category_level_2_id
            INNER JOIN category_level_1 as c ON t.category_level_1_id = c.category_level_1_id  
            INNER JOIN designer as d ON d.designer_id = a.designer_id
            INNER JOIN manufacturer as m ON m.manufacturer_id = a.manufacturer_id
            WHERE a.ad_id = '" . $id . "'
            ORDER by a.ad_title ASC 
    ";
    return requeteResultat($sql);
}
