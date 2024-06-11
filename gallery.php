<?php

include './includes/config.php';

$sql = "SELECT * from gallery;";

$result = $conn->query($sql);

?>

<!DOCTYPE html>
<html lang="en">

<head>
  <title>GiveHope &mdash; Website Template by Colorlib</title>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
</head>

<body>

  <?php include './includes/header.php'; ?>

  <div class="block-31" style="position: relative;">
    <div class="owl-carousel loop-block-31 ">
      <div class="block-30 block-30-sm item" style="background-image: url('./includes/images/background1.jpg');" data-stellar-background-ratio="0.5">
        <div class="container">
          <div class="row align-items-center justify-content-center text-center">
            <div class="col-md-7">
              <h2 class="heading">Our Gallery</h2>
            </div>
          </div>
        </div>
      </div>

    </div>
  </div>

  <div class="site-section">
    <div class="container">
      <div class="row">

        <?php
        if ($result) :
          while ($row = $result->fetch_assoc()) :
        ?>
            <div class="col-md-4">
              <a href="./admin/includes/gallery/<?php echo $row['imgsrc'] ?>" class="img-hover" data-fancybox="gallery">
                <span class="icon icon-search"></span>
                <img src="./admin/includes/gallery/<?php echo $row['imgsrc'] ?>" alt="Image placeholder" class="img-fluid">
              </a>
            </div>
        <?php
          endwhile;
        endif;
        ?>
      </div>
    </div>
  </div>


  <?php include './includes/footer.php'; ?>
</body>

</html>