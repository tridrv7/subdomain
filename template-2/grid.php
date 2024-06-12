<?php 


require('../conf/config.php');
require('../conf/phpFunction.php');

$queryProfile    = $mysqli->query('SELECT * FROM pub_profile');
$profileData     = $queryProfile->fetch_all(MYSQLI_ASSOC);


$kategori = $_GET['kategori'];


$getCategory  = $mysqli->query("SELECT ca_nm FROM set_category  WHERE ca_id = $kategori");
$category     = $getCategory->fetch_assoc();



?>


<!doctype html>
<html lang="en">
<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
  <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@100;200;300;400;500;600;700;800;900&display=swap" rel="stylesheet">
  <link rel="shortcut icon" href="../images/profile/<?= $profileData[0]['prof_lg']?>">

  <title><?= $profileData[0]['prof_lnm'];?></title>

  <!-- Bootstrap core CSS -->
  <link href="../vendor/bootstrap/css/bootstrap.min.css" rel="stylesheet">

  <!-- Additional CSS Files -->
  <link rel="stylesheet" href="../assets/css/fontawesome.css">
  <link rel="stylesheet" href="../assets/css/style.css">
  <link rel="stylesheet" href="../assets/css/owl.css">
  <link rel="stylesheet" href="../assets/css/animate.css">
  <link rel="stylesheet" href="../assets/css/jquery.fancybox.min.css">
  <link rel="stylesheet"href="https://unpkg.com/swiper@7/swiper-bundle.min.css"/>


</head>
<body>


  <?php 
    include_once('views/counter.php');
    include_once('views/social.php');
  ?>



  <!-- ======= Header ======= -->
  <?php 
  
    include_once('views/navbar.php')
  
  ?>
  <!-- End Header -->

  <div class="hero-grid overlay inner-page">
    <div class="container">
      <div class="row align-items-center justify-content-center text-center pt-5">
        <div class="col-lg-8">
          <h1 class="heading text-white mb-3" data-aos="fade-up" data-aos-delay="100"><?= $category['ca_nm']?></h1>
        </div>
      </div>
    </div>
  </div>

  <div class="py-5">
    <div class="container">
      <div class="row posts-entry">
        <div class="col-lg-8">

          <?php

          $page = (isset($_GET['page']))? $_GET['page'] : 1;
          $limit = 6; 
          $limit_start = ($page - 1) * $limit;
          $no = $limit_start + 1;

          $query = "SELECT * FROM pub_post WHERE ca_id=$kategori AND _active=1 ORDER BY post_publish DESC LIMIT $limit_start, $limit";
          $video = $mysqli->prepare($query);
          $video->execute();
          $res1 = $video->get_result();

          while ($row = $res1->fetch_assoc()) {
            $id 		= $row['post_id'];
            $title 	    = $row['post_judul'];
            $desk 	    = $row['post_desk'];
            $date 	    = $row['post_publish'];
            $count 	    = $row['post_see'];
            $image 	    = $row['post_img'];
            


            // VARIABEL NEED OPERATION



            // DEFAULT IMAGE
            
            
                        
            if(!empty($image)){
				$image = '../'.$_dirPost . $row['post_img'];
			} else {
				$image = '../'.$_dirPost . 'default-template-2.png';
			}



            // CUT DESCRIPTION WHERE MAX LEGHT > 100

            $deskToStr = strip_tags($desk);

            if (strlen($deskToStr) > 100) {
              $deskToStr = substrwords($deskToStr, 100);
            }


            // CUT TITLE WHERE MAX LEGHT > 70

            // $deskToStr = strip_tags($desk);

            // if (strlen($deskToStr) <= 100) {
            //   $deskToDisplay = substrwords($title, 70);
            // };

          ?>


          <div class="blog-entry mb-5" id="blog-content">
            <div class="row justify-content-start align-items-start">
              <div class="col-lg-5 mb-lg-0 mb-4">
                <a href="<?= $id?>" class="img-link me-4">
                  <img src="<?= $image?>" alt="Image" class="img-fluid rounded">
                </a>
              </div>
              <div class="col-lg-6">
                <h2><a href="<?= $id?>"><?=$title ?></a></h2>
                <p><?= $deskToStr?></p>
                <p><a href="<?= $id?>" class="btn btn-sm btn-outline-primary read-more rounded-pill px-3">Baca selengkapnya</a></p>
              </div>
            </div>
          </div>

          <?php } ?>


          <?php
            $countVid = "SELECT count(*) AS jumlah FROM pub_post WHERE ca_id=$kategori AND _active=1";
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
        <div class="col-lg-4 mt-lg-0 mt-5">
          <?php include_once('views/side.php')?>
        </div>
      </div>
    </div>
  </div>

    <!-- footer start -->


    <?php 
    
    include_once('views/footer.php')
    
    
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
