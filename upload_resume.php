<?php
session_start();
include "db.php";

$email = $_SESSION['email'];

/* GET USER */
$user = mysqli_query($conn,
"SELECT * FROM users WHERE email='$email'");

$u = mysqli_fetch_assoc($user);

$user_id = $u['id'];

/* UPLOAD RESUME */
if(isset($_POST['upload']))
{
    $file = $_FILES['resume']['name'];
    $tmp = $_FILES['resume']['tmp_name'];

    $path = "uploads/".$file;

    move_uploaded_file($tmp,$path);

    /* SAVE ONLY FILE FIRST */
    mysqli_query($conn,
    "INSERT INTO resumes(user_id,file_path,skills)
    VALUES('$user_id','$file','')");

    echo "<script>
    alert('Resume Uploaded Successfully');
    window.location='upload_resume.php';
    </script>";
}

/* SAVE SKILLS */
if(isset($_POST['save_skills']))
{
    $skills = $_POST['skills'];

    mysqli_query($conn,
    "UPDATE resumes
    SET skills='$skills'
    WHERE user_id='$user_id'
    ORDER BY id DESC
    LIMIT 1
    ");

    echo "<script>
    alert('Skills Saved Successfully');
    window.location='match_jobs.php';
    </script>";
}
?>

<!DOCTYPE html>
<html>
<head>

<title>Upload Resume</title>

<style>

body{
margin:0;
font-family:Arial;
background:linear-gradient(135deg,#1e3c72,#2a5298,#0f2027);
height:100vh;
display:flex;
justify-content:center;
align-items:center;
}

.box{
background:white;
padding:40px;
border-radius:20px;
width:450px;
text-align:center;
box-shadow:0px 0px 25px rgba(0,0,0,0.5);
}

h2{
color:#1e3c72;
margin-bottom:20px;
}

input,textarea{
width:95%;
padding:12px;
margin-top:12px;
border:1px solid #ccc;
border-radius:10px;
}

button{
width:100%;
padding:12px;
margin-top:15px;
border:none;
background:black;
color:white;
cursor:pointer;
border-radius:10px;
transition:0.3s;
}

button:hover{
background:green;
}

.section{
margin-bottom:20px;
padding-bottom:20px;
border-bottom:1px solid #ddd;
}

.small{
font-size:13px;
color:gray;
margin-top:10px;
}

</style>

</head>

<body>

<div class="box">

<h2>Resume Upload System</h2>

<!-- RESUME UPLOAD -->
<div class="section">

<form method="POST" enctype="multipart/form-data">

<input type="file" name="resume" required>

<button name="upload">
Upload Resume
</button>

</form>

</div>

<!-- SKILLS INPUT -->
<div class="section">

<form method="POST">

<textarea name="skills"
placeholder="Enter Resume Related Skills
Example: PHP, Java, HTML, CSS"
required></textarea>

<button name="save_skills">
Enter Resume Related Skills
</button>

</form>

</div>

<div class="small">

Step 1: Upload Resume  
Step 2: Enter Skills  
Step 3: Get Matching Jobs

</div>

</div>

</body>
</html>