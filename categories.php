<?php
  require('./includes/nav.inc.php');
  require('./includes/slider.inc.php');
?>


<!--? ======== CATEGORIES LIST ======== -->
<section class="py-1 category-list">
  <div class="container">
    <h2 class="headings">Categories</h2>
    <div class="card-container">
      <?php
        $sql = "SELECT * FROM category ORDER BY category_name ASC";
        $result = mysqli_query($con,$sql);
        $row = mysqli_num_rows($result);
        if($row > 0) {
          while($data = mysqli_fetch_assoc($result)) {
            $category_id = $data['category_id'];
            $category_name = $data['category_name'];
            $category_image = $data['category_image'];
            $category_desc = $data['category_description'];
            createCategoryCard($category_name,$category_image,$category_desc,$category_id);   
          }
        }
      ?>
      </article>
    </div>
  </div>
</section>



<?php
  require('./includes/footer.inc.php');
?>