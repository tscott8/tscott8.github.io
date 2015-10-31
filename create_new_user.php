<?php
session_start();
require 'password.php';
if(isset($_SESSION['logged_in'])){
header("location: menu.php");
}

function register_user()
{
	//get form variables
	$first_name = $_POST["first_name"];
	$last_name = $_POST["last_name"];
	$phone = $_POST["phone"];
	$user_type = $_POST["user_type"];
	$major = "";
	$skills = "";
	if($user_type == "Student")
	{
		$major = $_POST["major"];
		$skills = $_POST["skills"];
	}
	$username = $_POST["username"];
	
	$password = $_POST["password"];
	$password_confirm = $_POST["password_confirm"];

	//$password = password_hash($_POST["password"],PASSWORD_DEFAULT);
	//$password_confirm = password_hash($_POST["password_confirm"],PASSWORD_DEFAULT);

	$_SESSION['login_user'] = $username;
	$_SESSION['login_pass'] = $password;
	//connect and insert into db
	try
	{
	   $dbuser = 'tyler';
	   $dbpassword = 'password'; 
	   $db = new PDO('mysql:host=127.3.233.130:3306;dbname=resume_db', $dbuser, $dbpassword);
		$db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
		$sql = "INSERT INTO users (username, password, first_name, last_name, user_type, phone, major, skills)
			VALUES ('$username', '$password', '$first_name', '$last_name', '$user_type', '$phone','$major', '$skills')";
		$db->exec($sql);
		echo "SUCCESS!";
	}
	catch (PDOException $ex) 
	{
	   echo 'Error!: ' . $ex->getMessage();
	   die(); 
	}
}
function main()
{
	register_user();
	//go to login
	header("location: login.php");	
}
main();
?>
