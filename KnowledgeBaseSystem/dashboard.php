<?php
session_start();
if (!isset($_SESSION['user_id']) || !isset($_SESSION['user_name'])) {
  header("Location: login.php");
  exit();
}
?>
<!DOCTYPE html>
<html>
<head>
  <title>Document Dashboard</title>
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">
  <link rel="stylesheet" href="dashboard-style.css"> <!-- Add this line -->
  <style>
    body {
      font-family: 'Segoe UI', sans-serif;
      margin: 0;
      background: #f7f9fc;
    }
    .header {
      background: #2c3e50;
      color: white;
      padding: 20px;
      text-align: center;
    }
    .container {
      max-width: 1100px;
      margin: 30px auto;
      background: white;
      padding: 20px;
      border-radius: 10px;
      box-shadow: 0 2px 10px rgba(0,0,0,0.1);
    }
    .top-bar {
      display: flex;
      justify-content: space-between;
      align-items: center;
      margin-bottom: 20px;
    }
    .top-bar input {
      padding: 8px 12px;
      width: 300px;
      border: 1px solid #ccc;
      border-radius: 6px;
    }
    .top-bar button {
      padding: 10px 15px;
      background: #3498db;
      color: white;
      border: none;
      border-radius: 6px;
      cursor: pointer;
    }
    table {
      width: 100%;
      border-collapse: collapse;
    }
    th, td {
      padding: 12px 10px;
      border-bottom: 1px solid #eee;
      text-align: left;
    }
    th {
      background-color: #ecf0f1;
    }
    .action-icons a {
      margin-right: 10px;
      color: #3498db;
      text-decoration: none;
      cursor: pointer;
    }
    .public {
      color: green;
      font-weight: bold;
    }
    .private {
      color: red;
      font-weight: bold;
    }
    .slide-panel {
      position: fixed;
      top: 0;
      right: -100%;
      width: 50%;
      height: 100%;
      background: #fff;
      box-shadow: -2px 0 10px rgba(0,0,0,0.2);
      padding: 20px;
      overflow-y: auto;
      transition: right 0.3s ease;
      z-index: 9999;
    }
    .slide-panel.active {
      right: 0;
    }
    
    .slide-panel-close {
      float: right;
      font-size: 20px;
      cursor: pointer;
      color: #2c3e50;
    }
    .slide-panel {
  position: fixed;
  top: 0;
  right: -100%;
  width: 50%;
  height: 100%;
  background: #ffffff;
  box-shadow: -4px 0 12px rgba(0, 0, 0, 0.15);
  padding: 30px;
  overflow-y: auto;
  transition: right 0.4s ease;
  z-index: 1000;
  border-left: 5px solid #3498db;
  border-radius: 0 0 0 10px;
}

.slide-panel.active {
  right: 0;
}

.slide-panel-close {
  position: absolute;
  top: 15px;
  right: 20px;
  font-size: 22px;
  font-weight: bold;
  color: #2c3e50;
  cursor: pointer;
  transition: color 0.3s;
}

.slide-panel-close:hover {
  color: #e74c3c;
}

#slideContent {
  margin-top: 40px;
}

.slide-panel h2 {
  color: #2c3e50;
  margin-bottom: 20px;
  border-bottom: 2px solid #ecf0f1;
  padding-bottom: 10px;
}

.slide-panel label {
  display: block;
  margin: 15px 0 5px;
  font-weight: 600;
  color: #34495e;
}

.slide-panel input,
.slide-panel textarea,
.slide-panel select {
  width: 100%;
  padding: 10px 12px;
  border: 1px solid #ccc;
  border-radius: 6px;
  margin-bottom: 15px;
  font-size: 14px;
}

.slide-panel textarea {
  min-height: 150px;
  resize: vertical;
}

.slide-panel button {
  padding: 10px 16px;
  background: #3498db;
  border: none;
  color: white;
  font-weight: bold;
  border-radius: 6px;
  cursor: pointer;
  transition: background 0.3s;
}

