<html>
	<head>
	<meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <!-- The above 3 meta tags *must* come first in the head; any other head content must come *after* these tags -->
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
		</style>
		<script type="text/javascript">
			//leagues in class
			function User(ID,name){
				this.name=name;
				
				this.ID=ID;
			}
			function Team(name,userID){
				this.name=name;
				this.userID=userID;
			}
			//var successmessage = "Thank you for email, we will be in contact soon!";
			//var failedmessage = "There was a problem, please try again!";
			//var usersname = $('#name');
			//var usersemail = $('#email');
			//var usersphone = $('#phone');			
			//var userscomment = $('#comment');
			//var usershuman = $('#human');
			if($('#newUserResult').text()!==""){
				$('#userFormContainer').hide();
			}
			var looked=0;
			var users=[];
			//var userID=0;
			var url = "core.php";
			function getUsers(){
				
				if (looked==0) {
				var getUsers = 1;
				
				$.post(url,{ getUsers: getUsers } , function(data) {
					//var response=data;
					var rows=data.split('^');//alert(response);
					//var leagueArray=[];
					for(var i=0;i<rows.length;i++){
						
						$userID=rows[i].split(',')[0];
						if($userID!==""){
							if(i==0){
								users=[new User($userID,rows[i].split(',')[1]) ];
							}else{
							users.push(new User($userID,rows[i].split(',')[1]) );}
							
					}}
					for(var i=0;i<users.length;i++){
						
						$('#slctUserID').append("<option value=''>"+users[i].name+"</option>");
					}
					
				});looked=1;}
			}
			function createTeam(){
				if(looked==1){
				var TeamName = $('#teamName');
				var userIndex=document.getElementById('slctUserID').selectedIndex;
				var url = "core.php";
				var userID4Team=parseInt(users[userIndex].ID);
				if(confirm("Are you sure you want to add team to this user?")){
					if(TeamName.val()!==""){
				$.post(url,{ TeamName: TeamName.val() , userID4Team: userID4Team} , function(data) {
					if(data>0){
						document.getElementById('resultSubmitTeam').innerHTML="Successfully made a new team!";
						alert('Successfully made a new team!');
						$('#SubmitTeam').hide();
						//window.location('index.php');
					}
					else{
						alert('failed to create team :('+data);
					}
				});}else{
					alert("Team name cannot be empty!");
				}}
			}}
			</script>
	</head>
	<body>
	
		<!-- Fixed navbar -->
    <nav class="navbar navbar-inverse navbar-fixed-top">
      <div class="container">
        <div class="navbar-header">
          <button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#navbar" aria-expanded="false" aria-controls="navbar">
            <span class="sr-only">Toggle navigation</span>
            <span class="icon-bar"></span>
            <span class="icon-bar"></span>
            <span class="icon-bar"></span>
          </button>
          <a class="navbar-brand" href="index.html">PS25+ FIFA</a>
        </div>
        <div id="navbar" class="navbar-collapse collapse">
          <ul class="nav navbar-nav">
            <li><a href="index.html">Home</a></li>
            <li class="active"><a href="registerUser.php">Register!</a></li>
            <li><a href="newLeague.html">New League!</a></li>
            <li><a href="leaderboards.html">Leaderboards</a></li>
            <li><a href="admin.php">Admin</a></li>
          </ul>
        </div><!--/.nav-collapse -->
      </div>
    </nav><br><br>
    <div class="container theme-showcase" role="main">
    	<div class="jumbotron">
        <h1></h1>
        <p></p>
      </div>
      <div class="page-header"><h6><strong>BETA VERSION</strong></h6></div>
		<div class="label label-default">Welcome PS25+ members to our brand new FIFA17 system</div>
		<h5>Register User:</h5>
		<div id="userFormContainer"><?php echo userForm(); ?></div><div id="newUserResult"><?php
			echo allWork();
			?></div><br>
		<div id="resultSubmitTeam">Please Create a team here to get in Leageus!</div>
		<form method="post" action="javascript:createTeam();" id="SubmitTeam">
		<table class="table">
			<tr><td>Team Name: </td><td><input type="text" name="teamName" id="teamName" required></td></tr>
			<tr><td>Select your Username: </td><td><select id="slctUserID" onclick="getUsers();"></select></td></tr>
			
			<tr><td>Submit Team </td><td><button type="submit" id="submitTeam" name="Submit">Submit</button></td></tr>
			<div ><?php
			//echo allWork();
			?></div>
		</table></form>
		<footer>©2017  BY  <a href="http://sofian.co.nf/">DrXtReMe</a> </footer>
	</body>
