<!DOCTYPE html>
<?php
// Start the session
session_start();
?>

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

<?php

function findNext($array, $curPos, $diff, $moreDifficulty)
{
    $counter = 0;
    $size    = count($array);
    
    $nextDifficulty = 0;
    
    if ($moreDifficulty) {
        switch ($diff) {
            case 1:
                $nextDifficulty = 2;
                break;
            case 2:
                $nextDifficulty = 3;
                break;
            case 3:
                $nextDifficulty = 3;
                break;
        }
    } else {
        switch ($diff) {
            case 1:
                $nextDifficulty = 1;
                break;
            case 2:
                $nextDifficulty = 1;
                break;
            case 3:
                $nextDifficulty = 2;
                break;
        }
    }
    
    $curPos++;
    while ($counter < $size) {
        
        if ($curPos == $size)
            $curPos = 0;
        
        $element = $array[$curPos];
        if ($element->difficulty == $nextDifficulty)
            return $curPos;
        else {
            $counter++;
            $curPos++;
        }
    }
    return 0;
}

$question = $ans1 = $ans2 = $ans3 = $ans4 = $ans5 = "";

$_SESSION["flag1"] = true;
$_SESSION["flag2"] = false;
$_SESSION["flag3"] = false;
define("QUESTIONS", 5);
define("SAVE", "save");
define("NOT_SAVE", "not_save");


$finish       = false;
$answers      = array();
$nextTruthAns = 0;
$truthAns     = false;
$userAns      = false;
$difficulty   = 0;

if (isset($_GET['start'])) {
    $_SESSION["flag2"] = true;
    $_SESSION["flag1"] = false;
    
    $_SESSION["SCORE"]             = 0;
    $_SESSION["answers"]           = $answers;
    $_SESSION["CURRENT_ARRAY_POS"] = 0;
    
    $passedArray = array();
    $xml         = simplexml_load_file('questions.xml');
    foreach ($xml->note as $data) {
        $passedArray[] = $data;
    }
    shuffle($passedArray);
    $arraySize              = count($passedArray);
    $_SESSION["array_size"] = $arraySize;
    $_SESSION["array"]      = json_encode($passedArray);
    
    $arrayPosition              = 0;
    $_SESSION["array_position"] = $arrayPosition;
    
    $element = null;
    $size    = count($passedArray);
    $counter = 0;
    
    $position = findNext($passedArray, -1, 1, true);
    $element  = $passedArray[$position];
    
    $ans1         = $element->all_answers->answer[0];
    $ans2         = $element->all_answers->answer[1];
    $ans3         = $element->all_answers->answer[2];
    $ans4         = $element->all_answers->answer[3];
    $ans5         = $element->all_answers->answer[4];
    $question     = $element->question;
    $nextTruthAns = $element->answer;
    $difficulty   = $element->difficulty;
    
    $_SESSION["CURRENT_ARRAY_POS"] = $position;
}

if (isset($_POST['next']) || isset($_POST['finish'])) {
    $_SESSION["flag2"] = true;
    $_SESSION["flag1"] = false;
    
    $arraySize     = $_SESSION["array_size"];
    $arrayPosition = $_SESSION["array_position"];
    $answers       = $_SESSION["answers"];
    $arrayPosition++;
    $value           = "";
    $currentPosition = $_SESSION["CURRENT_ARRAY_POS"];
    $moreDifficulty;
    $currentScore = $_SESSION["SCORE"];
    
    if ($arrayPosition < QUESTIONS + 1) {
        
        $passedArray = json_decode($_SESSION["array"]);
        $truthAns    = $_POST["truthAns"];
        $userAns     = $_POST["ans"];
        $difficulty  = $_POST["difficulty"];
        
        $data        = new stdClass();
        $data->level = $difficulty;
        if ($truthAns == $userAns) {
            $data->answer   = true;
            $answers[]      = $data;
            $moreDifficulty = true;
            $currentScore += $difficulty;
        } else {
            $data->answer   = false;
            $answers[]      = $data;
            $moreDifficulty = false;
            
        }
        
        
        $position = findNext($passedArray, $currentPosition, $difficulty, $moreDifficulty);
        $element  = $passedArray[$position];
        // $_SESSION["array"] =  json_encode($passedArray);
        
        $ans1         = $element->all_answers->answer[0];
        $ans2         = $element->all_answers->answer[1];
        $ans3         = $element->all_answers->answer[2];
        $ans4         = $element->all_answers->answer[3];
        $ans5         = $element->all_answers->answer[4];
        $question     = $element->question;
        $nextTruthAns = $element->answer;
        $difficulty   = $element->difficulty;
        
        $_SESSION["array_position"]    = $arrayPosition;
        $_SESSION["CURRENT_ARRAY_POS"] = $position;
        $_SESSION["answers"]           = $answers;
        $_SESSION["SCORE"]             = $currentScore;
        
        if ($arrayPosition + 1 == QUESTIONS)
            $finish = true;
        
    } else {
        
    }
    
    if (isset($_POST['finish'])) {
        $_SESSION["flag3"] = true;
        $_SESSION["flag2"] = false;
    }
}

