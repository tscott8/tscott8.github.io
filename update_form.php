<?php
session_start();
echo "<script>console.log('info: ".$_SESSION['username_update']."')</script>"; 
?>
<!DOCTYPE html>
<html>
    <head>
		<meta charset="UTF-8">
		<link rel="stylesheet" type="text/css" href="SuperRecruiter.css"/>
		<title>New User Creation</title>
        <script type="text/javascript"> 
			
			echo "<script>console.log('". $_SESSION["first_name_update"]."')
			
			}document.getElementById("last_name").value = <?php echo $_SESSION['last_name_update'];?>;
				document.getElementById("phone").value = <?php echo $_SESSION['phone_update'];?>;
				document.getElementById("user_type").value = <?php echo $_SESSION['user_type_update'];?>;
				document.getElementById("major").value = <?php echo $_SESSION['major_update'];?>;
				document.getElementById("skills").value = <?php echo $_SESSION['skills_update'];?>;
				document.getElementById("username").value = <?php echo $_SESSION['username_update'];?>;
				document.getElementById("password").value = <?php echo $_SESSION['password_update'];?>;
				document.getElementById("password_confirm").value = <?php echo $_SESSION['password_update'];?>;*/
        </script>
    </head>
    <body class="center">
		<fieldset class="myform">
		<legend>Update your SuperRecruiter account</legend>
        <form id="update" action="update.php" method="post" onsubmit="return checkForm()"> 
            
				<span class="message">*required</span>
            <ul>
                <li>First Name:
					<br><input type="text" id="first_name" name="first_name" onchange="clear_message()" placeholder="Enter a valid First Name" /><span class="asterisk">*</span>
                    <div class ="message" id="first_name_message" style="color:Red"></div></li>
                <li>Last Name:
                    <br><input type="text" id="last_name" name="last_name" value="<?php echo $_SESSION['last_name_update'];?>" onchange="clear_message()" placeholder="Enter a valid Last Name" /><span class="asterisk">*</span>
                    <div class ="message" id="last_name_message" style="color:Red"></div></li>
                <li>Contact Number:
                    <br><input type="tel"  pattern="[0-9]*" id="phone" name="phone" onchange="clear_message()" placeholder="Enter a valid Phone Number"/>
                    <div class ="message" id="phone_message" style="color:Red"></div></li>
				<li>Select type of user:
                    <br><select id="user_type" name="user_type" onchange="check_user_type()">
						<option></option>
						<option value="Student">Student</option>
						<option value="Recruiter">Recruiter</option>
					</select><span class="asterisk">*</span>
				 <div class ="message" id="user_type_message" style="color:Red"></div></li></li>
				<li style="display:none" id="major_selector">Select a Major:
					<br><select id="major" name="major">
						<option></option>
						<option value="CS">Computer Science</option>
						<option value="CompE">Computer Engineering</option>
						<option value="EE">Electrical Engineering</option>
						<option value="ME">Mechanical Engineering</option>
						<option value="CE">Civil Engineering</option>
						<option value="CIT">CIT</option>
						<option value="Physics">Physics</option>
					</select><span class="asterisk">*</span>
				</li>
				<li style="display:none" id="skills">Please list your skills:
					<!--dynamic unfolding list would be nice-->
					<br><textarea name="skills"rows="10" cols="30"></textarea><span class="asterisk">*</span>
				</li>
				<li>Email: <span style="color:green; text-transform:uppercase; font-size:75%;">(this will be your username)</span>
                    <br><input type="email" id="username" name="username" onchange="clear_message()" placeholder="Enter a valid Email"/><span class="asterisk">*</span>
                    <div class ="message" id="username_message" style="color:Red"></div></li>
                <li>Password:
                    <br><input type="password" id="password" name="password" onchange="clear_message()" placeholder="Enter a valid Password" /><span class="asterisk">*</span>
                    <div class ="message" id="password_message" style="color:Red"></div></li>
                <li>Confirm Password:
                    <br><input type="password" id="password_confirm" name="password_confirm" onchange="clear_message(); checkPassMatch();" placeholder="Enter your Password again"/><span class="asterisk">*</span>
                    <div class ="message" id="password_confirm_message" style="color:Red"></div></li>
			<li><button type="submit" name="submit"/>Create User</button></li>
            </ul>
			</form>
            </fieldset>
    </body>
</html>