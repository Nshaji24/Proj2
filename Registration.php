<link  rel="stylesheet" href="styles.css">
<nav> <ul id="nav_menu">
        <li><a class="current" href="Login.html">Login</a></li>
        <li><a href="Questions_form.php">Post a Question</a></li>
        <li><a href="Registration.html">Register</a></li>&nbsp;
    </ul>
</nav>
<?php
require ('pdo.php');
$FirstNameReg = filter_input(INPUT_POST,'FirstName');
$LastNameReg =filter_input(INPUT_POST,'LastName');
$Birthday=filter_input(INPUT_POST,'Birthday');
$EmailReg=filter_input(INPUT_POST,'EmailReg');
$PassReg=filter_input(INPUT_POST,'PassReg' );
$PassRegERR ="";
$FirstNameERR="";
$LastNameERR ="";
$BirthdayERR ="";
$EmailERR="";
$Valid= true;

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    if (empty($_POST["FirstName"])) {
        $FirstNameERR = "Must enter a first name";
        $Valid=false;
    } else {
        $FirstNameReg = filter_input(INPUT_POST,'FirstName');

    }
    if (empty($_POST["LastName"])) {
        $LastNameERR = "Must enter a last name";
        $Valid=false;
    } else {
        $LastNameReg =filter_input(INPUT_POST,'LastName');
    }

    if (empty($_POST["Birthday"])) {
        $BirthdayERR = "Must enter a birthdate";
        $Valid=false;
    } else {
        $Birthday=filter_input(INPUT_POST,'Birthday');

    }
    if (empty($_POST["EmailReg"])) {
        $EmailRegERR = "Must enter a valid email";
        $Valid=false;
    } else {
        $EmailReg=filter_input(INPUT_POST,'EmailReg');
        if (!filter_var($EmailReg, FILTER_VALIDATE_EMAIL)) {
            $EmailERR = "ENTER A VALID EMAIL FORMAT";
            $Valid=false;
        }
    }


    if (empty($_POST["PassReg"])) {
        $PassRegERR = "Password is required";
        $Valid=false;
    } else if (strlen($PassReg) < 8) {
        $PassRegERR = "PASSWORD MUST BE AT LEAST 8 CHARACTERS";
        $Valid=false;
    } else {
        $PassReg=filter_input(INPUT_POST,'PassReg' );
    }

    if($Valid){
        try {
            $Birthday= new DateTime($Birthday);
            $query = 'INSERT INTO accounts
                (email, fname, lname, birthday,password)
              VALUES
                (:email, :fname, :lname , :birthday,:password)';
            $statement = $db->prepare($query);
            $statement->bindValue(':email', $EmailReg);
            $statement->bindValue(':fname', $FirstNameReg);
            $statement->bindValue(':lname', $LastNameReg);
            $statement->bindValue(':birthday', $Birthday->format('Y-m-d'));
            $statement->bindValue(':password', $PassReg);



            //   $statement->bindValue(':EmailReg', $EmailReg);
            //  $statement->bindValue(':PassReg', $PassReg);
            $statement->execute();
            $statement->closeCursor();


        } catch (Exception $error) {
            $error_messasge = $error->getMessage();
            echo "Error INSERTING into SQL: $error_messasge";
        }
    }
}

?>
<body>
<section>
<h2>Registration</h2>
<div >
    First Name: <?php echo $FirstNameReg ; ?>
    <span class="error"> <?php echo $FirstNameERR ;  ?> </span> <br>
</div>



<div>
    Last Name: <?php echo $LastNameReg;?>
    <span class="error"> <?php echo $LastNameERR ;  ?> </span><br>

</div>

<div>
    Birthday:<?php echo $Birthday;?>
    <span class="error"> <?php echo $BirthdayERR ;  ?> </span><br>
</div>

<div>
    Email:<?php echo $EmailReg; ?>
    <span class="error"> <?php echo $EmailERR ;  ?> </span><br>
</div>

<div>
    Password:<?php echo $PassReg ; ?>
    <span class="error"> <?php echo $PassRegERR ; ?> </span><br>
</div>
</section>
</body>