<?php
include "db.php";

if(isset($_POST['reg']))
{
    $name = $_POST['name'];
    $email = $_POST['email'];
    $mobile = $_POST['mobile'];
    $password = $_POST['password'];
    $confirm = $_POST['confirm'];

    if($password != $confirm)
    {
        echo "<script>alert('Password Not Match');</script>";
    }
    else
    {
        $check = mysqli_query($conn,"SELECT * FROM users WHERE email='$email'");

        if(mysqli_num_rows($check) > 0)
        {
            echo "<script>alert('Email Already Exists');</script>";
        }
        else
        {
            mysqli_query($conn,
            "INSERT INTO users(name,email,mobile,password)
            VALUES('$name','$email','$mobile','$password')");

            // ✅ SAFE REDIRECT (BEST METHOD)
            header("Location: user_dashboard.php");
            exit;
        }
    }
}
?>

<!DOCTYPE html>
<html>
<head>

<title>Register</title>

<style>

body{
margin:0;
font-family:Arial;
height:100vh;
display:flex;
justify-content:center;
align-items:center;
background:linear-gradient(135deg,#1e3c72,#2a5298,#0f2027);
}

.box{
background:white;
padding:40px;
border-radius:20px;
width:350px;
text-align:center;
box-shadow:0px 0px 20px black;
}

input{
width:90%;
padding:10px;
margin:8px;
border-radius:8px;
border:1px solid gray;
outline:none;
}

button{
width:95%;
padding:12px;
background:black;
color:white;
border:none;
border-radius:8px;
cursor:pointer;
}

button:hover{
background:green;
}

</style>

</head>

<body>

<div class="box">

<h2>Create Account 🚀</h2>

<form method="POST">

<input type="text" name="name" placeholder="Name" required><br>

<input type="email" name="email" placeholder="Email" required><br>

<input type="text" name="mobile" placeholder="Mobile" required><br>

<input type="password" name="password" placeholder="Password" required><br>

<input type="password" name="confirm" placeholder="Confirm Password" required><br>

<button type="submit" name="reg">Register</button>

</form>

</div>

</body>
</html>