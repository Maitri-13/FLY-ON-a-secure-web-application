<?php
// The login form
include_once ('header.php');		

echo"
  <html>
  <body>
	<center><h3><b> Please Login </b> </h3> 
	
	
	<form method = post action = \"index.php\">
	<font size = \"+1\">
	<b>Username:      </b>  <input type= \"text\" name=\"postUser\">
	<br><b>Password:   </b> <input type= \"password\" name= \"postPass\">
	<input type= \"hidden\" name= \"s\" value= 100>
	<br><br><button type =\"submit\"> Submit </button> 
	<br>
	<br> <b> <h4><a href=\"register.php\" style=\"color: maroon\"> New users please Register here! </a> </h4></b>
	</center></font></form>                                
	</body>
  </html>

";
?>
