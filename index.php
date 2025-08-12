<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Login Page</title>
  <!-- Bootstrap CSS -->
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
  <style>
  .container {
    position: relative;
    background: url('phpimage.jpg') no-repeat center center;
    background-size: cover;
    border-radius: 10px;
    overflow: hidden; /* keep blur inside container */
  }

  /* Overlay layer for blur + opacity without affecting the form */
  .container::before {
    content: "";
    position: absolute;
    top: 0; left: 0;
    width: 100%; height: 100%;
    background: inherit; /* same image */
    filter: blur(5px);
    opacity: 0.7; /* adjust dimness */
    z-index: 0;
  }

  /* Keep the card above the blur */
  .card {
    position: relative;
    z-index: 1;
  }

  .card {
    background: rgba(255, 255, 255, 0.6); /* soft transparency */
    border: 2px solid #d4af37; /* royal gold border */
    border-radius: 15px;
    box-shadow: 0px 8px 25px rgba(0, 0, 0, 0.2);
  }

  .card h3 {
    color: #1a3d7c; /* deep royal blue for header */
    font-weight: bold;
  }

  .btn-primary {
    background-color: #d4af37; /* gold button */
    border-color: #d4af37;
    font-weight: bold;
  }

  .btn-primary:hover {
    background-color: #b7950b; /* darker gold on hover */
    border-color: #b7950b;
  }
</style>





</head>
<body class="bg-light">

<?php

$servername="localhost";
$username="root";
$password="muskan591";
$database="loginsystem";


// create a connectin to mysql database using php...
$conn=mysqli_connect($servername,$username,$password,$database);

if(!$conn)
{
    die("sorry we failed to connect to database.");
}
else
{
    echo "Connection successfully done.";
}






session_start(); // Always at the very top

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $username = $_POST['username'];
    $password = $_POST['password'];




    // Insert into database
    $sql = "INSERT INTO users (username, password) VALUES ('$username', '$password')";
    mysqli_query($conn, $sql);

    // Save alert flag in session
    $_SESSION['show_alert'] = true;

    // Redirect to avoid resubmission
    header("Location: /loginform/dashboard.php");
    exit;
}

// This will run on GET after redirect
if (isset($_SESSION['show_alert'])) {
    echo '<div class="alert alert-info" role="alert">
        Welldone, you have submitted the login button!!
    </div>';
    unset($_SESSION['show_alert']); // clear the flag
}





?>

  <div class="container vh-100 d-flex justify-content-center align-items-center">
    <div class="card shadow p-4" style="width: 390px; height: 400px;">
      <h3 class="text-center mb-4">Login</h3>
      <form action="/loginform/index.php" method="post">
        <!-- Username -->
        <div class="mb-3">
          <label for="username" class="form-label">Username</label>
          <input type="text" name="username" id="username" class="form-control" placeholder="Enter username" required>
        </div>
        <!-- Password -->
        <div class="mb-3">
          <label for="password" class="form-label">Password</label>
          <input type="password" name="password" id="password" class="form-control" placeholder="Enter password" required>
        </div>
        <br><br>
        <!-- Login Button -->
        <button type="submit" class="btn btn-primary w-100 login-btn">Login</button>
      </form>
    </div>
  </div>



  <script>
    // Get the button using its class name
    const loginButton = document.querySelector(".login-btn");

    // Add click event handler
    loginButton.onclick = function() {
      alert("Login button clicked!");
    };
  </script>

  <!-- Bootstrap JS -->
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
