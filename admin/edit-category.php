<?php
  require('./includes/nav.inc.php');
  
  if(isset($_GET['id'])) {
    $category_id = $_GET['id'];
  }else {
    redirect('./categories.php');
  }
  if($category_id == '' || $category_id == null) {
    redirect('./categories.php');
  } 

  
  if (isset($_POST['submit'])) { 
    
    if(!isset($_SESSION['ADMIN_ID'])){ 
      alert("Please Login to Enter Admin Portal");
      redirect('./login.php');
    }
    $category_id = $_GET['id'];
    $category_name = $_POST['category_title'];
    $category_desc = $_POST['category_desc'];
    $category_color = $_POST['category_color'];
    $category_old_img = $_POST['category_old_img'];

    $category_name = str_replace('"','\"',$category_name);
    $category_desc = str_replace('"','\"',$category_desc);
    
    if(empty($_FILES['category_img']['name'])) {
      $basename = $category_old_img;
      $sql = "UPDATE category
            SET  category_name = \"$category_name\",
            category_description = \"$category_desc\",
            category_color = \"$category_color\"
            WHERE category_id = $category_id";

      $result = mysqli_query($con, $sql); 

      if($result) {
        alert("Category updated ");
        redirect('./categories.php');
      }

    }
    else {
      $name   = $category_name.time(); 
      $extension  = pathinfo( $_FILES["category_img"]["name"], PATHINFO_EXTENSION ); 
      $basename   = $name . "." . $extension; 
  
      $tempname = $_FILES["category_img"]["tmp_name"];     
      $folder = "../assets/images/category/{$basename}"; 
      
      $sql = "UPDATE category
            SET category_name = \"$category_name\",
            category_image = \"$basename\",
            category_description = \"$category_desc\",
            category_color = \"$category_color\"
            WHERE category_id = $category_id";

      $result = mysqli_query($con, $sql); 
      
      if($result) { 
        unlink("../assets/images/category/{$category_old_img}");
        move_uploaded_file($tempname, $folder);
        // echo "Data uploaded successfully"; 
        alert("Category updated");
        redirect('./categories.php');
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
      <li><a href="./categories.php">categories</a></li>
      <li class="active">Edit</li>
    </ol>
  </div>
</section>

<section id="main">
  <div class="container">
    <div class="row">
      <?php
        $sql = "SELECT * 
                FROM category 
                WHERE category_id = {$category_id}";
        
        $result = mysqli_query($con,$sql);
        $row = mysqli_num_rows($result);
        
        if($row == 0) {
          redirect('./categories.php');
        }
        
        $data = mysqli_fetch_assoc($result);
        $category_name = $data['category_name'];
        $category_desc = $data['category_description'];
        $category_color = $data['category_color'];
        $category_image = $data['category_image'];

        require('./includes/quick-links.inc.php');
      
      ?>
      <div class="col-md-9">
        <!-- Website Overview -->
        <div class="panel panel-default">
          <div class="panel-heading main-color-bg">
            <h3 class="panel-title">Add Category</h3>
          </div>
          <div class="panel-body">
            <form method="post" id="edit_form" enctype="multipart/form-data">
              <div class="form-group">
                <label>Category Name</label>
                <input type="text" autocomplete="off" class="form-control" placeholder="Category Name"
                  name="category_title" id="category_title" required value="<?php echo $category_name ?>" />
                <p id="error-title" class="error-msg text-danger"></p>
              </div>
              <div class="form-group">
                <label>Category Color</label>
                <select name="category_color" class="form-control" id="category_color">
                  <?php
                    $yellow = "";
                    $green = "";
                    $pink = "";
                    $orange = "";
                    $purple = "";
                    $brown = "";
                    $blue = "";
                    if($category_color == "tag-green") {
                      $green = "selected";
                    }
                    if($category_color == "tag-yellow") {
                      $yellow = "selected";
                    }
                    if($category_color == "tag-pink") {
                      $pink = "selected";
                    }
                    if($category_color == "tag-orange") {
                      $orange = "selected";
                    }
                    if($category_color == "tag-purple") {
                      $purple = "selected";
                    }
                    if($category_color == "tag-brown") {
                      $brown = "selected";
                    }
                    if($category_color == "tag-blue") {
                      $blue = "selected";
                    }
                  ?>
                  <option value="0">Choose Any Color...</option>
                  <option value="tag-yellow" <?php echo $yellow; ?>>Yellow</option>
                  <option value="tag-green" <?php echo $green; ?>>Green</option>
                  <option value="tag-pink" <?php echo $pink; ?>>Pink</option>
                  <option value="tag-orange" <?php echo $orange; ?>>Orange</option>
                  <option value="tag-purple" <?php echo $purple; ?>>Purple</option>
                  <option value="tag-brown" <?php echo $brown; ?>>Brown</option>
                  <option value="tag-blue" <?php echo $blue; ?>>Blue</option>
                </select>
                <p id="error-cat" class="error-msg text-danger"></p>
              </div>
              <div class="form-group">
                <label>Category Description</label>
                <textarea name="category_desc" autocomplete="off" id="category_desc" class="form-control"
                  placeholder="Category Description" rows="20" min="150"
                  required><?php echo $category_desc ?></textarea>
                <p id="error-desc" class="error-msg text-danger"></p>
              </div>
              <div class="form-group">
                <label>Category Image</label>
                <input type="file" class="form-control" placeholder="Category Image" name="category_img"
                  id="category_img" accept="image/*" />
                <input type="hidden" class="form-control" name="category_old_img"
                  value="<?php echo $category_image ?>" />
                <p id="error-img" class="error-msg text-danger"></p>
              </div>
              <div class="form-group text-center">
                <img src="../assets/images/category/<?php echo $category_image ?>" class="image_preview"
                  id="image_preview" />
              </div>
              <br>
              <div class="text-center">
                <button type="submit" name="submit" class="btn btn-success">Update Category</button>
              </div>
            </form>
          </div>
        </div>
      </div>
    </div>
  </div>
  <script src="../assets/js/admin/edit-form-validate-category.js"></script>
</section>

<?php
  require('./includes/footer.inc.php')
?>