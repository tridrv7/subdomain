<div class="col-lg-4 mt-lg-0 mt-5">

   <div class="row mb-5">

      <div class="col-12">

         <p class="text-left">BERITA POPULER</p>

         <div class="d-flex justify-content-start align-items-center mt-2">

            <div class="line-populer-news mr-1"></div>

            <div class="dots-populer-news mr-1"></div>

            <div class="dots-populer-news mr-1"></div>

            <div class="dots-populer-news mr-1"></div>

         </div>

      </div>

   </div>

   <div class="row">

      <?php

      

      $query = $mysqli->query("SELECT * FROM pub_post WHERE ca_id='001' AND _active=1 ORDER BY post_see DESC LIMIT 4");

      $news = $query->fetch_all(MYSQLI_ASSOC);

      

      foreach ($news as $row) {

         $id 		= $row['post_id'];

         $title 	= $row['post_judul'];

         $date 	= $row['post_publish'];

         $image 	= $pLink.$_dirPost.$row['post_img'];

         

      

      ?>



      <!-- POPULAR NEWS START -->

      <div class="col-12 d-flex justify-content-start align-items-start mb-3 p-0">

         <div class="col-5">

            <img src="<?= $image?>" alt="" class="img-fluid rounded-lg popular-post">

         </div>

         <div class="col-7">

            <a href="../001/<?= $id?>"><p class="title-populer-post"><?= $title?></p></a>                                 

            <p class="text-left date-populer-post"><?=dateToDay($date)?></p>

         </div>

      </div>

      <!-- POPULAR NEWS END -->

      

      <?php } ?>

   </div>

   <div class="row mb-5">

      <div class="col-12">

         <p class="text-left">BERITA TERKINI</p>

         <div class="d-flex justify-content-start align-items-center mt-2">

            <div class="line-populer-news mr-1"></div>

            <div class="dots-populer-news mr-1"></div>

            <div class="dots-populer-news mr-1"></div>

            <div class="dots-populer-news mr-1"></div>

         </div>

      </div>

   </div>

   <div class="row">

      <?php

      

      $query = $mysqli->query("SELECT * FROM pub_post WHERE ca_id='001' AND _active=1 ORDER BY post_publish DESC LIMIT 4");

      $news = $query->fetch_all(MYSQLI_ASSOC);

      

      foreach ($news as $row) {

         $id 		= $row['post_id'];

         $title 	= $row['post_judul'];

         $date 	= $row['post_publish'];

         $image 	= $pLink.$_dirPost.$row['post_img'];

   

         

      

      ?>



      <!-- POPULAR NEWS START -->

      <div class="col-12 d-flex justify-content-start align-items-start mb-3 p-0">

         <div class="col-5">

            <img src="<?= $image?>" alt="" class="img-fluid rounded-lg popular-post">

         </div>

         <div class="col-7">

            <a href="../001/<?= $id?>"><p class="title-populer-post"><?= $title?></p></a>                                  

            <p class="text-left date-populer-post"><?=dateToDay($date)?></p>

         </div>

      </div>

      <!-- POPULAR NEWS END -->

      

      <?php } ?>

   </div>

</div>





