<?php
session_start();
include "db.php";

$q = $_GET['q'];

/* SEARCH */
$result = mysqli_query($conn,
"SELECT * FROM jobs
WHERE title LIKE '%$q%'
OR skills_required LIKE '%$q%'");

?>

<!DOCTYPE html>
<html>
<head>

<title>Search Results</title>

<style>

body{
margin:0;
font-family:Arial;
background:linear-gradient(135deg,#1e3c72,#2a5298,#0f2027);
color:white;
padding:30px;
}

/* TOP */
.top{
text-align:center;
margin-bottom:35px;
}

.top h1{
font-size:45px;
animation:fade 2s;
}

@keyframes fade{
from{
opacity:0;
transform:translateY(-20px);
}
to{
opacity:1;
transform:translateY(0);
}
}

/* CARD */
.card{
background:white;
color:black;
padding:30px;
margin-bottom:30px;
border-radius:18px;
box-shadow:0px 0px 25px rgba(0,0,0,0.4);
transition:0.3s;
}

.card:hover{
transform:scale(1.01);
}

/* TITLE */
.title{
font-size:32px;
font-weight:bold;
color:#1e3c72;
margin-bottom:15px;
}

/* SECTION */
.section{
margin-top:18px;
line-height:1.8;
font-size:17px;
}

/* LABEL */
.label{
font-weight:bold;
color:green;
font-size:18px;
}

/* SKILL BADGE */
.badge{
display:inline-block;
padding:7px 14px;
background:#1e3c72;
color:white;
border-radius:20px;
margin:5px;
font-size:14px;
}

/* LINKS */
.linkBtn{
display:inline-block;
margin-top:15px;
margin-right:10px;
padding:12px 18px;
background:black;
color:white;
text-decoration:none;
border-radius:8px;
transition:0.3s;
}

.linkBtn:hover{
background:green;
}

/* NO RESULT */
.no{
background:white;
color:black;
padding:25px;
border-radius:15px;
text-align:center;
font-size:25px;
}

</style>

</head>

<body>

<div class="top">

<h1>
Search Results for "<?php echo $q; ?>" 🚀
</h1>

</div>

<?php

if(mysqli_num_rows($result) == 0)
{
    echo "<div class='no'>
    No Jobs Found
    </div>";
}
else
{
    while($row = mysqli_fetch_assoc($result))
    {
        echo "<div class='card'>";

        // TITLE
        echo "<div class='title'>"
        .$row['title'].
        "</div>";

        // DESCRIPTION
        if(!empty($row['description']))
        {
            echo "<div class='section'>

            <span class='label'>
            Description:
            </span><br>

            ".$row['description']."

            </div>";
        }

        // SKILLS
        echo "<div class='section'>

        <span class='label'>
        Skills Required:
        </span><br>";

        $skills = explode(",",$row['skills_required']);

        foreach($skills as $s)
        {
            echo "<span class='badge'>$s</span>";
        }

        echo "</div>";

        // HOW TO LEARN
        if(!empty($row['how_to_learn']))
        {
            echo "<div class='section'>

            <span class='label'>
            How To Learn:
            </span><br>

            ".$row['how_to_learn']."

            </div>";
        }

        // JOB SCOPE
        if(!empty($row['job_scope']))
        {
            echo "<div class='section'>

            <span class='label'>
            Future Scope:
            </span><br>

            ".$row['job_scope']."

            </div>";
        }

        // APPLY INFO
        if(!empty($row['apply_info']))
        {
            echo "<div class='section'>

            <span class='label'>
            How To Apply:
            </span><br>

            ".$row['apply_info']."

            </div>";
        }

        // PLAYLIST LINK
        if(!empty($row['playlist_link']))
        {
            echo "

            <a class='linkBtn'
            href='".$row['playlist_link']."'
            target='_blank'>

            Open Playlist

            </a>

            ";
        }

        // LEARNING VIDEO
        if(!empty($row['learning_video']))
        {
            echo "

            <a class='linkBtn'
            href='".$row['learning_video']."'
            target='_blank'>

            Learning Video

            </a>

            ";
        }

        // FUTURE VIDEO
        if(!empty($row['future_video']))
        {
            echo "

            <a class='linkBtn'
            href='".$row['future_video']."'
            target='_blank'>

            Future Scope Video

            </a>

            ";
        }

        echo "</div>";
    }
}

?>

</body>
</html>