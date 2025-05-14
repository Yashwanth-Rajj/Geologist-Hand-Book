<?php
// Include the connection file
include('Connection.php');

// Check if the user is an admin (you can add a more secure authentication mechanism)
session_start();
if (!isset($_SESSION['admin']) || $_SESSION['admin'] != true) {
    header("Location: index.php"); // Redirect to login if not an admin
    exit;
}

// Fetch all users from the Login table
$query = "SELECT * FROM Login ORDER BY id ASC";
$result = $con->query($query);
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin - User Details</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #f4f4f9;
            margin: 0;
            padding: 0;
        }
        .header {
            background-color: #343a40;
            color: white;
            text-align: center;
            padding: 20px;
            font-size: 1.8em;
            font-weight: bold;
        }
        .container {
            width: 90%;
            margin: 50px auto;
            padding: 20px;
            background-color: white;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
            border-radius: 8px;
        }
        h2 {
            text-align: center;
            color: #333;
            margin-bottom: 20px;
        }
        table {
            width: 100%;
            border-collapse: collapse;
            margin: 20px 0;
        }
        table, th, td {
            border: 1px solid #ddd;
        }
        th, td {
            padding: 12px;
            text-align: left;
        }
        th {
            background-color: #041d36;
            color: white;
        }
        td {
            background-color: #f9f9f9;
        }
        a {
            color: #041d36;
            text-decoration: none;
        }
        a:hover {
            text-decoration: underline;
        }
        .back-btn {
            display: inline-block;
            padding: 10px 20px;
            background-color: #041d36;
            color: white;
            text-decoration: none;
            border-radius: 5px;
            margin-top: 20px;
        }
        .back-btn:hover {
            background-color: #032b4f;
        }
    </style>
</head>
<body>

<div class="header">
    Admin Dashboard - User Details
</div>

<div class="container">
    <h2>User Details</h2>

    <!-- User table -->
    <table>
        <tr>
            <th>ID</th>
            <th>Name</th>
            <th>Email</th>
            <th>Phone</th>
            <th>Actions</th>
        </tr>
        <?php
        // Display users data
        if ($result->num_rows > 0) {
            while ($row = $result->fetch_assoc()) {
                echo "<tr>
                        <td>" . $row['id'] . "</td>
                        <td>" . htmlspecialchars($row['Name']) . "</td>
                        <td>" . htmlspecialchars($row['Num']) . "</td>
                        <td>" . htmlspecialchars($row['Phone']) . "</td>
                        <td>
                            <a href='edit_user.php?id=" . $row['id'] . "'>Edit</a> | 
                            <a href='delete_user.php?id=" . $row['id'] . "' onclick=\"return confirm('Are you sure you want to delete this user?');\">Delete</a>
                        </td>
                      </tr>";
            }
        } else {
            echo "<tr><td colspan='5'>No users found.</td></tr>";
        }
        ?>
    </table>

    <!-- Back button -->
    <a href="admin.php" class="back-btn">Back to Dashboard</a>
</div>

</body>
</html>

<?php
// Close the database connection
$con->close();
?>
