<?php
function generate_element($url, $icon, $text)
{
    echo "
    <li class=\"list\">
        <a  value=\"$url\">
            <span class=\"icon\"><ion-icon name=\"$icon\"></ion-icon></span>
            <span class=\"text\">$text</span>
        </a>
    </li>";
}
session_start();
$_SESSION['user'] = "admin";
$_SESSION['user_type'] = "admin";
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <link rel="stylesheet" href="styles.css">
</head>

<body>
    <div class="top">
        <div class="navigation">
            <?php
            if (isset($_SESSION['user']) && $_SESSION['user_type'] == "admin") {
                echo "<ul id=\"navListAdmin\">"; ?>
            <?php
                generate_element("home.php", "home-outline", "Home");
                generate_element("task_admin.php", "clipboard-outline", "Tasks");
                generate_element("users.php", "people-outline", "Users");
                generate_element("dashboard.php", "bar-chart-outline", "Dashboard");
                generate_element("profile.php", "person-outline", "Profile");
                generate_element("feedback.php", "chatbubbles-outline", "Feedback");
                generate_element("logout.php", "exit-outline", "Logout");
            } elseif (isset($_SESSION['user']) && $_SESSION['user_type'] == "user") {
                echo "<ul id=\"navListUser\">";
                generate_element("home.php", "home-outline", "Home");
                generate_element("task_user.php", "clipboard-outline", "Tasks");
                generate_element("profile.php", "person-outline", "Profile");
                generate_element("stat.php", "analytics-outline", "Statistics");
                generate_element("support.php", "headset-outline", "Tech Support");
                generate_element("logout.php", "exit-outline", "Logout");
            } else {
                echo "<ul id=\"navListDefault\">";
                generate_element("home.php", "home-outline", "Home");
                generate_element("login.php", "key-outline", "Login");
                generate_element("signup.php", "person-add-outline", "Sign up");
            }
            echo "<div class=\"indicator\"></div></ul>";
            ?>

        </div>

    </div>
    <div class="content"></div>
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>
    <script type="module" src="https://unpkg.com/ionicons@7.1.0/dist/ionicons/ionicons.esm.js"></script>
    <script nomodule src="https://unpkg.com/ionicons@7.1.0/dist/ionicons/ionicons.js"></script>
    <script src="script.js"></script>
</body>

</html>