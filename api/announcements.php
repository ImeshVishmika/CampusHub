<?php
header('Content-Type: application/json');
require_once '../config/db.php';
global $conn;

$method = $_SERVER['REQUEST_METHOD'];
$action = isset($_GET['action']) ? $_GET['action'] : '';


if ($method == 'GET' && $action == 'list') {
    $for_students = isset($_GET['for_students']) ? $_GET['for_students'] : 'true';
    
    $sql = "SELECT id, title, content, category, priority, created_by, created_date FROM announcements WHERE is_active = TRUE";
    
    if ($for_students == 'true') {
        $sql .= " AND for_students = TRUE";
    } else {
        $sql .= " AND for_admins = TRUE";
    }
    
    $sql .= " ORDER BY priority DESC, created_date DESC LIMIT 20";
    
    $result = $conn->query($sql);
    
    $announcements = [];
    while ($row = $result->fetch_assoc()) {
        $announcements[] = $row;
    }
    
    echo json_encode(['success' => true, 'data' => $announcements]);
}


elseif ($method == 'GET' && $action == 'details') {
    $announcement_id = isset($_GET['id']) ? intval($_GET['id']) : 0;
    
    if ($announcement_id == 0) {
        echo json_encode(['success' => false, 'message' => 'Announcement ID required']);
        exit;
    }
    
    $sql = "SELECT a.*, u.full_name as created_by_name FROM announcements a LEFT JOIN users u ON a.created_by = u.id WHERE a.id = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param('i', $announcement_id);
    $stmt->execute();
    $result = $stmt->get_result();
    
    if ($result->num_rows > 0) {
        $announcement = $result->fetch_assoc();
        echo json_encode(['success' => true, 'data' => $announcement]);
    } else {
        echo json_encode(['success' => false, 'message' => 'Announcement not found']);
    }
    $stmt->close();
}


elseif ($method == 'POST' && $action == 'create') {
    $input = json_decode(file_get_contents('php://input'), true);
    
    $title = isset($input['title']) ? trim($input['title']) : '';
    $content = isset($input['content']) ? trim($input['content']) : '';
    $category = isset($input['category']) ? trim($input['category']) : '';
    $priority = isset($input['priority']) ? $input['priority'] : 'medium';
    $created_by = isset($input['admin_id']) ? intval($input['admin_id']) : 0;
    $for_students = isset($input['for_students']) ? (bool)$input['for_students'] : true;
    $for_admins = isset($input['for_admins']) ? (bool)$input['for_admins'] : false;
    
    if (empty($title) || empty($content)) {
        echo json_encode(['success' => false, 'message' => 'Title and content are required']);
        exit;
    }
    
    $sql = "INSERT INTO announcements (title, content, category, priority, created_by, for_students, for_admins, is_active) VALUES (?, ?, ?, ?, ?, ?, ?, TRUE)";
    $stmt = $conn->prepare($sql);
    
    $for_students_int = $for_students ? 1 : 0;
    $for_admins_int = $for_admins ? 1 : 0;
    
    $stmt->bind_param('ssssiii', $title, $content, $category, $priority, $created_by, $for_students_int, $for_admins_int);
    
    if ($stmt->execute()) {
        echo json_encode(['success' => true, 'message' => 'Announcement created successfully', 'id' => $conn->insert_id]);
    } else {
        echo json_encode(['success' => false, 'message' => $conn->error]);
    }
    $stmt->close();
}


elseif ($method == 'PUT' && $action == 'update') {
    $input = json_decode(file_get_contents('php://input'), true);
    
    $announcement_id = isset($input['id']) ? intval($input['id']) : 0;
    $title = isset($input['title']) ? trim($input['title']) : '';
    $content = isset($input['content']) ? trim($input['content']) : '';
    $priority = isset($input['priority']) ? $input['priority'] : 'medium';
    $is_active = isset($input['is_active']) ? (bool)$input['is_active'] : true;
    
    if ($announcement_id == 0) {
        echo json_encode(['success' => false, 'message' => 'Announcement ID required']);
        exit;
    }
    
    $is_active_int = $is_active ? 1 : 0;
    
    $sql = "UPDATE announcements SET title = ?, content = ?, priority = ?, is_active = ? WHERE id = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param('sssii', $title, $content, $priority, $is_active_int, $announcement_id);
    
    if ($stmt->execute()) {
        echo json_encode(['success' => true, 'message' => 'Announcement updated successfully']);
    } else {
        echo json_encode(['success' => false, 'message' => $conn->error]);
    }
    $stmt->close();
}


