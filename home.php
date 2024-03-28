<style>
    .home-page {
        display: flex;
        justify-content: center;
        align-items: center;
        flex-direction: column;
        text-align: center;
        width: fit-content;
        margin: 50px;
    }

    .content {
        display: flex;
        justify-content: center;
        align-items: center;

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

    .home-page .user-view {
        display: flex;
        justify-content: center;
        align-items: center;
        flex-direction: column;
        width: 800px;
        border-radius: 20px;
        overflow: hidden;
    }

    .home-page .user-view h1 {

        font-size: 3em;
        margin: 20px;

    }

    .home-page .user-view p {
        font-size: 2em;
        margin: 20px;
    }

    .home-page .user-view table {
        width: 100%;
        table-layout: fixed;
    }

    .home-page .user-view table th,
    #head {
        text-align: left;
        background-color: #242424;
        color: white;
        padding: 20px;

    }

    #head {
        font-size: 1em;
        text-align: center;
        background-color: #202020;
    }

    .home-page .user-view table td:not(#head) {
        text-align: center;
        background-color: #303030;
        color: white;
        padding: 10px;
        font-size: 20px;
        font-weight: bold;
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
            <table cellspacing=0>
                <tr>
                    <td colspan="4" id="head">
                        <h1>Welcome back, <?php echo $_SESSION['user_entity']['username'] ?>.</h1>
                        <p>You have <?php echo $counter ?> out of <?php echo $total ?> tasks completed.</p>
                    </td>
                </tr>
                <?php if ($total != 0) : ?>

                    <tr>
                        <th style="text-align: center;">Task Title</th>
                        <th style="text-align: center;">Task Description</th>
                        <th style="text-align: center;">End Date</th>
                        <th style="text-align: center;">Status</th>
                    </tr>
                    <?php foreach ($tasks as $task) : ?>
                        <?php if ($task['user_id'] == $_SESSION['user_entity']['id']) :
                            if ($task['status'] == "Finished")
                                $statusColor = "green";
                            else if ($task['status'] == "Overdue")
                                $statusColor = "red";
                            else
                                $statusColor = "yellow";

                        ?>
                            <tr>
                                <td class="user-td"><?php echo $task['title'] ?></td>
                                <td class="user-td"><?php echo $task['description'] ?></td>
                                <td class="user-td"><?php echo $task['end_date'] ?></td>
                                <td class="user-td" style="color:<?php echo $statusColor ?>"><?php echo $task['status'] ?></td>
                            </tr>
                        <?php endif; ?>
                    <?php endforeach; ?>
            </table>
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
    <table cellspacing=0>
        <tr>
            <td colspan="2" id="head">
                <h1>Welcome, Admin <?php echo $_SESSION["user"] ?>.</h1>
            </td>
        </tr>
        <tr>
            <th>Total number of users</th>
            <td><?php echo $number_of_users; ?></td>
        </tr>
        <tr>
            <th>Total number of tasks</th>
            <td><?php echo $number_of_tasks; ?></td>
        </tr>
        <tr>
            <th>Number of finished tasks</th>
            <td><?php echo $finished_tasks; ?></td>
        </tr>
        <tr>
            <th>Total number of feedbacks</th>
            <td><?php echo $number_of_feedbacks; ?></td>
        </tr>
    </table>
</div>
</div>