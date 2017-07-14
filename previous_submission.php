<h5>Update Previous Debt Submission</h5>

<p>To make a correction to a previously entered debt submission, select a date below.</p>

<?php 
if($bp->displayed_user->id==$bp->loggedin_user->id)
{
	$nonce= wp_create_nonce  ('my-nonce');
	$sql = "SELECT DISTINCT(timestamp) d FROM `loans` l JOIN `loans_log` ll ON ll.loanID = l.ID WHERE memberID = '".$bp->displayed_user->id."' ORDER BY `timestamp` DESC";
	
	$result = @mysql_query($sql); if (mysql_error()) { echo mysql_error() . "<br /><br />" . $sql; }
	while ($list = mysql_fetch_array ($result)) 
	{
	echo "<div>"?><a href="<?php echo bp_loggedin_user_domain();?>updatedebt/checkprevioussubmission?ts=<?=$list[d];?>&wpnonce=<?php echo $nonce;?>"><?php echo date("M j, Y @ g:i A" ,$list[d]);?></a><?php echo "</div>";
	}

}
?>

