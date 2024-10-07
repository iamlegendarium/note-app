<?php
session_start(); 

include 'db_config.php';


if (!isset($_SESSION['username'])) {
    header("Location: login.php");
    exit;
}

$username = $_SESSION['username'];


if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['create_note'])) {
    $title = $_POST['title'];
    $content = $_POST['content'];

    
    $notes_table_name = $username . "_notes";

    
    $title = mysqli_real_escape_string($conn, $title);
    $content = mysqli_real_escape_string($conn, $content);

   
    $sql = "INSERT INTO `$notes_table_name` (`title`, `content`) VALUES ('$title', '$content')";
    $result = $conn->query($sql);

    if ($result) {
        $message = "Note created successfully";
    } else {
        $message = "Error creating note: " . $conn->error;
    }
}


if (isset($_GET['delete'])) {
    $note_id = $_GET['delete'];

   
    $notes_table_name = $username . "_notes";

    
    $sql = "DELETE FROM `$notes_table_name` WHERE `id` = $note_id";
    $result = $conn->query($sql);

    if ($result) {
        $message = "Note deleted successfully";
    } else {
        $message = "Error deleting note: " . $conn->error;
    }
}

if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['edit_note'])) {
    $note_id = $_POST['note_id'];
    $title = $_POST['title'];
    $content = $_POST['content'];

 
    $notes_table_name = $username . "_notes";

    
    $title = mysqli_real_escape_string($conn, $title);
    $content = mysqli_real_escape_string($conn, $content);

    $sql = "UPDATE `$notes_table_name` SET `title`='$title', `content`='$content' WHERE `id`='$note_id'";
    $result = $conn->query($sql);

    if ($result) {
        $message = "Note updated successfully";
    } else {
        $message = "Error updating note: " . $conn->error;
    }
}

$notes_table_name = $username . "_notes";
$sql = "SELECT * FROM `$notes_table_name`";
$result = $conn->query($sql);

$notes = [];
if ($result->num_rows > 0) {
    while ($row = $result->fetch_assoc()) {
        $notes[] = $row;
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Notes Application</title>
    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        /* Custom styles for better typography and layout */
        body {
            font-family: 'Arial', sans-serif;
            background-color: #f8f9fa;
        }
        h1, h2, h3 {
            font-weight: 600;
            color: #343a40;
        }
        p, li {
            font-size: 1.1rem;
            color: #495057;
        }
        .note-actions button {
            font-size: 0.9rem;
        }
        .header {
            background-color: #007bff;
            padding: 20px;
            color: white; /* White header text */
            text-align: center;
        }
        .header h1, .header p {
            margin: 0;
            color: white; /* White text for both h1 and p */
        }
        .footer {
            background-color: #343a40;
            padding: 20px;
            color: white; /* White footer text */
            text-align: center;
        }
        .footer p {
            margin: 0;
            font-size: 0.9rem;
            color: white; /* White text in the footer */
        }
        .logout-btn {
            padding: 10px 20px;
            font-size: 0.9rem;
        }
        .card {
            margin-bottom: 40px;
        }
    </style>
</head>
<body>

    <!-- Header -->
    <header class="header">
        <h1>Notes Application</h1>
        <p>Your simple and effective note management tool</p>
    </header>

    <!-- Main Content -->
    <div class="container mt-5">
        <div class="card shadow-sm p-4">
            <header class="d-flex justify-content-between align-items-center mb-4">
                <h2>Welcome, <?php echo $username; ?>!</h2>
                <a href="logout.php" class="btn btn-danger logout-btn">Logout</a>
            </header>

            <!-- Note Creation Form -->
            <section class="mb-4">
                <h3>Create a New Note</h3>
                <?php if (isset($message)) echo "<div class='alert alert-info'>$message</div>"; ?>
                <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="post">
                    <div class="mb-3">
                        <input type="text" name="title" class="form-control" placeholder="Note Title" required>
                    </div>
                    <div class="mb-3">
                        <textarea name="content" class="form-control" placeholder="Note Content" rows="4" required></textarea>
                    </div>
                    <button type="submit" name="create_note" class="btn btn-primary">Create Note</button>
                </form>
            </section>

            <!-- Your Notes Section -->
            <section>
                <h3>Your Notes</h3>
                <?php if (!empty($notes)) : ?>
                    <ul class="list-group">
                        <?php foreach ($notes as $note) : ?>
                            <li class="list-group-item mb-3">
                                <strong><?php echo $note['title']; ?></strong>
                                <p class="mt-2"><?php echo $note['content']; ?></p>
                                <div class="d-flex justify-content-start gap-2 mt-3 note-actions">
                                    <button class="btn btn-outline-primary btn-sm edit-btn">Edit</button>

                                    <form class="edit-form" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="post" style="display: none;">
                                        <input type="hidden" name="note_id" value="<?php echo $note['id']; ?>">
                                        <div class="mb-2">
                                            <input type="text" name="title" value="<?php echo $note['title']; ?>" class="form-control" required>
                                        </div>
                                        <div class="mb-2">
                                            <textarea name="content" rows="2" class="form-control" required><?php echo $note['content']; ?></textarea>
                                        </div>
                                        <button type="submit" name="edit_note" class="btn btn-success btn-sm">Save</button>
                                    </form>

                                    <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="get" class="d-inline">
                                        <input type="hidden" name="delete" value="<?php echo $note['id']; ?>">
                                        <button type="submit" class="btn btn-danger btn-sm">Delete</button>
                                    </form>
                                </div>
                            </li>
                        <?php endforeach; ?>
                    </ul>
                <?php else : ?>
                    <p class="text-muted">No notes found.</p>
                <?php endif; ?>
            </section>
        </div>
    </div>

    <!-- Footer -->
    <footer class="footer">
        <p>&copy; 2024 Notes Application. All rights reserved.</p>
    </footer>

    <!-- Bootstrap JS and Popper.js -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.bundle.min.js"></script>

    <!-- Toggle Edit Form -->
    <script>
        document.querySelectorAll('.edit-btn').forEach(function(button) {
            button.addEventListener('click', function() {
                var editForm = this.nextElementSibling;
                editForm.style.display = editForm.style.display === 'none' ? 'block' : 'none';
            });
        });
    </script>
</body>
</html>
