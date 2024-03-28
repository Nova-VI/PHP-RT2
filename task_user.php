<style>
    #task-container {
        margin-top: 20px;
    }

    .task {
        border: 1px solid #ccc;
        padding: 10px;
        margin-bottom: 10px;
        border-radius: 5px;
        background-color: #f9f9f9;
    }

    .task .title {
        font-size: 18px;
        font-weight: bold;
        margin-bottom: 5px;
    }

    .task .description {
        color: #666;
        margin-bottom: 10px;
    }

    .task .end_date {
        color: #999;
        font-style: italic;
        margin-bottom: 10px;
    }

    .buttons {
        margin-top: 10px;
    }

    .buttons button {
        margin-right: 10px;
        padding: 5px 10px;
        border: none;
        border-radius: 3px;
        cursor: pointer;
        color: #fff;
    }

    .delete-btn {
        background-color: #e74c3c;
    }

    .update-btn {
        background-color: #3498db;
    }

    .status {
        color: #fff;
        padding: 3px 8px;
        border-radius: 3px;
        display: inline-block;
    }

    .status-overdue {
        background-color: #e74c3c;
    }

    .status-progress {
        background-color: #f39c12;
    }

    .status-complete {
        background-color: #2ecc71;
    }

    button {
        padding: 8px 16px;
        border: none;
        border-radius: 4px;
        cursor: pointer;
        background-color: #4CAF50;
        color: white;
        font-size: 16px;
        margin-right: 10px;
        transition: 0.25s;
    }

    button:disabled {
        opacity: 0;
        cursor: default;
    }

    button:hover {
        background-color: #45a049;
    }

    #live_search {
        padding: 8px;
        border: 1px solid #ccc;
        border-radius: 4px;
        font-size: 16px;
        width: 300px;
        margin-bottom: 20px;
    }


    #live_search:focus {
        border-color: #4CAF50;
    }


    #task-title,
    #task-description,
    #end_date {
        padding: 8px;
        border: 1px solid #ccc;
        border-radius: 4px;
        font-size: 16px;
        width: 300px;
        margin-bottom: 10px;
    }


    #task-title:focus,
    #task-description:focus,
    #end_date:focus {
        border-color: #4CAF50;
    }

    .control-panel {
        display: flex;
        justify-content: space-between;
        align-items: center;
        margin-bottom: 20px;
    }

    #filter-task {
        margin-right: 10px;
        width: fit-content;
        padding: 0 0 0 40px;
        border-left: 1px solid #ccc;
    }

    #add-task {
        display: inline-block;
        margin-right: 10px;
        width: fit-content;

    }

    #add-task td {
        padding: 0 20px;
        align-items: center;
        vertical-align: middle;

    }

    #add-task td button {
        width: 100%;
    }
</style>

<div class="control-panel">

    <table id="add-task">
        <tr>
            <th>
                <h1>Add task</h1>
            </th>
            <td><input type="text" id="task-title" placeholder="Enter task title" name="title"></td>
            <td><textarea style="resize: none" id="task-description" placeholder="Enter task description" name="description"></textarea></td>
        </tr>
        <tr>
            <th>
                <h1>End Date</h1>
            </th>
            <td><input type="date" id="end_date" name="end_date" value="<?php echo date("Y-m-d"); ?>"></td>
            <td><button type="submit" onclick="addTask()" name="add">Add Task</button></td>
        </tr>
    </table>
    <div id="filter-task">
        <h2>Filter tasks</h2>
        <div>
            <input type="text" class="form-control" id="live_search" autocomplete="off" placeholder="Search...">
        </div>
        <div>
            <button type="button" onclick="sortByTitle()">Sort Alphabetically</button>
            <button type="button" onclick="sortByDate()">Sort by Date</button>
        </div>
    </div>
</div>
<div id="task-container">
    <?php
    include 'task_list.php';
    $result = $_SESSION["result"];
    $today = date("Y-m-d");
    for ($i = 0; $i < count($result); $i++) {
        if ($result[$i]["end_date"] < $today && $result[$i]["status"] != "Finished") {
            $status = "Overdue";
            $result[$i]["status"] = "Overdue";
            $query = "UPDATE Task SET status=:status WHERE id = :id";
            $stmt = $bdd->prepare($query);
            $stmt->execute(array(':status' => $status, ':id' => $result[$i]['id']));
        }
    ?>
        <div class="task" data-task-id="<?php echo $result[$i]['id']; ?>">
            <div class="title"><?php echo $result[$i]['title'] ?></div>
            <div class="description"><?php echo $result[$i]['description'] ?></div>
            <div class="end_date"><?php echo $result[$i]['end_date'] ?></div>
            <div class="buttons">
                <button type="button" class="delete-btn" onclick="deleteTask('<?php echo $result[$i]['id'] ?>')">Delete</button>
                <button type="button" class="update-btn" onclick="updateTaskPrompt('<?php echo $result[$i]['id'] ?>','<?php echo $result[$i]['title'] ?>','<?php echo $result[$i]['description'] ?>')">Update</button>
                <button type="button" class="finish-btn" onclick="finishTask('<?php echo $result[$i]['id'] ?>')" <?php if ($result[$i]["status"] == "Finished" || $result[$i]["status"] == "Overdue") echo "disabled"; ?>>Done</button>
                <div class="status <?php if ($result[$i]["status"] == "Finished") echo "status-complete";
                                    else if ($result[$i]["status"] == "In Progress") echo "status-progress";
                                    else echo "status-overdue" ?>"><?php echo $result[$i]["status"] ?></div>
            </div>

        </div>
    <?php
    }
    ?>

</div>

<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.7.1/jquery.min.js"></script>

<script>
    $(document).ready(function() {
        $('#live_search').on('input', function() {
            var searchText = $(this).val().toLowerCase();
            $('.task').each(function() {
                var title = $(this).find('.title').text().toLowerCase();
                var description = $(this).find('.description').text().toLowerCase();
                if (title.indexOf(searchText) === -1 && description.indexOf(searchText) === -1) {
                    $(this).hide();
                } else {
                    $(this).show();
                }
            });
        });
    });

    var currentSortOrder = 'asc'; // Initially set to ascending order


    function sortByTitle() {
        var taskContainer = $('#task-container');
        var tasks = taskContainer.children('.task').toArray();
        tasks.sort(function(a, b) {
            var titleA = $(a).find('.title').text().toLowerCase();
            var titleB = $(b).find('.title').text().toLowerCase();

            if (currentSortOrder === 'asc') {
                return titleA.localeCompare(titleB);
            } else {
                return titleB.localeCompare(titleA);
            }
        });
        taskContainer.empty().append(tasks);

        currentSortOrder = (currentSortOrder === 'asc') ? 'desc' : 'asc';
    }


    function sortByDate() {
        var taskContainer = $('#task-container');
        var tasks = taskContainer.children('.task').toArray();
        tasks.sort(function(a, b) {
            var dateA = new Date($(a).find('.end_date').text());
            var dateB = new Date($(b).find('.end_date').text());

            if (currentSortOrder === 'asc') {
                return dateA - dateB;
            } else {
                return dateB - dateA;
            }
        });
        taskContainer.empty().append(tasks);

        currentSortOrder = (currentSortOrder === 'asc') ? 'desc' : 'asc';
    }
</script>

<script src="task_script.js">