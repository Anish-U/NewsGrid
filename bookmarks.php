<?php
  // Fetching all the Navbar Data
  require('./includes/nav.inc.php');
  
  // If user not logged in
  if(!isset($_SESSION['USER_LOGGED_IN'])) {
    
    // Redirected to login page along with a message
    alert("Please Login to See Your Bookmarks");
    redirect('./user-login.php');
  }
?>


<!-- Article List Container -->
<section class="py-1 category-list">
  <div class="container">
    <h2 class="headings">Bookmarks</h2>
    <div class="card-container">
      <?php

        // Limit variable to specify the maximum no of articles in each page
        $limit = 6;

        // Check if we get page no from URL
        if(isset($_GET['page'])) {
          
          // Update the page
          $page = $_GET['page'];
        }

        // If page no is not fetched from URL => default to first page
        else {
         
          // Update to 1 as first page
          $page = 1;
        }
        
        // Calculate the offset value for SQL Query => pagination
        $offset = ($page - 1) * $limit;
        
        // Article Query to fetch all bookmarked articles of the user
        $articleQuery = " SELECT category.category_name, category.category_color, article.*
                          FROM category, article, bookmark
                          WHERE article.category_id = category.category_id
                          AND bookmark.article_id = article.article_id
                          AND article.article_active = 1
                          AND bookmark.user_id = {$_SESSION['USER_ID']}
                          ORDER BY article.article_title LIMIT {$offset},{$limit}";

        
        // Query to Get all the Details required for the Article Card
        // We get details from ARTICLE & CATEGORY Table in ASC order
        
        // Running the Article Query
        $result = mysqli_query($con,$articleQuery);

        // Returns the number of rows from the result retrieved.
        $row = mysqli_num_rows($result);
        
        // If query has any result (records) => If any bookmarked article is present
        if($row > 0) {
          
          // Fetching the data of particular record as an Associative Array
          while($data = mysqli_fetch_assoc($result)) {
            
            // Storing the article data in variables
            $category_color = $data['category_color'];
            $category_name = $data['category_name'];
            $category_id = $data['category_id'];
            $article_id = $data['article_id'];
            $article_title = $data['article_title'];
            $article_image = $data['article_image'];
            $article_desc = $data['article_description'];
            $article_date = $data['article_date'];
            $article_trend = $data['article_trend'];
            
            // Updating the title with a substring containing at most length of 55 characters
            $article_title = substr($article_title,0,55).' . . . . .';

            // Updating the description with a substring containing at most length of 150 characters
            $article_desc = substr($article_desc,0,150).' . . . . .';
            
            // New variable to determine if the article is NEW
            $new = false;
            
            // Fetching present timestamp
            $tdy = time();

            // Article date is updated to a timestamp 
            $article_date = strtotime($article_date);
            
            // Found the difference between the article release timestamp and present timestamp
            $datediff = $tdy - $article_date;

            // Converting the difference into no of days
            $datediff = round($datediff / (60*60*24));

            // If the difference is less than 2 => article is less than 2 days older
            if($datediff < 2) {
              
              // Updating the variable to true to have a new tag on article card
              $new = true;
            }

            // Bookmarked variable is set to true for this page
            $bookmarked = true;

            // Calling user defined function to create an article card based upon given data
            createArticleCard($article_title, $article_image, 
                  $article_desc, $category_name, $category_id,$article_id, 
                  $category_color, $new, $article_trend, $bookmarked);
          }
        }else {
          echo "</div>";

          // Calling user defined function to create a card that says no articles present
          createNoArticlesCard();
        } 
      ?>
    </div>
    <?php

      // Pagination Query to get number of bookmarked articles
      $paginationQuery = "SELECT category.category_name, category.category_color, article.*
                          FROM category, article, bookmark
                          WHERE article.category_id = category.category_id
                          AND article.article_active = 1
                          AND bookmark.article_id = article.article_id
                          AND bookmark.user_id = {$_SESSION['USER_ID']}";
      
      
      // Running Pagination Query
      $paginationResult = mysqli_query($con, $paginationQuery);
      
      // If query has any result (records) => If bookmarked articles are present
      if(mysqli_num_rows($paginationResult) > 0) {
        
        // Returns the number of rows from the result retrieved => total no of bookmarked articles
        $total_articles = mysqli_num_rows($paginationResult);
        
        // Calculated no of pages based on limit and no of bookmarked articles
        $total_page = ceil($total_articles / $limit);

        echo "</div>";
      ?>

    <div class="text-center py-2">
      <!-- Pagination Block -->
      <div class="pagination">
        <?php
          // If two or more page exists
          if($page > 1){
            
            // Previous page link added 
            echo '<a href="bookmarks.php?page='.($page - 1).'">&laquo;</a>';
          }

          for($i = 1; $i <= $total_page; $i++) {
            
            // Active variable to determine if the page link is current page
            $active = "";
            
            // If the page is active page
            if($i == $page) {
              
              // Updated active to active class name to show the active page link
              $active = "page-active";
            }
            
            echo '<a href="bookmarks.php?page='.$i.'" class="'.$active.'">'.$i.'</a>';
          }

          // If the current page is not the last page
          if($total_page > $page){
            
            // Next page link added
            echo '<a href="bookmarks.php?page='.($page + 1).'">&raquo;</a>';
          }
        }
    ?>

      </div>
    </div>
</section>


<?php

  // Fetching all the Footer Data
  require('./includes/footer.inc.php');
?>