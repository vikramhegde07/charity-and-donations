<?php
session_start();
include '../includes/config.php';
include './includes/functions.php';

$id = $_SESSION['aid'];

$sql = "SELECT * from admin where id = $id ";

$result = $conn->query($sql);

if ($_SERVER["REQUEST_METHOD"] == "POST") {

    if (isset($_POST['cancel'])) {
        header("Location: ./index.php");
    }
    if (isset($_POST['update'])) {
        $newEmail = $_POST['email'];
        $newUsername = $_POST['username'];

        if ($_POST['oldPassword'] == '' and $_POST['newPassword'] == '' and $_POST['confPassword'] == '') {
            $oldPass = $_POST['oldPassword'];
            $newPass = $_POST['newPassword'];
            $confPass = $_POST['confPassword'];

            $response = updateUser($id, $newEmail, $newUsername, $oldPass, $newPass, $confPass);
            if ($response['status'] === 'success') {
                // Redirect to profile page or display success message
                header('Location: profile.php?status=success');
                exit();
            } else {
                // Display error message
                echo "<p>Error: " . $response['message'] . "</p>";
            }
        } else {
        }
    }
}
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <style>
        #ftco-navbar {
            background: #fff !important;
        }

        .navbar a {
            color: #000 !important;
        }

        .navbar-toggler {
            color: #000 !important;
        }
    </style>
    <title>Profile</title>
</head>

<body>

    <?php include './includes/header.php'; ?>

    <div class="container" style="margin: 120px auto;">
        <div class="row">

            <div class="col-md-3"></div>

            <?php
            if ($result) :
                while ($admin = $result->fetch_assoc()) :
                    if ($admin['image'] == "")
                        $src = "../includes/images/default.webp";
                    else
                        $src = "../includes/" . $admin['image'];
            ?>
                    <div class="col-md-6">
                        <form action="" method="post">
                            <div class="person-donate text-center">

                                <div class="donate-info">
                                    <div class="form-group">
                                        <form id="profile-form" class="profile_form" action="../includes/uploadImage.php" method="POST" enctype="multipart/form-data">
                                            <img id="profile-img" src="<?php echo $src ?>" alt="Profile Photo" style="cursor:pointer;" />
                                            <input type="file" id="profile-photo-input" name="profile_photo" accept="image/*" style="display:none;" />
                                            <input type="hidden" name="user_id" value="<?php echo $id; ?>">
                                            <span class="time d-block mb-3" for="profile-photo-input">Change profile photo</span>
                                        </form>
                                    </div>
                                    <div class="form-group">
                                        <input type="text" class="form-control py-2" name="username" id="adminName" value="<?php echo $admin['adminName']; ?>" placeholder="Enter admin name">
                                    </div>
                                    <div class="form-group">
                                        <input type="email" class="form-control py-2" name="email" id="email" value="<?php echo $admin['email']; ?>" placeholder="Enter email">
                                    </div>
                                    <div class="form-group">
                                        <input type="password" class="form-control py-2" name="oldPassword" id="oldPassword" placeholder="Enter old password">
                                    </div>
                                    <div class="form-group">
                                        <input type="password" class="form-control py-2" name="newPassword" id="newPassword" placeholder="Enter new password">
                                    </div>
                                    <div class="form-group">
                                        <input type="password" class="form-control py-2" name="confPassword" id="confPassword" placeholder="Confirm new password">
                                    </div>
                                    <div class="form-group">
                                        <input type="submit" name="update" class="btn btn-white px-5 py-2" value="Update">
                                        <input type="submit" name="cancel" class="btn btn-black px-5 py-2" value="Cancel">
                                    </div>
                                </div>
                            </div>
                        </form>
                        <form action="../includes/logout.php">
                            <div class="form-group" style="display:flex;justify-content:center; align-items: center;">
                                <input type="submit" name="cancel" class="btn btn-primary px-5 py-2" value="Logout">
                            </div>
                        </form>
                    </div>

            <?php
                endwhile;
            endif;
            ?>

            <div class="col-md-3"></div>

        </div>
    </div>
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            console.log('DOM fully loaded and parsed');

            const profileForm = document.getElementById('profile-form');
            const profileImg = document.getElementById('profile-img');
            const profilePhotoInput = document.getElementById('profile-photo-input');

            if (!profileForm) {
                console.error('Form element not found');
            }

            if (!profileImg) {
                console.error('Profile image element not found');
            } else {
                profileImg.addEventListener('click', function() {
                    profilePhotoInput.click();
                });
            }



            if (!profilePhotoInput) {
                console.error('Profile photo input element not found');
            } else {
                profilePhotoInput.addEventListener('change', function() {
                    if (profilePhotoInput.files.length > 0) {
                        console.log('File selected:', profilePhotoInput.files[0]);
                        uploadProfilePhoto(profilePhotoInput.files[0]);
                    }
                });
            }

            function uploadProfilePhoto(file) {
                const formData = new FormData();
                formData.append('profile_photo', file);

                const xhr = new XMLHttpRequest();
                xhr.open('POST', '../includes/uploadImage.php', true);

                xhr.onload = function() {
                    if (xhr.status === 200) {
                        console.log('Upload successful');
                        // Optionally, update the profile image source with the new image
                        document.getElementById('profile-img').src = URL.createObjectURL(file);
                    } else {
                        console.error('Upload failed');
                    }
                };

                xhr.onerror = function() {
                    console.error('Request failed');
                };

                xhr.send(formData);
            }
        });
    </script>
</body>

</html>