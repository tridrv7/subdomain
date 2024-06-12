<?php 
   $profile =  $mysqli->query('SELECT * from pub_profile WHERE _active=1 ORDER BY _cre DESC');
   $_profile = $profile->fetch_all(MYSQLI_ASSOC);   
   
   $current_page = $_SERVER['REQUEST_URI'];

   // Menentukan jalur berdasarkan halaman yang sedang dimuat
   $footer_url = ($current_page === '') ? '' : '../';


?>


<div class="site-footer bg-section-light mt-5">
   <div class="footer-dots"></div> <!-- /.footer-dots -->
   <div class="container">

      <div class="row">

         <div class="col-lg-4">
            <div class="widget">
            <h3><?= $_profile[0]['prof_lnm']?><span class="text-primary">.</span> </h3>
            <p><?= $_profile[0]['prof_desk']?>.</p>
            </div> 
         </div>

         <?php 
            $data = $mysqli->query('SELECT * from set_menu WHERE _active=1');
            $_mnrecord = $data->fetch_all(MYSQLI_ASSOC);         
         ?>

         
         <?php foreach ($_mnrecord as $record): ?>
            <?php if ($record['parent'] == 0): ?>
               <div class="col-lg-2">
                  <div class="widget">
                     <h3 class="text-capitalize"><?= $record['mn_txt'] ?></h3>
                     <ul class="list-unstyled float-left links">
                        <?php foreach ($_mnrecord as $childRecord): ?>
                           <?php if ($childRecord['parent'] == $record['mn_id']): ?>
                              <li><a target="<?= $childRecord['mn_tar'] ?>" href="<?= $footer_url . $childRecord['mn_url'] ?>" class="text-capitalize"><?= $childRecord['mn_txt'] ?></a></li>
                              <?php foreach ($_mnrecord as $endChild): ?>
                                 <ul class="list-unstyled">
                                    <?php if ($endChild['parent'] == $childRecord['mn_id']): ?>
                                       <li><a target="<?= $record['mn_tar'] ?>" href="<?= $footer_url . $childRecord['mn_url'] ?>" class="text-capitalize"><?= $endChild['mn_txt'] ?></a></li>
                                    <?php endif ?>
                                 </ul>
                              <?php endforeach ?>
                           <?php endif ?>
                        <?php endforeach ?>
                     </ul>
                  </div>
               </div>
            <?php endif ?>
         <?php endforeach; ?>

      </div>

      <div class="row mt-5">
         <div class="col-12 text-center">
            <p class="copyright">Copyright &copy;2024. All Rights Reserved. &mdash; Dikelola oleh <a href="https://diskominfo.sidoarjokab.go.id/">Dinas Komunikasi dan Informatika Kabupaten Sidoarjo</a>
         </div>
      </div>
   </div> <!-- /.container -->
</div>