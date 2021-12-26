<?php
require __DIR__.'/../src/bootstrap.php';
include '../config/db.php';

if ($_SESSION['admin']==1){
    header('Location:adminPanel.php');
    exit();
}
if (isset($_POST['username']) && isset($_POST['password'])) {

    $user = $_POST['username'];
    $password = $_POST['password'];
    try{
        $query = 'SELECT * FROM Users WHERE admin="1"';
        $results = $pdo->prepare($query);
        $results->execute();

        $admin=$results->fetch();

        $hash = $admin["pass"];
        if ( $user == $admin["username"] && password_verify($password,$hash)){
            echo "Login successful!";
            $_SESSION['admin'] = true;
            header("Location: adminPanel.php");
            die();
        } else {
            echo "Login failed: wrong password";
        }
        
    }catch (PDOException $e){
        print_r($e->getMessage());
    }
    
}

?>
<?php view('header', ['title' => 'Login']) ?>
<body>
    <form method="POST">
        <h1>Login Admin</h1>
        <div>
            <label for="username">Username:</label>
            <input type="text" name="username" id="username">
        </div>
        <div>
            <label for="password">Password:</label>
            <input type="password" name="password" id="password">
        </div>
        <button type="submit">Upgrade</button>
    </form>
<?php view('footer') ?>