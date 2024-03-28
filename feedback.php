f<style>
    table {
        width: 100%;
        border-collapse: collapse;
    }
    th, td {
        padding: 8px;
        text-align: left;
        border-bottom: 1px solid #ddd;
    }
</style>
<h2>Feedback table </h2>

<table>
    <thead>
        <tr>
            <th>Submission text</th>
            <th>User name</th>
            <th>Email</th>
            <th>Date</th>
        </tr>
    </thead>
    <tbody>
        <?php
        require_once 'connexion.php'; // Include the file for database connection
        $cnx = ConnexionBD::getInstance(); // Create a database connection instance

        // Perform SQL query
        $sql1 = "SELECT `Submission text`, `User_Id`, `Date` FROM `Feedback`";
        $stmt1 = $cnx->query($sql1);

        // Fetch and display data in table
        if ($stmt1->rowCount() > 0) {
            while ($row = $stmt1->fetch(PDO::FETCH_ASSOC)) {
                // Get user details from the users table based on the User_Id
                $userId = $row['User_Id'];
                $sql2 = "SELECT `username`, `email` FROM `users` WHERE `id`= '$userId'";
                $stmt2 = $cnx->query($sql2);
                $userRow = $stmt2->fetch(PDO::FETCH_ASSOC);

                echo "<tr>";
                echo "<td>" . $row['Submission text'] . "</td>";
                echo "<td>" . $userRow['username'] . "</td>"; // Display username
                echo "<td>" . $userRow['email'] . "</td>"; // Display email
                echo "<td>" . $row['Date'] . "</td>";
                echo "</tr>";
            }
        } else {
            echo "<tr><td colspan='4'>No data found</td></tr>";
        }

        // Close connection
        $cnx = null;
        ?>
    </tbody>
</table>