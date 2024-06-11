<?php

include './includes/config.php';
$loginError = "";

if ($_SERVER['REQUEST_METHOD'] == "POST") {

    if (isset($_POST['volunteer_login'])) {
        $email = $_POST['email'];
        $password = $_POST['password'];

        $sql = "select id,password from users where email = ?";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param('s', $email);
        $stmt->execute();
        $stmt->store_result();
        $stmt->bind_result($uid, $hashed_password);
        $stmt->fetch();

        if ($stmt->num_rows > 0) {
            if (password_verify($password, $hashed_password)) {
                $_SESSION['uid'] = $uid;
                header("Location: ./index.php");
            } else {
                $loginError = "Invalid password.";
            }
        } else {
            $loginError = "No user found with that username.";
        }
    } elseif (isset($_POST['admin_login'])) {

        $email = $_POST['email'];
        $password = $_POST['password'];

        $sql = "select id,password from admin where email = ?";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param('s', $email);
        $stmt->execute();
        $stmt->store_result();
        $stmt->bind_result($aid, $hashed_password);
        $stmt->fetch();

        if ($stmt->num_rows > 0) {
            if (password_verify($password, $hashed_password)) {
                $_SESSION['aid'] = $aid;
                if ($_SESSION['uid'] != "") $_SESSION['uid'] = "";
                header("Location: ./admin/index.php");
            } else {
                $loginError = "Invalid password.";
            }
        } else {
            $loginError = "No user found with that username.";
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

        .ftco-navbar-light .navbar-toggler {
            color: #000 !important;
        }

        .form-control {
            border: 2px solid #000 !important;
        }

        .featured-section h2 {
            color: #000 !important;
        }
    </style>
    <title>Accounts</title>
</head>

<body>

    <?php include './includes/header.php'; ?>

    <div class="featured-section overlay-color-2" style="background-image: url('./includes/images/about_bg.jpg');min-height: 100vh;">

        <div class="container" style="margin-top: 10%;">
            <div class="row">

                <div class="col-md-4">
                    <div class="form-volunteer">
                        <h2>Volunteer Login</h2>
                        <form action="" method="post">
                            <div class="form-group">
                                <!-- <label for="name">Name</label> -->
                                <input type="email" class="form-control py-2" id="email" name="email" placeholder="Enter your email" style="color: #000 !important;">
                            </div>
                            <div class="form-group">
                                <!-- <label for="email">Email</label> -->
                                <input type="password" class="form-control py-2" id="password" name="password" placeholder="Enter your password" style="color: #000 !important;">
                            </div>

                            <div class="form-group">
                                <input type="submit" name="volunteer_login" class="btn btn-white px-5 py-2" value="Login">
                            </div>
                        </form>
                    </div>
                </div>

                <div class="col-md-4">
                    <div class="form-volunteer">
                        <h2>Volunteer Register</h2>
                        <form action="./register.php" method="post">
                            <div class="form-group">
                                <!-- <label for="name">Name</label> -->
                                <input type="text" class="form-control py-2" id="username" name="username" placeholder="Enter your name" style="color: #000 !important;">
                            </div>
                            <div class="form-group">
                                <!-- <label for="name">Name</label> -->
                                <input type="email" class="form-control py-2" id="email" name="email" placeholder="Enter your email" style="color: #000 !important;">
                            </div>
                            <div class="form-group">
                                <!-- <label for="email">Email</label> -->
                                <input type="password" class="form-control py-2" id="password" name="password" placeholder="Enter new password" style="color: #000 !important;">
                            </div>
                            <div class="form-group">
                                <!-- <label for="email">Email</label> -->
                                <input type="password" class="form-control py-2" id="password" name="confPassword" placeholder="Confirm new password" style="color: #000 !important;">
                            </div>
                            <div class="form-group">
                                <input type="submit" class="btn btn-white px-5 py-2" value="Register">
                            </div>
                        </form>
                    </div>
                </div>

                <div class="col-md-4">
                    <div class="form-volunteer">
                        <h2>Admin Login</h2>
                        <form action="" method="post">
                            <div class="form-group">
                                <!-- <label for="name">Name</label> -->
                                <input type="email" class="form-control py-2" id="email" name="email" placeholder="Enter your email" style="color: #000 !important;">
                            </div>
                            <div class="form-group">
                                <!-- <label for="email">Email</label> -->
                                <input type="password" class="form-control py-2" id="password" name="password" placeholder="Enter your password" style="color: #000 !important;">
                            </div>
                            <?php if ($loginError != "") echo $loginError; ?>
                            <div class="form-group">
                                <input type="submit" name="admin_login" class="btn btn-white px-5 py-2" value="Login">
                            </div>
                        </form>
                    </div>
                </div>

            </div>
        </div>

    </div>
    <?php include './includes/footer.php'; ?>
</body>

</html>