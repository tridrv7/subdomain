<!doctype html>
<html lang="en">

<?php 

  require('../conf/config.php');
  require('../conf/phpFunction.php');

  
  $profile =  $mysqli->query('SELECT * from pub_profile WHERE _active=1 ORDER BY _cre DESC');
  $prof = $profile->fetch_all(MYSQLI_ASSOC);

  $data = strOrganisasi();
  $file_path = 'employees.json';
  file_put_contents($file_path, $data);


?>



<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
  <meta name="author" content="Untree.co">
  <link rel="shortcut icon" href="../images/profile/<?= $prof[0]['prof_lg']?>">

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
    require_once('../views/navbar-detail.php');
  ?>






  <div class="untree_co-hero mb-0 pb-0" id="home-section">
    <div class="container">
      <div class="row">
        <div class="col-12">
          <div class="dots"></div>
          <div class="row justify-content-center">
            <div class="col-md-7 text-center">
              <h1 class="heading" data-aos="fade-up" data-aos-delay="0">Struktur Organisasi</h1>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>

  <div class="container-fluid" data-aos="fade-up" data-aos-delay="100">
    <div class="row justify-content-center">
      <div class="col-10">
        <div class="chart-container" style="width: 100%; min-height: 100vh"></div>
      </div>
    </div>
  </div>



  <?php require_once('../views/footer.php')?>
  
  
  <!-- START BIODATA PEGAWAI MODAL-->
  <div class="modal fade" id="biodataModal" tabindex="-1" aria-labelledby="otpModal" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
      <div class="modal-content">
        <div class="modal-header border-0">
          <button type="button" class="close" data-dismiss="modal">&times;</button>
        </div>
        <div class="modal-body p-5">
          <ul class="list-unstyled">
            <li class="text-uppercase title-emp">Nama</li>
            <li class="record-emp">Muhammad Wildan, S.S.</li>
            <li class="text-uppercase title-emp">Jabatan</li>
            <li class="record-emp">Kepala Dinas - Bidang</li>
            <li class="text-uppercase title-emp">Mulai Bekerja</li>
            <li class="record-emp">31 Agustus 2023</li>
            <li class="text-uppercase title-emp">Motivasi Kerja</li>
            <li class="record-emp">
            Lorem ipsum dolor, sit amet consectetur adipisicing elit. Corporis enim accusamus nesciunt corrupti culpa? Perferendis quaerat, cumque inventore, esse adipisci rem harum perspiciatis tempora repudiandae, repellendus consequuntur ex eaque quasi.
            </li>
            <li class="text-uppercase title-emp">Lhkpn</li>
            <li class="record-emp name-cell pdf"><a href="" class="ml-2">lhkpn-pimpinan.pdf</a></li>
          </ul>
        </div>
      </div>
    </div>
  </div>
  <!-- END BIODATA PEGAWAI MODAL -->

  

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
  <script src="https://d3js.org/d3.v7.min.js"></script>
  <script src="https://cdn.jsdelivr.net/npm/d3-org-chart@3.0.1"></script>
  <script src="https://cdn.jsdelivr.net/npm/d3-flextree@2.1.2/build/d3-flextree.js"></script>


  <script src="../js/custom.js"></script>
  
  <script>
    function openModal(){
      $('#biodataModal').modal('show');
    }
  </script>



</body>

</html>