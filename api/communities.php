<?php

header('Content-Type: application/json');
require_once '../config/db.php';
global $conn;

$method = $_SERVER['REQUEST_METHOD'];
$action = isset($_GET['action']) ? $_GET['action'] : '';


if ($method == 'GET' && $action == 'list') {
    $search = isset($_GET['search']) ? trim($_GET['search']) : '';
    
    $sql = "SELECT c.id, c.name, c.description, c.category, c.community_image, COUNT(cm.id) as member_count 
            FROM communities c 
            LEFT JOIN community_members cm ON c.id = cm.community_id";
            
    if (!empty($search)) {
        $sql .= " WHERE c.name LIKE ? OR c.description LIKE ? OR c.category LIKE ?";
    }
    
    $sql .= " GROUP BY c.id";
    
    $stmt = $conn->prepare($sql);
    
    if (!empty($search)) {
        $searchTerm = "%{$search}%";
        $stmt->bind_param('sss', $searchTerm, $searchTerm, $searchTerm);
    }
    
    $stmt->execute();
    $result = $stmt->get_result();
    
    $communities = [];
    while ($row = $result->fetch_assoc()) {
        $communities[] = $row;
    }
    
    echo json_encode(['success' => true, 'data' => $communities]);
    $stmt->close();
}


elseif ($method == 'GET' && $action == 'details') {
    $community_id = isset($_GET['id']) ? intval($_GET['id']) : 0;
    
    if ($community_id == 0) {
        echo json_encode(['success' => false, 'message' => 'Community ID required']);
        exit;
    }
    
    $sql = "SELECT c.*, COUNT(cm.id) as member_count FROM communities c LEFT JOIN community_members cm ON c.id = cm.community_id WHERE c.id = ? GROUP BY c.id";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param('i', $community_id);
    $stmt->execute();
    $result = $stmt->get_result();
    
    if ($result->num_rows > 0) {
        $community = $result->fetch_assoc();
        echo json_encode(['success' => true, 'data' => $community]);
    } else {
        echo json_encode(['success' => false, 'message' => 'Community not found']);
    }
    $stmt->close();
}


elseif ($method == 'GET' && $action == 'messages') {
    $community_id = isset($_GET['id']) ? intval($_GET['id']) : 0;
    
    if ($community_id == 0) {
        echo json_encode(['success' => false, 'message' => 'Community ID required']);
        exit;
    }
    
    $sql = "SELECT cm.id, cm.message_text, cm.media_attachment, cm.message_type, cm.created_date, u.full_name, u.profile_photo FROM community_messages cm JOIN community_channels ch ON cm.channel_id = ch.id JOIN users u ON cm.user_id = u.id WHERE ch.community_id = ? ORDER BY cm.created_date DESC LIMIT 50";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param('i', $community_id);
    $stmt->execute();
    $result = $stmt->get_result();
    
    $messages = [];
    while ($row = $result->fetch_assoc()) {
        $messages[] = $row;
    }
    
    echo json_encode(['success' => true, 'data' => $messages]);
    $stmt->close();
}


elseif ($method == 'POST' && $action == 'post_message') {
    $input = json_decode(file_get_contents('php://input'), true);
    
    $community_id = isset($input['community_id']) ? intval($input['community_id']) : 0;
    $user_id = isset($input['user_id']) ? intval($input['user_id']) : 0;
    $message_text = isset($input['message_text']) ? trim($input['message_text']) : '';
    $message_type = isset($input['message_type']) ? $input['message_type'] : 'text';
    
    if ($community_id == 0 || $user_id == 0 || empty($message_text)) {
        echo json_encode(['success' => false, 'message' => 'Missing required fields']);
        exit;
    }
    
    
    $sql = "SELECT id FROM community_channels WHERE community_id = ? LIMIT 1";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param('i', $community_id);
    $stmt->execute();
    $result = $stmt->get_result();
    
    if ($result->num_rows == 0) {
        $stmt->close();
        $sql = "INSERT INTO community_channels (community_id, name) VALUES (?, 'General')";
        $stmt2 = $conn->prepare($sql);
        $stmt2->bind_param('i', $community_id);
        $stmt2->execute();
        $channel_id = $conn->insert_id;
        $stmt2->close();
    } else {
        $channel_id = $result->fetch_assoc()['id'];
        $stmt->close();
    }
    
    $sql = "INSERT INTO community_messages (channel_id, user_id, message_text, message_type) VALUES (?, ?, ?, ?)";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param('iiss', $channel_id, $user_id, $message_text, $message_type);
    
    if ($stmt->execute()) {
        echo json_encode(['success' => true, 'message' => 'Message posted successfully', 'id' => $conn->insert_id]);
    } else {
        echo json_encode(['success' => false, 'message' => $conn->error]);
    }
    $stmt->close();
}


