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

  $sql = "UPDATE article 
          SET article_active = 1 
          WHERE article_id = {$article_id}";
          
  $result = mysqli_query($con, $sql);
 
  if($result) {
    alert("Activated Article");
    redirect('./articles.php');
  }
  else {
    alert("Error, Please try again later");
    redirect('./articles.php');
  }
?>

<?php
  require('./includes/footer.inc.php')
?>