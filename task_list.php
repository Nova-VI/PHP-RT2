<?php


session_start();

$user_id = $_SESSION["user_entity"]["id"];
require "connexion.php";
$bdd = ConnexionBd::getInstance();


////querying the tasks from the database
try {
    $query = "SELECT * FROM Task WHERE user_id=:id";
    $stmt = $bdd->prepare($query);
    $stmt->execute(array(':id' => $user_id));
    $result = $stmt->fetchAll();
    $_SESSION["result"] = $result;
} catch (PDOException $e) {
    echo "Error: " . $e->getMessage();
}




$jsonData = file_get_contents("php://input");
$taskData = json_decode($jsonData, true);
if ($taskData !== null) {
    $id = bin2hex(random_bytes(16));
    $title = $taskData['title'];
    $description = $taskData['description'];
    $end_date = $taskData['end_date'];
    $query = "INSERT INTO `Task` ( `id`,`title`,  
                `description`,`creation_date`,`end_date`,`status`,`user_id`) VALUES (:id,:title,  
                :description, :creation_date ,:end_date,:status,:user_id)";
    $stmt = $bdd->prepare($query);
    $stmt->execute(array(':id' => $id, ':title' => $title, ':description' => $description, ':creation_date' => date("Y-m-d"), ':end_date' => $end_date, ':status' => 'In Progress', ':user_id' => $user_id));
}



if (isset($_POST["delete"]) && isset($_POST['taskid'])) {
    $taskId = $_POST['taskid'];
    $query = "DELETE FROM Task WHERE id=:id";
    $stmt = $bdd->prepare($query);
    $stmt->execute(array(':id' => $taskId)); // Corrected variable name to match JavaScript
}



if (isset($_POST['update']) && isset($_POST['taskid']) && isset($_POST['new_title']) && isset($_POST['new_description'])) {
    $taskId = $_POST['taskid'];
    $newTitle = $_POST['new_title'];
    $newDescription = $_POST['new_description'];
    $query = "UPDATE task SET title = :newTitle, description = :newDescription WHERE id = :id";
    $stmt = $bdd->prepare($query);
    $stmt->execute(array(':id' => $taskId, ':newTitle' => $newTitle, ':newDescription' => $newDescription));
    exit();
}
