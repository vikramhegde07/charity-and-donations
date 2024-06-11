<?php
include './config.php';

// Function to update the raised amount and campaign status
function updateCampaign($conn, $campaign_id, $amount)
{
    // Get the current raised amount and target amount
    $sql = "SELECT raised_amount, target_amount FROM campaigns WHERE id=?";
    $stmt = mysqli_prepare($conn, $sql);
    mysqli_stmt_bind_param($stmt, "i", $campaign_id);
    mysqli_stmt_execute($stmt);
    mysqli_stmt_bind_result($stmt, $raised_amount, $target_amount);
    mysqli_stmt_fetch($stmt);
    mysqli_stmt_close($stmt);

    // Calculate new raised amount
    $new_raised_amount = $raised_amount + $amount;

    // Determine new status
    $status = $new_raised_amount >= $target_amount ? 'inactive' : 'active';
    $current_date = date("y-m-d");
    // Update campaign in the database
    $sql = "UPDATE campaigns SET raised_amount=?, status=?,end_date=? WHERE id=?";
    $stmt = mysqli_prepare($conn, $sql);
    mysqli_stmt_bind_param($stmt, "dssi", $new_raised_amount, $status, $current_date, $campaign_id);
    mysqli_stmt_execute($stmt);
    mysqli_stmt_close($stmt);
}

function updateDonate($conn, $campaign_id, $amount)
{
    if ($_SESSION['uid'] != "") {
        $uid = $_SESSION['uid'];

        $sql = "INSERT into donation (user_id,campaign_id,amount) values ($uid,$campaign_id,$amount)";
        $conn->query($sql);
    } else {
        header("Location: ../login.php");
    }
}

// Check if form is submitted
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['campaign_id']) && isset($_POST['amount'])) {
    $campaign_id = $_POST['campaign_id'];
    $amount = $_POST['amount'];

    // Update campaign with the donated amount
    updateCampaign($conn, $campaign_id, $amount);
    updateDonate($conn, $campaign_id, $amount);

    // Redirect to thank you page or similar
    header("Location: ../thanks.php");
    exit();
}
