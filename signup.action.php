<?php


//
//if(isset($_SESSION["PHPSESSID"])){
//    header("Location:profile.html");
//    die();
//}


if($_SERVER["REQUEST_METHOD"]=="POST"){
    require_once 'session_config.inc.php';
    $errors=array();
    $username = htmlspecialchars($_POST["username"]);
    $email = htmlspecialchars($_POST["email"]);
    $password = htmlspecialchars($_POST["password"]);
    $cpassword = htmlspecialchars($_POST["cpassword"]);
    $birthdate = htmlspecialchars($_POST["birth"]);
    $filename = '';
    if(empty($username)){
        $errors['username'] = "Username is required";
    }
    if(empty($email)){
        $errors['email'] = array('require'=>'email is required');
    }
    if(!filter_var($email,FILTER_VALIDATE_EMAIL)){
        $errors['email']['format']='enter a valid email';
    }
    $pattern = '/^(?=.*[a-z])(?=.*[A-Z])(?=.*\d)(?=.*[^\w\s]).{8,}$/';

    if(!preg_match($pattern,$password)){
        $errors['password']="Password too weak , passwords should be at least 8 chars long , with one lower case, one upper case, one number and one special char";
    }
    if($_POST["password"]!=$_POST["cpassword"]){
        $errors['cpassword']="Password should match";
    }
    if(empty($birthdate)){
        $errors['birthdate']="please enter a valid brith date";
    }

    if (isset($_FILES["profileimage"]) && $_FILES["profileimage"]["error"] == 0) {
        $allowed_extensions = array("jpg", "jpeg", "png", "gif");
        $temp = explode(".", $_FILES["profileimage"]["name"]);
        $extension = end($temp);
        if (in_array($extension, $allowed_extensions)) {
            // Generate a unique filename to prevent overwriting existing files
            $filename = uniqid() . "." . $extension;
            move_uploaded_file($_FILES["profileimage"]["tmp_name"],"../assets/images/" . $filename);
            echo "Image uploaded successfully:../assets/images/" . $filename;
        }

     else {
        $errors['extension']="Invalid file extension. Allowed extensions: " . implode(", ", $allowed_extensions);
     }

    } else {
        $errors['image']='error uploading the file';
    }

    if($errors){
        $_SESSION["errors"]=$errors;
        header("Location: signup.php");
        exit();
    }

    else {
        include 'connexion.php';
        $bdd = ConnexionBd::getInstance();
        $query = "SELECT * FROM users WHERE email=:email";

        $stmt = $bdd->prepare($query);
        $stmt->execute(array(':email' => $email));
        $result = $stmt->fetchAll();

        $num_rows = count($result);

        if ($num_rows> 0) {
            $errors["exist"]="email already exists";
            $_SESSION["errors"]=$errors;
            header("Location: signup.php");
            exit();
        }
        else {
            $hash = password_hash($password,
                PASSWORD_DEFAULT);
            $id = bin2hex(random_bytes(16));
            $query = "INSERT INTO `users` ( `id`,`username`,  
                `email`,`password`,`image`,`birthdate`,`role`) VALUES (:id,:username,  
                :email, :password ,:image,:birthdate,:role)";

            $stmt = $bdd->prepare($query);
            $role='user';
            if ($stmt->execute(array(':id' => $id, ':email' => $email, ':username' => $username, ':password' => $hash, ':image' => $filename, ':birthdate' => $birthdate, ':role' => $role))) {
              $query = "SELECT * FROM users WHERE email=:email";

                $stmt = $bdd->prepare($query);
                $stmt->execute(array(':email' => $email));
                $result = $stmt->fetchAll();
                $_SESSION["user"] = "user";
                $_SESSION["user_type"] = $role;
                header("Location: index.php");
                exit();
            } else {
                // If an error occurred during insertion
                $errors["fetch"] = "an error has occurred";
                $_SESSION["errors"] = $errors;
                header("Location: signup.php");
                exit();
            }

        }
    }
}
