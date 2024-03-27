<?php if (!isset($_SESSION['user'])) {
    header("Location: index.php");
} ?>
<form onsubmit="a()">
    <label for="feedback">Feedback:</label><br>
    <textarea id="feedback" name="feedback" rows="4" cols="50" required></textarea><br><br>
    <input type="submit" value="Submit">
</form>
<script>
    //simulate get method ( 7asb klem aymen khatro y9olk ekteb el code wmyfsrlkch chyamel)
    function a() {
        event.preventDefault();
        text = document.getElementById("feedback").value;
        $(".content").load("support.php?feedback=" + encodeURIComponent(text));
    }
</script>
<?php
session_start();
require 'connexion.php';
$cnx = ConnexionBD::getInstance();
$username = $_SESSION['user'];
$query = "select * from users where username='$username'";
$user = $cnx->query($query)->fetch(PDO::FETCH_ASSOC);


$user_id = $user["id"]; // Get user ID from session
echo "User ID: $user_id"; // Echo user ID for debugging (latrb7k ya m7amdia)
if ($_SERVER["REQUEST_METHOD"] == "GET") {
    // Check if the form is submitted
    if (isset($_GET['feedback']) && !empty($_GET['feedback'])) {
        // Process the form submission
        $feedback = $_GET['feedback'];
        echo $feedback;
        // Prepare SQL statement
        $sql = "INSERT INTO `Feedback` (`Submission text`,`User_Id`, `Date`) VALUES (:feedback,:user_id, CURDATE())";

        $stmt = $cnx->prepare($sql);

        // Bind parameters
        if ($stmt->execute(array(':feedback' => $feedback, ':user_id' => $user_id))) {
            // If insertion is successful, display confirmation message
            echo "<p>Thank you for your feedback: $feedback</p>";
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