elseif ($method == 'POST' && $action == 'join') {
    $input = json_decode(file_get_contents('php://input'), true);
    
    $community_id = isset($input['community_id']) ? intval($input['community_id']) : 0;
    $user_id = isset($input['user_id']) ? intval($input['user_id']) : 0;
    
    if ($community_id == 0 || $user_id == 0) {
        echo json_encode(['success' => false, 'message' => 'Missing required fields']);
        exit;
    }
    
    $sql = "INSERT INTO community_members (community_id, user_id, role) VALUES (?, ?, 'member')";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param('ii', $community_id, $user_id);
    
    if ($stmt->execute()) {
        echo json_encode(['success' => true, 'message' => 'Joined community successfully']);
    } else {
        echo json_encode(['success' => false, 'message' => $conn->error]);
    }
    $stmt->close();
}


elseif ($method == 'POST' && $action == 'leave') {
    $input = json_decode(file_get_contents('php://input'), true);
    
    $community_id = isset($input['community_id']) ? intval($input['community_id']) : 0;
    $user_id = isset($input['user_id']) ? intval($input['user_id']) : 0;
    
    if ($community_id == 0 || $user_id == 0) {
        echo json_encode(['success' => false, 'message' => 'Missing required fields']);
        exit;
    }
    
    $sql = "DELETE FROM community_members WHERE community_id = ? AND user_id = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param('ii', $community_id, $user_id);
    
    if ($stmt->execute()) {
        echo json_encode(['success' => true, 'message' => 'Left community successfully']);
    } else {
        echo json_encode(['success' => false, 'message' => $conn->error]);
    }
    $stmt->close();
}


elseif ($method == 'GET' && $action == 'user_communities') {
    $user_id = isset($_GET['user_id']) ? intval($_GET['user_id']) : 0;
    
    if ($user_id == 0) {
        echo json_encode(['success' => false, 'message' => 'User ID required']);
        exit;
    }
    
    $sql = "SELECT c.id, c.name, c.description, c.category, c.community_image FROM communities c JOIN community_members cm ON c.id = cm.community_id WHERE cm.user_id = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param('i', $user_id);
    $stmt->execute();
    $result = $stmt->get_result();
    
    $communities = [];
    while ($row = $result->fetch_assoc()) {
        $communities[] = $row;
    }
    
    echo json_encode(['success' => true, 'data' => $communities]);
    $stmt->close();
}


elseif ($method == 'GET' && $action == 'members') {
    $community_id = isset($_GET['id']) ? intval($_GET['id']) : 0;
    
    if ($community_id == 0) {
        echo json_encode(['success' => false, 'message' => 'Community ID required']);
        exit;
    }
    
    $sql = "SELECT u.id, u.full_name, u.profile_photo, u.department, cm.role, cm.join_date FROM community_members cm JOIN users u ON cm.user_id = u.id WHERE cm.community_id = ? ORDER BY cm.join_date DESC";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param('i', $community_id);
    $stmt->execute();
    $result = $stmt->get_result();
    
    $members = [];
    while ($row = $result->fetch_assoc()) {
        $members[] = $row;
    }
    
    echo json_encode(['success' => true, 'data' => $members]);
    $stmt->close();
}


elseif ($method == 'POST' && $action == 'create') {
    $input = json_decode(file_get_contents('php://input'), true);
    
    $name = isset($input['name']) ? trim($input['name']) : '';
    $description = isset($input['description']) ? trim($input['description']) : '';
    $category = isset($input['category']) ? trim($input['category']) : '';
    
    if (empty($name)) {
        echo json_encode(['success' => false, 'message' => 'Community name required']);
        exit;
    }
    
    $sql = "INSERT INTO communities (name, description, category) VALUES (?, ?, ?)";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param('sss', $name, $description, $category);
    
    if ($stmt->execute()) {
        echo json_encode(['success' => true, 'message' => 'Community created successfully', 'id' => $conn->insert_id]);
    } else {
        echo json_encode(['success' => false, 'message' => $conn->error]);
    }
    $stmt->close();
}


elseif ($method == 'PUT' && $action == 'update') {
    $input = json_decode(file_get_contents('php://input'), true);
    
    $community_id = isset($input['id']) ? intval($input['id']) : 0;
    $name = isset($input['name']) ? trim($input['name']) : '';
    $description = isset($input['description']) ? trim($input['description']) : '';
    $category = isset($input['category']) ? trim($input['category']) : '';
    
    if ($community_id == 0 || empty($name)) {
        echo json_encode(['success' => false, 'message' => 'Community ID and name required']);
        exit;
    }
    
    $sql = "UPDATE communities SET name=?, description=?, category=? WHERE id=?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param('sssi', $name, $description, $category, $community_id);
    
    if ($stmt->execute()) {
        echo json_encode(['success' => true, 'message' => 'Community updated successfully']);
    } else {
        echo json_encode(['success' => false, 'message' => $conn->error]);
    }
    $stmt->close();
}


elseif ($method == 'POST' && $action == 'delete') {
    $input = json_decode(file_get_contents('php://input'), true);
    $community_id = isset($input['id']) ? intval($input['id']) : 0;
    
    if ($community_id == 0) {
        echo json_encode(['success' => false, 'message' => 'Community ID required']);
        exit;
    }
    
    $sql = "DELETE FROM communities WHERE id = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param('i', $community_id);
    
    if ($stmt->execute()) {
        echo json_encode(['success' => true, 'message' => 'Community deleted successfully']);
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
