<?php
require_once '../config/db.php';
global $conn;

header("Content-type: text/xml");

$sql = "SELECT id, title, description, event_date, location, category FROM events WHERE status = 'upcoming' ORDER BY event_date ASC";
$result = $conn->query($sql);

echo "<?xml version='1.0' encoding='UTF-8'?>\n";
echo "<events>\n";

while ($row = $result->fetch_assoc()) {
    echo "  <event id='" . htmlspecialchars($row['id']) . "'>\n";
    echo "    <title>" . htmlspecialchars($row['title']) . "</title>\n";
    echo "    <description>" . htmlspecialchars($row['description']) . "</description>\n";
    echo "    <date>" . htmlspecialchars($row['event_date']) . "</date>\n";
    echo "    <location>" . htmlspecialchars($row['location']) . "</location>\n";
    echo "    <category>" . htmlspecialchars($row['category']) . "</category>\n";
    echo "  </event>\n";
}

echo "</events>\n";
$conn->close();
?>
