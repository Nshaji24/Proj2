
<link  rel="stylesheet" href="styles.css">
<nav> <ul id="nav_menu">
        <li><a class="current" href="Login.html">Login</a></li>
        <li><a href="Questions_form.php">Post a Question</a></li>
        <li><a href="Registration.html">Register</a></li>&nbsp;
    </ul>
</nav>
<?php
require ('pdo.php');

$Email = filter_input(INPUT_POST,'Email');
$Password = filter_input(INPUT_POST,'Password') ;
$EmailERR="";
$PassERR ="";
$Valid= true;

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    if (empty($_POST["Email"])) {
        $EmailERR = "Enter a valid Email Address";
        $Valid= false;
    } else {
        $Email = filter_input(INPUT_POST,'Email');

        if (!filter_var($Email, FILTER_VALIDATE_EMAIL)) {
            $EmailERR = "ENTER A VALID EMAIL FORMAT";
            $Valid= false;
        }

    }
    if (empty($_POST["Password"])) {
        $PassERR = "Password is required";
        $Valid= false;
    } else if (strlen($Password) < 4) {
        $PassERR = "PASSWORD MUST BE AT LEAST 8 CHARACTERS";
        $Valid= false;
    } else {
        $Password = filter_input(INPUT_POST,'Password') ;
    }

    if($Valid){

        $userId = validate_login($Email,$Password);
        if(!$userId){
            echo 'login attempt failed';
        }else{
            header("Location: display_questions.php?userId=$userId");
        }

    }else{
        echo 'Invalid Form';
    }



}
    function validate_login($Email,$Password){
    global $db;
    $query='SELECT * FROM accounts WHERE email=:email AND password = :password';
    $statement = $db->prepare($query);
    $statement->bindValue(':email',$Email);
    $statement->bindValue(':password',$Password);
    $statement->execute();
    $user= $statement->fetch();
    $isValidLogin= count($user)>0;
    if(!$isValidLogin){
        $statement->closeCursor();
        return false;
    }else{
        $userId=$user['id'];
        $statement->closeCursor();
        return $userId;
    }

    }
    ?>
<body>
<section >
<h2>Login Form</h2>
<div>
    Email : <?php echo $Email; ?>
    <span class="error">* <?php echo $EmailERR ;  ?> </span>
</div>
<div>
    Password: <?php echo $Password; ?>
    <span class="error">* <?php echo $PassERR;?></span>
</div>
</section>
</body>