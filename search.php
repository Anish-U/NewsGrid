<?php
  require('./includes/nav.inc.php');
?>

<!--? ======== ARTICLES LIST ======== -->
<section class="search-box">
  <div class="container p-2">
    <form method="GET" class="search-article">
      <div class="box-container d-flex">
        <table class=".search-table">
          <tr>
            <td>
              <input class="search-input" type="text" name="name" id="name" placeholder="Search" autocomplete="off" />
            </td>
            <!-- <td align="right">
              <a href="#"><i id="search-icon" class="fas fa-search"></i></a>
            </td> -->
          </tr>
        </table>
      </div>
      <div class="filters">
        <div>
          <label for="category_select">Category</label>
          <select name="category_select" id="category_select">
            <option value="">Select Any Category</option>
            <?php
                $categoryQuery = "SELECT * FROM category ORDER BY category_name ASC";
                $result = mysqli_query($con,$categoryQuery);

                $row = mysqli_num_rows($result);
                if($row > 0) {
                  while($data = mysqli_fetch_assoc($result)) {
                    $category_id = $data['category_id'];
                    $category_name = $data['category_name'];
                    echo '<option value="'.$category_id.'">'.$category_name.'</option>';
                  }
                }
              ?>
          </select>

        </div>
        <div>
          <label for="from_date">From</label>
          <input type="date" name="from_date" id="from_date" max="<?php echo date("Y-m-d") ?>">
        </div>
        <div>
          <label for="to_date">To</label>
          <input type="date" name="to_date" id="to_date" max="<?php echo date("Y-m-d") ?>">
        </div>
        <div>
          <label for="trending">Trending</label>
          <input type="checkbox" name="trending" id="trending" value="1">
        </div>
      </div>
      <center>
        <button type="submit" name="search" class="btn btn-primary">Search</button>
      </center>
    </form>
  </div>
</section>
<section class="py-1 category-list">
  <div class="container">
    <h2 class="search-heading">Search Results :</h2>
    <div class="card-container">
      <?php
        $limit = 6;
        if(isset($_GET['page'])) {
          $page = $_GET['page'];
        }else {
          $page = 1;
        }
        $offset = ($page - 1) * $limit;
        
        $trending = "";
        if(isset($_GET['trending'])) {
          $trending = get_safe_value($_GET['trending']);
        }
        
        $cat_id = "";
        if(isset($_GET['category_select'])) {
          $cat_id = get_safe_value($_GET['category_select']);
        }
        
        $name = "";
        if(isset($_GET['name'])) {
          $name = get_safe_value($_GET['name']);
        }
        
        $from_date = "";
        if(isset($_GET['from_date'])) {
          $from_date = get_safe_value($_GET['from_date']);
        }

        $to_date = "";
        if(isset($_GET['to_date'])) {
          $to_date = get_safe_value($_GET['to_date']);
        }
        
          
        $searchQuery = "SELECT * FROM article WHERE ";
        if($cat_id != "") {
          $searchQuery .= "category_id = {$cat_id}";
        }else {
          $searchQuery .= "category_id IS NOT NULL";
        }

        if($name != "") {
          $searchQuery .= ' AND article_title LIKE "%'.$name.'%"';
        }else {
          $searchQuery .= " AND article_title IS NOT NULL";
        }

        if($trending != "") {
          $searchQuery .= " AND article_trend = 1";
        }else {
          $searchQuery .= " AND article_trend IS NOT NULL";
        }
        if($from_date != "" && $to_date != "") {
          $searchQuery .= ' AND article_date BETWEEN "'.$from_date.'" AND "'.$to_date.'" ';
        }
        else if($to_date == $from_date && $to_date != "") {
          $searchQuery .= ' AND article_date ="'.$from_date.'"';
        }
        else if($to_date == "" && $from_date != "") {
          $searchQuery .= ' AND article_date >= "'.$from_date.'"';
        }
        else if($from_date == "" && $to_date != "") {
          $searchQuery .= ' AND article_date <= "'.$to_date.'"';
        }

        $searchQuery .= " AND article_active = 1 ";

        $searchQuery1 = $searchQuery." ORDER BY article_title LIMIT {$offset}, {$limit}";

        $searchResult = mysqli_query($con, $searchQuery1);

        $row = mysqli_num_rows($searchResult);
        if($row  > 0) {
          while($data = mysqli_fetch_assoc($searchResult)) {
            $article_id = $data['article_id'];
            $category_id = $data['category_id'];
            $article_title = $data['article_title'];
            $article_image = $data['article_image'];
            $article_desc = $data['article_description'];
            $article_date = $data['article_date'];
            $article_trend = $data['article_trend'];
            
            $article_title = substr($article_title,0,55).' . . . . .';
            $article_desc = substr($article_desc,0,150).' . . . . .';
            
            $new = false;
            $tdy = time();

            $article_date = strtotime($article_date);
            $datediff = $tdy - $article_date;

            $datediff = round($datediff / (60*60*24));

            if($datediff < 2) {
              $new = true;
            }

            $categorysql = "SELECT category_name, category_color 
                            FROM category 
                            WHERE category_id = {$category_id}";

            $categoryres = mysqli_query($con, $categorysql);
            $categorydata = mysqli_fetch_assoc($categoryres);

            // echo"<pre>";
            // print_r($categorydata);
            // echo"</pre>";

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

            $category_color = $categorydata['category_color'];
            $category_name = $categorydata['category_name'];
            
            createArticleCard($article_title, $article_image, 
                $article_desc, $category_name, $category_id,$article_id, 
                $category_color, $new, $article_trend, $bookmarked);
            }
          }
          else {
            echo"</div>";
            createNoArticlesCard();
          }

          $paginationResult = mysqli_query($con, $searchQuery);
          if(mysqli_num_rows($paginationResult) > 0) {
            $total_articles = mysqli_num_rows($paginationResult);
            $total_page = ceil($total_articles / $limit);
            echo "</div>";
            ?>
      <div class="text-center py-2">
        <div class="pagination">
          <?php
            if($page > 1){
              echo '<a href="search.php?page='.($page - 1).'&category_select='.$cat_id.'&name='.$name.'&from_date='.$from_date.'&to_date='.$to_date.'&trending='.$trending.'">&laquo;</a>';
            }
            for($i = 1; $i <= $total_page; $i++) {
              $active = "";
              if($i == $page) {
                $active = "page-active";
              }
              echo '<a href="search.php?page='.$i.'&category_select='.$cat_id.'&name='.$name.'&from_date='.$from_date.'&to_date='.$to_date.'&trending='.$trending.'" class="'.$active.'">'.$i.'</a>';
            }
            if($total_page > $page){
              echo '<a href="search.php?page='.($page + 1).'&category_select='.$cat_id.'&name='.$name.'&from_date='.$from_date.'&to_date='.$to_date.'&trending='.$trending.'">&raquo;</a>';
            }
          }
      ?>
        </div>

      </div>
    </div>
</section>


<?php
  require('./includes/footer.inc.php');
?>