<?php 
   $profile = $mysqli->query('SELECT prof_lnm, prof_snm, prof_lg from pub_profile');
   $_profile = $profile->fetch_all(MYSQLI_ASSOC);


?>





<nav class="site-nav dark js-site-navbar mb-5 site-navbar-target <?=$bgNav?>">

   <div class="container-fluid">

      <div class="row justify-content-center">

         <div class="col-lg-12 px-5">

            <div class="site-navigation d-flex justify-content-between align-items-center">

               <div>

                  <div class="d-flex align-items-center gap-1">

                     <a href="/"><img src="<?=$src?>" class="mr-lg-3 mr-2 logo" style="font-style: italic;"></a>

                     <small class="title-short text-uppercase">

                        <?= $_profile[0]['prof_snm']?>

                     </small>

                     <small class="title-long text-uppercase">

                        <?= $_profile[0]['prof_lnm']?>


                     </small>



                  </div>

               </div>

               <div>

                                        <ul class="js-clone-nav d-none site-menu text-capitalize d-lg-flex justify-content-start gap-2 align-items-center">

                        <li>

                           <a class="nav-link d-flex justify-content-start align-items-center" href="../">

                              <span class="icon-home2 mr-2"></span>

                              <span>Beranda</span>

                           </a>

                        </li>

      

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

                                 echo 

                                 

                                 '<li class="has-children">

                                       <a href="javascript:void(0)" class="nav-link">'.$menu['mn_txt'].'</a>

                                          <ul class="dropdown">';

                                             menu($data, $menu['mn_id']);

                                 echo '</ul> </li>';

                              }

               

                              else{
								if($menu['mn_url']){
									if(!empty($_REQUEST['kategori'])){
										if($menu['mn_tar']){
											$rLink = ''.$menu['mn_url'];
											$rTarget = $menu['mn_tar'];
										} else {
											$rLink = '../'.$menu['mn_url'];
											$rTarget = $menu['mn_tar'];
										}
									} else {
										$rLink = ''.$menu['mn_url'];
										$rTarget = $menu['mn_tar'];
									}
								} else {
									$rLink = 'javascript:void(0);';
									$rTarget = '';
								}

									 echo '<li><a class="nav-link" target="'.$menu['mn_tar'].'" href="'.$rLink.'">'.$menu['mn_txt'].'</a></li>';

                              }

                           }

                        ?>

                     </ul>

                  <a href="#" class="burger ml-auto site-menu-toggle js-menu-toggle d-inline-block dark d-lg-none" data-toggle="collapse" data-target="#main-navbar">

                  <span></span>

                  </a>

               </div>

            </div>

         </div>

      </div>

   </div>

</nav>



<div class="site-mobile-menu site-navbar-target">

   <div class="site-mobile-menu-header">

   <div class="site-mobile-menu-close">

      <span class="icofont-close js-menu-toggle"></span>

   </div>

   </div>

   <div class="site-mobile-menu-body"></div>

</div>