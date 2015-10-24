<?php
function goto_menu($user_type)
{
	$basic_menu="base";
	$student_extras="student";
	$recruiter_extras="recruit";
	if($user_type == "Recruiter")
		echo $basic_menu.$recruiter_extras;
	if($user_type == "Student")
		echo $basic_menu.$student_extras;
}
function main()
{
	$user_type=$_SESSION['user_type'];
	goto_menu($user_type);
}

main();
?>