<?php
  require('./includes/nav.inc.php');
  
  if (isset($_POST['submit'])) { 
    
    if(isset($_SESSION['AUTHOR_ID'])){ 
      $author_id = $_SESSION['AUTHOR_ID'];
    }
    else {
      alert("Please Login to Enter Author Portal");
      redirect('../author-login.php');
    }
    
    $article_title = $_POST['article_title'];
    $article_desc = $_POST['article_desc'];
    $article_cat_id = $_POST['category_id'];

    $article_title = str_replace('"','\"',$article_title);
    $article_desc = str_replace('"','\"',$article_desc);

    $name   = 'article-'.$article_cat_id.'-'.time(); 
    $extension  = pathinfo( $_FILES["article_img"]["name"], PATHINFO_EXTENSION ); 
    $basename   = $name . "." . $extension; 

    $tempname = $_FILES["article_img"]["tmp_name"];     
    $folder = "../assets/images/articles/{$basename}"; 
    
    $article_date = date("Y-m-d");

    $sql = "INSERT INTO article 
            (category_id,author_id,article_title,article_image,article_description,article_date,article_trend,article_active) 
            VALUES 
            (\"$article_cat_id\",\"$author_id\",\"$article_title\",\"$basename\",\"$article_desc\",\"$article_date\",0,0)"; 

    $result = mysqli_query($con, $sql); 
    
    if ($result)  { 
      move_uploaded_file($tempname, $folder);
      alert("Article posted. Please wait for Admin to activate it.");
      redirect('./articles.php');
    }else{ 
      echo "Failed to upload Data"; 
    } 
  }
?>

<section id="breadcrumb">
  <div class="container">
    <ol class="breadcrumb">
      <li><a href="./index.php">Dashboard</a></li>
      <li><a href="./articles.php">Articles</a></li>
      <li class="active">Add</li>
    </ol>
  </div>
</section>

<section id="main">
  <div class="container">
    <div class="row">
      <?php
        require('./includes/quick-links.inc.php');
      ?>
      <div class="col-md-9">
        <!-- Website Overview -->
        <div class="panel panel-default">
          <div class="panel-heading main-color-bg">
            <h3 class="panel-title">Add Article</h3>
          </div>
          <div class="panel-body">
            <form method="post" id="add_form" enctype="multipart/form-data">
              <div class="form-group">
                <label>Article Title</label>
                <input type="text" autocomplete="off" class="form-control" placeholder="Article Title"
                  name="article_title" id="article_title" required />
                <p id="error-title" class="error-msg text-danger"></p>
              </div>
              <div class="form-group">
                <label>Category</label>
                <select name="category_id" class="form-control" id="category">
                  <option value="0" selected>Choose Any Category...</option>
                  <?php
                    $cat_sql = "SELECT category_id, category_name FROM category ORDER BY category_name ASC";
                    $cat_res = mysqli_query($con,$cat_sql);
                    $cat_row = mysqli_num_rows($cat_res);
                    
                    while($cat_data = mysqli_fetch_assoc($cat_res)) {
                      $cat_id = $cat_data['category_id'];   
                      $cat_name = $cat_data['category_name'];
                      echo '
                        <option value="'.$cat_id.'">'.$cat_name.'</option>
                      ';   
                    }
                    ?>
                </select>
                <p id="error-cat" class="error-msg text-danger"></p>
              </div>
              <div class="form-group">
                <label>Article Description</label>
                <textarea name="article_desc" autocomplete="off" id="article_desc" class="form-control"
                  placeholder="Article Description" rows="20" min="150" required></textarea>
                <p id="error-desc" class="error-msg text-danger"></p>
              </div>
              <div class="form-group">
                <label>Article Image</label>
                <input type="file" class="form-control" placeholder="Article Image" name="article_img" id="article_img"
                  accept="image/*" required />
                <p id="error-img" class="error-msg text-danger"></p>
              </div>
              <div class="form-group text-center">
                <img src="../assets/images/articles/choose.png" class="image_preview" id="image_preview" />
              </div>
              <br>
              <div class="text-center">
                <button type="submit" name="submit" class="btn btn-success">Post Article</button>
              </div>
            </form>
          </div>
        </div>
      </div>
    </div>
  </div>
  <script src="../assets/js/admin/add-form-validate.js"></script>
</section>

<?php
  require('./includes/footer.inc.php')
?>