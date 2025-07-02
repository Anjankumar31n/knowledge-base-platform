<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0"/>
  <title>Knowledge Base</title>
  <style>
    * {
      box-sizing: border-box;
      margin: 0;
      padding: 0;
      font-family: 'Segoe UI', sans-serif;
    }

    body {
      background: #f4f6f9;
      color: #333;
    }

    /* Top Navbar */
    .navbar {
      display: flex;
      justify-content: space-between;
      align-items: center;
      background: #2c3e50;
      padding: 15px 30px;
      color: white;
    }

    .navbar h2 {
      font-weight: normal;
    }

    .user-icon {
      width: 35px;
      height: 35px;
      background: url('https://cdn-icons-png.flaticon.com/512/149/149071.png') no-repeat center center / cover;
      cursor: pointer;
      border-radius: 50%;
    }

    /* Slide Login/Register Panel */
    .modal {
      position: fixed;
      top: 0;
      right: -400px;
      width: 350px;
      height: 100%;
      background: white;
      box-shadow: -2px 0 10px rgba(0,0,0,0.2);
      transition: 0.4s ease;
      padding: 30px 20px;
      z-index: 1000;
    }

    .modal.active {
      right: 0;
    }

    .modal h3 {
      margin-bottom: 20px;
      color: #2c3e50;
    }

    .tabs {
      display: flex;
      justify-content: space-around;
      margin-bottom: 15px;
      cursor: pointer;
    }

    .tab {
      padding: 10px 15px;
      border-bottom: 2px solid transparent;
    }

    .tab.active {
      border-bottom: 2px solid #3498db;
      font-weight: bold;
    }

    .form-container {
      display: none;
    }

    .form-container.active {
      display: block;
    }

    input[type="text"], input[type="password"], input[type="email"] {
      width: 100%;
      padding: 10px;
      margin: 10px 0 20px 0;
      border: 1px solid #ccc;
      border-radius: 5px;
    }

    button {
      width: 100%;
      background: #3498db;
      color: white;
      padding: 10px;
      border: none;
      border-radius: 5px;
      cursor: pointer;
    }

    button:hover {
      background: #2980b9;
    }

    /* Project Info Section */
    .info-section {
      padding: 40px;
      max-width: 1000px;
      margin: auto;
    }

    .card {
      background: white;
      padding: 30px;
      border-radius: 12px;
      box-shadow: 0 4px 12px rgba(0,0,0,0.1);
      margin-top: 20px;
    }

    .card h3 {
      margin-bottom: 15px;
      color: #2c3e50;
    }

    .card p {
      line-height: 1.6;
    }
    .action-btn {
  width: 100%;
  padding: 12px;
  margin: 10px 0;
  background: #3498db;
  border: none;
  color: white;
  border-radius: 8px;
  font-size: 16px;
  cursor: pointer;
  transition: 0.3s;
}

.action-btn:hover {
  background: #2980b9;
}
.modal-header {
  display: flex;
  justify-content: space-between;
  align-items: center;
  padding: 20px;
  border-bottom: 1px solid #eee;
}

.close-btn {
  font-size: 24px;
  font-weight: bold;
  cursor: pointer;
  color: #888;
  transition: 0.3s;
}

.close-btn:hover {
  color: #000;
}



    /* Footer */
    footer {
      background: #2c3e50;
      color: white;
      padding: 20px 30px;
      text-align: center;
      margin-top: 40px;
    }

    @media (max-width: 600px) {
      .info-section {
        padding: 20px;
      }

      .modal {
        width: 100%;
      }
    }
  </style>
</head>
<body>

  <div class="navbar">
    <h2>Knowledge Base</h2>
    <div class="user-icon" onclick="toggleModal()"></div>
  </div>

<div class="modal" id="authModal">
  <div class="modal-header">
    <h3>Account Access</h3>
    <span class="close-btn" onclick="toggleModal()">&times;</span>
  </div>
  <p style="text-align: center;">Select what you want to do:</p>
  <div style="margin-top: 20px; padding: 0 20px;">
    <a href="login.php"><button class="action-btn">Login</button></a>
    <a href="register.php"><button class="action-btn">Register</button></a>
    <a href="forgot_password.php"><button class="action-btn">Forgot Password</button></a>
  </div>
</div>
  <!-- Info Section -->
  <div class="info-section">
    <div class="card">
      <h3>About the Project</h3>
      <p>
        The Knowledge Base platform is designed to offer users a secure and organized repository of technical and non-technical content. 
        Users can register, log in, and manage their personal access through secure JWT-based authentication. 
        The system supports password recovery and API-secured content delivery, making it ideal for modern web applications.
      </p>
    </div>
  </div>

  <!-- Footer -->
  <footer>
    &copy; 2025 Knowledge Base Project | Built with ❤️ by Anjankumar N
  </footer>

  <script>
    function toggleModal() {
  document.getElementById('authModal').classList.toggle('active');
}

    function showTab(tabId) {
      const tabs = document.querySelectorAll('.tab');
      const containers = document.querySelectorAll('.form-container');

      tabs.forEach(tab => {
        tab.classList.remove('active');
      });
      containers.forEach(cont => {
        cont.classList.remove('active');
      });

      document.querySelector(`.tab[onclick="showTab('${tabId}')"]`).classList.add('active');
      document.getElementById(tabId).classList.add('active');
    }
  </script>

</body>
</html>
