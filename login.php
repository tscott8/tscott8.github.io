<?php
if(isset($_SESSION['logged_in']))
{
header("location: SuperRecruiter.php");
}
function check_existence()
{
	return true;
}
function login_user()
{
	$_SESSION['logged_in']=$_SESSION['login_user'];
}
function get_user_type()
{
try
{
   $user = 'tyler';
   $password = 'password'; 
   $db = new PDO('mysql:host=127.3.233.130:3306;dbname=resume_db', $user, $password);
   $_SESSION('user_type') = $db->query('SELECT user_type, FROM users WHERE username = $_SESSION['logged_in']');
}
catch (PDOException $ex) 
{
   echo 'Error!: ' . $ex->getMessage();
   die(); 
}

}
function go_to_menu()
{
	header("location: SuperRecruiter.php");
}
function main()
{
	if(check_existence()==true) 
	{
		login_user();
		go_to_menu();
	}
	else 
	{
		echo "<script type =\"text/javascript\"> alert(The username does not exist, redirecting to account creation.)</script>";
		header("location: new_user_form.html");
	}
}
main();
?>