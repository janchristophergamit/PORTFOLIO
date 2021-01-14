<?php 
session_start();
error_reporting(0);
include('includes/config.php');// connection to the data

$uname=$_POST['username'];  // coolect form data after submitting an html form
$email=$_POST['email']; 
$password1=md5($_POST['pass1']); //encryption on database
$password2=md5($_POST['pass2']); //encryption on database

$btnInvalidUName= false;

//query if user name is available
if (($uname<>"") && ($email<>"") && ($password1<>"")&& ($password2<>"")) // fields are null , it loads first the webpage
{
	
		$sql ="SELECT username from tblaccounts WHERE username =:uname"; //data are validated from the database
		$query= $dbh -> prepare($sql);
		$query-> bindParam(':uname', $uname, PDO::PARAM_STR);
		$query-> execute();
		$results=$query->fetchAll(PDO::FETCH_OBJ);

	if($query->rowCount() > 0)// if record more than 1
	{
	 $btnInvalidUName= true; //load again the body Html and alert message will appear
	}

	else // else if not existing account it 
	{
	//data are inserted from the database

		$sql="INSERT INTO tblaccounts (username,EmailId,Password) VALUES(:uname,:email,:password1)";

		$query = $dbh->prepare($sql); 
		$query->bindParam(':uname',$uname,PDO::PARAM_STR);
		$query->bindParam(':email',$email,PDO::PARAM_STR);
		$query->bindParam(':password1',$password1,PDO::PARAM_STR);

		$query->execute();
		
		$lastInsertId = $dbh->lastInsertId();

		if($lastInsertId)
		{
		$msg="User Account record added Successfully";
		}
		else 
		{
		$msg=="Something went wrong. Please try again";
		}
		}
}
?>



<!DOCTYPE html>
<html>
<head>
    <title>USER REGISTRATION</title>
    <link rel="stylesheet" type="text/css" href="style.css">
	
	<script type = "text/javascript">
	
	function fvalidate() //validation to submission of from submit button of the form *register the name of the form
	{
		if (document.register.username.value =='')
		{
			alert("Username is required!");
			document.register.username.focus();
			return false;
		}
		
		if (document.register.email.value =='')
		{
			alert("Email is required!");
			document.register.email.focus();
			return false;
		}
		if (document.register.pass1.value =='')
		{
			alert("Password is required!");
			document.register.pass1.focus();
			return false;
		}
		
		if (document.register.pass2.value =='')
		{
			alert("Confirm Password is required!");
			document.register.pass2.focus();
			return false;
		}
		
		else
		{
			if (document.register.pass1.value == document.register.pass2.value)
			{
				return true;
			}
		
			else
			{
				alert("Password and Confirm Password doesn't match!");
				document.register.pass1.value ="";
				document.register.pass2.value ="";
				document.register.pass1.focus();
				return false;
			}
		
		}
	}
	
	</script>
	
	
	
</head>
<body <?php if ($btnInvalidUName==true) {?> onload ="alert('Username already taken!');" <?php } ?>>
<p align ="center" > <img src="assets/img/banner.png" /></p>
    <div class="header">
        <H2>REGISTRATION <br><?php echo $msg; ?></H2>
    </div>

   <form method ="post" name ="register" onSubmit="return fvalidate();" > 

    
    

    <div class= "input-group">
    <label>Username</label>
    <input type="type" name="username" value ="<?php echo $_POST['username'];?>" >
    </div>
    
    <div class= "input-group">
    <label>Email</label>
    <input type="email" name="email" value ="<?php echo $_POST['email'];?>">
    </div>

    <div class= "input-group">
    <label>Password</label>
    <input type="password" name="pass1" value ="<?php echo $_POST['pass1'];?>">
    </div>

    <div class= "input-group">
    <label>Confirm Password</label>
    <input type="password" name="pass2" value ="<?php echo $_POST['pass2'];?>">
  
    </div>

    <div class= "input-group">
	 <input type="submit" name="register" value="CLICK TO REGISTER"class="btnRegister">
	 
    
    </div>
    <p>Already a member?<a href="index.php">Log-in</a></p>
    </form>
	</br>
	

</body>
</html>


