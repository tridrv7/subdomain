<div>
   <div class="sidebar-box">
      <h3 class="heading">Berita Populer (3)</h3>
      <div class="row">
         <?php
         
         $query = $mysqli->query("SELECT * FROM pub_post WHERE ca_id=001 ORDER BY post_see DESC LIMIT 3");
         $news = $query->fetch_all(MYSQLI_ASSOC);
         
         foreach ($news as $row) {
            $id 		= $row['post_id'];
            $title 	= $row['post_judul'];
            $date 	= $row['post_publish'];
            $image 	= $row['post_img'];
            
            if(!empty($image)){
				$image = '../'.$_dirPost . $row['post_img'];
			} else {
				$image = '../'.$_dirPost . 'default-template-2.png';
			}

         
         ?>
         <div class="col-12 d-flex justify-content-start align-items-start mb-5 pl-2 gap-3">
            <div class="col-5">
               <img src="<?= $image?>" alt="" class="img-fluid rounded">
            </div>
            <div class="col-7">
               <a href="../001/<?= $id?>"><p class="title-populer-post"><?= $title?></p></a>                                  
               <p class="text-left date-populer-post"><?=dateToDay($date)?></p>
            </div>
         </div>
         <?php } ?>
      </div>
   </div>
   <div class="sidebar-box">
      <h3 class="heading">Berita Terkini (3)</h3>
      <div class="row">
         <?php
         
         $query = $mysqli->query("SELECT * FROM pub_post WHERE ca_id=001 ORDER BY post_publish DESC LIMIT 3");
         $news = $query->fetch_all(MYSQLI_ASSOC);
         
         foreach ($news as $row) {
            $id 		= $row['post_id'];
            $title 	= $row['post_judul'];
            $date 	= $row['post_publish'];
            $image 	= $row['post_img'];
            
            if(!empty($image)){
				$image = '../'.$_dirPost . $row['post_img'];
			} else {
				$image = '../'.$_dirPost . 'default-template-2.png';
			}
      
            
         
         ?>
         <div class="col-12 d-flex justify-content-start align-items-start mb-5 pl-2 gap-3">
            <div class="col-5">
               <img src="<?=$image?>" alt="" class="img-fluid rounded">
            </div>
            <div class="col-7">
               <a href="../001/<?= $id?>"><p class="title-populer-post"><?= $title?></p></a>                                  
               <p class="text-left date-populer-post"><?=dateToDay($date)?></p>
            </div>
         </div>

         <?php } ?>
      </div>
   </div>
   <div class="sidebar-box">
      <?php 
      
      $count_cat   = $mysqli->query("SELECT COUNT(ca_id) AS total_kategori  FROM set_category WHERE _active='1' ORDER BY ca_nm ASC");
      $get_count_cat = $count_cat->fetch_all(MYSQLI_ASSOC);
      
      ?>
      <h3 class="heading">Semua Kategori (<?= $get_count_cat[0]['total_kategori']?>) </h3>
      <ul class="categories">
      <?php

         $category_query   = $mysqli->query("SELECT ca_id, ca_nm FROM set_category WHERE _active='1' ORDER BY ca_nm ASC");
         $category = $category_query->fetch_all(MYSQLI_ASSOC);
         
         foreach ($category as $row) {
            $id 		   =  $row['ca_id'];
            $ca_name 	=  $row['ca_nm'];

            $count_query = $mysqli->query("SELECT COUNT(*) AS total_data FROM pub_post WHERE ca_id = $id AND _active='1'");
            $count_result = $count_query->fetch_assoc();
            $total_data = $count_result['total_data'];
         
         ?>
         <li><a href="../<?=$id?>/"><?= $ca_name?> <span><?= $total_data?></span></a></li>

         <?php } ?>
      </ul>
   </div>
</div>