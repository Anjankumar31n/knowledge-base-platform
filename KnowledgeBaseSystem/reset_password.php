<?php
require_once "includes/db.php";

if (!isset($_GET['token'])) {
    echo "No token provided.";
    exit;
}

$token = $_GET['token'];

$stmt = $conn->prepare("SELECT user_id FROM users WHERE reset_token = ?");
$stmt->bind_param("s", $token);
$stmt->execute();
$stmt->store_result();

if ($stmt->num_rows === 0) {
    echo "Invalid or expired reset token.";
    exit;
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $new_password = password_hash($_POST['new_password'], PASSWORD_BCRYPT);
    $stmt = $conn->prepare("UPDATE users SET password = ?, reset_token = NULL WHERE reset_token = ?");
    $stmt->bind_param("ss", $new_password, $token);
    if ($stmt->execute()) {
        echo "<p style='color:green;text-align:center;'>Password has been reset. <a href='login.php'>Login here</a></p>";
    } else {
        echo "<p style='color:red;text-align:center;'>Something went wrong.</p>";
    }
    exit;
}
?>

<!DOCTYPE html>
<html>
<head>
  <title>Reset Password</title>
  <style>
    body {
      background: #f4f6f9;
      font-family: 'Segoe UI', sans-serif;
    }
    .container {
      width: 400px;
      margin: 80px auto;
      padding: 30px;
      background: white;
      box-shadow: 0 4px 12px rgba(0,0,0,0.1);
      border-radius: 10px;
    }
    h2 {
      text-align: center;
      margin-bottom: 20px;
      color: #2c3e50;
    }
    input {
      width: 100%;
      padding: 12px;
      margin: 10px 0;
      border: 1px solid #ccc;
      border-radius: 6px;
    }
    button {
      width: 100%;
      padding: 12px;
      background: #3498db;
      border: none;
      color: white;
      border-radius: 6px;
      cursor: pointer;
    }
    button:hover {
      background: #2980b9;
    }
    .back-home {
  text-align: center;
  margin-top: 30px;
}

.back-home a {
  display: inline-block;
  text-decoration: none;
  color: #3498db;
  font-weight: bold;
  font-size: 16px;
  padding: 10px 20px;
  border: 2px solid #3498db;
  border-radius: 25px;
  transition: 0.3s ease;
}

.back-home a:hover {
  background-color: #3498db;
  color: white;
  box-shadow: 0 4px 10px rgba(0, 0, 0, 0.1);
}

  </style>
</head>
<body>
    <p class="back-home">
  <a href="index.php">← Back to Home</a>
</p>

  <div class="container">
    <h2>Reset Password</h2>
    <form method="POST">
      <input type="password" name="new_password" placeholder="Enter new password" required>
      <button type="submit">Reset Password</button>
      <a href="index.html" style="display:inline-block; text-align:center; background:#ddd; padding:10px 20px; border-radius:6px; color:#333; text-decoration:none;">← Back to Home</a>
    </form>
  </div>
</body>
</html>
