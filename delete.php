<?php
session_start();
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
function confirm_delete()
{
	$response = $_POST["q2"];
	if($response == "yes")
		return true;
	else if($response == "no")
		return false;
}
function delete()
{
	$username = $_SESSION['login_user'];
	$db = connect_to_db();
	try
	{	
		$sql = "DELETE FROM users WHERE username = :username;";
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
	$db=null;
	header("location: startup.html");
}
function main()
{
	if(confirm_delete() == true)
		delete();
	else
		header("location: menu.php");

}
main();
?>