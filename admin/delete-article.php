<?php
  require('./includes/nav.inc.php');
  
  if(isset($_GET['id'])) {
    $article_id = $_GET['id'];
  }else {
    redirect('./articles.php');
  }
  if($article_id == '' || $article_id == null) {
    redirect('./articles.php');
  } 

  $sql = "SELECT article_image 
          FROM article 
          WHERE article_id = {$article_id}";
          
  $result = mysqli_query($con, $sql);
  $row = mysqli_fetch_assoc($result);
  $article_img = $row['article_image'];
  
  unlink("../assets/images/articles/{$article_img}");

  $delete_sql = " DELETE FROM article 
                  WHERE article_id = {$article_id}";
  $cat_result = mysqli_query($con, $delete_sql); 
 
  if($cat_result) {
    redirect('./articles.php');
  }
?>


<?php
  require('./includes/footer.inc.php')
?>