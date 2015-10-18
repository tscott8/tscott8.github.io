<html><body>
<?php

function check_user(){
    if(isset($_POST['yes']))
        create_user();
    if(isset($_POST['no']))
        login();
}
function create_user()
{
	echo "create user here";
}
function login()
{
	echo "login here";
}
?>
    </body></html>