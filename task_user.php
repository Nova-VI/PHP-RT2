
<div id="task-container">
    <?php
    include 'task_list.php';
    $result=$_SESSION["result"];
    for ($i=0;$i<count($result);$i++){
        ?>
            <div class="task" data-task-id="<?php echo $result[$i]['id']; ?>">
                <div class="title"><?php echo $result[$i]['title']?></div>
                <div class="description"><?php echo $result[$i]['description'] ?></div>
                <div class="buttons">
                    <button type="button" class="delete-btn" onclick="deleteTask('<?php echo $result[$i]['id'] ?>')" >Delete</button>
                    <button type="button" class="update-btn" onclick="updateTaskPrompt('<?php echo $result[$i]['id'] ?>','<?php echo $result[$i]['title']?>','<?php echo $result[$i]['description'] ?>')">Update</button>
                    <div class="status status-complete"><?php echo $result[$i]["status"]?></div>
                </div>
            </div>
                <?php
    }
    ?>

</div>
    <div id="add-task" >
        <input type="text" id="task-title" placeholder="Enter task title" name="title">
        <textarea id="task-description" placeholder="Enter task description" name="description"></textarea>
        <input type="date" id="end_date"  name="end_date">End Date
        <button type="submit" onclick="addTask()" name="add">Add Task</button>
    </div>
<script src="task_script.js">



