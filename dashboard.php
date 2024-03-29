<?php
require_once('connexion.php');

session_start();

class TaskStatsManager
{
    private $connection;

    public function __construct($connection)
    {
        $this->connection = $connection;
    }

    public function redirectToHomeIfNotAdmin()
    {
        if (!isset($_SESSION['user_type']) || $_SESSION['user_type'] !== 'admin') {
            header("Location: home.php");
            exit();
        }
    }
    public function calculateUserStats($userId, $startDate, $endDate)
    {
        $query = "SELECT * FROM Task WHERE (user_id = '$userId') AND (DATE(completion_date) BETWEEN '$startDate' AND '$endDate'OR DATE(end_date) BETWEEN '$startDate' AND '$endDate' AND status!='In Progress')";
        return $this->calculateStats($query);
    }
    public function calculateTotalStats($startDate, $endDate)
    {
        $query = "SELECT * FROM Task WHERE DATE(completion_date) BETWEEN '$startDate' AND '$endDate'OR DATE(end_date) BETWEEN '$startDate' AND '$endDate' AND status!='In Progress'";
        return $this->calculateStats($query);
    }
    private function calculateStats($query)
    {
        $result = $this->connection->query($query);
        $totalTasks = $result->rowCount();
        $completedCount = 0;
        $failedCount = 0;

        foreach ($result as $row) {
            if ($row['status'] == 'Finished') {
                $completedCount++;
            } else if ($row['status'] == 'Overdue') {
                $failedCount++;
            }
        }

        $completedPercentage = $totalTasks > 0 ? ($completedCount / $totalTasks) * 100 : 0;
        $failedPercentage = $totalTasks > 0 ? ($failedCount / $totalTasks) * 100 : 0;

        return array(
            'totalTasks' => $totalTasks,
            'completedCount' => $completedCount,
            'failedCount' => $failedCount,
            'completedPercentage' => round($completedPercentage, 2),
            'failedPercentage' => round($failedPercentage, 2)
        );
    }
    public function getTotalUndoneTasks()
    {
        $query = "SELECT * FROM Task WHERE completion_date IS NULL AND status = 'In Progress'";
        $result = $this->connection->query($query);
        return $result->rowCount();
    }

    public function getAvgTasksPerUser()
    {
        $query = "SELECT AVG(tasks_done) AS avg_tasks 
                  FROM (SELECT COUNT(*) AS tasks_done FROM Task WHERE completion_date IS NOT NULL AND status = 'Finished' GROUP BY user_id) AS temp";
        $result = $this->connection->query($query);
        $row = $result->fetch(PDO::FETCH_ASSOC);
        return round($row['avg_tasks'], 2);
    }

    public function getTotalUndoneTasksForUser($userId)
    {
        $query = "SELECT * FROM Task WHERE user_id = '$userId' AND completion_date IS NULL AND status = 'In Progress'";
        $result = $this->connection->query($query);
        return $result->rowCount();
    }
}

$pdo = ConnexionBD::getInstance();

$taskStatsManager = new TaskStatsManager($pdo);
$taskStatsManager->redirectToHomeIfNotAdmin();

$today = date("Y-m-d");
$lastWeek = date("Y-m-d", strtotime("-1 week"));
$lastMonth = date("Y-m-d", strtotime("-1 month"));

$totalStats = array(
    'today' => $taskStatsManager->calculateTotalStats($today, $today),
    'lastWeek' => $taskStatsManager->calculateTotalStats($lastWeek, $today),
    'lastMonth' => $taskStatsManager->calculateTotalStats($lastMonth, $today)
);

$totalUndone = $taskStatsManager->getTotalUndoneTasks();
$avgTasksPerUser = $taskStatsManager->getAvgTasksPerUser();

if (isset($_GET['username'])) {
    $username = $_GET['username'];
    $query = "SELECT * FROM users WHERE username = '$username'";
    $user = $pdo->query($query)->fetch(PDO::FETCH_ASSOC);
    if (!$user) {
        $error = 'User not found';
    } elseif ($user['role'] == 'admin') {
        $error = 'You can\'t view statistics for an admin user';
    } else {
        $userId = $user['id'];
        $userStats = array(
            'today' => $taskStatsManager->calculateUserStats($userId, $today, $today),
            'lastWeek' => $taskStatsManager->calculateUserStats($userId, $lastWeek, $today),
            'lastMonth' => $taskStatsManager->calculateUserStats($userId, $lastMonth, $today)
        );
        $TotalTasksUndoneForUser = $taskStatsManager->getTotalUndoneTasksForUser($userId);
    }
}

?>



