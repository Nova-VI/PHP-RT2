<?php

require_once('connexion.php');
session_start();
class UserStatsManager
{
    private $connection;

    public function __construct($connection)
    {
        $this->connection = $connection;
    }

    public function redirectToHomeIfNotUser()
    {
        if (!isset($_SESSION['user'])) {
            header("Location: index.php");
            exit();
        }
    }

    public function calculateUserStats($userId, $startDate, $endDate)
    {
        $query = "SELECT * FROM Task WHERE (user_id = '$userId') AND (DATE(completion_date) BETWEEN '$startDate' AND '$endDate'OR DATE(end_date) BETWEEN '$startDate' AND '$endDate' AND status!='In Progress')";
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

    public function getTotalUndoneTasksForUser($userId)
    {
        $query = "SELECT * FROM Task WHERE user_id = '$userId' AND status = 'In Progress'";
        $result = $this->connection->query($query);
        return $result->rowCount();
    }
}

$pdo = ConnexionBD::getInstance();

$userStatsManager = new UserStatsManager($pdo);
$userStatsManager->redirectToHomeIfNotUser();
$userId = $_SESSION['user_entity']['id'];
$today = date("Y-m-d");
$lastWeek = date("Y-m-d", strtotime("-1 week"));
$lastMonth = date("Y-m-d", strtotime("-1 month"));

$userStats = array(
    'today' => $userStatsManager->calculateUserStats($userId, $today, $today),
    'lastWeek' => $userStatsManager->calculateUserStats($userId, $lastWeek, $today),
    'lastMonth' => $userStatsManager->calculateUserStats($userId, $lastMonth, $today)
);

$totalTasksUndone = $userStatsManager->getTotalUndoneTasksForUser($userId);
?>
<table class="stats-table">
    <tr>
        <th colspan="4">
            <h1 class="stats-title" style="text-align: center;">Statistics</h1>
        </th>
    </tr>
    <tr>
        <th></th>
        <th class="head">Tasks Done</th>
        <th class="head">Tasks Failed</th>
        <th class="head">Total</th>
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
        <th>Pending Tasks</th>
        <td></td>
        <td></td>
        <td style="color:yellow;font-weight:bold"><?php echo $totalTasksUndone ?></td>
    </tr>
</table>


<style>
    .stats-table {
        width: 100%;
        border-collapse: collapse;
        margin-bottom: 20px;
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
</style>