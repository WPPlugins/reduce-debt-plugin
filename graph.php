<?php
require_once("../../../wp-config.php");
global $bp;

$maxBars = 8;

$profile_id = intval($_REQUEST['memberID']);

if ($profile_id) {

	$sql = "SELECT DISTINCT(timestamp) t FROM `loans` l JOIN `loans_log` ll ON ll.loanID = l.ID WHERE memberID = '".$profile_id."'";			
	$result = @mysql_query($sql); if (mysql_error()) { echo mysql_error() . "<br /><br />" . $sql; }

	
	while ($list = mysql_fetch_array ($result)) 
	{
		$sql2 = "SELECT SUM(amount) a FROM `loans` l JOIN `loans_log` ll ON ll.loanID = l.ID WHERE memberID = '".$profile_id."'	AND `timestamp` = '".$list[t]."'";
		//echo $sql2;die;
		$result2 = @mysql_query($sql2); if (mysql_error()) { echo mysql_error() . "<br /><br />" . $sql; }
		$row = mysql_fetch_array ($result2);
		$v[] = $row[a];
	}
	
	if (count($v) <= $maxBars) 
	{
		for ($i = 0; $i < count($v); $i++) { $values[] = $v[$i]; }
	}
	else 
	{
		for ($i = 1; $i <= $maxBars; $i++) 
		{
			if($i==1)
			{
			$values[] = $v[0];
			//echo "now";die;
			}
			else if($i==$maxBars)
			{
			$values[] = $v[count($v)-1];
			//echo "now";die;
			}
			else
			{
			$values[] = $v[round(count($v)*($i/$maxBars))];
			}
		}
	}
	
	// This array of values is just here for the example.
	
	   // $values = array(310, 320, 330, 340, 350,360,370);
	
	// Get the total number of columns we are going to plot
	
		$columns  = count($values);
	
	// Get the height and width of the final image
	
		$width = 115;
		$height = 85;
	
	// Set the amount of space between each column
	
		$padding = 7;
	
	// Get the width of 1 column
	
		if ($values) { $column_width = $width / $columns ; }
	
	// Generate the image variables
	
	
			//$im        	= imagecreate($width,$height);
			$im		= imagecreatefromjpeg($plugin_path.'/images/newbadge.jpg');
			//$orange	= imagecolorallocate ($im,226,96,0);
			$orange		= imagecolorallocate ($im,121,0,0);
			$gray_lite	= imagecolorallocate ($im,0xee,0xee,0xee);
			$gray_dark	= imagecolorallocate ($im,0x7f,0x7f,0x7f);
		//   	$white     	= imagecolorallocate ($im,0xff,0xff,0xff);
	
	if ($values) {
	
		// Fill in the background of the image
	
		//    imagefilledrectangle($im,0,0,$width,$height,$white);
	
			$maxv = 0;
	
		// Calculate the maximum value we are going to plot
	
			for($i=0;$i<$columns;$i++)$maxv = max($values[$i],$maxv);
	
		// Now plot each column
	
			for($i=0;$i<$columns;$i++)
			{
				$column_height = ($height / 100) * (( $values[$i] / $maxv) *100);
	
				$x1 = $i*$column_width+6;
				$y1 = $height-$column_height+27; // 27 = padding from top
				$x2 = (($i+1)*$column_width)-$padding+6;
				$y2 = $height+27; // 27 = padding from top chanage with 27 above
	
				imagefilledrectangle($im,$x1,$y1,$x2,$y2,$orange);
	
		// This part is just for 3D effect
	
				imageline($im,$x1,$y1,$x1,$y2,$gray_lite);
				imageline($im,$x2,$y1,$x2,$y2,$gray_dark);
	
			}
	}
	
	
	#HT
	$sql = "SELECT SUM(amount) amt 
				FROM `loans_log` ll JOIN loans l ON ll.loanID = l.ID 
				WHERE l.memberID = '".$profile_id."'
				Group by `timestamp`
				Order by timestamp DESC";
	
	$result = mysql_query($sql);
	
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
		
		if ( $decrease >= 100 ) {
			$small_award = $plugin_path.'/images/adw_bebtfree_small.png';
		} elseif ($decrease > 75 ) {
			$small_award = $plugin_path.'/images/adw_platinum_small.png';
		} elseif ($decrease > 50 ) {
			$small_award = $plugin_path.'/images/adw_gold_small.png';
		} elseif ($decrease > 25 ) {
			$small_award = $plugin_path.'/images/adw_silver_small.png';
		} elseif ($decrease > 10 ) {	
			$small_award = $plugin_path.'/images/adw_bronze_small.png';
		} else {
			$small_award = $plugin_path.'/images/adw_rookie_small.png';
		}//if
		
		$insert = imagecreatefrompng($small_award);
	
		$white = imagecolorallocate( $insert, 255, 255, 255 );
	
		$insert_x = imagesx($insert);
		$insert_y = imagesy($insert);
		
		// copy image into new resource
		
		//int imagecopy ( resource dst_im, resource src_im, int dst_x, int dst_y, int src_x, int src_y, int src_w, int src_h )
		imagecopy( $im, $insert, 80, 18, 0, 0, $insert_x, $insert_y );
		   
		//fill the background with white (not sure why it has to be in this order)
		imagefill( $insert, 0, 0, $white );

		
	}//if
	
//	echo count($result);die;
	
	
	// Send the PNG header information. Replace for JPEG or GIF or whatever
	
	header ("Content-type: image/png");
	imagepng($im); 
}//if
?>