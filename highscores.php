<!DOCTYPE html>
<?php
// Start the session
session_start(); ?>

<html lang="en">
<head>
  <title>Home Page</title>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.1.3/css/bootstrap.min.css">
  <link rel="stylesheet" href="styles.css">
  <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
  <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.3/umd/popper.min.js"></script>
  <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.1.3/js/bootstrap.min.js"></script>
  <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css">
  <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js"></script>
  <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.4.2/css/all.css" integrity="sha384-/rXc/GQVaYpyDdyxK+ecHPVYJSN9bmVFBvjA/9eOB+pb3F2w2N6fc5qB9Ew5yIns"
        crossorigin="anonymous">
  <link rel="stylesheet" href="https://www.w3schools.com/w3css/4/w3.css">  
</head>
<body class="main_page_backround">

<nav class="navbar navbar-expand-md navbar-dark navbar_backround sticky-top">
  <a class="navbar-brand" href="#">Quizzer</a>
  <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#collapsibleNavbar">
    <span class="navbar-toggler-icon"></span>
  </button>
  <div class="collapse navbar-collapse" id="collapsibleNavbar">
    <ul class="navbar-nav">
      <li class="nav-item">
        <a class="nav-link" href="index.php">Home Page</a>
      </li>
      <li class="nav-item">
        <a class="nav-link" href="help.php">Help Page</a>
      </li>
      <li class="nav-item">
        <a class="nav-link active" href="highscores.php">High Scores Page</a>
      </li>    
    </ul>
  </div>  
</nav>

<?php
  $inp = file_get_contents('results.json');
  $scores = json_decode($inp);
?>

<div id="image_backround_container" class="container high_scores_container">
<div class="align_right_top">
  <form  method="get" action="<?php echo $_SERVER['PHP_SELF']; ?>">

  <div class="row" >
    <div class="start_message">
     <p id="start_message"><b>Quizzer all scores</b></p>
    </div>
  </div>
  <table class="table table-hover" id="table_body">
    <thead>
      <tr id = "scores_row">
        <th><h2>Player Nickname</h2></th>
        <th><h2>Score</h2></th>
      </tr>
    </thead>

    <tbody>

    <?php
    $counter = 0;
    if (isset($_SESSION["answers"])) $answers = $_SESSION["answers"];
    if (isset($scores)){
      foreach ($scores as $data){?>
          <tr>
          <td><h2><?php echo $data->nickname ?></h2></td>
          <td><h2><?php echo $data->score ?></h2></td>
        </tr> 
        <?php } 
    }?>
    </tbody>

  </table>

  </form>
    </div>
</div>


<div class="footer" id="sc">
  <a href="#sc" class="fab fa-facebook social-media social_icon" id="circle_fb"></a>
  <a href="#sc" class="fab fa-twitter social-media circle social_icon" id="circle_twit"></a>
  <a href="#sc" class="fab fa-instagram social-media circle social_icon" id="circle_insta"></a>
</div>

<div class="nav_right"> <a href="#top" class="fas fa-arrow-up" id="circle_icon_go_up"></a> </div>

</body>
</html>