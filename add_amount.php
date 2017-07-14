<?php

$sql = "SELECT * FROM loans l LEFT JOIN loans_log ll ON ll.loanID = l.ID WHERE l.memberID = '".$bp->displayed_user->id."'";
$result = @mysql_query($sql);

//echo mysql_num_rows($result);die;

if (mysql_error()) { echo mysql_error() . "<br /><br />" . $sql;}

if (!mysql_num_rows($result)) {
    $sql = "INSERT INTO `loans` SET `memberID` = '".$bp->displayed_user->id."', `loan` = 'Auto Loan'";   
	$result = @mysql_query($sql); 
	if (mysql_error()) { echo mysql_error() . "<br /><br />" . $sql; }
    $sql = "INSERT INTO `loans` SET `memberID` = '".$bp->displayed_user->id."', `loan` = 'Credit Card'";   
	$result = @mysql_query($sql); 
	if (mysql_error()) { echo mysql_error() . "<br /><br />" . $sql; }
    $sql = "INSERT INTO `loans` SET `memberID` = '".$bp->displayed_user->id."', `loan` = 'Education Loan'";   
	$result = @mysql_query($sql); 
	if (mysql_error()) { echo mysql_error() . "<br /><br />" . $sql; }
    $sql = "INSERT INTO `loans` SET `memberID` = '".$bp->displayed_user->id."', `loan` = 'Medical Loan'";   
	$result = @mysql_query($sql); 
	if (mysql_error()) { echo mysql_error() . "<br /><br />" . $sql; }
    $sql = "INSERT INTO `loans` SET `memberID` = '".$bp->displayed_user->id."', `loan` = 'Personal Loan'";   
	$result = @mysql_query($sql); 
	if (mysql_error()) { echo mysql_error() . "<br /><br />"; }

}


$sql = "SELECT * FROM loans l LEFT JOIN loans_log ll ON ll.loanID = l.ID WHERE l.memberID = '".$bp->displayed_user->id."'";
		
$result = @mysql_query($sql); 
if (mysql_error()) { echo mysql_error() . "<br /><br />" . $sql; }
if (mysql_num_rows($result)) { $new = "true"; }

?>


<form name = "add" method = "post" >
<input type="hidden" name="add" value="1"/>
<table style = "width:600px";>
<tr>
    <td style = "padding-left: 120px; padding-bottom: 10px;" width="30%"><strong>Loan</strong></td>
    <td style = "padding-left: 50px; padding-bottom: 10px; width:10%"><strong>Amount</strong></td>
    <?=($new ? "<td style = \"padding-bottom: 10px;padding-left: 20px;\"><strong>Previous Amount</strong></td>" : "")?>
</tr>
<?
$aWhere .= (getLastLoanDate($bp->displayed_user->id) ? "AND ll.timestamp = '".getLastLoanDate($bp->displayed_user->id)."'" : "");

$sql = "SELECT l.loan, l.ID,  ll.amount FROM loans l LEFT JOIN loans_log ll ON ll.loanID = l.ID WHERE l.memberID = '".$bp->displayed_user->id."' ".$aWhere." ";
$result = @mysql_query($sql); if (mysql_error()) { echo mysql_error() . "<br /><br />" . $sql; }
$z = 0;


while ($list = mysql_fetch_array ($result)) {
//echo $list[ID];
    echo "
        <tr>
            <td style = \"padding-left: 120px; padding-bottom: 8px;\"><input type = \"text\" name = \"loan[".$list[ID]."]\" value = \"".$list[loan]."\" style = \"width: 210px;\" /></td>
            <td style = \"padding-left: 50px; padding-bottom: 8px;\"><input onchange = \"change_total()\" id = \"amount_".$z."\" type = \"text\" name = \"amount[".$list[ID]."]\" value = \"".number_format($list[amount],2,'.','')."\" style = \"width: 70px;  text-align: right;\" /></td>
            <td style = \"padding-left: 20px; padding-bottom: 8px; text-align:left;\">".($list[amount] > 0 ? number_format($list[amount],2) : "")."</td>
        </tr>
    ";
    $total = $total + $list[amount];
    $z = $z + 1;
	
}//while

echo "<tr><td colspan = \"3\">&nbsp;</tr>";
for ($i = 0; $i < 10; $i++) {
    echo "
        <tr>
            <td style = \"padding-left: 120px; padding-bottom: 8px;\"><input type = \"text\" name = \"newLoan[".$i."]\" value = \"Additional Loan\" style = \"width: 210px;\" /></td>
            <td style = \"padding-left: 50px; padding-bottom: 8px;\"><input onchange = \"change_total()\" id = \"amount_".$z."\" type = \"text\" name = \"newAmount[".$i."]\" value = \"0.00\" style = \"width: 70px; text-align: right;\" /></td>
        </tr>
    ";
    $z = $z + 1;
}
?>
<tr>
    <td style = "text-align: right; padding-right: 10px;"><b>Total:</b></td>
    <td id = "total" style = "text-align: right; padding-right: 14px;"><?=number_format($total,2)?></td>
</tr>
</table><br />
<?php if($bp->displayed_user->id==$bp->loggedin_user->id){?>
<input type = "submit" value = "Submit"  style="margin-left:120px;"/>
<?php }?>
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

