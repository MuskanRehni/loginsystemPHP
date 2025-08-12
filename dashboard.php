<?php
// Database connection
$servername = "localhost";
$username = "root";
$password = "muskan591";
$database = "loginsystem";

$conn = mysqli_connect($servername, $username, $password, $database);

if (!$conn) {
    die("Database connection failed: " . mysqli_connect_error());
}


// Update note
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['update_note'])) {
    $id = intval($_POST['note_id']);
    $title = mysqli_real_escape_string($conn, $_POST['title']);
    $content = mysqli_real_escape_string($conn, $_POST['content']);

    $sql = "UPDATE notes SET title='$title', content='$content' WHERE id=$id";
    mysqli_query($conn, $sql);
}
// Insert note when form is submitted
elseif ($_SERVER["REQUEST_METHOD"] == "POST") {
    $title = mysqli_real_escape_string($conn, $_POST['title']);
    $content = mysqli_real_escape_string($conn, $_POST['content']);

    $sql = "INSERT INTO notes (title, content) VALUES ('$title', '$content')";
    mysqli_query($conn, $sql);
}


// Delete note
if (isset($_GET['delete'])) {
    $id = intval($_GET['delete']);
    mysqli_query($conn, "DELETE FROM notes WHERE id=$id");
}



// Fetch all notes
$result = mysqli_query($conn, "SELECT * FROM notes ORDER BY created_at DESC");
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>My Notes App</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body class="bg-light">

<div class="container mt-4">
    <h2 class="text-center mb-4">✍️ My Notes</h2>

    <!-- Add Note Form -->
    <form method="POST" class="card p-3 mb-4">
        <input type="text" name="title" class="form-control mb-2" placeholder="Title" required>
        <textarea name="content" class="form-control mb-2" rows="4" placeholder="Take a note..." required></textarea>
        <button type="submit" class="btn btn-primary">Add Note</button>
    </form>

    <!-- Notes Display -->
    <div class="row">
        <?php while ($row = mysqli_fetch_assoc($result)) { ?>
            <div class="col-md-4 mb-3">
                <div class="card h-100">
                    <div class="card-body">
                        <h5><?php echo htmlspecialchars($row['title']); ?></h5>
                        <p><?php echo nl2br(htmlspecialchars($row['content'])); ?></p>

                         <!-- Edit Form -->
                        <form method="POST" class="mt-2">
                            <input type="hidden" name="update_note" value="1">
                            <input type="hidden" name="note_id" value="<?php echo $row['id']; ?>">
                            <input type="text" name="title" class="form-control mb-2" value="<?php echo htmlspecialchars($row['title']); ?>" required>
                            <textarea name="content" class="form-control mb-2" rows="3" required><?php echo htmlspecialchars($row['content']); ?></textarea>
                            <button type="submit" class="btn btn-warning btn-sm">Update</button>
                        </form>

                        <!-- Delete Button -->
                        <a href="?delete=<?php echo $row['id']; ?>" class="btn btn-danger btn-sm mt-2" onclick="return confirm('Delete this note?')">Delete</a>


                    </div>
                    <div class="card-footer text-muted">
                        <?php echo $row['created_at']; ?>
                    </div>
                </div>
            </div>
        <?php } ?>
    </div>
</div>

</body>
</html>
