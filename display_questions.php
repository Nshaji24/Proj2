<link  rel="stylesheet" href="styles.css">

<?php
require ('pdo.php');
$userId=filter_input(INPUT_GET,'userId');


function get_questions_by_ownerId($ownerId){
    global $db;
    $query = 'SELECT * FROM questions WHERE ownerId= :ownerId';

    $statement = $db->prepare($query);
    $statement->bindValue('ownerId',$ownerId);
    $statement->execute();
    $questions = $statement->fetchAll();
    $statement->closeCursor();
    return $questions;
}


$questions=get_questions_by_ownerId($userId);




?>
<nav> <ul id="nav_menu">
        <li><a class="current" href="Login.html">Login</a></li>
        <li><a href="Questions_form.php?userId=<?php echo $userId ; ?>">Add Question</a></li>
        <li><a href="Registration.html">Register</a></li>&nbsp;
    </ul>
</nav>
<a href="Questions_form.php?userId=<?php echo $userId ; ?>"Add Question></a>



<table>
    <tr>
        <th>Name</th>
        <th>Body</th>
    </tr>
    <?php foreach ($questions as $question): ?>
    <tr>
        <td> <?php echo $question['title'];?> </td>
        <td> <?php echo $question['body'];?> </td>
        <td> <?php echo $question['skills'];?> </td>

    </tr>
    <?php endforeach; ?>
</table>


