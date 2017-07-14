<h1>My Chart Badge</h1>

<a href = "<?php echo bp_loggedin_user_domain() ?>profile" title= "I am reducing debt" style="padding-left:20px;"><img src = "<?php echo $plugin_path.'graph.php?memberID='.$bp->displayed_user->id;?>" alt = "I am reducing debt" border = "0" /></a>

<br /><br />
Copy and paste the following HTML text for use on your own website, blog, or social network.
<br /><br />
<textarea type = "text" value = "" name = "my_chart" style = "width: 655px; height: 70px;" /><a href = "<?php echo bp_loggedin_user_domain() ?>profile" title= "I am reducing debt." style="padding-left:20px;"><img src = "<?php echo $plugin_path.'graph.php?memberID='.$bp->displayed_user->id;?>" alt = "I am reducing debt." border = "0" /></a></textarea>
<br /><br />
<?php $sel = selectUserMailRec($bp->loggedin_user->id);
	  $result = mysql_fetch_array($sel);
?>
<form name="mailreminder" method="post">
<input type="checkbox" name="email_reminder" <?php if($result[sendMonthlyReminders]==1) {?> checked="checked" <?php }?> /> Uncheck to stop monthly reminder email.
<br/><br/><input type = "submit" value = "Update"/>
<input type="hidden" value="1" name="update" />
</form>
