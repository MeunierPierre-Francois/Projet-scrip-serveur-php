<div class="row">
    <div class="six columns">
        <?php
        echo "<h5>Recherche alphabétique :</h5>";
        echo "<p>";
        foreach ($alphabet as $lettre) {
            echo "<a href='index.php?p=" . $url_page . "&alpha=" . $lettre . "' class='bt-action'>" . $lettre . "</a> ";
        }
        echo "</p>";
        ?>
    </div>
    <div class="six columns">
        <form action="index.php?p=<?php echo $url_page; ?>" method="get" id="search">

            <div>
                <input type="hidden" name="p" value="<?php echo $url_page; ?>" />
                <input type="text" id="quicherchez_vous" name="alpha" value="" placeholder="Tapez votre recherche ici" />
                <input type="submit" value="trouver" />
                <a href="index.php?p=<?php echo $url_page; ?>&action=add" class="button"><i class="fas fa-user-plus"></i> Ajouter</a>
            </div>
        </form>
    </div>
</div>


<div class="row">
    <div class="twelve columns">
        <?php
        if (is_array($result)) {
            echo isset($msg) && !empty($msg) ? "<div class='missingfield $msg_class'>" . $msg . "</div>" : "";
            foreach ($result as $r) {
                $id = $r["id"];
                $ad_title = $r["ad_title"];
                $categorie = $r["categorie"];
                $name = $r["full_name"];
                $manufacturer = $r["manufacturer"];
                $is_visible = $r["is_visible"];


                if ($is_visible == "1") {
                    $txt_nom = "<b>" . $ad_title . "</b>";
                    $txt_description = "<p>Catégorie : " . $categorie . "</br>Designer : " . $name . "</br> Manufacturer : " . $manufacturer . "</p>";
                    $txt_visible = "<i class=\"fas fa-eye-slash\"></i>";
                    $txt_title = "Masquer cette entrée";
                } else {
                    $txt_nom = "<s style='color:#b1b1b1;'> <b>" . $ad_title . "</b> </s>";
                    $txt_description = "<s><p>Catégorie : " . $categorie . "</br>Designer : " . $name . "</br> Manufacturer : " . $manufacturer . "</p></s>";
                    $txt_visible = "<i class=\"fas fa-eye\"></i>";
                    $txt_title = "Réactiver cette entrée";
                }

                echo "<p>
                         
                <a href='index.php?p=" . $url_page . "&ad_id=" . $id . "&action=update&alpha=" . $get_alpha . "&id=" . $get_id . "' title='éditer cette entrée' class='bt-action'><i class=\"far fa-edit\"></i></a> 
                <a href='index.php?p=" . $url_page . "&ad_id=" . $id . "&action=showHide&alpha=" . $get_alpha . "&id=" . $get_id . "' title='" . $txt_title . "' class='bt-action'>" . $txt_visible . "</a> 
                " . $txt_nom .  $txt_description . "
                    </p>";
            }
        } else {
            echo "<p>Aucun résultat pour la lettre " . $get_alpha . "</p>";
        }

        ?>
    </div>
    <div class="eight columns">
        <?php

        echo isset($msg) && !empty($msg) ? "<div class='missingfield $msg_class'>" . $msg . "</div>" : "";
        ?>
    </div>
</div>