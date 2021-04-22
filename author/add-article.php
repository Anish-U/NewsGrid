<?php 
  require('../includes/functions.inc.php');
  require('../includes/database.inc.php');
  session_start();
  if(!isset($_SESSION['AUTHOR_LOGGED_IN'])) {
    alert("Please Login to Enter Author Portal");
    redirect('../author-login.php');
  }

  if (isset($_POST['submit'])) { 
    $article_name = $_POST['name'];
    $cat_id = $_POST['category'];
    $article_desc = $_POST['desc'];
    $article_name = str_replace('"','\"',$article_name);
    $article_desc = str_replace('"','\"',$article_desc);
    
    if(isset($_SESSION['AUTHOR_ID'])){ 
      $author_id = $_SESSION['AUTHOR_ID'];
    }
    else {
      alert("Please Login to Enter Author Portal");
      redirect('../author-login.php');
    }
    $name   = 'article-'.$cat_id.'-'.time(); 
    $extension  = pathinfo( $_FILES["image"]["name"], PATHINFO_EXTENSION ); 
    $basename   = $name . "." . $extension; 

    $tempname = $_FILES["image"]["tmp_name"];     
    $folder = "../assets/images/articles/{$basename}"; 
    
    $article_date = date("Y-m-d");

    $sql = "INSERT INTO article 
            (category_id,author_id,article_title,article_image,article_description,article_date,article_trend) 
            VALUES 
            (\"$cat_id\",\"$author_id\",\"$article_name\",\"$basename\",\"$article_desc\",\"$article_date\",1)"; 

    $result = mysqli_query($con, $sql); 
    
    if ($result)  { 
      move_uploaded_file($tempname, $folder);
      echo "Data uploaded successfully"; 
    }else{ 
      echo "Failed to upload Data"; 
    } 
  } 
?>

<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Add Article</title>
</head>

<body>
  <form method="post" enctype="multipart/form-data">
    <label for="name">Article Name</label>
    <input type="text" name="name" id="name">
    <br>
    <br>
    <label for="category">Category Name</label>
    <select name="category" id="category">
      <?php
        $query = "SELECT category_name,category_id FROM category ORDER BY category_name ASC";
        $result = mysqli_query($con,$query);
        $row = mysqli_num_rows($result);
        if($row > 0) {
          while($data = mysqli_fetch_assoc($result)) {
            $category_id = $data['category_id'];
            $category_name = $data['category_name'];
            ?>
      <option value="<?php echo $category_id ?>"><?php echo $category_name ?></option>
      <?php
          }
        }
  	  ?>
    </select>
    <br>
    <br>
    <label for="image">Article Image</label>
    <input type="file" name="image" id="image" accept="image/*">
    <br>
    <br>
    <label for="desc">Article Description</label>
    <textarea name="desc" id="desc" rows="2"></textarea>
    <br>
    <br>
    <button type="submit" name="submit">Submit</button>
  </form>
</body>

</html>