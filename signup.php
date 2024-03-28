<style>
    body {
        font-family: Arial, sans-serif;
        background-color: #f8f9fa;
        margin: 0;
        padding: 0;
    }

    .container {
        max-width: 400px;
        margin: 50px auto;
        padding: 20px;
        background-color: #fff;
        border-radius: 10px;
        box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
        border: 2px solid black;
    }

    .form-group {
        margin-bottom: 20px;
    }

    .form-label {
        display: block;
        font-weight: bold;
        margin-bottom: 5px;
    }

    .form-control {
        width: 100%;
        padding: 10px;
        border-radius: 5px;
        border: 1px solid #ccc;
    }

    .form-text {
        font-size: 14px;
        color: #6c757d;
        margin-top: 5px;
    }

    .text-danger:not(:empty) {
        border: 2px solid #dc3545;
        color: #dc3545;
        margin-bottom: 10px;
        padding: 30px;
        border-radius: 10px;
    }

    .btn-primary {
        background-color: #007bff;
        color: #fff;
        border: none;
        padding: 10px 20px;
        border-radius: 5px;
        cursor: pointer;
        transition: background-color 0.3s ease;
        width: 100%;
        margin: 20px 0;
    }

    .btn-primary:hover {
        background-color: #0056b3;
    }

    .btn-secondary {
        width: 100%;
        background-color: #28a745;
        color: #fff;
        border: none;
        padding: 10px 20px;
        border-radius: 5px;
        cursor: pointer;
        transition: background-color 0.3s ease;
        margin-right: 10px;
    }

    .btn-secondary:hover {
        background-color: #218838;
    }
</style>

<div class="container">
    <div class="text-danger" id="danger"></div>

    <form onsubmit="submitForm()" method="post" enctype="multipart/form-data" novalidate>
        <?php
        if (isset($_SESSION['errors']['fetch'])) {
            echo '<div class="text-danger">' . $_SESSION['errors']['fetch'] . '</div>';
        }
        ?>
        <div class="form-group">
            <label for="usernamefield" class="form-label">Username</label>
            <input type="text" class="form-control" id="usernamefield" placeholder="Enter a username" required autofocus name="username">
            <?php
            if (isset($_SESSION['errors']['username'])) {
                echo '<div class="text-danger">' . $_SESSION['errors']['username'] . '</div>';
            }
            ?>
        </div>

        <div class="form-group">
            <label for="emailfield" class="form-label">Email address</label>
            <input type="email" class="form-control" id="emailfield" placeholder="Enter Your Email" required autofocus name="email">
            <div class="form-text">We'll never share your email with anyone else.</div>
            <?php
            if (isset($_SESSION['errors']['email']['require'])) {
                echo '<div class="text-danger">' . $_SESSION['errors']['email']['require'] . '</div>';
            }
            if (isset($_SESSION['errors']['email']['format'])) {
                echo '<div class="text-danger">' . $_SESSION['errors']['email']['format'] . '</div>';
            }
            ?>
        </div>

        <div class="form-group">
            <label for="passwordfield" class="form-label">Password</label>
            <input type="password" class="form-control" id="passwordfield" name="password" required>
            <?php
            if (isset($_SESSION['errors']['password'])) {
                echo '<div class="text-danger">' . $_SESSION['errors']['password'] . '</div>';
            }
            ?>
        </div>

        <div class="form-group">
            <label for="cpasswordfield" class="form-label">Confirm Password</label>
            <input type="password" class="form-control" id="cpasswordfield" name="cpassword">
            <?php
            if (isset($_SESSION['errors']['cpassword'])) {
                echo '<div class="text-danger">' . $_SESSION['errors']['cpassword'] . '</div>';
            }
            ?>
        </div>

        <div class="form-group">
            <label for="datefield" class="form-label">Birth Date</label>
            <input type="date" class="form-control" id="datefield" required autofocus name="birth">
            <?php
            if (isset($_SESSION['errors']['birthdate'])) {
                echo '<div class="text-danger">' . $_SESSION['errors']['birthdate'] . '</div>';
            }
            ?>
        </div>

        <div class="form-group">
            <label for="imagefield" class="form-label">Choose Your Profile Image</label>
            <input type="file" class="form-control" id="imagefield" name="profileimage">

            <?php
            if (isset($_SESSION['errors']['extension'])) {
                echo '<div class="text-danger">' . $_SESSION['errors']['extension'] . '</div>';
            }
            if (isset($_SESSION['errors']['image'])) {
                echo '<div class="text-danger">' . $_SESSION['errors']['image'] . '</div>';
            }
            ?>
        </div>

        <button type="submit" class="btn-primary">Submit</button>
        <button onclick="setActive(list[1])" class="btn-secondary">Log In</a>
            <?php
            unset($_SESSION["errors"]);
            ?>
    </form>
</div>

<script>
    function submitForm() {
        const form = document.querySelector('form');
        let formData = new FormData(form);

        var xhr = new XMLHttpRequest();
        xhr.open('POST', 'signup.action.php', true);
        xhr.send(formData);
        xhr.onreadystatechange = function() {
            if (xhr.readyState === XMLHttpRequest.DONE) {
                if (xhr.status === 200) {
                    if (xhr.responseText.includes("<head>"))
                        window.location.href = "index.php";
                    else
                        document.getElementById("danger").innerHTML = xhr.responseText;

                }
            };

        }
        event.preventDefault();
    }
</script>