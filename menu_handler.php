<?php
session_start();
//if($_SESSION['logged_in']!=true){
//header("location: startup.html");
//}
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
function search()
{
	echo "in search";
	//need to display fancy options in the html
	header("location: search.html");

}
function update()
{
	$db = connect_to_db();
	try
	{	
		$sql = "SELECT * FROM users WHERE username = :username";
		$statement = $db->prepare($sql);
		$statement->bindValue(':username', $_SESSION['login_user']);
		$statement->execute();
		$info = $statement->fetch();
		$statement->closeCursor();
	}
	catch (PDOException $ex) 
	{
		echo 'Error!: ' . $ex->getMessage();
	   	die(); 
	}
	echo "<script>console.log('info: ".$info[1]."')</script>";
	echo "<script>console.log('info: ".$info[2]."')</script>";
	echo "<script>console.log('info: ".$info[3]."')</script>";
	echo "<script>console.log('info: ".$info[4]."')</script>";
	echo "<script>console.log('info: ".$info[5]."')</script>";
	echo "<script>console.log('info: ".$info[6]."')</script>";
	echo "<script>console.log('info: ".$info[7]."')</script>";
	echo "<script>console.log('info: ".$info[8]."')</script>";

	$_SESSION['username_update'] = $info[1];
	$_SESSION['password_update'] = $info[2];
	$_SESSION['first_name_update'] = $info[3];
	$_SESSION['last_name_update'] = $info[4];
	$_SESSION['user_type_update'] = $info[5];
	$_SESSION['phone_update'] = $info[6];
	$_SESSION['major_update'] = $info[7];
	$_SESSION['skills_update'] = $info[8];

	echo "<script>console.log('info: ".$_SESSION['username_update']."')</script>"; 
	//pull account info to use on next page
	$db=null;
	header("location: update_form.php");
}
function delete()
{
	echo "in delete";
	//maybe echo confirm then deletes your account
}
function browse()
{
	echo "in browse";
	//displays all the people in the db

}

function handle_menu()
{
if($_POST["menu_select"] == "search")
	search();
if($_POST["menu_select"] == "update")
	update();
if($_POST["menu_select"] == "delete")
	delete();
if($_POST["menu_select"] == "browse")
	browse();
}
function main()
{
	handle_menu();
}
main();
?>