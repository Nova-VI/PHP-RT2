<!DOCTYPE html>
<?php
session_start();
?>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <link rel="stylesheet" href="..\css\bootstrap.css">
</head>

<body>


    <div class="container mt-5 col-4 bg-light p-4 rounded-3 shadow">

        <form action="..\php\signup.php" method="post" enctype="multipart/form-data" novalidate>
            <?php
            if(isset($_SESSION['errors']['fetch'])) {
                echo '<div class="text-danger">' . $_SESSION['errors']['fetch'] . '</div>';
            }
            ?>
            <div class="mb-3">
                <label for="usernamefield" class="form-label">Email address</label>
                <input type="text" class="form-control" id="usernamefield" aria-describedby="emailHelp"
                    placeholder="Enter a username" required autofocus name="username" >
                <?php
                if(isset($_SESSION['errors']['username'])) {
                    echo '<div class="text-danger">' . $_SESSION['errors']['username'] . '</div>';
                }
                ?>
            </div>

            <div class="mb-3">
                <label for="emailfield" class="form-label">Email address</label>
                <input type="email" class="form-control" id="emailfield" aria-describedby="emailHelp"
                    placeholder="Enter Ur Email" required autofocus name="email" >
                <div id="emailHelp" class="form-text">We'll never share your email with anyone else.</div>
                <?php
                if(isset($_SESSION['errors']['email']['require'])) {
                    echo '<div class="text-danger">' . $_SESSION['errors']['email']['require'] . '</div>';
                }
                if(isset($_SESSION['errors']['email']['format'])) {
                    echo '<div class="text-danger">' . $_SESSION['errors']['email']['format'] . '</div>';
                }
                ?>
            </div>
            <div class="mb-3">
                <label for="passwordfield" class="form-label">Password</label>
                <input type="password" class="form-control" id="passwordfield" aria-describedby="passwordHelpBlock"
                    name="password" required>
                <?php
                if(isset($_SESSION['errors']['password'])) {
                    echo '<div class="text-danger">' . $_SESSION['errors']['password'] . '</div>';
                }
                ?>
            </div>

            <div class="mb-3">
                <label for="cpasswordfield" class="form-label">Confirm Password</label>
                <input type="password" class="form-control" id="cpasswordfield" aria-describedby="passwordHelpBlock"
                    name="cpassword">
                <?php
                if(isset($_SESSION['errors']['cpassword'])) {
                    echo '<div class="text-danger">' . $_SESSION['errors']['cpassword'] . '</div>';
                }
                ?>
            </div>

            <div class="mb-3">
                <label for="datefield" class="form-label">Birth Date</label>
                <input type="date" class="form-control" id="datefield"
                        required autofocus name="birth" >
                <?php
                if(isset($_SESSION['errors']['birthdate'])) {
                    echo '<div class="text-danger">' . $_SESSION['errors']['birthdate'] . '</div>';
                }
                ?>
            </div>

            <div class="mb-3">
                <label for="imagefield" class="form-label">Choose Ur Profile Image</label>
                <input type="file" class="form-control" id="imagefield" aria-describedby="image-picker"
                       name="profileimage">

                <?php
                if(isset($_SESSION['errors']['extension'])) {
                    echo '<div class="text-danger">' . $_SESSION['errors']['extension'] . '</div>';
                }
                if(isset($_SESSION['errors']['image'])) {
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

    <script src=" 
    https://code.jquery.com/jquery-3.5.1.slim.min.js" integrity=" 
    sha384-DfXdz2htPH0lsSSs5nCTpuj/zy4C+OGpamoFVy38MVBnE+IbbVYUew+OrCXaRkfj" crossorigin="anonymous">
    </script>

    <script src=" 
    https://cdn.jsdelivr.net/npm/popper.js@1.16.0/dist/umd/popper.min.js"
        integrity="sha384-Q6E9RHvbIyZFJoft+2mJbHaEWldlvI9IOYy5n3zV9zzTtmI3UksdQRVvoxMfooAo" crossorigin="anonymous">
        </script>

    <script src=" 
    https://stackpath.bootstrapcdn.com/bootstrap/4.5.0/js/bootstrap.min.js"
        integrity="sha384-OgVRvuATP1z7JjHLkuOU7Xw704+h835Lr+6QL9UvYjZE3Ipu6Tp75j7Bh/kR0JKI" crossorigin="anonymous">
        </script>

</body>

</html>