<?php
include "db.php";

$msg = "";

if(isset($_POST['reset']))
{
    $email = $_POST['email'];
    $newpass = $_POST['newpass'];
    $confirmpass = $_POST['confirmpass'];

    if($newpass != $confirmpass)
    {
        $msg = "Password Not Match!";
    }
    else
    {
        $check = mysqli_query($conn,
        "SELECT * FROM users WHERE email='$email'");

        if(mysqli_num_rows($check) > 0)
        {
            mysqli_query($conn,
            "UPDATE users
            SET password='$newpass'
            WHERE email='$email'");

            $msg = "Password Updated Successfully!";
        }
        else
        {
            $msg = "Email ID Not Found!";
        }
    }
}
?>

<!DOCTYPE html>
<html>
<head>

<title>Forgot Password</title>

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
}

input{
width:90%;
padding:12px;
margin:10px;
border-radius:8px;
border:1px solid gray;
}

button{
width:95%;
padding:12px;
background:black;
color:white;
border:none;
border-radius:8px;
}

button:hover{
background:green;
}

.msg{
margin-top:10px;
color:red;
}

</style>

</head>

<body>

<div class="box">

<h2>Forgot Password</h2>

<form method="POST">

<input type="email"
name="email"
placeholder="Enter Email ID"
required>

<input type="password"
name="newpass"
placeholder="Enter New Password"
required>

<input type="password"
name="confirmpass"
placeholder="Confirm New Password"
required>

<button type="submit" name="reset">
Update Password
</button>

</form>

<div class="msg">
<?php echo $msg; ?>
</div>

</div>

</body>
</html>