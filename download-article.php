<?php
  require('./includes/functions.inc.php');
  require('./includes/database.inc.php');
  require('./assets/vendor/autoload.php');

  session_start();

  if(!isset($_GET['id'])) {
    redirect('./index.php');
  }
  elseif ($_GET['id'] == '') {
    redirect('./index.php');
  }
  else {
    $article_id = $_GET['id'];
  }
  if(!isset($_SESSION['USER_LOGGED_IN'])) {
    alert('Please log in to Download Article');
    redirect('./user-login.php');
  }

  $articleQuery = " SELECT *
                    FROM article
                    WHERE article_id = {$article_id}";
  
  $res = mysqli_query($con, $articleQuery);
  
  if(mysqli_num_rows($res)>0){


    
    while($data=mysqli_fetch_assoc($res)){
      $article_title = $data['article_title'];
      $article_desc = $data['article_description'];
      $article_date = $data['article_date'];
      $article_date = strtotime($article_date);
      
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
          font-size: 2rem;
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
    // echo $html;
  }else{
    redirect('index.php');
  }
  $mpdf=new \Mpdf\Mpdf();

  $mpdf->SetWatermarkText('NewsGrid');
  $mpdf->showWatermarkText = true;
  $mpdf->watermark_font = 'DejaVuSansCondensed'; 

  $mpdf->setFooter('{PAGENO}');
  $mpdf->WriteHTML($html);
  
  $file='NewsGrid-NA'.$article_id.'-DT'.time().'.pdf';
  $mpdf->output($file,'I');
?>