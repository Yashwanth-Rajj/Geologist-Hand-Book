<?php
include 'Connection.php'; // Include the database connection

// Check if the ID is passed via URL and ensure it's numeric
if (isset($_GET['id']) && is_numeric($_GET['id'])) {
    $id = $_GET['id'];

    // Correct SQL query with valid column aliases
    $sql = "SELECT 
                fname AS Act_Rule, 
                lname AS Chapter, 
                email AS Chapter_Name, 
                Mobile AS Section_Rule, 
                Title AS Title, 
                Exp AS Description 
            FROM Mine 
            WHERE ID = ?";

    // Prepare the query
    if ($stmt = $con->prepare($sql)) {
        $stmt->bind_param("i", $id); // Bind the ID parameter
        $stmt->execute();
        $result = $stmt->get_result(); // Execute the query and get the result
    } else {
        echo "<div class='alert alert-danger'>Failed to prepare the query.</div>";
        exit;
    }
} else {
    echo "<div class='alert alert-danger'>Invalid ID provided.</div>";
    exit; // Stop further execution if the ID is invalid
}
?>

<!doctype html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.4.1/dist/css/bootstrap.min.css"
        integrity="sha384-Vkoo8x4CGsO3+Hhxv8T/Q5PaXtkKtu6ug5TOeNV6gBiFeWPGFN9MuhOf23Q9Ifjh" crossorigin="anonymous">
    <title>View Rule Details</title>
</head>
<style>
    body {
        font-family: Arial, sans-serif;
    }

    /* Justify text in the "Explanation" column */
    .card-text {
        text-align: justify;
    }

    .card {
        border: 1px solid #ddd;
        box-shadow: 0 4px 8px rgba(0, 0, 0, 0.2);
    }

    /* Search Results Styling */
    #results-table {
        font-family: Arial, sans-serif;
        margin-top: 20px;
    }

    th {
        background-color: #007bff;
        color: white;
    }

    td {
        padding: 10px;
    }

    .highlight {
        background-color: yellow;
        font-weight: bold;
    }
</style>
<body>
    <div class="container my-5">
        <h1 class="text-center">View Rule Details</h1>

        <?php
        if (isset($result) && $result->num_rows > 0) {
            $row = $result->fetch_assoc(); // Fetch the specific row

            // Determine the header color based on Act/Rule type
            $typeClass = ($row['Act_Rule'] === 'Act') ? 'bg-success' : 'bg-info';
        ?>
            <div class="card my-3">
                <div class="card-header text-white <?php echo $typeClass; ?>">
                    <h5 class="card-title"><?php echo htmlspecialchars($row['Title']); ?></h5>
                </div>
                <div class="card-body">
                    <h6 class="card-subtitle mb-2 text-muted">Act/Rule:</h6>
                    <p class="card-text"><?php echo htmlspecialchars($row['Act_Rule']); ?></p>

                    <h6 class="card-subtitle mb-2 text-muted">Chapter:</h6>
                    <p class="card-text"><?php echo htmlspecialchars($row['Chapter']); ?></p>

                    <h6 class="card-subtitle mb-2 text-muted">Chapter Name:</h6>
                    <p class="card-text"><?php echo htmlspecialchars($row['Chapter_Name']); ?></p>

                    <h6 class="card-subtitle mb-2 text-muted">Section/Rule:</h6>
                    <p class="card-text"><?php echo htmlspecialchars($row['Section_Rule']); ?></p>

                    <h6 class="card-subtitle mb-2 text-muted">Description:</h6>
                    <p class="card-text"><?php echo nl2br(htmlspecialchars($row['Description'])); ?></p>
                </div>
            </div>
        <?php
        } else {
            echo "<div class='alert alert-danger'>No data found for the specified ID.</div>";
        }
        ?>
        <!-- Back Button -->
        <a href="searchs.php" class="btn btn-primary mb-3">Back to Search</a>
    </div>

   
</body>

</html>
