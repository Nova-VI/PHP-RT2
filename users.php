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

<style>
    .content ul {
        display: flex;
        flex-direction: column;
    }

    .content ul li {
        margin: 5px;
        display: flex;
        justify-content: space-between;
        align-items: center;
        flex-direction: row;
        text-align: center;
        font-weight: 500;
        cursor: pointer;
        transition: 0.5s;
        color: black;
        border: 2px solid #222327;
    }

    .content ul li:hover {
        background-color: black;
        color: white;
    }

    .content ul li:hover span.final button {
        background-color: red;
    }

    .content ul li span {
        flex-basis: 0;
        flex-grow: 1;
        display: flex;
        flex-direction: row;
        align-items: center;
    }

    .content ul li span.final {
        display: flex;
        justify-content: center;
    }

    .content ul li span.final button {
        background-color: black;
        color: white;
        border: none;
        border-radius: 10px;
        margin: 0 40px;
        width: 100px;
        display: flex;
        justify-content: center;
        cursor: pointer;
        transition: .5s;
    }

    .content ul li span.final button:hover {
        width: 150px;
    }

    .content ul li span img {
        float: left;
        width: 75px;
        height: 75px;
        border-radius: 50%;
        margin: 10px 20px 10px 10px;
    }

    .content ul li span ion-icon {
        font-size: 75px;
        float: left;
        margin: 10px 20px 10px 10px;
    }

    .content ul li span.final ion-icon {
        font-size: 20px;
        margin: 10px 10px 10px 10px;
    }

    .content .search {
        display: flex;
        justify-content: center;
        align-items: center;
        flex-direction: column;
    }

    .content .search input {
        width: 70%;
        height: 60px;
        border: 3px solid #222327;
        border-radius: 10px;
        font-size: 1.5em;
        margin: 20px;
        text-align: center;
        transition: .5s;
    }

    .content .search input:hover,
    .content .search input:focus {
        width: 80%;
    }
</style>