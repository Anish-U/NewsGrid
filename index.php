<?php
  // Adding Navbar File from Includes
  require('./includes/nav.inc.php');

  // Adding Image Slider File from Includes
  require('./includes/slider.inc.php');
?>

<!-- ======== ARTICLES LIST ======== -->
<section class="py-1 category-list">
  <div class="container">
    <h2 class="headings">Articles</h2>
    <div class="card-container">
      <?php

        // Query to Get all the Details required for the Article Card
        // We get 5 details from ARTICLE & CATEGORY Table Randomly  
        $articleQuery = " SELECT category.category_name, category.category_color, article.*
                          FROM category, article
                          WHERE article.category_id = category.category_id
                          ORDER BY RAND() LIMIT 5";
        
        // Running the Query
        // Result = 1 -> Successfull Query Execution
        // Result = 0 -> Failure of Query Execution 
        $result = mysqli_query($con,$articleQuery);

        // Row stores the no of rows in the return data from Query
        $row = mysqli_num_rows($result);
        if($row > 0) {
          
          // Traverse through each of the row
          // Storing the Associative array in Data
          while($data = mysqli_fetch_assoc($result)) {
            
            // Variables Storing data from DB
            $category_color = $data['category_color'];
            $category_name = $data['category_name'];
            $category_id = $data['category_id'];
            $article_id = $data['article_id'];
            $article_title = $data['article_title'];
            $article_image = $data['article_image'];
            $article_desc = $data['article_description'];
            $article_date = $data['article_date'];
            $article_trend = $data['article_trend'];
            
            // Using the Substring function to break the content into smaller part for better UI
            $article_title = substr($article_title,0,55).' . . . . .';
            $article_desc = substr($article_desc,0,150).' . . . . .';
            
            // Flag Boolean for knowing if the Article is New
            $new = false;
            $tdy = time();

            // Converting the date from DB to time (secs)
            $article_date = strtotime($article_date);
            $datediff = $tdy - $article_date;

            // Converting the difference in times & rounding it
            $datediff = round($datediff / (60*60*24));

            // If the post is less than 2 days older -> New Article Tag
            if($datediff < 2) {
              $new = true;
            }
            
            $bookmarked = false;

            if(isset($_SESSION['USER_ID'])) {
              $bookmarkQuery = "SELECT * FROM bookmark 
                                WHERE user_id = {$_SESSION['USER_ID']}
                                AND article_id = {$article_id}";
              
              $bookmarkResult = mysqli_query($con, $bookmarkQuery);
              $bookmarkRow = mysqli_num_rows($bookmarkResult);
              if($bookmarkRow > 0) {
                $bookmarked = true;
              }
            }

            // Calling the createArticle Function that creates the card based upon params given
            createArticleCard($article_title, $article_image, 
                  $article_desc, $category_name, $category_id, $article_id, 
                  $category_color, $new, $article_trend, $bookmarked);

          }
        }
        // Calling this function to create a Add more Card which directs to All Article Page
        createMoreCard('./articles.php');
      ?>

    </div>
  </div>
</section>


<!--? ======== CATEGORIES LIST ======== -->
<section class="py-1 category-list">
  <div class="container">
    <h2 class="headings">Categories</h2>
    <div class="card-container">
      <?php
        // Query to Get all the Details required for the Category Card
        // We get 5 details from CATEGORY Table Randomly  
        $categoryQuery= " SELECT * 
                          FROM category 
                          ORDER BY RAND() LIMIT 5";
        
        // Running the Query
        // Result = 1 -> Successfull Query Execution
        // Result = 0 -> Failure of Query Execution 
        $result = mysqli_query($con,$categoryQuery);
        
        // Row stores the no of rows in the return data from Query
        $row = mysqli_num_rows($result);
        if($row > 0) {
        
          // Traverse through each of the row
          // Storing the Associative array in Data
          while($data = mysqli_fetch_assoc($result)) {
            
            // Variables Storing data from DB
            $category_id = $data['category_id'];
            $category_name = $data['category_name'];
            $category_image = $data['category_image'];
            $category_desc = $data['category_description'];
            
            // Calling the createCategory Function that creates the card based upon params given
            createCategoryCard($category_name,$category_image,$category_desc,$category_id,);   
          }
        }
        // Calling this function to create a Add more Card which directs to All Categories Page
        createMoreCard('./categories.php');
      ?>
    </div>
  </div>
</section>


<?php
  // Adding Footer File from Includes
  require('./includes/footer.inc.php');
?>