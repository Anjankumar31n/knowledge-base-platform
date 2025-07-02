<?php
require_once "includes/db.php";

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $name = $_POST["name"];
    $email = $_POST["email"];
    $password = password_hash($_POST["password"], PASSWORD_BCRYPT);

    $stmt = $conn->prepare("INSERT INTO users (name, email, password) VALUES (?, ?, ?)");
    $stmt->bind_param("sss", $name, $email, $password);

    if ($stmt->execute()) {
        echo "<p style='color:green;text-align:center;'>Registration successful. <a href='login.php'>Login here</a></p>";
    } else {
        echo "<p style='color:red;text-align:center;'>Error: Email may already exist.</p>";
    }
}
?>

<!DOCTYPE html>
<html>
<head>
  <title>Register</title>
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
    <h2>Create Account</h2>
    <form method="POST">
      <input name="name" placeholder="Full Name" required>
      <input name="email" type="email" placeholder="Email" required>
      <input name="password" type="password" placeholder="Password" required>
      <button type="submit">Register</button>
    </form>
  </div>
</body>
</html>
