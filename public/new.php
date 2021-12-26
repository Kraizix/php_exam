<?php
require __DIR__.'/../src/bootstrap.php';
require_once __DIR__ .'/Method/imagePost.php';
include '../config/db.php';


 include_once '../src/inc/common.php';   
 view('header', ['title' => 'New']) ;

if (isset($_POST['sub'])){
    header("Location:home.php");
    exit();
}
?>
<!DOCTYPE html>

<body>
    <?php
        if (isset($_POST['title']) && isset($_POST['content']) && $_POST['title'] != NULL && $_POST['content'] != NULL && $_POST['category'] != NULL) {
            $title = $_POST['title'];
            $content = $_POST['content'];
            $pin= $_POST['pin'] ?? 0;
            var_dump((int)$pin);
            try{
                //serialize category array to insert in db
                var_dump($_POST['category']);
                $category = serialize($_POST['category']);
                var_dump($category);
                //Uploaded image data
                $img = NULL;

                // insert
                $date = date("Y-m-d");
                $userID = $_SESSION['id'];
                $pinned = (int)$pin;
                $queryString = 'INSERT INTO Articles (title, content, image, category,date, userID, pinned) VALUES (:title, :content, :image, :category, :date, :userID, :pinned)';
                $data = [
                    "title" => $title, 
                    "content" => $content,
                    "image" => $img,
                    "category" => $category,
                    "date" => $date,
                    "userID" => $userID,
                    "pinned" => $pinned
                ];
                var_dump($data["category"]);
                $query = $pdo->prepare($queryString);
                $query->execute($data);

                $queryString = "SELECT id FROM Articles ORDER BY id DESC LIMIT 1";
                $query = $pdo->prepare($queryString);
                $query->execute();
                $idPost=$query->fetch();
                $idPost=$idPost[0];
                if (isset($_FILES['image'])) {
                    $img = getImgDirectory($idPost, $_FILES['image'], $pdo);
                    print_r($img);
                    $queryString = "UPDATE Articles SET image = '$img' WHERE id ='$idPost'";
                    $query = $pdo->prepare($queryString);
                    $query->execute();
                }

                header("Location:./details.php?id=$idPost");
            }catch (Exception $e) {
                echo "Problem bro : ------> " . $e->getMessage();
                echo $_POST['content'];
            }
        }else{
            ?>
    <label>Required Title, Content and Category please</label>
    <?php 
        }
        if (isset($_SESSION['user'])){?>
    <form method="POST" enctype="multipart/form-data">
        <div>
            <button type="submit" name="sub" value="back">BACK</button>
        </div>
        <h1>Create Post</h1>
        <div class="ui card centered" style="transform:scale(1); width:75%; margin-top:10%;">
            <div class="content">
                <div class="header">
                    <input type="text" name="title" id="title" placeholder="title ... ">
                    <select name="category[]" class="ui selection dropdown" multiple="" id="multi-select">
                        <option value="">Categories</option>
                        <option value="informatique">Informatique</option>
                        <option value="new">New</option>
                        <option value="anime">Anime</option>
                        <option value="event">Event</option>
                        <option value="test">Test</option>
                    </select>
                </div>
                <div class="description">
                    <textarea name="content" id="content" rows="7" style="transform:scale(1); width:100%;"
                        placeholder="Tell us what you want ... "></textarea>
                    <div>
                        <label for="image">Add a Picture : </label>
                        <input type="file" id="image" name="image">
                    </div>
                </div>
            </div>
            <div class="extra content ">

                <i class="thumbtack icon" style="transform:scale(2)"></i>
                <input type="checkbox" style="transform:scale(1)" name="pin" id="pin:" />

                <button type="submit" style="margin-left:90%;">Submit</button>
            </div>
        </div>

    </form>
    <?php
        }else{
            ?>
    <div>
        <h1 class="Message">You are not connected</h1>
        <input type="button" onclick="document.location='./register.php'" value="Register" class="lonelyBtn" />
        <input type="button" onclick="document.location='./login.php'" value="Login" class="lonelyBtn" />
    </div>
    <?php 
        }
        ?>
</body>
<?php view('footer') ?>