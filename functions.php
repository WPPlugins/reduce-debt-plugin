<?php
function selectAmount($ID){

$sql = "SELECT * FROM loans l LEFT JOIN loans_log ll ON ll.loanID = l.ID WHERE l.memberID = '".$ID."'";
$result = @mysql_query($sql);
return $result1;

}
function getFirstLoanDate($memberID) {
    global $db;
    $sql = "SELECT MIN(timestamp) d FROM `loans` l JOIN `loans_log` ll ON ll.loanID = l.ID
							WHERE 
			memberID = '".$memberID."'";
    $result = @mysql_query($sql); if (mysql_error()) { echo mysql_error() . "<br /><br />" . $sql; }
    $row = mysql_fetch_array ($result);
    return $row[d];

}

function getLastLoanDate($memberID) {

    $sql = "SELECT MAX(timestamp) d FROM `loans` l JOIN `loans_log` ll ON ll.loanID = l.ID
								WHERE 
			memberID = '".$memberID."'";
    $result = @mysql_query($sql); if (mysql_error()) { echo mysql_error() . "<br /><br />" . $sql; }
    $row = mysql_fetch_array ($result);
    return $row[d];

}

/*function getTotalLoanDates($memberID) {
    global $db;
    $sql = "SELECT DISTINCT(timestamp) d FROM `loans` l
        JOIN `loans_log` ll ON ll.loanID = l.ID
        WHERE memberID = '".$memberID."'";
    $result = @mysql_query($sql,$db); if (mysql_error()) { echo mysql_error() . "<br /><br />" . $sql; }
    return mysql_num_rows($result);

}*/

function getLoan($ID) {         //Function for getting data from loans table on the basis of user id.
	
	$loan = "SELECT * FROM loans l WHERE l.memberID = '".$ID."'";
	
	$result = @mysql_query($loan); if (mysql_error()) { echo mysql_error() . "<br /><br />" . $loan; }
	return $result;
}

function getFirstSum($ID){      //Function for getting sum of first amount

	$sql = "SELECT SUM(amount) amt FROM `loans_log` ll JOIN loans l ON ll.loanID = l.ID 
											WHERE 
		   `timestamp` = '".getFirstLoanDate($ID)."' AND l.memberID = '".$ID."'";
		   
		   
		   
		    
	$result = mysql_query($sql);
	return $result;
}

function getLastSum($ID) {       //Function for getting sum of last amount.

	$sql = "SELECT SUM(amount) amt FROM `loans_log` ll JOIN loans l ON ll.loanID = l.ID 
											WHERE 
			`timestamp` = '".getLastLoanDate($ID)."'AND l.memberID = '".$ID."'";
				
	$result = mysql_query($sql);
	return $result;
}
	
	
	
function getMaxTimeStamp($ID) {          //Function for getting sum max time stamp.

	$sql = "SELECT MAX(timestamp) ts FROM `loans_log` ll JOIN `loans` l ON l.ID = ll.loanID AND l.memberID = '".$ID."'";
				
    $result = @mysql_query($sql); if (mysql_error()) { echo mysql_error() . "<br /><br />" . $sql; }
	return $result;
}


function getData($ID,$tstamp) {        //Function for getting sum max time stamp.

	$sql = "SELECT l.ID, l.loan, ll.amount FROM loans l LEFT JOIN loans_log ll ON ll.loanID = l.ID
								WHERE 
		    l.memberID = '".$ID."' AND `timestamp` = '".$tstamp."'";
			
			 
    $result = @mysql_query($sql); if (mysql_error()) { echo mysql_error() . "<br /><br />" . $sql; }
	return $result;
}


function updateLoan($loan,$ID,$memberID){

	$sql ="UPDATE `loans` SET `loan` = '".$loan."' WHERE `ID` = '".$ID."' AND `memberID` = '".$memberID."'";
	
	$result = @mysql_query($sql); if (mysql_error()) { echo mysql_error() . "<br /><br />" . $sql; }
	return $result;

}

