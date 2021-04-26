<?php
  // Adding Navbar File from Includes
  require('./includes/nav.inc.php');
?>


<!--? ======== ARTICLES LIST ======== -->
<section class="py-1 category-list">
  <div class="container">
    <h2 class="headings">Articles</h2>
    <div class="card-container">
      <?php

        $limit = 6;
        if(isset($_GET['page'])) {
          $page = $_GET['page'];
        }else {
          $page = 1;
        }
        $offset = ($page - 1) * $limit;
        $articleQuery = "";

        if(isset($_GET['id']) && $_GET['id']!='') {
          $category_id = $_GET['id'];
          $articleQuery = " SELECT category.category_name, category.category_color, article.*
                            FROM category, article
                            WHERE article.category_id = category.category_id
                            AND category.category_id = {$category_id}
                            AND article.article_Active = 1
                            ORDER BY article.article_title LIMIT {$offset},{$limit}";

        }
        else {
          $articleQuery = " SELECT category.category_name, category.category_color, article.*
                            FROM category, article
                            WHERE article.category_id = category.category_id
                            AND article.article_active = 1
                            ORDER BY article.article_title LIMIT {$offset},{$limit}";
        
        }
        
        // Query to Get all the Details required for the Article Card
        // We get details from ARTICLE & CATEGORY Table in ASC order
        
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
                  $article_desc, $category_name, $category_id,$article_id, 
                  $category_color, $new, $article_trend, $bookmarked);
          }
        }else {
          echo "</div>";
          createNoArticlesCard();
        } 
      ?>
    </div>
    <!-- PAGINATION -->
    <?php

      $paginationQuery = "";
      if(isset($_GET['id']) && $_GET['id']!='') {
        $category_id = $_GET['id'];
        $paginationQuery = "SELECT * FROM article WHERE article.category_id = {$category_id} AND article.article_active = 1";
      }
      else {
        $paginationQuery = "SELECT * FROM article WHERE article_active = 1";
      }
      
      $paginationResult = mysqli_query($con, $paginationQuery);
      if(mysqli_num_rows($paginationResult) > 0) {
        $total_articles = mysqli_num_rows($paginationResult);
        $total_page = ceil($total_articles / $limit);
        ?>
    <div class="text-center py-2">
      <div class="pagination">
        <?php
        $cat_id = "";
        if(isset($_GET['id'])) {
          $cat_id = 'id='.$_GET['id'].'&';
        }
        if($page > 1){
          echo '<a href="articles.php?'.$cat_id.'page='.($page - 1).'">&laquo;</a>';
        }
        for($i = 1; $i <= $total_page; $i++) {
          $active = "";
          if($i == $page) {
            $active = "page-active";
          }
          echo '<a href="articles.php?'.$cat_id.'page='.$i.'" class="'.$active.'">'.$i.'</a>';
        }
        if($total_page > $page){
          echo '<a href="articles.php?'.$cat_id.'page='.($page + 1).'">&raquo;</a>';
        }
      }
    ?>
        <!-- <a href="#">&laquo;</a>
        <a href="#" class="disabled">...</a>
        <a href="#" class="page-active">14</a>
        <a href="#">&raquo;</a> -->
      </div>
    </div>
  </div>
</section>


<?php
  // Adding Footer File from Includes
  require('./includes/footer.inc.php');
?>