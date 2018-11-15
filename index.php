<!DOCTYPE html>
<?php
// Start the session
session_start(); ?>

<html lang="en">
<head>
  <title>Bootstrap Example</title>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.1.3/css/bootstrap.min.css">
  <link rel="stylesheet" href="styles.css">
  <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
  <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.3/umd/popper.min.js"></script>
  <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.1.3/js/bootstrap.min.js"></script>
</head>
<body class="main_page_backround">


<?php

function findNext($array, $curPos, $diff, $moreDifficulty){
  $counter = 0;
  $size = count($array);
  
  $nextDifficulty = 0;
    //    echo "<script>";
    //  echo "alert($diff);";
    //  echo "</script>";

  if ($moreDifficulty) {
    switch($diff){
      case 1: $nextDifficulty = 2;
      break;
      case 2: $nextDifficulty = 3; 
      break;
      case 3: $nextDifficulty = 3;  
      break;
    }
  }else{
    switch($diff){
      case 1: $nextDifficulty = 1;
      break;
      case 2: $nextDifficulty = 1; 
      break;
      case 3: $nextDifficulty = 2;  
      break;
    }
  }

  $curPos ++;
  while ($counter < $size){

    if ($curPos == $size) $curPos = 0;
    
    $element = $array[$curPos];
    if ( $element->difficulty == $nextDifficulty) return $curPos;
    else {
      $counter ++;
      $curPos ++ ;
    }
  }
  return 0;
}

$question = $ans1 = $ans2 = $ans3 = $ans4 = $ans5 = "";

$_SESSION["flag1"] =  true;
$_SESSION["flag2"] =  false;
$finish = false;
$answers = array();
$nextTruthAns = 0;
$truthAns = false;
$userAns = false;
$difficulty = 0;

if (isset($_GET['start'])) {
  $_SESSION["flag1"] =  false;
  $_SESSION["flag2"] =  true;
  $_SESSION["answers"] = $answers;
  $_SESSION["CURRENT_ARRAY_POS"] = 0;

  $passedArray = array();
  $xml = simplexml_load_file('questions.xml');
  foreach ($xml->note as $data){
    $passedArray[] = $data;
  }
  shuffle($passedArray);
  $arraySize = count($passedArray);
  $_SESSION["array_size"] = $arraySize;
  $_SESSION["array"] =  json_encode($passedArray);

  $arrayPosition = 0;
  $_SESSION["array_position"] = $arrayPosition;

  $element = null;
  $size = count($passedArray);
  $counter = 0;

  $position = findNext($passedArray, -1, 1, true);
  $element = $passedArray[$position];

  $ans1 = $element->all_answers->answer[0];
  $ans2 = $element->all_answers->answer[1];
  $ans3 = $element->all_answers->answer[2];
  $ans4 = $element->all_answers->answer[3];
  $ans5 = $element->all_answers->answer[4];
  $question = $element->question;
  $nextTruthAns = $element->answer;
  $difficulty = $element->difficulty;

  $_SESSION["CURRENT_ARRAY_POS"] = $position;
  // $_SESSION["difficulty"] = $difficulty;
}

if (isset($_POST['next'])) {
  $_SESSION["flag1"] =  false;
  $_SESSION["flag2"] =  true;
  $arraySize = $_SESSION["array_size"];
  $arrayPosition =  $_SESSION["array_position"];
  $answers = $_SESSION["answers"];
  $arrayPosition ++;
  $value = "";
  $currentPosition = $_SESSION["CURRENT_ARRAY_POS"];
  $moreDifficulty;

  if ($arrayPosition < 9){
    
    $passedArray = json_decode($_SESSION["array"]);
    $truthAns = $_POST["truthAns"];
    $userAns = $_POST["ans"];
    $difficulty = $_POST["difficulty"];
  
    if ($truthAns == $userAns){
       $answers[] = true;
       $moreDifficulty = true;
    //   echo "<script>";
    //  echo "alert('TRUE');";
    //  echo "</script>";
      $answers[] = true;
     }
     else{
       $answers[] = false;
       $moreDifficulty = false;

     }
 

    $position = findNext($passedArray, $currentPosition, $difficulty, $moreDifficulty);
    $element = $passedArray[$position];
    // $_SESSION["array"] =  json_encode($passedArray);

    $ans1 = $element->all_answers->answer[0];
    $ans2 = $element->all_answers->answer[1];
    $ans3 = $element->all_answers->answer[2];
    $ans4 = $element->all_answers->answer[3];
    $ans5 = $element->all_answers->answer[4];
    $question = $element->question;
    $nextTruthAns = $element->answer;
    $difficulty = $element->difficulty;
   
    $_SESSION["array_position"] = $arrayPosition;
    $_SESSION["CURRENT_ARRAY_POS"] = $position;

    if ($arrayPosition + 1 == 9) $finish = true;

  }else{
    
  }
}
?>