function insert($ID,$amount){

	$sql = "INSERT INTO `loans_log` SET `loanID` = '".$ID."', `amount` = '".number_format($amount,2,'.','')."', 
		   `timestamp` = '".time()."',`month` = '".date("n")."', `day` = '".date("j")."', `year` = '".(date("Y"))."'";
	$result = @mysql_query($sql); if (mysql_error()) { echo mysql_error() . "<br /><br />" . $sql; }
	return $result;

}


function updateLoanExtra($loan,$ID){

	$sql = "INSERT INTO `loans` SET `loan` = '".$loan."', `memberID` = '".$ID."'";
	
	$result = @mysql_query($sql); if (mysql_error()) { echo mysql_error() . "<br /><br />" . $sql; }
	return $result;

}

function insertExtra($ID,$newamount){

	$sql = "INSERT INTO `loans_log` SET `loanID` = '".$ID."', `amount` = '".number_format($newamount,2,'.','')."', `timestamp` = 
			'".time()."', `month` = '".date("n")."', `day` = '".date("j")."', `year` = '".(date("Y"))."'";
			
	$result = @mysql_query($sql); if (mysql_error()) { echo mysql_error() . "<br /><br />" . $sql; }
	return $result;

}


function displayedUserEmail($ID){

	$usermail = "select user_email from wp_users where ID='". $ID ."'";
	
	$result = mysql_query($usermail);
	return $result;
}


function AdminEmail(){

	$usermail = "select user_email from wp_users where ID='1'";
	
	$result = mysql_query($usermail);
	return $result;
}


/*function Encourage($month,$ID)
{ 
$sql = "select count(user_id) from encourage where DATE_FORMAT(encourage_date, '%c') = $month AND user_id = '".$ID."'";
$result = mysql_query($sql);
return $result;
}*/

function insertEncourage($pID,$uID){

	$sql = "INSERT INTO encourage(`profile_id`, `user_id`, `encourage_date`) values($pID, $uID, now())";
	
	$result = mysql_query($sql);
	return $result;
}

function getAwards($ID){

	$sql = "SELECT SUM(amount) amt FROM `loans_log` ll JOIN loans l ON ll.loanID = l.ID 
							WHERE 
			l.memberID = '".$ID."' Group by `timestamp`	Order by timestamp DESC";
			
	$result = mysql_query($sql);
	return $result;
}

function earnEncourage($ID){
	$sql = "select count(profile_id) from encourage where profile_id = '".$ID."'";
	
	$result = mysql_query($sql);
	return $result;
}

function updateMonthlyReminder($memberID,$val)
{
	$sql ="UPDATE `mailreminder` SET `sendMonthlyReminders` = '".$val."'  WHERE `memberID` = '".$memberID."'";
	$result = @mysql_query($sql); if (mysql_error()) { echo mysql_error() . "<br /><br />" . $sql; }
	return $result;
}

function updateUserMail($memberID)
{
	$sql ="INSERT INTO mailreminder(`memberID`) values($memberID)";
		
	$result = @mysql_query($sql); if (mysql_error()) { echo mysql_error() . "<br /><br />" . $sql; }
	return $result;
}

function selectUserMailRec($memberID)
{
	$sql ="SELECT * FROM mailreminder WHERE `memberID` = '".$memberID."'";
	
	$result = @mysql_query($sql); if (mysql_error()) { echo mysql_error() . "<br /><br />" . $sql; }
	return $result;
}

function insertMailRec()
{
	$sql ="INSERT INTO maildates(`date`) values('".date('Y-m-d')."')";
		
	$result = @mysql_query($sql); if (mysql_error()) { echo mysql_error() . "<br /><br />" . $sql; }
	return $result;
}

function getMailDate()
{
	$sql ="SELECT * FROM maildates ";
	
	$result = @mysql_query($sql); if (mysql_error()) { echo mysql_error() . "<br /><br />" . $sql; }
	return $result;

}
