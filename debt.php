<?php

global $wp_version;
define ( 'BP_MESSAGES_DB_VERSION', '2000' );

$exit_msg = 'Reduce Debt Plugin requires WordPress 3.1 or newer. <a href="http://codex.wordpress.org/Upgrading_WordPress">Please update!</a>'; 
if (version_compare($wp_version,"3.1","<"))
 { 
     exit ($exit_msg); 
 } 
 

include_once("functions.php");

/////////////////////////LOAN INPUT/UPDATE////////////////////////////
function add_submenu() {
	global $bp;

	bp_core_new_nav_item( 
						array( 'name' => __( 'Reduce Debt', 'debt-page' ), 
							   'slug' => 'updatedebt', 'position' => 110, 
							   'screen_function' => 'display_function',
							   'default_subnav_slug' => 'lastsubmission',
							   'show_for_displayed_user' => true,
							   'screen_function' =>'Last_Submission' ) 
		 			    );
	   
   $updatedebt = 'updatedebt';
   $updatedebt_link = ($bp->displayed_user->id ? $bp->displayed_user->domain : $bp->loggedin_user->domain) . $updatedebt.'/';
	   
   bp_core_new_subnav_item( 
   							array('name' =>'Last Submission',
							'slug' => 'lastsubmission',
							'parent_slug' => $updatedebt,
							'parent_url' => $updatedebt_link,
							'screen_function' =>'Last_Submission','position' => 10) 
						  );
	   
   bp_core_new_subnav_item( 
   							array('name' =>'Update My Debt',
							'slug' => 'updatemydebt',
							'parent_slug' => $updatedebt,
							'parent_url' => $updatedebt_link,
							'screen_function' =>'Update_Debt','position' => 20) 
						  );
	   
   bp_core_new_subnav_item( 
   							array('name' =>'Previous Submission',
							'slug' => 'previoussubmission',
							'parent_slug' => $updatedebt,
							'parent_url' => $updatedebt_link,
						    'screen_function' =>'Previous_Submission',
							'position' => 30) 
						  );
 
   bp_core_new_subnav_item(
   							 array('name' =>'Update Previous Submission',
							 'slug' => 'checkprevioussubmission',
							 'parent_slug' => $updatedebt,
							 'parent_url' => $updatedebt_link,
							 'screen_function' =>'Check_Previous_Submission') 
						   );
   
    bp_core_new_subnav_item( 
							 array('name' =>'Previous Submission Updated',
							 'slug' => 'updateprevioussubmission',
							 'parent_slug' => $updatedebt,
							 'parent_url' => $updatedebt_link,
							 'screen_function' =>'Update_Previous_Submission')
						   );
	
	////////////////////////////MY CHART BADGE////////////////////////////
	
	bp_core_new_nav_item( 
							array( 'name' => __( 'My Chart Badge', 'mychart-badge' ), 
							'slug' => 'mychartbadge', 
							'position' => 120, 
							'screen_function' => 'mychart_function'	,
							'show_for_displayed_user' => false, 
							'default_subnav_slug' => 'chartbadge',
							'screen_function' =>  'My_Chart_Badge') 
						);
	
    $mychartbadge = 'mychartbadge';
    $mychartbadge_link = ($bp->displayed_user->id ? $bp->displayed_user->domain : $bp->loggedin_user->domain) . $mychartbadge.'/';
	
	bp_core_new_subnav_item( 
								array('name' =>'My Chart Badge',
								'slug' => 'chartbadge',
								'parent_slug' => $mychartbadge,
								'parent_url' => $mychartbadge_link,
								'screen_function' =>  'My_Chart_Badge','position' => 10) 
							);
							
	bp_core_new_subnav_item( 
								array('name' =>'Awards',
								'slug' => 'awards',
								'parent_slug' => $mychartbadge,
								'parent_url' => $mychartbadge_link,
								'screen_function' =>  'Awards','position' => 20) 
							);
							

////////////////////////////CALCULATOR////////////////////////////
	
	bp_core_new_nav_item( 
							array( 'name' => __( 'Debt Calculator', 'calculator' ), 
							'slug' => 'calculator', 
							'position' => 130, 
							'screen_function' => 'calculator_function'	,
							'show_for_displayed_user' => false, 
							'default_subnav_slug' => 'debtcalculator',
							'screen_function' =>  'Calculator') 
						);
	
    $calculator = 'calculator';
    $calculator_link = ($bp->displayed_user->id ? $bp->displayed_user->domain : $bp->loggedin_user->domain) . $calculator.'/';
	
	bp_core_new_subnav_item( 
								array('name' =>'Calculator',
								'slug' => 'debtcalculator',
								'parent_slug' => $calculator,
								'parent_url' => $calculator_link,
								'screen_function' =>  'Calculator','position' => 10) 
							);							
							
   do_action( 'add_submenu');
}


