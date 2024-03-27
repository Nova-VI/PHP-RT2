<?php
require 'connexion.php';
session_start();
if (isset($_SESSION['users']) && isset($_SESSION['tasks'])) {
    $users = $_SESSION['users'];
    $tasks = $_SESSION['tasks'];
} else {
    $cnx = ConnexionBD::getInstance();
    $query = "select * from users";
    $users = $cnx->query($query)->fetchAll(PDO::FETCH_ASSOC);
    $query = "select * from Task";
    $tasks = $cnx->query($query)->fetchAll(PDO::FETCH_ASSOC);
    $_SESSION['users'] = $users;
    $_SESSION['tasks'] = $tasks;
}
?>

<div class="search">
    <input type="text" id="inputField" placeholder="Type here to search" onkeyup="filterAccounts()">
</div>
<div class="users" id="users"></div>


<script>
    function filterAccounts() {
        var inputText = document.getElementById('inputField').value;

        var xhr = new XMLHttpRequest();
        xhr.open('POST', 'filterUser.php', true);
        xhr.setRequestHeader('Content-Type', 'application/x-www-form-urlencoded');
        xhr.send('input=' + inputText);

        xhr.onreadystatechange = function() {
            if (xhr.readyState === XMLHttpRequest.DONE) {
                document.getElementById('users').innerHTML = xhr.responseText;
            }
        };
    }

    function deleteUser(username) {
        xhr = new XMLHttpRequest();
        xhr.open('GET', 'deleteUser.php?username=' + username, true);
        xhr.setRequestHeader('Content-Type', 'application/x-www-form-urlencoded');
        xhr.send();
        xhr.onreadystatechange = function() {
            if (xhr.readyState === XMLHttpRequest.DONE) {
                filterAccounts();
            }
        };
    }
    filterAccounts();
</script>