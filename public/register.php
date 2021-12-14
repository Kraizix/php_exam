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

if (isset($_POST['username'])) {
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
    
    try {
        $hash = password_hash($password,PASSWORD_BCRYPT,$options);
        $query= "INSERT INTO users(username,pass,mail) VALUES ('$user','$hash','$email')";
        $results = $pdo->prepare($query);
        $results->execute();
    }catch (PDOException $e){
        echo "Error: " . $query . "<br>" . $pdo->error;
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
    </form>
<?php view('footer') ?>