<?php
require __DIR__.'/../src/bootstrap.php';
if (is_post_request()) {
    $conn = new mysqli("localhost", "root", "", "php_exam_db");
    $data =$_POST;
    if (empty($data['username'])||
        empty($data['password'])||
        empty($data['password2'])||
        empty($data['email'])) {
        die('Please fill all required fields');
    }
    $user = $data['username'];
    $password = $data['password'];
    $password2 = $data['password2'];
    $email = $data['email'];
    $options = [
        'cost' => 12,
    ];
    $hash = password_hash($password,PASSWORD_BCRYPT,$options);
    $sql= "INSERT INTO users(username,pass,mail) VALUES ('$user','$hash','$email')";
    if ($conn->query($sql)=== TRUE) {
        echo "Inserted successfully";
        header("Location: http://localhost/php_exam/login.php");
        die();
    } else {
        echo "Error: " . $sql . "<br>" . $conn->error;
    }
    $conn->close();
}

?>

<?php view('header', ['title' => 'Register']) ?>
<body>
    <form action="register.php" method="POST">
        <h1>Register Page</h1>
        <div>
            <label for="username">Username:</label>
            <input type="text" name="username" id="username">
        </div>
        <div>
            <label for="email">Email:</label>
            <input type="email" name="email" id="email">
        </div>
        <div>
            <label for="password">Password:</label>
            <input type="password" name="password" id="password">
        </div>
        <div>
            <label for="password2">Confirm Password:</label>
            <input type="password" name="password2" id="password2">
        </div>
        <button type="submit">Register</button>
    </form>
<?php view('footer') ?>