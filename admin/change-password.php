<?php
  require('./includes/nav.inc.php');
  
  if (isset($_POST['submit'])) { 
    
    if(isset($_SESSION['ADMIN_ID'])){ 
      $admin_id = $_SESSION['ADMIN_ID'];
    }
    else {
      alert("Please Login to Enter Author Portal");
      redirect('./login.php');
    }  
    
    $old_password = $_POST['old_password'];
    $new_password = $_POST['new_password'];
    $confirm_new_password = $_POST['confirm_new_password'];
    
    $str_new_pass = password_hash($new_password,PASSWORD_BCRYPT);

    $sql = "SELECT * FROM admin 
            WHERE admin_id = {$admin_id}";
    $result = mysqli_query($con,$sql);
    $rows = mysqli_num_rows($result);
    if($rows > 0) {
      $data = mysqli_fetch_assoc($result);
      $password_check = password_verify($old_password,$data['admin_password']);
      if($password_check) {
        $update_sql = " UPDATE admin
                        SET admin.admin_password = '{$str_new_pass}'
                        WHERE admin_id = {$admin_id}";
 
        $update_result = mysqli_query($con,$update_sql);
        if(!$update_result) {
          alert("Sorry. Try again later !");
        }
        else {
          alert("Password Updated !");
        }
      }else {
        alert("Wrong Password. Try again !");
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