<!--? ======== FOOTER ======== -->
<footer class="footer">
  <div class="footer-left">
    <a href="./index.php"><img src="./assets/images/logo_light.png" /></a>
    <p>
      Lorem ipsum dolor sit amet consectetur adipisicing elit. Esse ipsam
      doloremque error nisi voluptatem voluptas molestias fugiat nostrum
      rerum explicabo.
    </p>
    <div class="socials">
      <a href="#"><i class="fab fa-facebook"></i></a>
      <a href="#"><i class="fab fa-youtube"></i></a>
      <a href="#"><i class="fab fa-twitter"></i></a>
      <a href="#"><i class="fab fa-instagram"></i></a>
    </div>
  </div>
  <ul class="footer-right">
    <li>
      <h2>Quick Links</h2>
      <ul class="box">
        <li><a href="./index.php">Home</a></li>
        <li><a href="./categories.php">Categories</a></li>
        <li><a href="./bookmarks.php">Bookmarks</a></li>
        <li><a href="./search.php?trending=1">Trending</a></li>
      </ul>
    </li>
    <li>
      <h2>Categories</h2>
      <ul class="box">
        <?php
  	      $categoryQuery= " SELECT  category_id, category_name
                            FROM category 
                            ORDER BY RAND() LIMIT 3";

          $result = mysqli_query($con,$categoryQuery);

          $row = mysqli_num_rows($result);
          if($row > 0) {
          while($data = mysqli_fetch_assoc($result)) {

          $category_id = $data['category_id'];
          $category_name = $data['category_name'];
        ?>
        <li><a href="articles.php?id=<?php echo $category_id ?>"><?php echo $category_name ?></a></li>
        <?php  
              }
            }
          ?>
        <li><a href="./categories.php">More +</a></li>
      </ul>
    </li>
    <li>
      <h2>Join Us</h2>
      <ul class="box">
        <li>
          Lorem ipsum dolor sit amet consectetur adipisicing elit. Libero,
          incidunt.
        </li>
        <a href="./author-login.php" class="my-1 btn btn-secondary">Sign Up</a>
      </ul>
    </li>
  </ul>
  <div class="footer-bottom">
    <p>All Rights Reserved by &copy; NewsGrid <?php echo date("Y")?></p>
  </div>
</footer>

<!-- JQUERY SCRIPT -->
<script src="https://code.jquery.com/jquery-3.5.0.js"></script>

<!-- SCRIPT FOR BACK TO TOP BUTTON -->
<script src="../assets/js/back-to-top.js"></script>

<!-- SCRIPT FOR NAVBAR COLLAPSE -->
<script src="../assets/js/navbar-collapse.js"></script>
</body>

</html>