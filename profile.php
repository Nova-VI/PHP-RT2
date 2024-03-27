<?php
session_start();
if (!isset($_SESSION['user'])) {
    header("Location: index.php");
}
if (isset($_SESSION['users'])) {
    $users = $_SESSION['users'];
} else {
    require 'connexion.php';
    $cnx = ConnexionBD::getInstance();
    $query = "select * from users";
    $users = $cnx->query($query)->fetchAll(PDO::FETCH_ASSOC);
    $_SESSION['users'] = $users;
}
if (isset($_GET['username']) && $_SESSION['user_type'] == "admin" && $_GET['username'] != "") {
    $username = $_GET['username'];
} else {
    $username = $_SESSION['user'];
}
foreach ($users as $u) {

    if (strcmp($u['username'], $username) == 0) {
        $user = $u;
        break;
    }
}
?>
<div class="table-container">
    <table>
        <tr>
            <td colspan="3" style="text-align: center;font-size:200px" ;>
                <?php if ($user['profile_image'] != "") : ?>
                    <img src=" <?php echo $user['profile_image'] ?>" alt="">
                <?php else : ?>
                    <ion-icon name="person-outline"></ion-icon>
                <?php endif; ?>
            </td>
        </tr>
        <tr>
            <th>username</th>
            <td id="username"><?php echo $user["username"] ?> </td>
            <td id="username-icon"><button onclick='changeUsername()'><ion-icon name="create-outline"></ion-icon></button></td>
        </tr>
        <tr>
            <th>email</th>
            <td id="email"><?php echo $user['email'] ?></td>
            <td id="email-icon"><button onclick='changeEmail()'><ion-icon name="create-outline"></ion-icon></button></td>
        </tr>
        <tr>
            <th>birthday</th>
            <td id="bday"><?php echo $user['birth_date'] ?></td>
            <td id="bday-icon"><button onclick='changeBday()'><ion-icon name="create-outline"></ion-icon></button></td>
        </tr>
        <?php if ($user['role'] == "admin") : ?>
            <tr>
                <th colspan="3" style="text-align:center;padding:20px;font-size:2em;">This user is an admin.</th>
            </tr>
        <?php endif; ?>
    </table>
</div>

<style>
    .table-container {
        display: flex;
        justify-content: center;
    }

    table tr td img {
        width: 200px;
        height: 200px;
        border-radius: 50%;
        margin: 35px;
    }

    table tr th {
        text-align: left;
        font-size: 1.5em;
        padding: 10px 30px;
    }

    table tr td {
        font-size: 1.5em;
        padding: 0 30px;
    }

    table tr td button {
        background-color: transparent;
        border: none;
        cursor: pointer;
        font-size: 1.5em;
        outline: none;
    }
</style>

<script>
    function changeBday() {
        let bday = document.getElementById('bday').innerText;
        let newBday = prompt("Enter the new birthday", bday);
        if (newBday != null && newBday != "") {
            let xhr = new XMLHttpRequest();
            xhr.open("POST", "profile_update.php", true);
            xhr.setRequestHeader("Content-Type", "application/x-www-form-urlencoded");
            xhr.onreadystatechange = function() {
                if (xhr.readyState == 4 && xhr.status == 200) {
                    if (xhr.responseText == "")
                        document.getElementById('bday').innerText = newBday;
                    else
                        alert(xhr.responseText);
                }
            }
            xhr.send("username=<?php echo $user['username'] ?>&bday=" + newBday);
        }
    }

    function changeUsername() {
        let username = document.getElementById('username').innerText;
        let newUsername = prompt("Enter the new username", username);
        if (newUsername != null && newUsername != "") {
            let xhr = new XMLHttpRequest();
            xhr.open("POST", "profile_update.php", true);
            xhr.setRequestHeader("Content-Type", "application/x-www-form-urlencoded");
            xhr.onreadystatechange = function() {
                if (xhr.readyState == 4 && xhr.status == 200) {
                    if (xhr.responseText != "")
                        alert(xhr.responseText);
                    else
                        document.getElementById('username').innerText = newUsername;
                }
            }
            xhr.send("username=" + encodeURIComponent(username) + "&newUsername=" + encodeURIComponent(newUsername));
        }
    }

    function changeEmail() {
        let email = document.getElementById('email').innerText;
        let newEmail = prompt("Enter the new email", email);
        if (newEmail != null && newEmail != "") {
            let xhr = new XMLHttpRequest();
            xhr.open("POST", "profile_update.php", true);
            xhr.setRequestHeader("Content-Type", "application/x-www-form-urlencoded");
            xhr.onreadystatechange = function() {
                if (xhr.readyState == 4 && xhr.status == 200) {
                    if (xhr.responseText != "")
                        alert(xhr.responseText);
                    else
                        document.getElementById('email').innerText = newEmail;
                }
            }
            let params = "username=<?php echo urlencode($user['username']) ?>&email=" + encodeURIComponent(newEmail);
            xhr.send(params);
        }
    }
</script>