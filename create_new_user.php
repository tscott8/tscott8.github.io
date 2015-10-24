<?php
if(isset($_SESSION['logged_in'])){
header("location: SuperRecruiter.php");
}

function register_user()
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
	$skills =$_POST["skills"];
}
$username_email = $_POST["email"];
$password = $_POST["password"];
$password_confirm = $_POST["password_confirm"];

echo "<bodyThe following info for user: " . $username_email . "will be inserted into the database<br>";
echo "<table><tr><th>Username</th><th>Password</th><th>First</th><th>Last</th><th>Phone</th></tr>";
echo "<tr><td>" . $username_email . "</td><td>" . $password . "</td><td>" . $first_name."</td><td>" . $last_name . "</td><td>" . $phone . "</td></tr></table></body>";

try
{
   $user = 'tyler';
   $password = 'password'; 
   $db = new PDO('mysql:host=127.3.233.130:3306;dbname=resume_db', $user, $password);
	$db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
	$sql = "INSERT INTO users (username, password, first_name, last_name, user_type, phone, major, skills)
		VALUES ('$username_email', '$password', '$first_name', '$last_name', '$user_type', '$phone','$major', '$skills')";
	$db->exec($sql);
	echo "SUCCESS!";
}
catch (PDOException $ex) 
{
   echo 'Error!: ' . $ex->getMessage();
   die(); 
}

}
function go_to_login()
{
	$_SESSION['login_user']=$username_email;
	header("location: login.php");	
}
function main()
{
	register_user();
	go_to_login();
}
main();
?>