<table class="stats-table">
    <tr>
        <th colspan=4 style="text-align: center;padding:40px">
            <h1>Overall Statistics</h1>
        </th>
    </tr>
    <tr>
        <th></th>
        <th style="text-align:center">Tasks Done</th>
        <th style="text-align:center">Tasks Failed</th>
        <th style="text-align:center">Total</th>
    </tr>
    <tr>
        <th>Today</th>
        <td><?php echo $totalStats['today']['completedCount'] . " (" . $totalStats['today']['completedPercentage'] . "%)" ?></td>
        <td><?php echo $totalStats['today']['failedCount'] . " (" . $totalStats['today']['failedPercentage'] . "%)" ?></td>
        <td><?php echo $totalStats['today']['totalTasks'] ?></td>
    </tr>
    <tr>
        <th>Last Week</th>
        <td><?php echo $totalStats['lastWeek']['completedCount'] . " (" . $totalStats['lastWeek']['completedPercentage'] . "%)" ?></td>
        <td><?php echo $totalStats['lastWeek']['failedCount'] . " (" . $totalStats['lastWeek']['failedPercentage'] . "%)" ?></td>
        <td><?php echo $totalStats['lastWeek']['totalTasks'] ?></td>
    </tr>
    <tr>
        <th>Last Month</th>
        <td><?php echo $totalStats['lastMonth']['completedCount'] . " (" . $totalStats['lastMonth']['completedPercentage'] . "%)" ?></td>
        <td><?php echo $totalStats['lastMonth']['failedCount'] . " (" . $totalStats['lastMonth']['failedPercentage'] . "%)" ?></td>
        <td><?php echo $totalStats['lastMonth']['totalTasks'] ?></td>
    </tr>
    <tr>
        <th>Pending Tasks</th>
        <td></td>
        <td></td>
        <td><?php echo $totalUndone ?></td>
    </tr>
    <tr>
        <th>Average Tasks Per User</th>
        <td></td>
        <td></td>
        <td><?php echo $avgTasksPerUser ?></td>
    </tr>
    <tr>
        <th colspan=4 style="text-align: center;padding:40px">
            <h1>Statistics for a specific User</h1>
        </th>
    </tr>
    <tr>
        <th>
            <span class="error"><?php echo isset($error) ? $error : '' ?></span>
        </th>
        <th colspan=2>
            <input type="text" id="username" placeholder="Enter username">
        </th>
        <th>
            <button type="submit" onclick="submitForm()">Submit</button>
        </th>

    </tr>
    <?php if (isset($user) && !isset($error)) : ?>
        <tr>
            <th colspan=4>
                <h1><?php echo $user['username'] ?></h1>
            </th>
        </tr>
        <tr>
            <th></th>
            <th style="text-align:center">Tasks Done</th>
            <th style="text-align:center">Tasks Failed</th>
            <th style="text-align:center">Total</th>
        </tr>
        <tr>
            <th>Today</th>
            <td><?php echo $userStats['today']['completedCount'] . " (" . $userStats['today']['completedPercentage'] . "%)" ?></td>
            <td><?php echo $userStats['today']['failedCount'] . " (" . $userStats['today']['failedCount'] . "%)" ?></td>
            <td><?php echo $userStats['today']['totalTasks'] ?></td>
        </tr>
        <tr>
            <th>Last Week</th>
            <td><?php echo $userStats['lastWeek']['completedCount'] . " (" . $userStats['lastWeek']['completedPercentage'] . "%)" ?></td>
            <td><?php echo $userStats['lastWeek']['failedCount'] . " (" . $userStats['lastWeek']['failedPercentage'] . "%)" ?></td>
            <td><?php echo $userStats['lastWeek']['totalTasks'] ?></td>
        </tr>
        <tr>
            <th>Last Month</th>
            <td><?php echo $userStats['lastMonth']['completedCount'] . " (" . $userStats['lastMonth']['completedPercentage'] . "%)" ?></td>
            <td><?php echo $userStats['lastMonth']['failedCount'] . " (" . $userStats['lastMonth']['failedPercentage'] . "%)" ?></td>
            <td><?php echo $userStats['lastMonth']['totalTasks'] ?></td>
        </tr>
        <tr>
            <th>Total Pending Tasks</th>
            <td></td>
            <td></td>
            <td><?php echo $TotalTasksUndoneForUser ?></td>
        </tr>
    <?php endif; ?>
</table>

<script>
    function submitForm() {
        event.preventDefault();
        const username = document.querySelector('#username').value;
        $(".content").load(`dashboard.php?username=${encodeURIComponent(username)}`);
    };
</script>
<style>
    .stats-table {
        width: 100%;
        border-collapse: collapse;
        margin-bottom: 20px;
        table-layout: fixed;
    }

    .stats-table th {
        background-color: #202020;
        color: white;
        font-weight: bold;
        text-align: left;
        padding: 10px;
    }


    .stats-table tr {
        background-color: #404040;
        color: white;
        text-align: center;
        transition: .3s;
    }

    .stats-table tr:nth-child(even) {
        background-color: #303030;
    }

    .stats-table tr:hover {
        background-color: #505050;
    }

    .stats-table td {
        padding: 10px;
    }

    .stats-title {
        font-size: 24px;
        margin-bottom: 10px;
    }

    .stats-table .head {
        text-align: center;
    }

    body {
        background-color: #202020;
    }

    .content {
        background-color: #202020;
        padding: 50px;
    }

    .stats-table input {
        padding: 10px;
        font-size: 1.5em;
        margin-right: 10px;
        background: none;
        border: 2px solid #808080;
        color: white;
        width: 100%;
        border-radius: 10px;
    }

    .stats-table button {
        padding: 10px;
        font-size: 1.5em;
        background-color: black;
        border: none;
        width: 200px;
        color: white;
        cursor: pointer;
        border-radius: 10px;

    }

    .error {
        color: red;
    }
</style>