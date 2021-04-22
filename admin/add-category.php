<?php 
  if (isset($_POST['submit'])) { 
    $category_name = $_POST['name'];
    $category_desc = $_POST['desc'];
    $category_color = $_POST['color'];
    
    $name   = $category_name.time(); 
    $extension  = pathinfo( $_FILES["image"]["name"], PATHINFO_EXTENSION ); 
    $basename   = $name . "." . $extension; 

    $tempname = $_FILES["image"]["tmp_name"];     
    $folder = "../assets/images/category/{$basename}"; 
    
    $db = mysqli_connect("localhost", "root", "", "news-portal"); 
  
    $sql = "INSERT INTO category (category_name,category_color,category_description,category_image) VALUES (\"$category_name\",\"$category_color\",\"$category_desc\",\"$basename\")"; 

    $result = mysqli_query($db, $sql); 
    


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
  <title>Add Category</title>
</head>

<body>
  <form method="post" enctype="multipart/form-data">
    <label for="name">Category Name</label>
    <input type="text" name="name" id="name">
    <br>
    <br>
    <label for="desc">Category Description</label>
    <textarea name="desc" id="desc" rows="2"></textarea>
    <br>
    <br>
    <label for="color">Category Color</label>
    <select name="color" id="color">
      <option value="tag-yellow">Yellow</option>
      <option value="tag-green">Green</option>
      <option value="tag-pink">Pink</option>
      <option value="tag-orange">Orange</option>
      <option value="tag-purple">Purple</option>
      <option value="tag-brown">Brown</option>
      <option value="tag-blue">Blue</option>
    </select>
    <br>
    <br>
    <label for="image">Category Image</label>
    <input type="file" name="image" id="image" accept="image/*">
    <br>
    <br>
    <button type="submit" name="submit">Submit</button>
  </form>
</body>

</html>