<?php


//
//if(isset($_SESSION["PHPSESSID"])){
//    header("Location:profile.html");
//    die();
//}


if ($_SERVER["REQUEST_METHOD"] == "POST") {
    session_start();
    $errors = array();
    $username = htmlspecialchars($_POST["username"]);
    $email = htmlspecialchars($_POST["email"]);
    $password = htmlspecialchars($_POST["password"]);
    $cpassword = htmlspecialchars($_POST["cpassword"]);
    $birthdate = htmlspecialchars($_POST["birth"]);
    $filename = '';
    if (empty($username)) {
        $errors['username'] = "Username is required";
    }
    if (empty($email)) {
        $errors['email'] = "email is required";
    } else if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        $errors['email'] = 'enter a valid email';
    }
    $pattern = '/^(?=.*[a-z])(?=.*[A-Z])(?=.*\d)(?=.*[^\w\s]).{8,}$/';

    if (!preg_match($pattern, $password)) {
        $errors['password'] = "Password too weak , passwords should be at least 8 chars long , with one lower case, one upper case, one number and one special char";
    }
    if ($_POST["password"] != $_POST["cpassword"]) {
        $errors['cpassword'] = "Password should match";
    }
    if (empty($birthdate)) {
        $errors['birthdate'] = "please enter a valid brith date";
    }
    $image_error = null;
    if (isset($_FILES["profileimage"]) && $_FILES["profileimage"]["error"] == 0) {
        $allowed_extensions = array("jpg", "jpeg", "png", "gif");
        $temp = explode(".", $_FILES["profileimage"]["name"]);
        $extension = end($temp);
        if (in_array($extension, $allowed_extensions)) {
            // Generate a unique filename to prevent overwriting existing files
            $filename = uniqid() . "." . $extension;
        } else {
            $errors['extension'] = "Invalid image extension. Allowed extensions: " . implode(", ", $allowed_extensions);
        }
    } else {
        $image_error = 'You haven\'t upload a profile picture (optional) ';
    }

    if ($errors) {
        foreach ($errors as $error) {
            echo " - " . $error . "<br>";
        }
        if ($image_error) {
            echo " - " . $image_error . "<br>";
        }
    } else {
        include 'connexion.php';
        $bdd = ConnexionBd::getInstance();
        $query = "SELECT * FROM users WHERE email=:email";

        $stmt = $bdd->prepare($query);
        $stmt->execute(array(':email' => $email));
        $result = $stmt->fetchAll();

        $num_rows = count($result);

        $query = "SELECT * FROM users WHERE username=:username";

        $stmt = $bdd->prepare($query);
        $stmt->execute(array(':username' => $username));
        $result = $stmt->fetchAll();

        $num_rows2 = count($result);
        if ($num_rows2 > 0) {
            echo "- Username already exists<br>";
        } else if ($num_rows > 0) {
            echo "- Email already exists <a href ='#' onclick='setActive(list[1])'>login instead?</a>";
        } else {
            $hash = password_hash($password, PASSWORD_DEFAULT);
            $id = bin2hex(random_bytes(16));
            $query = "INSERT INTO `users` ( `id`,`username`,  
                `email`,`password`,`profile_image`,`birth_date`,`role`) VALUES (:id,:username,  
                :email, :password ,:image,:birthdate,:role)";

            $stmt = $bdd->prepare($query);
            $role = 'user';
            if ($filename != '') {
                $uploadDir = 'images/';
                $uploadedFile = $_FILES['profileimage']['tmp_name'];
                $destinationFile = $uploadDir . $filename;
                if (!is_dir($uploadDir)) {
                    mkdir($uploadDir, 0777, true);
                }
                move_uploaded_file($uploadedFile, $destinationFile);
                $filename = $destinationFile;
            }
            if ($stmt->execute(array(':id' => $id, ':email' => $email, ':username' => $username, ':password' => $hash, ':image' => $filename, ':birthdate' => $birthdate, ':role' => $role))) {
                $query = "SELECT * FROM users WHERE email=:email";

                $stmt = $bdd->prepare($query);
                $stmt->execute(array(':email' => $email));
                $result = $stmt->fetchAll();
                $_SESSION["user"] = $username;
                $_SESSION["user_type"] = $role;
                header("Location: index.php");
                exit();
            } else {
                echo "An error has occurred. Please try again.";
            }
        }
    }
}
