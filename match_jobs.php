<?php
session_start();
include "db.php";

/* CHECK LOGIN */
if(!isset($_SESSION['email'])){
    die("Please login first");
}

$email = $_SESSION['email'];

/* GET USER */
$user = mysqli_query($conn,
"SELECT * FROM users WHERE email='$email'");

$u = mysqli_fetch_assoc($user);
$user_id = $u['id'];

/* GET RESUME */
$res = mysqli_query($conn,
"SELECT * FROM resumes
WHERE user_id='$user_id'
ORDER BY id DESC LIMIT 1");
?>

<!DOCTYPE html>
<html>
<head>
<title>Resume Jobs</title>

<style>
body{
margin:0;
font-family:Arial;
background:#0f2027;
color:white;
padding:30px;
}

h1{text-align:center;}

.box{
background:white;
color:black;
padding:20px;
margin:10px 0;
border-radius:10px;
}

.match{
background:green;
color:white;
padding:5px 10px;
display:inline-block;
border-radius:20px;
}

.resume{
background:white;
color:black;
padding:15px;
border-radius:10px;
margin-bottom:20px;
}
</style>

</head>

<body>

<h1>Resume Related Jobs 🚀</h1>

<?php

/* ❌ NO RESUME */
if(mysqli_num_rows($res) == 0)
{
    echo "<h2>No Resume Found</h2>";
}
else
{
    $resume = mysqli_fetch_assoc($res);

    echo "<div class='resume'>
    <h3>Your Resume File</h3>
    <p>".$resume['file_path']."</p>
    </div>";

    /* USER SKILLS (SUPER SIMPLE FIX) */
    $userSkills = strtolower($resume['skills']);
    $userSkills = str_replace(["\n","|","•","-","/"], ",", $userSkills);
    $userSkills = str_replace(" ", "", $userSkills);
    $userSkills = explode(",", $userSkills);

    /* GET JOBS */
    $jobs = mysqli_query($conn,"SELECT * FROM jobs");

    $found = false;

    while($row = mysqli_fetch_assoc($jobs))
    {
        $jobSkills = strtolower($row['skills_required']);
        $jobSkills = str_replace(["\n","|","•","-","/"], ",", $jobSkills);
        $jobSkills = str_replace(" ", "", $jobSkills);
        $jobSkills = explode(",", $jobSkills);

        $match = array_intersect($jobSkills, $userSkills);

        if(count($match) > 0)
        {
            $found = true;

            echo "<div class='box'>";
            echo "<h2>".$row['title']."</h2>";
            echo "<p>Skills: ".$row['skills_required']."</p>";
            echo "<div class='match'>Matched</div>";
            echo "</div>";
        }
    }

    /* ❗ IF NO MATCH */
    if(!$found)
    {
        echo "<h2>No Matching Jobs Found</h2>";
    }
}
?>

</body>
</html>