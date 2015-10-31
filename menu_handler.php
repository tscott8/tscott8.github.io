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
	echo "in search";
	//need to display fancy options in the html
	header("location: search.php");

}
function update($db)
{
	
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
	//pull account info to use on next page
	header("location: update_form.php");
}
function delete()
{
	$deleter="<?php
session_start();
?>

<!DOCTYPE html>
<html>
    <head>
		<meta charset=\"UTF-8\">
		<link rel=\"stylesheet\" type=\"text/css\" href=\"SuperRecruiter.css\"/>
		<title>Confirm Deletion</title>
	</head>
	<body class=\"center\">
		<fieldset class=\"myform\" >
		<legend>Confirm Deletion</legend>
		<form id=\"menu\" action=\"delete.php\" method=\"post\">
		<fieldset>
			<legend>Do you really want to delete your account?</legend>
			<ul>
				<li>
						<button type=\"submit\" name=\"q2\" value=\"yes\">Yes</button>
					</li> 
					<li>
						<br><button type=\"submit\" name=\"q2\" value=\"no\">No</button>
					</li>
			</ul>
		</fieldset>
	</form>
	</fieldset>
</body>
</html>";
echo $deleter;
}
function browse($db)
{
	try
	{	
		$sql = "SELECT * FROM users";
		$statement = $db->prepare($sql);
		$statement->execute();
		$read = $statement->fetch();
		$statement->closeCursor();
	}
	catch (PDOException $ex) 
	{
		echo 'Error!: ' . $ex->getMessage();
	   	die(); 
	}
	echo '<head>
	<meta charset=\"UTF-8\">
	<link rel=\"stylesheet\" type=\"text/css\" href=\"SuperRecruiter.css\"/>
	<title>Brows</title>
</head><body class=\"center\"><fieldset class=\"myform\"><legend>Database Entries</legend>
	<table><tr><th>ID</th><th>First</th><th>Last</th><th>Type</th><th>Email</th><th>Phone</th><th>Major</th><th>Skills</th></tr>';
	foreach ($db->query($sql) as $row)
	{	
		echo '<tr>';
		echo '<td>' . $row['user_id']. '</td>';
		echo '<td>' . $row['first_name']. '</td>';
		echo '<td>' . $row['last_name']. '</td>';
		echo '<td>' . $row['user_type']. '</td>';
		echo '<td>' . $row['username']. '</td>';
		echo '<td>' . $row['phone']. '</td>';
		echo '<td>' . $row['major']. '</td>';
		echo '<td>' . $row['user_id']. '</td>';
		echo '<td>' . $row['skills']. '</td>';
		echo '</tr>';
	}
	echo '</table></fieldset></body></html>';
	//displays all the people in the db
	$db=null;
}

function handle_menu()
{
$db = connect_to_db();
if($_POST["menu_select"] == "search")
	search();
if($_POST["menu_select"] == "update")
	update($db);
if($_POST["menu_select"] == "delete")
	delete();
if($_POST["menu_select"] == "browse")
	browse($db);
}
function main()
{
	
	handle_menu();
}
main();
?>