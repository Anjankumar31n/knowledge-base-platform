<?php
session_start();
require_once "includes/db.php";
require_once "includes/jwt_helper.php";

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $email = $_POST["email"];
    $password = $_POST["password"];

    // Fetch user_id, hashed_password and name in one query
    $stmt = $conn->prepare("SELECT user_id, password, name FROM users WHERE email = ?");
    $stmt->bind_param("s", $email);
    $stmt->execute();
    $stmt->store_result();
    $stmt->bind_result($user_id, $hashed_password, $user_name);

    if ($stmt->num_rows > 0 && $stmt->fetch()) {
        if (password_verify($password, $hashed_password)) {
            $token = generate_jwt($user_id);
            $_SESSION['jwt_token'] = $token;
            $_SESSION['user_id'] = $user_id;
            $_SESSION['user_name'] = $user_name;

            header("Location: dashboard.php");
            exit;
        } else {
            $error = "Incorrect password.";
        }
    } else {
        $error = "User not found.";
    }
}
?>

<!DOCTYPE html>
<html>
<head>
  <title>Login</title>
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
    a {
      color: #3498db;
      display: block;
      margin-top: 10px;
      text-align: center;
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
    .error {
      color: red;
      text-align: center;
      margin-bottom: 10px;
    }
  </style>
</head>
<body>
  <p class="back-home">
    <a href="index.php">← Back to Home</a>
  </p>

  <div class="container">
    <h2>Login</h2>
    
    <?php if (isset($error)): ?>
      <p class="error"><?php echo htmlspecialchars($error); ?></p>
    <?php endif; ?>

    <form method="POST">
      <input name="email" type="email" placeholder="Email" required>
      <input name="password" type="password" placeholder="Password" required>
      <button type="submit">Login</button>
    </form>
    <a href="forgot_password.php">Forgot Password?</a>
  </div>
</body>
</html>
