<?php

include '../includes/config.php';

if (!isset($_SESSION['aid'])) {
    header("Location: ./login.php");
}

$sql = "SELECT count(id) as total from campaigns;";
$result = $conn->query($sql);
while ($row = $result->fetch_assoc())
    $total = $row['total'];

?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Panel</title>
</head>

<body>
    <?php include './includes/header.php'; ?>

    <div class="container" style="margin-top: 100px;">
        <div class="row">

            <div class="col-md-6">
                <div class="block-48">
                    <span class="block-48-text-1">Total Campaigns</span>
                    <div class="block-48-counter ftco-number"><?php echo (int)$total; ?></div>
                    <p class="mb-0"><a href="./manage_campaigns.php" class="btn btn-white px-3 py-2">Manage Campaigns</a></p>
                </div>
            </div>

            <?php
            $sql = "SELECT count(id) as total from users;";
            $result = $conn->query($sql);
            while ($row = $result->fetch_assoc())
                $total = $row['total'];
            ?>
            <div class="col-md-6">
                <div class="block-48">
                    <span class="block-48-text-1">Total Volunteers</span>
                    <div class="block-48-counter ftco-number"><?php echo (int)$total; ?></div>
                    <p class="mb-0"><a href="./manage_users.php" class="btn btn-white px-3 py-2">Manage Volunteers</a></p>
                </div>
            </div>

        </div>
    </div>

    <div class="container" style="margin-top: 40px;">
        <div class="row">

            <?php
            $sql = "SELECT count(*) as total from gallery;";
            $result = $conn->query($sql);
            while ($row = $result->fetch_assoc())
                $total = $row['total'];
            ?>
            <div class="col-md-6">
                <div class="block-48">
                    <span class="block-48-text-1">Gallery Images</span>
                    <div class="block-48-counter ftco-number"><?php echo (int)$total; ?></div>
                    <p class="mb-0"><a href="./manage_gallery.php" class="btn btn-white px-3 py-2">Manage Gallery</a></p>
                </div>
            </div>

            <?php
            $sql = "SELECT count(id) as total from donation;";
            $result = $conn->query($sql);
            while ($row = $result->fetch_assoc())
                $total = $row['total'];
            ?>
            <div class="col-md-6">
                <div class="block-48">
                    <span class="block-48-text-1">Total Donations</span>
                    <div class="block-48-counter ftco-number"><?php echo (int)$total; ?></div>
                    <p class="mb-0"><a href="./manage_account.php" class="btn btn-white px-3 py-2">Manage Accounts</a></p>
                </div>
            </div>

        </div>
    </div>

</body>

</html>