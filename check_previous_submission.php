<?php 
$nonce=$_REQUEST['wpnonce'];
if (! wp_verify_nonce($nonce, 'my-nonce') ) {echo '<b>No Previous Record Selected</b> '; 
if($bp->displayed_user->id==$bp->loggedin_user->id) {
?>
<a href = "<?php echo bp_loggedin_user_domain() ?>updatedebt/previoussubmission">Click here to update a previous submission.</a>
<?php } }else {
$updatenonce = wp_create_nonce  ('check-nonce');
?>
<h5>Update Previous Debt Submission</h5>

<p>Date: <?=date("M j, Y @ g:i A" ,$_REQUEST[ts])?></p>
<br /><br />


<form name = "add" method = "post" action = "<?php echo bp_loggedin_user_domain() ?>updatedebt/updateprevioussubmission">
<input type="hidden" name="nonce" value="<?=$updatenonce?>" />
<table>
<tr>
	<td style = "padding-left: 120px; padding-bottom: 8px;"; width="5%"><b>Loan</b></td>
    <td style = "padding-left: 50px;"; width="30%" ><b>Amount</b></td>
</tr>
<?
#$aWhere .= (getLastLoanDate($_SESSION[memberID]) ? "AND ll.timestamp = '".getLastLoanDate($_SESSION[memberID])."'" : "");
#HT

$aWhere .= "AND ll.timestamp = '". $_REQUEST[ts] ."'";


$sql = "SELECT l.loan, l.ID,ll.amount, ll.ID llID FROM loans l LEFT JOIN loans_log ll ON ll.loanID = l.ID WHERE l.memberID = '".$bp->displayed_user->id."'".$aWhere."";


$result = @mysql_query($sql); 
if (mysql_error()) { echo mysql_error() . "<br /><br />" . $sql; }
$z = 0;

while ($list = mysql_fetch_array ($result)) {
    echo "
        <tr>
            <td style = \"padding-left: 120px; padding-bottom: 6px;\">".$list[loan]."</td>
            <td style = \"padding-left: 50px; padding-bottom: 6px;\"><input onchange = \"change_total()\" id = \"amount_".$z."\" type = \"text\" name = \"amount[".$list[llID]."]\" value = \"".number_format($list[amount],2,'.','')."\" style = \"width: 70px; text-align: right;\" /></td>
        </tr>";
	
	
    $total = $total + $list[amount];
    $z = $z + 1;
}
?>
<tr>
    <td style = "padding-left: 120px;"><b>Total:</b></td>
    <td id = "total" style = "padding-left: 50px;"><?=number_format($total,2)?></td>
</tr>
</table><br />
<input type = "hidden" name = "ts" value  = "<?=$_REQUEST[ts]?>" />
<input type = "submit" value = "Submit" style="margin-left:120px;" />

</form>

<script type = "text/javascript">
    var z = <?=number_format($z)?>;
    function change_total() {
        var total = 0;
        for (i = 0; i <  z; i++) {
            a = parseFloat(document.getElementById('amount_'+i).value);
            document.getElementById('amount_'+i).value = a.toFixed(2);
            total = total + a;
        }
        total = total.toFixed(2);
        document.getElementById('total').innerHTML = total;
    }
    function roundNumber(num, dec) {
	var result = Math.round( Math.round( num * Math.pow( 10, dec + 1 ) ) / Math.pow( 10, 1 ) ) / Math.pow(10,dec);
	return result;
}
</script>
<?php }?>