/////////////////////////LOAN INPUT/UPDATE (FUNCTIONS)///////////////////////////
function display_function()  
{
	global $bp;
	bp_core_load_template( apply_filters( 'bp_core_template_plugin', 'members/single/plugins' ) );
}


function mychart_function()  
{
	global $bp;
	bp_core_load_template( apply_filters( 'bp_core_template_plugin', 'members/single/plugins' ) );
}


function calculator_function()  
{
	global $bp;
	bp_core_load_template( apply_filters( 'bp_core_template_plugin', 'members/single/plugins' ) );
}


function Last_submission()
{
	global $bp;

	add_action( 'bp_template_content', 'Last_Submission_temp' );
	$templates = array('members/single/plugins.php','plugin-template.php');
	
	if( strstr( locate_template($templates), 'members/single/plugins.php' ) )
	{
		bp_core_load_template( apply_filters( 'bp_core_template_plugin', 'members/single/plugins' ) );
	}
	else 
	{
		bp_core_load_template( apply_filters( 'bp_core_template_plugin', 'plugin-template' ) );
	}	
}


function Previous_Submission() 
{
	global $bp;

	add_action( 'bp_template_content', 'Previous_Submission_temp' );

	$templates = array('members/single/plugins.php','plugin-template.php');
	
	if( strstr( locate_template($templates), 'members/single/plugins.php' ) ) 
	{
		bp_core_load_template( apply_filters( 'bp_core_template_plugin', 'members/single/plugins' ) );
	}
	else 
	{
		bp_core_load_template( apply_filters( 'bp_core_template_plugin', 'plugin-template' ) );
	}
}

function Update_Debt() 
{
	global $bp;

	add_action( 'bp_template_content', 'Update_Debt_temp' );

	$templates = array('members/single/plugins.php','plugin-template.php');
	if( strstr( locate_template($templates), 'members/single/plugins.php' ) ) 
	{
		bp_core_load_template( apply_filters( 'bp_core_template_plugin', 'members/single/plugins' ) );
	}
	else 
	{
		bp_core_load_template( apply_filters( 'bp_core_template_plugin', 'plugin-template' ) );
	}
}



function Check_Previous_Submission() 
{
	global $bp;

	add_action( 'bp_template_content', 'Check_Previous_Submission_temp' );

	$templates = array('members/single/plugins.php','plugin-template.php');
	
	if( strstr( locate_template($templates), 'members/single/plugins.php' ) )
	{
		bp_core_load_template( apply_filters( 'bp_core_template_plugin', 'members/single/plugins' ) );
	}
	else 
	{
		bp_core_load_template( apply_filters( 'bp_core_template_plugin', 'plugin-template' ) );
	}
}


function Update_Previous_Submission() 
{
	global $bp;

	add_action( 'bp_template_content', 'Update_Previous_Submission_temp' );

	$templates = array('members/single/plugins.php','plugin-template.php');
	
	if( strstr( locate_template($templates), 'members/single/plugins.php' ) )
	{
		bp_core_load_template( apply_filters( 'bp_core_template_plugin', 'members/single/plugins' ) );
	}
	else 
	{
		bp_core_load_template( apply_filters( 'bp_core_template_plugin', 'plugin-template' ) );
	}
}



