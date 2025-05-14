<?php
include 'Connection.php'; // Include the database connection

if (isset($_POST['submit'])) {
    // Sanitize and validate input data
    $ruleNumber = htmlspecialchars(trim($_POST['fname']));  // Rule Number
    $description = htmlspecialchars(trim($_POST['lname'])); // Description
    $clause = !empty($_POST['Email']) ? htmlspecialchars(trim($_POST['Email'])) : null; // Clause
    $subClause = !empty($_POST['Mobile']) ? htmlspecialchars(trim($_POST['Mobile'])) : null; // Sub-Clause

    // Check database connection
    if (!$con) {
        die("<div class='alert alert-danger'>Database connection failed: " . mysqli_connect_error() . "</div>");
    }

    // Validate required fields
    if (empty($ruleNumber) || empty($description)) {
        echo "<div class='alert alert-danger'>Please fill in both Rule Number and Description.</div>";
    } else {
        // Prepare the SQL statement to prevent SQL injection
        $sql = "INSERT INTO Mine (fname, lname, email, Mobile) VALUES (?, ?, ?, ?)";
        $stmt = $con->prepare($sql);

        // Check if the statement was prepared successfully
        if ($stmt) {
            // Bind parameters to the prepared statement
            $stmt->bind_param("ssss", $ruleNumber, $description, $clause, $subClause);

            // Execute the prepared statement
            if ($stmt->execute()) {
                echo "<div class='alert alert-success'>Data Inserted Successfully!</div>";
            } else {
                echo "<div class='alert alert-danger'>Error inserting data: " . $stmt->error . "</div>";
            }

            // Close the statement
            $stmt->close();
        } else {
            echo "<div class='alert alert-danger'>Failed to prepare the SQL statement.</div>";
        }
    }
}
?>
<!doctype html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.4.1/dist/css/bootstrap.min.css"
        integrity="sha384-Vkoo8x4CGsO3+Hhxv8T/Q5PaXtkKtu6ug5TOeNV6gBiFeWPGFN9MuhOf23Q9Ifjh" crossorigin="anonymous">
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.8/dist/umd/popper.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@4.4.1/dist/js/bootstrap.min.js"
        integrity="sha384-wfSDF2E50Y2D1uUdj0O3uMBJnjuuRv3W5HzQHc7Sjq/Jzj69j/n8uQe7BScO3nm9"
        crossorigin="anonymous"></script>

    <title>Geologist Handbook - Insert Rule</title>

    <style>
        .large-input {
            height: 120px;
        }
    </style>
</head>

<body>
    <div class="container my-5">
        <h2 class="text-center">Insert Rule Data</h2>
        <form method="post">
            <div class="form-group">
                <label>Rule Number</label>
                <input type="text" class="form-control" placeholder="Enter Rule Number" name="fname" required>
            </div>
            <div class="form-group">
                <label>Description</label>
                <textarea class="form-control large-input" placeholder="Enter Description" name="lname" required></textarea>
            </div>
            <div class="form-group">
                <label>Clause</label>
                <textarea class="form-control large-input" placeholder="Enter Clause" name="Email"></textarea>
            </div>
            <div class="form-group">
                <label>Sub Clause</label>
                <textarea class="form-control large-input" placeholder="Enter Sub Clause" name="Mobile"></textarea>
            </div>
            <button class="btn btn-dark btn-lg my-3" name="submit" type="submit">Submit</button>
        </form>

        <!-- Search Button Section -->
        <h2 class="text-center">Click Here to Search Rules</h2>
        <form action="searchs.php" method="get">
            <div class="input-group mb-3">
                <div class="input-group-append">
                    <button class="btn btn-primary" type="submit">Search</button>
                </div>
            </div>
        </form>
    </div>
</body>

</html>
