<?php
require __DIR__.'/../src/bootstrap.php';
include '../Config/db.php';

if (isset($_POST['username'])) {
    echo "HERE";
    $user = $_POST['username'];
    $password = $_POST['password'];
    try{
        $query = 'SELECT * FROM Users WHERE username="'.$user.'"';
        $results = $pdo->prepare($query);
        $results->execute();

        $currentUser=$results->fetch();

        $hash = $currentUser["pass"];
        if (password_verify($password,$hash)){
            echo "Login successful!";
            if(!isset($_SESSION)) 
            { 
                session_start(); 
            } 
            $_SESSION['user'] = $user;
            $_SESSION['admin'] = $currentUser['admin'];
            $_SESSION['id'] = $currentUser['id'];
            header("Location: index.php");
            die();
        } else {
            echo "Login failed: wrong password";
        }
        
    }catch (PDOException $e){
        echo "No User with this name";
    }
    
}

?>

<?php view('header', ['title' => 'Login']) ?>
<body>
    <form action="login.php" method="POST">
        <h1>Login Page</h1>
        <div>
            <label for="username">Username:</label>
            <input type="text" name="username" id="username">
        </div>
        <div>
            <label for="password">Password:</label>
            <input type="password" name="password" id="password">
        </div>
        <button type="submit">Login</button>
    </form>
<?php view('footer') ?>