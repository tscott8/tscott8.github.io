<?php
session_start();
if(isset($_SESSION['logged_in']))
{
	header("location: menu.php");
}

function connect_to_db()
{
	$conn="";
	try
	{
	   $user = 'tyler';
	   $password = 'password';
	   $conn = new PDO('mysql:host=127.3.233.130:3306;dbname=resume_db', $user, $password);
		$conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
	}
	catch (PDOException $ex) 
	{
	   echo 'Error!: ' . $ex->getMessage();
	   die(); 
	}
	return $conn;
}

function check_existence($db)
{
	//if exists
	return true;
	//else false
}
function login_user()
{
	$username="";
	if(isset($_SESSION['login_user']))
	{
		$username = $_SESSION['login_user'];
	}
	else 
	{
		$username = $_POST["username"];
	}
	return $username;
}
function get_user_type($login, $db)
{
	$sql = "SELECT user_type FROM users WHERE username = '".$login."'";
	echo $sql . "<br>";
	$user_type = $db->query($sql);
	//$_SESSION('user_type') = $user_type;
	$_SESSION['user_type'] = "Student";
}
function go_to_menu()
{
	header("location: menu.php");
}
function main()
{
	$db = connect_to_db();
	if(check_existence($db) == true) 
	{
		$login = login_user();
		get_user_type($login, $db);
		$_SESSION['logged_in'] = true;
		echo $_SESSION['user_type'];
		echo $_SESSION['logged_in'];
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