elseif ($method == 'GET' && $action == 'notifications') {
    $user_id = isset($_GET['user_id']) ? intval($_GET['user_id']) : 0;
    
    if ($user_id == 0) {
        echo json_encode(['success' => false, 'message' => 'User ID required']);
        exit;
    }
    
    $sql = "SELECT id, notification_type, notification_title, notification_message, is_read, created_date FROM user_notifications WHERE user_id = ? ORDER BY created_date DESC LIMIT 50";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param('i', $user_id);
    $stmt->execute();
    $result = $stmt->get_result();
    
    $notifications = [];
    while ($row = $result->fetch_assoc()) {
        $notifications[] = $row;
    }
    
    echo json_encode(['success' => true, 'data' => $notifications]);
    $stmt->close();
}


elseif ($method == 'POST' && $action == 'mark_read') {
    $input = json_decode(file_get_contents('php://input'), true);
    $notification_id = isset($input['id']) ? intval($input['id']) : 0;
    
    if ($notification_id == 0) {
        echo json_encode(['success' => false, 'message' => 'Notification ID required']);
        exit;
    }
    
    $sql = "UPDATE user_notifications SET is_read = TRUE WHERE id = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param('i', $notification_id);
    
    if ($stmt->execute()) {
        echo json_encode(['success' => true, 'message' => 'Notification marked as read']);
    } else {
        echo json_encode(['success' => false, 'message' => $conn->error]);
    }
    $stmt->close();
}


elseif ($method == 'POST' && $action == 'create_notification') {
    $input = json_decode(file_get_contents('php://input'), true);
    
    $user_id = isset($input['user_id']) ? intval($input['user_id']) : 0;
    $notification_type = isset($input['type']) ? trim($input['type']) : '';
    $notification_title = isset($input['title']) ? trim($input['title']) : '';
    $notification_message = isset($input['message']) ? trim($input['message']) : '';
    $related_id = isset($input['related_id']) ? intval($input['related_id']) : null;
    
    if ($user_id == 0 || empty($notification_type) || empty($notification_title)) {
        echo json_encode(['success' => false, 'message' => 'Missing required fields']);
        exit;
    }
    
    $sql = "INSERT INTO user_notifications (user_id, notification_type, notification_title, notification_message, related_id) VALUES (?, ?, ?, ?, ?)";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param('isssi', $user_id, $notification_type, $notification_title, $notification_message, $related_id);
    
    if ($stmt->execute()) {
        echo json_encode(['success' => true, 'message' => 'Notification created successfully']);
    } else {
        echo json_encode(['success' => false, 'message' => $conn->error]);
    }
    $stmt->close();
}


elseif ($method == 'GET' && $action == 'unread_count') {
    $user_id = isset($_GET['user_id']) ? intval($_GET['user_id']) : 0;
    
    if ($user_id == 0) {
        echo json_encode(['success' => false, 'message' => 'User ID required']);
        exit;
    }
    
    $sql = "SELECT COUNT(*) as count FROM user_notifications WHERE user_id = ? AND is_read = FALSE";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param('i', $user_id);
    $stmt->execute();
    $result = $stmt->get_result();
    
    $count = $result->fetch_assoc()['count'];
    echo json_encode(['success' => true, 'data' => ['unread_count' => $count]]);
    $stmt->close();
}


elseif ($method == 'POST' && $action == 'delete') {
    $input = json_decode(file_get_contents('php://input'), true);
    $announcement_id = isset($input['id']) ? intval($input['id']) : 0;
    
    if ($announcement_id == 0) {
        echo json_encode(['success' => false, 'message' => 'Announcement ID required']);
        exit;
    }
    
    $sql = "DELETE FROM announcements WHERE id = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param('i', $announcement_id);
    
    if ($stmt->execute()) {
        echo json_encode(['success' => true, 'message' => 'Announcement deleted successfully']);
    } else {
        echo json_encode(['success' => false, 'message' => $conn->error]);
    }
    $stmt->close();
}

else {
    echo json_encode(['success' => false, 'message' => 'Invalid action']);
}

$conn->close();
?>
