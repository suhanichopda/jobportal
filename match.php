<?php
include "db.php";

$user_id = $_GET['uid'];

$resume = mysqli_fetch_assoc(mysqli_query($conn,
"SELECT * FROM resumes WHERE user_id='$user_id'"));

$userSkills = explode(",", $resume['skills']);

$jobs = mysqli_query($conn, "SELECT * FROM jobs");

while ($job = mysqli_fetch_assoc($jobs)) {

    $jobSkills = explode(",", $job['skills_required']);

    $match = count(array_intersect($userSkills, $jobSkills));
    $score = ($match / count($jobSkills)) * 100;

    echo "<h3>{$job['title']}</h3>";
    echo "Match Score: $score %<br>";

    if ($score > 60) {
        echo "🔥 Recommended Job<br><br>";
    }
}
?>