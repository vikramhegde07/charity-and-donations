<?php

// Function to get all campaigns
function getAllCampaigns($conn)
{
    $sql = "SELECT * FROM campaigns";
    $result = mysqli_query($conn, $sql);
    $campaigns = mysqli_fetch_all($result, MYSQLI_ASSOC);
    return $campaigns;
}

// Function to delete a campaign
function deleteCampaign($conn, $id)
{
    $sql = "DELETE FROM campaigns WHERE id=?";
    $stmt = mysqli_prepare($conn, $sql);
    mysqli_stmt_bind_param($stmt, "i", $id);
    mysqli_stmt_execute($stmt);
    mysqli_stmt_close($stmt);
}

// Function to add a new campaign
function addCampaign($conn, $title, $description, $target_amount, $status, $start_date, $img)
{
    $sql = "INSERT INTO campaigns ( title, description, target_amount, status,start_date, img) VALUES ( ?, ?, ?, ?, ?, ?)";
    $stmt = mysqli_prepare($conn, $sql);
    mysqli_stmt_bind_param($stmt, "ssssss", $title, $description, $target_amount, $status, $start_date, $img);
    mysqli_stmt_execute($stmt);
    mysqli_stmt_close($stmt);
}

function getImagesFromDB()
{
    global $conn;
    $sql = "SELECT * FROM gallery";
    $result = mysqli_query($conn, $sql);
    $images = mysqli_fetch_all($result, MYSQLI_ASSOC);
    return $images;
}

// Function to delete an image from the database and file system
function deleteImage($conn, $id, $image)
{

    $sql = "DELETE FROM gallery WHERE id=$id";
    $result = $conn->query($sql);

    if ($result) {
        // Delete from file system
        $file_path = "includes/gallery/" . $image;
        if (file_exists($file_path)) {
            if (unlink($file_path))
                return "success";
            else
                return "fail in deleting";
        }
    } else {
        return $conn->error;
    }
}

function insertImage($conn, $image_url)
{
    $sql = "INSERT INTO gallery (imgsrc) VALUES ('$image_url')";
    $conn->query($sql);
}

function createUser($username, $email, $password)
{
    global $conn;
    $hashedPassword = password_hash($password, PASSWORD_DEFAULT);
    $sql = "INSERT INTO users (username, email, password) VALUES ('$username', '$email', '$hashedPassword')";
    return $conn->query($sql);
}

function getUsers()
{
    global $conn;
    $sql = "SELECT * FROM users";
    return $conn->query($sql);
}

function getUserById($id)
{
    global $conn;
    $sql = "SELECT * FROM users WHERE id=$id";
    return $conn->query($sql)->fetch_assoc();
}

function deleteUser($id)
{
    global $conn;
    $sql = "DELETE FROM users WHERE id=$id";
    return $conn->query($sql);
}

function createAdmin($username, $email, $password)
{
    global $conn;
    $hashedPassword = password_hash($password, PASSWORD_DEFAULT);
    $sql = "INSERT INTO admin (adminName, email, password) VALUES ('$username', '$email', '$hashedPassword')";
    return $conn->query($sql);
}

function getAdmins()
{
    global $conn;
    $sql = "SELECT * FROM admin where id != 1";
    return $conn->query($sql);
}

function getAdminById($id)
{
    global $conn;
    $sql = "SELECT * FROM admin WHERE id=$id";
    return $conn->query($sql)->fetch_assoc();
}

function deleteAdmin($id)
{
    global $conn;
    $sql = "DELETE FROM admin WHERE id=$id";
    return $conn->query($sql);
}

function getTransactions($limit, $offset)
{
    global $conn;
    $sql = "SELECT donation.id as id, donation.campaign_id as campaign_id, users.username as donor_name, users.email as donor_email, donation.donation_date as transaction_date, donation.amount as amount  FROM donation join users on users.id = donation.user_id LIMIT $offset,$limit";
    $result = mysqli_query($conn, $sql);
    $transactions = mysqli_fetch_all($result, MYSQLI_ASSOC);
    return $transactions;
}

// Function to fetch total amounts raised per campaign
function getTotalAmountsPerCampaign($limit, $offset)
{
    global $conn;
    $sql = "SELECT donation.campaign_id as campaign_id, SUM(donation.amount) as total_amount, campaigns.title as title FROM donation join campaigns on campaigns.id = donation.campaign_id  GROUP BY campaign_id LIMIT $offset,$limit";
    $result = mysqli_query($conn, $sql);
    $totals = mysqli_fetch_all($result, MYSQLI_ASSOC);
    return $totals;
}

function getTotalTransactionCount()
{
    global $conn;
    $sql = "SELECT COUNT(id) as count FROM donation";
    $result = mysqli_query($conn, $sql);
    $row = mysqli_fetch_assoc($result);
    return $row['count'];
}

function getTotalCampaignCount()
{
    global $conn;
    $sql = "SELECT COUNT(DISTINCT campaign_id) as count FROM donation";
    $result = mysqli_query($conn, $sql);
    $row = mysqli_fetch_assoc($result);
    return $row['count'];
}
function getFilteredTransactions($user_email = null, $campaign_id = null)
{
    global $conn;
    $sql = "SELECT donation.id as id, donation.campaign_id as campaign_id, users.username as donor_name, users.email as donor_email, donation.donation_date as transaction_date, donation.amount as amount  FROM donation join users on users.id = donation.user_id WHERE 1=1";

    if ($user_email) {
        $sql .= " AND users.email = ?";
    }
    if ($campaign_id) {
        $sql .= " AND campaign_id = ?";
    }

    $stmt = mysqli_prepare($conn, $sql);

    if ($user_email && $campaign_id) {
        mysqli_stmt_bind_param($stmt, "si", $user_email, $campaign_id);
    } elseif ($user_email) {
        mysqli_stmt_bind_param($stmt, "s", $user_email);
    } elseif ($campaign_id) {
        mysqli_stmt_bind_param($stmt, "i", $campaign_id);
    }

    mysqli_stmt_execute($stmt);
    $result = mysqli_stmt_get_result($stmt);
    $transactions = mysqli_fetch_all($result, MYSQLI_ASSOC);
    mysqli_stmt_close($stmt);
    return $transactions;
}
