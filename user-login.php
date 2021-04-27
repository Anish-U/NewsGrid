<?php
  require('./includes/nav.inc.php');
  if(isset($_SESSION['USER_LOGGED_IN']) && $_SESSION['USER_LOGGED_IN'] == "YES") {
    redirect('./index.php');
  }
  if(isset($_POST['login-submit'])) {
    $loginEmail = get_safe_value($_POST['login-email']);
    $loginPassword = get_safe_value($_POST['login-password']);
    
    $loginQuery = " SELECT * FROM user 
                    WHERE user_email = '{$loginEmail}'";
    
    $result = mysqli_query($con, $loginQuery);
    $rows = mysqli_num_rows($result);
    if($rows > 0) {
      while($data = mysqli_fetch_assoc($result)) {
        $password_check = password_verify($loginPassword, $data['user_password']);
        if($password_check) {

          $_SESSION['USER_NAME'] = $data['user_name'];
          $_SESSION['USER_LOGGED_IN'] = "YES";
          $_SESSION['USER_ID'] = $data['user_id'];
          $_SESSION['USER_EMAIL'] = $data['user_email'];

          unset($_SESSION['AUTHOR_NAME']);
          unset($_SESSION['AUTHOR_LOGGED_IN']);
          unset($_SESSION['AUTHOR_ID']);
          unset($_SESSION['AUTHOR_EMAIL']);
          redirect('./index.php');
        }
        else {
          alert("Wrong Password");
          redirect('./user-login.php');
        }
      }     
    }
    else {
      alert("This Email is not registered. Please Register");
      redirect('./user-login.php');
    }
  }

  if(isset($_POST['signup-submit'])) {
    $signupName = get_safe_value($_POST['signup-name']);
    $signupEmail = get_safe_value($_POST['signup-email']);
    $signupPassword = get_safe_value($_POST['signup-password']);
    $strg_pass = password_hash($signupPassword,PASSWORD_BCRYPT);
    
    $check_sql = "SELECT user_email FROM user 
                  WHERE user_email = '{$signupEmail}'";
    $check_result = mysqli_query($con,$check_sql);
    $check_row = mysqli_num_rows($check_result);
    
    if($check_row > 0) {
      alert("Email Already Exists");
      redirect('./user-login.php');
    }
    else {
      $signupQuery = "INSERT INTO user 
                      (user_name, user_email, user_password) 
                      VALUES 
                      ('{$signupName}', '{$signupEmail}', '{$strg_pass}')";
      $result = mysqli_query($con, $signupQuery);
      if($result) {
        alert("Signup Successful, Please Login");
        redirect('./user-login.php');
      }
      else {
        echo "Error: ".mysqli_error($con);
      }
    }
  }
?>


<div class="container p-2">
  <div class="forms-container">
    <div class="left">
      <div class="form-title">
        <h4>User Login</h4>
      </div>
      <div class="login-form-container">
        <form method="POST" class="login-form" id="login-form">
          <div class="input-field">
            <input type="email" name="login-email" id="login-email" placeholder=" Email Address" autocomplete="off"
              required>
          </div>
          <div class="input-field">
            <input type="password" name="login-password" id="login-password" placeholder=" Password" autocomplete="off"
              required>
          </div>
          <div class="input-field">
            <button type="submit" name="login-submit">Login</button>
          </div>
        </form>
      </div>
      <div class="form-errors">
        <p class="errors" id="login-errors"></p>
      </div>
    </div>
    <div class="right">
      <div class="form-title">
        <h4>User Signup</h4>
      </div>
      <div class="signup-form-container">
        <form method="POST" class="signup-form" id="signup-form">
          <div class="input-field">
            <input type="text" name="signup-name" id="signup-name" placeholder=" Name" autocomplete="off" required>
          </div>
          <div class="input-field">
            <input type="email" name="signup-email" id="signup-email" placeholder=" Email Address" autocomplete="off"
              required>
          </div>
          <div class="input-field">
            <input type="password" name="signup-password" id="signup-password" placeholder=" Password"
              autocomplete="off" required>
          </div>
          <div class="input-field">
            <input type="password" name="signup-confirm-password" id="signup-confirm-password"
              placeholder=" Confirm Password" autocomplete="off" required>
          </div>
          <div class="input-field">
            <button type="submit" name="signup-submit">Signup</button>
          </div>
        </form>
      </div>
      <div class="form-errors d-flex">
        <p class="errors" id="signup-errors">
          Password must be 6 to 20 characters long with aleast 1 number, 1 uppercase and 1 lowecase
        </p>
      </div>
    </div>
  </div>
</div>

<script src="./assets/js/form-validate.js"></script>

<?php
  require('./includes/footer.inc.php');
?>