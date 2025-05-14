<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Geologist Handbook</title>
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
            padding: 20px 0;
            font-size: 1.8em;
            font-weight: bold;
        }
        .container {
            width: 100%;
            max-width: 400px;
            margin: 20px auto;
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
            color: #041d36;
        }
        input[type="email"],
        input[type="password"] {
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
        .signup-link {
            text-align: center;
            margin-top: 20px;
        }
        .signup-link a {
            color: #041d360;
            text-decoration: none;
        }
        .signup-link a:hover {
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
            .input{
                max-width: 50%;
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
    <h2>Login</h2>

    <?php
    // Handle login process
    if ($_SERVER["REQUEST_METHOD"] == "POST") {
        include 'Connection.php';  // Include the database connection

        $username = $_POST['num'];  // Email field (used for admin and user)
        $password = $_POST['pass'];  // Password field

        // Validate Admin Login
        $admin_sql = "SELECT * FROM admins WHERE username = ?";
        $stmt = $con->prepare($admin_sql);
        $stmt->bind_param("s", $username);
        $stmt->execute();
        $admin_result = $stmt->get_result();

        if ($admin_result->num_rows > 0) {
            $admin_row = $admin_result->fetch_assoc();
            if ($password === $admin_row['password']) {  // Direct comparison; update if passwords are hashed
                session_start();
                $_SESSION['admin'] = $username;
                header("Location: admin.php"); // Redirect to admin page
                exit();
            } else {
                echo "<p style='color: red;'>Invalid admin username or password.</p>";
            }
        } else {
            // Validate Regular User Login
            $user_sql = "SELECT * FROM Login WHERE Num = ?";
            $stmt = $con->prepare($user_sql);
            $stmt->bind_param("s", $username);
            $stmt->execute();
            $user_result = $stmt->get_result();

            if ($user_result->num_rows > 0) {
                $user_row = $user_result->fetch_assoc();
                if ($password === $user_row['Pass']) {  // Direct comparison; update if passwords are hashed
                   
                        session_start();
                        $_SESSION['user'] = $username;
                        header("Location: searchs.php"); // Redirect to user page
                        exit();
                    } else {
                        echo "<p style='color: red;'>Your account is awaiting admin approval.</p>";
                    }
                } else {
                    echo "<p style='color: red;'>Invalid email or password.</p>";
                }
            } 
        }

        
        
    ?>

    <!-- Login Form -->
    <form method="post" action="index.php">
        <label for="num">Username (or Email):</label>
        <input type="email" name="num" required>

        <label for="pass">Password:</label>
        <input type="password" name="pass" required>

        <input type="submit" value="Login">
    </form>

    <!-- Sign-up Link -->
    <div class="signup-link">
        <p>Don't have an account? <a href="signup.php">Sign up here</a></p>
    </div>
</div>

</body>
</html>
