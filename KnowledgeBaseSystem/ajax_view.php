<?php
require_once "includes/db.php";
session_start();
if (!isset($_SESSION['user_id'])) {
    http_response_code(403);
    echo "Unauthorized access.";
    exit;
}
$user_id = (int)$_SESSION['user_id'];
$doc_id = $_GET['id'];
// Step 1: Check edit permission
$checkStmt = $conn->prepare("
    SELECT 1 
    FROM documents d 
    LEFT JOIN doc_access a ON d.doc_id = a.doc_id AND a.user_id = ? AND (a.permission = 'view' OR a.permission = 'edit')
    WHERE d.doc_id = ? AND (d.author_id = ? OR (a.permission = 'edit' OR a.permission = 'view'))
");
$checkStmt->bind_param("iii", $user_id, $doc_id, $user_id);
$checkStmt->execute();
$checkStmt->store_result();

if ($checkStmt->num_rows === 0) {
    echo "<p style='color:red;'>You don't have access to view this document.</p>";
    exit;
}
$checkStmt->close();
$stmt = $conn->prepare("SELECT title, content FROM documents WHERE doc_id = ?");
$stmt->bind_param("i", $doc_id);
$stmt->execute();
$stmt->bind_result($title, $content);
$stmt->fetch();
?>
<h2>View Document</h2>
<h3><?php echo htmlspecialchars($title); ?></h3>
<<div><?php echo $content; ?></div>
