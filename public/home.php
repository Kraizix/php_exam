<!DOCTYPE html>
<?php
require __DIR__.'/../src/bootstrap.php';
include_once '../src/inc/common.php';  
view('header', ['title' => 'HOME']);
include '../config/db.php';
?>

<body>
    <div class="container">
        <div class="home">
            <img class="ui fluid image" style="object-fit: cover;" src="./content/banner/banner.jpg"></img>
            <!-- Site content !-->
            <?= var_dump($_SESSION['admin']);?>
        </div>
        <div class="new">
            <h2>New:</h4>
                <?php
            // New articles
            $queryString="SELECT * FROM Articles ORDER BY date DESC LIMIT 4";
            $results = $pdo->prepare($queryString);
            $results->execute();
            $posts=$results->fetchAll();
            foreach ($posts as $post){
            ?>
                <div class="ui raised link card">
                    <div class="content">
                        <div class="header"><?= $post['title'] ?></div>
                        <div class="meta">
                            <?php
                        $catArray = unserialize($post["category"]);
                        foreach ($catArray as $category) { ?>
                            <div class="ui label"><?= $category ?></div>
                            <?php } ?>
                        </div>
                        <div class="description">
                            <p><?= $post["content"]?></p>
                        </div>
                    </div>
                    <div class="extra content">
                        By User_<?= $post["userID"] ?> -- <?= $post["pinned"] == 1 ? "Pinned" : "Not Pinned" ?>
                    </div>
                </div>
                <?php } ?>
        </div>
        <div class="trend">
            <h2>Tendances :</h2>

            <?php
            //Tendances :
                $favQuery = "SELECT Articles.id, title, content, image, category, date, Articles.userID, pinned, count(Favs.id) AS nbFavs
                FROM Articles INNER JOIN Favs ON Articles.id = postID GROUP BY postID ORDER BY count(Favs.id) DESC LIMIT 4";
                $results = $pdo->prepare($favQuery);
                $results->execute();
                $posts = $results->fetchAll();

                foreach ($posts as $post){
            ?>
            <div class="ui raised link card">
                <div class="content">
                    <div class="header"><?= $post['title'] ?></div>
                    <div class="meta">
                        <?php
                        $catArray = unserialize($post["category"]);
                        foreach ($catArray as $category) { ?>
                        <div class="ui label"><?= $category ?></div>
                        <?php } ?>
                    </div>
                    <div class="description">
                        <p><?= $post["content"]?></p>
                    </div>
                </div>
                <div class="extra content">
                    By User_<?= $post["userID"] ?> -- <?= $post["pinned"] == 1 ? "Pinned" : "Not Pinned" ?>
                </div>
            </div>
            <?php } ?>
        </div>
        <div class="search-posts">
            <h2 id="search">Search what you want :</h2>
            <form method="GET">
                <div class="ui input">
                    <input type="text" name="q" id="searchbar" placeholder="Tell us what you want to find ... ">
                </div>
                <div>
                    <!--Dropdown style VALENTIN -->
                    <label for="category">Category:</label>
                    <select name="category[]" class="ui selection dropdown" multiple="" id="multi-select">
                        <option value="informatique">Informatique</option>
                        <option value="new">New</option>
                        <option value="anime">Animé</option>
                        <option value="event">Evènement</option>
                    </select>
                </div>
                <button type="submit" class="ui labeled icon button">
                    <i class="search icon"></i>
                    Search
                </button>
            </form>

            <?php
                if (isset($_GET['q']) && $_GET['q'] != "") {
                    if ($_GET['category'] != "") {
                        $squery = "SELECT * FROM Articles WHERE (category = :category AND title LIKE :query) OR (category = :category AND content LIKE :query)";
                        print_r($_GET['category']);
                        $catArray = $_GET['category'];
                        $category = serialize($catArray);

                        $datas = [
                            "query" => "%".$_GET["q"]."%",
                            "category" => $category,
                        ];
                    } else {
                        $squery = "SELECT * FROM Articles WHERE title LIKE :query OR content LIKE :query";

                        $datas = [
                            "query" => "%".$_GET["q"]."%",
                        ];
                    }
                    $results = $pdo->prepare($squery);
                    $results->execute($datas);
                    $posts = $results->fetchAll();
                    if (empty($posts)) {
                        echo "<p>Pas de résultat...</p>";
                    } else {
                foreach ($posts as $post) {
            ?>
            <div class="ui raised link card">
                <div class="content">
                    <div class="header"><?= $post['title'] ?></div>
                    <div class="meta">
                        <?php
                        $catArray = unserialize($post["category"]);
                        foreach ($catArray as $category) { ?>
                        <div class="ui label"><?= $category ?></div>
                        <?php } ?>
                    </div>
                    <div class="description">
                        <p><?= $post["content"]?></p>
                    </div>
                </div>
                <div class="extra content">
                    <a href="account.php?=<?= $post["userID"] ?>">By User_<?= $post["userID"] ?></a> -- <?= $post["pinned"] == 1 ? "Pinned" : "Not Pinned" ?>
                </div>
            </div>
            <?php       }
                    }
                } else {
            ?>
            <br>
            <p>Il manque un query !</p>
            <?php
                }
            ?>
        </div>
    </div>

            
    <?php view('footer') ?>

    <script>
        $(document).ready(function () {
            $('#multi-select')
                .dropdown();
        })

        $('button').click(function () {
            $('.ui.sidebar')
                .sidebar('setting', 'transition', 'overlay')
                .sidebar('toggle')
        })
    </script>
    </div>
</body>

{{ end }}