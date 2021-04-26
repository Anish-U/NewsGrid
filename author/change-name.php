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
    
    $old_name = $_POST['old_name'];
    $new_name = $_POST['new_name'];
    $confirm_name = $_POST['confirm_name'];

    $sql = "SELECT author_name FROM author 
            WHERE author_id = {$author_id}
            AND author_name = '{$old_name}'";
    $result = mysqli_query($con,$sql);
    $rows = mysqli_num_rows($result);
    if($rows > 0) {
      $update_sql = " UPDATE author 
                      SET author_name = '{$new_name}'
                      WHERE author_id = {$author_id}";
      $update_result = mysqli_query($con,$update_sql);
      if(!$update_result) {
        alert("Sorry. Try again later !");
      }
      else {
        $_SESSION['AUTHOR_NAME'] = $new_name;
        alert("Name Updated !");
      }
    }
    else {
      alert("Wrong Name. Try again !");
    }
  }
?>

<section id="breadcrumb">
  <div class="container">
    <ol class="breadcrumb">
      <li><a href="./index.php">Dashboard</a></li>
      <li class="active">Settings</li>
      <li class="active">Change Name</li>
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
        <div class="panel panel-default">
          <div class="panel-heading main-color-bg">
            <h3 class="panel-title">Change Name</h3>
          </div>
          <div class="panel-body">
            <form method="post" id="change_name_form">
              <div class="form-group">
                <label>Old Name</label>
                <input type="text" autocomplete="off" class="form-control" placeholder="Old Name" name="old_name"
                  id="old_name" required />
                <p id="error-old" class="error-msg text-danger"></p>
              </div>
              <div class="form-group">
                <label>New Name</label>
                <input type="text" autocomplete="off" class="form-control" placeholder="New Name" name="new_name"
                  id="new_name" required />
                <p id="error-new" class="error-msg text-danger"></p>
              </div>
              <div class="form-group">
                <label>Confirm New Name</label>
                <input type="text" autocomplete="off" class="form-control" placeholder="Confirm New Name"
                  name="confirm_name" id="confirm_name" required />
                <p id="error-confirm" class="error-msg text-danger"></p>
                <p id="error-common" class="error-msg text-danger"></p>
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
  <script src="../assets/js/admin/change-name-validate.js"></script>
</section>

<?php
  require('./includes/footer.inc.php')
?>