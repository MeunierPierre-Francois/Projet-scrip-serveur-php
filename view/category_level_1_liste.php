<div class="row">

    <div class="twelve columns">
        <div>
            <a href="index.php?p=<?php echo $url_page; ?>&action=add" class="button"><i class="fas fa-user-plus"></i> Ajouter</a>
        </div>
    </div>
</div>

<div class="row">
    <div class="twelve columns">
        <?php
        if (is_array($result)) {

            echo isset($msg) && !empty($msg) ? "<div class='missingfield $msg_class'>" . $msg . "</div>" : "";


            foreach ($result as $r) {

                $category_level_1_id = $r["category_level_1_id"];
                $level_1 = $r["level_1"];
                $is_visible = $r["is_visible"];


                if ($is_visible == "1") {
                    $txt_nom = $level_1;
                    $txt_visible = "<i class=\"fas fa-eye-slash\"></i>";
                    $txt_title = "Masquer cette entrée";
                } else {
                    $txt_nom = "<s style='color:#b1b1b1;'>" . $level_1 . "</s>";
                    $txt_visible = "<i class=\"fas fa-eye\"></i>";
                    $txt_title = "Réactiver cette entrée";
                }

                echo "<p>
                <a href='index.php?p=" . $url_page . "&category_level_1_id=" . $category_level_1_id . "&action=update&alpha=" . $get_alpha . "' title='éditer cette entrée' class='bt-action'><i class=\"far fa-edit\"></i></a> 
                <a href='index.php?p=" . $url_page . "&category_level_1_id=" . $category_level_1_id . "&action=showHide&alpha=" . $get_alpha . "' title='" . $txt_title . "' class='bt-action'>" . $txt_visible . "</a> 
                " . $txt_nom . " 
            </p>";
            }
        } else {
            echo "<p>Aucun résultat</p>";
        }

        ?>