<style>
    table {
        width: 100%;
        border-collapse: collapse;
    }

    th,
    td {
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
        session_start();
        if (isset($_SESSION['feedbacks']) && isset($_SESSION['users'])) {
            $feedbacks = $_SESSION['feedbacks'];
            $users = $_SESSION['users'];
        } else {
            require_once 'connexion.php'; // Include the file for database connection
            $cnx = ConnexionBD::getInstance(); // Create a database connection instance
            $query = "select * from Feedback";
            $feedbacks = $cnx->query($query)->fetchAll(PDO::FETCH_ASSOC);
            $_SESSION['feedbacks'] = $feedbacks;
            $query = "select * from users";
            $users = $cnx->query($query)->fetchAll(PDO::FETCH_ASSOC);
            $_SESSION['users'] = $users;
        }

        $feedbacks = array_reverse($feedbacks); // Reverse the array (newest feedbacks first)
        // Fetch and display data in table
        if (count($feedbacks) > 0) {
            foreach ($feedbacks as $row) {
                $userRow = $users[array_search($row['User_Id'], array_column($users, 'id'))];

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