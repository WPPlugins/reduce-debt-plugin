<?php 

$user_id = $bp->loggedin_user->id;

$profile_id = $bp->displayed_user->id;

$usermail = displayedUserEmail($profile_id);
$result1 = mysql_fetch_array($usermail);
$displayed_user_email = $result1[user_email];
$adminemail = AdminEmail();
$result2 = mysql_fetch_array($adminemail);

if ($user_id) {

	$this_month = date("n");

	$sql = "select count(user_id) from encourage where DATE_FORMAT(encourage_date, '%c') = $this_month AND user_id = '". $user_id ."'";
	
	$result = mysql_query($sql);
	
	#echo $sql;
	
	$encourage_count = mysql_result($result, 0);

}//if

//Give Encourage
if ($_POST['encourage'] && $encourage_count < 3 && $user_id && $profile_id ) {
	
	$sql = insertEncourage($profile_id, $user_id);
	
	$encourage_count = $encourage_count + 1;

		
	$mailto = $displayed_user_email;
	$subject = 'A friend gave you an Encourage';
	$message = "Greetings ".$bp->displayed_user->userdata->user_login .",

Each user is only allowed to give 3 \"Encourages\" a month.  ".ucfirst($bp->loggedin_user->userdata->user_login)." decided to send one of those three to you.  

".ucfirst($bp->loggedin_user->userdata->user_login)." just wants to let you know that they are thinking about you and wants to encourage you on your financial marathon of reducing debt.  

To respond to ".ucfirst($bp->loggedin_user->userdata->user_login)."'s Encourage, follow this link: 
<a href=\"".bp_loggedin_user_domain()."\">".ucfirst($bp->loggedin_user->userdata->user_login)."'s profile</a>

To view your profile, follow this link: 
<a href=\"".bp_displayed_user_domain()."\">Your Profile</a>


Sincerely,
Admin
Reducing Debt Team";


	$headers = 'From: ' .$result2[user_email]."\r\n" .
    'X-Mailer: PHP/' . phpversion();

	
	mail($mailto, $subject, $message, $headers);
	
	
	echo "<div class = \"success\">
			Give Encourage Success!
			<br>Your remaining account balance is ".(3 - $encourage_count)." Encourages this month.
		</div>";

}//if



$result = getLoan($profile_id);   

$info = mysql_fetch_array ($result);

