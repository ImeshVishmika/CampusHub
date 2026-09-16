<?php

header('Content-Type: application/json');
require_once '../config/db.php';
global $conn;

$method = $_SERVER['REQUEST_METHOD'];
$action = isset($_GET['action']) ? $_GET['action'] : '';


if ($method == 'POST' && $action == 'upload') {
    if (!isset($_FILES['file']) || !isset($_POST['user_id'])) {
        echo json_encode(['success' => false, 'message' => 'File and user_id required']);
        exit;
    }
    
    $user_id = intval($_POST['user_id']);
    $community_id = isset($_POST['community_id']) ? intval($_POST['community_id']) : null;
    $event_id = isset($_POST['event_id']) ? intval($_POST['event_id']) : null;
    $description = isset($_POST['description']) ? trim($_POST['description']) : '';
    $media_category = isset($_POST['category']) ? trim($_POST['category']) : 'general';
    
    $file = $_FILES['file'];
    $allowed_extensions = ['jpg', 'jpeg', 'png', 'gif', 'mp4', 'avi', 'mov', 'pdf', 'doc', 'docx'];
    $file_ext = strtolower(pathinfo($file['name'], PATHINFO_EXTENSION));
    
    if (!in_array($file_ext, $allowed_extensions)) {
        echo json_encode(['success' => false, 'message' => 'File type not allowed']);
        exit;
    }
    
    if ($file['size'] > 50000000) { 
        echo json_encode(['success' => false, 'message' => 'File size exceeds limit (50MB)']);
        exit;
    }
    
    $upload_dir = '../uploads/';
    if (!is_dir($upload_dir)) {
        mkdir($upload_dir, 0777, true);
    }
    
    $unique_filename = uniqid() . '_' . basename($file['name']);
    $file_path = $upload_dir . $unique_filename;
    
    if (move_uploaded_file($file['tmp_name'], $file_path)) {
        $relative_path = 'uploads/' . $unique_filename;
        $file_type = substr($file['type'], 0, strpos($file['type'], '/') ?: strlen($file['type']));
        
        $sql = "INSERT INTO media (user_id, file_name, file_path, file_type, file_size, media_category, description, community_id, event_id) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?)";
        $stmt = $conn->prepare($sql);
        
        $stmt->bind_param(
            'isssissii',
            $user_id,
            $file['name'],
            $relative_path,
            $file_type,
            $file['size'],
            $media_category,
            $description,
            $community_id,
            $event_id
        );
        
        if ($stmt->execute()) {
            echo json_encode([
                'success' => true,
                'message' => 'File uploaded successfully',
                'id' => $conn->insert_id,
                'file_path' => $relative_path
            ]);
        } else {
            echo json_encode(['success' => false, 'message' => $conn->error]);
        }
        $stmt->close();
    } else {
        echo json_encode(['success' => false, 'message' => 'Failed to upload file']);
    }
}


elseif ($method == 'GET' && $action == 'community_media') {
    $community_id = isset($_GET['community_id']) ? intval($_GET['community_id']) : 0;
    
    if ($community_id == 0) {
        echo json_encode(['success' => false, 'message' => 'Community ID required']);
        exit;
    }
    
    $sql = "SELECT m.id, m.file_name, m.file_path, m.file_type, m.description, m.media_category, m.upload_date, u.full_name, u.profile_photo FROM media m JOIN users u ON m.user_id = u.id WHERE m.community_id = ? ORDER BY m.upload_date DESC";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param('i', $community_id);
    $stmt->execute();
    $result = $stmt->get_result();
    
    $media = [];
    while ($row = $result->fetch_assoc()) {
        $media[] = $row;
    }
    
    echo json_encode(['success' => true, 'data' => $media]);
    $stmt->close();
}


elseif ($method == 'GET' && $action == 'event_media') {
    $event_id = isset($_GET['event_id']) ? intval($_GET['event_id']) : 0;
    
    if ($event_id == 0) {
        echo json_encode(['success' => false, 'message' => 'Event ID required']);
        exit;
    }
    
    $sql = "SELECT m.id, m.file_name, m.file_path, m.file_type, m.description, m.media_category, m.upload_date, u.full_name, u.profile_photo FROM media m JOIN users u ON m.user_id = u.id WHERE m.event_id = ? ORDER BY m.upload_date DESC";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param('i', $event_id);
    $stmt->execute();
    $result = $stmt->get_result();
    
    $media = [];
    while ($row = $result->fetch_assoc()) {
        $media[] = $row;
    }
    
    echo json_encode(['success' => true, 'data' => $media]);
    $stmt->close();
}


elseif ($method == 'GET' && $action == 'user_media') {
    $user_id = isset($_GET['user_id']) ? intval($_GET['user_id']) : 0;
    
    if ($user_id == 0) {
        echo json_encode(['success' => false, 'message' => 'User ID required']);
        exit;
    }
    
    $sql = "SELECT m.id, m.file_name, m.file_path, m.file_type, m.description, m.media_category, m.upload_date FROM media m WHERE m.user_id = ? ORDER BY m.upload_date DESC";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param('i', $user_id);
    $stmt->execute();
    $result = $stmt->get_result();
    
    $media = [];
    while ($row = $result->fetch_assoc()) {
        $media[] = $row;
    }
    
    echo json_encode(['success' => true, 'data' => $media]);
    $stmt->close();
}


elseif ($method == 'POST' && $action == 'delete') {
    $input = json_decode(file_get_contents('php://input'), true);
    $media_id = isset($input['id']) ? intval($input['id']) : 0;
    
    if ($media_id == 0) {
        echo json_encode(['success' => false, 'message' => 'Media ID required']);
        exit;
    }
    
    $sql = "SELECT file_path FROM media WHERE id = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param('i', $media_id);
    $stmt->execute();
    $result = $stmt->get_result();
    
    if ($result->num_rows == 0) {
        echo json_encode(['success' => false, 'message' => 'Media not found']);
        $stmt->close();
        exit;
    }
    
    $file_path = $result->fetch_assoc()['file_path'];
    $stmt->close();
    
    if (file_exists($file_path)) {
        unlink($file_path);
    }
    
    $sql = "DELETE FROM media WHERE id = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param('i', $media_id);
    
    if ($stmt->execute()) {
        echo json_encode(['success' => true, 'message' => 'Media deleted successfully']);
    } else {
        echo json_encode(['success' => false, 'message' => $conn->error]);
    }
    $stmt->close();
}

else {
    echo json_encode(['success' => false, 'message' => 'Invalid request']);
}

$conn->close();
?>