function Update_Debt_temp() 
{
global $wpdb,$bp,$plugin_path;

if($_REQUEST['add']==1)
{ 	
	
	foreach ($_REQUEST['loan'] as $ID=>$loan) 
	{
		$result = updateLoan($loan,$ID,$bp->displayed_user->id);
		$result = insert($ID,$_REQUEST[amount][$ID]);
	}
	
	

foreach ($_REQUEST['newLoan'] as $num=>$loan)
{	
	if ($_REQUEST[newAmount][$num] > 0) 
	{ 
		$result = updateLoanExtra($loan,$bp->displayed_user->id);
		$result = insertExtra(mysql_insert_id(),$_REQUEST[newAmount][$num]);
		
	}
}

	 echo "<div style=\"width: 250px;float:right\">
	 <div style = \"width: 262px; text-align: left;margin-right:-45px;\"><h5>Debt Amounts Saved</h5>
	 <p>Keep up the good work reducing debt.</p>
	
	<br />";?>
	<a href = "<?php echo bp_loggedin_user_domain() ?>profile" title= "I am reducing debt" ><img src = "<?php echo $plugin_path.
	"graph.php?memberID=".$bp->displayed_user->id;?>" alt = "I am reducing debt" border = "0" /></a>	<?php echo " </div>";
	
	$result = getFirstSum($bp->displayed_user->id);
	$first = mysql_fetch_array ($result);


	$result = getLastSum($bp->displayed_user->id);
	$last = mysql_fetch_array ($result);


?>
<div style = "width: 135px; margin-left: 15px; margin-bottom: 10px;margin-top:10px;">
<div style = "font-size: 11px; margin-top: 5px; line-height: 13px;">
<div style = "margin-bottom: 4px;"><b>Start Date:</b> <br /><?=date("M-j-y", getFirstLoanDate($bp->displayed_user->id))?></div>
<div style = "margin-bottom: 4px;"><b>Start Amount:</b><br /><?=number_format($first[amt],2)?></div>
<div style = "margin-bottom: 4px;"><b>Last Updated:</b> <br /><?=date("M-j-y", getLastLoanDate($bp->displayed_user->id))?></div>
<div style = "margin-bottom: 4px;"><b>Latest Amount:</b><br /><?=number_format($last[amt],2)?></div>
<div style = "margin-bottom: 4px;"><b>Encourages left:</b><br /><?
$this_month = date("n");
$sql = "select count(user_id) from encourage where DATE_FORMAT(encourage_date, '%c') = $this_month AND user_id = '".$bp->displayed_user->id."'";
$result = mysql_query($sql);
echo (3 - mysql_result($result, 0));
?></div>
  </div>
 </div>
</div>
<?php    
$sel = selectUserMailRec($bp->loggedin_user->id);

if(mysql_num_rows($sel)==0)
	{
		$updmail = updateUserMail($bp->loggedin_user->id);
	}
}  
	include('add_amount.php');
}

function Last_Submission_temp()
{
	global $bp;
	global $plugin_path;
	include("create_account.php");
} 


function Previous_Submission_temp() 
{	
	global $bp;
	global $plugin_path;
	include("previous_submission.php"); 
} 

function Check_Previous_Submission_temp() 
{	
	global $bp;
	global $plugin_path;
	include("check_previous_submission.php"); 
} 


function Update_Previous_Submission_temp() 
{	
	global $bp;
	global $plugin_path;
	include("update_previous_submission.php"); 
} 
	

