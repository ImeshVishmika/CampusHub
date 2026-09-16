<?php

header('Content-Type: application/json');
require_once '../config/db.php';
global $conn;

$method = $_SERVER['REQUEST_METHOD'];
$action = isset($_GET['action']) ? $_GET['action'] : '';


if ($method == 'GET' && $action == 'list') {
    $status = isset($_GET['status']) ? $_GET['status'] : 'upcoming';
    
    $sql = "SELECT id, title, description, event_date, location, category, max_capacity, image_url, status FROM events WHERE status = ? ORDER BY event_date DESC";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param('s', $status);
    $stmt->execute();
    $result = $stmt->get_result();
    
    $events = [];
    while ($row = $result->fetch_assoc()) {
        $events[] = $row;
    }
    
    echo json_encode(['success' => true, 'data' => $events]);
    $stmt->close();
}


elseif ($method == 'GET' && $action == 'details') {
    $event_id = isset($_GET['id']) ? intval($_GET['id']) : 0;
    
    if ($event_id == 0) {
        echo json_encode(['success' => false, 'message' => 'Event ID required']);
        exit;
    }
    
    $sql = "SELECT e.*, COUNT(DISTINCT er.id) as registration_count FROM events e LEFT JOIN event_registrations er ON e.id = er.event_id WHERE e.id = ? GROUP BY e.id";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param('i', $event_id);
    $stmt->execute();
    $result = $stmt->get_result();
    
    if ($result->num_rows > 0) {
        $event = $result->fetch_assoc();
        
        
        $sql = "SELECT id, group_name, description, group_category, max_members FROM event_groups WHERE event_id = ?";
        $stmt2 = $conn->prepare($sql);
        $stmt2->bind_param('i', $event_id);
        $stmt2->execute();
        $groups_result = $stmt2->get_result();
        
        $groups = [];
        while ($group = $groups_result->fetch_assoc()) {
            $groups[] = $group;
        }
        
        $event['groups'] = $groups;
        echo json_encode(['success' => true, 'data' => $event]);
        $stmt2->close();
    } else {
        echo json_encode(['success' => false, 'message' => 'Event not found']);
    }
    $stmt->close();
}


elseif ($method == 'POST' && $action == 'create') {
    $input = json_decode(file_get_contents('php://input'), true);
    
    $title = isset($input['title']) ? trim($input['title']) : '';
    $description = isset($input['description']) ? trim($input['description']) : '';
    $event_date = isset($input['event_date']) ? $input['event_date'] : '';
    $location = isset($input['location']) ? trim($input['location']) : '';
    $category = isset($input['category']) ? trim($input['category']) : '';
    $max_capacity = isset($input['max_capacity']) ? intval($input['max_capacity']) : 0;
    $organizer_id = isset($input['organizer_id']) ? intval($input['organizer_id']) : 0;
    
    if (empty($title) || empty($event_date)) {
        echo json_encode(['success' => false, 'message' => 'Missing required fields']);
        exit;
    }
    
    $sql = "INSERT INTO events (title, description, event_date, location, category, max_capacity, organizer_id, status) VALUES (?, ?, ?, ?, ?, ?, ?, 'upcoming')";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param('sssssii', $title, $description, $event_date, $location, $category, $max_capacity, $organizer_id);
    
    if ($stmt->execute()) {
        $event_id = $conn->insert_id;
        echo json_encode(['success' => true, 'message' => 'Event created successfully', 'id' => $event_id]);
    } else {
        echo json_encode(['success' => false, 'message' => $conn->error]);
    }
    $stmt->close();
}


elseif ($method == 'POST' && $action == 'create_group') {
    $input = json_decode(file_get_contents('php://input'), true);
    
    $event_id = isset($input['event_id']) ? intval($input['event_id']) : 0;
    $group_name = isset($input['group_name']) ? trim($input['group_name']) : '';
    $description = isset($input['description']) ? trim($input['description']) : '';
    $group_category = isset($input['group_category']) ? trim($input['group_category']) : '';
    $max_members = isset($input['max_members']) ? intval($input['max_members']) : 0;
    
    if ($event_id == 0 || empty($group_name)) {
        echo json_encode(['success' => false, 'message' => 'Missing required fields']);
        exit;
    }
    
    $sql = "INSERT INTO event_groups (event_id, group_name, description, group_category, max_members) VALUES (?, ?, ?, ?, ?)";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param('isssi', $event_id, $group_name, $description, $group_category, $max_members);
    
    if ($stmt->execute()) {
        $group_id = $conn->insert_id;
        echo json_encode(['success' => true, 'message' => 'Group created successfully', 'id' => $group_id]);
    } else {
        echo json_encode(['success' => false, 'message' => $conn->error]);
    }
    $stmt->close();
}


