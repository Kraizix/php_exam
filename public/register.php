<?php
require __DIR__.'/../src/bootstrap.php';
include '../config/db.php';

if(isset($_POST['login'])){
    header("Location:login.php");
}else if (isset($_POST['username'])) {
    $data =$_POST;
    if (empty($data['username'])||
        empty($data['password'])||
        empty($data['password2'])||
        empty($data['email'])) {
        $_SESSION['error'] ='Please fill all required fields';
        header("Location:register.php");
        exit;
    }
    $user = $data['username'];
    $password = $data['password'];
    $password2 = $data['password2'];
    if (preg_match('/[\'^£$%&*()}{@#~?><>,|=_+¬-]/', $user))
        {
            $_SESSION['error'] = 'Invalid username';
            header("Location:register.php");
            exit;
        }
    if ($password != $password2) {
        $_SESSION['error'] = 'Password mismatch';
        header("Location:register.php");
        exit;
    }
    $email = $data['email'];
    $image = "./content/default/default.png";
    $date = date("Y-m-d H:i:s");
    $options = [
        'cost' => 12,
    ];

    $result = $pdo->prepare("SELECT * from Users WHERE username = '$user'");
    $result->execute();
    if ($result->rowCount() != 0) {
        $_SESSION['error'] = "Username already taken";
        header("Location:register.php");
        exit;
    }
    $result = $pdo->prepare("SELECT * from Users WHERE mail = '$email'");
    $result->execute();
    if ($result->rowCount() != 0) {
        $_SESSION['error'] = "Email already taken";
        header("Location:register.php");
        exit;
    }
    
    try {
        $hash = password_hash($password,PASSWORD_BCRYPT,$options);
        $query= "INSERT INTO Users(username,pass,mail,joinDate,image) VALUES (:username, :pass, :mail, :joinDate, :image)";
        $datas = [
            "username" => $user,
            "pass" => $hash,
            "mail" => $email,
            "joinDate" => $date,
            "image" => $image
        ];

        $results = $pdo->prepare($query);
        $results->execute($datas);
    }catch (PDOException $e){
        echo "Error: " . $query . "<br>" . $pdo->error;
        exit;
    }
    echo "Inserted successfully";
    header("Location:login.php");
}

?>

<?php view('header', ['title' => 'Register']) ?>
<body>
    <form method="POST">
        <h1>Register Page</h1>
        <div>
            <label for="username">Username:</label>
            <input type="text" name="username" id="username" maxlength="20">
        </div>
        <div>
            <label for="email">Email:</label>
            <input type="email" name="email" id="email" maxlength="255">
        </div>
        <div>
            <label for="password">Password:</label>
            <input type="password" name="password" id="password" maxlength="255">
        </div>
        <div>
            <label for="password2">Confirm Password:</label>
            <input type="password" name="password2" id="password2" maxlength="255">
        </div>
        <?php if (isset($_SESSION['error'])) { ?>
            <a> <?= $_SESSION['error'] ?> </a>
        <?php 
            unset($_SESSION['error']);
        }?>
        <button type="submit">Register</button>
        <a href="login.php">I already have an account</a>
    </form>
<?php view('footer') ?>