///////////////////////////MY CHART BADGE  (FUNCTIONS)/////////////////////

 function My_Chart_Badge() 
{ 
	global $bp;

	add_action( 'bp_template_content', 'My_Chart_Badge_temp' );

	$templates = array('members/single/plugins.php','plugin-template.php');
	
	if( strstr( locate_template($templates), 'members/single/plugins.php' ) )
	{
		bp_core_load_template( apply_filters( 'bp_core_template_plugin', 'members/single/plugins' ) );
	}
	else 
	{ 
		bp_core_load_template( apply_filters( 'bp_core_template_plugin', 'plugin-template' ) );
	}
}

function Awards()  
{ 
	global $bp;

	add_action( 'bp_template_content', 'Awards_temp' );

	$templates = array('members/single/plugins.php','plugin-template.php');
	
	if( strstr( locate_template($templates), 'members/single/plugins.php' ) )
	{
		bp_core_load_template( apply_filters( 'bp_core_template_plugin', 'members/single/plugins' ) );
	}
	else 
	{ 
		bp_core_load_template( apply_filters( 'bp_core_template_plugin', 'plugin-template' ) );
	}
}


function My_Chart_Badge_temp()
{	
	global $wpdb,$bp,$plugin_path;

	if($_REQUEST['update']==1)
	{ 	
		if($_REQUEST['email_reminder']=='on')  $mail = 1; else $mail = 0;
		$result = updateMonthlyReminder($bp->loggedin_user->id,$mail);

	}
	include("my_chart_badge.php"); 
}


function Awards_temp() 
{	
	global $bp;
	global $plugin_path;
	include("awards.php"); 
}


function Calculator() 
{ 
	global $bp;

	add_action( 'bp_template_content', 'Calculator_temp' );

	$templates = array('members/single/plugins.php','plugin-template.php');
	
	if( strstr( locate_template($templates), 'members/single/plugins.php' ) )
	{
		bp_core_load_template( apply_filters( 'bp_core_template_plugin', 'members/single/plugins' ) );
	}
	else 
	{
		bp_core_load_template( apply_filters( 'bp_core_template_plugin', 'plugin-template' ) );
	}
}

function Calculator_temp()
	{
		global $bp;
		global $plugin_path;
		include("DebtIndependenceDay.php");
		include("calculator.php"); 
	}


add_action( 'bp_setup_nav', 'add_submenu' ); 

function reduce_install()
{ 
	global $wpdb, $bp;
	$table_name = "loans";          ///////////      loan table  ///////////// 
	if($wpdb->get_var("show tables like '$table_name'") != $table_name) {
	
	$sql = "CREATE TABLE " . $table_name . " (
	`ID` int(11) NOT NULL AUTO_INCREMENT,                  
	`memberID` int(11) DEFAULT NULL,
	`loan` varchar(255) DEFAULT NULL,
	
	PRIMARY KEY (`id`));";
	
	require_once(ABSPATH . 'wp-admin/includes/upgrade.php');
	dbDelta($sql); }
	
	$table_logs = "loans_log";          ///////////      logs table  /////////////
	if($wpdb->get_var("show tables like '$table_schedule'") != $table_logs) {
	
	$sql_table = "CREATE TABLE " . $table_logs. " (
	`ID` int(11) NOT NULL AUTO_INCREMENT,                  
	`timestamp` varchar(255) DEFAULT NULL,
	`loanID` int(11) DEFAULT NULL,
	`amount` decimal(11,2) DEFAULT NULL, 
	`month` int(11) DEFAULT NULL,                      
	`day` int(11) DEFAULT NULL,
	`year` int(11) DEFAULT NULL,
	 PRIMARY KEY (`id`));";
	
	require_once(ABSPATH . 'wp-admin/includes/upgrade.php');
	dbDelta($sql_table); }
	
	$table_encourage = "encourage";          ///////////      encourage table  /////////////
	if($wpdb->get_var("show tables like '$table_encourage'") != $table_encourage) {
	
	$sql_table_enc = "CREATE TABLE " . $table_encourage. " (
	`encourage_id` int(11) NOT NULL AUTO_INCREMENT,                  
	`profile_id` int(11) DEFAULT NULL,
	`user_id` int(11) DEFAULT NULL,
	`encourage_date` date DEFAULT NULL,
	 PRIMARY KEY (`encourage_id`));";
	
	require_once(ABSPATH . 'wp-admin/includes/upgrade.php');
	dbDelta($sql_table_enc); }



	$table_reminder = "mailreminder";          ///////////      mail reminder table for cron job  /////////////
	if($wpdb->get_var("show tables like '$table_reminder'") != $table_reminder) {
	
	$sql_table_rem = "CREATE TABLE " . $table_reminder. " (
	`id` int(11) NOT NULL AUTO_INCREMENT,                  
	`memberID` int(11) DEFAULT NULL,
	`sendMonthlyReminders` int(11) DEFAULT '1',
	 PRIMARY KEY (`id`));";
	
	require_once(ABSPATH . 'wp-admin/includes/upgrade.php');
	dbDelta($sql_table_rem); }
	
	$table_dates = "maildates";          ///////////      mail reminder table for cron job  /////////////
	if($wpdb->get_var("show tables like '$table_dates'") != $table_dates) {
	
	$sql_table_date = "CREATE TABLE " . $table_dates. " (
	`id` int(11) NOT NULL AUTO_INCREMENT,                  
	`date` date DEFAULT NULL,
	 PRIMARY KEY (`id`));";
	
	require_once(ABSPATH . 'wp-admin/includes/upgrade.php');
	dbDelta($sql_table_date); }
}


