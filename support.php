<style>
    /* Style the form container */
    .form-container {
        max-width: 400px;
        margin: 0 auto;
        padding: 20px;
        border: 1px solid #ccc;
        border-radius: 5px;
        background-color: #f9f9f9;
    }

    /* Style the form labels */
    label {
        font-weight: bold;
    }

    /* Style the textarea */
    textarea {
        width: 100%;
        padding: 12px;
        border: 1px solid #ccc;
        border-radius: 4px;
        box-sizing: border-box;
        resize: vertical; /* Allow vertical resize */
    }

    /* Style the submit button */
    input[type="submit"] {
        background-color: #4caf50;
        color: white;
        padding: 12px 20px;
        border: none;
        border-radius: 4px;
        cursor: pointer;
    }

    /* Change submit button color on hover */
    input[type="submit"]:hover {
        background-color: #45a049;
    }
</style>

<div class="form-container">
    <form id="feedbackForm" onsubmit="a()">
        <label for="feedback">Feedback:</label><br>
        <textarea id="feedback" name="feedback" rows="4" cols="50" required></textarea><br><br>
        <input type="submit" value="Submit">
    </form>
</div>

<script>
    //simulate get method ( 7asb klem aymen khatro y9olk ekteb el code wmyfsrlkch chyamel)
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
            echo "<p>Thank you for your feedback.</p>";
        } else {
            // If insertion fails, display error message
            echo "<p>Error: Failed to insert feedback.</p>";
        }
    } else {
        // If feedback is not provided, display an error message
        echo "<p>Please provide your feedback.</p>";
    }
}
?>
</div>