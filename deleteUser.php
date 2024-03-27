<?php
$username = $_GET['username'];
echo $username;
session_start();
require 'connexion.php';
$cnx = ConnexionBD::getInstance();
$query = "delete from users where username = '$username'";
$cnx->query($query);
$query = "select * from users";
$users = $cnx->query($query)->fetchAll(PDO::FETCH_ASSOC);
$_SESSION['users'] = $users;
