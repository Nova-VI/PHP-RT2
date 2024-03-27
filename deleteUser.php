<?php
$username = $_GET['username'];
session_start();
require 'connexion.php';
$cnx = ConnexionBD::getInstance();
$query = "select * from users where username = '$username'";
$user = $cnx->query($query)->fetch(PDO::FETCH_ASSOC);
unlink($user['profile_image']);
$query = "delete from users where username = '$username'";
$cnx->query($query);
$query = "select * from users";
$users = $cnx->query($query)->fetchAll(PDO::FETCH_ASSOC);
$_SESSION['users'] = $users;
