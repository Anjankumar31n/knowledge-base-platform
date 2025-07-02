<?php
require_once "includes/db.php";
session_start();

$doc_id = $_GET['id'];

$stmt = $conn->prepare("
  SELECT v.version_timestamp, v.content, u.name 
  FROM doc_versions v 
  JOIN users u ON v.modified_by = u.user_id 
  WHERE v.doc_id = ? 
  ORDER BY v.version_timestamp DESC
");
$stmt->bind_param("i", $doc_id);
$stmt->execute();
$result = $stmt->get_result();

echo "<h2>Document Versions</h2>";
while ($row = $result->fetch_assoc()) {
    echo "<div style='margin-bottom:15px; border-bottom:1px solid #ccc; padding-bottom:10px;'>
            <strong>{$row['version_timestamp']}</strong> by <em>{$row['name']}</em>
            <pre style='white-space:pre-wrap;background:#f4f4f4;padding:10px;border-radius:4px;'>{$row['content']}</pre>
          </div>";
}
?>
