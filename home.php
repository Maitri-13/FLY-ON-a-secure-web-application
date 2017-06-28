<?php

include_once ('header.php');
include_once ('logout.php');
echo"
	<html>
	<body>
	<center>	
	<br><br>
	<h3><b> Enter search criteria</b> </h3>
	<form method = post action =\"index.php?s=1\">

	Boarding Location:<input type= \"text\" name=\"board\">
	<br>Destination:<input type= \"text\" name= \"destination\">
	<br>Boarding Date:<input type= \"date\" name= \"boarddate\" >
	
	<br><br><button type =\"submit\"> Submit </button>
	</center>

	<b><h4><a href=\"/project/index.php?s=10\"> List of Bookings</a></h4></b>
	</form>

</body>
</html>
";
?>
