<?php
require('authenticate.php');
?>
<?php
//Database::selectAllGames();
//session_start();
$IP=$_SERVER['REMOTE_ADDR'];
$authUser = $_SESSION["username"];
echo $authUser." ",$IP;
class Database
{
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
	static public function selectAdminGames(){
		$username= $_SESSION["username"];
		$userID;
		$sqlSelect = ("SELECT `userID` FROM `admins` WHERE `username`='$username' ;");
		$result=mysqli_query(Database::connect(),$sqlSelect);
		while ($row=$result->fetch_assoc()){
			 $userID=$row['userID'];
		}
		if($userID!="" && $userID!=null && $userID!="undefined"){
			$sqlSelect = ("SELECT * FROM `league` WHERE `admin`='$userID' ;");
		//$sqlSelect = ("SELECT * FROM `games` WHERE `Verified`='0';");
		$result=mysqli_query(Database::connect(),$sqlSelect);
		//$leagues="";
		while ($row=$result->fetch_assoc()){
			echo $row['ID'].",".$row['Name'].",".$row['Seasons']."^";
		}
		//return $leagues;
		mysqli_close(Database::connect());
		}
		else{

		}
	}
	static public function selectAllGames($verified=0){
		$sqlSelect = ("SELECT * FROM `games` WHERE `Verified`='0';");
		if($verified==1){
			$sqlSelect = ("SELECT * FROM `games` WHERE `Verified`='1';");
		}
		
		$resolto=mysqli_query(Database::connect(),$sqlSelect);
		 while ($row=$resolto->fetch_assoc()){
		 	$sqlUser1ID="SELECT `userID` FROM `teams` WHERE `ID`='$row[team1ID]';";
		 	$user1ID;
		 	$resolt=mysqli_query(Database::connect(),$sqlUser1ID);
		 	while ($rowo=$resolt->fetch_assoc()){
		 		$user1ID=$rowo['userID'];
		 	}
		 	$sqlUser2ID="SELECT `userID` FROM `teams` WHERE `ID`='$row[team2ID]';";
		 	$user2ID;
		 	$resolt2=mysqli_query(Database::connect(),$sqlUser2ID);
		 	while ($rowo2=$resolt2->fetch_assoc()){
		 		$user2ID=$rowo2['userID'];
		 	}
		 	$sqlSelectUser1Name = ("SELECT `Name` FROM `users` WHERE `ID`='$user1ID';");
		 	$user1name;
		 	$resalta=mysqli_query(Database::connect(),$sqlSelectUser1Name);
		 	while($rowto=$resalta->fetch_assoc()){
		 		$user1name=$rowto['Name'];
		 	}
		 	$sqlSelectUser2Name = ("SELECT `Name` FROM `users` WHERE `ID`='$user2ID';");
		 	$user2name;
		 	$resalta2=mysqli_query(Database::connect(),$sqlSelectUser2Name);
		 	while($rowto2=$resalta2->fetch_assoc()){
		 		$user2name=$rowto2['Name'];
		 	}
		 	echo $row['ID'];echo ",";
		 	echo $row['leagueID'];echo ",";
		 	echo $row['seasonID'];echo ",";
		 	echo $user1name;echo ",";
		 	echo $user2name;echo ",";
		 	echo $row['team1Goals'];echo ",";
		 	echo $row['team2Goals'];echo ",";
		 	echo $row['Date'];echo ",";
		 	echo $row['Verified'];echo ",";
		 	echo $row['team1ID'];echo ",";
		 	echo $row['team2ID'];echo "^";
		 	mysqli_close(Database::connect());

		}
	}
}

?>
<!DOCTYPE html>
<html>
<head>
<meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <!-- The above 3 meta tags *must* come first in the head; any other head content must come *after* these tags -->
    <meta name="theme-color" content="#000000" >
    <meta name="description" content="FIFA17 :: LIBYA:: PS25+ GROUP">
    <meta name="author" content="Sofain Ben-issa">
		<title>PS25+ FIFA SYSTEM 2017 :: LIBYA ::</title>
		<script src="jquery-3.2.1.js" type="text/javascript"></script>
		<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css" integrity="sha384-BVYiiSIFeK1dGmJRAkycuHAHRg32OmUcww7on3RYdg4Va+PmSTsz/K68vbdEjh4u" crossorigin="anonymous">

<!-- Optional theme -->
<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap-theme.min.css" integrity="sha384-rHyoN1iRsVXV4nD0JutlnGaslCJuC7uwjduW9SVrLvRYooPp2bWYgmgJQIXwl/Sp" crossorigin="anonymous">

