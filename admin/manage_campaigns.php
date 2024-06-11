<?php
include '../includes/config.php';
include './includes/functions.php';


if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['delete_id'])) {
    deleteCampaign($conn, $_POST['delete_id']);
}
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['add_campaign'])) {
    $image_name = $_FILES['image']['name'];
    $image_tmp_name = $_FILES['image']['tmp_name'];
    $image_url = "includes/gallery/campaign/" . basename($image_name);

    // Move uploaded image to gallery folder
    if (move_uploaded_file($image_tmp_name, $image_url)) {
        // Insert image data into database
        addCampaign($conn, $_POST['title'], $_POST['description'], $_POST['target_amount'], "active", $_POST['start_date'], $image_name);
    }
}

$campaigns = getAllCampaigns($conn);
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Manage Campaigns</title>
</head>

<body>

    <?php include './includes/header.php'; ?>

    <div class="container" style="margin-top: 100px;">
        <div class="row">
            <?php
            $sql = "SELECT count(*) as total from campaigns;";
            $result = $conn->query($sql);
            while ($row = $result->fetch_assoc())
                $total = $row['total'];
            ?>
            <div class="col-md-4">
                <div class="block-48">
                    <span class="block-48-text-1">Total Campaigns</span>
                    <div class="block-48-counter ftco-number"><?php echo (int)$total; ?></div>
                    <p class="mb-0"><a href="#manage" class="btn btn-white px-3 py-2">Manage Campaigns</a></p>
                </div>
            </div>


            <div class="col-md-8">

                <div class="block-48">

                    <h2>Add a new Campaign</h2>
                    <form action="" method="post" enctype="multipart/form-data">
                        <div class="form-group">
                            <!-- <label for="name">Name</label> -->
                            <input type="text" class="form-control py-2" id="title" name="title" placeholder="Enter campaign title">
                        </div>
                        <div class="form-group">
                            <!-- <label for="v_message">Email</label> -->
                            <textarea name="description" id="" cols="30" rows="3" class="form-control py-2" placeholder="Description"></textarea>
                            <!-- <input type="text" class="form-control py-2" id="email"> -->
                        </div>
                        <div class="form-group">
                            <!-- <label for="email">Email</label> -->
                            <input type="number" class="form-control py-2" id="target_amount" name="target_amount" placeholder="Target Amount">
                        </div>
                        <div class="form-group">
                            <!-- <label for="email">Email</label> -->
                            <input type="date" class="form-control py-2" id="start_date" name="start_date" placeholder="Start Date">
                        </div>
                        <div class="form-group">
                            <!-- <label for="email">Email</label> -->
                            <input type="file" class="form-control py-2" id="file" name="image" placeholder="Select Image">
                        </div>
                        <div class="form-group">
                            <input type="submit" class="btn btn-white px-5 py-2" name="add_campaign" value="Add Campaign">
                        </div>
                    </form>
                </div>
            </div>

        </div>
    </div>

    <div class="container mt-5" id="manage">
        <h2>Manage Campaigns</h2>
        <table class="table table-bordered">
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Title</th>
                    <th>Description</th>
                    <th>Target Amount</th>
                    <th>Raised Amount</th>
                    <th>Start Date</th>
                    <th>End Date</th>
                    <th>Actions</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($campaigns as $campaign) : ?>
                    <tr>
                        <td><?php echo htmlspecialchars($campaign['id']); ?></td>
                        <td><?php echo htmlspecialchars($campaign['title']); ?></td>
                        <td><?php echo htmlspecialchars($campaign['description']); ?></td>
                        <td><?php echo htmlspecialchars($campaign['target_amount']); ?></td>
                        <td><?php echo htmlspecialchars($campaign['raised_amount']); ?></td>
                        <td><?php echo htmlspecialchars($campaign['start_date']); ?></td>
                        <td><?php echo htmlspecialchars($campaign['end_date']); ?></td>
                        <td>
                            <form method="post" style="display:inline;">
                                <input type="hidden" name="delete_id" value="<?php echo $campaign['id']; ?>">
                                <button type="submit" class="btn btn-primary btn-sm">Delete</button>
                            </form>
                            <!-- Add edit functionality here if needed -->
                        </td>
                    </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
    </div>

</body>

</html>