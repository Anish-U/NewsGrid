<?php
  $art_sql = "SELECT COUNT(article_id) 
              AS no_of_articles 
              FROM article 
              WHERE author_id = {$author_id}";
  $art_result = mysqli_query($con,$art_sql);
  $art_data = mysqli_fetch_assoc($art_result);
  $no_of_articles = $art_data['no_of_articles'];
?>
<div class="col-md-3">
  <div class="list-group">
    <a href="./index.php" class="list-group-item active main-color-bg">
      <span class="glyphicon glyphicon-link"></span>
      Quick Links
    </a>
    <a href="./index.php" class="list-group-item"><span class="glyphicon glyphicon-home"></span> Dashboard
    </a>
    <a href="./articles.php" class="list-group-item"><span class="glyphicon glyphicon-pencil"></span> Articles
      <span class="badge"><?php echo $no_of_articles ?></span></a>
    <a href="./change-password.php" class="list-group-item"><span class="glyphicon glyphicon-cog"></span> Change
      Password
    </a>
    <a href="./change-name.php" class="list-group-item"><span class="glyphicon glyphicon-user"></span> Change
      Name
    </a>
    <a href="./logout.php" class="list-group-item"><span class="glyphicon glyphicon-log-out"></span> Logout
    </a>
  </div>
</div>