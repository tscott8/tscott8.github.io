<?php
session_start();

function search()
{
	echo "in search";
	//need to display fancy options in the html
	header("location: search.html");

}
function update()
{
	echo "in update";
	//need to pull account info and set session variables to pass to update.html
	header("location: update.html");
}
function delete()
{
	echo "in delete";
	//maybe echo confirm then deletes your account
}
function browse()
{
	echo "in browse";
	//displays all the people in the db

}

function handle_menu()
{
if($_POST["menu_select"] == "search")
	search();
if($_POST["menu_select"] == "update")
	update();
if($_POST["menu_select"] == "delete")
	delete();
if($_POST["menu_select"] == "browse")
	browse();
}
function main()
{
	handle_menu();
}
main();
?>