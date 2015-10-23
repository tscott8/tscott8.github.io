<html>
<body>
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
?>
</body>
</html>
