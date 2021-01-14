
<?php
session_start();
error_reporting(0);
include('includes/config.php'); // connection to the data

if(isset($_POST['signin']))// triggers when sign inbutton is clicked. 
{
$uname=$_POST['username']; // collect form data after submitting an html form
$password=md5($_POST['password']);

$sql ="SELECT username,Password,EmailId,id FROM tblaccounts WHERE username=:uname and Password=:password";
$query= $dbh -> prepare($sql);
$query-> bindParam(':uname', $uname, PDO::PARAM_STR);
$query-> bindParam(':password', $password, PDO::PARAM_STR);
$query-> execute();

$results=$query->fetchAll(PDO::FETCH_OBJ);

if($query->rowCount() > 0)  // if record more than 1
{
 /*foreach ($results as $result) {
    $status=$result->Status;
   
  }*/

echo "<script type='text/javascript'> document.location = 'home.php'; </script>";
} 
else{
echo "<script>alert('Username or Password is incorrect!');</script>";
}

}

?><!DOCTYPE html>
<html>
<head>
    <title>USER LOGIN</title>
    <link rel="stylesheet" type="text/css" href="style.css">
	
	<script type = "text/javascript">
	
	function fvalidate()
	{
		if (document.signin.username.value =='')
		{
			alert("Username is required!");
			document.signin.username.focus();
			return false;
		}
			if (document.signin.password.value =='')
		{
			alert("Password is required!");
			document.signin.password.focus();
			return false;
		}
		else
		{
			return true;
		}
		
	}
	
	</script>
	
</head>
<body>
   
 
   </br>
   
<p align ="center" > <img src="assets/img/banner.png" /></p>
    <div class="header">
        <H2>LOG-IN</H2>
    </div>


    <form method ="post" name ="signin" onSubmit="return fvalidate();" > 

    <div class= "input-group">
    <label>Username</label>
    <input type="type" name="username">
    </div>

    <div class= "input-group">
    <label>Password</label>
    <input type="password" name="password">
    </div>
    
    <div class= "input-group">
    
     <input type="submit" name="signin" value="LOGIN"class="btnRegister">
	</div>
    
	<P>Not yet a member?<a href="Register.php">Sign Up</a></p>

    </form>
	
	</br>
	
	

</body>
</html>


