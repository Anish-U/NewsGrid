<?php
  require('./includes/nav.inc.php');  
?>

<!-- BREADCRUMB -->
<section id="breadcrumb">
  <div class="container">
    <ol class="breadcrumb">
      <li><a href="./index.php">Dashboard</a></li>
      <li class="active">Categories</li>
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
        $sql = "SELECT * 
                FROM category
                ORDER BY category_name ASC
                LIMIT {$offset},{$limit}";
        $result = mysqli_query($con,$sql);
        $row = mysqli_num_rows($result);

      ?>
      <div class="panel panel-default">
        <div class="panel-heading main-color-bg">
          <h3 class="panel-title">Categories</h3>
        </div>
        <div class="panel-body">
          <table class="table table-striped table-hover article-list">
            <tr>
              <th style="min-width: 80px; text-align:center">Name</th>
              <th style="min-width: 100px">Image</th>
              <th style="min-width: 280px">Description</th>
              <th style="min-width: 20px">Tag Color</th>
              <th style="min-width: 20px">Actions</th>
            </tr>
            <?php
                if($row > 0) {
                  while($data = mysqli_fetch_assoc($result)) {
                    $category_name = $data['category_name'];
                    $category_id = $data['category_id'];
                    $category_desc = $data['category_description'];
                    $category_image = $data['category_image'];
                    $category_color = $data['category_color'];

                    echo '
                      <tr>
                        <td style="text-align:center;">
                          '.$category_name.'
                        </td>
                        <td>
                          <img src="../assets/images/category/'.$category_image.'" />
                        </td>
                        <td>
                          '.$category_desc.'
                        </td>
                        <td>
                          <div class="tag '.$category_color.'">'.$category_name.'</div>
                        </td>
                        <td>
                          <a class="btn btn-primary" href="./edit-category.php?id='.$category_id.'">
                            <span class="glyphicon glyphicon-pencil"></span>
                          </a>
                        </td>
                      </tr>
                    ';
                  }
                }
                else {
                  echo '
                    <td colspan="5" align="center" style="padding-top: 28px; color: var(--active-color);">
                      <h4>
                        You need to create a Category !
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
              $paginationQuery = "SELECT * FROM category";
              $paginationResult = mysqli_query($con, $paginationQuery);
              if(mysqli_num_rows($paginationResult) > 0) {
                $total_categories = mysqli_num_rows($paginationResult);
                $total_page = ceil($total_categories / $limit);

                if($page > $total_page) {
                  redirect('./categories.php');
                }
                if($page > 1) {
                  echo '
                    <li class="page-item">
                      <a href="categories.php?page='.($page - 1).'" class="page-link">
                        <span>&laquo;</span>
                      </a>
                    </li>';
                }
                for($i = 1; $i <= $total_page; $i++) {
                  $active = "";
                  if($i == $page) {
                    $active = "active";
                  }
                  echo '<li class="page-item '.$active.'"><a href="./categories.php?page='.$i.'" class="page-link">'.$i.'</a></li>';
                }
                if($total_page > $page){
                  echo '
                    <li class="page-item">
                      <a href="categories.php?page='.($page + 1).'" class="page-link">
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