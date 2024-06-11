<?php
session_start();
include './config.php';

if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_FILES['profile_photo'])) {

    if (isset($_SESSION['uid'])) {
        $uploadDir = 'images/profile/';
        $userId = $_SESSION['uid'];
        $sql = "UPDATE users SET image = ? WHERE id = ?";
    } else {
        $uploadDir = 'images/admin/';
        $userId = $_SESSION['aid'];
        $sql = "UPDATE admin SET image = ? WHERE id = ?";

    }
    $uploadFile = $uploadDir . basename($_FILES['profile_photo']['name']);


    $check = getimagesize($_FILES['profile_photo']['tmp_name']);
    if ($check !== false) {
        if (move_uploaded_file($_FILES['profile_photo']['tmp_name'], $uploadFile)) {

            $profilePhotoUrl = $uploadFile;

            $stmt = $conn->prepare($sql);
            $stmt->bind_param('si', $profilePhotoUrl, $userId);

            if ($stmt->execute()) {
                echo json_encode(['status' => 'success', 'message' => 'Profile photo updated successfully.']);
            } else {
                http_response_code(500);
                echo json_encode(['status' => 'error', 'message' => 'Error updating profile photo: ' . $stmt->error]);
            }
        } else {
            http_response_code(500);
            echo json_encode(['status' => 'error', 'message' => 'Error uploading file.']);
        }
    } else {
        http_response_code(400);
        echo json_encode(['status' => 'error', 'message' => 'File is not an image.']);
    }
} else {
    http_response_code(400);
    echo json_encode(['status' => 'error', 'message' => 'Invalid request.']);
}
