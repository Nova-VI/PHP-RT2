<?php

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    session_start();
    $errors = array();
    $email = htmlspecialchars($_GET["email"]);
    $password = htmlspecialchars($_GET["password"]);


    if (empty($email)) {
        $errors["email"] = "email is required";
    }
    if (empty($password)) {
        $errors["password"] = "password is required";
    }
    if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        $errors["email"] = "enter a valid email";
    }
    if ($errors) {
        foreach ($errors as $error) {
            echo " - " . $error . "<br>";
        }
    } else {
        require "connexion.php";
        $bdd = ConnexionBd::getInstance();

        $query = "SELECT * FROM users WHERE email=:email";

        $stmt = $bdd->prepare($query);
        $stmt->execute(array(':email' => $email));
        $result = $stmt->fetchAll();


        if (!$result) {
            echo "Email does not exist.";
        } else {
            if (!password_verify($password, $result[0]["password"])) {
                echo "Wrong password.";
            } else {
                $_SESSION["user"] = $result[0]["username"];
                $_SESSION["user_type"] = $result[0]["role"];
                $_SESSION["user_entity"] = $result[0];
                header("Location: index.php");
                exit();
            }
        }
    }
}
