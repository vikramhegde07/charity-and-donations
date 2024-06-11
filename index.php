<?php

include './includes/config.php';

$sql = "SELECT * from campaigns where status = 'active' LIMIT 5";
$result = $conn->query($sql);
if ($result === false) {
  die("Error in query: " . $conn->error);
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
  <title>GiveHope</title>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
</head>

<body>

  <?php include './includes/header.php'; ?>

  <!--background displayed-->
  <div class="block-31" style="position: relative;">
    <div class="owl-carousel loop-block-31 ">
      <div class="block-30 block-30-sm item" style="background-image: url('./includes/images/background2.jpg');" data-stellar-background-ratio="0.5">
        <div class="container">
          <div class="row align-items-center justify-content-center text-center">
            <div class="col-md-7">
              <h2 class="heading mb-5">Give Hope <br> Make a change</h2>
              <p style="display: inline-block;"><a href="#" data-fancybox class="ftco-play-video d-flex"><span class="play-icon-wrap align-self-center mr-4"><span class="ion-ios-play"></span></span> <span class="align-self-center">Watch Video</span></a></p>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>


  <!-- who are we -->
  <div class="site-section section-counter">
    <div class="container">
      <div class="row">
        <div class="col-md-6 pr-5">
          <div class="block-48">
            <span class="block-48-text-1">Served Over</span>
            <div class="block-48-counter ftco-number" data-number="17301">0</div>
            <span class="block-48-text-1 mb-4 d-block">Children in 15 Countries</span>
            <p class="mb-0"><a href="#" class="btn btn-white px-3 py-2">View Our Program</a></p>
          </div>
        </div>
        <div class="col-md-6 welcome-text">
          <h2 class="display-4 mb-3">Who Are We?</h2>
          <p class="lead" style="text-align: justify;">At Give Hope, we are dedicated to fostering meaningful connections between donors and charitable organizations. Our platform empowers users to discover, support, and engage with a diverse range of causes, making a positive impact on communities worldwide. With a user-friendly interface and transparent donation processes, we strive to facilitate seamless interactions, ensuring every contribution counts towards creating a brighter future for those in need. Join us in our mission to spread compassion, generosity, and hope through the power of giving.</p>
          <p class="mb-0"><a href="./about.php" class="btn btn-primary px-3 py-2">Learn More</a></p>
        </div>
      </div>
    </div>
  </div>


  <!-- our mission section -->
  <div class="site-section border-top">
    <div class="container">
      <div class="row">

        <div class="col-md-4">
          <div class="media block-6">
            <div class="icon"><span class="ion-ios-bulb"></span></div>
            <div class="media-body">
              <h3 class="heading">Our Mission</h3>
              <p style="text-align: justify;">Our mission at Give Hope is to bridge the gap between compassion and action. Through our platform, we aim to empower individuals to make meaningful contributions to charitable causes, fostering a culture of giving that enriches lives and creates positive change in the world.</p>
              <p><a href="./about.php" class="link-underline">Learn More</a></p>
            </div>
          </div>
        </div>

        <div class="col-md-4">
          <div class="media block-6">
            <div class="icon"><span class="ion-ios-cash"></span></div>
            <div class="media-body">
              <h3 class="heading">Make Donations</h3>
              <p style="text-align: justify;">Giving back has never been easier. With just a few clicks, you can support causes close to your heart and make a tangible difference in the lives of others. Join us in spreading kindness and transforming lives through the power of donation.</p>
              <p><a href="#" class="link-underline">Learn More</a></p>
            </div>
          </div>
        </div>

        <div class="col-md-4">
          <div class="media block-6">
            <div class="icon"><span class="ion-ios-contacts"></span></div>
            <div class="media-body">
              <h3 class="heading">We Need Volunteers</h3>
              <p style="text-align: justify;">we invite you to lend your time and skills to causes that matter. Whether it's mentoring, fundraising, or hands-on assistance, your contribution can make a significant impact. Join us in building stronger communities and creating lasting change through volunteerism.</p>
              <p><a href="#" class="link-underline">Learn More</a></p>
            </div>
          </div>
        </div>

      </div>
    </div>
  </div>



  <!-- Latest campains section -->

  <div class="site-section fund-raisers bg-light">

    <div class="container">
      <div class="row mb-3 justify-content-center">
        <div class="col-md-8 text-center">
          <h2>Latest Campaigns</h2>
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
                <a href="./campaign_single?id=<?php echo $campaign['id']; ?>"><img class="card-img-top" src="./admin/includes/gallery/campaign/<?php echo $campaign['img']; ?>" alt="Image placeholder"></a>
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
                  <span class="fund-raised d-block"><?php echo "₹" . $campaign['raised_amount'] . " raised of " . "₹" . $campaign['target_amount']; ?></span>
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
  <!-- Latest campains section -->


  <!-- Latest Donations section -->

  <?php
  $sql = "SELECT users.image as image, users.username as username, donation.amount as amount, donation.donation_date as d_date, campaigns.title as title,campaigns.id as cam_id from donation join users on users.id = donation.user_id join campaigns on campaigns.id = donation.campaign_id ORDER BY donation.donation_date DESC  limit 4;";
  $result = $conn->query($sql);
  ?>

  <div class="site-section fund-raisers">
    <div class="container">
      <div class="row mb-3 justify-content-center">
        <div class="col-md-8 text-center">
          <h2>Latest Donations</h2>
        </div>
      </div>

      <div class="row">
        <?php
        if ($result) :
          while ($data = $result->fetch_assoc()) :
        ?>
            <div class="col-md-6 col-lg-3 mb-5">
              <div class="person-donate text-center">
                <?php if ($data['image'] == "")
                  $imgsrc = "./includes/images/default.webp";
                else
                  $imgsrc = "./includes/" . $data['image'];
                ?>
                <img src="<?php echo $imgsrc ?>" alt="Image placeholder" class="img-fluid">
                <div class="donate-info">
                  <h2><?php echo $data['username']; ?></h2>
                  <span class="time d-block mb-3">
                    <?php

                    $diff = strtotime(date("y-m-d")) - strtotime($data['d_date']);

                    // 1 day = 24 hours 
                    // 24 * 60 * 60 = 86400 seconds 
                    $lastDonation =  abs(round($diff / 86400));
                    echo "Donated " . $lastDonation . " days ago";
                    ?>
                  </span>
                  <p>Donated <span class="text-success"><?php echo "₹" . $data['amount']; ?></span> <br> <em>for</em> <a href="./campaign_single.php?id=<?php echo $data['cam_id']; ?>" class="link-underline fundraise-item"><?php echo $data['title']; ?></a></p>
                </div>
              </div>
            </div>
        <?php
          endwhile;
        endif;
        ?>
      </div>

    </div>
  </div>
  <!-- Latest Donations section -->


  <!-- success stories section  -->
  <div class="featured-section overlay-color-2" style="background-image: url('./includes/images/bg_3.jpg');">

    <div class="container">
      <div class="row">

        <?php
        $sql = "SELECT * from campaigns where status = 'inactive' ORDER BY end_date ASC LIMIT 1";
        $res = $conn->query($sql);
        if ($res) :
          while ($story = $res->fetch_assoc()) :
        ?>

            <div class="col-md-6">
              <img src="./admin/includes/gallery/campaign/<?php echo $story['img']; ?>" alt="Image placeholder" class="img-fluid">
            </div>

            <div class="col-md-6 pl-md-5">
              <span class="featured-text d-block mb-3">Success Stories</span>
              <h2><?php echo $story['title']; ?></h2>
              <p class="mb-3"><?php echo $story['description']; ?></p>
              <span class="fund-raised d-block mb-5">We have raised ₹<?php echo $story['raised_amount']; ?></span>
            </div>
        <?php
          endwhile;
        endif;
        ?>

      </div>
    </div>

  </div>
  <!-- success stories section  -->


  <?php include './includes/footer.php'; ?>

  <!-- loader -->
  <div id="ftco-loader" class="show fullscreen"><svg class="circular" width="48px" height="48px">
      <circle class="path-bg" cx="24" cy="24" r="22" fill="none" stroke-width="4" stroke="#eeeeee" />
      <circle class="path" cx="24" cy="24" r="22" fill="none" stroke-width="4" stroke-miterlimit="10" stroke="#F96D00" />
    </svg></div>


</body>

</html>