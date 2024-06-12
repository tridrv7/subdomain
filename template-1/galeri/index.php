<?php 

  require('../../conf/config.php');
  require('../../conf/phpFunction.php');

  $profile =  $mysqli->query('SELECT * from pub_profile WHERE _active=1 ORDER BY _cre DESC');
  $prof = $profile->fetch_all(MYSQLI_ASSOC);
  
  if (!empty($row['post_img'] && file_exists($dir_image) )) {
    $src = 'images/profile/'.$prof[0]['prof_lg'];
  } else {
    $src = 'images/profile/default.png';
  }

?>



<!doctype html>
<html lang="en">
<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
  <meta name="author" content="Untree.co">
  <link rel="shortcut icon" href="../<?= $src?>">

  <meta name="description" content="" />
  <meta name="keywords" content="" />

  <link rel="preconnect" href="https://fonts.googleapis.com">
  <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
  <link href="https://fonts.googleapis.com/css2?family=Work+Sans:wght@400;500;600;700&display=swap" rel="stylesheet">

  <link rel="stylesheet" href="../css/bootstrap.min.css">
  <link rel="stylesheet" href="../css/owl.carousel.min.css">
  <link rel="stylesheet" href="../css/owl.theme.default.min.css">
  <link rel="stylesheet" href="../css/jquery.fancybox.min.css">
  <link rel="stylesheet" href="../fonts/icomoon/style.css">
  <link rel="stylesheet" href="../fonts/flaticon/font/flaticon.css">
  <link rel="stylesheet" href="../css/aos.css">
  <link rel="stylesheet" href="../css/style.css">

  <title><?= $prof[0]['prof_lnm']?></title>
</head>

<body data-spy="scroll" data-target=".site-navbar-target" data-offset="100">


  <?php 
    require_once('../views/navbar.php');
    require_once('../views/social.php');
  ?>






  <div class="untree_co-hero mb-0" id="home-section">
    <div class="container">
      <div class="row">
        <div class="col-12">
          <div class="dots"></div>
          <div class="row justify-content-center">
            <div class="col-md-7 text-center">
              <h1 class="heading" data-aos="fade-up" data-aos-delay="0">Galeri Kegiatan</h1>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>

  <div class="container" data-aos="fade-up" data-aos-delay="100">
    <div class="row gutter-2 gallery justify-content-start align-items-center">
    <?php

      $page = (isset($_GET['page']))? $_GET['page'] : 1;
      $limit = 9; 
      $limit_start = ($page - 1) * $limit;
      $no = $limit_start + 1;

      $query = "SELECT * FROM pub_banner WHERE ban_stat=002 AND _active=1 ORDER BY _cre_date DESC LIMIT $limit_start, $limit";
      $video = $mysqli->prepare($query);
      $video->execute();
      $res1 = $video->get_result();

      while ($row = $res1->fetch_assoc()) {
				$title = $row['ban_title'];
				$image = '../images/galery/'.$row['ban_img'];
      ?>

      <div class="col-lg-4 col-12">
        <a href="<?= $image?>" class="gal-item mb-4" data-fancybox="gal" data-caption="<?= $title?>"><img src="<?= $image?>" alt="Image" class="img-fluid"></a>
      </div>

      <?php } ?>

    </div>
  </div>


  <?php
    $countVid = "SELECT count(*) AS jumlah FROM pub_banner WHERE ban_stat=002 AND _active=1";
    $video = $mysqli->prepare($countVid);
    $video->execute();
    $res1 = $video->get_result();
    $row = $res1->fetch_assoc();
    $total_records = $row['jumlah'];
  ?>

  <nav class="my-5">
    <ul class="pagination justify-content-center">
      <?php
        $jumlah_page = ceil($total_records / $limit);
        $jumlah_number = 2;
        $start_number = ($page > $jumlah_number)? $page - $jumlah_number : 1;
        $end_number = ($page < ($jumlah_page - $jumlah_number))? $page + $jumlah_number : $jumlah_page;
        
        if($page == 1){
          echo '<li class="page-item disabled"><a class="page-link" href="#">First</a></li>';
          echo '<li class="page-item disabled"><a class="page-link" href="#"><span aria-hidden="true">&laquo;</span></a></li>';
        } else {
          $link_prev = ($page > 1)? $page - 1 : 1;
          echo '<li class="page-item"><a class="page-link" href="?page=1">First</a></li>';
          echo '<li class="page-item"><a class="page-link" href="?page='.$link_prev.'" aria-label="Previous"><span aria-hidden="true">&laquo;</span></a></li>';
        }


        for($i = $start_number; $i <= $end_number; $i++){
          $link_active = ($page == $i)? ' active' : '';
          echo '<li class="page-item '.$link_active.'"><a class="page-link" href="?page='.$i.'">'.$i.'</a></li>';
        }
        
        if($page == $jumlah_page){
          echo '<li class="page-item disabled"><a class="page-link" href="#"><span aria-hidden="true">&raquo;</span></a></li>';
          echo '<li class="page-item disabled"><a class="page-link" href="#">Last</a></li>';
        } else {
          $link_next = ($page < $jumlah_page)? $page + 1 : $jumlah_page;
          echo '<li class="page-item"><a class="page-link" href="?page='.$link_next.'" aria-label="Next"><span aria-hidden="true">&raquo;</span></a></li>';
          echo '<li class="page-item"><a class="page-link" href="?page='.$jumlah_page.'">Last</a></li>';
        }
      ?>
    </ul>
  </nav>



  <?php require_once('../views/footer.php')?>

  

  <div id="overlayer"></div>
  <div class="loader">
    <div class="spinner-border" role="status">
      <span class="sr-only">Loading...</span>
    </div>
  </div>

  <script src="../js/jquery-3.4.1.min.js"></script>
  <script src="../js/jquery-migrate-3.0.1.min.js"></script>
  <script src="../js/popper.min.js"></script>
  <script src="../js/bootstrap.min.js"></script>
  <script src="../js/owl.carousel.min.js"></script>
  <script src="../js/jquery.easing.1.3.js"></script>
  <script src="../js/jquery.animateNumber.min.js"></script>
  <script src="../js/jquery.waypoints.min.js"></script>
  <script src="../js/jquery.fancybox.min.js"></script>
  <script src="../js/aos.js"></script>
  
  <script src="../js/custom.js"></script>
  
</body>

</html>