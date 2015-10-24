<?php

try
{
   $user = 'tyler';
   $password = 'password'; 
   $db = new PDO('mysql:host=127.3.233.130:3306;dbname=resume_db', $user, $password);
}
catch (PDOException $ex) 
{
   echo 'Error!: ' . $ex->getMessage();
   die(); 
}

foreach ($db->query('SELECT last_name, first_name, user_id, username, password, user_type FROM users') as $row)
{
	
    echo 'user_id: ' . $row['user_id'];
   	echo '<br />';
	echo 'name: ' . $row['last_name'] . ',' . $row['first_name'];
   	echo '<br />';
	echo 'username: ' . $row['username'];
   	echo '<br />';
   	echo 'password: ' . $row['password']; 
   	echo '<br />';
   	echo 'user_type: ' . $row['user_type']; 
   	echo '<br />';
	echo '<br />';
}

function register_user()
{
$first_name = $_POST["first_name"];
$last_name = $_POST["last_name"];
$phone = $_POST["phone"];
$username_email = $_POST["email"];
$password = $_POST["password"];
$password_confirm = $_POST["password_confirm"];

echo "<bodyThe following info for user: " . $username_email . "will be inserted into the database<br>";
echo "<table><tr><th>Username</th><th>Password</th><th>First</th><th>Last</th><th>Phone</th></tr>";
echo "<tr><td>" . $username_email . "</td><td>" . $password . "</td><td>" . $first_name."</td><td>" . $last_name . "</td><td>" . $phone . "</td></tr></table></body>";
}
function go_to_menu()
{
}
register_user();
?>
