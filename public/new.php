<?php
require __DIR__.'/../src/bootstrap.php';
include '../config/db.php';


 include_once '../src/inc/common.php';   
 view('header', ['title' => 'New']) ;

if (isset($_POST['sub'])){
    header("Location:http://localhost:8080/home.php");
    exit();
}
?>
<!DOCTYPE html>
    <body>
        <?php
        if (isset($_POST['title']) && isset($_POST['content'])) {
            $title = $_POST['title'];
            $content = $_POST['content'];
            $pin= $_POST['pin'] ?? 0;
            try{
                //serialize category array to insert in db
                var_dump($_POST['category']);
                $category = serialize($_POST['category']);
                var_dump($category);
                // insert
                $date = date("Y-m-d");
                $userID = $_SESSION['id'];
                $pinned = (bool) $pin;
                $queryString = 'INSERT INTO Articles (title, content, category,date, userID, pinned) VALUES (:title, :content,:category,:date, :userID, :pinned)';
                $data = [
                    "title" => $title, 
                    "content" => $content,
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

                header("Location:./details.php?id=$idPost");
            }catch (Exception $e) {
                echo "Problem bro : ------> " . $e->getMessage();
                echo $_POST['content'];
            }
        }else{
            ?>
            <label>Required Title and Content please</label>
        <?php 
        }
        if (isset($_SESSION['user'])){?>
            <form method="POST">
                <div>
                    <button type="submit" name="sub" value="back" >BACK</button>
                </div>
                <h1>Create Post</h1>
                <div class="ui card centered" style="transform:scale(1); width:75%; margin-top:10%;">
                    <div class="content">
                        <div class="header">
                            <input type="text" name="title" id="title" placeholder="title ... ">
                        </div>
                        <div class="description">
                            <textarea  name="content" id="content" rows="7" placeholder="Tell us what you want ... "></textarea>
                        </div>
                    </div>
                    <div class="extra content">
                        <select name="category[]" class="ui selection dropdown" multiple="" id="multi-select">
                            <option value="">Categories</option>    
                            <option value="informatique">Informatique</option>
                            <option value="new">New</option>
                            <option value="anime">Anime</option>
                            <option value="event">Event</option>
                            <option value="test">Test</option>
                        </select>
                        <i class="thumbtack icon" style="margin-left:20%;"></i>
                        <input type="checkbox" name="pin" id="pin:"/>

                        <button type="submit" style="margin-left:90%;">Submit</button>
                    </div>
                </div>
                
            </form>        
        <?php
        }else{
            ?>
            <div>  
                <h1 class="Message">You are not connected</h1>
                <input  type="button" onclick="document.location='./register.php'" value="Register" class="lonelyBtn"/>  
                <input  type="button" onclick="document.location='./login.php'" value="Login" class="lonelyBtn"/>
            </div>
            <?php 
        }
        ?>
    </body>
<?php view('footer') ?>

<script>
        $(document).ready(function () {
            $('#multi-select')
                .dropdown();
        })
    </script>