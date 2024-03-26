<?php

if($_SERVER["REQUEST_METHOD"]=="POST"){
    session_start();
    $errors=array();
    $email = htmlspecialchars($_POST["email"]);
    $password = htmlspecialchars($_POST["password"]);


    if(empty($email)){
        $errors["email"]="email is required";
    }
    if(empty($password)){
        $errors["password"]="password is required";
    }
    if(!filter_var($email,FILTER_VALIDATE_EMAIL)){
       $errors["email"]="enter a valid email";
    }
    if($errors){
        $_SESSION["errors"]=$errors;
        header("Location: login.php");
        exit();
    }
    else {
        require "db.inc.php";

        $bdd = ConnexionBd::getInstance();

        $query = "SELECT * FROM users WHERE email=:email";

        $stmt = $bdd->prepare($query);
        $stmt->execute(array(':email' => $email));
        $result = $stmt->fetchAll();


        if (!$result) {
           $errors["credentials"]="Wrong credentials";
            header("Location: ../html/login.php");
            exit();
        } else {
            if (!password_verify($password, $result[0]["password"])) {
                die ("incorrect credentials");
            } else {
                $_SESSION["user"]="user";
                $_SESSION["user-type"]=$result["role"];
                $_SESSION["user-entity"]=$result;
                header("Location:../html/profile.html");
            }
        }
    }
}