<html><body>
<?php

$user_type = 0;

function check_user(){
    $value = $_POST["q1"];
    if($value == "yes")
    {
       new_user_form();
    	create_user();   
    }
    else if($value == "no")
    {
        login_form();
        login();
    }
    else
        echo "error, please try again<br>";
}

function new_user_form(){
   header('Location: new_user_form.html');
}


function login_form()
{
    header('Location: new_user_form.html'); 
}

function goto_menu()
{
}

function main()
{
    check_user();
    goto_menu($user_type);
}

main();

?>
    </body></html>