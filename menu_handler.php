<?php
session_start();

function search()
{
	echo "in search";
}
function update()
{
	echo "in update";
}
function delete()
{
	echo "in delete";
}
function browse()
{
	echo "in browse";

}
function display($what){}

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