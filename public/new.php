<?php
require __DIR__.'/../src/bootstrap.php';
?>
<!DOCTYPE html>
<?php view('header', ['title' => 'New']) ?>
    <body>
        <?php
        if (isset($_SESSION['user'])){?>
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
                <div>
                    <label for="pin">Pin</label>
                    <input type="checkbox" name="pin" id="pin:"/>
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
                        $pin= $_POST['pin'] ?? 0
                    
                    
                    ?> 
                        <br>
                        
                        <?php 

                        try{
                            $queryString = "INSERT INTO Articles (title, content, date, userID, pinned) VALUES (:title, :content, :date, :userID, :pinned)";
                            
                            $data = [
                                'title' => $title,
                                'content' => $content,
                                //'category' => $category
                                'date' => date("Y-m-d"),
                                'userID' => $_SESSION['user'],
                                'pinned' => (bool) $pin
                            ];

                            $query = $mysqli->prepare($queryString);
                            $query->execute($data);

                            header("Location:./home.php");
                        }catch (Exception $e) {
                            
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