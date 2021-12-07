<?php
require __DIR__.'/../src/bootstrap.php';
if (is_post_request()) {
    $conn = new mysqli("localhost", "root", "", "php_exam_db");
    $user = $_POST['username'];
    $password = $_POST['password'];
    $result = $conn->query("SELECT pass FROM users WHERE username='{$user}'");
    $row = mysqli_fetch_row($result);
    echo print_r($row);
    $hash = $row[0];
    if (password_verify($password,$hash)){
        echo "Login successful!";
        if(!isset($_SESSION)) 
        { 
            session_start(); 
        } 
        $_SESSION['user'] = $user;
        header("Location: http://localhost/php_exam/index.php");
        die();
    } else {
        echo "Login failed";
    }
    $conn->close();
}

?>

<?php view('header', ['title' => 'Register']) ?>
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