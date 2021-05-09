<?php
  require('./includes/nav.inc.php');
  
?>


<section id="main">
  <div class="container">
    <div class="row">
      <?php

        $user_sql =  "SELECT COUNT(user_id) 
                        AS no_of_users 
                        FROM user";
        $user_result = mysqli_query($con,$user_sql);
        $user_data = mysqli_fetch_assoc($user_result);
        $no_of_users = $user_data['no_of_users'];
                
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
                  <span class="glyphicon glyphicon-user"></span>
                  <?php echo $no_of_users;?>
                </h2>
                <h4>Users</h4>
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
                category.category_name,
                author.author_name 
                FROM article, category, author
                WHERE article.category_id = category.category_id 
                AND article.author_id  = author.author_id
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
                <th>Author Name</th>
                <th>Published On</th>
              </tr>
              <?php
                if($row > 0) {
                  while($data = mysqli_fetch_assoc($result)) {
                    $category_name = $data['category_name'];
                    $author_name = $data['author_name'];
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
                          '.$author_name.'
                        </td>
                        <td>
                          '.$article_date.'
                        </td>
                      </tr>
                    ';
                  }
                  echo '
                    <tr>
                      <td colspan="5" align="center" style="padding-top: 2rem;">
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