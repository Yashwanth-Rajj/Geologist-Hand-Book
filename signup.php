<?php
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    include('Connection.php');




    // Retrieve and sanitize data from the form
    $num = filter_var($_POST['num'], FILTER_SANITIZE_EMAIL);
    $pass = $_POST['pass']; // Storing raw password
    $name = htmlspecialchars($_POST['name']);
    $phone = htmlspecialchars($_POST['phone']);

    // Validate email format
    if (!filter_var($num, FILTER_VALIDATE_EMAIL)) {
        echo "<script>alert('Invalid email format.');
         window.location.href = 'signup.php'; // Redirect to signup page
        </script>";
        exit;
    }

    // Validate phone number format (assuming 10-digit numbers)
    if (!preg_match('/^\d{10}$/', $phone)) {
        echo "<script>alert('Invalid phone number format.');
         window.location.href = 'signup.php'; // Redirect to signup page
        </script>";
        exit;
    }

    // Check for duplicate email
    $stmt = $con->prepare("SELECT COUNT(*) FROM Login WHERE Num = ?");
    $stmt->bind_param("s", $num);
    $stmt->execute();
    $stmt->bind_result($count);
    $stmt->fetch();
    $stmt->close();

    if ($count > 0) {
        echo "<script>alert('Email already registered Please Login.');
         window.location.href = 'index.php'; // Redirect to login page
        </script>";
        exit;
    }

    // Check for duplicate phone number
    $stmt = $con->prepare("SELECT COUNT(*) FROM Login WHERE Phone = ?");
    $stmt->bind_param("s", $phone);
    $stmt->execute();
    $stmt->bind_result($count);
    $stmt->fetch();
    $stmt->close();

    if ($count > 0) {
        echo "<script>
                alert('Phone number already registered Please Login.');
                window.location.href = 'index.php'; // Redirect to login page
              </script>";
        exit;
    }
    

    // Insert new user into the database with raw password
    $stmt = $con->prepare("INSERT INTO Login (Num, Pass, Name, Phone) VALUES (?, ?, ?, ?)");
    $stmt->bind_param("ssss", $num, $pass, $name, $phone);

    if ($stmt->execute()) {
      // Redirect to Searchs.php after successful sign-up
        header("Location: Searchs.php");
        exit;
    } else {
        echo "<script>alert('An error occurred during registration. Please try again later.');</script>";
    }

    $stmt->close();
    $con->close();
}



?>





<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Sign Up - Geologist Handbook</title>
    <style>
        /* Style definitions */
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
            padding: 20px 0;
            font-size: 1.8em;
            font-weight: bold;
        }
        .container {
            width: 100%;
            max-width: 400px;
            margin: 100px auto;
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
        label {
            font-size: 1.1em;
            margin-bottom: 10px;
            display: block;
            color: #333;
        }
        input[type="email"], input[type="password"], input[type="text"], input[type="tel"] {
            width: 90%;
            padding: 10px;
            margin: 10px 0 20px 0;
            border: 1px solid #ccc;
            border-radius: 4px;
            font-size: 1em;
        }
        input[type="submit"] {
            background-color: #041d36;
            color: white;
            border: none;
            padding: 12px;
            font-size: 1.1em;
            width: 100%;
            cursor: pointer;
            border-radius: 4px;
        }
        input[type="submit"]:hover {
            background-color: #041d36;
        }
        .login-link {
            text-align: center;
            margin-top: 20px;
        }
        .login-link a {
            color: #041d360;
            text-decoration: none;
        }
        .login-link a:hover {
            text-decoration: underline;
        }

        /* Responsive Design */
        @media (max-width: 900px) {
            .container {
                padding: 15px;
                margin: 20px auto;
                max-width: 82%;
            }
            .header {
                font-size: 1.5em;
                padding: 15px 1;
            }
            h2 {
                font-size: 1.5em;
            }
            input[type="email"],
            input[type="password"],
            input[type="submit"] {
                font-size: 1em;
                padding: 8px;
                width: 90%;
            }
        }
    </style>
</head>
<body>

<div class="header">
    Geologist Handbook
</div>

<div class="container">
    <h2>Sign Up</h2>

    <form method="post" action="signup.php">
        <label for="name">Name:</label>
        <input type="text" name="name" required>

        <label for="phone">Phone Number:</label>
        <input type="tel" name="phone" required>
        
        <label for="num">Email:</label>
        <input type="email" name="num" required>

        <label for="pass">Password:</label>
        <input type="password" name="pass" required>

        <input type="submit" value="Sign Up">
    </form>

    <div class="login-link">
        <p>Already have an account? <a href="index.php">Login here</a></p>
    </div>
</div>

</body>
</html>
