<?php
  require('./includes/nav.inc.php');
  
?>


<section id="main">
  <div class="container">
    <div class="row">
      <?php
        
        $cat_sql = "SELECT COUNT(category_id) 
                    AS no_of_categories 
                    FROM category";
        $cat_result = mysqli_query($con,$cat_sql);
        $cat_data = mysqli_fetch_assoc($cat_result);
        $no_of_categories = $cat_data['no_of_categories'];
                
        $book_sql =  "SELECT COUNT(bookmark_id) 
                      AS no_of_bookmarks 
                      FROM article,bookmark 
                      WHERE article.author_id = {$author_id} 
                      AND bookmark.article_id = article.article_id";
        $book_result = mysqli_query($con,$book_sql);
        $book_data = mysqli_fetch_assoc($book_result);
        $no_of_bookmarks = $book_data['no_of_bookmarks'];
        
        // echo "<pre>";
        // print_r($book_data);
        // echo "</pre>";
        
        require('./includes/quick-links.inc.php');
      ?>
      <div class="col-md-9">
        <!-- Website Overview -->
        <div class="panel panel-default">
          <div class="panel-heading main-color-bg">
            <h3 class="panel-title">Overview</h3>
          </div>
          <div class="panel-body" style="padding: 2.5rem;">
            <div class="col-md-4">
              <div class="well dash-box">
                <h2>
                  <span class="glyphicon glyphicon-pencil"></span>
                  <?php echo $no_of_articles;?>
                </h2>
                <h4>Articles</h4>
              </div>
            </div>
            <div class="col-md-4">
              <div class="well dash-box">
                <h2>
                  <span class="glyphicon glyphicon-list-alt" aria-hidden="true"></span>
                  <?php echo $no_of_categories;?>
                </h2>
                <h4>Categories</h4>
              </div>
            </div>
            <div class="col-md-4">
              <div class="well dash-box">
                <h2>
                  <span class="glyphicon glyphicon-bookmark"></span>
                  <?php echo $no_of_bookmarks;?>
                </h2>
                <h4>Bookmarks</h4>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>


    <!-- Latest Articles -->
    <div class="row">
      <?php

        $sql = "SELECT article.article_title, 
                article.article_date, 
                article.article_image, 
                category.category_name 
                FROM article, category 
                WHERE article.author_id = {$author_id} 
                AND article.category_id = category.category_id 
                ORDER BY article_date DESC
                LIMIT 4";
        $result = mysqli_query($con,$sql);
        $row = mysqli_num_rows($result);
        
      ?>
      <div class="col-md-12">
        <div class="panel panel-default">
          <div class="panel-heading">
            <h4 class="panel-title">Latest Articles</h4>
          </div>
          <div class="panel-body">
            <table class="table table-striped article-list table-hover">
              <tr>
                <th>Title</th>
                <th>Category</th>
                <th>Image</th>
                <th>Published On</th>
              </tr>
              <?php
                if($row > 0) {
                  while($data = mysqli_fetch_assoc($result)) {
                    $category_name = $data['category_name'];
                    $article_title = $data['article_title'];
                    $article_image = $data['article_image'];
                    $article_date = $data['article_date'];
                    $article_date = date("d M y",strtotime($article_date));

                    echo '
                      <tr>
                        <td>
                          '.$article_title.'
                        </td>
                        <td>
                          '.$category_name.'
                        </td>
                        <td>
                          <img src="../assets/images/articles/'.$article_image.'" />
                        </td>
                        <td>
                          '.$article_date.'
                        </td>
                      </tr>
                    ';
                  }
                  echo '
                    <tr>
                      <td colspan="4" align="center" style="padding-top: 2rem;">
                        <a href="./articles.php" class="btn btn-danger ">View All</a>
                      </td>
                    </tr>
                  ';
                }
                else {
                  echo '
                    <td colspan="4" align="center" style="padding-top: 28px; color: var(--active-color);">
                      <h4>
                        You need to start writing '.$_SESSION['AUTHOR_NAME'].' !
                      </h4>
                    </td>
                  ';
                }
              ?>
            </table>
          </div>
        </div>
      </div>
    </div>
  </div>
</section>

<?php
  require('./includes/footer.inc.php')
?>