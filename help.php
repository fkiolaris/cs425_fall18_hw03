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

<nav class="navbar navbar-expand-md navbar-dark navbar_backround">
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
        <a class="nav-link active" href="help.php">Help Page</a>
      </li>
      <li class="nav-item">
        <a class="nav-link" href="highscores.php">High Scores Page</a>
      </li>    
    </ul>
  </div>  
</nav>

  <div class="container" id="image_backround_container">

  <div class="help">
    <div>
      <h2>HOME PAGE</h2>
      <div class="row">
        <div class="col-50 help_data_format">START GAME:</div>
        <div class="col-50 help_description">Press this button to start the game</div>
      </div>
      <br>
      <div class="row">
        <div class="col-50 help_data_format">NEXT:</div>
        <div class="col-50 help_description">Press this button to move to the next question</div>
      </div>
      <br>
      <div class="row">
        <div class="col-50 help_data_format">EXIT:</div>
        <div class="col-50 help_description">Press this button to clsoe the game</div>
      </div>
      <br>
      <div class="row"> 
        <div class="col-50 help_data_format">FINISH:</div>
        <div class="col-50 help_description">Press this button in last question to finish the game</div>
      </div>
      <br>
      <div class="row">
        <div class="col-50 help_data_format">SAVE:</div>
        <div class="col-50 help_description">Press this button to save the your score with some nickname.</div>
      </div>
      <br>
      <div class="row">
        <div class="col-50 help_data_format">END GAME:</div>
        <div class="col-50 help_description">Press this button to end the game.</div>          
      </div>
    </div>

    <div>
      <h2>HIGH SCORE PAGE</h2>
      <div class="row">
        <div class="col-50 help_data_format">Description:</div>
        <div class="col-50 help_description">Shows the scores of users.</div>          
      </div>
    </div>
  </div>
</div>


</body>
</html>