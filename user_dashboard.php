<?php
session_start();
include "db.php";

/* USER LOGIN CHECK */
if(!isset($_SESSION['email']))
{
    header("Location: login.php");
    exit;
}

/* USER DATA */
$email = $_SESSION['email'];

$user = mysqli_query($conn,
"SELECT * FROM users WHERE email='$email'");

$u = mysqli_fetch_assoc($user);

$user_id = $u['id'];

/* LAST UPLOADED RESUME */
$resumeFile = "";

$resume = mysqli_query($conn,
"SELECT * FROM resumes
WHERE user_id='$user_id'
ORDER BY id DESC LIMIT 1");

if(mysqli_num_rows($resume) > 0)
{
    $r = mysqli_fetch_assoc($resume);

    $resumeFile = $r['file_path'];
}
?>

<!DOCTYPE html>
<html>
<head>
<title>User Dashboard</title>

<style>

body{
margin:0;
font-family:Arial;

/* 🔥 NEW PROFESSIONAL BACKGROUND */
background: radial-gradient(circle at top left,#0f2027,#203a43,#2c5364);
color:white;
height:100vh;
overflow:hidden;
}

/* TOP */
.top{
display:flex;
justify-content:space-between;
align-items:center;
padding:20px 25px;
}

/* MENU */
.menu{
font-size:32px;
cursor:pointer;
font-weight:bold;
transition:0.3s;
}

.menu:hover{
transform:scale(1.1);
}

/* SIDEBAR */
.sidebar{
position:fixed;
top:0;
left:-260px;
width:260px;
height:100%;
background:white;
color:black;
transition:0.4s;
padding-top:70px;
z-index:1000;
box-shadow:0px 0px 20px rgba(0,0,0,0.4);
}

.sidebar a{
display:block;
padding:18px;
text-decoration:none;
color:black;
font-weight:bold;
font-size:17px;
transition:0.3s;
}

.sidebar a:hover{
background:#f1f1f1;
padding-left:25px;
}

/* OVERLAY */
.overlay{
display:none;
position:fixed;
top:0;
left:0;
width:100%;
height:100%;
background:rgba(0,0,0,0.6);
z-index:999;
}

/* TITLE */
.title{
text-align:center;
font-size:52px;
margin-top:80px;
font-weight:bold;
animation:fade 2s;
}

@keyframes fade{
from{opacity:0; transform:translateY(-30px);}
to{opacity:1; transform:translateY(0);}
}

/* SEARCH */
.searchBox{
display:flex;
justify-content:center;
margin-top:45px;
}

.searchBox input{
width:520px;
padding:25px;
border:none;
outline:none;
font-size:18px;
border-radius:35px;
box-shadow:0px 0px 25px rgba(0,0,0,0.4);
}

.searchBox button{
padding:25px 28px;
background:black;
color:white;
border:none;
font-size:17px;
cursor:pointer;
border-radius:35px;
margin-left:3px;
transition:0.3s;
}

.searchBox button:hover{
background:green;
transform:scale(1.05);
}

/* INFO */
.info{
text-align:center;
margin-top:35px;
font-size:18px;
}

/* 🔥 POPUP - NEW GLASSMORPHISM DESIGN */
.popup{
display:none;
position:fixed;
top:50%;
left:50%;
transform:translate(-50%,-50%);

/* NEW STYLE */
background: rgba(255,255,255,0.12);
backdrop-filter: blur(18px);
-webkit-backdrop-filter: blur(18px);

border: 1px solid rgba(255,255,255,0.25);
color:white;

padding:30px;
border-radius:18px;
width:360px;
z-index:2000;

box-shadow:0px 15px 40px rgba(0,0,0,0.5);
}

.popup h2{
text-align:center;
margin-bottom:20px;
}

/* INPUT */
.popup input{
width:95%;
padding:12px;
margin-top:10px;
border-radius:8px;
border:none;
outline:none;
}

/* BUTTON */
.popup button{
width:100%;
padding:12px;
margin-top:15px;
background:linear-gradient(135deg,#00c6ff,#0072ff);
color:white;
border:none;
cursor:pointer;
font-size:16px;
border-radius:8px;
transition:0.3s;
}

.popup button:hover{
transform:scale(1.03);
}

/* RESUME VIEW */
.resumeView{
background: rgba(255,255,255,0.2);
padding:10px;
margin-top:15px;
border-radius:10px;
color:white;
backdrop-filter: blur(10px);
}

.resumeView a{
text-decoration:none;
color:#00d4ff;
font-weight:bold;
}

</style>
</head>

<body>

<div class="top">
<div class="menu" onclick="openMenu()">☰</div>
</div>

<div class="title">
Find Your Dream IT Job 🚀
</div>

<form action="search_result.php" method="GET">

<div class="searchBox">

<input type="text"
name="q"
placeholder="Search PHP, Java, Web Development..."
required>

<button type="submit">
Search
</button>

</div>

</form>

<div class="info">
Search jobs related to IT, Computer Engineering & Technical Skills
</div>

<div class="sidebar" id="sidebar">

<a href="#" onclick="openUpload()">
Upload Resume
</a>

<a href="match_jobs.php">
Resume Related Jobs
</a>

<a href="logout.php">
Logout
</a>

</div>

<div class="overlay"
id="overlay"
onclick="closeMenu()"></div>

<div class="popup" id="popup">

<h2>Upload Your Resume 🚀</h2>

<?php
if($resumeFile != "")
{
    echo "
    <div class='resumeView'>
    Uploaded Resume:<br><br>
    <b>$resumeFile</b>
    <br><br>
    <a href='uploads/$resumeFile' target='_blank'>
    View Resume
    </a>
    </div>
    ";
}
?>

<form action="upload_resume.php"
method="POST"
enctype="multipart/form-data">

<input type="file" name="resume" required>

<button type="submit" name="upload">
Upload Resume
</button>

</form>

</div>

<script>

function openMenu(){
document.getElementById("sidebar").style.left="0";
document.getElementById("overlay").style.display="block";
}

function closeMenu(){
document.getElementById("sidebar").style.left="-260px";
document.getElementById("overlay").style.display="none";
document.getElementById("popup").style.display="none";
}

function openUpload(){
document.getElementById("popup").style.display="block";
}

</script>

</body>
</html>