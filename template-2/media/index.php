<?php 


require('../../conf/config.php');
require('../../conf/phpFunction.php');

$queryProfile    = $mysqli->query('SELECT * FROM pub_profile');
$profileData     = $queryProfile->fetch_all(MYSQLI_ASSOC);


?>


<!doctype html>
<html lang="en">
<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
  <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@100;200;300;400;500;600;700;800;900&display=swap" rel="stylesheet">
  <link rel="shortcut icon" href="images/profile/<?= $profileData[0]['prof_lg']?>">

  <title><?= $profileData[0]['prof_lnm'];?></title>

  <!-- Bootstrap core CSS -->
  <link href="../vendor/bootstrap/css/bootstrap.min.css" rel="stylesheet">

  <!-- Additional CSS Files -->
  <link rel="stylesheet" href="../assets/css/fontawesome.css">
  <link rel="stylesheet" href="../assets/css/style.css">
  <link rel="stylesheet" href="../assets/css/owl.css">
  <link rel="stylesheet" href="../assets/css/animate.css">
  <link rel="stylesheet" href="../assets/css/jquery.fancybox.min.css">

</head>
<body>


  <?php 
    include_once('../views/counter.php');
  ?>



  <!-- ======= Header ======= -->
  <?php 
  
    include_once('../views/navbar.php')
  
  ?>
  <!-- End Header -->

  <div class="hero overlay inner-page" style="  background-image: url('../../images/video-bg.png');">
    <div class="container">
      <div class="row align-items-center justify-content-center text-center pt-5">
        <div class="col-lg-8">
          <h1 class="heading text-white mb-3" data-aos="fade-up" data-aos-delay="100">Media Digital</h1>
        </div>
      </div>
    </div>
  </div>

  <div class="py-5">
    <div class="container">
      <div class="row detail-gallery">
        <div class="col-lg-9">
          <div class="row">
          <?php
            require_once('../../conf/config.php');

            $page = (isset($_GET['page']))? $_GET['page'] : 1;
            $limit = 6; 
            $limit_start = ($page - 1) * $limit;
            $no = $limit_start + 1;

            $query = "SELECT * FROM pub_socials WHERE cat=003 AND _active=1 ORDER BY _cre DESC LIMIT $limit_start, $limit";
            $video = $mysqli->prepare($query);
            $video->execute();
            $res1 = $video->get_result();

            while ($row = $res1->fetch_assoc()) {
              $id = $row['sos_id'];
              $url = $row['sos_url'];
              $queryString = parse_url($url, PHP_URL_QUERY);
              parse_str($queryString, $params);
              $videoId = $params['v'];
            ?>

            <div class="col-lg-6 col-12 mb-4">
              <a href=" <?= $url?>" data-fancybox class="video-wrap">
                <span class="play-wrap"><i class="fa-solid fa-play"></i></span>
                <img src="https://img.youtube.com/vi/<?= $videoId?>/hqdefault.jpg" class="video-cover rounded"/>
              </a>
            </div>

          <?php } ?>

          </div>

          <?php
            $countVid = "SELECT count(*) AS jumlah FROM pub_socials WHERE _active=1 AND cat=003";
            $video = $mysqli->prepare($countVid);
            $video->execute();
            $res1 = $video->get_result();
            $row = $res1->fetch_assoc();
            $total_records = $row['jumlah'];
          ?>

          <div class="row justify-content-start pt-5">
            <div class="col-md-12">
              <nav class="my-5">
                <ul class="pagination justify-content-center">
                  <?php
                    $jumlah_page = ceil($total_records / $limit);
                    $jumlah_number = 2;
                    $start_number = ($page > $jumlah_number)? $page - $jumlah_number : 1;
                    $end_number = ($page < ($jumlah_page - $jumlah_number))? $page + $jumlah_number : $jumlah_page;
                    
                    if($page == 1){
                      echo '<li class="page-item disabled"><a class="page-link" href="#"><span aria-hidden="true">&laquo;</span></a></li>';
                    } else {
                      $link_prev = ($page > 1)? $page - 1 : 1;
                      echo '<li class="page-item"><a class="page-link" href="halaman-'.$link_prev.'" aria-label="Previous"><span aria-hidden="true">&laquo;</span></a></li>';
                    }


                    for($i = $start_number; $i <= $end_number; $i++){
                      $link_active = ($page == $i)? ' active' : '';
                      echo '<li class="page-item '.$link_active.'"><a class="page-link" href="halaman-'.$i.'">'.$i.'</a></li>';
                    }
                    
                    if($page == $jumlah_page){
                      echo '<li class="page-item disabled"><a class="page-link" href="#"><span aria-hidden="true">&raquo;</span></a></li>';
                    } else {
                      $link_next = ($page < $jumlah_page)? $page + 1 : $jumlah_page;
                      echo '<li class="page-item"><a class="page-link" href="halaman-'.$link_next.'" aria-label="Next"><span aria-hidden="true">&raquo;</span></a></li>';
                    }
                  ?>
                </ul>
              </nav>
            </div>
          </div>

        </div>
        <div class="col-lg-3 mt-lg-0 mt-5">
          <?php include_once('../views/side.php')?>
        </div>
      </div>
    </div>
  </div>

    <!-- footer start -->


    <?php 
    
    include_once('../views/footer.php')
    
    
    ?>


    <!-- footer end -->


  <!-- Scripts -->
  <!-- Bootstrap core JavaScript -->
  <script src="../vendor/jquery/jquery.min.js"></script>
  <script src="../vendor/bootstrap/js/bootstrap.min.js"></script>
  <script src="../assets/js/isotope.min.js"></script>
  <script src="../assets/js/owl-carousel.js"></script>
  <script src="../assets/js/counter.js"></script>
  <script src="../assets/js/jquery.fancybox.min.js"></script>
  <script src="../assets/js/custom.js"></script>


  <script>

    function search(){
      let textToSearch = document.getElementById("text-to-search").value;
      let paragraph = document.getElementById("blog-content");
      textToSearch = textToSearch.replace(/[.*+?^${}()|[\]\\]/g,"\\$&");

      let pattern = new RegExp(`${textToSearch}`,"gi");

      paragraph.innerHTML = paragraph.textContent.replace(pattern, match => `<mark>${match}</mark>`)
    }



  </script>





  </body>
</html>
