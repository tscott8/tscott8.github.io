<?php

function check_user(){
    $value = $_POST["q1"];
    if($value == "yes")
    {
        header('Location: new_user_form.html');
    }
    else if($value == "no")
    {
        header('Location: login_form.html'); 
    }
    else
        echo "error, please try again<br>";
}

?>