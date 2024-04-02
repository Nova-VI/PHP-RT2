<div class="form-container">
    <form onsubmit="a()">
        <label class="form-label" for="feedback">Feedback:</label><br>
        <textarea id="feedback" name="feedback" rows="4" cols="50" class="form-textarea" required></textarea><br><br>
        <div style="margin:0 0 30px 0"> or
            <a href="mailto:taskmanagement@support.com?subject=Support Request&body=Dear Support Team," style="color:#505050;font-weight:bold">
                send us a mail
            </a>
        </div>
        <div id="submit-message" class="submit-message"></div>
        <input type="submit" value="Submit" class="form-submit">
    </form>


</div>

<script>
    function a() {
        event.preventDefault();
        text = document.getElementById("feedback").value;
        $(".content").load("support.php?feedback=" + encodeURIComponent(text));
    }
</script>
<div style="text-align: center;">
    <?php
    session_start();
    if (!isset($_SESSION['user'])) {
        header("Location: index.php");
    }
    require 'connexion.php';
    $cnx = ConnexionBD::getInstance();
    $username = $_SESSION['user'];
    $query = "select * from users where username='$username'";
    $user = $cnx->query($query)->fetch(PDO::FETCH_ASSOC);


    $user_id = $user["id"]; // Get user ID from session
    if ($_SERVER["REQUEST_METHOD"] == "GET") {
        // Check if the form is submitted
        if (isset($_GET['feedback']) && !empty($_GET['feedback'])) {
            // Process the form submission
            $feedback = $_GET['feedback'];
            // Prepare SQL statement
            $sql = "INSERT INTO `Feedback` (`Submission text`,`User_Id`, `Date`) VALUES (:feedback,:user_id, CURDATE())";

            $stmt = $cnx->prepare($sql);

            // Bind parameters
            if ($stmt->execute(array(':feedback' => $feedback, ':user_id' => $user_id))) {
                // If insertion is successful, display confirmation message
                echo "<script>document.getElementById('submit-message').innerHTML='Thank you for your feedback.'</script>";
            } else {
                // If insertion fails, display error message
                echo "<p>Error: Failed to insert feedback.</p>";
            }
        }
    }
    ?>

    <style>
        .form-container {
            max-width: 500px;
            margin: auto;
            padding: 20px;
            border: 1px solid #ccc;
            border-radius: 5px;
            background-color: #f9f9f9;
            border: 2px solid black;
        }

        .form-label {
            font-weight: bold;
            margin: 40px 20px;
        }

        .form-textarea {
            width: 100%;
            padding: 10px;
            margin: 20px 0 10px;
            box-sizing: border-box;
            border: 1px solid #ccc;
            border-radius: 4px;
            resize: vertical;
        }

        .form-submit {
            background-color: #4CAF50;
            color: white;
            padding: 12px 20px;
            border: none;
            border-radius: 4px;
            cursor: pointer;
            width: 100%;
            transition: 0.5s;
        }

        .form-submit:hover {
            background-color: #45a049;
        }

        .submit-message:not(:empty) {
            font-weight: bold;
            font-size: 1em;
            margin: 0 10px 40px 0;
            color: green;
        }
    </style>