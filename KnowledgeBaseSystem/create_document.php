<?php
session_start();
require_once "includes/db.php";

if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit;
}

$current_user_id = $_SESSION['user_id'];
$error = "";

// Fetch user list for dropdown
$users = [];
$stmt = $conn->prepare("SELECT user_id, name FROM users WHERE user_id != ?");
$stmt->bind_param("i", $current_user_id);
$stmt->execute();
$result = $stmt->get_result();
while ($row = $result->fetch_assoc()) {
    $users[] = $row;
}

if ($_SERVER["REQUEST_METHOD"] === "POST") {
    $title = trim($_POST['title']);
    $content = $_POST['content'];
    $is_public = isset($_POST['is_public']) ? 1 : 0;

    $stmt = $conn->prepare("INSERT INTO documents (title, content, author_id, is_public) VALUES (?, ?, ?, ?)");
    $stmt->bind_param("ssii", $title, $content, $current_user_id, $is_public);

    if ($stmt->execute()) {
        $doc_id = $stmt->insert_id;
        // Insert current user as default editor
        $default_stmt = $conn->prepare("INSERT INTO doc_access (doc_id, user_id, permission) VALUES (?, ?, 'edit')");
        $default_stmt->bind_param("ii", $doc_id, $current_user_id);
        $default_stmt->execute();


        // Handle selected users and permissions
        if (isset($_POST['access_user']) && is_array($_POST['access_user'])) {
            foreach ($_POST['access_user'] as $uid) {
                $uid = (int)$uid;
                $perm = $_POST['permission'][$uid] ?? 'view';
                if (in_array($perm, ['view', 'edit'])) {
                    $access_stmt = $conn->prepare("INSERT INTO doc_access (doc_id, user_id, permission) VALUES (?, ?, ?)");
                    $access_stmt->bind_param("iis", $doc_id, $uid, $perm);
                    $access_stmt->execute();
                }
            }
        }

        // Handle All Members option
        if (isset($_POST['all_members'])) {
            foreach ($users as $u) {
                $perm = $_POST['permission'][$u['user_id']] ?? 'view';
                if (in_array($perm, ['view', 'edit'])) {
                    $access_stmt = $conn->prepare("INSERT INTO doc_access (doc_id, user_id, permission) VALUES (?, ?, ?)");
                    $access_stmt->bind_param("iis", $doc_id, $u['user_id'], $perm);
                    $access_stmt->execute();
                }
            }
        }

        header("Location: dashboard.php");
        exit;
    } else {
        $error = "Failed to create document. Please try again.";
    }
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>Create Document</title>
    <script src="https://cdn.ckeditor.com/4.16.2/standard/ckeditor.js"></script>
    <style>
        body {
            font-family: 'Segoe UI', sans-serif;
            background: #f4f6f9;
            margin: 0;
        }
        .container {
            width: 90%;
            max-width: 1000px;
            margin: 40px auto;
            background: white;
            padding: 30px;
            border-radius: 10px;
            box-shadow: 0 4px 10px rgba(0,0,0,0.1);
        }
        h2 {
            text-align: center;
            color: #2c3e50;
            margin-bottom: 30px;
        }
        input[type="text"], textarea {
            width: 100%;
            padding: 12px;
            margin-bottom: 15px;
            border: 1px solid #ccc;
            border-radius: 6px;
        }
        label {
            font-weight: 600;
            display: block;
            margin-top: 15px;
            margin-bottom: 5px;
        }
        .form-footer {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-top: 20px;
        }
        .form-footer button {
            padding: 10px 20px;
            background: #3498db;
            color: white;
            border: none;
            border-radius: 6px;
            cursor: pointer;
        }
        .form-footer button:hover {
            background: #2980b9;
        }
        .form-footer a {
            text-decoration: none;
            color: #3498db;
            font-weight: 500;
        }
        .error {
            color: red;
            text-align: center;
            margin-bottom: 10px;
        }
        .user-access {
            margin-top: 20px;
            border-top: 1px solid #ddd;
            padding-top: 20px;
        }
        .user-row {
            display: flex;
            align-items: center;
            gap: 15px;
            margin-bottom: 10px;
        }
    </style>
</head>
<body>
<div class="container">
    <h2>Create New Document</h2>

    <?php if (!empty($error)) echo "<p class='error'>$error</p>"; ?>

    <form method="POST">
        <label>Title</label>
        <input type="text" name="title" required>

        <label>Content</label>
        <textarea name="content" id="content" required></textarea>

        <label><input type="checkbox" name="is_public"> Make Public</label>

        
        <div class="user-access">
            <label>Manage Permissions </label>
            <label><input type="checkbox" name="all_members" id="allMembersToggle"> All Members</label>
            <div id="userList">
                <?php foreach ($users as $user): ?>
                    <div class="user-row">
                        <label><input type="checkbox" name="access_user[]" value="<?= $user['user_id'] ?>"> <?= htmlspecialchars($user['name']) ?></label>
                        <label><input type="radio" name="permission[<?= $user['user_id'] ?>]" value="view" checked> View</label>
                        <label><input type="radio" name="permission[<?= $user['user_id'] ?>]" value="edit"> Edit</label>
                    </div>
                <?php endforeach; ?>
            </div>
        </div>

        <div class="form-footer">
            <a href="dashboard.php">← Back to Dashboard</a>
            <button type="submit">Save Document</button>
        </div>
    </form>
</div>

<script>
    CKEDITOR.replace('content');

    // When All Members is selected, disable individual checkboxes
    document.getElementById('allMembersToggle').addEventListener('change', function () {
        const isChecked = this.checked;
        document.querySelectorAll('#userList input[type="checkbox"]').forEach(cb => cb.disabled = isChecked);
        document.querySelectorAll('#userList input[type="radio"]').forEach(rb => rb.disabled = isChecked);
    });
</script>
</body>
</html>
