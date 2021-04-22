<?php
  require('./includes/nav.inc.php');
  if(isset($_SESSION['AUTHOR_LOGGED_IN']) && $_SESSION['AUTHOR_LOGGED_IN'] == "YES") {
    redirect('./author/index.php');
  }
  if(isset($_POST['login-submit'])) {
    $loginEmail = get_safe_value($_POST['login-email']);
    $loginPassword = get_safe_value($_POST['login-password']);
    
    $loginQuery = " SELECT * FROM author 
                    WHERE author_email = '{$loginEmail}'
                    AND author_password = '{$loginPassword}'";
    
    $result = mysqli_query($con, $loginQuery);
    $rows = mysqli_num_rows($result);
    if($rows > 0) {
      while($data = mysqli_fetch_assoc($result)) {
        $_SESSION['AUTHOR_NAME'] = $data['author_name'];
        $_SESSION['AUTHOR_LOGGED_IN'] = "YES";
        $_SESSION['AUTHOR_ID'] = $data['author_id'];
        $_SESSION['AUTHOR_EMAIL'] = $data['author_email'];
      }
      unset($_SESSION['USER_NAME']);
      unset($_SESSION['USER_LOGGED_IN']);
      unset($_SESSION['USER_ID']);
      unset($_SESSION['USER_EMAIL']);
      redirect('./author/index.php');
    }
    else {
      alert("Wrong Email or Password");
    }
  }

  if(isset($_POST['signup-submit'])) {
    echo $signupName = get_safe_value($_POST['signup-name']);
    echo $signupEmail = get_safe_value($_POST['signup-email']);
    echo $signupPassword = get_safe_value($_POST['signup-password']);
    
    $signupQuery = " INSERT INTO author 
                    (author_name, author_email, author_password) 
                    VALUES 
                    ('{$signupName}', '{$signupEmail}', '{$signupPassword}')";
    $result = mysqli_query($con, $signupQuery);
    if($result) {
      alert("Signup Successful, Please Login");
      redirect('./author-login.php');
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
        <h4>Author Login</h4>
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
      <div class="form-errors d-flex">
        <p class="errors" id="login-errors"></p>
      </div>
    </div>
    <div class="right">
      <div class="form-title">
        <h4>Author Signup</h4>
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