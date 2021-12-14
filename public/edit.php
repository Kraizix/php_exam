<?php
require __DIR__.'/../src/bootstrap.php';

$dbName = "forum_php";

$dsn = "mysql:host=localhost:3306;dbname=" . $dbName;
$username = "root";
$password = "";

try{
    $pdo = new PDO($dsn, $username, $password);
} catch (PDOException $e){
    echo "ERROR";
    echo $e->getMessage();
die();
}

?>
<!DOCTYPE html>
<?php view('header', ['title' => 'New']) ?>
    <body>
        <?php
        if (isset($_SESSION['user'])){
            $query = "SELECT * FROM Articles WHERE id = " . $_SESSION["Post_id"];
            $results = $mysqli->prepare($query);
            $results->execute();
            $post=$results->fetchAll();
            ?>

            <form method="POST">
                <h1>Create Post</h1>
                <div>
                    <input type="text" name="title" id="title" placeholder="title ... ">
                </div>
                <div>
                    <input type="text" name="content" id="content" placeholder="Tell us what you want ... ">
                </div>
                <div>
                    <label for="category">Category:</label>
                    <!--Dropdown style VALENTIN -->
                    <input type="text" name="category" id="category:">
                </div>
                <button type="submit">Submit</button>
            </form>
            <?php
                $error=false;
                if (isset($_POST['title']) && isset($_POST['content'])) {
                    ?>
                <?php
                    session_start();
                        $title = $_POST['title'];
                        $content = $_POST['content'];
                    
                    
                    ?> 
                        <br>
                        
                        <?php 

                        try{

                            //$queryString = "UPDATE Articles SET (title, description, date, author) VALUES (:title, :description, :date, :author)";
                            
                            $data = [
                                'title' => $title,
                                'description' => $content,
                                'date' => date("Y-m-d"),
                                'author' => $_SESSION['user']
                            ];

                            $query = $mysqli->prepare($queryString);
                            $query->execute($data);

                            header("Location:./home.php");
                        }catch (Exception $e){
                            $error=true;
                            ?>
                            <label>This  exist</label>
                            <?php
                        }
                    }else{
                        ?>
                        <label>Required Title and Content please</label>
                        <?php 
                    }?>
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