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
    
    $old_password = $_POST['old_password'];
    $new_password = $_POST['new_password'];
    $confirm_new_password = $_POST['confirm_new_password'];

    $sql = "SELECT author_password FROM author 
            WHERE author_id = {$author_id}
            AND author_password = '{$old_password}'";
    $result = mysqli_query($con,$sql);
    $rows = mysqli_num_rows($result);
    if($rows > 0) {
      $update_sql = " UPDATE author 
                      SET author_password = '{$new_password}'
                      WHERE author_id = {$author_id}";
      $update_result = mysqli_query($con,$update_sql);
      if(!$update_result) {
        alert("Sorry. Try again later !");
      }
      else {
        alert("Password Updated !");
      }
    }
    else {
      alert("Wrong Password. Try again !");
    }
  }
?>

<section id="breadcrumb">
  <div class="container">
    <ol class="breadcrumb">
      <li><a href="./index.php">Dashboard</a></li>
      <li class="active">Settings</li>
      <li class="active">Change Password</li>
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
            <h3 class="panel-title">Change Password</h3>
          </div>
          <div class="panel-body">
            <form method="post" id="change_pass_form">
              <div class="form-group">
                <label>Old Password</label>
                <input type="password" autocomplete="off" class="form-control" placeholder="Old Password"
                  name="old_password" id="old_password" required />
                <p id="error-old" class="error-msg text-danger"></p>
              </div>
              <div class="form-group">
                <label>New Password</label>
                <input type="password" autocomplete="off" class="form-control" placeholder="New Password"
                  name="new_password" id="new_password" required />
                <p id="error-new" class="error-msg text-danger"></p>
              </div>
              <div class="form-group">
                <label>Confirm New Password</label>
                <input type="password" autocomplete="off" class="form-control" placeholder="Confirm New Password"
                  name="confirm_new_password" id="confirm_new_password" required />
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
  <script src="../assets/js/admin/change-pass-validate.js"></script>
</section>

<?php
  require('./includes/footer.inc.php')
?>