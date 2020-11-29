<?php
$userId=filter_input(INPUT_GET,'userId');
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <link  rel="stylesheet" href="styles.css">
    <meta charset="UTF-8">

</head>
<body>
<nav> <ul id="nav_menu">
    <li><a class="current" href="Login.html">Login</a></li>
    <li><a href="Questions_form.php">Post a Question</a></li>
    <li><a href="Registration.html">Register</a></li>&nbsp;
</ul>
</nav>
<form action="questions.php" method="post" >
    <input type="hidden" name="ownerid" value="<?php echo $userId; ?>">
<section id="Question" class="quest">
    <h1>Question Form</h1>
    <h3>Question name?</h3>
    <input type="text" name="NameQuestion"><br>
    <h3>Question Body</h3><br>
    <textarea name="TextBox" rows="4" cols="50"></textarea><br>
    <h3>Enter Skills</h3>
    <input type="text" name="Skills" id="Skills">  <br>
    <br>

    <br>

    <input type="submit" value="Submit" class="BTN">

</section>
</form>
</body>
</html>