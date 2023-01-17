<body>
    <div class="main_content">
        <div id='search' class='u-full-width'>
            <div id="trail" class="container row">
                <ul>
                    <li>Vous êtes ici :</li>
                    <li>Page d'accueil</li>
                </ul>
            </div>
        </div>

        <section class="container">

            <!-- début de la première ligne de 3 articles -->

            <?php
            if (is_array($result)) {

                foreach ($result as $key => $r) {

                    $id = $r["id"];
                    $ad_title = $r["ad_title"];
                    $name = $r["full_name"];
                    $manufacturer = $r["manufacturer"];
                    $description = $r["ad_description"];
                    $is_visible = $r["is_visible"];
                    $price = $r["price"];
                    $description_max = subMyString($description, 100);
                    $prix = round($price, 2);


                    if ($key % 3 === 0) {
                        echo "<div class = 'row'>";
                    }
                    echo "<article class='pres_product four columns border'>
                            <div class='thumb'>
                                <a href='./index.php?p=detail&id=" . $id . "'>
                                    <span class='rollover'><i>+</i></span>
                                    <img src='upload/thumb/thumb_" . $id . "-1.jpg' alt='' />
                                </a>
                            </div>
                            <header>
                                <h4><a href='./index.php?p=detail&id=" . $id . "' title=''>$ad_title</a></h4>
                                <div class='subheader'>
                                    <span class='fa fa-bars'></span> <a href='' title=''></a>
                                    <span class='separator'>|</span>
                                    <span class='fa fa-pencil'></span> <a href='' title=''>$name</a>
                                    <span class='separator'>|</span>
                                    <span class='fa fa-building-o'></span> <a href='' title=''><small style='opacity:.5;'>- $manufacturer -</small></a>
                                </div>
                            </header>
                            <div class='une_txt'>
                                <p>
                                     $description_max
                                    <a href='./index.php?p=detail&id=" . $id . "' title=''>[...]</a>
                                    <b> $prix €</b>
                                </p>
                            </div>
                        </article>";
                    if (($key + 1) % 3 === 0) {
                        echo "</div>";
                    }
                }
            } else {
                echo "<p>Aucun article </p>";
            }





            // <!-- début de la pagination -->
            echo " <br /><br />";

            echo "<ul class='pagination'>";
            for ($i = 1; $i <= $page_total; $i++) {
                if ($i == $page_courrante) {
                    echo "<li><a href='./index.php?p=home&page=" . $i . "' class='active'>" . $i . "</a></li>";
                } else {
                    echo "<li><a href='./index.php?p=home&page=" . $i . "' class=''>" . $i . "</a></li>";
                }
            }
            echo "</ul>";
            ?>
        </section>
    </div>
</body>