</html>
<?php
/**
* 
*/
function userForm(){
	if (!$_POST) {
		return '<form method="post" action="" id="userForm">
		<table class="table">
			<tr><td>Name: </td><td><input type="text" name="name" required></td></tr>
			<tr><td>PSN: </td><td><input type="text" name="PSN" required></td></tr>
			<tr><td>FB: </td><td><input type="text" name="FB" required></td></tr>
			<tr><td> </td><td><button type="submit" id="submitUser" name="Submit">Submit</button></td></tr>
			
		</table></form>';
	}else{
		return "";
	}
}
function allWork(){
if(isset($_POST['Submit'])){
	
	date_default_timezone_set('Etc/GMT+2');
	$date = date('d/m/Y h:i:s a', time());
	$name=$_POST['name'];
	$PSN=$_POST['PSN'];
	$FB=$_POST['FB'];
	try{
		if(Database::connect()!==false||null){
			$con=Database::connect();
			$return = Database::createUser($name,$PSN,$FB,$date,$con);
				mysqli_close($con);
				if($return!==false){return $return;}
				}else{
					return "Failed to Database!";
				}
	}catch(Exception $error){
		return "Failed to Database!".$error;
	}
}}

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
	static public function createUser($name,$PSN,$FB, $born, $nexion, $scored=0, $against=0, $won=0, $draw=0, $lost=0,$points=0){
		if($nexion==false){
			return "cant connect";
		}
	$sqlNameCheck="SELECT `name` FROM `users` WHERE name='$name'";
	mysqli_query($nexion,$sqlNameCheck);
	$rowCount=mysqli_affected_rows($nexion);
	$sqlNameCheck="SELECT `PSN` FROM `users` WHERE `PSN`='$PSN'";
	mysqli_query($nexion,$sqlNameCheck);
	$rowCount+=mysqli_affected_rows($nexion);
	if($rowCount==0){
		$sqlInsert=$nexion->prepare("INSERT INTO users (name,PSN,FB, scored, against, won, draw, lost,points,born) 
	  Values (?,?,?,?,?,?,?,?,?,?)");
	  $sqlInsert->bind_param("sssiiiiiis",$name,$PSN,$FB, $scored, $against, $won, $draw, $lost,$points,$born);
	  $sqlInsert->execute();
	  return "user added to database successfully" ;
	}else{
		return "User or PSN already exists!";
	}
	
	}
	static public function createLeague($name,$seasons, $nexion){
		if($nexion==false){
			return "cant connect";
		}
	$sqlInsert=$nexion->prepare("INSERT INTO league (Name,Seasons) 
	  Values (?,?)");
	  $sqlInsert->bind_param("si",$name,$seasons);
	  $sqlInsert->execute();
	  return "line inserted in database successfully" ;
	}
	static public function createSeason($name,$leagueID,$nOfTeams, $nOfGames, $nexion){
		if($nexion==false){
			return "cant connect";
		}
	$sqlInsert=$nexion->prepare("INSERT INTO seasons (Name,LeagueID,nOfTeams, nOfGames) 
	  Values (?,?,?,?)");
	  $sqlInsert->bind_param("siii",$name,$leagueID,$nOfTeams, $nOfGames);
	  $sqlInsert->execute();
	  return "line inserted in database successfully" ;
	}
	static public function createTeam($name,$userID,$leagueID, $seasonID, $nexion, $scored=0, $against=0, $won=0, $draw=0, $lost=0,$points=0,$notPlayed=0){
		if($nexion==false){
			return "cant connect";
		}
	$sqlInsert=$nexion->prepare("INSERT INTO users (Name,userID,leagueID, seasonID, Against, Won, Draw, Lost,Points,notPLayed) 
	  Values (?,?,?,?,?,?,?,?,?,?)");
	  $sqlInsert->bind_param("siiiiiiiii",$name,$userID,$leagueID, $seasonID, $against, $won, $draw, $lost,$points,$notPLayed);
	  $sqlInsert->execute();
	  return "line inserted in database successfully" ;
	}
	static public function createGame($leagueID,$seasonID,$team1ID, $team2ID, $nexion, $team1Goals=0, $team2Goals=0, $date=0, $verified=0){
		if($nexion==false){
			return "cant connect";
		}
	$sqlInsert=$nexion->prepare("INSERT INTO users (leagueID,seasonID,team1ID, team2ID, team1Goals, team2Goals, Date, Verified) 
	  Values (?,?,?,?,?,?,?,?)");
	  $sqlInsert->bind_param("iiiiiisi",$leagueID,$seasonID,$team1ID, $team2ID, $team1Goals, $team2Goals, $date, $verified);
	  $sqlInsert->execute();
	  return "line inserted in database successfully" ;
	}
}
class Users{
	public $ID;
	public $name;
	public $PSN;
	public $FB;
	public $scored;
	public $against;
	public $won;
	public $draw;
	public $lost;
	public $points;
	public $born;
	static public function getUsersStatus($seasonID=0){
		if($seasonID==0){//then all seasons for leaderboards

		}
		else{//Search for specific season users

		}
	}

}
class Leagues{

static public function getLeagues(){//get all leagues from DB

}
}
/**
*  
*/
class Seasons extends Leagues
{
	
	
}
/**
* 
*/
class Teams extends Seasons
{
	
	
}
/**
* 
*/
class Games 
{
	
	
}

?>