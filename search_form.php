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
			document.getElementById("major_selector").style.display = '';				
		}
		function unhide_name()
		{
			document.getElementById("last_inputer").style.display = '';				
		}
		function unhide_type()
		{
			document.getElementById("type_selector").style.display = '';				

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
					<li><input type="checkbox" name="sort_major" value="sort_major" onselect="unhide_major()">Sort by Major</li>
					<li style="display:none" id="major_selector">
						<select id="major" name="major">
							<option>- Select Major - </option>
							<option value="CS">Computer Science</option>
							<option value="CompE">Computer Engineering</option>
							<option value="EE">Electrical Engineering</option>
							<option value="ME">Mechanical Engineering</option>
							<option value="CE">Civil Engineering</option>
							<option value="CIT">CIT</option>
							<option value="Physics">Physics</option>
						</select></li>
					<li><input type="radio" name="sort_last_name" value="sort_last_name" onselect="unhide_name()">Sort by Last Name</li>
					<li style="display:none" id="last_inputer"><input type="text" name="last"></li>
					<li><input type="radio" name="sort_type" value="sort_type" onselect="unhide_type()">Sort by User Type</li>
					<li style="display:none" id="type_selector">
                    <br><select id="user_type" name="user_type" >
						<option>- Select User Type -</option>
						<option value="Student">Student</option>
						<option value="Recruiter">Recruiter</option>
					</select></li>					
					<li><button type="submit">Apply Filters</button></li>
				</ul>
			</fieldset>
			</form>
		</fieldset>
    </body>
</html> 