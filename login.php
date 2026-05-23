<?php
session_start();
include "db.php";

$error = "";

if(isset($_POST['login']))
{
    $email = $_POST['email'];
    $password = $_POST['password'];

    $check = mysqli_query($conn,
    "SELECT * FROM users
    WHERE email='$email'
    AND password='$password'");

    if(mysqli_num_rows($check) > 0)
    {
        $_SESSION['email'] = $email;

        header("Location: user_dashboard.php");
        exit;
    }
    else
    {
        $error = "Email ID or Password is Wrong!";
    }
}
?>

<!DOCTYPE html>
<html>
<head>

<title>Login</title>

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
width:350px;
border-radius:20px;
text-align:center;
box-shadow:0px 0px 20px black;
}

h2{
margin-bottom:20px;
}

input{
width:90%;
padding:12px;
margin:10px;
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
font-size:16px;
}

button:hover{
background:green;
}

.error{
color:red;
font-size:14px;
margin-top:10px;
}

a{
text-decoration:none;
color:#1e3c72;
font-weight:bold;
}

</style>

</head>

<body>

<div class="box">

<h2>User Login 🚀</h2>

<form method="POST">

<input type="email"
name="email"
placeholder="Enter Email ID"
required>

<input type="password"
name="password"
placeholder="Enter Password"
required>

<button type="submit" name="login">
Login
</button>

</form>

<div class="error">
<?php echo $error; ?>
</div>

<br>

<a href="forgot_password.php">
Forgot Password?
</a>

<br><br>

<a href="register.php">
Create New Account
</a>

</div>

</body>
</html>