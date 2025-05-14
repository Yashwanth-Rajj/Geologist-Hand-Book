<?php
include('Connection.php');

if (isset($_GET['id'])) {
    $id = intval($_GET['id']); // Sanitize input to prevent SQL injection

    // Prepare the DELETE query
    $stmt = $con->prepare("DELETE FROM Login WHERE id = ?");
    $stmt->bind_param("i", $id);

    if ($stmt->execute()) {
        header("Location: admin.php?message=User deleted successfully");
        exit;
    } else {
        echo "Error: Unable to delete user. " . $stmt->error;
    }

    $stmt->close();
} else {
    echo "Invalid request.";
}

$con->close();
?>
