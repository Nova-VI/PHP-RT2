<?php
function taskCompleted($tasks, $user_id)
{
    $completed = 0;
    $total = 0;
    foreach ($tasks as $task) {
        if ($task["user_id"] != $user_id) continue;
        if ($task["status"] == "completed") {
            $completed++;
        }
        $total++;
    }
    echo $completed . " out of " . $total . " tasks completed.";
}
function getAge($birthday)
{
    $today = new DateTime();
    $diff = $today->diff(new DateTime($birthday));
    return $diff->y;
}
session_start();
$users = $_SESSION['users'];
$tasks = $_SESSION['tasks'];
?>
<ul>
    <?php
    foreach ($users as $user) :
        if (!strstr(strtoupper($user["username"]), strtoupper($_POST["input"]))) continue;
        $formatted_user = str_replace(" ", "%20", $user["username"])
    ?>
        <li onclick="$('.content').load('profile.php?username=<?php echo $formatted_user ?>');"><span class="icon">
                <?php if ($user["profile_image"] == "") : ?>
                    <ion-icon name="person-outline"></ion-icon>
                <?php else : ?>
                    <img src="<?php echo $user["profile_image"] ?>" alt="profile picture">
                <?php endif;
                echo $user["username"]
                ?>
            </span>
            <span><?php echo $user["email"] ?></span>
            <span><?php echo getAge($user["birth_date"]) . " years old." ?></span>
            <span><?php echo taskCompleted($tasks, $user["id"]) ?></span>
            <span class="final">
                <?php if ($user["role"] == "admin") : ?>
                    Admin <ion-icon name="shield-checkmark-outline"></ion-icon>
                <?php else : ?>
                    <button onclick="event.stopPropagation();deleteUser('<?php echo $user['username'] ?>')"><ion-icon name="trash-outline"></button></ion-icon>
            </span>
        <?php endif ?>
        </li>
    <?php endforeach; ?>
</ul>