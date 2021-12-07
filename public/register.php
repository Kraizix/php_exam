<?php
require __DIR__.'/../src/bootstrap.php';
if (is_post_request()) {
    $conn = new mysqli("localhost", "root", "", "php_exam_db");
    $user = $_POST['username'];
    $password = $_POST['password'];
    $password2 = $_POST['password2'];
    $email = $_POST['email'];
    $options = [
        'cost' => 12,
    ];
    $hash = password_hash($password,PASSWORD_BCRYPT,$options);
    $sql= "INSERT INTO users(username,pass,mail) VALUES ('$user','$hash','$email')";
    if ($conn->query($sql)=== TRUE) {
        echo "Inserted successfully";
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
            <label for="password2">Password Again:</label>
            <input type="password" name="password2" id="password2">
        </div>
        <button type="submit">Register</button>
    </form>
<?php view('footer') ?>