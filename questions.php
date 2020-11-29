<link  rel="stylesheet" href="styles.css">
<nav> <ul id="nav_menu">
        <li><a class="current" href="Login.html">Login</a></li>
        <li><a href="Questions_form.php">Post a Question</a></li>
        <li><a href="Registration.html">Register</a></li>&nbsp;
    </ul>
</nav>
<?php
require ('pdo.php');
$NameQuestion = filter_input(INPUT_POST,'NameQuestion' );
$TextBox=filter_input(INPUT_POST,'TextBox' );
$Skills=filter_input(INPUT_POST,'Skills');
$ownerid=filter_input(INPUT_POST,'ownerid');
$NameQuestionERR="";

$TextBoxERR="";
$Valid=true;

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    if (empty($_POST["NameQuestion"])) {
        $NameQuestionERR = "PLEASE ENTER QUESTION";
        $Valid=false;
    } else if (strlen($NameQuestion) < 3) {
        $NameQuestionERR = "MUST BE AT LEAST 3 CHARACTERS";
        $Valid=false;
    } else {
        $NameQuestion = filter_input(INPUT_POST,'NameQuestion' );
    }


    if (empty($_POST[$TextBox])) {
        $TextBoxERR = "MUST ENTER TEXT ";

    } else if (strlen($TextBox) > 500) {
        $TextBoxERR = "MUST BE AT UNDER 500 CHARACTERS";
        $Valid=false;
    } else {
        $TextBox = $_POST["TextBox"];
    }
}

if($Valid){
    try {

        $query = 'INSERT INTO questions
                (title, body, skills,ownerid)
              VALUES
                (:title, :body, :skills, :ownerid)';
        $statement = $db->prepare($query);
        $statement->bindValue(':title', $NameQuestion);
        $statement->bindValue(':body', $TextBox);
        $statement->bindValue(':skills', $Skills);
        $statement->bindValue(':ownerid', $ownerid);

        $statement->execute();
        $statement->closeCursor();


    } catch (Exception $error) {
        $error_messasge = $error->getMessage();
        echo "Error INSERTING into SQL: $error_messasge";
    }
}



function get_users_questions($userID){
    global $db;

    $query= 'SELECT * FROM questions WHERE ownerid= :userID';
    $statement= $db->prepare($query);
    $statement->bindValue(':userID',$userID);
    $statement->execute();

    $questions = $statement->fetchAll();
    $statement->closeCursor();
    return $questions;
}
function create_question($title, $body,$skills,$ownerid){
    global $db;

    $query= 'INSERT INTO questions
                  (title,body,skills,ownerid)
                  VALUES(:title,:body,:skills,:ownerid)';
    $statement = $db->prepare($query);
    $statement->bindValue('title',$title);
    $statement->bindValue('body',$body);
    $statement->bindValue('skills',$skills);
    $statement->bindValue('ownerid',$ownerid);
    $statement->execute();
    $statement->closeCursor();
}
?>
<body>
<section class="testing">
    <h2>Question Form</h2>

    Question Name :<?php echo $NameQuestion ;?><br>
    <span class="error"> <?php echo $NameQuestionERR ; ?> </span><br>


    Question Body : <?php echo $TextBox ; ?><br>
    <span class="error"><?php echo $TextBoxERR; ?></span><br>

    Skills: <?php
$SkillsSTR=explode("," ,$Skills);
for($s = 0; $s < count($SkillsSTR); $s++) {
    echo " $s = $SkillsSTR[$s] <br />";
}
?>
</section>
</body>
