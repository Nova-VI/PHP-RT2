
function addTask() {
    var title = document.getElementById("task-title").value;
    var description = document.getElementById("task-description").value;
    var end_date = document.getElementById("end_date").value;

    if (title.trim() === '' || description.trim() === '' || end_date.trim() === '') {
        alert("Please fill in all fields.");
        return;
    }

    var taskData = {
        title: title,
        description: description,
        end_date: end_date
    };
    let button = document.querySelector("button[name='add']")
    button.onclick = null; //to prevent multiple clicks.
    button.style.cursor = "wait";
    var jsonData = JSON.stringify(taskData);

    var xhr = new XMLHttpRequest();

    xhr.open("POST", "task_list.php", true);
    xhr.setRequestHeader("Content-Type", "application/json");

    // Set up the event handler for when the XMLHttpRequest completes
    xhr.onreadystatechange = function () {
        if (xhr.readyState === XMLHttpRequest.DONE) {
            if (xhr.status === 200) {
                button.style.cursor = "default";
                $(".content").load("task_user.php");
            } else {
                alert('Error: ' + xhr.status);
            }
        }
    };

    xhr.send(jsonData);
}


function deleteTask(taskId) {
    if (confirm("Are you sure you want to delete this task?")) {
        var xhr = new XMLHttpRequest();
        xhr.open("POST", "task_list.php", true);
        xhr.setRequestHeader("Content-Type", "application/x-www-form-urlencoded");
        xhr.onreadystatechange = function () {
            if (xhr.readyState === XMLHttpRequest.DONE) {
                if (xhr.status === 200) {
                    var taskElement = document.querySelector(".task[data-task-id='" + taskId + "']");
                    if (taskElement) {
                        taskElement.parentNode.removeChild(taskElement);
                    }
                } else {
                    alert('Error: ' + xhr.status);
                }
            }
        };
        xhr.send("delete=true&taskid=" + taskId);
    }
}


function updateTaskPrompt(taskId, currentTitle, currentDescription) {
    var newTitle = prompt("Enter new title:", currentTitle);
    if (newTitle === null) { // If the user cancels the prompt
        return;
    }

    var newDescription = prompt("Enter new description:", currentDescription);
    if (newDescription === null) { // If the user cancels the prompt
        return;
    }

    updateTask(taskId, newTitle, newDescription); // Call the updateTask function with new values
}




function updateTask(taskId, newTitle, newDescription) {
    var xhr = new XMLHttpRequest();
    xhr.open("POST", "task_list.php", true);
    xhr.setRequestHeader("Content-Type", "application/x-www-form-urlencoded");

    var data = "update=true&taskid=" + taskId + "&new_title=" + newTitle + "&new_description=" + newDescription;

    xhr.onreadystatechange = function () {
        if (xhr.readyState === XMLHttpRequest.DONE) {
            if (xhr.status === 200) {
                var taskElement = document.querySelector(".task[data-task-id='" + taskId + "']");
                var titleElement = taskElement.querySelector(".title");
                var descriptionElement = taskElement.querySelector(".description");
                if (titleElement && descriptionElement) {
                    titleElement.textContent = newTitle;
                    descriptionElement.textContent = newDescription;
                }

            } else {
                alert('Error: ' + xhr.status);
            }
        }
    };
    xhr.send(data);
}
function finishTask(taskId) {
    var xhr = new XMLHttpRequest();
    xhr.open("POST", "task_list.php", true);
    xhr.setRequestHeader("Content-Type", "application/x-www-form-urlencoded");

    var data = "finish=true&taskid=" + taskId;
    var taskElement = document.querySelector(".task[data-task-id='" + taskId + "']");
    let taskStatus = taskElement.querySelector(".status");
    taskStatus.classList.remove("status-progress");
    taskStatus.classList.add("status-complete");
    taskStatus.textContent = "Finished";
    let button = taskElement.querySelector(".finish-btn");
    button.disabled = true;
    xhr.send(data);
}



