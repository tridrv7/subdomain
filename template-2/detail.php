<?php 


require('../conf/config.php');
require('../conf/phpFunction.php');

$queryProfile    = $mysqli->query('SELECT * FROM pub_profile');
$profileData     = $queryProfile->fetch_all(MYSQLI_ASSOC);



$url = $_SERVER['REQUEST_URI'];

$getURL = explode('/', $url);
$categoryURL  = $getURL[2];
$firstUrl     = $getURL[1];


$post_id  = $_GET['post_id'];


$url_awal = "http://$_SERVER[HTTP_HOST]$_SERVER[REQUEST_URI]";




$getCategory  = $mysqli->query("SELECT ca_nm, ca_icon FROM set_category  WHERE ca_id = $categoryURL");
$category     = $getCategory->fetch_assoc();

$query    = $mysqli->query("SELECT * from pub_post WHERE ca_id=$categoryURL AND post_id=$post_id");
$result   = $query->fetch_assoc();

if (!$result) {
  header("Location: ../error.php");
  exit();
}


if (!empty($profileData[0]['prof_lg'])) {
    $src = '../images/profile/'.$prof[0]['prof_lg'];
} else {
    $src = '../../images/profile/default.png';
}



postSee($post_id);


$id 	  = $result['post_id'];
$title    = $result['post_judul'];
$desk 	  = $result['post_desk'];
$date 	  = $result['post_publish'];
$dateEnd  = $result['post_datex'];
$count 	  = $result['post_see'];
$image 	  = $result['post_img'];



// VARIABEL NEED OPERATION

if(!empty($image)){
	$image = '../'.$_dirPost . $result['post_img'];
} else {
	$image = '../'.$_dirPost . 'default-template-2.png';
}


?>


<!doctype html>
<html lang="en">
<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
  <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@100;200;300;400;500;600;700;800;900&display=swap" rel="stylesheet">
  <link rel="shortcut icon" href="<?= $src?>">

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

  <div class="hero overlay inner-page" style="background-image: url('<?=$image?>');">
    <div class="container ">
      <div class="row align-items-end justify-content-center text-center pt-5">
        <div class="col-lg-8 heading-area">
          <h1 class="heading mb-3" data-aos="fade-up" data-aos-delay="100"><?= $title ?></h1>
          <p data-aos="fade-up" class="meta">Diposting pada <?= dateToDay($date)?> | <?= $count?> kali dibaca</p>
        </div>
      </div>
    </div>
  </div>

  <div class="py-5">
    <div class="container article">
      <div class="row justify-content-center align-items-stretch">
        <article class="col-lg-9 px-lg-5 order-lg-2">
          <div class="post-content" id="post-content">

            <?php
              if ($categoryURL == "002") {
            ?>
            <div class="event-calendar mb-5">
              <p>📌 <?= dateToDMY($date)?> - <?= dateToDMY($dateEnd)?></p>
            </div>

            <?php
              }
            ?>

            <?= $desk?>
            <?php
              if ($categoryURL == "004") {
            ?>
            <div class="download mt-5">
              <table class="table">
                <thead>
                  <tr>
                    <th scope="col">Nama Dokumen</th>
                    <th scope="col">Download</th>
                    <th scope="col">Opsi</th>
                  </tr>
                </thead>
                <tbody>
                  <?php
                    $query = $mysqli->query("SELECT * FROM pub_files WHERE post_id=$post_id ORDER BY files_nm");
                    $news = $query->fetch_all(MYSQLI_ASSOC);
                    
                    foreach ($news as $row) {
                      $title  = $row['files_nm'];
                      $count  = $row['files_down'];


                      // VARIABEL NEED OPERATION

                       $parts = explode(".", $title);

                       if (count($parts) > 2 && is_numeric($parts[0])) {
                         $file_name = implode(".", array_slice($parts, 1));
                       } else {
                         $file_name = $title;
                       }
                      
                    ?>
                  <tr>
                    <td><?= $title?></td>
                    <td><?= $count?></td>
                    <td>
                      <a  href="#" data-bs-toggle="modal" data-bs-target="#pdfModal" data-pdfsrc="../../images/files/<?= $title ?>" ><i class="fa-solid fa-eye"></i></a>
                      <a href="../../images/files/force.php?file=<?= urlencode($title)?>"><i class="fa-solid fa-download"></i></a>
                    </td>
                  </tr>
                  <?php } ?>
                </tbody>
              </table>
            </div>
            <?php
                    }
                ?>
          </div>
          <div class="post-single-navigation d-flex align-items-stretch my-5">
          <?php

            $previousSql    = "SELECT post_id, post_judul FROM pub_post WHERE post_id < $id AND ca_id=$categoryURL AND _active=1 ORDER BY post_id DESC LIMIT 1";
            $previousResult = $mysqli->query($previousSql);
            $previousRow    = $previousResult->fetch_assoc();
            $previousPostId = isset($previousRow['post_id']) ? $previousRow['post_id'] : null;

            $nextSql        = "SELECT post_id, post_judul FROM pub_post WHERE post_id > $id AND ca_id=$categoryURL AND _active=1 ORDER BY post_id ASC LIMIT 1";
            $nextResult     = $mysqli->query($nextSql);
            $nextRow        = $nextResult->fetch_assoc();
            $nextPostId     = isset($nextRow['post_id']) ? $nextRow['post_id'] : null;


            if ($previousPostId !== null) {
                echo '<a href="'.$previousPostId.'" class="mr-auto w-50 pr-4"><span class="d-block">Previous Post</span>'.$previousRow['post_judul'].'</a>';
            }

            if ($nextPostId !== null) {
                echo '<a href="'.$nextPostId.'" class="ml-auto w-50 text-right pl-4"><span class="d-block">Next Post</span>'.$nextRow['post_judul'].'</a>';
            }

            ?>
          </div>
        </article>

        <div class="col-lg-3 order-lg-3">
          <?php include_once('views/side.php')?>
        </div>
      </div>
    </div>
  </div>

  <!-- footer start -->
  
  
  <!-- Modal View PDF -->
  <div class="modal fade" id="pdfModal" tabindex="-1" aria-labelledby="pdfModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg modal-dialog-centered">
      <div class="modal-content">
        <div class="modal-header border-0">
          <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
          </button>
        </div>
        <div class="modal-body d-flex justify-content-center align-items-center">
          <div id="pdfViewer"></div>
        </div>
        <div class="modal-footer border-0">
          <!--<button type="button" class="close-button-modal" data-dismiss="modal">Close</button>-->
        </div>
      </div>
    </div>
  </div>


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
  <script src="../assets/js/pdfobject.min.js"></script>
  <script src="../assets/js/custom.js"></script>


  <script>
  
  
    document.addEventListener("DOMContentLoaded", function() {
      var pdfModal = document.getElementById('pdfModal');
      pdfModal.addEventListener('show.bs.modal', function(event) {
        var button = event.relatedTarget;
        var pdfSrc = button.getAttribute('data-pdfsrc');
        PDFObject.embed(pdfSrc, "#pdfViewer", { pdfOpenParams: { toolbar: 0 } });
      });
    });



  </script>





  </body>
</html>
