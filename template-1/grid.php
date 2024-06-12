<?php 

  require('../conf/config.php');
  require('../conf/phpFunction.php');


  $profile =  $mysqli->query('SELECT * from pub_profile WHERE _active=1 ORDER BY _cre DESC');
  $prof = $profile->fetch_all(MYSQLI_ASSOC);
  
  $_kategori = $_GET['kategori'];

  $getCategory  = $mysqli->query("SELECT ca_nm, ca_desk FROM set_category  WHERE ca_id = $_kategori");
  $category     = $getCategory->fetch_assoc();
  
  if (!$category) {
    header("Location: ../error.php");
    exit();
  };
  
 

?>


<!doctype html>
<html lang="en">



<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
  <meta name="author" content="Untree.co">
  <link rel="shortcut icon" href="../<?=$src?>">

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

<body data-spy="scroll" data-target=".site-navbar-target" data-offset="100" class="bg-light">


  <?php 
    require_once('views/navbar.php');
    require_once('views/visitor.php');
    require_once('views/social.php');
  ?>






  <div class="untree_co-hero mb-0" id="home-section">
    <div class="container">
      <div class="row">
        <div class="col-12">
          <div class="row justify-content-center">
            <div class="col-12 text-center">
              <h1 class="heading" data-aos="fade-up" data-aos-delay="0" id="hover-text"><?= $category['ca_nm']?></h1>
              <p style="font-style: italic;" class="my-5"><?= $category['ca_desk']?></p>
            </div>
          </div>
        </div>
        <div class="col-12">
        </div>
      </div>
    </div>
  </div>

  <div class="container" data-aos="fade-up" data-aos-delay="100">
    <div class="row gutter-2 gallery justify-content-start align-items-center detail-news">
    <?php

      $page = (isset($_GET['page']))? $_GET['page'] : 1;
      $limit = 6; 
      $limit_start = ($page - 1) * $limit;
      $no = $limit_start + 1;

      $query = "SELECT * FROM pub_post WHERE ca_id=$_kategori AND _active=1 ORDER BY post_publish DESC LIMIT $limit_start, $limit";
      $video = $mysqli->prepare($query);
      $video->execute();
      $res1 = $video->get_result();
     

      while ($row = $res1->fetch_assoc()) {
				$id 		= $row['post_id'];
				$title 	    = $row['post_judul'];
				$desk 	    = $row['post_desk'];
				$date 	    = $row['post_publish'];
				$count 	    = $row['post_see'];

        $dir_image  = $_dirPost . $row['post_img'];


		// VARIABEL NEED OPERATION

        if (!empty($row['post_img'] && file_exists($dir_image) )) {
          $src = $pLink. $_dirPost . $row['post_img'];
        } else {
          $src = $pLink. $_dirPost . 'default.png';
        }


				$dateString 	= DateTime::createFromFormat('Y-m-d', $date);
				$dayEng	= $dateString->format('l');


				$listDayIn = array(
					'Sunday' => 'Minggu',
					'Monday' => 'Senin',
					'Tuesday' => 'Selasa',
					'Wednesday' => 'Rabu',
					'Thursday' => 'Kamis',
					'Friday' => 'Jumat',
					'Saturday' => 'Sabtu'
				);
				

				$dayIn = $listDayIn[$dayEng];
				$_convertDate = $dayIn . ', ' . $dateString->format('d F Y');
        

				$deskToStr = strip_tags($desk);
      ?>
      <div class="col-lg-4 mb-4">
        <div class="news-item bg-white">
          <div class="news-img">
            <img src="<?= $src?>" alt="" class="img-fluid">
          </div>
          <div class="news-contents my-4">
            <a href="<?= $id?>"><h3><?= $title?></h3></a>
            <p><?=$deskToStr?></p>
            <span>
              <?php
                if ($date !== NULL && $date !== '0000-00-00') {
                    echo dateToDay($date);
                }
              ?>
            <span class="icon-eye ml-3 mr-2"></span><?= $count?></span>
          </div>
          <p class="mb-0"><a href="<?= $id?>" class="read-more-arrow">
            <svg class="bi bi-arrow-right" width="1em" height="1em" viewBox="0 0 16 16" fill="currentColor" xmlns="http://www.w3.org/2000/svg">
              <path fill-rule="evenodd" d="M10.146 4.646a.5.5 0 0 1 .708 0l3 3a.5.5 0 0 1 0 .708l-3 3a.5.5 0 0 1-.708-.708L12.793 8l-2.647-2.646a.5.5 0 0 1 0-.708z"/>
              <path fill-rule="evenodd" d="M2 8a.5.5 0 0 1 .5-.5H13a.5.5 0 0 1 0 1H2.5A.5.5 0 0 1 2 8z"/>
            </svg>
          </a>
          </p>
        </div>
      </div>

      <?php } ?>

    </div>
  </div>


  <?php
    $countVid = "SELECT count(*) AS jumlah FROM pub_post WHERE ca_id=$_kategori";
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
          echo '<li class="page-item"><a class="page-link" href="halaman-1">First</a></li>';
          echo '<li class="page-item"><a class="page-link" href="halaman-'.$link_prev.'" aria-label="Previous"><span aria-hidden="true">&laquo;</span></a></li>';
        }


        for($i = $start_number; $i <= $end_number; $i++){
          $link_active = ($page == $i)? ' active' : '';
          echo '<li class="page-item '.$link_active.'"><a class="page-link" href="halaman-'.$i.'">'.$i.'</a></li>';
        }
        
        if($page == $jumlah_page){
          echo '<li class="page-item disabled"><a class="page-link" href="#"><span aria-hidden="true">&raquo;</span></a></li>';
          echo '<li class="page-item disabled"><a class="page-link" href="#">Last</a></li>';
        } else {
          $link_next = ($page < $jumlah_page)? $page + 1 : $jumlah_page;
          echo '<li class="page-item"><a class="page-link" href="halaman-'.$link_next.'" aria-label="Next"><span aria-hidden="true">&raquo;</span></a></li>';
          echo '<li class="page-item"><a class="page-link" href="halaman-'.$jumlah_page.'">Last</a></li>';
        }
      ?>
    </ul>
  </nav>



  <?php require_once('views/footer.php')?>

  

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

<!--plugin-->
<script src="https://cdn.userway.org/widget.js" data-account="KF7HpO0n3A"></script>
<script src="https://code.responsivevoice.org/responsivevoice.js?key=VUVE7OJg"></script>	
	
  <script>
    
    $(document).ready(function(){
		// text to speech======================================================================================
		// ----------------------------------------------------------------------------------------------------
		/*
		var element = document.getElementById("hover-text");
		var text = element.textContent;
		var speech = new SpeechSynthesisUtterance();
		speech.lang = "id-ID";
		speech.text = text;
		speech.voice = speechSynthesis.getVoices().find(voice => voice.name === 'Google Bahasa Indonesia');
		window.speechSynthesis.speak(speech);
		*/
        responsiveVoice.setDefaultVoice('Indonesian Female');
        var element = document.getElementById('hover-text');
        var text = element.textContent;
        responsiveVoice.speak(text);
		
	});
	</script>
  
</body>

</html>