<?php
  require('./includes/nav.inc.php');  
?>

<script>
function deleteConfirm(id) {
  if (confirm("Are you sure you want to delete this article ?")) {
    var url = "./delete-article.php?id=" + id;
    document.location = url;
  }
}
</script>

<!-- BREADCRUMB -->
<section id="breadcrumb">
  <div class="container">
    <ol class="breadcrumb">
      <li><a href="./index.php">Dashboard</a></li>
      <li class="active">Articles</li>
    </ol>
  </div>
</section>


<section id="main">
  <div class="container">
    <div class="col-md-12">
      <?php
        $limit = 6;
        if(isset($_GET['page'])) {
          $page = $_GET['page'];
        }else {
          $page = 1;
        }
        $offset = ($page - 1) * $limit;
        $sql = "SELECT article.article_title, 
                article.article_id, 
                article.article_date, 
                author.author_name, 
                article.article_image, 
                article.article_trend, 
                article.article_active, 
                article.article_description, 
                category.category_name 
                FROM article, category, author
                WHERE article.category_id = category.category_id
                AND article.author_id = author.author_id
                ORDER BY article.article_date DESC
                LIMIT {$offset},{$limit}";
        $result = mysqli_query($con,$sql);
        $row = mysqli_num_rows($result);

      ?>
      <div class="panel panel-default">
        <div class="panel-heading main-color-bg">
          <h3 class="panel-title">Articles</h3>
        </div>
        <div class="panel-body">
          <table class="table table-striped table-hover article-table">
            <tr>
              <th style="min-width: 200px">Title</th>
              <th style="min-width: 120px">Category</th>
              <th style="min-width: 250px">Content</th>
              <th style="min-width: 90px">Image</th>
              <th style="min-width: 130px">Author</th>
              <th style="min-width: 100px">Published On</th>
              <th style="min-width: 150px">Actions</th>
            </tr>
            <?php
                if($row > 0) {
                  while($data = mysqli_fetch_assoc($result)) {
                    $category_name = $data['category_name'];
                    $article_id = $data['article_id'];
                    $article_title = $data['article_title'];
                    $article_trend = $data['article_trend'];
                    $article_desc = $data['article_description'];
                    $article_image = $data['article_image'];
                    $article_date = $data['article_date'];
                    $article_author = $data['author_name'];
                    $article_active = $data['article_active'];

                    $article_desc = substr($article_desc,0,100);
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
                          '.$article_desc.'
                        </td>
                        <td>
                          <img src="../assets/images/articles/'.$article_image.'" />
                        </td>
                        <td>
                          '.$article_author.'
                        </td>
                        <td>
                          '.$article_date.'
                        </td>
                        <td>';
                        if($article_trend > 0) {
                          echo '
                          <a class="btn btn-danger" href="./deactivate-trend.php?id='.$article_id.'" title="Remove Article Trend">
                            <span class="glyphicon glyphicon-heart"></span>
                          </a>
                          ';
                        }
                        else {
                          echo '
                          <a class="btn btn-warning" href="./activate-trend.php?id='.$article_id.'" title="Make Article Trending">
                            <span class="glyphicon glyphicon-heart-empty"></span>
                          </a>
                          ';
                        }
                        if($article_active > 0) {
                          echo '
                          <a class="btn btn-success" href="./deactivate-article.php?id='.$article_id.'" title="Deactivate Article">
                            <span class="glyphicon glyphicon-eye-open"></span>
                          </a>
                          ';
                        }
                        else {
                          echo '
                          <a class="btn btn-info" href="./activate-article.php?id='.$article_id.'" title="Activate Article">
                            <span class="glyphicon glyphicon-eye-close"></span>
                          </a>
                          ';
                        }
                        echo '
                          
                          <a class="btn btn-danger" href="javascript:deleteConfirm('.$article_id.')" title="Delete Article">
                            <span class="glyphicon glyphicon-trash"></span>
                          </a>
                        </td>
                      </tr>
                    ';
                  }
                }
                else {
                  echo '
                    <td colspan="7" align="center" style="padding-top: 28px; color: var(--active-color);">
                      <h4>
                        Authors need to start writing !
                      </h4>
                    </td>
                  ';
                }
              ?>
          </table>
        </div>
        <div class="text-center">
          <ul class="pagination pg-red">
            <?php
              $paginationQuery = "SELECT * FROM article";
              $paginationResult = mysqli_query($con, $paginationQuery);
              if(mysqli_num_rows($paginationResult) > 0) {
                $total_articles = mysqli_num_rows($paginationResult);
                $total_page = ceil($total_articles / $limit);

                if($page > $total_page) {
                  redirect('./articles.php');
                }
                if($page > 1) {
                  echo '
                    <li class="page-item">
                      <a href="articles.php?page='.($page - 1).'" class="page-link">
                        <span>&laquo;</span>
                      </a>
                    </li>';
                }
                for($i = 1; $i <= $total_page; $i++) {
                  $active = "";
                  if($i == $page) {
                    $active = "active";
                  }
                  echo '<li class="page-item '.$active.'"><a href="./articles.php?page='.$i.'" class="page-link">'.$i.'</a></li>';
                }
                if($total_page > $page){
                  echo '
                    <li class="page-item">
                      <a href="articles.php?page='.($page + 1).'" class="page-link">
                        <span>&raquo;</span>
                      </a>
                    </li>';
                }
              }
            ?>
          </ul>
        </div>
      </div>
    </div>
  </div>
</section>

<?php
  require('./includes/footer.inc.php')
?>