<nav class="navbar navbar-expand-md bg-dark navbar-dark">
  <a class="navbar-brand" href="#">Navbar</a>
  <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#collapsibleNavbar">
    <span class="navbar-toggler-icon"></span>
  </button>
  <div class="collapse navbar-collapse" id="collapsibleNavbar">
    <ul class="navbar-nav">
      <li class="nav-item">
        <a class="nav-link" href="#">Home Page</a>
      </li>
      <li class="nav-item">
        <a class="nav-link" href="#">Help Page</a>
      </li>
      <li class="nav-item">
        <a class="nav-link" href="#">High Scores Page</a>
      </li>    
    </ul>
  </div>  
</nav>
<br>

<?php
if ($_SESSION["flag1"]) {
?>

<div class="container">
  
  <div class = "container_backround pagination-centered text-center" >
  <h1 id="welcome_message"><b>Welcome to quizzer!!</b></h1>
    <form action="<?php echo $_SERVER['PHP_SELF']; ?>" method="get">
      <input type="submit" id="startButton" value="Start Game" name="start">
    </form>
  </div>
</div>
<?php
}
?>


<?php
if ($_SESSION["flag2"]) {
?>

<div id="container_position" class="container container_backround">
  <div>
  <h1 id="start_message"><b>Game is started</b></h1>
    <!-- <button id="startButton">Start Game</button> -->
    <form  method="post" action="<?php echo $_SERVER['PHP_SELF']; ?>">
      <div class="row">
      <h2 name="quest"><?php echo $question ?></h2>
      <div class="align_right_top">
        <span><?php echo ($_SESSION["array_position"] +1 ); ?></span>
      <span><?php echo "/" ?></span>
      <span><?php echo $_SESSION["array_size"]; ?></span>
    </div>
    </div>
      <input type="hidden"  name="truthAns" value = <?php echo $nextTruthAns ?>>
      <input type="hidden"  name="difficulty" value = <?php echo $difficulty ?>>
      <div class="row">
      <div class="col-25">
      <input type="radio" id="radio1" name="ans" value = 0 checked >
      <label for=radio1 ><?php echo $ans1 ?></label>
      </div>

    </div>

    <div class="row">
    <div class="col-25">
      <input type="radio" id="radio2" name="ans" value = 1>     
      <label for=radio2 ><?php echo $ans2 ?></label>
      </div>
    </div>

    <div class="row">
    <div class="col-25">
      <input type="radio" id="radio3" name="ans" value = 2>
      <label for=radio3 ><?php echo $ans3 ?></label>
      </div>
    </div>

    <div class="row">
    <div class="col-25">
      <input type="radio" id="radio4" name="ans"  value = 3>
      <label for=radio4 ><?php echo $ans4 ?></label>
      </div>
    </div>

        <div class="row">
        <div class="col-25">
      <input type="radio" id="radio5" name="ans" value = 4>
      <label for=radio5 ><?php echo $ans5 ?></label>
      </div>
    </div>

    <div class="row">
    <input type="submit" id="endButton" value="End Game">
     
      <?php if ($finish) {  ?>
        <input type="submit" id="finishButton" value="Finish" name="finish">
      <?php } else { ?>
        <input type="submit" id="nextButton" value="Next" name="next">
      <?php } ?>
    </div>

    </form>
  </div>

<?php
}
?>

</div>
</div>

<?php  //   if ($truthAns == $userAns){
    //  echo "<script>";
    //  echo "alert('TRUE');";
    //  echo "</script>";
    //   $answers[] = true;
    // }
    // else{
    //   echo "<script>";
    //   echo "alert('FALSE');";
    //   echo "</script>";
    //   $answers[] = false;
 //   } ?>

</body>
</html>