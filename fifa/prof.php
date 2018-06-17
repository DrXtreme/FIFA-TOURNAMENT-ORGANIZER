<?php

if(isset($_GET['ID'])){
	$ID=$_GET['ID'];
	Database::getUserData($ID);
}
class Database{
	static public function connect(){

		$nexion=@mysqli_connect("localhost","User","","testdatabase") or die();
		if($nexion->connect_error){
		    return "cant connect";
		    exit;
		}
		if(!$nexion){
			return "cant connect";
		    exit;
		}
		return $nexion;
		}
	static public function getUserData($ID){
		$sqlSelect = ("SELECT * FROM `users` WHERE `ID` = '$ID' ORDER BY Points DESC , Scored - Against DESC , Scored DESC , Name");
		$resolto=mysqli_query(Database::connect(),$sqlSelect);
		while ($row=$resolto->fetch_assoc()){
		 	$Scored=0;
		 	$Against=0;
		 	$Won=0;
		 	$Draw=0;
		 	$Lost=0;
		 	$Points=0;
		 	$sqlSelect2=("SELECT * FROM `teams` WHERE `userID`='$row[ID]' ;");
		 	$resalta=mysqli_query(Database::connect(),$sqlSelect2);
		 	while ($rowTeam=$resalta->fetch_assoc()){
		 		$Scored+=$rowTeam['Scored'];
			 	$Against+=$rowTeam['Against'];
			 	$Won+=$rowTeam['Won'];
			 	$Draw+=$rowTeam['Draw'];
			 	$Lost+=$rowTeam['Lost'];
			 	$Points+=$rowTeam['Points'];

		 	}
		 	$sqlUpdate=("UPDATE  `users` SET `Points` ='$Points' ,`Scored`='$Scored',`Against`='$Against' WHERE `ID`='$row[ID]' ;" );
		 	mysqli_query(Database::connect(),$sqlUpdate);
		 	?>
		 	<head>
<meta charset="utf-8">
<meta name="theme-color" content="#000000" >
<meta http-equiv="X-UA-Compatible" content="IE=edge">
<meta name="viewport" content="width=device-width, initial-scale=1">
<!-- The above 3 meta tags *must* come first in the head; any other head content must come *after* these tags -->
<meta name="description" content="FIFA17 :: LIBYA:: PS25+ GROUP">
<meta name="author" content="Sofian Ben-issa">
	<title>PS25+ FIFA SYSTEM 2017 :: LIBYA ::</title>
	<script src="jquery-3.2.1.js" type="text/javascript"></script>
	<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css" integrity="sha384-BVYiiSIFeK1dGmJRAkycuHAHRg32OmUcww7on3RYdg4Va+PmSTsz/K68vbdEjh4u" crossorigin="anonymous">

<!-- Optional theme -->
<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap-theme.min.css" integrity="sha384-rHyoN1iRsVXV4nD0JutlnGaslCJuC7uwjduW9SVrLvRYooPp2bWYgmgJQIXwl/Sp" crossorigin="anonymous">

<!-- Latest compiled and minified JavaScript -->
<script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js" integrity="sha384-Tc5IQib027qvyjSMfHjOMaLkfuWVxZxUPnCJA7l2mCWNIpG9mGCD8wGNIcPD7Txa" crossorigin="anonymous"></script>
		<style type="text/css">
			body{
				background-color: #15061F;
				color: white;
				text-align: center;
			}
			.well{
				color: black;
			}
			.jumbotron{
				color: #9F0EFF;
				background: url("ps25.jpg") no-repeat center center;
				text-outline: 80px 80px black;
				background-size: cover;
				 -webkit-text-stroke-width: 1px;
                 -webkit-text-stroke-color: black;
			}
			input{
				color: black;
			}
			select{
				color: black;
			}
			button{
				color: black;
			}
			#rankings .ranka{
				padding:0 5px 0 5px;
			}
			#rankings tr{
				border-bottom:1pt solid white;
			}
			#rankings tr:hover{
				background-color: #150610;
			}
			#rankings .rankScored{
				padding:0 10px 0 10px;
			}
			#rankings .P{
				color: lightblue;
			}
			#rankings .rankW{
				color: lightgreen;
			}
			#rankings .rankD{
				color: whitesmoke;
			}
			#rankings .rankL{
				color: #ff4c4c;
			}
			#rankings .rankPlyd{
				color: whitesmoke;
				background-color: linear;
				border:1pt solid lightblue;
			}
			#rankings .rank{
				color: whitesmoke;
				
				border:2pt solid lightblue;
			}
			table {
			    width: auto;
			    margin-left: auto;
			    margin-right: auto;
			}
			#gameSchedule tr{
				border:1pt solid gray	;
			}
		</style>
		</head>
<body>
<nav class="navbar navbar-inverse">
        <div class="container">
          <div class="navbar-header">
            <button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target=".navbar-collapse">
              <span class="sr-only">Toggle navigation</span>
              <span class="icon-bar"></span>
              <span class="icon-bar"></span>
              <span class="icon-bar"></span>
            </button>
            <a class="navbar-brand" href="index.html">PS25+ FIFA</a>
          </div>
          <div class="navbar-collapse collapse">
            <ul class="nav navbar-nav">
              <li><a href="index.html">Home</a></li>
              <li><a href="registerUser.php">Register!</a></li>
              <li><a href="newLeague.html">New League!</a></li>
              <li class="active"><a href="leaderboards.html">Leaderboards</a></li>
              <li><a href="admin.php">Admin</a></li>
            </ul>
          </div><!--/.nav-collapse -->
        </div>
      </nav>
      <div class="well"><p><strong><?php echo "<a href='prof.php?ID=$row[ID]' >".$row['Name'].'</a>';?></strong></p>
      <br><p>member since: <?php echo $row['Born'];  ?></p></div>
<table id="rankings" class="table">
	<tr><td>Name: </td> <td> <?php echo "<a href='prof.php?ID=$row[ID]' >".$row['Name'].'</a>';?></td></tr>
	<tr><td>PSN: </td><td> <?php echo $row['PSN'];  ?></td></tr>
	<tr><td>FB: </td><td> <?php echo $row['FB'];  ?></td></tr>
	<tr><td>W/L ratio: </td><td><?php if($Lost==0){$Lost=1;} echo $Won/$Lost;  ?></td></tr>
</table>
</body>
</html>





		 	<?php
		 	echo $row['ID'];echo ",";
		 	echo "<a href='prof.php?ID=$row[ID]' >".$row['Name'].'</a>';echo ",";
		 	echo $row['PSN'];echo ",";
		 	echo $row['FB'];echo ",";
		 	echo $Scored;echo ",";
		 	echo $Against;echo ",";
		 	echo $Won;echo ",";
		 	echo $Draw;echo ",";
		 	echo $Lost;echo ",";
		 	echo $Points;echo "^";
		 	mysqli_close(Database::connect());

    		//$arr+= $name.",".$seasons." " ;
    		//$outSeasons=array_push($outSeasons,);
		}

	}

  }