<!-- Latest compiled and minified JavaScript -->
<script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js" integrity="sha384-Tc5IQib027qvyjSMfHjOMaLkfuWVxZxUPnCJA7l2mCWNIpG9mGCD8wGNIcPD7Txa" crossorigin="anonymous"></script>
		<style type="text/css">
			body{
				background-color: black;
				color: white;
				text-align: center;
			}
			.well{
				color: black;
				background: #110f0f;
				border: 1px solid black;
			}
			.well p {
				color: red;
				background-color: black;
			}
			.jumbotron{
				color: black;
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
		</style>
	<script type="text/javascript">
	function Game(ID,user1,user2,Team1Goals,Team2Goals,V,Team1ID,Team2ID){
				this.ID=ID;
				this.user1=user1
				this.user2=user2;
				this.Team1Goals=Team1Goals;
				this.Team2Goals=Team2Goals;
				this.V=V;
				this.Team1ID=Team1ID;
				this.Team2ID=Team2ID;
			}
	function League(ID,name,seasons){
				this.ID=ID;
				this.name=name;
				this.seasons=seasons||0;
			}
		var games=[];
		var url="core.php";
		function loadGames(){
			$('#games').html("<tr><td>ID</td><td>Team1ID</td><td>Team1Goals</td><td>Team2ID</td><td>Team2Goals</td><td>V</td></tr>");
			var data = document.getElementById("hidden").innerHTML;
			
			
			if(data!==""){
				//var response=data;
				var rows=data.split('^');//alert(response);
				//var leagueArray=[];
				for(var i=0;i<rows.length-1;i++){
					
					$gameID=rows[i].split(',')[0];
					if($gameID!==0){
						
					games.push(new Game($gameID,rows[i].split(',')[3],rows[i].split(',')[4],rows[i].split(',')[5],rows[i].split(',')[6],rows[i].split(',')[8],rows[i].split(',')[9],rows[i].split(',')[10] ));}
						
				}
				//put data in table
				for(var i=0;i<games.length;i++){
					$('#games').append("<tr id='tr"+i+"'><td>"+games[i].ID+"</td><td>"+games[i].user1+"</td><td>"+games[i].Team1Goals+"</td><td>"+games[i].user2+"</td><td>"+games[i].Team2Goals+"</td><td>"+games[i].V+"</td><td><a href='#' onclick='VerifyGame("+i+");'>Verify"+i+"</a></td></tr>");
				}
			}
		}

		function loadGamesV(){
			//$('#gamesV').html("<tr><td>ID</td><td>Team1ID</td><td>Team1Goals</td><td>Team2ID</td><td>Team2Goals</td><td>V</td></tr>");
			var data = document.getElementById("hidden2").innerHTML;
			
			
			if(data!==""){
				//var response=data;
				var rows=data.split('^');//alert(response);
				//var leagueArray=[];
				for(var i=0;i<rows.length-1;i++){
					
					$gameID=rows[i].split(',')[0];
					if($gameID!==0){
						
					games.push(new Game($gameID,rows[i].split(',')[3],rows[i].split(',')[4],rows[i].split(',')[5],rows[i].split(',')[6],rows[i].split(',')[8],rows[i].split(',')[9],rows[i].split(',')[10] ));}
						
				}
				//put data in table
				for(var i=0;i<games.length;i++){
					$('#games').append("<tr id='tr"+i+"'><td>"+games[i].ID+"</td><td>"+games[i].user1+"</td><td>"+games[i].Team1Goals+"</td><td>"+games[i].user2+"</td><td>"+games[i].Team2Goals+"</td><td>"+games[i].V+"</td><td><a href='#' style='color:red;'>Remove"+i+"</a></td></tr>");
				}
			}
		}
		var leagues=[];
		function loadLeagues(){

			//$('#gamesV').html("<tr><td>ID</td><td>Team1ID</td><td>Team1Goals</td><td>Team2ID</td><td>Team2Goals</td><td>V</td></tr>");
			var data = document.getElementById("hidden3").innerHTML;
			
			
			if(data!==""){
				//var response=data;
				var rows=data.split('^');//alert(response);
				//var leagueArray=[];
				for(var i=0;i<rows.length-1;i++){
					
					
						
					leagues.push(new League(rows[i].split(',')[0],rows[i].split(',')[1],rows[i].split(',')[2] ));}
						
				
				//put data in table
				for(var i=0;i<leagues.length;i++){
					$('#leagues').append("<tr id='trL"+i+"'><td>"+leagues[i].name+"</td><td>"+leagues[i].seasons+"</td></tr>");
				}
			}
		}
						
		function VerifyGame(i){
			var adminVerifyGames=1;alert(games[i].ID);
			$.post(url,{adminVerifyGames:adminVerifyGames,team1ID:games[i].Team1ID,team2ID:games[i].Team2ID,user1Goals:games[i].Team1Goals,user2Goals:games[i].Team2Goals,gameID:games[i].ID},function(data){alert(data);
				if(data==1){
					alert("Game Verified!");
				}else{
					alert("Verification Failed!");
				}
			})
		}
	</script>
</head>
<body onload="loadGames();loadGamesV();loadLeagues();">
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
              <li><a href="leaderboards.html">Leaderboards</a></li>
              <li class="active"><a href="admin.php">Admin</a></li>
            </ul>
          </div><!--/.nav-collapse -->
        </div>
      </nav>
      <div class="well"><p><strong>ADMINs ONLY ALLOWED IN HERE!</strong></p></div>
      <table id="leagues" class="table">
      	<tr><td>League Name</td><td>Seasons</td></tr>
      </table>
<table id="games" class="table">
	<tr><td>ID</td><td>Team1ID</td><td>Team1Goals</td><td>Team2ID</td><td>Team2Goals</td><td>V</td></tr>
</table>
<br><br>

<div id="hidden" style="visibility: hidden;">
	<?php  
						Database::selectAllGames();


						?>
</div>
<div id="hidden2" style="visibility: hidden;">
	<?php  
						Database::selectAllGames(1);


						?>
</div>
<div id="hidden3" style="visibility: visible;color: white;">
	<?php  
						Database::selectAdminGames();


						?>
</div>
</body>
</html>