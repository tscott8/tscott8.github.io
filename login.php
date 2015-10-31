<?php
session_start();
require 'password.php';
if(isset($_SESSION['logged_in'])){
	header("location: menu.php");
}

function connect_to_db()
{
	$conn="";
	try
	{
	   $dbuser = 'tyler';
	   $dbpassword = 'password';
	   $conn = new PDO('mysql:host=127.3.233.130:3306;dbname=resume_db', $dbuser, $dbpassword);
		$conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
	}
	catch (PDOException $ex) 
	{
	   echo 'Error!: ' . $ex->getMessage();
	   die(); 
	}
	return $conn;
}

function check_existence($username, $db)
{
	/*try
	{	
		$sql = "SELECT password FROM users WHERE username = :username";
		$statement = $db->prepare($sql);
		$statement->bindValue(':username',$username);
		$statement->execute();
		$hash = $statement->fetch();
		$statement->closeCursor();
	}
	catch (PDOException $ex) 
	{
	   	echo 'Error!: ' . $ex->getMessage();
	   	die(); 
	}
	*/
	return true;
}
function verify_password($username, $password, $db)
{
	try
	{	
		$sql = "SELECT password FROM users WHERE username = :username";
		$statement = $db->prepare($sql);
		$statement->bindValue(':username',$username);
		$statement->execute();
		$hash = $statement->fetch();
		$statement->closeCursor();
	}
	catch (PDOException $ex) 
	{
		echo 'Error!: ' . $ex->getMessage();
	   	die(); 
	}
	$verify = password_verify($password, $hash[0]);
	echo "<script>console.log('hash: ".$hash[0]."')</script>";
	//echo "<script>console.log('password in db un hashes to: ".$verify."')</script>";
	/*if (password_verify($password, $hash[0])) {
		return true;
	}
	else {
		return false;
	}*/
	
	//cheat way
	if($hash[0] === $password){
		return true;
	}
	else {
		return false;
	}
}

function get_user_type($username, $db)
{
	try
	{	
		$sql = "SELECT user_type FROM users WHERE username = :username";
		$statement = $db->prepare($sql);
		$statement->bindValue(':username',$username);
		$statement->execute();
		$user_type = $statement->fetch();
		$statement->closeCursor();
	}
	catch (PDOException $ex) 
	{
		echo 'Error!: ' . $ex->getMessage();
	   	die(); 
	}
	$_SESSION['user_type'] = $user_type[0];
}

function login_user()
{
	$db = connect_to_db();
	$username = $_POST["username"];
	$password = $_POST["password"];
		//echo "<script>console.log('password is hashed to: ".password_hash($password,PASSWORD_DEFAULT)."')</script>";
	echo "<script>console.log('checking if new')</script>";
	if(isset($_SESSION['login_user'])){
		$username = $_SESSION['login_user'];
	}
	if(isset($_SESSION['login_pass'])){
		$password = $_SESSION['login_pass'];
	}
	echo "<script>console.log('checking if exists')</script>";
	//check existence
	if(check_existence($username, $db) == false){
		echo "<script type =\"text/javascript\"> alert(The username does not exist, redirecting to account creation.)</script>";
		//header("location: new_user_form.html");
		return false;
	}
	echo "<script>console.log('verifying password')</script>";
	//verify password and set session variable logged in
 	if (verify_password($username, $password, $db) == true)	{
    	$_SESSION['login_user'] = $username;
		$_SESSION['logged_in'] = true;
		get_user_type($username, $db);
	} 
	else {
		echo "<script>console.log('password fail')</script>";
		echo "<script>console.log('password is: ".$password."')</script>";
		return false;
	}
	$db = null;
	return true;
}

function go_to_menu()
{
	header("location: menu.php");
}

function main()
{
	if(login_user() == true) 
	{
		go_to_menu();
	}
	else 
	{
	header("location:login_form.html");
	}
}
main();
?>