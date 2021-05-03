<?php

  // Fetching all the Navbar Data
  require('./includes/nav.inc.php');
?>


<!-- Article List Container -->
<section class="py-1 category-list">
  <div class="container">
    <h2 class="headings">Articles</h2>
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
        
        // Declaring Article Query
        $articleQuery = "";

        // If we get category_id from URL and it is not null
        if(isset($_GET['id']) && $_GET['id']!='') {
          
          // Storing the category_id in a variable
          $category_id = $_GET['id'];

          // Article Query to fetch limit no of articles with respective category id
          $articleQuery = " SELECT category.category_name, category.category_color, article.*
                            FROM category, article
                            WHERE article.category_id = category.category_id
                            AND category.category_id = {$category_id}
                            AND article.article_Active = 1
                            ORDER BY article.article_title LIMIT {$offset},{$limit}";

        }

        // Either category_id is null or we didnt get from URL
        else {

          // Article Query to fetch limit no of articles 
          $articleQuery = " SELECT category.category_name, category.category_color, article.*
                            FROM category, article
                            WHERE article.category_id = category.category_id
                            AND article.article_active = 1
                            ORDER BY article.article_title LIMIT {$offset},{$limit}";
        
        }
        
        // Query to Get all the Details required for the Article Card
        // We get details from ARTICLE & CATEGORY Table in ASC order
        
        // Running Article Query
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

            // Bookmarked variable to determine if the article is bookmarked by the user
            $bookmarked = false;

            // Checking if the user is logged in
            if(isset($_SESSION['USER_ID'])) {
              
              // Bookmark Query to check if the particular article is bookmarked by user
              $bookmarkQuery = "SELECT * FROM bookmark 
                                WHERE user_id = {$_SESSION['USER_ID']}
                                AND article_id = {$article_id}";
              
              
              // Running the Bookmark Query
              $bookmarkResult = mysqli_query($con, $bookmarkQuery);
              
              // Returns the number of rows from the result retrieved.
              $bookmarkRow = mysqli_num_rows($bookmarkResult);
              
              // If query has any result (records) => User has the article bookmarked
              if($bookmarkRow > 0) {
              
                // Updating the variable to true to have bookmarked icon on article card
                $bookmarked = true;
              }
            }

            // Calling user defined function to create an article card based upon given data
            createArticleCard($article_title, $article_image, 
                  $article_desc, $category_name, $category_id,$article_id, 
                  $category_color, $new, $article_trend, $bookmarked);
          }
        }
        
        // If query has no records => If no articles are present with the above filters
        else {
          echo "</div>";
          
          // Calling user defined function to create a card that says no articles present
          createNoArticlesCard();
        } 
      ?>
    </div>
    <?php

      // Declared Pagination Query
      $paginationQuery = "";
      
      // If we get category_id from URL and it is not null
      if(isset($_GET['id']) && $_GET['id']!='') {

        // Stored category_id in a variable
        $category_id = $_GET['id'];

        // Updated Pagination Query
        $paginationQuery = "SELECT * FROM article WHERE article.category_id = {$category_id} AND article.article_active = 1";
      }
      
      // Either category_id is null or we didnt get from URL
      else {
        
        // Updated Pagination Query
        $paginationQuery = "SELECT * FROM article WHERE article_active = 1";
      }
      
      // Running Pagination Query
      $paginationResult = mysqli_query($con, $paginationQuery);
      
      // If query has any result (records) => If articles are present
      if(mysqli_num_rows($paginationResult) > 0) {
        
        // Returns the number of rows from the result retrieved => total no of articles
        $total_articles = mysqli_num_rows($paginationResult);
        
        // Calculated no of pages based on limit and no of articles
        $total_page = ceil($total_articles / $limit);
      ?>

    <div class="text-center py-2">
      <!-- Pagination Block -->
      <div class="pagination">
        <?php
          // Declared string variable for the URL
          $cat_id = "";

          // If we get category_id from the URL
          if(isset($_GET['id']) && $_GET['id'] != '' && $_GET['id'] != null) {
            
            // Updated the URL query string
            $cat_id = 'id='.$_GET['id'].'&';
          }

          // If two or more page exists
          if($page > 1){
            
            // Previous page link added 
            echo '<a href="articles.php?'.$cat_id.'page='.($page - 1).'">&laquo;</a>';
          }
          
          for($i = 1; $i <= $total_page; $i++) {
            
            // Active variable to determine if the page link is current page
            $active = "";
           
            // If the page is active page
            if($i == $page) {

              // Updated active to active class name to show the active page link
              $active = "page-active";
            }
            echo '<a href="articles.php?'.$cat_id.'page='.$i.'" class="'.$active.'">'.$i.'</a>';
          }

          // If the current page is not the last page
          if($total_page > $page){

            // Next page link added
            echo '<a href="articles.php?'.$cat_id.'page='.($page + 1).'">&raquo;</a>';
          }
        }
      ?>
      </div>
    </div>
  </div>
</section>


<?php

  // Fetching all the Footer Data
  require('./includes/footer.inc.php');
?>