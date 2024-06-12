<?php 



   $profile = $mysqli->query('SELECT prof_lnm, prof_snm, prof_lg from pub_profile');

   $_profile = $profile->fetch_all(MYSQLI_ASSOC);

   

    if ((!empty($row['post_img'])) && file_exists($dir_image)) {

        $src = $_dirProf . $prof[0]['prof_lg'];

    } else {

        $src = $_dirProf . 'default.png';

    }

//$current_page = $_SERVER['REQUEST_URI'];

//$url_root = empty($current_page) ? '' : '../';
?>







<header id="header" class="fixed-top d-flex align-items-center">

   <div class="container d-flex align-items-center">



      <div class="logo me-auto">

         <div class="d-flex justify-content-start align-items-center gap-3">

            <img src="<?=$src?>" class="logo">
            <small class="title-short text-uppercase">

                        <?= $profileData[0]['prof_snm']?>

                     </small>

                     <small class="title-long text-uppercase">

                        <?= $profileData[0]['prof_lnm']?>

            </small>

         </div>

         <!-- Uncomment below if you prefer to use an image logo -->

         <!-- <a href="index.html"><img src="images/profile/sidoarjo.png" alt="" class="img-fluid"></a> -->

      </div>





      <nav id="navbar" class="navbar order-last order-lg-0">

         <ul>

            <li><a class="nav-link scrollto" href="/">Beranda</a></li>

            <?php

               $result = $mysqli->query('SELECT * from set_menu WHERE _active=1');

               $rows = $result->fetch_all(MYSQLI_ASSOC);

               menu($rows);



               function menu($data, $parent_id=0){

                  foreach ($data as $key => $value) {

                     if ($value['parent'] == $parent_id) {

                        html($data, $value);

                     }

                  }

               }



               function html($data, $menu){

                  $count = 0;



                  foreach ($data as $key => $value) {

                     if ($value['parent'] == $menu['mn_id']) {

                        $count++;

                     }

                  }



                  if ($count > 0) {

                     echo '<li class="dropdown">

                           <a href="javascript:void(0)">'.$menu['mn_txt'].'<i class="fa fa-angle-right"></i></a>

                              <ul>';

                                 menu($data, $menu['mn_id']);

                        echo '</ul>

                        </li>';

                  }



                  else{
					//$couURI = strlen($_SERVER['REQUEST_URI']);
					if(strlen($_SERVER['REQUEST_URI']) > 12){
						$rLink = '../';
					} else {
						$rLink = '';
					}
					  
                     echo '<li><a class="nav-link scrollto active" target="'.$menu['mn_tar'].'" href="'.$rLink.$menu['mn_url'].'">'.$menu['mn_txt'].'</a></li>';

                  }

               }

            ?>

         </ul>

         <i class="fa-solid fa-bars mobile-nav-toggle"></i>

      </nav><!-- .navbar -->  





   </div>

</header>