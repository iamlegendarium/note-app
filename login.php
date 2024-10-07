<?php
session_start(); 

include 'db_config.php';

$message = ''; 

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $email = $_POST["email"];
    $password = $_POST["password"];
    
    $sql = "SELECT * FROM `users` WHERE `email` = '$email'";
    $result = $conn->query($sql);

    if ($result->num_rows > 0) {
        $row = $result->fetch_assoc();
        if ($password === $row['password']) {
            $_SESSION['username'] = $row['username']; 
            header("Location: notes.php");
            exit;
        } else {
            $message = "Incorrect password";
        }
    } else {
        $message = "Email not found";
    }

    $conn->close();
}
?>


<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login</title>
    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        /* Custom styles for better typography and layout */
        body {
            font-family: 'Arial', sans-serif;
            background-color: #f8f9fa;
            height: 100vh;
            display: flex;
            flex-direction: column;
        }
        .header {
            background-color: #007bff;
            padding: 20px;
            color: white;
            text-align: center;
        }
        .header h1 {
            margin: 0;
            font-size: 2rem;
        }
        .login-container {
            max-width: 400px;
            margin: auto;
            padding: 40px 20px;
            background-color: white;
            border-radius: 8px;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
            margin-top: 50px;
        }
        .login-container h2 {
            text-align: center;
            margin-bottom: 20px;
            color: #343a40;
            font-weight: 600;
        }
        .login-container p, .login-container a {
            font-size: 1rem;
            color: #495057;
        }
        .footer {
            background-color: #343a40;
            padding: 20px;
            color: white;
            text-align: center;
            margin-top: auto;
        }
        .footer p {
            margin: 0;
            font-size: 0.9rem;
        }
    </style>
</head>
<body>

    <!-- Header -->
    <header class="header">
        <h1>Notes Application</h1>
        <p>Your simple and effective note management tool</p>
    </header>

    <!-- Login Form -->
    <div class="login-container">
        <h2>Login</h2>
        <?php if (!empty($message)) echo "<div class='alert alert-danger'>$message</div>"; ?>
        <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="post">
            <div class="mb-3">
                <input type="email" name="email" class="form-control" placeholder="Email" required>
            </div>
            <div class="mb-3">
                <input type="password" name="password" class="form-control" placeholder="Password" required>
            </div>
            <button type="submit" class="btn btn-primary w-100">Login</button>
        </form>
        <p class="text-center mt-3">Don't have an account? <a href="register.php">Register</a></p>
    </div>

    <!-- Footer -->
    <footer class="footer">
        <p>&copy; 2024 Notes Application. All rights reserved.</p>
    </footer>

    <!-- Bootstrap JS and Popper.js -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.bundle.min.js"></script>

</body>
</html>

