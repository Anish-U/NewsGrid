<?php
  // Fetching all the Navbar Data
  require('./includes/nav.inc.php');
  
  // Fetching all the Slider Data
  require('./includes/slider.inc.php');
?>


<!-- Category List Container -->
<section class="py-1 category-list">
  <div class="container">
    <h2 class="headings">Categories</h2>
    <div class="card-container">
      <?php

        // Category Query to fetch all categories in lexicographic order
        $sql = "SELECT * 
                FROM category 
                ORDER BY category_name ASC";

        // Running the Category query
        $result = mysqli_query($con,$sql);
        
        // Returns the number of rows from the result retrieved.
        $row = mysqli_num_rows($result);
        
        // If query has any result (records) => If there are categories
        if($row > 0) {

          // Fetching the data of particular record as an Associative Array
          while($data = mysqli_fetch_assoc($result)) {
            
            // Storing the category data in variables
            $category_id = $data['category_id'];
            $category_name = $data['category_name'];
            $category_image = $data['category_image'];
            $category_desc = $data['category_description'];
            
            // Calling user defined function to create an category card based upon given data
            createCategoryCard($category_name,$category_image,$category_desc,$category_id);   
          }
        }
      ?>
      </article>
    </div>
  </div>
</section>



<?php

  // Fetching all the Footer Data
  require('./includes/footer.inc.php');
?>