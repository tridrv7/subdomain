<?php 

  require('../conf/config.php');
  require('../conf/phpFunction.php');

if(!empty(loadRecText('prof_sty', 'pub_profile', '_active=1'))){
	$_urlTemp = explode('/', $_SERVER['REQUEST_URI']);
	if(loadRecText('prof_sty', 'pub_profile', '_active=1') != $_urlTemp[1]){
		echo '<meta content="0; url=http://'.$_SERVER['SERVER_NAME'].'/'.loadRecText('prof_sty', 'pub_profile', '_active=1').'" http-equiv="refresh">';	
	}
}
  $profile =  $mysqli->query('SELECT * from pub_profile WHERE _active=1 ORDER BY _cre DESC');
  $prof = $profile->fetch_all(MYSQLI_ASSOC);

  $video =  $mysqli->query('SELECT sos_url from pub_socials WHERE _active=1 AND cat=003 ORDER BY _cre_date DESC LIMIT 1');
  $get_url = $video->fetch_all(MYSQLI_ASSOC);
  $url = $get_url[0]['sos_url'];
  $queryID = parse_url($url, PHP_URL_QUERY);
  parse_str($queryID, $params);
  $videoId = $params['v'];
  
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

    
  if ((!empty($row['post_img'])) && file_exists($dir_image)) {
    $src = $_dirProf.$prof[0]['prof_lg'];
  } else {
    $src = $_dirProf.'default.png';
  }
  


?>


<!doctype html>
<html lang="en">

<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
  <meta name="author" content="Untree.co">
  <link rel="shortcut icon" href="<?= $src?>">

  <meta name="description" content="" />
  <meta name="keywords" content="" />

  <link rel="preconnect" href="https://fonts.googleapis.com">
  <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
  <link href="https://fonts.googleapis.com/css2?family=Work+Sans:wght@400;500;600;700&display=swap" rel="stylesheet">
<link href="https://fonts.googleapis.com/css2?family=Kanit:ital,wght@0,100;0,200;0,300;0,400;0,500;0,600;0,700;0,800;0,900;1,100;1,200;1,300;1,400;1,500;1,600;1,700;1,800;1,900&family=League+Spartan:wght@100..900&family=Lobster&family=Poetsen+One&family=Poppins:ital,wght@0,100;0,200;0,300;0,400;0,500;0,600;0,700;0,800;0,900;1,100;1,200;1,300;1,400;1,500;1,600;1,700;1,800;1,900&family=Seymour+One&family=Ubuntu:ital,wght@0,300;0,400;0,500;0,700;1,300;1,400;1,500;1,700&display=swap" rel="stylesheet">

  <link rel="stylesheet" href="css/bootstrap.min.css">
  <link rel="stylesheet" href="css/owl.carousel.min.css">
  <link rel="stylesheet" href="css/owl.theme.default.min.css">
  <link rel="stylesheet" href="css/jquery.fancybox.min.css">
  <link rel="stylesheet" href="fonts/icomoon/style.css">
  <link rel="stylesheet" href="css/font-animated.css">
  <link rel="stylesheet" href="css/aos.css">
  <link rel="stylesheet" href="css/embedYoutube.css">
  <link rel="stylesheet" href="css/style.css">

  <title><?= $prof[0]['prof_lnm']?></title>
</head>

