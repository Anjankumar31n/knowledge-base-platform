<?php
require_once "includes/db.php";

$alertMessage = '';
$alertClass = '';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $email = $_POST["email"];
    $token = bin2hex(random_bytes(32));

    $stmt = $conn->prepare("UPDATE users SET reset_token = ? WHERE email = ?");
    $stmt->bind_param("ss", $token, $email);
    $stmt->execute();

    if ($stmt->affected_rows > 0) {
        $alertClass = 'success';
        $alertMessage = "Password reset link generated!<br><a href='reset_password.php?token=$token'>Click here to reset your password</a>";
    } else {
        $alertClass = 'error';
        $alertMessage = "Email not found or failed to generate reset link.";
    }
}
?>

<!DOCTYPE html>
<html>
<head>
  <title>Forgot Password</title>
  <style>
    body {
      background: #f4f6f9;
      font-family: 'Segoe UI', sans-serif;
    }

    .container {
      width: 400px;
      margin: 60px auto;
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
      margin-top: 20px;
    }

    .back-home a {
      display: inline-block;
      padding: 10px 20px;
      background-color: #ecf0f1;
      color: #3498db;
      text-decoration: none;
      font-weight: 500;
      border-radius: 25px;
      font-size: 16px;
      box-shadow: 0 2px 6px rgba(0, 0, 0, 0.1);
      transition: all 0.3s ease;
    }

    .back-home a:hover {
      background-color: #3498db;
      color: #fff;
      transform: scale(1.05);
    }

    .alert {
      width: 90%;
      max-width: 500px;
      margin: 20px auto;
      padding: 20px;
      border-radius: 8px;
      font-size: 16px;
      text-align: center;
      box-shadow: 0 4px 10px rgba(0,0,0,0.1);
    }

    .alert.success {
      background-color: #e8f9e9;
      color: #2e7d32;
      border-left: 5px solid #2ecc71;
    }

    .alert.error {
      background-color: #fdecea;
      color: #c0392b;
      border-left: 5px solid #e74c3c;
    }

    .alert a {
      display: inline-block;
      margin-top: 10px;
      padding: 8px 16px;
      background: #3498db;
      color: white;
      text-decoration: none;
      border-radius: 6px;
      transition: 0.3s;
    }

    .alert a:hover {
      background: #2980b9;
    }
  </style>
</head>
<body>

  <?php if (!empty($alertMessage)): ?>
    <div class="alert <?= $alertClass ?>">
      <?= $alertMessage ?>
    </div>
  <?php endif; ?>

  <div class="container">
    <h2>Forgot Password</h2>
    <form method="POST">
      <input type="email" name="email" placeholder="Enter your email" required>
      <button type="submit">Send Reset Link</button>
    </form>
  </div>

  <div class="back-home">
    <a href="index.php">← Back to Home</a>
  </div>

</body>
</html>
