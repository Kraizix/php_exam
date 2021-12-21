<?php
require __DIR__.'/../src/bootstrap.php';
include '../config/db.php';


if (isset($_POST['sub'])){
    header("Location:http://localhost:8080/home.php");
    exit();
}
?>
<!DOCTYPE html>
<?php view('header', ['title' => 'New']) ?>
    <body>
        <?php
        if (isset($_POST['title']) && isset($_POST['content'])) {
            $title = $_POST['title'];
            $content = $_POST['content'];
            $pin= $_POST['pin'] ?? 0;

            try{
                //serialize category array to insert in db
                $catArray = explode(',', $_POST['category']);
                $category = serialize($catArray);
                // insert
                $date = date("Y-m-d");
                $userID = $_SESSION['id'];
                $pinned = (bool) $pin;
                $queryString = 'INSERT INTO Articles (title, content, category,date, userID, pinned) VALUES (:title, :content, :category,:date, :userID, :pinned)';
                $data = [
                    "title" => $title, 
                    "content" => $content,
                    "category" => $category,
                    "date" => $date,
                    "userID" => $userID,
                    "pinned" => $pinned
                ];

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
                <div>
                    <input type="text" name="title" id="title" placeholder="title ... ">
                </div>
                <div>
                    <input type="text" name="content" id="content" placeholder="Tell us what you want ... ">
                </div>
                <div>
                    <!--Dropdown style VALENTIN -->

                    <label for="category">Category:</label>
                    <select name="category" id="category">
                        <option value="">--Please choose an category--</option>
                        <option value="informatique">Informatique</option>
                        <option value="new">New</option>
                        <option value="anime">Animé</option>
                        <option value="event">Evènement</option>
                        <option value="test">TEST</option>
                    </select>
                </div>
                <div>
                    <label for="pin">Pin</label>
                    <input type="checkbox" name="pin" id="pin:"/>
                </div>
                <button type="submit">Submit</button>
                
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