

<?php
ini_set('html_errors', false);
error_reporting(E_ALL);
ini_set('display_errors', 1);
/**
* 
*/
if(isset($_POST['pass'])){
	$user=$_POST['username'];
	$pass=$_POST['pass'];
	$userID=$_POST['userID'];
	echo FileBase::addAdmin($user,$pass,$userID);

}
if(isset($_POST['SubmitUser'])){
	
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
}
if(isset($_POST['leagueName'])){
	$name=$_POST['leagueName'];
	try{
		if(Database::connect()!==false||null){
			$con=Database::connect();
			$return=Database::createLeague($name,$con);
			mysqli_close($con);
			if($return!==false){echo $return;}

		}
		else{
			echo "Failed to Database!";
		}
	}catch(Exception $error){
		echo "Failed to Database!".$error;
	}
}
if(isset($_POST['SubmitSeason'])){
	$name=$_POST['seasonName'];
	$leagueID=$_POST['leagueID'];
	try{
		if(Database::connect()!==false||null){
			$con=Database::connect();
			$return=Database::createSeason($name,$leagueID,$con);
			mysql_close($con);
			if($return!==false){return $return;}

		}
		else{
			return "Failed to Database!";
		}
	}catch(Exception $error){
		return "Failed to Database!".$error;
	}
}
if(isset($_POST['SubmitTeam'])){
	$name=$_POST['TeamName'];//stopped here tonight finish filling up using functions in post from ajax and then use js and maybe send from one php to another too then make it pretty!;
	$leagueID=$_POST['leagueID'];
	$userID=$_POST['userID'];
	$seasonID=$_POST['seasonID'];
	try{
		if(Database::connect()!==false||null){
			$con=Database::connect();
			$return=Database::createTeam($name,$userID,$leagueID,$seasonID,$con);
			mysql_close($con);
			if($return!==false){return $return;}

		}
		else{
			return "Failed to Database!";
		}
	}catch(Exception $error){
		return "Failed to Database!".$error;
	}
}
if(isset($_POST['SubmitGame'])){
	$seasonID=$_POST['seasonID'];
	$leagueID=$_POST['leagueID'];
	$team1ID=$_POST['team1ID'];
	$team2ID=$_POST['team2ID'];
	date_default_timezone_set('Etc/GMT+2');
	$date = date('d/m/Y h:i:s a', time());
	try{
		if(Database::connect()!==false||null){
			$con=Database::connect();
			$return=Database::createSeason($leagueID,$seasonID,$team1ID,$team2ID,$date,$con);
			mysql_close($con);
			if($return!==false){return $return;}

		}
		else{
			return "Failed to Database!";
		}
	}catch(Exception $error){
		return "Failed to Database!".$error;
	}
}

//get functions to select intelligently from DB here .....

