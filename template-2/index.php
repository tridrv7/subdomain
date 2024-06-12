<?php 



  require('../conf/config.php');

  require('../conf/phpFunction.php');

/*
if(!empty(loadRecText('prof_sty', 'pub_profile', '_active=1'))){
	$_urlTemp = explode('/', $_SERVER['REQUEST_URI']);
	if(loadRecText('prof_sty', 'pub_profile', '_active=1') != $_urlTemp[1]){
		echo '<meta content="0; url=http://'.$_SERVER['SERVER_NAME'].'/'.loadRecText('prof_sty', 'pub_profile', '_active=1').'" http-equiv="refresh">';	
	}
}
*/

  $queryProfile    = $mysqli->query('SELECT * FROM pub_profile');

  $profileData     = $queryProfile->fetch_all(MYSQLI_ASSOC);





  $pengumuman =  $mysqli->query('SELECT COUNT(*) as pengumuman FROM pub_post WHERE ca_id="003" AND _active="1" AND post_datex >= CURDATE()');

  $count = mysqli_fetch_assoc($pengumuman);



  $event =  $mysqli->query('SELECT COUNT(*) as event FROM pub_post WHERE ca_id="002" AND _active="1" AND post_datex >= CURDATE()');

  $countEvent = mysqli_fetch_assoc($event);







  

  if ($count['pengumuman'] > 0)

  

  {

    echo "<script src='https://code.jquery.com/jquery-3.6.0.min.js'></script>";

    echo 

    "<script type='text/javascript'>

      $(document).ready(function () {

          $('#announcementModal').modal('show');

      });

    </script>";

  }



  $ip_address = getIp();

  $os = get_operating_system();

  $browser = get_the_browser();

  $visit_date = date('Y-m-d H:i:s');

  addVisitToDatabase($ip_address, $os, $browser, $visit_date);

  

  

  if ((!empty($row['post_img'])) && file_exists($dir_image)) {

    $src = '../images/profile/'.$prof[0]['prof_lg'];

  } else {

    $src = '../images/profile/default.png';

  }

  



?>





<!DOCTYPE html>

<html lang="en">



  <head>



    <meta charset="utf-8">

    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">

    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@100;200;300;400;500;600;700;800;900&display=swap" rel="stylesheet">

    <link rel="shortcut icon" href="<?= $src?>">



    <title><?= $profileData[0]['prof_lnm'];?></title>



    <!-- Bootstrap core CSS -->

    <link href="vendor/bootstrap/css/bootstrap.min.css" rel="stylesheet">



    <!-- Additional CSS Files -->

    <link rel="stylesheet" href="assets/css/fontawesome.css">

    <link rel="stylesheet" href="assets/css/style.css">

    <link rel="stylesheet" href="assets/css/owl.css">

    <link rel="stylesheet" href="assets/css/animate.css">

    <link rel="stylesheet" href="assets/css/jquery.fancybox.min.css">



  </head>