if (!mysql_num_rows($result)) {
    echo "<h4>Loan Profile Not Created</h4>";
}
else {

$result = getAwards($profile_id);

if ( mysql_num_rows($result) > 1 ) {

	$current_loan = mysql_result($result, 0);
	
	$begin = mysql_num_rows($result) - 1;
	
	$last_loan = mysql_result($result, $begin);
	
	#echo $current_loan;
	#echo '<hr>';
	#echo $last_loan;
	#echo '<hr>';
	#echo ( ($last_loan - $current_loan) * 100 ) / $last_loan;
	
	$decrease = @round(( ($last_loan - $current_loan) * 100 ) / $last_loan);
	
	#echo '<hr>';
	#echo $decrease;
	
	$small_award = '';

	
if ( $decrease >= 100 ) 
{
	echo "Congratulations to ".$bp->displayed_user->userdata->user_login." for earning a Debt Free award!"?>
<a href = "<?php echo bp_loggedin_user_domain() ?>mychartbadge/awards/"> <img border=0 title='I am Debt Free!' alt='I am Debt Free!' src=<?php echo $plugin_path.'/images/adw_bebtfree.png'?>></a>
		 <?php
		$small_award = "<img border=0 title='I am Debt Free!' alt='I an Debt Free!' src=".$plugin_path.'/images/adw_bebtfree_small.png'?>
		<?php
} elseif ($decrease > 75 ) {
		echo "Congratulations to ".$bp->displayed_user->userdata->user_login." for earning a Platinum award! "?>
		<a href = "<?php echo bp_loggedin_user_domain() ?>mychartbadge/awards/"> <img border=0 title='I earned a Platinum Award reducing debt.' alt='I earned a Platinum Award reducing debt.' src=<?php echo $plugin_path.'images/adw_platinum.png'?> /></a>
		<?php 
		$small_award = "<img border=0 title='I earned a Platinum Award.' alt='I earned a Platinum Award.' src=".$plugin_path.'images/adw_platinum_small.png'?>
		<?php	} elseif ($decrease > 50 ) {
		echo "Congratulations to ".$bp->displayed_user->userdata->user_login." for earning a Gold award!"?> 
		<a href = "<?php echo bp_loggedin_user_domain() ?>mychartbadge/awards/"> <img border=0 title='I earned a Gold Award reducing debt.' alt='I earned a Gold Award reducing debt.' src=<?php echo $plugin_path.'images/adw_gold.png'?> /></a>
		<?php	$small_award = "<img border=0 title='I earned a Gold Award.' alt='I earned a Gold Award.' src=".$plugin_path.'images/adw_gold_small.png'?>
		<?php	} elseif ($decrease > 25 ) {
		echo "Congratulations to ".$bp->displayed_user->userdata->user_login." for earning a Silver award!"?>
		 <a href = "<?php echo bp_loggedin_user_domain() ?>mychartbadge/awards/"> <img border=0 title='I earned a Silver Award reducing debt.' alt='I earned a Silver Award reducing debt.' src= <?php echo $plugin_path.'images/adw_silver.png'?> /></a>
		<?php	$small_award = "<img border=0 title='I earned a Silver Award.' alt='I earned a Silver Award.' src=".$plugin_path.'images/adw_silver_small.png'?>
		<?php	} elseif ($decrease > 10 ) {	
		echo "Congratulations to ".$bp->displayed_user->userdata->user_login." for earning a Bronze award!"?>
		<a href = "<?php echo bp_loggedin_user_domain() ?>mychartbadge/awards/"> <img border=0 title='I earned a Bronze Award reducing debt.' alt='I earned a Bronze Award reducing debt.' src=<?php echo $plugin_path.'images/adw_bronze.png'?> /></a>
		<?php	$small_award = "<img border=0 title='I earned a Bronze Award.' alt='I earned a Bronze Award.' src=".$plugin_path.'images/adw_bronze_small.png'?>
		<?php	} else {
		echo $bp->displayed_user->userdata->user_login." is just starting out on their financial marathon."?> 
		<a href = "<?php echo bp_loggedin_user_domain() ?>mychartbadge/awards/"> <img border=0 title='I am a Rookie at reducing debt.' alt='I am a Rookie at reducing debt.' src=<?php echo $plugin_path.'images/adw_rookie.png'?> /></a>
	    <?php	$small_award = "<img border=0 title='I am a Rookie at reducing debt.' alt='I am a Rookie at reducing debt.' src=".$plugin_path.	
		'images/adw_rookie_small.png'?>
			<?php 	}//if*/
}//if


    echo "
        <h4>Last Submitted Amounts</h4>
    <div style = \"width: 150px; float: right; margin-right:100px;\">";
	
	
		$result = getFirstSum($profile_id);
		$first = mysql_fetch_array ($result);

		$result = getLastSum($profile_id);
		$last = mysql_fetch_array ($result);
	?>
        <a href = "<?php echo bp_displayed_user_domain() ?>profile" title= "I am reducing debt" ><img src = "<?php echo $plugin_path.'graph.php?memberID='.$profile_id;?>" alt = "I am reducing debt" border = "0" /> </a>
	<div style = "width: 135px; float: right; margin-left: 20px; margin-bottom: 10px;">
    <div style = "font-size: 11px; margin-top: 5px; line-height: 13px;">
    <div style = "margin-bottom: 4px;"><b>Start Date:</b> <br /><?=date("M-j-y", getFirstLoanDate($profile_id))?></div>
    <div style = "margin-bottom: 4px;"><b>Start Amount:</b><br /><?=number_format($first[amt],2)?></div>
    <div style = "margin-bottom: 4px;"><b>Last Updated:</b> <br /><?=date("M-j-y", getLastLoanDate($profile_id))?></div>
    <div style = "margin-bottom: 4px;"><b>Latest Amount:</b><br /><?=number_format($last[amt],2)?></div>
	<div style = "margin-bottom: 4px;"><b>Encourages left:</b><br /><?
	$this_month = date("n");
	$sql = "select count(user_id) from encourage where DATE_FORMAT(encourage_date, '%c') = $this_month AND user_id = '".$profile_id."'";
	$result = mysql_query($sql);
	echo (3 - mysql_result($result, 0));
	?></div>
    </div>

</div>
		<?php echo "
    </div>
        <table style = \"width:600px\";>
        <tr>
            <td style = \"padding-left: 120px; padding-bottom: 8px;\"; width=\"30%\"><b>Loan</b></td>
            <td style = \"padding-left: 50px;\"; width=\"30%\" ><b>Amount</b></td>
			
        </tr>
    ";
    // Get last Submission
    $result = getMaxTimeStamp($profile_id);
    $row = mysql_fetch_array ($result);

    $record = getData($profile_id,$row[ts]);
    $z = 0;
    while ($list = mysql_fetch_array ($record)) {
        echo "
            <tr>
                <td style = \"padding-left: 120px; padding-bottom: 6px;\">".$list[loan]."</td>
                <td style = \"padding-bottom: 6px; padding-left: 50px; text-align:left;\">".($list[amount] > 0 ? number_format($list[amount],2) : "-")."</td>
            </tr>
        ";
        $t = $list[amount] + $t;
    }

}
echo "
        </td>
    </tr>
    <tr>
        <td style = \"padding-left: 120px;\"><b>Total:</b></td>

		 <td style = \"padding-left: 50px;\"; ><b>".number_format($t,2)."</b></td>
    </tr>
    </table>
    <br /><br /><br /><br />";?>
	
<?php
	$result = earnEncourage($profile_id);
	$earn_encourage = mysql_result($result, 0);
?>
<div>
<h5>Encourages <?=$bp->displayed_user->userdata->user_login;?> recieved <img border="0" src="<?php echo $plugin_path.'images/encourage_button.png'?>" align="absmiddle" alt="I've been encouraged to reduce debt." title="I've been encouraged to reduce debt."/> (<?=$earn_encourage?>)</h5>
</div>
<br /><br />
<h5>Encourage <?=$bp->displayed_user->userdata->user_login;?></h5>

<?php
if ($encourage_count < 3 && $user_id) {
?>
<form method="post" action="">
<input value="1" name="encourage" type="hidden">

Give an Encourage 
<input type="image" border="0" src="<?php echo $plugin_path.'images/encourage_button.png'?>" alt="Send an Encouragement" align="absmiddle" /> 

</form>
<?php
}//if
?>

