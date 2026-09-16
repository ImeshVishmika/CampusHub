<?php

header('Content-Type: application/json');
require_once '../config/db.php';
global $conn;

$method = $_SERVER['REQUEST_METHOD'];
$action = isset($_GET['action']) ? $_GET['action'] : '';


if ($method == 'GET' && $action == 'list') {
    $status = isset($_GET['status']) ? $_GET['status'] : 'active';
    
    $sql = "SELECT id, form_name, form_description, form_type, form_status, created_date FROM forms WHERE form_status = ? ORDER BY created_date DESC";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param('s', $status);
    $stmt->execute();
    $result = $stmt->get_result();
    
    $forms = [];
    while ($row = $result->fetch_assoc()) {
        $forms[] = $row;
    }
    
    echo json_encode(['success' => true, 'data' => $forms]);
    $stmt->close();
}


elseif ($method == 'GET' && $action == 'details') {
    $form_id = isset($_GET['id']) ? intval($_GET['id']) : 0;
    
    if ($form_id == 0) {
        echo json_encode(['success' => false, 'message' => 'Form ID required']);
        exit;
    }
    
    $sql = "SELECT id, form_name, form_description, form_type, form_status, created_date FROM forms WHERE id = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param('i', $form_id);
    $stmt->execute();
    $result = $stmt->get_result();
    
    if ($result->num_rows == 0) {
        echo json_encode(['success' => false, 'message' => 'Form not found']);
        $stmt->close();
        exit;
    }
    
    $form = $result->fetch_assoc();
    $stmt->close();
    
    
    $sql = "SELECT id, field_name, field_type, field_label, is_required, field_options, field_order FROM form_fields WHERE form_id = ? ORDER BY field_order ASC";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param('i', $form_id);
    $stmt->execute();
    $fields_result = $stmt->get_result();
    
    $fields = [];
    while ($field = $fields_result->fetch_assoc()) {
        if ($field['field_options']) {
            $field['field_options'] = json_decode($field['field_options'], true);
        }
        $fields[] = $field;
    }
    
    $form['fields'] = $fields;
    echo json_encode(['success' => true, 'data' => $form]);
    $stmt->close();
}


elseif ($method == 'POST' && $action == 'create') {
    $input = json_decode(file_get_contents('php://input'), true);
    
    $form_name = isset($input['form_name']) ? trim($input['form_name']) : '';
    $form_description = isset($input['form_description']) ? trim($input['form_description']) : '';
    $form_type = isset($input['form_type']) ? trim($input['form_type']) : '';
    $admin_id = isset($input['admin_id']) ? intval($input['admin_id']) : 0;
    
    if (empty($form_name)) {
        echo json_encode(['success' => false, 'message' => 'Form name is required']);
        exit;
    }
    
    $sql = "INSERT INTO forms (form_name, form_description, form_type, created_by, form_status) VALUES (?, ?, ?, ?, 'active')";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param('sssi', $form_name, $form_description, $form_type, $admin_id);
    
    if ($stmt->execute()) {
        $form_id = $conn->insert_id;
        echo json_encode(['success' => true, 'message' => 'Form created successfully', 'id' => $form_id]);
    } else {
        echo json_encode(['success' => false, 'message' => $conn->error]);
    }
    $stmt->close();
}


elseif ($method == 'POST' && $action == 'add_field') {
    $input = json_decode(file_get_contents('php://input'), true);
    
    $form_id = isset($input['form_id']) ? intval($input['form_id']) : 0;
    $field_name = isset($input['field_name']) ? trim($input['field_name']) : '';
    $field_type = isset($input['field_type']) ? trim($input['field_type']) : '';
    $field_label = isset($input['field_label']) ? trim($input['field_label']) : '';
    $is_required = isset($input['is_required']) ? (bool)$input['is_required'] : false;
    $field_options = isset($input['field_options']) ? json_encode($input['field_options']) : null;
    $field_order = isset($input['field_order']) ? intval($input['field_order']) : 0;
    
    if ($form_id == 0 || empty($field_name)) {
        echo json_encode(['success' => false, 'message' => 'Form ID and field name are required']);
        exit;
    }
    
    $is_required_int = $is_required ? 1 : 0;
    
    $sql = "INSERT INTO form_fields (form_id, field_name, field_type, field_label, is_required, field_options, field_order) VALUES (?, ?, ?, ?, ?, ?, ?)";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param('isssisi', $form_id, $field_name, $field_type, $field_label, $is_required_int, $field_options, $field_order);
    
    if ($stmt->execute()) {
        echo json_encode(['success' => true, 'message' => 'Field added successfully', 'id' => $conn->insert_id]);
    } else {
        echo json_encode(['success' => false, 'message' => $conn->error]);
    }
    $stmt->close();
}