if(isset($_POST['getLeagues'])){
	$output= Database::selectAllLeagues();
	//echo $output;
	
}
if(isset($_POST['addSeason'])){
	$leagueID=$_POST['addSeason'];
	$seasons=$_POST['seasons'];
	Database::addSeason($leagueID,$seasons);
}
if(isset($_POST['getUsers'])){
	$output=Database::selectAllusers();
}
if(isset($_POST['userID4Team'])){
	$con=Database::connect();
	 $TeamName=$_POST['TeamName'];
	 $userID=$_POST['userID4Team'];
	 $output=Database::createTeam($TeamName,$userID,$con);
	 echo $output;
}
if(isset($_POST['leagueID4Teams'])){
	$leagueID=$_POST['leagueID4Teams'];
	$seasonID=$_POST['seasonID4Teams'];
	$forRankings=0;
	if(isset($_POST['forRankings'])){
		$forRankings=$_POST['forRankings'];
	}
	$output=Database::getTeams($leagueID,$seasonID,0,$forRankings);
}
if(isset($_POST['addTeamSeason'])){
	$teamID=$_POST['teamID'];
	$leagueID=$_POST['leagueID'];
	$seasonID=$_POST['seasonID4Teams'];
	$output=Database::addTeamSeason($teamID,$leagueID,$seasonID);
}
if(isset($_POST['notPlayedGames'])){
	$leagueID=$_POST['leagueID4Games'];
	$seasonID=$_POST['seasonID4Games'];
	$notPlayedGames=$_POST['notPlayedGames'];
	$forRankings=0;
	if(isset($_POST['forRankings'])){
		$forRankings=$_POST['forRankings'];
	}
	$output=Database::getTeams($leagueID,$seasonID,$notPlayedGames,$forRankings);
}
if(isset($_POST['gameSubmitByUser'])){
	$leagueID=$_POST['leagueID'];
	$seasonID=$_POST['seasonID'];
	$t1ID=$_POST['t1ID'];
	$t2ID=$_POST['t2ID'];
	$t1g=$_POST['t1g'];
	$t2g=$_POST['t2g'];
	$verified=0;
	date_default_timezone_set('Etc/GMT+2');
	$date = date('d/m/Y h:i:s a', time());
	$output=Database::gameSubmitByUser($leagueID,$seasonID,$t1ID,$t2ID,$t1g,$t2g,$date,$verified);
	echo $output;
}
if(isset($_POST['gimmeLeaderboards'])){
	Database::selectAllUsersLeaderboards();
}
if(isset($_POST['Encryption'])){
	// .. code managing encrypted admin connection to mangle stuff like verifying game results!!
}
if(isset($_POST['adminVerifyGames'])){
	$team1ID=$_POST['team1ID'];
	$team2ID=$_POST['team2ID'];
	$user1Goals=$_POST['user1Goals'];
	$user2Goals=$_POST['user2Goals'];
	$gameID=$_POST['gameID'];
	$output=Database::submitGameAdmin($team1ID,$team2ID,$user1Goals,$user2Goals,$gameID);
	echo $output;
}
if(isset($_POST['gimmeGames'])){
	Database::selectAllGames();
}
if(isset($_POST['seasonID4Schedule'])){
	$leagueID=$_POST['leagueID4Schedule'];
	$seasonID=$_POST['seasonID4Schedule'];
	$output=Database::getSchedule($leagueID,$seasonID);
	echo $output;
	}
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
	// the following is deprecated now we use registerUser.php
	static public function createUser($name,$PSN,$FB, $born, $nexion, $scored=0, $against=0, $won=0, $draw=0, $lost=0,$points=0){
		if($nexion==false){
			return "cant connect";
		}
	$sqlInsert=$nexion->prepare("INSERT INTO users (name,PSN,FB, scored, against, won, draw, lost,points,born) 
	  Values (?,?,?,?,?,?,?,?,?,?)");
	  $sqlInsert->bind_param("sssiiiiiis",$name,$PSN,$FB, $scored, $against, $won, $draw, $lost,$points,$born);
	  $sqlInsert->execute();
	  mysqli_close($nexion);
	  return "line inserted in database successfully" ;
	}
	static public function createLeague($name,$nexion,$seasons=0 ){
		if($nexion==false){
			return "cant connect";
		}
	$sqlInsert=$nexion->prepare("INSERT INTO league (Name,Seasons) 
	  Values (?,?)");
	  $sqlInsert->bind_param("si",$name,$seasons);
	  $sqlInsert->execute();
	  mysqli_close($nexion);
	  return 1 ;
	}
	static public function createSeason($name,$leagueID, $nexion,$nOfTeams=0, $nOfGames=0){
		if($nexion==false){
			return "cant connect";
		}
	$sqlInsert=$nexion->prepare("INSERT INTO seasons (Name,LeagueID,nOfTeams, nOfGames) 
	  Values (?,?,?,?)");
	  $sqlInsert->bind_param("siii",$name,$leagueID,$nOfTeams, $nOfGames);
	  $sqlInsert->execute();
	  mysqli_close($nexion);
	  return "line inserted in database successfully" ;
	}
	static public function createTeam($name,$userID, $nexion,$leagueID=0, $seasonID=0, $scored=0, $against=0, $won=0, $draw=0, $lost=0,$points=0,$notPlayed=0){
		if($nexion==false){
			return "cant connect";
		}
	$sqlInsert=$nexion->prepare("INSERT INTO `teams` (Name, userID, leagueID, seasonID, Scored, Against, Won, Draw, Lost, Points, notPLayed) 
	  Values (?,?,?,?,?,?,?,?,?,?,?)");
	  $sqlInsert->bind_param("siiiiiiiiii",$name,$userID,$leagueID, $seasonID, $scored, $against, $won, $draw, $lost,$points,$notPlayed);
	  $sqlInsert->execute();
	  mysqli_close($nexion);
	  return $sqlInsert->insert_id ;
	}
	static public function createGame($leagueID,$seasonID,$team1ID, $team2ID,$date, $nexion, $team1Goals=0, $team2Goals=0,  $verified=0){
		if($nexion==false){
			return "cant connect";
		}
	$sqlInsert=$nexion->prepare("INSERT INTO users (leagueID,seasonID,team1ID, team2ID, team1Goals, team2Goals, Date, Verified) 
	  Values (?,?,?,?,?,?,?,?)");
	  $sqlInsert->bind_param("iiiiiisi",$leagueID,$seasonID,$team1ID, $team2ID, $team1Goals, $team2Goals, $date, $verified);
	  $sqlInsert->execute();
	  mysqli_close($nexion);
	  return "line inserted in database successfully" ;
	}
	static public function selectAllLeagues($nameEquals=0){
		if($nameEquals==0){ 
		//$outName=array();
		//$outSeasons=array();           // NAMEeQUALS MUST BE A ZEEROO 0000 SO FAR AND IN CASE 0 ITS SELECT ALL******	
		$sqlSelect = ("SELECT * FROM `league`");
		//edit 
		$arr="";
		$resolto=mysqli_query(Database::connect(),$sqlSelect);
		 while ($row=$resolto->fetch_assoc()){
		 	//$ID=$row['ID'];
		 	echo $row['Name'];echo ",";
		 	echo $row['Seasons'];echo ",";
		 	echo $row['ID'];echo "^";
    		//$arr+= $name.",".$seasons." " ;
    		//$outSeasons=array_push($outSeasons,);
		}
		
		

		//return $arr;
		
		}
		else{

		}
		mysqli_close(Database::connect());
	}
	static public function addSeason($leagueID,$seasons){
		if($leagueID!=2){
		$sqlUpdateInsert = ("UPDATE `league` SET `Seasons`=".$seasons." WHERE ID=".$leagueID.";");
		$sqlUpdateInsert .=("INSERT INTO `seasons`(`Name`, `LeagueID`, `nOfTeams`, `nOfGames`) VALUES (".$seasons.",".$leagueID.",0,0)");
		//edit 
		$arr="";
		$resolto=mysqli_multi_query(Database::connect(),$sqlUpdateInsert);
		$finalResult=0;
		 
		 	$finalResult=$resolto;
		echo $finalResult;}
		else{
			echo "you are not allowed to add seasons to this league";
		}
		mysqli_close(Database::connect());
	}
	static public function selectAllUsers(){
		$sqlSelect = ("SELECT * FROM `users`");
		//edit 
		$arr="";
		$resolto=mysqli_query(Database::connect(),$sqlSelect);
		 while ($row=$resolto->fetch_assoc()){
		 	//$ID=$row['ID'];
		 	echo $row['ID'];echo ",";
		 	echo $row['Name'];echo "^";
    		//$arr+= $name.",".$seasons." " ;
    		//$outSeasons=array_push($outSeasons,);
		}
		mysqli_close(Database::connect());
	}
	//this funct. gets teams for various reasons (ex. for ranking tables)
	static public function getTeams($leagueID,$seasonID,$notPlayedGames=0,$forRankings=0){
		//ifleague and seasons id's are zeroes then it brings teams that are not in any and its for adding teams to season
		$sqlSelect = ("SELECT * FROM `teams` WHERE leagueID = $leagueID AND seasonID = $seasonID ");
		//if we want teams that have more games to play
		if($notPlayedGames==1){
			$sqlSelect.=" AND notPlayed != 0";
		}//if it were for rankings tabbles sort it out by points then goal diff. then goals scored then name.
		if($forRankings!=0){
			$sqlSelect .=" ORDER BY Points DESC , Scored - Against DESC , Scored DESC , Name ;";
		}
		//run sqli
		$resolto=mysqli_query(Database::connect(),$sqlSelect);
		 while ($row=$resolto->fetch_assoc()){
		 	//pass to js in string values
		 	//for each team also get PSN id and glue it to the name string for client side
		 	$sqlSelectUzer = ("SELECT `PSN` FROM `users` WHERE `ID` = '$row[userID]' ;");
		 	$resoltoto=mysqli_query(Database::connect(),$sqlSelectUzer);
		 	while ($rowto=$resoltoto->fetch_assoc()){
		 		$PSN=$rowto['PSN'];
		 	}
		 	echo $row['ID'];echo ",";
		 	echo $row['Name']." (".$PSN.")";echo ",";
		 	echo $row['userID'];echo ",";
		 	echo $row['leagueID'];echo ",";
		 	echo $row['seasonID'];echo ",";
		 	echo $row['Scored'];echo ",";
		 	echo $row['Against'];echo ",";
		 	echo $row['Won'];echo ",";
		 	echo $row['Lost'];echo ",";
		 	echo $row['Draw'];echo ",";
		 	echo $row['Points'];echo ",";
		 	echo $row['notPlayed'];echo "^";

    		
		}
		mysqli_close(Database::connect());
	}
	static public function addTeamSeason($teamID2,$leagueID,$seasonID){
		$sqlSelectSeason="SELECT `nOfTeams`, `nOfGames` FROM `seasons` WHERE `Name` = '$seasonID' AND `leagueID`= '$leagueID' ;";
		$resolto=mysqli_query(Database::connect(),$sqlSelectSeason);
		$noTeams=0;
		$noGames=0;
		while ($row=$resolto->fetch_assoc()) {
			if($row['nOfTeams']>0){
				$noTeams=(int)$row['nOfTeams'];
				if($row['nOfGames']>0){
				$noGames=(int)$row['nOfGames'];
				}
			}
		}
		(int)$teamID=(int)$teamID2;
		(int)$noTeams+=1;
		$tempMath=$noTeams-1;
		//(int)$tempMath*=2;
		(int)$noGames=$tempMath*2;
		$sqlUpdateSeasonTeam ="UPDATE `seasons` SET `nOfTeams`='$noTeams', `nOfGames`='$noGames' WHERE `Name` = '$seasonID' AND `leagueID`= '$leagueID'  ;";
		$sqlUpdateSeasonTeam2 ="UPDATE `teams` SET `leagueID` = '$leagueID' , `seasonID` = '$seasonID' , `notPlayed` = '$noGames' WHERE `ID` = '$teamID' ;";
		$resolto2=mysqli_query(Database::connect(),$sqlUpdateSeasonTeam2);
		$resolto=mysqli_query(Database::connect(),$sqlUpdateSeasonTeam);
		$sqlSelectNpTeams="SELECT * FROM `teams` WHERE `seasonID` = '$seasonID' AND `leagueID`= '$leagueID' ;";
		$npResult=mysqli_query(Database::connect(),$sqlSelectNpTeams);
		while ($saf=$npResult->fetch_assoc()) {
			(int)$played=$saf['Won']+$saf['Lost']+$saf['Draw'];
			(int)$notPlayed=$noGames-$played;
			//($tempMath-($saf['Won']+$saf['Lost']+$saf['Draw']);
			//$tempNp=(int)$notPlayed+2;
			$notPlayedID=(int)$saf['ID'];
			if($notPlayedID!==$teamID){
				$sqlUpdateNpTeams="UPDATE `teams` SET `notPlayed`='$notPlayed' WHERE `ID` = '$notPlayedID' ;";
				$sqlUpdateNpTeamsResult=mysqli_query(Database::connect(),$sqlUpdateNpTeams);
			}
		}
		
		$finalResult=0;
		$finalResult=$resolto;
		
		$finalResult2=$resolto2;
		echo $finalResult+$finalResult2;
		mysqli_close(Database::connect());
	}
	static public function gameSubmitByUser($leagueID,$seasonID,$t1ID,$t2ID,$t1g,$t2g,$date,$verified){
		$nexion=Database::connect();
		if($nexion==false){
			return "cant connect";
		}
		//check if teams played two verified games against each other first.
		$gameCount=0;
		$selectSql="SELECT `ID` FROM `games` WHERE (`leagueID`='$leagueID' AND `seasonID`='$seasonID' AND `team1ID`='$t1ID' AND `team2ID`='$t2ID') OR (`leagueID`='$leagueID' AND `seasonID`='$seasonID' AND `team1ID`='$t2ID' AND `team2ID`='$t1ID') ;";
		$resolt=mysqli_query($nexion,$selectSql);
	 	while ($row=$resolt->fetch_assoc()){
	 		$gameCount++;
	 	}
	 	if($gameCount>1){

		 return -1;
	 	}
		$sqlInsert=$nexion->prepare("INSERT INTO `games`(`leagueID`, `seasonID`, `team1ID`, `team2ID`, `team1Goals`, `team2Goals`, `Date`, `Verified`)
 		VALUES (?,?,?,?,?,?,?,?)");
	  	$sqlInsert->bind_param("iiiiiisi",$leagueID,$seasonID,$t1ID,$t2ID,$t1g,$t2g,$date,$verified);
	  	$sqlInsert->execute();
	  	mysqli_close($nexion);
	  	return $sqlInsert->insert_id ;
	}
	static public function selectAllUsersLeaderboards(){
		$sqlSelect = ("SELECT * FROM `users` ORDER BY Points DESC , Scored - Against DESC , Scored DESC , Name");
		
		//$arr="";
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
	static public function selectAllGames(){
		$sqlSelect = ("SELECT * FROM `games` WHERE `Verified`='0';");
		
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
	static public function submitGameAdmin($team1ID,$team2ID,$user1Goals,$user2Goals,$gameID){
		$user1ID=0;
		$user2ID=0;
		$scored1=0;
		$scored2=0;
		$agnst1=0;
		$agnst2=0;
		$won1=0;
		$won2=0;
		$lost1=0;
		$lost2=0;
		$draw1=0;
		$draw2=0;
		$points1=0;
		$points2=0;
		$np1=0;
		$np2=0;
		//check if teams played two verified games against each other first.
		$gameCount=0;
		$selectSql="SELECT `ID` FROM `games` WHERE ( `team1ID`='$team1ID' AND `team2ID`='$team2ID' AND `Verified`='1') OR ( `team1ID`='$team2ID' AND `team2ID`='$team1ID' AND `Verified`='1') ;";
		$resolt=mysqli_query(Database::connect(),$selectSql);
	 	while ($row=$resolt->fetch_assoc()){
	 		$gameCount++;
	 	}
	 	if($gameCount>1){

		 return -1;
	 	}
		$sqlSelectTeam1="SELECT * FROM `teams` WHERE ID='$team1ID' ;";
		$resolto=mysqli_query(Database::connect(),$sqlSelectTeam1);
		 while ($row=$resolto->fetch_assoc()){
		 	$user1ID=(int)$row['userID'];
		 	$scored1= (int)$row['Scored'];
		 	$agnst1= (int)$row['Against'];
		 	$won1=(int)$row['Won'];
		 	$lost1=(int)$row['Lost'];
		 	$draw1=(int)$row['Draw'];
		 	$points1=(int)$row['Points'];
		 	$np1=(int)$row['notPlayed'];
    		
		}
		$sqlSelectTeam2="SELECT * FROM `teams` WHERE ID='$team2ID' ;";
		$resolto2=mysqli_query(Database::connect(),$sqlSelectTeam2);
		 while ($row=$resolto2->fetch_assoc()){
		 	$user2ID=(int)$row['userID'];
		 	$scored2= (int)$row['Scored'];
		 	$agnst2=(int)$row['Against'];
		 	$won2=(int)$row['Won'];
		 	$lost2=(int)$row['Lost'];
		 	$draw2=(int)$row['Draw'];
		 	$points2=(int)$row['Points'];
		 	$np2=(int)$row['notPlayed'];
    		
		}
		$scored1+=$user1Goals;
		$scored2+=$user2Goals;
		$agnst1+=$user2Goals;
		$agnst2+=$user1Goals;
		$np1-=1;
		$np2-=1;
		if($user1Goals>$user2Goals){
			$won1+=1;$points1+=3;
			$lost2+=1;
		}
		else if($user2Goals>$user1Goals){
			$won2+=1;$points2+=3;
			$lost1+=1;
		}
		else if($user1Goals==$user2Goals){
			$draw1+=1;$points1+=1;
			$draw2+=1;$points2+=1;
		}

		$sqlUpdateTeam1Team2User1User2Game="UPDATE `teams` SET `Scored`='$scored1', `Against`='$agnst1', `Won`='$won1', `Lost`='$lost1', `Draw`='$draw1', `Points`='$points1', `notPlayed`='$np1' WHERE ID='$team1ID' ;";
		$sqlUpdateTeam1Team2User1User2Game.="UPDATE `teams` SET `Scored`='$scored2', `Against`='$agnst2', `Won`='$won2', `Lost`='$lost2', `Draw`='$draw2', `Points`='$points2', `notPlayed`='$np2' WHERE ID='$team2ID' ;";
		//$sqlUpdateTeam1Team2User1User2Game.="UPDATE `users` SET `Scored`='$scored1', `Against`='$agnst1', `Won`='$won1', `Lost`='$lost1', `Draw`='$draw1', `Points`='$points1', `notPlayed`='$np1' WHERE ID='$user1ID';";
		//$sqlUpdateTeam1Team2User1User2Game.="UPDATE `users` SET `Scored`='$scored2', `Against`='$agnst2', `Won`='$won2', `Lost`='$lost2', `Draw`='$draw2', `Points`='$points2', `notPlayed`='$np2' WHERE ID='$user2ID' ;";
		//$sqlUpdateTeam1Team2User1User2Game.="UPDATE `games` SET `Verified`='1' WHERE `ID`='$gameID';";
		$resoltoFinal=mysqli_multi_query(Database::connect(),$sqlUpdateTeam1Team2User1User2Game);
		$sqltestalone="UPDATE `games` SET `Verified` = '1' WHERE `games`.`ID` = $gameID ;";
		$resoltoAlone=mysqli_query(Database::connect(),$sqltestalone);

		mysqli_close(Database::connect());
		if($resoltoAlone==false){
			return "failed to verify";
		}
		if($resoltoFinal==false){
			return "Unable to verify results";
		}
		return $resoltoFinal;
	}

	static public function getSchedule($leagueID,$seasonID){
		$sqlSchedule="SELECT * FROM `games` WHERE `leagueID` = '$leagueID' AND `seasonID` = '$seasonID' AND `Verified` = '1' ;";
		$result=mysqli_query(Database::connect(),$sqlSchedule);
		while ($row=$result->fetch_assoc()){
			
		 	$team1ID=$row['team1ID'];
		 	$team2ID=$row['team2ID'];
		 	$team1Goals=$row['team1Goals'];
		 	$team2Goals=$row['team2Goals'];
		 	$Date=$row['Date'];
		 	$sqlTeamName="SELECT `Name` FROM `teams` WHERE `ID` = '$team1ID' ;";
		 	$team1Name;
		 	$resalt=mysqli_query(Database::connect(),$sqlTeamName);
		 	while ($rowa=$resalt->fetch_assoc()){
		 		$team1Name=$rowa['Name'];
		 	}

		 	$sqlTeamName2="SELECT `Name` FROM `teams` WHERE `ID` = '$team2ID' ;";
		 	$team2Name;
		 	$resalt2=mysqli_query(Database::connect(),$sqlTeamName2);
		 	while ($rowa2=$resalt2->fetch_assoc()){
		 		$team2Name=$rowa2['Name'];
		 	}

		 	echo $team1Name;echo ",";
		 	echo $team1Goals;echo ",";
			echo $team2Goals;echo ",";
			echo $team2Name;echo ",";
			echo $Date;echo "^";
			mysqli_close(Database::connect());
		}
	}
	static public function sqlAdminAdd( $username , $userID){
		
		$nexion=Database::connect();
		//turns out you MUST put it in a variable forst before sqling it
		$sqlInsert=$nexion->prepare("INSERT INTO `admins` (`username`, `userID`) Values (?,?)");
		$sqlInsert->bind_param("si",$username , $userID);
		$sqlInsert->execute();
		return $sqlInsert->insert_id ;
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

class FileBase{
	public static function addAdmin($username,$pass,$userID){
		$oldData="";
		try{
		if(file_exists("feel.txt")){
			$oldData=file_get_contents("feel.txt");
			
			//$username=nl2br(htmlspecialchars($username);
			$oldDataArray=preg_split("[\^]", $oldData);
			foreach  ($oldDataArray as $user) {
				if(preg_split("[,]",$user)[0]==$username){
					return "-1";//admin already exists
				}

			}
			$result=Database::sqlAdminAdd( $username , $userID);
			
			if(!$result){
				$result=0;
			}
			elseif ($result>1) {
				$result=1;
			}
			$newData=$username.",".$pass."^";
			$handle=fopen("feel.txt", "w");
			fwrite($handle,$oldData.$newData);
			fclose($handle);
			return 1+$result;
		}

		}catch(Exception $s){
			return "0";
		}
	}
}

?>