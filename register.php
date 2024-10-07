<?php
include 'db_config.php';

$message = ''; 

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $username = $_POST["username"];
    $password = $_POST["password"];
    $email = $_POST["email"];
    

    $sql = "INSERT INTO `users`(`username`, `password`, `email`) VALUES ('$username', '$password', '$email')";
    if ($conn->query($sql) === TRUE) {

        $notes_table_name = $username . "_notes";
        $sql = "CREATE TABLE IF NOT EXISTS `$notes_table_name` (
            `id` INT AUTO_INCREMENT PRIMARY KEY,
            `title` VARCHAR(255) NOT NULL,
            `content` TEXT NOT NULL,
            `created_at` TIMESTAMP DEFAULT CURRENT_TIMESTAMP
        )";
        if ($conn->query($sql) !== TRUE) {
            $message = "Error creating table: " . $conn->error;
        } else {
         
            header("Location: login.php");
            exit;
        }
    } else {
        $message = "Error: " . $sql . "<br>" . $conn->error;
    }

    $conn->close();
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Registration</title>
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
        .register-container {
            max-width: 400px;
            margin: auto;
            padding: 40px 20px;
            background-color: white;
            border-radius: 8px;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
            margin-top: 50px;
        }
        .register-container h2 {
            text-align: center;
            margin-bottom: 20px;
            color: #343a40;
            font-weight: 600;
        }
        .register-container p, .register-container a {
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

    <!-- Registration Form -->
    <div class="register-container">
        <h2>Registration</h2>
        <?php if (!empty($message)) echo "<div class='alert alert-danger'>$message</div>"; ?>
        <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="post">
            <div class="mb-3">
                <input type="text" name="username" class="form-control" placeholder="Username" required>
            </div>
            <div class="mb-3">
                <input type="email" name="email" class="form-control" placeholder="Email" required>
            </div>
            <div class="mb-3">
                <input type="password" name="password" class="form-control" placeholder="Password" required>
            </div>
            <button type="submit" class="btn btn-primary w-100">Register</button>
        </form>
        <p class="text-center mt-3">Already have an account? <a href="login.php">Login</a></p>
    </div>

    <!-- Footer -->
    <footer class="footer">
        <p>&copy; 2024 Notes Application. All rights reserved.</p>
    </footer>

    <!-- Bootstrap JS and Popper.js -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.bundle.min.js"></script>

</body>
</html>