elseif ($method == 'POST' && $action == 'submit') {
    $input = json_decode(file_get_contents('php://input'), true);
    
    $form_id = isset($input['form_id']) ? intval($input['form_id']) : 0;
    $user_id = isset($input['user_id']) ? intval($input['user_id']) : 0;
    $submission_data = isset($input['data']) ? json_encode($input['data']) : '{}';
    
    if ($form_id == 0 || $user_id == 0) {
        echo json_encode(['success' => false, 'message' => 'Form ID and user ID are required']);
        exit;
    }
    
    $sql = "INSERT INTO form_submissions (form_id, user_id, submission_data) VALUES (?, ?, ?)";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param('iis', $form_id, $user_id, $submission_data);
    
    if ($stmt->execute()) {
        echo json_encode(['success' => true, 'message' => 'Form submitted successfully', 'id' => $conn->insert_id]);
    } else {
        echo json_encode(['success' => false, 'message' => $conn->error]);
    }
    $stmt->close();
}


elseif ($method == 'GET' && $action == 'submissions') {
    $form_id = isset($_GET['form_id']) ? intval($_GET['form_id']) : 0;
    
    if ($form_id == 0) {
        echo json_encode(['success' => false, 'message' => 'Form ID required']);
        exit;
    }
    
    $sql = "SELECT fs.id, fs.user_id, u.full_name, u.email, fs.submission_data, fs.submission_date FROM form_submissions fs JOIN users u ON fs.user_id = u.id WHERE fs.form_id = ? ORDER BY fs.submission_date DESC";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param('i', $form_id);
    $stmt->execute();
    $result = $stmt->get_result();
    
    $submissions = [];
    while ($row = $result->fetch_assoc()) {
        $row['submission_data'] = json_decode($row['submission_data'], true);
        $submissions[] = $row;
    }
    
    echo json_encode(['success' => true, 'data' => $submissions]);
    $stmt->close();
}


elseif ($method == 'GET' && $action == 'user_submissions') {
    $user_id = isset($_GET['user_id']) ? intval($_GET['user_id']) : 0;
    
    if ($user_id == 0) {
        echo json_encode(['success' => false, 'message' => 'User ID required']);
        exit;
    }
    
    $sql = "SELECT fs.id, fs.form_id, f.form_name, fs.submission_data, fs.submission_date FROM form_submissions fs JOIN forms f ON fs.form_id = f.id WHERE fs.user_id = ? ORDER BY fs.submission_date DESC";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param('i', $user_id);
    $stmt->execute();
    $result = $stmt->get_result();
    
    $submissions = [];
    while ($row = $result->fetch_assoc()) {
        $row['submission_data'] = json_decode($row['submission_data'], true);
        $submissions[] = $row;
    }
    
    echo json_encode(['success' => true, 'data' => $submissions]);
    $stmt->close();
}


elseif ($method == 'PUT' && $action == 'update_status') {
    $input = json_decode(file_get_contents('php://input'), true);
    
    $form_id = isset($input['form_id']) ? intval($input['form_id']) : 0;
    $form_status = isset($input['form_status']) ? trim($input['form_status']) : 'active';
    
    if ($form_id == 0) {
        echo json_encode(['success' => false, 'message' => 'Form ID required']);
        exit;
    }
    
    $sql = "UPDATE forms SET form_status = ? WHERE id = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param('si', $form_status, $form_id);
    
    if ($stmt->execute()) {
        echo json_encode(['success' => true, 'message' => 'Form status updated successfully']);
    } else {
        echo json_encode(['success' => false, 'message' => $conn->error]);
    }
    $stmt->close();
}


elseif ($method == 'POST' && $action == 'delete') {
    $input = json_decode(file_get_contents('php://input'), true);
    $form_id = isset($input['id']) ? intval($input['id']) : 0;
    
    if ($form_id == 0) {
        echo json_encode(['success' => false, 'message' => 'Form ID required']);
        exit;
    }
    
    $sql = "DELETE FROM forms WHERE id = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param('i', $form_id);
    
    if ($stmt->execute()) {
        echo json_encode(['success' => true, 'message' => 'Form deleted successfully']);
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
