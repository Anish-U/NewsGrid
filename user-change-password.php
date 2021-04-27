<?php
  require('./includes/nav.inc.php');
  
  if(!isset($_SESSION['USER_LOGGED_IN'])) {
    alert("Please Login to See Your Bookmarks");
    redirect('./user-login.php');
  }
  $user_id = $_SESSION['USER_ID'];
  if(isset($_POST['submit'])) {
    $old_password = get_safe_value($_POST['old_password']);
    $new_password = get_safe_value($_POST['new_password']);
    $confirm_new_password = get_safe_value($_POST['confirm_new_password']);
    
    $str_new_pass = password_hash($new_password,PASSWORD_BCRYPT);
    
    $sql = "SELECT * FROM user 
            WHERE user_id = {$user_id}";
    $result = mysqli_query($con,$sql);
    $rows = mysqli_num_rows($result);

    if($rows > 0) {
    
      $data = mysqli_fetch_assoc($result);
      $email = $data['user_email'];

      $author_check_sql = "SELECT * FROM author 
                           WHERE author_email = '{$email}'";
      
      $author_check_result = mysqli_query($con, $author_check_sql);
      $author_check_rows = mysqli_num_rows($author_check_result);

      if($author_check_rows = 1) {
        $pasword_check = password_verify($old_password,$data['user_password']);
        if($pasword_check) {
          $update_sql = " UPDATE user
                          SET user_password = '{$str_new_pass}'
                          WHERE user_id = {$user_id}";
  
          $update_result = mysqli_query($con,$update_sql);
          if(!$update_result) {
            alert("Sorry. Try again later !");
          }
          else {
            alert("Password Updated !");
          }
        }
      }
      else {
        $author_check_data = mysqli_fetch_assoc($author_check_result);
        $author_id = $author_check_data['author_id'];

        $pasword_check = password_verify($old_password,$data['user_password']);
        if($pasword_check) {
          $update_sql = " UPDATE author, user
                          SET author.author_password = '{$str_new_pass}',
                          user.user_password = '{$str_new_pass}'
                          WHERE author_id = {$author_id}
                          AND user.user_email = '{$email}'";
  
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
    }
    else {
      alert("Try again Later!");
    }
  }

?>


<div class="container p-2">
  <div class="forms-container">
    <div class="left">
      <div class="form-title">
        <h4>Change Password</h4>
      </div>
      <div class="login-form-container">
        <form method="POST" class="login-form" id="change_pass_form">
          <div class="input-field">
            <input type="password" name="old_password" id="old_password" placeholder=" Old Password" autocomplete="off"
              required>
          </div>
          <div class="input-field">
            <input type="password" name="new_password" id="new_password" placeholder=" New Password" autocomplete="off"
              required>
          </div>
          <div class="input-field">
            <input type="password" name="confirm_new_password" id="confirm_new_password"
              placeholder=" Confirm New Password" autocomplete="off" required>
          </div>
          <div class="input-field">
            <button type="submit" name="submit">Login</button>
          </div>
        </form>
      </div>
      <div class="form-errors">
        <p class="errors" id="errors"></p>
      </div>
    </div>
  </div>
</div>

<script src="./assets/js/change-pass-validate.js"></script>

<?php
  require('./includes/footer.inc.php');
?>