<body data-spy="scroll" data-target=".site-navbar-target" data-offset="100">
  
  <?php 
    require_once('views/navbar.php');
    require_once('views/social.php');
    require_once('views/visitor.php');
  ?>

  <!-- START HOME SECTION -->
  <div class="main-banner">
    <div class="owl-carousel banner-slide">
      <?=requestRec('ban_title, ban_img', 'pub_banner', 'ban_stat=001 AND _active=1', '_cre_date DESC',5, 1)?>
    </div>
  </div>
  <!-- END HOME SECTION -->

  <!-- START LEAD SECTION 
  <div class="base-section" id="lead-section">
    <div class="container">
      <div class="row mb-5">
        <div class="col-12 text-center" data-aos="fade-up" data-aos-delay="0">
          <h2 class="heading">Profil Pimpinan</h2>
          <p class="text-capitalize">Kepala <?= $_profile[0]['prof_lnm']?> Kabupaten Sidoarjo</p>
        </div>
      </div>
      <div class="row justify-content-center" data-aos="fade-up" data-aos-delay="100">
        <?=requestRec('emp_nm, emp_desk, emp_lhkpn, jab_id, emp_img', 'pub_employees', 'jab_id=001 AND _active=1', '','1', 2)?>
      </div>
    </div>
  </div>
   END LEAD SECTION -->

  <!-- START SERVICES SECTION -->
  <div class="base-section" id="services-section">
    <div class="container-fluid">
      <div class="row mb-5">
        <div class="post-heading" data-aos="fade-up" data-aos-delay="0">
          <!--<h2 class="heading">Layanan</h2>-->
		  <h2><?=loadRecText('ca_desk', 'set_category', 'ca_id=005')?></h2>
        </div>
      </div>
      <div class="row d-flex justify-content-center align-items-center" data-aos="fade-up" data-aos-delay="100">
        <div class="col-lg-7 col-10 owl-carousel services-slider">
          <?=requestRec('post_id, post_judul, post_desk, post_img', 'pub_post', 'ca_id=005 AND _active=1', 'post_judul ASC','', 3)?>
        </div>
      </div>
      <div class="row mt-5">
        <div class="col-12 d-flex justify-content-center align-items-center">
          <a href="005/" class="btn btn-outline-primary">Lihat layanan lainnya</a>
        </div>
      </div>
    </div>
  </div>
  <!-- END SERVICES SECTION -->
	
  <!-- START SERVICES SECTION -->
  <div class="base-section bg-section-light" id="services-section">
    <div class="container-fluid">
      <div class="row mb-5">
        <div class="col-12 post-heading" data-aos="fade-up" data-aos-delay="0">
          <h2>Profil Bidang</h2>
          <!--<p class="text-capitalize"><?= $prof[0]['prof_lnm']?></p>-->
        </div>
      </div>
      <div class="row d-flex justify-content-center align-items-center" data-aos="fade-up" data-aos-delay="100">
        <div class="col-lg-7 col-10 owl-carousel services-slider">
          <?=requestRec('jab_id, jab_nm, jab_desk', 'set_jabdept', 'stat=1 AND _active=1 AND jab_id!=001', 'jab_id ASC','', 14)?>
        </div>
      </div>
    </div>
  </div>
  <!-- END SERVICES SECTION -->

  <!-- START MEDIA SECTION -->
  <div class="base-section" id="media-section">
    <div class="container">
      <div class="row justify-content-between">
        <div class="col-lg-4">
			<div class="post-heading pb-5 text-justify">
			  <h2><?=loadRecText('ca_desk', 'set_category', 'ca_id=002')?></h2>
			</div>			
          <!--<h3 class="heading my-2" data-aos="fade-up" data-aos-delay="100">Media Digital</h3>-->
          <div class="mb-4 text-center" data-aos="fade-up" data-aos-delay="100">
			<!--<p><?=loadRecText('ca_desk', 'set_category', 'ca_id=002')?></p>-->
            <a href="video/" class="btn btn-outline-primary">Lihat media lainnya</a>
          </div>
        </div>
        <div class="col-lg-7" data-aos="fade-up" data-aos-delay="100">
            <div class="embed__container">
              <div id="player" data-video-id="<?= $videoId?>"></div>
            </div>
            <div class="carousel__wrap mt-3">
                <div class="owl-carousel media-carousel owl-theme">
                  <?=requestRec('sos_id, sos_url', 'pub_socials', '_active=1 AND cat=003', '_cre_date DESC',10, 6)?>
                </div>
              </div>
            </div>
        </div>
      </div>
    </div>
  </div>
  <!-- END MEDIA SECTION -->

  <!-- START NEWS SECTION -->
  <div class="base-section bg-section-light" id="news-section">
    <div class="container-fluid">
      <div class="row mb-5">
        <div class="col-12 post-heading" data-aos="fade-up" data-aos-delay="0">
		  <h2><?=loadRecText('ca_desk', 'set_category', 'ca_id=001')?></h2>
			<!--
          <h2 class="heading">Berita Terbaru</h2>
          <p>Informasi terupdate kami sediakan bagi Anda</p>
			-->
        </div>
      </div>
      <div class="row d-flex justify-content-center align-items-center" data-aos="fade-up" data-aos-delay="100">
        <div class="col-lg-8 col-10 px-lg-5 px-3 owl-carousel news-slider">
          <?=requestRec('post_id, post_judul, post_desk, post_publish, post_see, post_img', 'pub_post', 'ca_id=001 AND _active=1', 'post_publish DESC',10, 4)?>
        </div>
      </div>
      <div class="row mt-5">
        <div class="col-12 d-flex justify-content-center align-items-center">
          <a href="001/" class="btn btn-outline-primary">Baca berita lainnya</a>
        </div>
      </div>
      
    </div>
  </div>
  <!-- END NEWS SECTION -->

  <!-- START GALERY SECTION -->
  <div class="base-section" id="galery-section">
    <div class="container">
      <div class="row mb-5">
        <div class="col-12" data-aos="fade-up" data-aos-delay="0">
			<div class="post-heading pb-5">
			  <!--<h1 data-text="Foto Kegiatan">Foto Kegiatan</h1>-->
				<h2><?=loadRecText('ca_desk', 'set_category', 'ca_id=002')?></h2>
			</div>			
        </div>
      </div> <!-- /.row -->
      <div class="col-lg-12" data-aos="fade-up" data-aos-delay="100">
        <div class="row gutter-4">
          <?=requestRec('ban_title, ban_img', 'pub_banner', 'ban_stat=002 AND _active=1', '_cre_date DESC',6, 7)?>
        </div>
        <div class="col-12 mt-5 d-flex justify-content-center align-items-center">
          <a href="galeri" class="btn btn-outline-primary">Lihat galeri lainnya</a>
        </div>
      </div>
    </div>
  </div>
  <!-- END GALERY SECTION -->

  <!-- START EVENT SECTION -->
  <?php
  if ($countEvent['event'] > 0) {
  ?>
  <div class="base-section bg-section-light">
    <div class="container">
      <div class="row">
        <div class="col-12 mb-5 text-center post-heading">
			<h2><?=loadRecText('ca_desk', 'set_category', 'ca_id=002')?></h2>
          <!--<p>Jadwal Kegiatan <?= $prof[0]['prof_snm']?> Kabupaten Sidoarjo</p>-->
        </div>
      </div>
      <?php
      if ($countEvent['event'] > 3) {
      ?>
          <div class="row owl-carousel event-slider">
              <?= requestRec('post_id, post_judul, post_desk, post_publish, post_datex, post_img', 'pub_post', 'ca_id=002 AND _active=1 AND post_datex >= CURDATE()', 'post_publish DESC', '', 9) ?>
          </div>
      <?php
      } else {
      ?>
          <div class="row">
              <?= requestRec('post_id, post_judul, post_desk, post_publish, post_datex, post_img', 'pub_post', 'ca_id=002 AND _active=1 AND post_datex >= CURDATE()', 'post_publish DESC', '', 9) ?>
          </div>
      <?php
      }
      ?>
    </div>
  </div>
  <?php
  }
  ?>
  <!-- END EVENT SECTION -->

  <!-- START LINK SECTION -->
  <div class="base-section" id="link-section">
    <div class="container">
      <div class="row mb-5"  data-aos="fade-up" data-aos-delay="0">
        <div class="col-12 text-center post-heading">
          <h2 class="heading">Link Terkait</h2>
          <!--<p>Tautan terkait layanan pemerintahan lainnya</p>-->
        </div>
      </div> <!-- /.row -->
      <div class="row justify-content-center align-items-center">
        <div class="col-lg-12" data-aos="fade" data-aos-delay="200">
          <div class="link-slider owl-carousel d-flex justify-content-center align-items-center">
            <?=requestRec('sos_nm, sos_url, sos_ic', 'pub_socials', '_active=1 AND cat=2', 'sos_nm DESC','', 11)?>
          </div>
        </div>
      </div> 
    </div>
  </div>
  <!-- END LINK SECTION -->

	
  <!-- START CONTACT SECTION -->
  <div class="base-section mb-lg-0 bg-section-light" id="contact-section">
    <div class="container">
      <div class="row mb-5"  data-aos="fade-up" data-aos-delay="0">
        <div class="col-12 text-center post-heading">
          <h2>Kritik dan Saran</h2>
          <!--<p>Kirimkan kritik dan saran melalui form ini</p>-->
        </div>
      </div> <!-- /.row -->
      <div class="row">
        <div class="col-lg-5 col-12 mb-5 mb-lg-0">
          <form data-aos="fade-up" data-aos-delay="100" class="form-message">
            <div class="form-group">
              <label for="nama">Nama Lengkap</label>
              <input type="text" class="form-control" id="nama" name="nama" placeholder="Contoh: Renia Frans" required>
            </div>
            <div class="form-group">
              <label for="mail">Alamat Email</label>
              <input type="email" class="form-control" id="mail" name="mail" placeholder="Contoh: reniafrans@gmail.com" required>
            </div>
            <div class="form-group">
              <label for="message">Pesan</label>
              <textarea name="message" class="form-control" id="message" cols="30" rows="5" required></textarea>
            </div>
            <button type="submit" name="submit" class="btn btn-primary mb-lg-0 mb-5" id="submit-message">Kirim pesan</button>
          </form>
        </div>
        <div class="col-lg-7 col-12 justify-content-center align-items-center d-flex"  data-aos="fade-up" data-aos-delay="100">
          <div class="contact-info mt-5 mt-lg-0">
            <div class="contact-info-item">
              <div class="contact-info-body">
                  <strong class="text-capitalize"><?=$prof[0]['prof_lnm']?></strong>
                  <strong><?=$prof[0]['prof_addr']?></strong>
                  <ul class="list-unstyled ul-links my-3">
                    <li><a href="tel:// <?=$prof[0]['prof_telp']?>" class="d-flex"><span class="mt-1 icon-phone mr-2"></span><span>Telpon : <?=$prof[0]['prof_telp']?></span></a></li>
                    <li><a href="#" class="d-flex"><span class="mt-1 icon-phone mr-2"></span><span>Fax : <?=$prof[0]['prof_fax']?></a></li>
                    <li><a href="mailto:info@mydomain.com" class="d-flex"><span class="mt-1 icon-envelope mr-2"></span><span>Email : <?=$prof[0]['prof_mail']?></span></a></li>
                    <li><a href="<?=$prof[0]['prof_skm']?>" target="_blank" class="d-flex"><span class="mt-1 icon-smile-o mr-2"></span><span>E-SKM : Survey Kepuasan <?=$prof[0]['prof_snm']?>  </span></a></li>
                  </ul>
              </div>
              <div class="contact-info-footer">
                <a href="<?=$prof[0]['prof_maps']?>" class="text-center" target="_blank">Lihat di Google Maps</a>
              </div>
            </div>
            <img src="images/WorldMap.svg" class="img-fluid" alt="Peta Indonesia">
          </div>
        </div> 
      </div>
    </div>
  </div> 
  <!-- END CONTACT SECTION -->

	
	
  <?php //require_once('views/footer.php')?>


  <!-- START ANNOUNCEMENT MODAL -->
  <div class="modal fade" id="announcementModal" tabindex="-1" aria-labelledby="pengumumanModal" aria-hidden="true">
    <div class="modal-dialog modal-lg">
      <div class="modal-content">
        <div class="modal-header border-0">
          <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
          </button>
        </div>
        <div class="modal-body">
          <div class="announcement-slide owl-carousel owl-theme">
            <?=requestRec('post_id, post_judul, post_desk', 'pub_post', 'ca_id=003 AND _active=1 AND post_datex >= CURDATE()', '','', 8)?>
          </div>
          <div class="modal-footer border-0">
            <a href="003/" type="button" class="btn btn-outline-primary">Pengumuman Lainnya</a>
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
  
  
  
  <!-- START ERROR FORM MODAL-->
  <div class="modal fade" id="errorForm" tabindex="-1" aria-labelledby="errorForm" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
      <div class="modal-content">
        <div class="modal-body p-5">
          <img src="images/form-validation.png" alt="" style="width: 100%; border-radius: 8px;" class="mb-4">
          <p class="fw-bolder mb-0">
              Form tidak boleh kosong dan harus diisi dengan data yang benar!
          </p>
        </div>
        <div class="modal-footer border-0">
          <a href="" type="button" class="btn btn-secondary" data-dismiss="modal" aria-label="Close">Oke</a>
        </div>
      </div>
    </div>
  </div>
  <!-- END ERROR FORM MODAL -->

  <!-- START _globModal -->
	<div class="modal fade" id="_globModal" tabindex="-1" role="dialog" aria-labelledby="_globModal" aria-hidden="true" data-backdrop="static" data-keyboard="false">
		<div class="modal-dialog modal-xl" role="document">
			<div class="modal-content">
				<div class="modal-header">
					<h5 class="modal-title" id="_globTitle">Title Modal</h5>
					<button type="button" class="btn icon-close" data-dismiss="modal"></button>
				</div>

				<div class="modal-body p-2">
					<div id="_globBody"></div>
				</div>
			</div>
		</div>
	</div>
  <!-- END _globModal -->
	
	

  <div id="overlayer"></div>

  <div class="loader">
    <div class="spinner-border" role="status">
      <span class="sr-only">Loading...</span>
    </div>
  </div>
 

  <script src="js/jquery-3.4.1.min.js"></script>
  <script src="js/jquery-migrate-3.0.1.min.js"></script>
  <script src="js/popper.min.js"></script>
  <script src="js/bootstrap.min.js"></script>
  <script src="js/owl.carousel.min.js"></script>
  <script src="js/jquery.easing.1.3.js"></script>
  <script src="js/jquery.animateNumber.min.js"></script>
  <script src="js/jquery.waypoints.min.js"></script>
  <script src="js/jquery.fancybox.min.js"></script>
  <script src="js/aos.js"></script>
  <script src="js/embedYoutube.js"></script>
  <script src="js/custom.js"></script>

