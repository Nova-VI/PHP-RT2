<?php
function check_birthday($bday)
{
    $bday = explode('-', $bday);
    if (count($bday) != 3) {
        return false;
    }
    if (!checkdate($bday[1], $bday[2], $bday[0])) {
        return false;
    }
    return true;
}
function check_username($username, $cnx)
{
    $query = "select count(*) from users where username=:username";
    $query = $cnx->prepare($query);
    $query->execute(['username' => $username]);
    $result = $query->fetchColumn();
    if ($result > 0) {
        return false;
    }
    return true;
}
function check_email($email, $cnx)
{
    $query = "select count(*) from users where email=:email";
    $query = $cnx->prepare($query);
    $query->execute(['email' => $email]);
    $result = $query->fetchColumn();
    if ($result > 0) {
        return false;
    }
    return true;
}
function valid_email($email)
{
    if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        return false;
    }
    return true;
}
session_start();
if (!isset($_SESSION['user'])) {
    header("Location: index.php");
}
require 'connexion.php';
$cnx = ConnexionBD::getInstance();



$username = urldecode($_POST["username"]);
if (isset($_POST['newUsername'])) {
    $newUsername = urldecode($_POST['newUsername']);
    if (!check_username($newUsername, $cnx)) {
        echo "Username already exists.";
        return;
    }
    $query = "update users set username=:newUsername where username=:username";
    $query = $cnx->prepare($query);
    $query->execute(['newUsername' => $newUsername, 'username' => $username]);
    if ($username == $_SESSION['user']) {
        $_SESSION['user'] = $newUsername;
    }
}
if (isset($_POST['email'])) {
    $email = urldecode($_POST['email']);
    if (!valid_email($email)) {
        echo "Invalid email.";
        return;
    }
    if (!check_email($email, $cnx)) {
        echo "Email already exists.";
        return;
    }
    $query = "update users set email=:email where username=:username";
    $query = $cnx->prepare($query);
    $query->execute(['email' => $email, 'username' => $username]);
}
if (isset($_POST['bday'])) {
    if (!check_birthday(urldecode($_POST['bday']))) {
        echo "Invalid birthday.";
        return;
    }
    $bday = urldecode($_POST['bday']);
    $query = "update users set birth_date=:bday where username=:username";
    $query = $cnx->prepare($query);
    $query->execute(['bday' => $bday, 'username' => $username]);
}
$query = "select * from users";
$users = $cnx->query($query)->fetchAll(PDO::FETCH_ASSOC);
$_SESSION['users'] = $users;
