<?php
include "db.php";
session_start();

if (isset($_POST['post'])) {

    $title = $_POST['title'];
    $skills = $_POST['skills'];
    $lang = $_POST['language'];

    $emp_id = $_SESSION['user']['id'];

    mysqli_query($conn, "INSERT INTO jobs(employer_id,title,skills_required,language_required)
    VALUES('$emp_id','$title','$skills','$lang')");

    echo "Job Posted";
}
?>

<form method="POST">
    <input name="title" placeholder="Job Title"><br>
    <input name="skills" placeholder="PHP, MySQL"><br>
    <input name="language" placeholder="English"><br>
    <button name="post">Post Job</button>
</form>