function reduce_check_installed() { 
	global $bp;

	if ( !is_super_admin() )
		return false;

	else	reduce_install();
}
add_action( is_multisite() ? 'network_admin_menu' : 'admin_menu', 'reduce_check_installed' );

function reduceDebtCron() 
{
	add_options_page("Listing", "Reduce Debt", 1, "listing", "callMailFunction");
}

function callMailFunction()
{
	global $wpdb, $bp,$plugin_path;;
	
	//echo "<pre>";print_r($sql);echo "</pre>";
?>
<div class="wrap" style="max-width:950px !important;"> 
   <h2>Send Reminder Mail</h2>

			 <div id="poststuff" style="margin-top:10px;"> 
			  <div id="mainblock" style="width:850px"> 
			   <div class="dbx-content"> 
           
			 <form action="<?php echo $action_url ?>" name="add_listing" id="add_listing" method="post">
			 <input type="hidden" name="add" value="1" />
			  <table width="897" align="center" style="margin-left:00px">
				 <tr>
				<td height="40" colspan="4"><b>Welcome Admin, For Sending Reminder Email To the Users For Updating Their Debt Information Just Click On The Send Mail Button.</b> </td>
				 </tr>
				  <?php if(mysql_num_rows(getMailDate())>0) {?>
				 <tr>
				<td width="129" height="40">&nbsp;</td>
				 <td width="261"><b>Mail Sent Dates</b></td>
				 <td colspan="2">&nbsp;</td>
				 </tr>
				 <?php $res = getMailDate();
					   while ($list = mysql_fetch_array ($res)) {  ?>
				   <tr>
				<td width="129" height="40">&nbsp;</td>
				 <td width="261"><?php echo $list[date];?></td>
				 <td colspan="2">&nbsp;</td>
				 </tr>
				 <?php  }}?>
				 
				  <tr>
				<td height="40" align="right">&nbsp;</td>
				 <td height="40" align="right">&nbsp;</td>
				 <td width="178" height="40" >&nbsp;</td>
			     <td width="309" ><input type="submit" name="Input" value="Send Mail"/></td>
			     </tr>
				 
				  
				 <?php if($_REQUEST['add']==1) {?>
				  <tr>
				<td height="40" colspan="4" style="margin-left:200px"><b>Mail Sent Successfully</b></td>
				 </tr>
				 <?php }?>
		   </table>
		 </form>
		 <br />
 		</div> 
     </div> 
  </div> 

</div>
<?php     
  if($_REQUEST['add']==1)
  { 
	$table_users = $wpdb->prefix . "users";
	$date_month = date("F Y");
	$admin = AdminEmail();
	$email = mysql_fetch_row($admin);
	$WEBMASTER_EMAIL = $email[0];
	$sql = $wpdb->get_results("SELECT DISTINCT memberID from mailreminder WHERE sendMonthlyReminders=1");
for($i=0;$i<count($sql);$i++)
{ 
	$sitename = wp_specialchars_decode( get_blog_option( bp_get_root_blog_id(), 'blogname' ), ENT_QUOTES );
	$subject = '[' . $sitename . '] Monthly Reducing Debt Reminder';
	$userdata = get_userdata($sql[$i]->memberID);
	$msg = "<b>Hi ".$userdata->user_nicename.",</b><br/><br/>";
	$msg.= "This is a monthly email reminder for you to update your Reducing Debt Charts for this month, ".$date_month;

 
    $msg.=  "<br/><br/>
        Your last debt input:<br/>
    <div style = \"width: 870px; float: right; \">"; 
	
	
		$result = getFirstSum($sql[$i]->memberID);
		$first = mysql_fetch_array ($result);

		$result = getLastSum($sql[$i]->memberID);
		$last = mysql_fetch_array ($result);
		
	$msg.="<br/><a href = ".site_url()."/members/".$userdata->user_nicename."/profile title= 'I am reducing debt'  target='_blank'>
			<img src = ".$plugin_path."graph.php?memberID=".$sql[$i]->memberID."alt = 'I am reducing debt' border = '0' />
		 </a>

</div>  </div><br/>
        <table style = \"width:350px\";>
        <tr>
            <td style = \"padding-left: 30px; padding-bottom: 8px;\";><b>Loan</b></td>
            <td style = \"padding-left: 10px;\";><b>Amount</b></td>
			
        </tr>
    ";
    // Get last Submission
    $result = getMaxTimeStamp($sql[$i]->memberID);
    $row = mysql_fetch_array ($result);

    $record = getData($sql[$i]->memberID,$row[ts]);
    $z = 0;
	$t = 0;
    while ($list = mysql_fetch_array ($record)) {
        $msg.= "
            <tr>
                <td style = \"padding-left: 30px; padding-bottom: 6px;\">".$list[loan]."</td>
                <td style = \"padding-bottom: 6px; padding-left: 10px; \">".($list[amount] > 0 ? number_format($list[amount],2) : "-")."</td>
            </tr>
        ";
        $t = $list[amount] + $t;
    }

$msg.= "
        </td>
    </tr>
    <tr>
        <td style = \"padding-left: 30px;\"><b>Total:</b></td>

		 <td style = \"padding-left: 10px;\"; >".number_format($t,2)."</td>
    </tr>
    </table>
";

$msg.= "<br/><br/><a href = ".site_url()."/members/".$userdata->user_nicename."/updatedebt>Click Here to update your Debt List.</a><br/><br/>";
$msg.= "<a href = ".site_url()."/members/".$userdata->user_nicename."/calculator>Check out your new Debt Independence Day</a><br/><br/>";
$msg.= "Update your email preferences via your <a href = ".site_url()."/members/".$userdata->user_nicename."/profile>Profile page</a><br/><br/>";
$msg.= "<b>The Reducing Debt Team</b><br>";
$to = $userdata->user_email;


$headers  = "MIME-Version: 1.0\n";
$headers .= "Content-type: text/html; charset=iso-8859-1\n";
//$headers .= "From: $WEBMASTER_EMAIL \n";


wp_mail($to, $subject, $msg, $headers);

//echo $msg;

}
	
  $ins = insertMailrec();
//  if($ins) {header("Location:")}

	
}

}

add_action('admin_menu', 'reduceDebtCron');
