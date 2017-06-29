<?php
include_once ('header.php'); 
include_once ('logout.php');
include_once('/var/www/html/project/project-lib.php');

echo"

<html>
<body>

	<center><h3><b> Please create a new account </b> </h3>
	
	<form method = post action= \"index.php\">
	<b> <font size=\"+1\">
	Username:        <input type= \"text\" name=\"username\">
	<br>Password:    <input type= \"password\" name= \"password\">
	<br>Card number: <input type = \"text\" name= \"cardnumber\">
<input type= \"hidden\" name= \"s\" value=5>
	
<br><br><button type =\"submit\"> Submit </button>
</center> </b></font>	</form>

</body>
</html>

";
?>