<body>





  <?php 

  

    include_once('views/counter.php');

    include_once('views/social.php');

  

  ?>



  

  <div id="overlayer"></div>



  <div class="loader">

    <div class="spinner-border" role="status">

      <span class="sr-only">Loading...</span>

    </div>

  </div>







  <!-- ======= Header ======= -->

  

  <?php 

  

    include_once('views/navbar.php')

  

  ?>

  <!-- End Header -->



  <!-- START HOME SECTION -->

  <!-- END HOME SECTION -->





  <div class="main-banner">

    <div class="owl-carousel owl-banner">

        <?=requestRecTemplate2('ban_title, ban_img', 'pub_banner', 'ban_stat=001 AND _active=1', '_cre_date DESC',5, 1)?>

    </div>

  </div>

  

  

    <div class="section about-us bg-white">

    <div class="container">

      <div class="row">

        <div class="col-lg-5 offset-lg-1 order-lg-2">

          <img src="../images/connect-world.png" alt="" class="image-section">

        </div>

        <div class="col-lg-6 align-self-center order-lg-1">

          <div class="section-heading">

            <h2>Layanan Kami</h2>

            <p><?= $profileData[0]['prof_lnm']?> Kabupaten Sidoarjo siap memberikan pelayanan terbaik bagi Anda</p>

            <?=requestRecTemplate2('mn_url, mn_txt', 'set_menu', 'parent=003 AND _active=1', '_cre_date DESC','', 13)?>

          </div>

        </div>

      </div>

    </div>

  </div>





  

  <div class="section about-us bg-white" style="margin-top: 250px;">

    <div class="container">

      <?=requestRecTemplate2('emp_nm, emp_desk, emp_lhkpn, jab_id, emp_img', 'pub_employees', 'jab_id=001 AND _active=1', '',1, 2)?>

    </div>

  </div>









  <div class="section media">

    <div class="container">

      <div class="row">

        <div class="col-lg-7">

          <div class="owl-carousel owl-media">

            <?=requestRecTemplate2('sos_id, sos_url', 'pub_socials', 'cat=003 AND _active=1', '_cre_date DESC', 5, 12)?>

          </div>

        </div>

        <div class="col-lg-5 align-self-center">

          <div class="section-heading">

            <h2>Media digital</h2>

            <p class="mt-0">Ikuti dokumetasi aktivitas kegiatan lainnya melalui media digital kami</p>

            <div class="main-button-blue mt-4">

              <a href="media/">LIHAT MEDIA LAINNYA</a>

            </div>

          </div>

        </div>

      </div>

    </div>

  </div>



  <section class="section courses mb-5" id="courses" >

    <div class="container">

      <div class="row">

        <div class="col-lg-12 text-center">

          <div class="section-heading">

            <h2>Berita Terbaru</h2>

          </div>

        </div>

      </div>

      <div class="row event_box">

        <?=requestRecTemplate2('post_id, post_judul, post_desk, post_publish, post_see, post_img', 'pub_post', 'ca_id=001 AND _active=1', 'post_publish DESC',6, 4)?>

      </div>

      <div class="col-12 d-flex justify-content-center align-items-center">

        <div class="main-button-blue mt-4">

          <a href="001/">BACA BERITA LAINNYA</a>

        </div>

      </div>

    </div>

  </section>

  

  

  <?php

  if ($countEvent['event'] > 0) {

  ?>





  <div class="section events" id="events">

    <div class="container">

      <div class="row">

        <div class="col-lg-12 text-center">

          <div class="section-heading">

            <h2>Agenda Kegiatan</h2>

          </div>

        </div>

        <?= requestRecTemplate2('post_id, post_judul, post_desk, post_publish, post_datex, post_img', 'pub_post', 'ca_id=002 AND _active=1 AND post_datex >= CURDATE()', 'post_publish DESC', '', 9) ?>

      </div>

    </div>

  </div>

  

  <?php

    }

  ?>



    <!-- about

  ----------------------------------------------- -->

  <div class="section mx-5">

      <div class="container">

          <div class="row clients">

            <?=requestRecTemplate2('sos_nm, sos_url, sos_ic', 'pub_socials', '_active=1 AND cat=2', 'sos_nm DESC','', 11)?>

          </div> 

      </div><!-- end s-clients -->

  </div> <!-- end s-about -->





  <div class="section events" id="events">

    <div class="container">

      <div class="row">

        <div class="col-lg-12 text-center">

          <div class="section-heading">

            <h2>Galeri</h2>

          </div>

        </div>

        <div class="row justify-content-center mb-5">

          <?=requestRecTemplate2('ban_id, ban_title, ban_img', 'pub_banner', 'ban_stat=002 AND _active=1', '_cre_date DESC',6, 7)?>

        </div>

      </div>

      <div class="col-12 d-flex justify-content-center align-items-center">

        <div class="main-button-blue mt-5">

          <a href="galeri/">LIHAT GALERI LAINNYA</a>

        </div>

      </div>

    </div>

  </div>





  <div class="contact-us section" id="contact">

    <div class="container">

      <div class="row">

        <div class="col-lg-6  align-self-center">

          <div class="section-heading">

            <h6>Kontak Kami</h6>

            <h2><?= $profileData[0]['prof_lnm']?></h2>

            <ul>

              <li><i class="fa fa-phone"></i><?= $profileData[0]['prof_telp']?></li>

              <li><i class="fa fa-fax"></i><?= $profileData[0]['prof_fax']?></li>

              <li><i class="fa fa-at"></i><?= $profileData[0]['prof_mail']?></li>

              <li><i class="fa fa-star"></i><a href="><?= $profileData[0]['prof_skm']?>">E-SKM <?= $profileData[0]['prof_snm']?></a></li>

            </ul>

            <div class="maps">

              <p><?= $profileData[0]['prof_addr']?></p>

              <div class="maps-button">

                <a href="<?= $profileData[0]['prof_maps'];?>"><i class="fa-solid fa-map-location-dot"></i></a>

              </div>

            </div>

          </div>

        </div>

        <div class="col-lg-6">

          <div class="contact-us-content">

            <form id="contact-form" class="form-message">

              <div class="row">

                <div class="col-lg-12">

                  <fieldset>

                    <input type="name" name="nama" id="name" placeholder="Nama Lengkap..." autocomplete="on" required>

                  </fieldset>

                </div>

                <div class="col-lg-12">

                  <fieldset>

                    <input type="text" name="mail" id="email" pattern="[^ @]*@[^ @]*" placeholder="Alamat E-mail..." required="">

                  </fieldset>

                </div>

                <div class="col-lg-12">

                  <fieldset>

                    <textarea name="message" id="message" placeholder="Isian kritik atau saran"></textarea>

                  </fieldset>

                </div>

                <div class="col-lg-12">

                  <fieldset>

                    <button type="submit" id="submit-message" class="orange-button">Kirim Kritik atau Saran</button>

                  </fieldset>

                </div>

              </div>

            </form>

          </div>

        </div>

      </div>

    </div>

  </div>









  <!-- footer start -->

  





  <?php 

  

  include_once('views/footer.php')

  

  

  ?>





  <!-- footer end -->



  <!-- START ANNOUNCEMENT MODAL -->

  <div class="modal fade" id="announcementModal" tabindex="-1" aria-labelledby="pengumumanModal" aria-hidden="true">

    <div class="modal-dialog modal-lg">

      <div class="modal-content">

        <div class="modal-header border-0">

          <!-- <button type="button" class="btn-custom-close-modal" data-bs-dismiss="modal">Close</button> -->

        </div>

        <div class="modal-body p-3">

          <div class="announcement-slide owl-carousel owl-theme">

            <?=requestRec('post_id, post_judul, post_desk', 'pub_post', 'ca_id=003 AND _active=1 AND post_datex >= CURDATE()', '','', 8)?>

          </div>

          <div class="modal-footer border-0 py-lg-5 py-4">

            <div class="main-button-blue mt-4">

              <a href="003/">SEMUA PENGUMUMAN</a>

            </div>

            <button type="button" class="close-button-modal mt-4" data-bs-dismiss="modal">TUTUP</button>

          </div>

        </div>

      </div>

    </div>

  </div>

  <!-- END ANNOUNCEMENT MODAL -->



  <!-- START MODAL OTP-->

  <div class="modal fade" id="otpModal" tabindex="-1" aria-labelledby="otpModal" aria-hidden="true">

    <div class="modal-dialog modal-dialog-centered">

      <div class="modal-content">

        <div class="modal-body p-5">

          <div class="alert alert-danger" role="alert" style="display: none;">

            Kode otp yang anda masukkan salah

          </div>

          <img src="images/3.png" alt="" style="width: 100%; border-radius: 8px;" class="mb-3">

          <h5 class="fw-bolder">Verifikasi Email</h5>

          <p class="fw-light">

            Kami telah mengirimkan kode otp ke alamat email anda

          </p>

          <form class="form-otp" method="POST">

            <div class="otp-field mb-4">

              <input type="number" class="otp-input" name="key1" required/>

              <input type="number" class="otp-input" name="key2" disabled required />

              <input type="number" class="otp-input" name="key3" disabled required />

              <input type="number" class="otp-input" name="key4" disabled required />

            </div>

            <div class="row justify-content-center">

              <button type="submit" name="submit" id="submit-otp" class="col-11 btn btn-primary">Verifikasi</button>

            </div>

          </form>

        </div>

      </div>

    </div>

  </div>

  <!-- END MODAL OTP -->



  <!-- START SKM MODAL-->

  <div class="modal fade" id="ikmModal" tabindex="-1" aria-labelledby="otpModal" aria-hidden="true">

    <div class="modal-dialog modal-dialog-centered">

      <div class="modal-content">

        <div class="modal-body p-5">

          <img src="images/4.png" alt="" style="width: 100%; border-radius: 8px;" class="mb-4">

          <h4 class="fw-bolder">Verifikasi berhasil!</h4>

          <p class="fw-bolder mb-0">Yuk isi survei kepuasan masyarakat pada tautan ini

            <a href="<?=$prof[0]['prof_skm']?>">Survei kepuasan masyarakat Dinas Komunikasi dan Informatika</a>

          </p>

        </div>

        <div class="modal-footer border-0">

          <a href="" type="button" class="btn btn-secondary" data-dismiss="modal" aria-label="Close">Lewati</a>

        </div>

      </div>

    </div>

  </div>

  <!-- END SKM MODAL -->









  <!-- Scripts -->

  <!-- Bootstrap core JavaScript -->

  <script src="vendor/jquery/jquery.min.js"></script>

  <script src="vendor/bootstrap/js/bootstrap.min.js"></script>

  <script src="assets/js/isotope.min.js"></script>

  <script src="assets/js/owl-carousel.js"></script>

  <script src="assets/js/counter.js"></script>

  <script src="assets/js/jquery.fancybox.min.js"></script>

  <script src="assets/js/custom.js"></script>



  

  <script>



    

    // START FORM HEADLE OTP //

    const inputs = document.querySelectorAll(".otp-input")



    inputs.forEach((input, index1) => {

      input.addEventListener("keyup", (e) => {

        const currentInput = input,

        nextInput = input.nextElementSibling,

        prevInput = input.previousElementSibling;



        if (currentInput.value.length > 1) {

        currentInput.value = "";

        return;

        }



        if (nextInput && nextInput.hasAttribute("disabled") && currentInput.value !== "") {

        nextInput.removeAttribute("disabled");

        nextInput.focus();

        }



        if (e.key === "Backspace") {

        inputs.forEach((input, index2) => {

            if (index1 <= index2 && prevInput) {

            input.setAttribute("disabled", true);

            input.value = "";

            prevInput.focus();

            }

        });

        }

      });

    });



    window.addEventListener("load", () => inputs[0].focus());



    $(document).ready(function(){

      $("#submit-message").click(function(e){

        e.preventDefault();

        var formData = $('.form-message').serialize();



        $.ajax({

          type: 'POST',

          url: 'form/sendMessage.php',

          data: formData,

          success: function(response){

            console.log('Message sent successfully:', response);

            $('#otpModal').modal('show');

            $('.form-message')[0].reset();



            $("#submit-otp").click(function(e){

              e.preventDefault();

              var code = $('.form-otp').serialize();



              $.ajax({

                type: 'POST',

                url: 'form/verifyOTP.php',

                data: code,

                dataType: 'json', // Menentukan tipe data yang diharapkan dari respons

                success: function(response) {

                  console.log('Response:', response);

                  if (response.success) {

                    console.log('Message sent successfully:', response);

                    $('#otpModal').modal('hide');

                    $('#ikmModal').modal('show');

                  } else {

                    $('.alert-danger').show();

                  }

                }

              });

            });

          }

        });

      });

    });



    // END FORM HEADLE OTP //





  </script>



  </body>

</html>