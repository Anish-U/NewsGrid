<?php
  // Fetching all the Functions and DB Code
  require('./includes/functions.inc.php');
  require('./includes/database.inc.php');
  
  // Adding Composer Autoload
  require('./assets/vendor/autoload.php');

  // Creates a session or resumes the current one based on a session identifier. 
  session_start();
  
  // If user not logged in
  if(!isset($_SESSION['USER_LOGGED_IN'])) {

    // Redirected to login page along with a message
    alert('Please log in to Download Article');
    redirect('./user-login.php');
  }

  // If we dont get article_id from URL
  if(!isset($_GET['id'])) {

    // Redirect to home page
    redirect('./index.php');
  }

  // If we get article_id from URL and it is null
  elseif ($_GET['id'] == '') {
    
    // Redirect to home page
    redirect('./index.php');
  }

  // If we get article_id from URL and it is not null
  else {

    // Store the article_id in a variable
    $article_id = $_GET['id'];
  }
  

  // Article Query to fetch all the article data for respective article id
  $articleQuery = " SELECT *
                    FROM article
                    WHERE article_id = {$article_id} 
                    AND article_active = 1";
  
  // Running the Article Query
  $res = mysqli_query($con, $articleQuery);
  
  // Returns the number of rows from the result retrieved.
  $row = mysqli_num_rows($res);

  // If no article found with respectcive article id
  if($row == 0) {
    
    // Redirect to home page
    redirect('./index.php');
  }

  // If article found with respectcive article id
  if($row > 0){

    // Fetching the data of particular record as an Associative Array
    while($data=mysqli_fetch_assoc($res)){
      
      // Storing the article data in variables
      $article_title = $data['article_title'];
      $article_desc = $data['article_description'];
      $article_date = $data['article_date'];
      
      // Article date is updated to a timestamp 
      $article_date = strtotime($article_date);
      
      // HTML CODE for the PDF file
      $html = '
      <style>
        * {
          font-family: "Nunito Sans", sans-serif;
        }
        article {
          width: 85%;
          margin: auto;
        } 
        p {
          text-align: justify;
          font-size: 1rem;
          padding: 15px 5px;
          margin: 0.5rem 0;
        }
        h1 {
          font-size: 2.5rem;
          font-weight: 600;
          color: #333333;
          letter-spacing: -2px;
          font-family: "Montserrat", sans-serif;
        }
      </style>
      <article>
        <h1>'.$article_title.'</h1>
        <div> 
          <p>João José.<br><br>'.date("d M Y",$article_date).'</p>
        </div>
        <div>
          <p>
            '.nl2br($article_desc).'
          </p>
        </div>
      </article>';
    }
  }

  // Created an instance of the class Mpdf()
  $mpdf = new \Mpdf\Mpdf();

  // Specifying to show the watermark text
  $mpdf->showWatermarkText = true;
  
  // Setting Text to use as watermark
  $mpdf->SetWatermarkText('NewsGrid');

  // Specifying the font to use for watermark text
  $mpdf->watermark_font = 'DejaVuSans'; 

  // Specifying the transparency (alpha value) for the watermark text
  $mpdf->watermarkTextAlpha = 0.2;

  // Setting Footer including the page number
  $mpdf->setFooter('{PAGENO}');
  
  // Setting the PDF title
  $mpdf->SetTitle($article_title);

  // Writing HTML Boiler Plate already created
  $mpdf->WriteHTML($html);
  
  // Setting PDF file name
  $file = 'NewsGrid-NA'.$article_id.'-DT'.time().'.pdf';
  
  // Sends file inline to the browser
  $mpdf->output($file,'I');
?>