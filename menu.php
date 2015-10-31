<?php
session_start();
if($_SESSION['logged_in']!=true){
header("location: startup.html");
}
function goto_menu($user_type)
{
	$menu="<?php
session_start();
?>

<!DOCTYPE html>
<html>
    <head>
		<meta charset=\"UTF-8\">
		<link rel=\"stylesheet\" type=\"text/css\" href=\"SuperRecruiter.css\"/>
		<title>" . $user_type . " Menu</title>
	</head>
	<body class=\"center\">
		<fieldset class=\"myform\" >
		<legend>" . $user_type . " Menu</legend>
		<form id=\"menu\" action=\"menu_handler.php\" method=\"post\">
		<fieldset>
			<legend>What would you like to do?</legend>
			<ul>
				<li><button type=\"submit\" id=\"search\" name=\"menu_select\" value=\"search\">Search For a Profile</button></li>
				<li><button type=\"submit\" id=\"update\" name=\"menu_select\" value=\"update\">Update Profile</button></li>
				<li><button type=\"submit\" id=\"delete\" name=\"menu_select\" value=\"delete\">Delete Your Profile</button></li>
				<li><button type=\"submit\" id=\"browse\" name=\"menu_select\" value=\"browse\">Browse Profiles</button></li>
			</ul>
		</fieldset>
	</form>
	</fieldset>
</body>
</html>";
echo $menu;
}

function main()
{
	$user_type = $_SESSION['user_type'];
	goto_menu($user_type);
}

main();
?>