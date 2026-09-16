<?php
header('Content-Type: application/json');
require_once '../config/db.php';
global $conn;

$method = $_SERVER['REQUEST_METHOD'];
$action = isset($_GET['action']) ? $_GET['action'] : '';


if ($method == 'POST' && $action == 'login') {
    $input = json_decode(file_get_contents('php://input'), true);
    
    $username = isset($input['username']) ? trim($input['username']) : '';
    $password = isset($input['password']) ? $input['password'] : '';
    
    if (empty($username) || empty($password)) {
        echo json_encode(['success' => false, 'message' => 'Username and password required']);
        exit;
    }
    
    $sql = "SELECT id, username, email, password, role, full_name FROM users WHERE username = ? AND is_active = TRUE";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param('s', $username);
    $stmt->execute();
    $result = $stmt->get_result();
    
    if ($result->num_rows == 0) {
        echo json_encode(['success' => false, 'message' => 'Invalid credentials']);
        exit;
    }
    
    $user = $result->fetch_assoc();
    $stmt->close();
    
    if (password_verify($password, $user['password'])) {
        unset($user['password']);
        $_SESSION['user'] = $user;
        
        echo json_encode([
            'success' => true,
            'message' => 'Login successful',
            'user' => $user
        ]);
    } else {
        echo json_encode(['success' => false, 'message' => 'Invalid credentials']);
    }
}


elseif ($method == 'GET' && $action == 'status') {
    if (isset($_SESSION['user'])) {
        echo json_encode([
            'success' => true,
            'user' => $_SESSION['user']
        ]);
    } else {
        echo json_encode([
            'success' => false,
            'message' => 'Not logged in'
        ]);
    }
}


elseif ($method == 'POST' && $action == 'register_student') {
    $input = json_decode(file_get_contents('php://input'), true);
    
    $username = isset($input['username']) ? trim($input['username']) : '';
    $email = isset($input['email']) ? trim($input['email']) : '';
    $password = isset($input['password']) ? $input['password'] : '';
    $full_name = isset($input['full_name']) ? trim($input['full_name']) : '';
    $department = isset($input['department']) ? trim($input['department']) : '';
    
    if (empty($username) || empty($email) || empty($password) || empty($full_name)) {
        echo json_encode(['success' => false, 'message' => 'Missing required fields']);
        exit;
    }
    
    
    $sql = "SELECT id FROM users WHERE username = ? OR email = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param('ss', $username, $email);
    $stmt->execute();
    if ($stmt->get_result()->num_rows > 0) {
        echo json_encode(['success' => false, 'message' => 'Username or email already exists']);
        $stmt->close();
        exit;
    }
    $stmt->close();
    
    $hashed_password = password_hash($password, PASSWORD_DEFAULT);
    
    $sql = "INSERT INTO users (username, email, password, full_name, department, role) VALUES (?, ?, ?, ?, ?, 'student')";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param('sssss', $username, $email, $hashed_password, $full_name, $department);
    
    if ($stmt->execute()) {
        $user_id = $conn->insert_id;
        echo json_encode([
            'success' => true,
            'message' => 'Registration successful',
            'user_id' => $user_id
        ]);
    } else {
        echo json_encode(['success' => false, 'message' => $conn->error]);
    }
    $stmt->close();
}


elseif ($method == 'POST' && $action == 'register_admin') {
    $input = json_decode(file_get_contents('php://input'), true);
    
    $username = isset($input['username']) ? trim($input['username']) : '';
    $email = isset($input['email']) ? trim($input['email']) : '';
    $password = isset($input['password']) ? $input['password'] : '';
    $full_name = isset($input['full_name']) ? trim($input['full_name']) : '';
    $admin_key = isset($input['admin_key']) ? trim($input['admin_key']) : '';
    
    
    if ($admin_key !== 'CampusHub2024AdminKey') {
        echo json_encode(['success' => false, 'message' => 'Invalid admin key']);
        exit;
    }
    
    if (empty($username) || empty($email) || empty($password) || empty($full_name)) {
        echo json_encode(['success' => false, 'message' => 'Missing required fields']);
        exit;
    }
    
    
    $sql = "SELECT id FROM users WHERE username = ? OR email = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param('ss', $username, $email);
    $stmt->execute();
    if ($stmt->get_result()->num_rows > 0) {
        echo json_encode(['success' => false, 'message' => 'Username or email already exists']);
        $stmt->close();
        exit;
    }
    $stmt->close();
    
    $hashed_password = password_hash($password, PASSWORD_DEFAULT);
    
    $sql = "INSERT INTO users (username, email, password, full_name, role) VALUES (?, ?, ?, ?, 'admin')";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param('ssss', $username, $email, $hashed_password, $full_name);
    
    if ($stmt->execute()) {
        $user_id = $conn->insert_id;
        echo json_encode([
            'success' => true,
            'message' => 'Admin registration successful',
            'user_id' => $user_id
        ]);
    } else {
        echo json_encode(['success' => false, 'message' => $conn->error]);
    }
    $stmt->close();
}


elseif ($method == 'POST' && $action == 'logout') {
    session_destroy();
    echo json_encode(['success' => true, 'message' => 'Logged out successfully']);
}

else {
    echo json_encode(['success' => false, 'message' => 'Invalid request']);
}

$conn->close();
?>
