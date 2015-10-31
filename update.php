<?php
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
function update()
{
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

	$db = connect_to_db();
	try
	{	
		$sql = "UPDATE users SET username =:username, password=:password, first_name = :first_name,
				last_name = :last_name, user_type = :user_type, phone = :phone, major = :major,
				skills = :skills WHERE username = :username";
		$statement = $db->prepare($sql);
		$statement->bindValue(':username',$username);
		$statement->bindValue(':password',$password);
		$statement->bindValue(':first_name',$first_name);
		$statement->bindValue(':last_name',$last_name);
		$statement->bindValue(':user_type',$user_type);
		$statement->bindValue(':phone',$phone);
		$statement->bindValue(':major',$major);
		$statement->bindValue(':skills',$skills);
		$statement->execute();
		$user_type = $statement->fetch();
		$statement->closeCursor();
	}
	catch (PDOException $ex) 
	{
		echo 'Error!: ' . $ex->getMessage();
	   	die(); 
	}
}
function main()
{
	update();
	header("location: menu.php");

}
main();
?>