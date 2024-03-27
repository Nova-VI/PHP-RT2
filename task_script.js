



function addTask() {
    var title = document.getElementById("task-title").value;
    var description = document.getElementById("task-description").value;
    var end_date = document.getElementById("end_date").value;

    // Validate input
    if (title.trim() === '' || description.trim() === '' || end_date.trim() === '') {
        alert("Please fill in all fields.");
        return;
    }

    // Create a new task object
    var taskData = {
        title: title,
        description: description,
        end_date: end_date
    };

    // Convert task data to JSON string
    var jsonData = JSON.stringify(taskData);

    // Create a new XMLHttpRequest object
    var xhr = new XMLHttpRequest();

    // Configure the XMLHttpRequest
    xhr.open("POST", "task_list.php", true);
    xhr.setRequestHeader("Content-Type", "application/json");

    // Set up the event handler for when the XMLHttpRequest completes
    xhr.onreadystatechange = function() {
        if (xhr.readyState === XMLHttpRequest.DONE) {
            if (xhr.status === 200) {
                var taskElement = document.createElement('div');
                taskElement.classList.add('task');

                // Set data-task-id attribute (assuming you don't have ID for new task yet)
                taskElement.setAttribute('data-task-id', 'new');

                // Create inner HTML for the task
                taskElement.innerHTML = `
        <div class="title">${title}</div>
        <div class="description">${description}</div>
        <div class="buttons">
            <button type="button" class="delete-btn" onclick="deleteTask('new')">Delete</button>
            <button type="button" class="update-btn" onclick="updateTask('new')">Update</button>
            <div class="status status-complete">${end_date}</div>
        </div>
    `;

                // Append the new task element to the task container
                var taskContainer = document.getElementById("task-container");
                taskContainer.appendChild(taskElement);

                // Optionally, you can clear the input fields after adding the task
                document.getElementById("task-title").value = '';
                document.getElementById("task-description").value = '';
                document.getElementById("end_date").value = '';

                alert("Task added successfully");
            } else {
                // Handle error response from the server
                alert('Error: ' + xhr.status);
            }
        }
    };

    // Send the XMLHttpRequest with the task data
    xhr.send(jsonData);
}


function deleteTask(taskId) {
    if (confirm("Are you sure you want to delete this task?")) {
        var xhr = new XMLHttpRequest();
        xhr.open("POST", "task_list.php", true);
        xhr.setRequestHeader("Content-Type", "application/x-www-form-urlencoded");
        xhr.onreadystatechange = function() {
            if (xhr.readyState === XMLHttpRequest.DONE) {
                if (xhr.status === 200) {
                    // Remove the deleted task from the DOM
                    var taskElement = document.querySelector(".task[data-task-id='" + taskId + "']");
                    if (taskElement) {
                        taskElement.parentNode.removeChild(taskElement);
                    }
                    alert(xhr.responseText); // Show response message
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

    // Construct the data to be sent in the request
    var data = "update=true&taskid=" + taskId + "&new_title=" + newTitle + "&new_description=" + newDescription;

    xhr.onreadystatechange = function() {
        if (xhr.readyState === XMLHttpRequest.DONE) {
            if (xhr.status === 200) {
                var taskElement = document.querySelector(".task[data-task-id='" + taskId + "']");
                // Update title and description inside the task element
                var titleElement = taskElement.querySelector(".title");
                var descriptionElement = taskElement.querySelector(".description");
                if (titleElement && descriptionElement) {
                    titleElement.textContent = newTitle;
                    descriptionElement.textContent = newDescription;
                }
                alert(xhr.responseText); // Show response message
                // Optionally, you can update the task in the DOM here
            } else {
                alert('Error: ' + xhr.status);
            }
        }
    };
    xhr.send(data); // Send the request with the data
}









