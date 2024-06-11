<?php

include './includes/config.php';

$sql = "SELECT * from campaigns where status = 'active'";
$result = $conn->query($sql);
if ($result === false) {
    die("Error in query: " . $conn->error);
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Campaigns</title>
</head>

<body>

    <?php include './includes/header.php'; ?>

    <div class="block-31" style="position: relative;">
        <div class="owl-carousel loop-block-31 ">
            <div class="block-30 block-30-sm item" style="background-image: url('./includes/images/background1.jpg');" data-stellar-background-ratio="0.5">
                <div class="container">
                    <div class="row align-items-center justify-content-center text-center">
                        <div class="col-md-7">
                            <h2 class="heading mb-5">Give Hope <br> Make a change</h2>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>


    <div class="site-section fund-raisers bg-light">

        <div class="container">
            <div class="row mb-3 justify-content-center">
                <div class="col-md-8 text-center">
                    <h2>Our Campaigns</h2>
                </div>
            </div>
        </div>

        <div class="container-fluid">
            <div class="col-md-12 block-11">
                <div class="nonloop-block-13 owl-carousel">

                    <?php
                    if ($result->num_rows > 0) :
                        while ($campaign = mysqli_fetch_assoc($result)) :
                            $campaign_id = $campaign['id'];
                    ?>
                            <div class="card fundraise-item">
                                <a href="./campaign_single.php?id=<?php echo $campaign['id']; ?>"><img class="card-img-top" src="./admin/includes/gallery/campaign/<?php echo $campaign['img']; ?>" alt="Image placeholder"></a>
                                <div class="card-body">
                                    <h3 class="card-title"><a href="./campaign_single.php?id=<?php echo $campaign['id']; ?>"><?php echo $campaign['title']; ?></a></h3>
                                    <p class="card-text">
                                        <?php
                                        $des = substr($campaign['description'], 0, 100);
                                        echo $des;
                                        ?>
                                    </p>
                                    <span class="donation-time mb-3 d-block">
                                        <?php

                                        $sql2 = "SELECT donation_date from donation where campaign_id = $campaign_id ORDER BY donation_date DESC LIMIT 1; ";
                                        $res2 = $conn->query($sql2);
                                        if ($res2) {
                                            while ($dat = $res2->fetch_assoc())

                                                $diff = strtotime(date("y-m-d")) - strtotime($dat['donation_date']);

                                            // 1 day = 24 hours 
                                            // 24 * 60 * 60 = 86400 seconds 
                                            $lastDonation =  abs(round($diff / 86400));
                                            echo "Donated " . $lastDonation . " days ago";
                                        }
                                        ?>
                                    </span>
                                    <div class="progress custom-progress-success">
                                        <?php $width = ($campaign['raised_amount'] * 100) / $campaign['target_amount']; ?>
                                        <div class="progress-bar bg-primary" role="progressbar" style="width: <?php echo $width; ?>%" aria-valuenow="<?php echo $width ?>" aria-valuemin="0" aria-valuemax="100"></div>
                                    </div>
                                    <span class="fund-raised d-block"><?php echo "₹" . $campaign['raised_amount'] . "  raised of  " . "₹" . $campaign['target_amount']; ?></span>
                                </div>
                            </div>
                    <?php
                        endwhile;
                    endif;
                    ?>

                </div>
            </div>
        </div>

    </div>
    <?php include './includes/footer.php'; ?>
</body>

</html>