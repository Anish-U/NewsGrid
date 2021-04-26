<!-- ======== IMAGE SLIDER ======== -->
<header class="img-slider">
  <?php
  $no_of_slides = "4";
  $sliderQuery = "SELECT category.category_name, category.category_color, article.*
                  FROM category, article
                  WHERE article.category_id = category.category_id
                  AND article.article_trend = 1
                  AND article.article_active = 1
                  ORDER BY RAND() 
                  LIMIT {$no_of_slides}";
  $sliderResult = mysqli_query($con,$sliderQuery);
  
  $row = mysqli_num_rows($sliderResult);
  if($row > 0) {
    $counter = 0;
    while($data = mysqli_fetch_assoc($sliderResult)) {
      $category_color = $data['category_color'];
      $category_name = $data['category_name'];
      $article_id = $data['article_id'];
      $article_title = $data['article_title'];
      $article_image = $data['article_image'];
      $article_desc = $data['article_description'];
      $article_date = $data['article_date'];
      $article_trend = $data['article_trend'];
      $article_title = substr($article_title,0,50).' . . . . .';
      $article_desc = substr($article_desc,0,100).' . . . . .';
      
      $new = false;
      $tdy = time();

      $article_date = strtotime($article_date);
      $datediff = $tdy - $article_date;

      $datediff = round($datediff / (60*60*24));

      if($datediff < 2) {
        $new = true;
      }
      $active = "";
      if($counter == 0) {
        $counter++;
        $active = "active";
      }

      createSlider($active, $article_image, $category_color, $category_name, $article_title, $article_desc, $article_id, $new, $article_trend);
    }
    $counter = 0;
    echo '<div class="navigation">';
    for ($i=0; $i < $no_of_slides; $i++) { 
      $active = "";
      if($counter == 0) {
        $counter++;
        $active = "active";
      }
      echo '<div class="slide-nav-btn '.$active.'"></div>';    
    }
  }      
?>
  </div>
</header>
<!-- SCRIPT FOR IMAGE SLIDER -->
<script src="../assets/js/image-slider.js"></script>