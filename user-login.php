<?php
  
  require('./includes/nav.inc.php');
  if(isset($_SESSION['USER_LOGGED_IN']) && $_SESSION['USER_LOGGED_IN'] == "YES") {
    redirect('./index.php');
  }
  if(isset($_POST['login-submit'])) {
    $loginEmail = get_safe_value($_POST['login-email']);
    $loginPassword = get_safe_value($_POST['login-password']);
    
    $loginQuery = " SELECT * FROM user 
                    WHERE user_email = '{$loginEmail}'
                    AND user_password = '{$loginPassword}'";
    
    $result = mysqli_query($con, $loginQuery);
    $rows = mysqli_num_rows($result);
    if($rows > 0) {
      while($data = mysqli_fetch_assoc($result)) {
        $_SESSION['USER_NAME'] = $data['user_name'];
        $_SESSION['USER_LOGGED_IN'] = "YES";
        $_SESSION['USER_ID'] = $data['user_id'];
        $_SESSION['USER_EMAIL'] = $data['user_email'];
      }  
      unset($_SESSION['AUTHOR_NAME']);
      unset($_SESSION['AUTHOR_LOGGED_IN']);
      unset($_SESSION['AUTHOR_ID']);
      unset($_SESSION['AUTHOR_EMAIL']);
      redirect('./index.php');
    }
    else {
      alert("Wrong Email or Password");
    }
  }

  if(isset($_POST['signup-submit'])) {
    echo $signupName = get_safe_value($_POST['signup-name']);
    echo $signupEmail = get_safe_value($_POST['signup-email']);
    echo $signupPassword = get_safe_value($_POST['signup-password']);
    
    $signupQuery = " INSERT INTO user 
                    (user_name, user_email, user_password) 
                    VALUES 
                    ('{$signupName}', '{$signupEmail}', '{$signupPassword}')";
    $result = mysqli_query($con, $signupQuery);
    if($result) {
      alert("Signup Successful, Please Login");
      redirect('./user-login.php');
    }
    else {
      echo "Error: ".mysqli_error($con);
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