<?php

include './includes/config.php';

$id = $_GET['id'];

$sql = "SELECT * from campaigns where id = $id";
$result = $conn->query($sql);

?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <style>
        #ftco-navbar {
            background: #fff !important;
            top: 0;
            padding: 0;
        }

        .navbar a {
            color: #000 !important;
        }

        .navbar-toggler {
            color: #000 !important;
        }
    </style>
    <title>Campaign</title>
</head>

<body>

    <?php include './includes/header.php'; ?>

    <div class="container" style="margin-top: 100px auto0;">
        <div class="row">

            <div class="col-md-2"></div>

            <div class="col-md-8">

                <?php
                if ($result) :
                    while ($campaign = $result->fetch_assoc()) :
                ?>
                        <div class="card fundraise-item">
                            <img class="card-img-top" src="./admin/includes/gallery/campaign/<?php echo $campaign['img']; ?>" alt="Image placeholder">
                            <div class="card-body">
                                <h3 class="card-title"><?php echo $campaign['title']; ?></h3>
                                <p class="card-text"><?php echo $campaign['description']; ?></p>
                                <span class="donation-time mb-3 d-block">
                                    <?php

                                    $sql2 = "SELECT donation_date from donation where campaign_id = $id ORDER BY donation_date DESC LIMIT 1; ";
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

                                <h3 class="card-title">Donate for the campaign</h3>
                                <form id="donationForm" method="post" action="./includes/donate.php">
                                    <div class="form-group">
                                        <input type="number" id="amount" name="amount" class="form-control" required>
                                    </div>
                                    <div class="form-group">
                                        <input type="hidden" id="campaign_id" name="campaign_id" class="form-control" value="<?php echo $id ?>">
                                    </div>
                                    <button type="button" id="payButton" class="btn btn-primary">Donate</button>
                                </form>
                            </div>
                        </div>
                <?php
                    endwhile;
                endif;
                ?>
            </div>
            <div class="col-md-2"></div>
        </div>

    </div>

    <?php include './includes/footer.php'; ?>

    <script>
        document.getElementById('payButton').onclick = function(e) {
            let campaign_id = document.getElementById('campaign_id').value;
            let amount = document.getElementById('amount').value;

            window.location.href = "./thanks.php";

            //     let options = {
            //         "key": "YOUR_RAZORPAY_KEY_ID", // Enter the Key ID generated from the Dashboard
            //         "amount": amount * 100, // Razorpay works with paise, hence amount is multiplied by 100
            //         "currency": "INR",
            //         "name": "Give Hope",
            //         "description": "Donation for Campaign ID: " + campaign_id,
            //         "handler": function(response) {
            //             // After payment is successful
            //             document.getElementById('donationForm').submit();
            //         },
            //         "prefill": {
            //             "email": "donor@example.com"
            //         },
            //         "theme": {
            //             "color": "#3399cc"
            //         }
            //     };
            //     let rzp1 = new Razorpay(options);
            //     rzp1.open();
            //     e.preventDefault();
        }
    </script>
</body>

</html>