elseif ($method == 'POST' && $action == 'register') {
    $input = json_decode(file_get_contents('php://input'), true);
    
    $student_id = isset($input['student_id']) ? intval($input['student_id']) : 0;
    $event_id = isset($input['event_id']) ? intval($input['event_id']) : 0;
    $group_id = isset($input['group_id']) ? intval($input['group_id']) : null;
    
    if ($student_id == 0 || $event_id == 0) {
        echo json_encode(['success' => false, 'message' => 'Missing required fields']);
        exit;
    }
    
    $sql = "INSERT INTO event_registrations (student_id, event_id, group_id, registration_status) VALUES (?, ?, ?, 'registered')";
    $stmt = $conn->prepare($sql);
    
    if ($group_id !== null) {
        $stmt->bind_param('iii', $student_id, $event_id, $group_id);
    } else {
        $stmt->bind_param('iii', $student_id, $event_id, $group_id);
    }
    
    if ($stmt->execute()) {
        echo json_encode(['success' => true, 'message' => 'Registered for event successfully', 'id' => $conn->insert_id]);
    } else {
        echo json_encode(['success' => false, 'message' => $conn->error]);
    }
    $stmt->close();
}


elseif ($method == 'GET' && $action == 'registrations') {
    $event_id = isset($_GET['event_id']) ? intval($_GET['event_id']) : 0;
    $group_id = isset($_GET['group_id']) ? intval($_GET['group_id']) : null;
    
    if ($event_id == 0) {
        echo json_encode(['success' => false, 'message' => 'Event ID required']);
        exit;
    }
    
    if ($group_id) {
        $sql = "SELECT er.id, er.student_id, u.full_name, u.email, er.registration_status, er.registration_date FROM event_registrations er JOIN users u ON er.student_id = u.id WHERE er.event_id = ? AND er.group_id = ?";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param('ii', $event_id, $group_id);
    } else {
        $sql = "SELECT er.id, er.student_id, u.full_name, u.email, er.registration_status, er.registration_date FROM event_registrations er JOIN users u ON er.student_id = u.id WHERE er.event_id = ?";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param('i', $event_id);
    }
    
    $stmt->execute();
    $result = $stmt->get_result();
    
    $registrations = [];
    while ($row = $result->fetch_assoc()) {
        $registrations[] = $row;
    }
    
    echo json_encode(['success' => true, 'data' => $registrations]);
    $stmt->close();
}


elseif ($method == 'POST' && $action == 'cancel_registration') {
    $input = json_decode(file_get_contents('php://input'), true);
    
    $registration_id = isset($input['registration_id']) ? intval($input['registration_id']) : 0;
    
    if ($registration_id == 0) {
        echo json_encode(['success' => false, 'message' => 'Registration ID required']);
        exit;
    }
    
    $sql = "UPDATE event_registrations SET registration_status = 'cancelled' WHERE id = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param('i', $registration_id);
    
    if ($stmt->execute()) {
        echo json_encode(['success' => true, 'message' => 'Registration cancelled successfully']);
    } else {
        echo json_encode(['success' => false, 'message' => $conn->error]);
    }
    $stmt->close();
}


elseif ($method == 'PUT' && $action == 'update') {
    $input = json_decode(file_get_contents('php://input'), true);
    
    $event_id = isset($input['id']) ? intval($input['id']) : 0;
    $title = isset($input['title']) ? trim($input['title']) : '';
    $description = isset($input['description']) ? trim($input['description']) : '';
    $event_date = isset($input['event_date']) ? $input['event_date'] : '';
    $location = isset($input['location']) ? trim($input['location']) : '';
    $category = isset($input['category']) ? trim($input['category']) : '';
    $max_capacity = isset($input['max_capacity']) ? intval($input['max_capacity']) : 0;
    $status = isset($input['status']) ? trim($input['status']) : 'upcoming';
    
    if ($event_id == 0 || empty($title) || empty($event_date)) {
        echo json_encode(['success' => false, 'message' => 'Missing required fields']);
        exit;
    }
    
    $sql = "UPDATE events SET title=?, description=?, event_date=?, location=?, category=?, max_capacity=?, status=? WHERE id=?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param('sssssisi', $title, $description, $event_date, $location, $category, $max_capacity, $status, $event_id);
    
    if ($stmt->execute()) {
        echo json_encode(['success' => true, 'message' => 'Event updated successfully']);
    } else {
        echo json_encode(['success' => false, 'message' => $conn->error]);
    }
    $stmt->close();
}


elseif ($method == 'POST' && $action == 'delete') {
    $input = json_decode(file_get_contents('php://input'), true);
    $event_id = isset($input['id']) ? intval($input['id']) : 0;
    
    if ($event_id == 0) {
        echo json_encode(['success' => false, 'message' => 'Event ID required']);
        exit;
    }
    
    $sql = "DELETE FROM events WHERE id = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param('i', $event_id);
    
    if ($stmt->execute()) {
        echo json_encode(['success' => true, 'message' => 'Event deleted successfully']);
    } else {
        echo json_encode(['success' => false, 'message' => $conn->error]);
    }
    $stmt->close();
}


elseif ($method == 'PUT' && $action == 'update_registration_status') {
    $input = json_decode(file_get_contents('php://input'), true);
    
    $registration_id = isset($input['registration_id']) ? intval($input['registration_id']) : 0;
    $status = isset($input['status']) ? trim($input['status']) : '';
    
    if ($registration_id == 0 || empty($status)) {
        echo json_encode(['success' => false, 'message' => 'Registration ID and status required']);
        exit;
    }
    
    $sql = "UPDATE event_registrations SET registration_status = ? WHERE id = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param('si', $status, $registration_id);
    
    if ($stmt->execute()) {
        echo json_encode(['success' => true, 'message' => 'Registration status updated successfully']);
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
