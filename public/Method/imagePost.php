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
        $queryString = "SELECT * FROM Users WHERE id = " . $userID;
        $query = $pdo->prepare($queryString);
        $query->execute();
        $user=$query->fetch();
        return $user;
    }

    function getImgDirectory(int $id,$file,$pdo){
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
        return $fname;
    }