<?php

if (isset($_SESSION['uid']))
    $url = "login.php";
else
    $url = "profile.php";

?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://fonts.googleapis.com/css?family=Overpass:300,400,500|Dosis:400,700" rel="stylesheet">
    <link rel="stylesheet" href="../includes/css/open-iconic-bootstrap.min.css">
    <link rel="stylesheet" href="../includes/css/animate.css">
    <link rel="stylesheet" href="../includes/css/owl.carousel.min.css">
    <link rel="stylesheet" href="../includes/css/owl.theme.default.min.css">
    <link rel="stylesheet" href="../includes/css/magnific-popup.css">
    <link rel="stylesheet" href="../includes/css/aos.css">
    <link rel="stylesheet" href="../includes/css/ionicons.min.css">
    <link rel="stylesheet" href="../includes/css/bootstrap-datepicker.css">
    <link rel="stylesheet" href="../includes/css/jquery.timepicker.css">
    <link rel="stylesheet" href="../includes/css/flaticon.css">
    <link rel="stylesheet" href="../includes/css/icomoon.css">
    <link rel="stylesheet" href="../includes/css/fancybox.min.css">
    <link rel="stylesheet" href="../includes/css/bootstrap.css">
    <link rel="stylesheet" href="../includes/css/style.css">
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
    <title>Document</title>
</head>

<body>

    <nav class="navbar navbar-expand-lg navbar-dark ftco_navbar bg-dark ftco-navbar-light" id="ftco-navbar">
        <div class="container">
            <a class="navbar-brand" href="./index.php">GiveHope</a>
            <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#ftco-nav" aria-controls="ftco-nav" aria-expanded="false" aria-label="Toggle navigation">
                <span class="oi oi-menu"></span> Menu
            </button>

            <div class="collapse navbar-collapse" id="ftco-nav">
                <ul class="navbar-nav ml-auto">
                    <li class="nav-item active"><a href="./index.php" class="nav-link">Dashboard</a></li>
                    <li class="nav-item"><a href="./manage_campaigns.php" class="nav-link">Manage Campains</a></li>
                    <li class="nav-item"><a href="./manage_gallery.php" class="nav-link">Manage Gallery</a></li>
                    <li class="nav-item"><a href="./manage_users.php" class="nav-link">Manage Volunteers</a></li>
                    <li class="nav-item"><a href="./manage_account.php" class="nav-link">Manage Account</a></li>
                    <li class="nav-item"><a href="./profile.php" class="nav-link">Profile</a></li>
                </ul>
            </div>
        </div>
    </nav>

    <script src="../includes/js/jquery.min.js"></script>
    <script src="../includes/js/jquery-migrate-3.0.1.min.js"></script>
    <script src="../includes/js/popper.min.js"></script>
    <script src="../includes/js/bootstrap.min.js"></script>
    <script src="../includes/js/jquery.easing.1.3.js"></script>
    <script src="../includes/js/jquery.waypoints.min.js"></script>
    <script src="../includes/js/jquery.stellar.min.js"></script>
    <script src="../includes/js/owl.carousel.min.js"></script>
    <script src="../includes/js/jquery.magnific-popup.min.js"></script>
    <script src="../includes/js/bootstrap-datepicker.js"></script>
    <script src="../includes/js/jquery.fancybox.min.js"></script>
    <script src="../includes/js/aos.js"></script>
    <script src="../includes/js/jquery.animateNumber.min.js"></script>
    <script src="https://maps.googleapis.com/maps/api/js?key=AIzaSyBVWaKrjvy3MaE7SQ74_uJiULgl1JY0H2s&sensor=false"></script>
    <script src="../includes/js/google-map.js"></script>
    <script src="../includes/js/main.js"></script>
</body>

</html>