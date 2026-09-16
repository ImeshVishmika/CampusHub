<?php

header('Content-Type: application/json');
require_once '../config/db.php';
global $conn;

$method = $_SERVER['REQUEST_METHOD'];
$action = isset($_GET['action']) ? $_GET['action'] : '';


if ($method == 'GET' && $action == 'list') {
    $sql = "SELECT id, username, email, full_name, phone, profile_photo, department, bio, registration_date FROM users WHERE role = 'student'";
    $result = $conn->query($sql);
    
    if ($result) {
        $students = [];
        while ($row = $result->fetch_assoc()) {
            $students[] = $row;
        }
        echo json_encode(['success' => true, 'data' => $students]);
    } else {
        echo json_encode(['success' => false, 'message' => $conn->error]);
    }
}


elseif ($method == 'GET' && $action == 'profile') {
    $student_id = isset($_GET['id']) ? intval($_GET['id']) : 0;
    
    if ($student_id == 0) {
        echo json_encode(['success' => false, 'message' => 'Student ID required']);
        exit;
    }
    
    $sql = "SELECT * FROM users WHERE id = ? AND role = 'student'";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param('i', $student_id);
    $stmt->execute();
    $result = $stmt->get_result();
    
    if ($result->num_rows > 0) {
        $student = $result->fetch_assoc();
        echo json_encode(['success' => true, 'data' => $student]);
    } else {
        echo json_encode(['success' => false, 'message' => 'Student not found']);
    }
    $stmt->close();
}


elseif ($method == 'POST' && $action == 'register') {
    $input = json_decode(file_get_contents('php://input'), true);
    
    $username = isset($input['username']) ? trim($input['username']) : '';
    $email = isset($input['email']) ? trim($input['email']) : '';
    $password = isset($input['password']) ? $input['password'] : '';
    $full_name = isset($input['full_name']) ? trim($input['full_name']) : '';
    $phone = isset($input['phone']) ? trim($input['phone']) : '';
    $department = isset($input['department']) ? trim($input['department']) : '';
    
    if (empty($username) || empty($email) || empty($password) || empty($full_name)) {
        echo json_encode(['success' => false, 'message' => 'Missing required fields']);
        exit;
    }
    
    $hashed_password = password_hash($password, PASSWORD_DEFAULT);
    
    $sql = "INSERT INTO users (username, email, password, full_name, phone, department, role) VALUES (?, ?, ?, ?, ?, ?, 'student')";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param('ssssss', $username, $email, $hashed_password, $full_name, $phone, $department);
    
    if ($stmt->execute()) {
        $new_id = $conn->insert_id;
        echo json_encode(['success' => true, 'message' => 'Student registered successfully', 'id' => $new_id]);
    } else {
        echo json_encode(['success' => false, 'message' => $conn->error]);
    }
    $stmt->close();
}


elseif ($method == 'PUT' && $action == 'update') {
    $input = json_decode(file_get_contents('php://input'), true);
    
    $student_id = isset($input['id']) ? intval($input['id']) : 0;
    $full_name = isset($input['full_name']) ? trim($input['full_name']) : '';
    $phone = isset($input['phone']) ? trim($input['phone']) : '';
    $bio = isset($input['bio']) ? trim($input['bio']) : '';
    $department = isset($input['department']) ? trim($input['department']) : '';
    
    if ($student_id == 0) {
        echo json_encode(['success' => false, 'message' => 'Student ID required']);
        exit;
    }
    
    $sql = "UPDATE users SET full_name = ?, phone = ?, bio = ?, department = ? WHERE id = ? AND role = 'student'";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param('ssssi', $full_name, $phone, $bio, $department, $student_id);
    
    if ($stmt->execute()) {
        echo json_encode(['success' => true, 'message' => 'Profile updated successfully']);
    } else {
        echo json_encode(['success' => false, 'message' => $conn->error]);
    }
    $stmt->close();
}


elseif ($method == 'GET' && $action == 'stats') {
    $student_id = isset($_GET['id']) ? intval($_GET['id']) : 0;
    
    if ($student_id == 0) {
        echo json_encode(['success' => false, 'message' => 'Student ID required']);
        exit;
    }
    
    $stats = [];
    
    
    $sql = "SELECT COUNT(*) as count FROM event_registrations WHERE student_id = ? AND registration_status = 'attended'";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param('i', $student_id);
    $stmt->execute();
    $result = $stmt->get_result();
    $stats['events_attended'] = $result->fetch_assoc()['count'];
    $stmt->close();
    
    
    $sql = "SELECT COUNT(*) as count FROM community_members WHERE user_id = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param('i', $student_id);
    $stmt->execute();
    $result = $stmt->get_result();
    $stats['communities_joined'] = $result->fetch_assoc()['count'];
    $stmt->close();
    
    
    $sql = "SELECT COUNT(*) as count FROM media WHERE user_id = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param('i', $student_id);
    $stmt->execute();
    $result = $stmt->get_result();
    $stats['media_uploaded'] = $result->fetch_assoc()['count'];
    $stmt->close();
    
    echo json_encode(['success' => true, 'data' => $stats]);
}


elseif ($method == 'POST' && $action == 'delete') {
    $input = json_decode(file_get_contents('php://input'), true);
    $student_id = isset($input['id']) ? intval($input['id']) : 0;
    
    if ($student_id == 0) {
        echo json_encode(['success' => false, 'message' => 'Student ID required']);
        exit;
    }
    
    $sql = "DELETE FROM users WHERE id = ? AND role = 'student'";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param('i', $student_id);
    
    if ($stmt->execute()) {
        echo json_encode(['success' => true, 'message' => 'Student deleted successfully']);
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
