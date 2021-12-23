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
        die('Please fill all required fields');
    }
    $user = $data['username'];
    $password = $data['password'];
    $password2 = $data['password2'];
    if ($password != $password2) {
        die('Password mismatch');
    }
    $email = $data['email'];
    $image = "./content/default/default.png";
    $date = date("Y-m-d H:i:s");
    $options = [
        'cost' => 12,
    ];
    
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
        <a href="login.php">I already have an account</a>
    </form>
<?php view('footer') ?>