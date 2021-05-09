<?php
  // Fetching all the Navbar Data
  require('./includes/nav.inc.php');
  
  // Checking if the Author is logged in already
  if(isset($_SESSION['AUTHOR_LOGGED_IN']) && $_SESSION['AUTHOR_LOGGED_IN'] == "YES") {
    
    // Redirected to author dashboard
    redirect('./author/index.php');
  }

  // Whenever login button is pressed
  if(isset($_POST['login-submit'])) {
    
    // Fetching values via POST and passing them to user defined function 
    // to get rid of special characters used in SQL
    $loginEmail = get_safe_value($_POST['login-email']);
    $loginPassword = get_safe_value($_POST['login-password']);
    
    // Login Query to check if the email submitted is present or registered
    $loginQuery = " SELECT * FROM author 
                    WHERE author_email = '{$loginEmail}'";
    
    // Running the Login Query
    $result = mysqli_query($con, $loginQuery);
    
    // Returns the number of rows from the result retrieved.
    $rows = mysqli_num_rows($result);
    
    // If query has any result (records) => If any user with the email exists
    if($rows > 0) {
      
      // Fetching the data of particular record as an Associative Array
      while($data = mysqli_fetch_assoc($result)) {
        
        // Verifing whether the password matches the hash from DB
        $password_check = password_verify($loginPassword, $data['author_password']);
        
        // If password matches with the data from DB
        if($password_check) {

          // Setting author specific session variables
          $_SESSION['AUTHOR_NAME'] = $data['author_name'];
          $_SESSION['AUTHOR_LOGGED_IN'] = "YES";
          $_SESSION['AUTHOR_ID'] = $data['author_id'];
          $_SESSION['AUTHOR_EMAIL'] = $data['author_email'];

          // Unsetting all the user specific session variables
          unset($_SESSION['USER_NAME']);
          unset($_SESSION['USER_LOGGED_IN']);
          unset($_SESSION['USER_ID']);
          unset($_SESSION['USER_EMAIL']);
          
          // Redirected to author dashboard
          redirect('./author/index.php');
        }

        // If the password fails to match
        else {
          
          // Redirected to login page along with a message
          alert("Wrong Password");
          redirect('./author-login.php');
        }
      }     
    }
    
    // If the email is not registered 
    else {
      
      // Redirected to signup page along with a message
      alert("This Email is not registered. Please Register");
      redirect('./author-login.php');
    }
  }

  // Whenever signup button is pressed
  if(isset($_POST['signup-submit'])) {
    
    // Fetching values via POST and passing them to user defined 
    // function to get rid of special characters used in SQL
    $signupName = get_safe_value($_POST['signup-name']);
    $signupEmail = get_safe_value($_POST['signup-email']);
    $signupPassword = get_safe_value($_POST['signup-password']);

    // Check Query to check if the email submitted is present or registered already
    $check_sql = "SELECT author_email FROM author 
                  WHERE author_email = '{$signupEmail}'";
    
    // Running the Check Query
    $check_result = mysqli_query($con,$check_sql);
    
    // Returns the number of rows from the result retrieved.
    $check_row = mysqli_num_rows($check_result);
  
    // If query has any result (records) => If any author with the email exists
    if($check_row > 0) {
      
      // Redirecting to the login page along with a message
      alert("Email Already Exists");
      redirect('./author-login.php');
    }
    
    // If the query has no records => No author with the email exists (New Author)
    else {

      // Check User Query if the email is present as a user
      $check_user_sql = "SELECT user_email FROM user 
                         WHERE user_email = '{$signupEmail}'";
      
      // Running Check User Query
      $check_user_result = mysqli_query($con,$check_user_sql);
      
      // Returns the number of rows from the result retrieved.
      $check_user_row = mysqli_num_rows($check_user_result);
      
      // Creating new password hash using a strong one-way hashing algorithm => CRYPT_BLOWFISH algorithm
      $strg_pass = password_hash($signupPassword,PASSWORD_BCRYPT);
      
      // If query has any result (records) => If any user with the email exists
      if($check_user_row > 0) {
        
        // Signup Query Author to insert values into the DB
        $signupQueryAuthor = "INSERT INTO author 
                              (author_name, author_email, author_password) 
                              VALUES 
                              ('{$signupName}', '{$signupEmail}', '{$strg_pass}')";
        
        // Running the Signup Query Author
        $author_result = mysqli_query($con, $signupQueryAuthor);
        
        // Signup Query User to updating password into the DB
        $signupQueryUser = "UPDATE user 
                            SET user_name = '{$signupName}',
                            user_password = '{$strg_pass}'
                            WHERE user_email = '{$signupEmail}'";
        
        // Running the Signup Query User
        $user_result = mysqli_query($con, $signupQueryUser);
        
        //If both Queries ran successfully
        if($author_result && $user_result) {
          
          // Redirected to login page with a message
          alert("Author Signup Successful, Please Login");
          redirect('./author-login.php');
        }
        
        // If the Query failed
        else {
         
          // Print the error
          echo "Error: ".mysqli_error($con);
        }
      }
      
      // If the query has no records => No user with the email exists (New User)
      else {

        // Signup Query Author to insert values into the DB
        $signupQueryAuthor = "INSERT INTO author 
                              (author_name, author_email, author_password) 
                              VALUES 
                              ('{$signupName}', '{$signupEmail}', '{$strg_pass}')";
        
        // Running the Signup Query Author
        $author_result = mysqli_query($con, $signupQueryAuthor);
        
        // Signup Query User to insert values into the DB
        $signupQueryUser = "INSERT INTO user 
                            (user_name, user_email, user_password) 
                            VALUES 
                            ('{$signupName}', '{$signupEmail}', '{$strg_pass}')";
        
        // Running the Signup Query User
        $user_result = mysqli_query($con, $signupQueryUser);
        
        //If both Queries ran successfully
        if($user_result && $author_result) {
        
          // Redirected to login page with a message
          alert("Author and User Signup Successful, Please Login");
          redirect('./author-login.php');
        }
        // If the Query failed
        else {

          // Print the error
          echo "Error: ".mysqli_error($con);
        }
      }
    }
  }
?>


<div class="container p-2">
  <!-- Container to store two form divs -->
  <div class="forms-container">
    <!-- Left div for login -->
    <div class="left">
      <div class="form-title">
        <h4>Author Login</h4>
      </div>
      <div class="login-form-container">
        <!-- Form for Login -->
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
      <!-- Div to display the errors from the Login form -->
      <div class="form-errors d-flex">
        <p class="errors" id="login-errors"></p>
      </div>
    </div>
    <!-- Right div for Signup -->
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
      <!-- Div to display the errors from the Signup form -->
      <div class="form-errors d-flex">
        <p class="errors" id="signup-errors">
          Password must be 6 to 20 characters long with aleast 1 number, 1 uppercase and 1 lowecase
        </p>
      </div>
    </div>
  </div>
</div>

<!-- Script for form Validation -->
<script src="./assets/js/form-validate.js"></script>

<?php

  // Fetching all the Footer Data
  require('./includes/footer.inc.php');
?>