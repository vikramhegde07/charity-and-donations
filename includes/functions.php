<?php

function updateUserEmailAndUsername($userId, $newEmail, $newUsername)
{
    global $conn;

    $sql = "UPDATE users SET email = ?, username = ? WHERE id = ?";
    $stmt = $conn->prepare($sql);

    if ($stmt === false) {
        die('Prepare failed: ' . htmlspecialchars($conn->error));
    }

    $stmt->bind_param('ssi', $newEmail, $newUsername, $userId);

    if ($stmt->execute()) {
        return ['status' => 'success', 'message' => 'Email and username updated successfully.'];
    } else {
        return ['status' => 'error', 'message' => 'Error updating email and username: ' . htmlspecialchars($stmt->error)];
    }

    $stmt->close();
}

function updateUser($userId, $newEmail, $newUsername, $oldPass, $newPass, $confPass)
{
    global $conn;

    $sql = "SELECT password from users where id = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param('s', $userId);
    $stmt->execute();
    $stmt->bind_result($hashed_password);
    $stmt->fetch();
    $stmt->close();

    if (password_verify($hashed_password, $oldPass)) {
        if ($newPass == $confPass) {
            $newPass = password_hash($newPass,PASSWORD_DEFAULT);
            $sql = "UPDATE users SET email = ?, username = ?,password = ? WHERE id = ?";
            $stmt = $conn->prepare($sql);

            if ($stmt === false) {
                die('Prepare failed: ' . htmlspecialchars($conn->error));
            }

            $stmt->bind_param('sssi', $newEmail, $newUsername, $newPass, $userId);

            if ($stmt->execute()) {
                return ['status' => 'success', 'message' => 'Email and username updated successfully.'];
            } else {
                return ['status' => 'error', 'message' => 'Error updating email and username: ' . htmlspecialchars($stmt->error)];
            }

            $stmt->close();
        } else {
            return ['status' => 'Failed', 'message' => 'New passwords do not match'];
        }
    } else {
        return ['status' => 'Failed', 'message' => 'Old password is wrong'];
    }


    $sql = "UPDATE users SET email = ?, username = ? WHERE id = ?";
    $stmt = $conn->prepare($sql);

    if ($stmt === false) {
        die('Prepare failed: ' . htmlspecialchars($conn->error));
    }

    $stmt->bind_param('ssi', $newEmail, $newUsername, $userId);

    if ($stmt->execute()) {
        return ['status' => 'success', 'message' => 'Email and username updated successfully.'];
    } else {
        return ['status' => 'error', 'message' => 'Error updating email and username: ' . htmlspecialchars($stmt->error)];
    }

    $stmt->close();
}