$succesfulSaveFlag = "";
if (isset($_POST['save'])) {
    
    $data           = new stdClass();
    $data->nickname = $_POST['nickname'];
    $data->score    = $_SESSION["SCORE"];
    $inp            = file_get_contents('results.json');
    
    $tempArray = json_decode($inp);
    if ($tempArray == null)
        $tempArray = array();
    array_push($tempArray, $data);
    $jsonData = json_encode($tempArray);
    if (file_put_contents('results.json', $jsonData)) $succesfulSaveFlag = SAVE;
    else $succesfulSaveFlag = NOT_SAVE;

}
?>


<nav class="navbar navbar-expand-md navbar-dark navbar_backround">
  <a class="navbar-brand" href="#">Quizzer</a>
  <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#collapsibleNavbar">
    <span class="navbar-toggler-icon"></span>
  </button>
  <div class="collapse navbar-collapse" id="collapsibleNavbar">
    <ul class="navbar-nav">
      <li class="nav-item">
        <a class="nav-link active" href="index.php">Home Page</a>
      </li>
      <li class="nav-item">
        <a class="nav-link" href="help.php">Help Page</a>
      </li>
      <li class="nav-item">
        <a class="nav-link" href="highscores.php">High Scores Page</a>
      </li>    
    </ul>
  </div>  
</nav>

<?php
if ($_SESSION["flag1"]) {
?>

<div>
  <div id="image_backround_container" class="container">

          <form action="<?php echo $_SERVER['PHP_SELF']; ?>" method="get">
          <div>
            <h1 id="welcome_message"><b>Welcome to quizzer!!</b></h1>
            <div >
      <?php if ($succesfulSaveFlag == SAVE) { ?>
        <div class="w3-panel w3-green w3-display-container" id="alert_message_success">
          <span onclick="this.parentElement.style.display='none'" class="w3-button w3-large w3-display-topright">&times;</span>
          <h3>Success!</h3>
          <p>Your score save success!!.</p>
        </div>
      <?php } else if ($succesfulSaveFlag == NOT_SAVE){?>
      <?php } ?>
  </div>
            <input type="submit"  value="Start Game" name="start">
          <div>
        </form>
  </div>

  
</div>
  
<?php }?>

<?php
if ($_SESSION["flag2"]) { ?>

<div id="image_backround_container" class="container">

    <form  method="post" action="<?php echo $_SERVER['PHP_SELF']; ?>">
   
      <input type="hidden"  name="truthAns" value = <?php echo $nextTruthAns; ?>>
      <input type="hidden"  name="difficulty" value = <?php echo $difficulty; ?>>

      <div class="row" >
        <div class="start_message"  style="text-align:right;">
        <span id="circle_word"><span><?php echo ($_SESSION["array_position"] + 1);?></span>
        <span><?php echo "/"; ?></span>
        <span><?php echo QUESTIONS ?></span></span>
        <span style="float:left;">
        <span><b>Question:</b><?php echo $question;?></b></span></p>
        </span>
        </div>
      </div>

      <div class="radio">
        <label><input type="radio" name="ans" checked value = 0><?php echo $ans1?></label>
      </div>

      <div class="radio">
        <label><input type="radio" name="ans" value = 1><?php echo $ans2?></label>
      </div>

      <div class="radio">
        <label><input type="radio" name="ans" value = 2><?php echo $ans3?></label>
      </div>

      <div class="radio">
        <label><input type="radio" name="ans" value = 3><?php echo $ans4?></label>
      </div>

      <div class="radio">
        <label><input type="radio" name="ans" value = 4><?php echo $ans5?></label>
      </div>
          
      <p class="row">
        <div class="column">       
          <?php if ($finish) { ?><input type="submit" id="finishButton" value="Finish" name="finish">
          <?php } else { ?> 
          <input type="submit" id="nextButton" value="Next" name="next">
          <?php } ?> <input type="submit" id="endButton" value="End Game">
      </p>
          
    </form>
</div>

<?php
}
?>

<?php
if ($_SESSION["flag3"]) {
?>

<div id="image_backround_container" class="container">

    <form  method="post" action="<?php echo $_SERVER['PHP_SELF']; ?>">
    <p class="row">
      <p class="start_message" ><b>Score</b></p>
    </p>
    <div class="table-responsive">
    <table id="table_body" class="table ">
      <thead>
        <tr id = "scores_row">
          <th>Question:</th>
          <th>Level</th>
          <th>Score</th>
        </tr>
      </thead>

      <tbody>

      <?php
    $counter = 0;
    $overallScore = 0;
    $answers = $_SESSION["answers"];
    foreach ($answers as $data) {
        if ($data->answer) { ?>
         <tr>
          <td><?php
            echo ++$counter; ?></td>
          <td><?php
            echo $data->level; ?></td>
          <td style="color:green">Success</td>
        </tr> 
      <?php } else { ?>
        <tr>
          <td><?php
            echo ++$counter; ?></td>
          <td><?php
            echo $data->level;?></td>
          <td style="color:red">Failed</td>
        </tr> 
      <?php
        } 
      }?>

      </tbody>

    </table>
    </div>

    <div class="row">
      <p>Your overall score: <?php echo $_SESSION["SCORE"] ?></p> 
    </div>

    <div class="row half_row">
      <input type="text" id="nickname" name="nickname" value="Your nickname:">    
    </div>

    <input type="submit" id="saveButton" value="Save" name="save">
    <input type="submit" id="returnButton" value="Exit" name="return">

    </form>

<?php
}
?>

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