<!--plugin-->
<script src="https://cdn.userway.org/widget.js" data-account="KF7HpO0n3A"></script>
<script src="https://code.responsivevoice.org/responsivevoice.js?key=VUVE7OJg"></script>	
<!--<script>hljs.initHighlightingOnLoad();</script>	-->
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
		// text to speech======================================================================================
		// ----------------------------------------------------------------------------------------------------
		//responsiveVoice.speak(document.getElementById("article-container").textContent);
		//responsiveVoice.speak("hello world", "Indonesian Female");		
		responsiveVoice.speak('selamat datang di situs resmi <?= $prof[0]['prof_lnm']?>','Indonesian Female');
		
		/*
		var element = document.getElementById("hover-text");
		var text = element.textContent;
		var speech = new SpeechSynthesisUtterance();
		speech.lang = "id-ID";
		speech.text = text;
		speech.voice = speechSynthesis.getVoices().find(voice => voice.name === 'Google Bahasa Indonesia');
		window.speechSynthesis.speak(speech);
		*/
		
		
		
		
		// Ubah Data ==========================================================================================
		// ----------------------------------------------------------------------------------------------------
		// Tampilkan Form Ubah Data
		$('.globOpModal').click(function(reload){
			var _title = $(this).attr('_title');
			var _pk = $(this).attr('_pk');

			$.ajax({
				type : "GET",
				url  : "views/JSONData.php",
				data : {lF:'jab_id, jab_nm, jab_desk',lT:'set_jabdept',lW:'stat=1 AND jab_id='+_pk+' AND _active=1',lO:'',l:''},
				dataType : "JSON",
				success: function(result){
					// tampilkan modal ubah data transaksi
					$('#_globTitle').html(result.jab_nm);
					$('#_globBody').html(result.jab_desk);
					
					$('#_globModal').modal('show');
					// tampilkan data transaksi
				}
			});
		});

		
		
		
      $("#submit-message").click(function(e){
        e.preventDefault();

        var nama = $('#nama').val();
        var email = $('#mail').val();
        var pesan = $('#message').val();
        
        if(nama.trim() == '' || email.trim() == '' || pesan.trim() == '') {
            $('#errorForm').modal('show');
            return;
        }
        
        
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
                    $('.form-otp')[0].reset();
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
