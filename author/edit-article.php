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

  
  if (isset($_POST['submit'])) { 
    
    if(isset($_SESSION['AUTHOR_ID'])){ 
      $author_id = $_SESSION['AUTHOR_ID'];
    }
    else {
      alert("Please Login to Enter Author Portal");
      redirect('../author-login.php');
    }
    $article_id = $_GET['id'];
    $article_title = $_POST['article_title'];
    $article_desc = $_POST['article_desc'];
    $article_cat_id = $_POST['category_id'];
    $article_old_img = $_POST['article_old_img'];

    $article_title = str_replace('"','\"',$article_title);
    $article_desc = str_replace('"','\"',$article_desc);
    
    if(empty($_FILES['article_img']['name'])) {
      $basename = $article_old_img;
      $sql = "UPDATE article
            SET  category_id = \"$article_cat_id\",
            article_title = \"$article_title\",
            article_description = \"$article_desc\"
            WHERE article_id = $article_id";

      $result = mysqli_query($con, $sql); 

      if($result) {
        alert("Article updated ".$author_name." !");
        redirect('./articles.php');
      }

    }
    else {
      $name   = 'article-'.$article_cat_id.'-'.time(); 
      $extension  = pathinfo( $_FILES["article_img"]["name"], PATHINFO_EXTENSION ); 
      $basename   = $name . "." . $extension; 
      $name   = 'article-'.$article_cat_id.'-'.time(); 
      $extension  = pathinfo( $_FILES["article_img"]["name"], PATHINFO_EXTENSION ); 
      $basename   = $name . "." . $extension; 

      $tempname = $_FILES["article_img"]["tmp_name"];     

      $folder = "../assets/images/articles/{$basename}";   

      $sql = "UPDATE article
            SET  category_id = \"$article_cat_id\",
            article_title = \"$article_title\",
            article_image = \"$basename\",
            article_description = \"$article_desc\"
            WHERE article_id = $article_id";

      $result = mysqli_query($con, $sql); 
      
      if($result) { 
        unlink("../assets/images/articles/{$article_old_img}");
        move_uploaded_file($tempname, $folder);
        // echo "Data uploaded successfully"; 
        alert("Article updated ".$author_name." !");
        redirect('./articles.php');
      }else{ 
        echo "Failed to upload Data"; 
      } 
    }    
  }
?>

<section id="breadcrumb">
  <div class="container">
    <ol class="breadcrumb">
      <li><a href="./index.php">Dashboard</a></li>
      <li><a href="./articles.php">Articles</a></li>
      <li class="active">Edit</li>
    </ol>
  </div>
</section>

<section id="main">
  <div class="container">
    <div class="row">
      <?php
        $sql = "SELECT article.article_title, 
                article.article_date, 
                article.article_image, 
                article.article_active, 
                article.article_description, 
                category.category_name,
                article.category_id 
                FROM article, category 
                WHERE article.author_id = {$author_id} 
                AND article.article_id = {$article_id}
                AND article.category_id = category.category_id";
        
        $result = mysqli_query($con,$sql);
        $row = mysqli_num_rows($result);
        
        if($row == 0) {
          redirect('./articles.php');
        }
        
        $data = mysqli_fetch_assoc($result);
        $article_title = $data['article_title'];
        $article_desc = $data['article_description'];
        $article_cat_id = $data['category_id'];
        $article_image = $data['article_image'];

        require('./includes/quick-links.inc.php');
      
      ?>
      <div class="col-md-9">
        <!-- Website Overview -->
        <div class="panel panel-default">
          <div class="panel-heading main-color-bg">
            <h3 class="panel-title">Edit Article</h3>
          </div>
          <div class="panel-body">
            <form method="post" id="edit_form" enctype="multipart/form-data">
              <div class="form-group">
                <label>Article Title</label>
                <input type="text" autocomplete="off" class="form-control" placeholder="Article Title"
                  value="<?php echo $article_title; ?>" name="article_title" id="article_title" required />
                <p id="error-title" class="error-msg text-danger"></p>
              </div>
              <div class="form-group">
                <label>Category</label>
                <select name="category_id" class="form-control" name="category" id="category">
                  <?php
                    $cat_sql = "SELECT category_id, category_name FROM category ORDER BY category_name ASC";
                    $cat_res = mysqli_query($con,$cat_sql);
                    $cat_row = mysqli_num_rows($cat_res);
                    
                    while($cat_data = mysqli_fetch_assoc($cat_res)) {
                      // echo "<pre>";
                      // print_r($cat_data); 
                      // echo "</pre>"; 
                      $selected = "";
                      $cat_id = $cat_data['category_id'];   
                      $cat_name = $cat_data['category_name'];
                      if($cat_id == $article_cat_id) {
                        $selected = "selected";
                      }
                      echo '
                        <option value="'.$cat_id.'"'.$selected.'>'.$cat_name.'</option>
                      ';   
                    }
                    ?>
                </select>
              </div>
              <div class="form-group">
                <label>Article Description</label>
                <textarea name="article_desc" autocomplete="off" id="article_desc" class="form-control"
                  placeholder="Article Description" rows="20" min="150" required><?php echo $article_desc; ?></textarea>
                <p id="error-desc" class="error-msg text-danger"></p>
              </div>
              <div class="form-group">
                <label>Article Image</label>
                <input type="file" class="form-control" placeholder="Article Image" name="article_img" id="article_img"
                  accept="image/*" />
                <input type="hidden" class="form-control" name="article_old_img"
                  value="<?php echo $article_image; ?>" />
                <br>
              </div>
              <div class="form-group text-center">
                <img src="../assets/images/articles/<?php echo $article_image; ?>" class="image_preview"
                  id="image_preview" />
              </div>
              <br>
              <div class="text-center">
                <button type="submit" name="submit" class="btn btn-success">Update</button>
              </div>
            </form>
          </div>
        </div>
      </div>
    </div>
  </div>
  <script src="../assets/js/admin/edit-form-validate.js"></script>
</section>

<?php
  require('./includes/footer.inc.php')
?>