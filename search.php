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

function search() 
{
	$db = connect_to_db();	
	if(isset($_POST["sort_major"]))
		$major = $_POST["major"];
	else
		$major = "%";
	if(isset($_POST["sort_last_name"]))
		$last_name = $_POST["last_name"];
	else
		$last_name = "%";
	if(isset($_POST["sort_user_type"]))
		$user_type = $_POST["user_type"];
	else
		$user_type = "%";
	try
	{	
		$sql = "SELECT * FROM users WHERE major LIKE :major AND last_name LIKE :last_name AND user_type LIKE :user_type";
		$statement = $db->prepare($sql);
		$statement->bindValue(':major',$major);
		$statement->bindValue(':last_name', $last_name);
		$statement->bindValue(':user_type',$user_type);
		$statement->execute();
	echo "<html><head>
	<meta charset=\"UTF-8\">
	<link rel=\"stylesheet\" type=\"text/css\" href=\"SuperRecruiter.css\"/>
	<title>Search Results</title>
	</head><body class=\"center\"><fieldset class=\"myform\"><legend>Database Entries</legend>
	<table><tr><th>ID</th><th>First</th><th>Last</th><th>Type</th><th>Email</th><th>Phone</th><th>Major</th><th>Skills</th></tr>";
	while ($row = $statement->fetch())
	{	
		echo '<tr>';
		echo '<td>' . $row['user_id']. '</td>';
		echo '<td>' . $row['first_name']. '</td>';
		echo '<td>' . $row['last_name']. '</td>';
		echo '<td>' . $row['user_type']. '</td>';
		echo '<td>' . $row['username']. '</td>';
		echo '<td>' . $row['phone']. '</td>';
		echo '<td>' . $row['major']. '</td>';
		echo '<td>' . $row['skills']. '</td>';
		echo '</tr>';
	}
	echo "</table></fieldset></body></html>";
	//displays searched people in the db
	$statement->closeCursor();
	}
	catch (PDOException $ex) 
	{
		echo 'Error!: ' . $ex->getMessage();
	   	die(); 
	}
	$db=null;
}	
function main()
{
	search();
}
main();



?>