.slide-panel button:hover {
  background: #2980b9;
}
.logout-btn {
  background-color: #e74c3c;         /* Red background */
  color: #fff;                       /* White text */
  padding: 10px 20px;               /* Padding around text */
  border-radius: 8px;               /* Rounded corners */
  text-decoration: none;            /* Remove underline */
  font-weight: bold;                /* Bold text */
  transition: background-color 0.3s ease;  /* Smooth hover effect */
  box-shadow: 0 2px 5px rgba(0, 0, 0, 0.1); /* Subtle shadow */
}

.logout-btn:hover {
  background-color: #c0392b;        /* Darker red on hover */
}


  </style>
  <script>
  function openPanel(type, docId) {
    const panel = document.getElementById('slidePanel');
    panel.classList.add('active');

    fetch(`ajax_${type}.php?id=${docId}`)
      .then(res => res.text())
      .then(html => {
        const container = document.getElementById('slideContent');
        container.innerHTML = html;

        // Re-run all <script> tags from response
        const scripts = container.querySelectorAll("script");
        scripts.forEach(oldScript => {
          const newScript = document.createElement("script");
          if (oldScript.src) {
            newScript.src = oldScript.src;
          } else {
            newScript.textContent = oldScript.textContent;
          }
          document.body.appendChild(newScript);
          oldScript.remove();
        });
      });
  }

  function closePanel() {
    document.getElementById('slidePanel').classList.remove('active');
    document.getElementById('slideContent').innerHTML = '';
  }
</script>

</head>
<body>

<div class="header">
  <div class="header-flex">
    <div>
      <h1>📁 Document Management Dashboard</h1>
      <p>Welcome, <strong><?php echo htmlspecialchars($_SESSION['user_name']); ?></strong></p>
    </div>
    <a href="logout.php" class="logout-btn">Logout</a>
  </div>
</div>

<div class="container">
  <div class="top-bar">
    <input type="text" id="search" placeholder="Search documents...">
    <button onclick="window.location.href='create_document.php'"><i class="fa fa-plus"></i> New Document</button>
  </div>

  <table>
    <thead>
      <tr>
        <th>Title</th>
        <th>Author</th>
        <th>Last Modified</th>
        <th>Visibility</th>
        <th>Actions</th>
      </tr>
    </thead>
    <tbody>
    <?php
    require_once "includes/db.php";
    $user_id = $_SESSION['user_id'];

    $query = "
            SELECT DISTINCT d.doc_id, d.title, d.last_modified, d.is_public, u.name AS author_name
            FROM documents d
            JOIN users u ON d.author_id = u.user_id
            WHERE d.author_id = ? OR d.is_public = 1 OR d.author_id = ?
            ORDER BY d.last_modified DESC

            ";

    $stmt = $conn->prepare($query);
    $stmt->bind_param("ii", $user_id, $user_id);
    $stmt->execute();
    $result = $stmt->get_result();

    while ($row = $result->fetch_assoc()) {
      $visibility = $row['is_public'] ? '<span class="public">Public</span>' : '<span class="private">Private</span>';
      echo "<tr>
        <td>" . htmlspecialchars($row['title']) . "</td>
        <td>" . htmlspecialchars($row['author_name']) . "</td>
        <td>" . $row['last_modified'] . "</td>
        <td>$visibility</td>
        <td class='action-icons'>
          <a onclick=\"openPanel('view', {$row['doc_id']})\"><i class='fa fa-eye'></i></a>
          <a onclick=\"openPanel('edit', {$row['doc_id']})\"><i class='fa fa-edit'></i></a>
          <a onclick=\"openPanel('versions', {$row['doc_id']})\"><i class='fa fa-history'></i></a>
        </td>
      </tr>";
    }
    ?>
    </tbody>
  </table>
</div>

<div class="slide-panel" id="slidePanel">
  <span class="slide-panel-close" onclick="closePanel()">&times;</span>
  <div id="slideContent">Loading...</div>
</div>

</body>
</html>
