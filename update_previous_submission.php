<?php 
$nonce=$_REQUEST['nonce'];

if (! wp_verify_nonce($nonce, 'check-nonce') ) {
echo '<b>Please Select Previous Submitted Record</b> ';
	if($bp->displayed_user->id==$bp->loggedin_user->id)	{
	?><a href = "<?php echo bp_loggedin_user_domain() ?>updatedebt/previoussubmission">Click here to update a previous submission.</a>
	<?php 
	}
}
else {

?><h5>Update Previous Debt Submission</h5>

<p>Your debt amounts for <?=date("M j, Y @ g:i A" ,$_REQUEST[ts])?> have been updated.</p>
<br /><br />

<?
	foreach ($_REQUEST['amount'] as $ID=>$amount) 
	{ 
		$sql = "UPDATE `loans_log` SET `amount` = '".number_format($_REQUEST[amount][$ID],2,'.','')."' WHERE ID = '".$ID."'";
		$result = @mysql_query($sql); if (mysql_error()) { echo mysql_error() . "<br /><br />" . $sql; }
	}
}
?>