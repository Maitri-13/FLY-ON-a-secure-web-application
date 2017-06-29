<?php
session_start();
session_regenerate_id();

include_once ('header.php'); 
include_once ('logout.php');
include_once('/var/www/html/project/project-lib.php');

connect($db);

$userid = $_SESSION['userid'];
icheck($scheduleid);



switch($s)
    {
	case 0;
	default;
		 header("Location: /project/login.php");
	break;

	case 100;
                // checking session
                if(!isset($_SESSION['authenticated']))
        	      {
	              	 authenticate($db, $postUser, $postPass);
          	      }
		checkAuth($db);


	       //If user is Admin
                if($_SESSION['userid']==93)
                {
                         echo "
			 <font size=\"+1\">
	   		 <center>
			 <br><b><a href = index.php?s=95 style=\"color: maroon\"> Failed login Table </a> </b>
			 <span style=' padding-left:3em '>
			 <b><a href = index.php?s=97 style=\"color: maroon\"> Block users</a> </b>
			 </span><span style=' padding-left:3em '>
			 <b><a href = index.php?s=99 style=\"color: maroon\"> Special Priviledged users</a> </b>
			 </span><span style=' padding-left:3em '>
			 <b><a href = index.php?s=6 style=\"color: maroon\"> Add flight details</a> </b></center> </font></span>
			 ";
                        echo"<center><b><h3>Welcome admin!</h3></b></center>";

		}
		
		//If user is Not admin
		// Search for flights form
		else
		{
	          	echo" 
			<center>
			<form method = post action =\"index.php\">
                        <font size=\"+1\">
			<br><b><a href=\"index.php?s=10\" style=\"color: maroon\"> List of Bookings</a></b>
        	        <b><h3> Enter search criteria</h3></b>	
        
 	       		<b>Boarding:</b><input type= \"text\" name=\"board\">
        		<br><b>Destination:</b><input type= \"text\" name= \"destination\">
        		<br><b>Boarding Date: </b> <input type= \"date\" name= \"boarddate\" >
			 <br><input type= \"hidden\" name= \"s\" value= 1>
        		<br><button type =\"submit\"> Submit</button>
			</center>   </font>
        		</form>";
		}	
	break;	



	case 1;	
			//User Funstionaity: To diaplay the flights present according to his search results
		 	echo"
                        <form method=post action=\"index.php\">
                        <font size=\"+1\"><center>
                        <br><b><a href=\"index.php?s=10\" style=\"color: maroon\"> List of Bookings</a></b><span style=' padding-left:3em '>
			<b><a href=index.php?s=100 style=\"color: maroon\">Search for flights</a></b></font>
                        </span> </center></form>
			";

        		$boarddate =mysqli_real_escape_string($db, $boarddate);
			$board =mysqli_real_escape_string($db, $board);
			$destination =mysqli_real_escape_string($db, $destination);
			
			$tempvar=0;
			$varrepeat =0;
	
			if ($stmt = mysqli_prepare($db, "SELECT flights.schedules.scheduleid, flights.schedules.flightname, flights.schedules.board, flights.schedules.boarddate, flights.schedules.boardTime, flights.schedules.destination,  flights.schedules.destinationTime, flights.schedules.duration, flights.schedules.fare from flights.schedules where flights.schedules.board=? and flights.schedules.destination=? and flights.schedules.boarddate=?"))
			{
				mysqli_stmt_bind_param($stmt, "sss", $board, $destination, $boarddate);
				mysqli_stmt_execute($stmt);
				mysqli_stmt_bind_result($stmt, $scheduleid, $flightname, $board, $boarddate, $boardTime, $destination, $destinationTime, $duration, $fare);
				while(mysqli_stmt_fetch($stmt))
				{	
					if($varrepeat==0)	
					echo "<center><b> <table> <tr> <td> <b> <u> <h3>Flight Schedules </h3> </b> </u> </td> </tr> </b>";				
					$varrepeat=1;
					$scheduleid =htmlspecialchars($scheduleid);
					$flightname =htmlspecialchars($flightname);
					$board =htmlspecialchars($board);
					$boarddate =htmlspecialchars($boarddate);
					$boardTime =htmlspecialchars($boardTime);
					$destination =htmlspecialchars($destination);
					$destinationTime =htmlspecialchars($destinationTime);
					$duration =htmlspecialchars($duration);
					$fare =htmlspecialchars($fare);	
					$tempVar=1;
				
					//Displaying the flights availaible
				 	echo "<tr> <td> <h3><a href=index.php?scheduleid=$scheduleid&flightname=$flightname&board=$board&boarddate=$boarddate&boardTime=$boardTime&destination=$destination&destinationTime=$destinationTime&duration=$duration&fare=$fare&s=3 style=\"color: maroon\"><br> flight Name:       $flightname<br> Boarding location:      $board<br> Boarding Date:      $boarddate <br> Boarding Time:       $boardTime<br> Destination:        $destination <br> Arrival Time:       $destinationTime<br>Duration:        $duration <br>Total fare:       $fare </a> </h3> </td> </tr> \n";
				}
				mysqli_stmt_close($stmt);
			}        
	
			if($tempVar==0)
			echo "<h3><b><center>Oops! No flights for the specified searched details</center> </h3></b>";
        	        echo "</table> </center>";
		
				
	break;

		
	case 3:
			
			// Displaying the flight details
			echo"
			<form method=post action=\"index.php\">
			<center>	
			<br><b> <font size=\"+1\"> <a href=index.php?s=10 style=\"color: maroon\">List of bookings</a>
                        </b>  <span style=' padding-left:3em '>
                        <b> <a href=index.php?s=100 style=\"color: maroon\">Search for flights</a> </b>
			</span>
			</font>
			</center>
			<br>
			<br>
			<center>
			<b> <h3>Confirm your flight details </h3> </b>
			<font size=\"+1\"> 
			<b>Name of the flight: </b> $flightname 
			<br><b> Boarding location:</b> $board
			<br><b>Boarding date:</b> $boarddate
			<br><b>Boarding time:</b>$boardTime  
			<br><b>Destination:</b> $destination 
			<br><b> Landing time:</b>$destinationTime
			<br><b>Duration of flight:</b> $duration
			<br><b>Total Fare:</b>$fare
			<br><input type= \"hidden\" name= \"s\" value= 4>
			<input type=\"hidden\" name=\"scheduleid\" value=\"$scheduleid\">
               		<br><button type = \"submit\"> Make payment </button>
			</font>
			</center> 
			</form>";

	break;

	case 4:
		// storing his booking after he has paid
			 echo"
                        <form method=post action=\"index.php\">
                        <center>
                        <br><b> <font size=\"+1\"> <a href=index.php?s=10 style=\"color: maroon\">List of bookings</a>
                        </b>  <span style=' padding-left:3em '>
                        <b> <a href=index.php?s=100 style=\"color: maroon\">Search for flights</a> </b>";

		$scheduleid=mysqli_real_escape_string($db, $scheduleid);
		$s=mysqli_real_escape_string($db, $s);
		$query = "insert into flights.bookings (flights.bookings.scheduleid, flights.bookings.userid) values($scheduleid, $userid)";
		$result= mysqli_query($db, $query);

		// displaying payment success
		echo "<center><h2>payment successfull! </h2> </center>";
	break;

	case 5;
		// Storing new user details functionality.
		
		$username=mysqli_real_escape_string($db, $username);
        	$password =mysqli_real_escape_string($db, $password);
		$cardnumber =mysqli_real_escape_string($db, $cardnumber);
        	$s=mysqli_real_escape_string($db, $s);

		$salt = rand();		
		$hashedPass= hash('sha256', $password.$salt );
	
		$temp=0;	
	
		$querycard= "SELECT creditcard from flights.users";
		$resultcard= mysqli_query($db, $querycard);

		//Checking if the card number is already registered
		while($row=mysqli_fetch_row($resultcard))
                {	
			if ($row[0]== $cardnumber)
				{
					echo "<b><h3><center>Credit card is already registered. Please logout to log into your account</center></h3><b>";								$temp=1;
					break;
				}
		}
		
		if($temp==0)
			{ 
				if ($stmt = mysqli_prepare($db, "insert into flights.users set flights.users.userid='', flights.users.username=?, flights.users.password=?, flights.users.salt=?,  flights.users.creditcard=?"))
					{
						mysqli_stmt_bind_param($stmt, "ssss", $username, $hashedPass, $salt, $cardnumber);
						 mysqli_stmt_execute($stmt);
						mysqli_stmt_close($stmt);
						echo"<center><b><h3>New Account Created! Please Logout to log into your account</center> </b> </h3>";
					}	
			}

             
	
 
	break;


	case 6;

		//Admin functions: Adding flights to BD
			 echo "
                         <font size=\"+1\">
                         <center>
                         <br><b><a href = index.php?s=95 style=\"color: maroon\"> Failed login Table </a> </b>
                         <span style=' padding-left:3em '>
                         <b><a href = index.php?s=97 style=\"color: maroon\"> Block users</a> </b>
                         </span><span style=' padding-left:3em '>
                         <b><a href = index.php?s=99 style=\"color: maroon\"> Special Priviledged users</a> </b>
                         </b></center> </font></span>
                        ";
		
		echo" 
		<center><br><b><h3>Add new flights details</h3></b>
		<form method = post action= \"index.php\">
		<font size=\"+1\">
		<b>flightname:  </b> <input type= \"text\" name=\"flightnameA\">
		<br><b>boarding location:</b>    <input type= \"text\" name= \"boardA\">
		<br><b>boardin date:</b> <input type = \"text\" name= \"boarddateA\">
		<br><b> boarding time: </b> <input type= \"text\" name=\"boardTimeA\">
	        <br><b>destination:  </b>  <input type= \"text\" name= \"destinationA\">
 	        <br><b>destination Time:</b> <input type = \"text\" name= \"destinationTimeA\">
 		<br><b>flight duration:  </b> <input type= \"text\" name=\"durationA\">
   	        <br><b>total fare: </b>   <input type= \"text\" name= \"fareA\">
		<input type=\"hidden\" name= \"s\" value=7>
		<br><br><button type =\"submit\"> Submit </button>
		</center>
		</font></form>
		";

	break;
				
	case 7;
		//Admin Function : Entering flight details in to DB part 2!
			echo "
                         <font size=\"+1\">
                         <center>
                         <br><b><a href = index.php?s=95 style=\"color: maroon\"> Failed login Table </a> </b>
                         <span style=' padding-left:3em '>
                         <b><a href = index.php?s=97 style=\"color: maroon\"> Block users</a> </b>                      </span><span style=' padding-left:3em '>
                         <b><a href = index.php?s=99 style=\"color: maroon\"> Special Priviledged users</a> </b>
                   	 </span><span style=' padding-left:3em '>
                         <b><a href = index.php?s=6 style=\"color: maroon\"> Add flight details</a>  </b>
      			 </b></center> </font></span>
                         ";
	
		$flightnameA =mysqli_real_escape_string($db, $flightnameA);
		$boardA =mysqli_real_escape_string($db, $boardA);
		$boarddateA =mysqli_real_escape_string($db, $boarddateA);
		$boardTimeA =mysqli_real_escape_string($db, $boardTimeA);
                $destinationA =mysqli_real_escape_string($db, $destinationA);
                $destinationTimeA =mysqli_real_escape_string($db, $destinationTimeA);
		$durationA =mysqli_real_escape_string($db, $durationA);
                $fareA =mysqli_real_escape_string($db, $fareA);
      		$s=mysqli_real_escape_string($db, $s);

                if ($stmt = mysqli_prepare($db, "insert into flights.schedules set flights.schedules.scheduleid='', flights.schedules.flightname=?, flights.schedules.board=?, flights.schedules.boarddate=?, flights.schedules.boardTime=?,flights.schedules.destination=?, flights.schedules.destinationTime=?, flights.schedules.duration=? ,flights.schedules.fare=? ")) 
		{ 
	
			mysqli_stmt_bind_param($stmt, "ssssssss", $flightnameA, $boardA, $boarddateA, $boardTimeA, $destinationA, $destinationTimeA, $durationA, $fareA);
                        mysqli_stmt_execute($stmt);
                        mysqli_stmt_close($stmt);
                }
		echo"<br><br><h3> <b><center> The flight details have been successfully stored</center></b></h3>";
	break;

	case 10;
	
		// USER FUNCTIONALITY:  FLIGHT BOOKINGS TABLE
                      	echo"
                        <form method=post action=\"index.php\">
                        <center>
                        <br><font size=\"+1\"> 
                        <b> <a href=index.php?s=100 style=\"color: maroon\">Search for flights</a> </b> </font> </center> </form>";

                       		
		$scheduleid=$_SESSION['scheduleid'];
		$userid = $_SESSION['userid'];
		echo "<center><h3><b> <u> Your bookings </u> </b> </h3></center>";
	
		//Fetching the bookings
	 	$query = "SELECT flights.schedules.flightname,  flights.schedules.board,  flights.schedules.boarddate,  flights.schedules.boardTime, flights.schedules.destination,  flights.schedules.destinationTime,  flights.schedules.duration,  flights.schedules.fare from  flights.schedules,  flights.bookings,  flights.users where  flights.bookings.scheduleid= flights.schedules.scheduleid and  flights.bookings.userid= flights.users.userid and flights.bookings.userid=$userid";
	                
		$result= mysqli_query($db, $query);
        	$flag=0;
	        while($row=mysqli_fetch_row($result))
                        {  
				$flag=1;
                                $row[0]=htmlspecialchars($row[0]);
                                $row[1]=htmlspecialchars($row[1]);
                                $row[2]=htmlspecialchars($row[2]);
                                $row[3]=htmlspecialchars($row[3]);
				$row[4]=htmlspecialchars($row[4]);
				$row[5]=htmlspecialchars($row[5]);
				$row[6]=htmlspecialchars($row[6]);
				$row[7]=htmlspecialchars($row[7]);
			
				echo " <center> <font size=\"+1\">

					<br><b>Flight name :</b> $row[0]
					<br><b>Boarding :</b> $row[1]
					<br><b>Boarding Date:</b> $row[2]
					<br><b>Boarding Time:</b> $row[3]
					<br><b>Destination:</b> $row[4]
					<br><b>Destination Time:</b> $row[5]
					<br><b>Duration:</b> $row[6]
					<br><b>Fare:</b> $row[7]
					<br><b>--------------------------------------------</b>
					<br><b>--------------------------------------------</b>

					</font><br> <br> </center>
				";
			
			}
		if ($flag==0)
		{
			echo "<center><b><h3>You have no prior bookings</h3></b> </center>";
		}
	break;


	case 95:
		//ADMIN FUNCTIONALITY: FAILED LOGIN DISPLAY
			 echo "
                         <font size=\"+1\">
                         <center>
                         <br>
                         <b><a href = index.php?s=97 style=\"color: maroon\"> Block users</a> </b>                      </span><span style=' padding-left:3em '>
                         <b><a href = index.php?s=99 style=\"color: maroon\"> Special Priviledged users</a> </b>
                 	 </span><span style=' padding-left:3em '>
                         <b><a href = index.php?s=6 style=\"color: maroon\"> Add flight details</a>  </b>
     			 </b></center> </font></span>
                        ";


		echo "<center><br><table><tr><td><b><h3> Failed Login Table </h3></b></td> </tr> </table></center>";
		$queryIp = "select flights.login.ip, flights.login.username, flights.login.date, flights.login.action from flights.login where flights.login.action = 'fail'";		
		$result= mysqli_query($db, $queryIp);
		while($row= mysqli_fetch_row($result))
		{
			$row[0]= htmlspecialchars($row[0]);
			echo "<center><br> <table> <tr>  <td> <b>IP: </b>  $row[0]</td> </tr> <tr><td> <b>User Name: </b> $row[1]</td></tr> <tr> <td><b> Login Time:</b>  $row[2]</td><tr>  </tr><td> <b>Login Status: </b>  $row[3] </td></tr> </table></center> ";
		echo "<center><b>---------------------------------------------------</b></center>";
		}
		 
	break;			


	case 96;
		
		//Logout Feature
		session_destroy();		
		header("Location: /project/login.php");
	break;


	case 97;
		//ADMIN functionalty: Blocked Users
		 	echo "
                         <font size=\"+1\">
                         <center>
                         <br><b><a href = index.php?s=95 style=\"color: maroon\"> Failed login Table </a> </b>
                         <span style=' padding-left:3em '>
                         </span><b><a href = index.php?s=99 style=\"color: maroon\"> Special Priviledged users</a> </b>
                         </span><span style=' padding-left:3em '>
                         <b><a href = index.php?s=6 style=\"color: maroon\"> Add flight details</a>  </b>
      			 </b></center> </font></span>
                        ";
	
		//Enter IP form
		echo "
		<center>
		 <form method = post action =\"index.php\">
		<b><h3> Permanently  Block Users </b></h3>
		<font size=\"+1\">
		<br><b>Enter the ip to be blocked:</b> <input type= \"text\" name=\"blockedip\"> 
		
		<input type=\"hidden\" name=\"s\" value=98>	
		<br><br><button type =\"submit\"> Submit </button>
		</font></form>
		</center>
		";

		 
	break;

	case 98;

		// Admin: Adding the blockedip to the BD 
			//Other Functionalities option
			 echo "
                         <font size=\"+1\">
                         <center>
                         <br><b><a href = index.php?s=95 style=\"color: maroon\"> Failed login Table </a> </b>
                         <span style=' padding-left:3em '>
                         <b><a href = index.php?s=97 style=\"color: maroon\"> Block users</a> </b>                      </span><span style=' padding-left:3em '>
                         <b><a href = index.php?s=99 style=\"color: maroon\"> Special Priviledged users</a> </b>
                   	 </span><span style=' padding-left:3em '>
                         <b><a href = index.php?s=6 style=\"color: maroon\"> Add flight details</a>  </b>
      			</b></center> </font></span>
                        ";	

			//Insert IP into DB
                	if ($stmt = mysqli_prepare($db, "insert into flights.blocked set flights.blocked.blockedid='', flights.blocked.ip=? "))
                	{

                        	mysqli_stmt_bind_param($stmt, "s", $blockedip);
                        	mysqli_stmt_execute($stmt);
                        	mysqli_stmt_close($stmt);
                	}
 			echo "
			<center><br><b><h3> User has been blocked permanently</b></h3> </center>";


	break;

	case 99;
			//ADMIN Functionality: Whitelist users
			// Option for other functionalities
			echo "
                        <font size=\"+1\">
                        <center>
                         <br><b><a href = index.php?s=95 style=\"color: maroon\"> Failed login Table </a> </b>
                         <span style=' padding-left:3em '>
                        <b><a href = index.php?s=97 style=\"color: maroon\"> Block users</a> </b>                      
		  	</span><span style=' padding-left:3em '>
                        <b><a href = index.php?s=6 style=\"color: maroon\"> Add flight details</a>  </b>
      			</b></center> </font></span>
                        ";
	
		// Form to enter the whitelist IP
		echo "
                <center>
                 <form method =post action =\"index.php\">
                <b><h3> Special Login Priviledges</b></h3>
		 <font size=\"+1\">
		 <br><b>Enter the ip:</b> <input type=\"text\" name=\"whiteip\">
                <br><br><button type =\"submit\"> Submit </button>
                </center>
                <input type=\"hidden\" name=\"s\" value=101>
                </font></form>
                ";
		 
	break;

	case 101:

		// Admin: Adding the Whiteist to the BD
		//The hyperlink for other of funtionaities
			echo "
                         <font size=\"+1\">
                        <center>
                         <br><b><a href = index.php?s=95 style=\"color: maroon\"> Failed login Table </a> </b>
                         <span style=' padding-left:3em '>
                        <b><a href = index.php?s=97 style=\"color: maroon\"> Block users</a> </b>                      </span><span style=' padding-left:3em '>
                         <b><a href = index.php?s=99 style=\"color: maroon\"> Special Priviledged users</a> </b>
                   	</span><span style=' padding-left:3em '>
                         <b><a href = index.php?s=6 style=\"color: maroon\"> Add flight details</a>  </b>
     			 </b></center> </font></span>
                        ";
	

		// Inserting into DB the ip
                if ($stmt = mysqli_prepare($db, "insert into flights.whitelist set flights.whitelist.whitelistid='', flights.whitelist.ip=? "))
                {

                        mysqli_stmt_bind_param($stmt, "s", $whiteip);
                        mysqli_stmt_execute($stmt);
                        mysqli_stmt_close($stmt);
                }



		 echo "
			<center><br><b><h3> User has been granted priviledges </b></h3></center>";

	break;
}

?>
