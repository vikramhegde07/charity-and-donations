<?php
include '../includes/config.php';
include './includes/functions.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['delete_id'])) {
    $did = $_POST['delete_id'];
    $filename = $_POST['filename'];
    deleteImage($conn, $did, $filename);
    echo "deleting";
}
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_FILES['image'])) {
    $image_name = $_FILES['image']['name'];
    $image_tmp_name = $_FILES['image']['tmp_name'];
    $image_url = "includes/gallery/" . basename($image_name);

    // Move uploaded image to gallery folder
    if (move_uploaded_file($image_tmp_name, $image_url)) {
        // Insert image data into database
        insertImage($conn,$image_name);
    } else {
        $error =  "Error uploading image.";
    }
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Manage Gallery</title>
</head>

<body>
    <?php include './includes/header.php' ?>

    <div class="container" style="margin-top: 100px;">
        <div class="row">

            <?php
            $sql = "SELECT count(*) as total from gallery;";
            $result = $conn->query($sql);
            while ($row = $result->fetch_assoc())
                $total = $row['total'];
            ?>
            <div class="col-md-4">
                <div class="block-48">
                    <span class="block-48-text-1">Total Images</span>
                    <div class="block-48-counter ftco-number"><?php echo (int)$total; ?></div>
                    <p class="mb-0"><a href="#manage" class="btn btn-white px-3 py-2">Manage Gallery</a></p>
                </div>
            </div>


            <div class="col-md-8">
                <div class="block-48">

                    <h2>Add new Image</h2>
                    <form action="" method="post" enctype="multipart/form-data">
                        <div class="form-group">
                            <!-- <label for="name">Name</label> -->
                            <input type="file" class="form-control py-2" id="image" name="image" accept="image/*" placeholder="Select Image">
                        </div>

                        <div class="form-group">
                            <input type="submit" class="btn btn-white px-5 py-2" value="Add Image">
                        </div>
                    </form>

                </div>
            </div>

        </div>
    </div>

    <div class="container mt-5" id="manage">
        <h2>Manage Gallery</h2>
        <div class="row">
            <?php foreach (getImagesFromDB() as $image) : ?>
                <div class="col-md-3 mb-4">
                    <div class="card">
                        <img src="<?php echo "./includes/gallery/" . $image['imgsrc']; ?>" class="card-img-top" alt="Image Placeholder">
                        <div class="card-body">
                            <form action="" method="post">
                                <input type="hidden" name="delete_id" value="<?php echo $image['id']; ?>">
                                <input type="hidden" name="filename" value="<?php echo $image['imgsrc']; ?>">
                                <button type="submit" class="btn btn-primary btn-sm">Delete</button>
                            </form>
                        </div>
                    </div>
                </div>
            <?php endforeach; ?>
        </div>
    </div>

</body>

</html>