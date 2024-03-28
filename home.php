<style>
    .home-page {
        display: flex;
        justify-content: center;
        align-items: center;
        flex-direction: column;
        text-align: center;
        padding: 30px;
        width: 100%;
    }

    .home-page .guest-view {
        display: flex;
        justify-content: center;
        align-items: center;
        flex-direction: column;
    }

    .home-page .guest-view h1 {
        font-size: 3em;
        margin: 50px;
    }

    .home-page .guest-view p {
        font-size: 1.8em;
    }

    .home-page .guest-view a {
        color: gray;
        font-weight: bold;
        text-decoration: none;
        cursor: pointer;
        transition: 0.5s;
    }

    .home-page .guest-view a:hover {
        color: blue;
    }

    .home-page .user-view h1 {

        font-size: 4em;
        margin: 50px;
    }

    .home-page .user-view p {
        font-size: 2em;
        margin: 20px;
    }

    .home-page .user-view ul {
        float: left;
        display: flex;
        flex-direction: column;
    }

    .home-page .user-view ul li {
        float: left;
        text-align: left;
        font-size: 1.4em;
    }
</style>
<div class="home-page">
    <?php
    session_start();
    if (!isset($_SESSION['user_entity'])) : ?>
        <div class="guest-view">
            <h1>Hello there, this is a task management website.</h1>
            <p>Start now by <a onclick="setActive(list[1])" href="#">logging</a> or <a onclick="setActive(list[2])" href="#">creating an account</a>.</p>
        </div>
    <?php
        return;
    endif;
    if (isset($_SESSION['tasks']) && isset($_SESSION['feedbacks']) && isset($_SESSION['users'])) {
        $tasks = $_SESSION['tasks'];
        $feedbacks = $_SESSION['feedbacks'];
        $users = $_SESSION['users'];
    } else {
        require 'connexion.php';
        $cnx = ConnexionBD::getInstance();
        $query = "SELECT * FROM Task ";
        $tasks = $cnx->query($query)->fetchAll(PDO::FETCH_ASSOC);
        $_SESSION['tasks'] = $tasks;
        $query = "SELECT * FROM Feedback";
        $feedbacks = $cnx->query($query)->fetchAll(PDO::FETCH_ASSOC);
        $_SESSION['feedbacks'] = $feedbacks;
        $query = "SELECT * FROM users";
        $users = $cnx->query($query)->fetchAll(PDO::FETCH_ASSOC);
        $_SESSION['users'] = $users;
    }
    if ($_SESSION['user_entity']['role'] != "admin") {

        $total = 0;
        $counter = 0;
        foreach ($tasks as $task) {
            if ($task['user_id'] == $_SESSION['user_entity']['id']) {
                $total++;
                if ($task['status'] == "Finished") {
                    $counter++;
                }
            }
        }
    ?>
        <div class="user-view">
            <h1>Welcome back, <?php echo $_SESSION['user_entity']['username'] ?>.</h1>
            <p>You have <?php echo $counter ?> out of <?php echo $total ?> tasks completed.</p>
            <?php if ($total != 0) : ?>
                <p>Here are your tasks:</p>
                <ul>
                    <?php foreach ($tasks as $task) {


                        if ($task['user_id'] == $_SESSION['user_entity']['id']) {
                            if ($task['status'] == "Finished")
                                echo "<li style='color:green'>" . $task['title'] . "</li>";
                            else if ($task['status'] == "In Progress")
                                echo "<li style='color:#f39c12'>" . $task['title'] . "</li>";
                            else
                                echo "<li style='color:red'>" . $task['title'] . "</li>";
                        }
                    } ?>
                </ul>
        </div>
<?php
            endif;
            return;
        }
        $number_of_users = count($users);
        $number_of_tasks = count($tasks);
        $finished_tasks = 0;
        foreach ($tasks as $task) {
            if ($task['status'] == "Finished")
                $finished_tasks++;
        }
        $number_of_feedbacks = 0;
        $number_of_feedbacks = count($feedbacks);
?>
<div class="user-view">
    <h1>Welcome, Admin <?php echo $_SESSION["user"] ?>.</h1>
    <p>Here are some statistics:</p>
    <ul>
        <li>Total number of users: <?php echo $number_of_users; ?></li>
        <li>Total number of tasks: <?php echo $number_of_tasks; ?></li>
        <li>Number of finished tasks: <?php echo $finished_tasks; ?></li>
        <li>Total number of feedbacks: <?php echo $number_of_feedbacks; ?></li>
        <li style="list-style-type: none;padding-top:50px"><a onclick="setActive(list[1])" href="#">View users</a></li>
        <li style="list-style-type: none;"><a onclick="setActive(list[4])" href="#">View feedbacks</a></li>
    </ul>
</div>
</div>