<?php
include('Connection.php');

if (isset($_GET['id'])) {
    $id = intval($_GET['id']); // Sanitize input

    if ($_SERVER["REQUEST_METHOD"] == "POST") {
        $name = htmlspecialchars($_POST['name']);
        $email = filter_var($_POST['email'], FILTER_SANITIZE_EMAIL);
        $phone = htmlspecialchars($_POST['phone']);

        // Update the user details
        $stmt = $con->prepare("UPDATE Login SET Name = ?, Num = ?, Phone = ? WHERE id = ?");
        $stmt->bind_param("sssi", $name, $email, $phone, $id);

        if ($stmt->execute()) {
            header("Location: admin.php?message=User updated successfully");
            exit;
        } else {
            echo "Error: Unable to update user. " . $stmt->error;
        }
    } else {
        // Fetch existing user details
        $stmt = $con->prepare("SELECT * FROM Login WHERE id = ?");
        $stmt->bind_param("i", $id);
        $stmt->execute();
        $result = $stmt->get_result();

        if ($result->num_rows == 1) {
            $user = $result->fetch_assoc();
        } else {
            echo "User not found.";
            exit;
        }
    }
} else {
    echo "Invalid request.";
    exit;
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edit User</title>
</head>
<body>
    <h2>Edit User</h2>
    <form method="post" action="">
        <label for="name">Name:</label>
        <input type="text" name="name" value="<?php echo htmlspecialchars($user['Name']); ?>" required>
        
        <label for="email">Email:</label>
        <input type="email" name="email" value="<?php echo htmlspecialchars($user['Num']); ?>" required>
        
        <label for="phone">Phone:</label>
        <input type="tel" name="phone" value="<?php echo htmlspecialchars($user['Phone']); ?>" required>
        
        <button type="submit">Update</button>
    </form>
</body>
</html>
