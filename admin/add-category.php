<?php
  require('./includes/nav.inc.php');
  
  if (isset($_POST['submit'])) { 
    
    if(isset($_SESSION['ADMIN_ID'])){ 
      $ADMIN_ID = $_SESSION['ADMIN_ID'];
    }
    else {
      alert("Please Login to Enter Admin Panel");
      redirect('./login.php');
    }
    
    $category_name = $_POST['category_title'];
    $category_desc = $_POST['category_desc'];
    $category_color = $_POST['category_color'];

    $category_name = str_replace('"','\"',$category_name);
    $category_desc = str_replace('"','\"',$category_desc);

    $name   = $category_name.time(); 
    $extension  = pathinfo( $_FILES["category_img"]["name"], PATHINFO_EXTENSION ); 
    $basename   = $name . "." . $extension; 

    $tempname = $_FILES["category_img"]["tmp_name"];     
    $folder = "../assets/images/category/{$basename}"; 
    
    $sql = "INSERT INTO category 
            (category_name,category_color,category_description,category_image) 
            VALUES 
            (\"$category_name\",\"$category_color\",\"$category_desc\",\"$basename\")"; 

    $result = mysqli_query($con, $sql); 
    
    if ($result)  { 
      move_uploaded_file($tempname, $folder);
      alert("Category Added !");
      redirect('./categories.php');
    }else{ 
      echo "Failed to upload Data"; 
    } 
  }
?>

<section id="breadcrumb">
  <div class="container">
    <ol class="breadcrumb">
      <li><a href="./index.php">Dashboard</a></li>
      <li><a href="./categories.php">Categories</a></li>
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
            <h3 class="panel-title">Add Category</h3>
          </div>
          <div class="panel-body">
            <form method="post" id="add_form" enctype="multipart/form-data">
              <div class="form-group">
                <label>Category Name</label>
                <input type="text" autocomplete="off" class="form-control" placeholder="Category Name"
                  name="category_title" id="category_title" required />
                <p id="error-title" class="error-msg text-danger"></p>
              </div>
              <div class="form-group">
                <label>Category Color</label>
                <select name="category_color" class="form-control" id="category_color">
                  <option value="0" selected>Choose Any Color...</option>
                  <option value="tag-yellow">Yellow</option>
                  <option value="tag-green">Green</option>
                  <option value="tag-pink">Pink</option>
                  <option value="tag-orange">Orange</option>
                  <option value="tag-purple">Purple</option>
                  <option value="tag-brown">Brown</option>
                  <option value="tag-blue">Blue</option>
                </select>
                <p id="error-cat" class="error-msg text-danger"></p>
              </div>
              <div class="form-group">
                <label>Category Description</label>
                <textarea name="category_desc" autocomplete="off" id="category_desc" class="form-control"
                  placeholder="Category Description" rows="20" min="150" required></textarea>
                <p id="error-desc" class="error-msg text-danger"></p>
              </div>
              <div class="form-group">
                <label>Category Image</label>
                <input type="file" class="form-control" placeholder="Category Image" name="category_img"
                  id="category_img" accept="image/*" required />
                <p id="error-img" class="error-msg text-danger"></p>
              </div>
              <div class="form-group text-center">
                <img src="../assets/images/articles/choose.png" class="image_preview" id="image_preview" />
              </div>
              <br>
              <div class="text-center">
                <button type="submit" name="submit" class="btn btn-success">Create Category</button>
              </div>
            </form>
          </div>
        </div>
      </div>
    </div>
  </div>
  <script src="../assets/js/admin/add-form-validate-category.js"></script>
</section>

<?php
  require('./includes/footer.inc.php')
?>