<?php
require('./includes/nav.inc.php');
  $cat_id = "";
  if(isset($_GET['id'])) {
    $article_id =  $_GET['id'];
  }
  elseif ($_GET['id'] == '' && $_GET['id'] == null) {
    redirect('./index.php');
  }
  else {
    redirect('index.php');
  }

  $articleQuery = " SELECT category.category_name, category.category_id, category.category_color, article.*, author.*
                    FROM category, article, author
                    WHERE article.category_id = category.category_id
                    AND article.author_id = author.author_id
                    AND article.article_id = {$article_id}";
  
  $bookmarked = false;
  if(isset($_SESSION['USER_ID'])) {
    $bookmarkQuery = "SELECT * FROM bookmark 
                      WHERE user_id = {$_SESSION['USER_ID']}
                      AND article_id = {$article_id}";       
    
    $bookmarkResult = mysqli_query($con, $bookmarkQuery);
    if(mysqli_num_rows($bookmarkResult) > 0) {
      $bookmarked = true;
    }
  }
  
  $result = mysqli_query($con,$articleQuery);

  if(!$result) {
    redirect('./index.php');
  }
  $row = mysqli_num_rows($result);
  if($row > 0) {
    while($data = mysqli_fetch_assoc($result)) {
      // echo "<pre>";
      // print_r($data);
      // echo "</pre>";
      $cat_id = $data['category_id'];
      $category_name = $data['category_name'];
      $category_color = $data['category_color'];
      $article_title = $data['article_title'];
      $article_image = $data['article_image'];
      $article_desc = $data['article_description'];
      $article_date = $data['article_date'];
      $author_name = $data['author_name'];
      $article_date = strtotime($article_date);
      
?>
<!--? ======== ARTICLE ======== -->
<section class="article">
  <div class="container">
    <div class="page-container">
      <article class="card1">
        <h1 class="article-heading">
          <?php
          echo $article_title;
        ?>
        </h1>
        <img src="./assets/images/articles/<?php echo $article_image; ?>" class="article-image" />
        <div class="meta">
          <div class="author">
            <i class="fas fa-user-alt"></i><?php echo $author_name; ?>
          </div>
          <div class="date">
            <i class="fas fa-calendar-alt"></i>
            <?php
              echo date("d M Y",$article_date);
            ?>
          </div>
          <div class="tag <?php echo $category_color;?>">
            <?php
              echo $category_name;
            ?>
          </div>
        </div>
        <div class="article-content">
          <p>
            <?php
              echo nl2br($article_desc);
            ?>
          </p>
        </div>
        <div class="d-flex text-center">
          <?php
            if ($bookmarked) {
              echo '<a class="btn btn-bookmark" href="remove-bookmark.php?id='.$article_id.'">Remove From Bookmark &nbsp<i class="fas fa-bookmark"></i></a>';   
            }
            else {
              echo '<a class="btn btn-bookmark" href="add-bookmark.php?id='.$article_id.'">Add To Bookmark &nbsp<i class="far fa-bookmark"></i></a>';   
            }
            echo'&nbsp';
            echo '<a class="btn btn-download" target="_blank" href="download-article.php?id='.$article_id.'">Download Article &nbsp<i class="fas fa-download"></i></a>';   
          ?>
        </div>
        <?php
            }
          }
          else {
            redirect('index.php');
          }
        ?>
      </article>
      <aside>
        <div class="card2">
          <h2 class="aside-title">Must read</h2>
          <?php
            $trendingArticleQuery = " SELECT *
                                      FROM article, author
                                      WHERE article.article_trend = 1
                                      AND article.author_id = author.author_id
                                      AND NOT article.article_id = {$article_id}
                                      ORDER BY RAND() LIMIT 5";
            
            $trendingResult = mysqli_query($con,$trendingArticleQuery);

            $row = mysqli_num_rows($trendingResult);
            if($row > 0) {
              while($data = mysqli_fetch_assoc($trendingResult)) {
                // echo "<pre>";
                // print_r($data);
                // echo "</pre>";
                $article_id = $data['article_id'];
                $article_title = $data['article_title'];
                $article_image = $data['article_image'];
                $article_date = $data['article_date'];
                $author_name = $data['author_name'];

                $article_date = strtotime($article_date);
                $article_date = date("d M Y", $article_date);
                
                $article_title = substr($article_title,0,75).' . . . . .';
                
                createAsideCard($article_image, $article_id, $article_title, $author_name,$article_date);
              }
            }
          ?>
          <div class="text-center py-1">
            <a href="search.php?trending=1" class="btn btn-card">View All <span>&twoheadrightarrow; </span>
            </a>
          </div>
        </div>
        <div class="card2">
          <h2 class="aside-title">People Also Read</h2>
          <?php
            $trendingArticleQuery = " SELECT *
                                      FROM article, author
                                      WHERE article.category_id = {$cat_id}
                                      AND article.author_id = author.author_id
                                      AND NOT article.article_id = {$_GET['id']}
                                      ORDER BY RAND() LIMIT 5";
            
            $trendingResult = mysqli_query($con,$trendingArticleQuery);

            $row = mysqli_num_rows($trendingResult);
            if($row > 0) {
              while($data = mysqli_fetch_assoc($trendingResult)) {
                // echo "<pre>";
                // print_r($data);
                // echo "</pre>";
                $article_id = $data['article_id'];
                $article_title = $data['article_title'];
                $article_image = $data['article_image'];
                $article_date = $data['article_date'];
                $author_name = $data['author_name'];

                $article_date = strtotime($article_date);
                $article_date = date("d M Y", $article_date);
                
                $article_title = substr($article_title,0,75).' . . . . .';
                
                createAsideCard($article_image, $article_id, $article_title, $author_name, $article_date);
              }
            }
          ?>
          <div class="text-center py-1">
            <a href="articles.php?id=<?php echo $cat_id;?>" class="btn btn-card">View All <span>&twoheadrightarrow;
              </span>
            </a>
          </div>
        </div>
      </aside>
    </div>
  </div>
</section>

<?php
  require('./includes/footer.inc.php');
?>