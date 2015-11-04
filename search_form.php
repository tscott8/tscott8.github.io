<?php
session_start();
?>
<html xmlns = "http://www.w3.org/1999/xhtml">
<head>
	<meta charset="UTF-8">
	<link rel="stylesheet" type="text/css" href="SuperRecruiter.css"/>
	<title>SuperRecruiter Startup</title>
	<script type="text/javascript">
		function unhide_major()
		{
			if(document.getElementById("sort_major").checked == true)
				document.getElementById("major_selector").style.display = '';
			else
				document.getElementById("major_selector").style.display = 'none';
		}
		function unhide_name()
		{
			if(document.getElementById("sort_last_name").checked == true)
				document.getElementById("last_inputer").style.display = '';	
			else
				document.getElementById("major_selector").style.display = 'none';

		}
		function unhide_type()
		{
			if(document.getElementById("sort_type").checked == true)
				document.getElementById("type_selector").style.display = '';	
			else
				document.getElementById("type_selector").style.display = 'none';

		}
	</script>
</head>

    <body class="center">
		<fieldset class="myform" >
			<legend>Filter Search</legend>
		<form id="startup" method="post" action="search.php">
			<fieldset>
			<legend>Apply Filters to select candidates</legend>
				<ul>
					<li>Sort by Major<input type="checkbox" id="sort_major" name="sort_major" value="sort_major" onchange="unhide_major()">
					<div style="display:none" id="major_selector">
						<select id="major" name="major">
							<option>- Select Major -</option>
							<option value="CS">Computer Science</option>
							<option value="CompE">Computer Engineering</option>
							<option value="EE">Electrical Engineering</option>
							<option value="ME">Mechanical Engineering</option>
							<option value="CE">Civil Engineering</option>
							<option value="CIT">CIT</option>
							<option value="Physics">Physics</option>
						</select></div></li>
					<li>Sort by Last Name<input type="checkbox" id="sort_last_name" name="sort_last_name" value="sort_last_name" onchange="unhide_name()">
						<div style="display:none" id="last_inputer"><input type="text" name="last"></div></li>
					<li>Sort by User Type<input type="checkbox" id="sort_type" name="sort_type" value="sort_type" onchange="unhide_type()">
					<div style="display:none" id="type_selector">
                    <select id="user_type" name="user_type" >
						<option>- Select User Type -</option>
						<option value="Student">Student</option>
						<option value="Recruiter">Recruiter</option>
						</select></div></li>					
					<li><button type="submit">Apply Filters</button></li>
				</ul>
			</fieldset>
			</form>
		</fieldset>
    </body>
</html> 