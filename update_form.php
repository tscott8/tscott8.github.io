<?php
session_start();
?>
<!DOCTYPE html>
<html>
    <head>
		<meta charset="UTF-8">
		<link rel="stylesheet" type="text/css" href="SuperRecruiter.css"/>
		<title>Update account</title>
        <script> 
			function autofill()
			{		
				document.getElementById("first_name").value = "<?php echo $_SESSION['first_name_update'];?>";
				document.getElementById("last_name").value = "<?php echo $_SESSION['last_name_update'];?>";
				document.getElementById("phone").value = "<?php echo $_SESSION['phone_update'];?>";
				document.getElementById("user_type").value = "<?php echo $_SESSION['user_type_update'];?>";
				document.getElementById("major").value = "<?php echo $_SESSION['major_update'];?>";
				document.getElementById("skills").innerhtml = "<?php echo $_SESSION['skills_update'];?>";
				document.getElementById("username").value = "<?php echo $_SESSION['username_update'];?>";
				document.getElementById("password").value = "<?php echo $_SESSION['password_update'];?>";
				document.getElementById("password_confirm").value = "<?php echo $_SESSION['password_update'];?>";
			}
			function checkForm()
			{ 
				var return_val = true;
                if(document.getElementById("first_name").value == "")
                {
					document.getElementById("first_name_message").innerHTML = "Enter your First Name.";
					return_val = false;
                }
				else
					clear_message("first_name");
                if(document.getElementById("last_name").value == "")
                {
					document.getElementById("last_name_message").innerHTML = "Enter your Last Name";
					return_val = false;
                }
				else
					clear_message("last_name");
				if(document.getElementById("user_type").value == "- Select User Type -")
                {
					document.getElementById("user_type_message").innerHTML = "Select a user type";
					return_val = false;
                }
				else
					clear_message("user_type");
                if(document.getElementById("username").value == "")
                {
					document.getElementById("username_message").innerHTML = "Enter your Email";
					return_val = false;
                }
				else
					clear_message("username");
                if(document.getElementById("password").value == "")
                {
					document.getElementById("password_message").innerHTML = "Enter a Password";
					return_val = false;
                }
				else
					clear_message("password");
                if(checkPassMatch() == false)
				{
					return_val = false;
                }
				else
					clear_message("password_confirm");
				
				return return_val;
            }
            function checkPassMatch()
			{
				if(document.getElementById("password").value != document.getElementById("password_confirm").value)
                {
                	document.getElementById("password_confirm_message").innerHTML = "Passwords do not match!";
                    return false;
                }
                else
                    return true;
            }
            function clear_message(message_to_clear)
			{           
				var string = message_to_clear + "_message";
                document.getElementById(string).innerHTML = "";
            }
			function check_user_type()
			{
				if(document.getElementById("user_type").value == "Student")
				{
					document.getElementById("major_selector").style.display = '';
					document.getElementById("skills").style.display = '';
			
				}
				else 
				{
					document.getElementById("major_selector").style.display = 'none';
					document.getElementById("skills").style.display = 'none';
				}
			}
        </script>
    </head>
    <body class="center" onload="autofill();check_user_type()">
		<fieldset class="myform">
		<legend>Update your SuperRecruiter account</legend>
        <form id="update" action="update.php" method="post" onsubmit="return checkForm()"> 
            
				<span class="message" >*required</span>
            <ul>
                <li>First Name:
					<br><input type="text" id="first_name" name="first_name" onchange="checkForm()" placeholder="Enter a valid First Name" /><span class="asterisk">*</span>
                    <div class="message" id="first_name_message" ></div></li>
                <li>Last Name:
                    <br><input type="text" id="last_name" name="last_name" onchange="checkForm()" placeholder="Enter a valid Last Name" /><span class="asterisk">*</span>
                    <div class="message" id="last_name_message" ></div></li>
                <li>Contact Number:
                    <br><input type="tel"  pattern="[0-9]*" id="phone" name="phone" onchange="checkForm()" placeholder="Enter a valid Phone Number"/>
                    <div class="message" id="phone_message" ></div></li>
				<li>Select type of user:
                    <br><select id="user_type" name="user_type" onchange="check_user_type(); checkForm()">
						<option>- Select User Type - </option>
						<option value="Student">Student</option>
						<option value="Recruiter">Recruiter</option>
					</select><span class="asterisk">*</span>
				 <div class="message" id="user_type_message"></div></li></li>
				<li style="display:none" id="major_selector">Select a Major:
					<br><select id="major" name="major">
						<option>- Select Major - </option>
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
					<br><textarea name="skills" rows="5" cols="30"></textarea><span class="asterisk">*</span>
				</li>
				<li>Email: <span style="color:green; text-transform:uppercase; font-size:75%;">(this will be your username)</span>
                    <br><input type="email" id="username" name="username" onchange="checkForm()" placeholder="Enter a valid Email"/><span class="asterisk">*</span>
                    <div class="message" id="username_message" ></div></li>
                <li>Password:
                    <br><input type="password" id="password" name="password" onchange="checkForm()" placeholder="Enter a valid Password" /><span class="asterisk">*</span>
                    <div class="message" id="password_message"></div></li>
                <li>Confirm Password:
                    <br><input type="password" id="password_confirm" name="password_confirm" onchange="checkForm(); checkPassMatch();" placeholder="Enter your Password again"/><span class="asterisk">*</span>
                    <div class="message" id="password_confirm_message"></div></li>
			<li><br><button type="submit" name="submit"/>Update User</button></li>
            </ul>
			</form>
            </fieldset>
    </body>
</html>