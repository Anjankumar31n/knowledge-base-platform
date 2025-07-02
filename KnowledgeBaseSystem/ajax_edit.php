<?php
require_once "includes/db.php";
session_start();

// Security check
if (!isset($_SESSION['user_id'])) {
    http_response_code(403);
    echo "Unauthorized access.";
    exit;
}

$user_id = (int)$_SESSION['user_id'];
$doc_id = isset($_GET['id']) ? (int)$_GET['id'] : 0;

// Handle POST submission
if ($_SERVER["REQUEST_METHOD"] === "POST") {
    $title = trim($_POST['title'] ?? '');
    $content = trim($_POST['content'] ?? '');

    if ($title === '' || $content === '') {
        echo "error: Title and content are required.";
        exit;
    }

    $conn->begin_transaction();
    try {
        // 1. Update document
        $stmt = $conn->prepare("UPDATE documents SET title = ?, content = ? WHERE doc_id = ?");
        $stmt->bind_param("ssi", $title, $content, $doc_id);
        $stmt->execute();
        if ($stmt->errno) throw new Exception("Update failed: " . $stmt->error);

        // 2. Insert new version
        $version_stmt = $conn->prepare("INSERT INTO doc_versions (doc_id, content, modified_by) VALUES (?, ?, ?)");
        $version_stmt->bind_param("isi", $doc_id, $content, $user_id);
        $version_stmt->execute();
        if ($version_stmt->errno) throw new Exception("Version insert failed: " . $version_stmt->error);

        $conn->commit();
        echo "success";
    } catch (Exception $e) {
        $conn->rollback();
        echo "error: " . $e->getMessage();
    }
    exit;
}
// Step 1: Check edit permission
$checkStmt = $conn->prepare("
    SELECT 1 
    FROM documents d 
    LEFT JOIN doc_access a ON d.doc_id = a.doc_id AND a.user_id = ? AND a.permission = 'edit'
    WHERE d.doc_id = ? AND (d.author_id = ? OR a.permission = 'edit')
");
$checkStmt->bind_param("iii", $user_id, $doc_id, $user_id);
$checkStmt->execute();
$checkStmt->store_result();

if ($checkStmt->num_rows === 0) {
    echo "<p style='color:red;'>You don't have access to edit this document.</p>";
    exit;
}
$checkStmt->close();
// step2 GET: Load the form
$stmt = $conn->prepare("SELECT title, content FROM documents WHERE doc_id = ?");
$stmt->bind_param("i", $doc_id);
$stmt->execute();
$stmt->bind_result($title, $content);
if (!$stmt->fetch()) {
    echo "Document not found.";
    exit;
}
?>

<!-- Slide panel form HTML -->
<h2>Edit Document</h2>
<form id="editForm">
  <label>Title</label>
  <input type="text" name="title" value="<?= htmlspecialchars($title) ?>" required><br><br>

  <label>Content</label>
  <textarea name="content" rows="10" style="width:100%"><?= htmlspecialchars($content) ?></textarea><br><br>

  <button type="submit">Update</button>
</form>

<script>
document.getElementById('editForm').addEventListener('submit', function(e) {
  e.preventDefault();

  const formData = new FormData(this);
  const docId = <?= $doc_id ?>;

  fetch(`ajax_edit.php?id=${docId}`, {
    method: 'POST',
    body: formData
  })
  .then(res => res.text())
  .then(response => {
    if (response.trim() === 'success') {
      alert("✅ Document updated successfully.");
      closePanel();
      location.reload();
    } else {
      alert("❌ Update failed: " + response);
    }
  })
  .catch(err => {
    alert("❌ Network error: " + err.message);
  });
});
</script>
