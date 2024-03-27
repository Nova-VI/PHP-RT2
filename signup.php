<div class="container mt-5 col-4 bg-light p-4 rounded-3 shadow">
    <div class="text-danger" id="danger"></div>

    <form onsubmit="submitForm()" method="post" enctype="multipart/form-data" novalidate>
        <?php
        if (isset($_SESSION['errors']['fetch'])) {
            echo '<div class="text-danger">' . $_SESSION['errors']['fetch'] . '</div>';
        }
        ?>
        <div class="mb-3">
            <label for="usernamefield" class="form-label">Username</label>
            <input type="text" class="form-control" id="usernamefield" aria-describedby="emailHelp" placeholder="Enter a username" required autofocus name="username">
            <?php
            if (isset($_SESSION['errors']['username'])) {
                echo '<div class="text-danger">' . $_SESSION['errors']['username'] . '</div>';
            }
            ?>
        </div>

        <div class="mb-3">
            <label for="emailfield" class="form-label">Email address</label>
            <input type="email" class="form-control" id="emailfield" aria-describedby="emailHelp" placeholder="Enter Ur Email" required autofocus name="email">
            <div id="emailHelp" class="form-text">We'll never share your email with anyone else.</div>
            <?php
            if (isset($_SESSION['errors']['email']['require'])) {
                echo '<div class="text-danger">' . $_SESSION['errors']['email']['require'] . '</div>';
            }
            if (isset($_SESSION['errors']['email']['format'])) {
                echo '<div class="text-danger">' . $_SESSION['errors']['email']['format'] . '</div>';
            }
            ?>
        </div>
        <div class="mb-3">
            <label for="passwordfield" class="form-label">Password</label>
            <input type="password" class="form-control" id="passwordfield" aria-describedby="passwordHelpBlock" name="password" required>
            <?php
            if (isset($_SESSION['errors']['password'])) {
                echo '<div class="text-danger">' . $_SESSION['errors']['password'] . '</div>';
            }
            ?>
        </div>

        <div class="mb-3">
            <label for="cpasswordfield" class="form-label">Confirm Password</label>
            <input type="password" class="form-control" id="cpasswordfield" aria-describedby="passwordHelpBlock" name="cpassword">
            <?php
            if (isset($_SESSION['errors']['cpassword'])) {
                echo '<div class="text-danger">' . $_SESSION['errors']['cpassword'] . '</div>';
            }
            ?>
        </div>

        <div class="mb-3">
            <label for="datefield" class="form-label">Birth Date</label>
            <input type="date" class="form-control" id="datefield" required autofocus name="birth">
            <?php
            if (isset($_SESSION['errors']['birthdate'])) {
                echo '<div class="text-danger">' . $_SESSION['errors']['birthdate'] . '</div>';
            }
            ?>
        </div>

        <div class="mb-3">
            <label for="imagefield" class="form-label">Choose Ur Profile Image</label>
            <input type="file" class="form-control" id="imagefield" aria-describedby="image-picker" name="profileimage">

            <?php
            if (isset($_SESSION['errors']['extension'])) {
                echo '<div class="text-danger">' . $_SESSION['errors']['extension'] . '</div>';
            }
            if (isset($_SESSION['errors']['image'])) {
                echo '<div class="text-danger">' . $_SESSION['errors']['image'] . '</div>';
            }
            ?>
        </div>

        <div class="mb-3 form-check">
            <input type="checkbox" class="form-check-input" id="exampleCheck1" name="check">
            <label class="form-check-label" for="exampleCheck1">Remember Me</label>
        </div>
        <button type="submit" class="btn btn-primary ">Submit</button>
        <a href=login.php class="btn btn-secondary">Log In</a>
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