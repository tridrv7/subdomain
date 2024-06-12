<?php

require('../conf/config.php');
require('../conf/phpFunction.php');

$_kategori = $_GET['kategori'];
$_apiId = $_GET['api'];
$page = isset($_GET['page']) ? (int)$_GET['page'] : 1;

$getApi = $mysqli->query("SELECT sos_nm, sos_url  FROM pub_socials WHERE cat=$_kategori AND sos_id = $_apiId");
$apiurl = $getApi->fetch_assoc();

?>

<!doctype html>
<html lang="en">



<head>
   <meta charset="utf-8">
   <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
   <meta name="author" content="Untree.co">
   <link rel="shortcut icon" href="../<?= $src ?>">

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

   <title><?= $prof[0]['prof_lnm'] ?></title>

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
                     <h1 class="heading" data-aos="fade-up" data-aos-delay="0"><?= $apiurl['sos_nm'] ?></h1>
                     <!-- <p style="font-style: italic;" class="my-5"></p> -->
                  </div>
               </div>
            </div>
            <div class="col-12">
            </div>
         </div>
      </div>
   </div>

   <div class="container" data-aos="fade-up" data-aos-delay="100">
      <div class="row gutter-2 gallery justify-content-start align-items-center detail-news" id="apiDataContainer">
         <!-- API data will be loaded here -->
      </div>
   </div>

   <nav class="my-5">
      <ul class="pagination justify-content-center" id="paginationContainer">
         <!-- Pagination controls will be loaded here -->
      </ul>
   </nav>

   <?php require_once('views/footer.php') ?>

   <div id="overlayer"></div>
   <div class="loader">
      <div class="spinner-border" role="status">
         <span class="sr-only">Loading...</span>
      </div>
   </div>

   <script src="../js/jquery-3.4.1.min.js"></script>
   <script src="../js/popper.min.js"></script>
   <script src="../js/bootstrap.min.js"></script>
   <script src="../js/aos.js"></script>
   <script src="../js/custom.js"></script>

   <script>
      function formatDateToIndonesian(dateString) {
         if (!dateString) return ''; // Return empty string if date string is not provided

         const date = new Date(dateString);
         const months = [
            "Januari", "Februari", "Maret", "April", "Mei", "Juni",
            "Juli", "Agustus", "September", "Oktober", "November", "Desember"
         ];

         const day = date.getDate();
         const month = months[date.getMonth()];
         const year = date.getFullYear();
         return `${day} ${month} ${year}`;
      }

      let apiurl = <?= json_encode($apiurl['sos_url']) ?>;
      let currentPage = <?= $page ?>;
      let itemsPerPage = 6;
      let apiData = [];

      // Fetch data from API
      fetch(apiurl)
         .then(response => {
            if (!response.ok) {
               throw new Error('Failed to fetch data from API');
            }
            return response.json();
         })
         .then(data => {
            console.log('Data fetched from API:', data);
            if (data && Array.isArray(data.data)) {
               apiData = data.data;
               // Filter out items where tgl_akhir is in the past
               const today = new Date();
               apiData = apiData.filter(peng => {
                  if (peng.tgl_akhir) {
                     return new Date(peng.tgl_akhir) >= today;
                  }
                  return true;
               });
               renderPage(currentPage);
               renderPagination();
            } else {
               console.error('Data format is not as expected:', data);
            }
         })
         .catch(error => {
            console.error('Error fetching data from API:', error);
         });

      // Render the specified page
      function renderPage(page) {
         let startIndex = (page - 1) * itemsPerPage;
         let endIndex = startIndex + itemsPerPage;
         let paginatedItems = apiData.slice(startIndex, endIndex);

         let apiDataContainer = document.getElementById('apiDataContainer');
         apiDataContainer.innerHTML = '';

         paginatedItems.forEach(peng => {
            let tanggal = peng.tgl_mulai || peng.tanggal;
            let html = `
                  <div class="col-lg-4 mb-4">
                     <div class="news-item bg-white">
                        <img src="${peng.gambar}" alt="${peng.judul}" class="img-fluid">
                        <div class="news-contents my-4">
                           <a href="${peng.url}" target="_blank"><h3>${peng.judul}</h3></a>
                           <span>
                              ${formatDateToIndonesian(tanggal)}${peng.tgl_akhir ? ' s.d ' + formatDateToIndonesian(peng.tgl_akhir) : ''}
                           </span>
                        </div>
                        <p class="mb-0">
                           <a href="${peng.url}" target="_blank" class="read-more-arrow">
                              <svg class="bi bi-arrow-right" width="1em" height="1em" viewBox="0 0 16 16" fill="currentColor" xmlns="http://www.w3.org/2000/svg">
                                 <path fill-rule="evenodd" d="M10.146 4.646a.5.5 0 0 1 .708 0l3 3a.5.5 0 0 1 0 .708l-3 3a.5.5 0 0 1-.708-.708L12.793 8l-2.647-2.646a.5.5 0 0 1 0-.708z"/>
                                 <path fill-rule="evenodd" d="M2 8a.5.5 0 0 1 .5-.5H13a.5.5 0 0 1 0 1H2.5A.5.5 0 0 1 2 8z"/>
                              </svg>
                           </a>
                        </p>
                     </div>
                  </div>
            `;
            apiDataContainer.innerHTML += html;
         });
      }

      // Render pagination controls
      function renderPagination() {
         let totalPages = Math.ceil(apiData.length / itemsPerPage);
         let paginationContainer = document.getElementById('paginationContainer');
         paginationContainer.innerHTML = '';

         let createPageItem = (page, label = page) => {
            let li = document.createElement('li');
            li.className = `page-item${page === currentPage ? ' active' : ''}`;
            li.innerHTML = `<a class="page-link" href="get-${<?= $_apiId ?>}/halaman-${page}">${label}</a>`;
            li.onclick = (event) => {
               event.preventDefault();
               currentPage = page;
               renderPage(currentPage);
               renderPagination();
            };
            return li;
         };

         // First and Previous buttons
         if (currentPage > 1) {
            paginationContainer.appendChild(createPageItem(1, 'First'));
            paginationContainer.appendChild(createPageItem(currentPage - 1, '&laquo;'));
         } else {
            let liFirst = document.createElement('li');
            liFirst.className = 'page-item disabled';
            liFirst.innerHTML = '<a class="page-link" href="#">First</a>';
            paginationContainer.appendChild(liFirst);

            let liPrev = document.createElement('li');
            liPrev.className = 'page-item disabled';
            liPrev.innerHTML = '<a class="page-link" href="#"><span aria-hidden="true">&laquo;</span></a>';
            paginationContainer.appendChild(liPrev);
         }

         // Page number buttons
         let startPage = Math.max(1, currentPage - 2);
         let endPage = Math.min(totalPages, currentPage + 2);
         for (let i = startPage; i <= endPage; i++) {
            paginationContainer.appendChild(createPageItem(i));
         }

         // Next and Last buttons
         if (currentPage < totalPages) {
            paginationContainer.appendChild(createPageItem(currentPage + 1, '&raquo;'));
            paginationContainer.appendChild(createPageItem(totalPages, 'Last'));
         } else {
            let liNext = document.createElement('li');
            liNext.className = 'page-item disabled';
            liNext.innerHTML = '<a class="page-link" href="#"><span aria-hidden="true">&raquo;</span></a>';
            paginationContainer.appendChild(liNext);

            let liLast = document.createElement('li');
            liLast.className = 'page-item disabled';
            liLast.innerHTML = '<a class="page-link" href="#">Last</a>';
            paginationContainer.appendChild(liLast);
         }
      }
   </script>
</body>

</html>