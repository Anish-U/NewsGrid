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
        $limit = 5;
        if(isset($_GET['page'])) {
          $page = $_GET['page'];
        }else {
          $page = 1;
        }
        $offset = ($page - 1) * $limit;
        $sql = "SELECT article.article_title, 
                article.article_id, 
                article.article_date, 
                article.article_image, 
                article.article_active, 
                article.article_description, 
                category.category_name 
                FROM article, category 
                WHERE article.author_id = {$author_id} 
                AND article.category_id = category.category_id
                ORDER BY article.article_date DESC,
                article.article_id DESC
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
              <th style="min-width: 50px">Active</th>
              <th style="min-width: 130px">Published On</th>
              <th style="min-width: 150px">Actions</th>
            </tr>
            <?php
                if($row > 0) {
                  while($data = mysqli_fetch_assoc($result)) {
                    $category_name = $data['category_name'];
                    $article_id = $data['article_id'];
                    $article_title = $data['article_title'];
                    $article_desc = $data['article_description'];
                    $article_image = $data['article_image'];
                    $article_date = $data['article_date'];
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
                        <td>';
                        if($article_active > 0) {
                          echo '<span class="glyphicon glyphicon-ok text-success"></span>';
                        }
                        else {
                          echo '<span class="glyphicon glyphicon-remove text-danger"></span>';
                        }
                        
                        echo '
                        </td>
                        <td>
                          '.$article_date.'
                        </td>
                        <td>
                          <a class="btn btn-primary" href="./edit-article.php?id='.$article_id.'">
                            <span class="glyphicon glyphicon-pencil"></span>
                          </a>
                          <a class="btn btn-danger" href="javascript:deleteConfirm('.$article_id.')">
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
                        You need to start writing '.$_SESSION['AUTHOR_NAME'].' !
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
              $paginationQuery = "SELECT * FROM article WHERE author_id = $author_id ";
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