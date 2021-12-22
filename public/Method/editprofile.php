<?php
    function rrmdir($dir) { 
        if (is_dir($dir)) { 
        $objects = scandir($dir);
        foreach ($objects as $object) { 
            if ($object != "." && $object != "..") { 
            if (is_dir($dir. DIRECTORY_SEPARATOR .$object) && !is_link($dir."/".$object))
                rrmdir($dir. DIRECTORY_SEPARATOR .$object);
            else
                unlink($dir. DIRECTORY_SEPARATOR .$object); 
            } 
        }
        rmdir($dir); 
        } 
    }
    
    function getUserByID(int $userID, $pdo){
        $queryString = "SELECT * FROM users WHERE id = " . $userID;
        $query = $pdo->prepare($queryString);
        $query->execute();
        $user=$query->fetch();
        return $user;
    }

    function updateUser(int $id,$file,string $username,string $desc,string $email,string $password,$pdo){
        $user = getUserByID($id,$pdo);
        //echo print_r($user);
        $fname= "";
        if (!is_uploaded_file($file['tmp_name'])){
            $fname = $user['image'];
        } else {
            try{
                rrmdir('./content/'.$_SESSION['id'].'/');
            } catch(Exception $e){
                //echo $e;
            }
            mkdir('./content/'.$_SESSION['id'].'/');
            $tmpName = $file['tmp_name'];
            $name = $file['name'];
            move_uploaded_file($tmpName,'./content/'.$_SESSION['id'].'/'.$name);
            $fname='./content/'.$_SESSION['id'].'/'.$name;
        }
        if ($username == ""){
            $username = $user['username'];
        }
        if ($desc == ""){
            $desc = $user['description'];
        }
        if ($email == ""){
            $email = $user['mail'];
        }
        if ($password == ""){
            $password = $user['pass'];
        } else {
            $options = [
                'cost' => 12,
            ];
            $password = password_hash($password,PASSWORD_BCRYPT,$options);
        }
        //echo "";
        //echo $username,$password,$desc,$email,$fname;
        $queryString = "UPDATE users SET username = '$username', mail = '$email', pass = '$password', image = '$fname', description = '$desc' WHERE id='$id'";
        //echo($queryString);
        $query = $pdo->prepare($queryString);
        $query->execute();
        $_SESSION['user'] = $username;
    }