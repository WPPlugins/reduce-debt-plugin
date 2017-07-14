<?php 
$aWhere .= (getLastLoanDate($bp->displayed_user->id) ? "AND ll.timestamp = '".getLastLoanDate($bp->displayed_user->id)."'" : "");

$sql = "SELECT l.loan, l.ID,  ll.amount FROM loans l LEFT JOIN loans_log ll ON ll.loanID = l.ID WHERE l.memberID = '".$bp->displayed_user->id."' ".$aWhere." ";

$result = @mysql_query($sql); if (mysql_error()) { echo mysql_error() . "<br /><br />" . $sql; }
$list = mysql_num_rows ($result);

?>
<table width="98%">
<tr valign="top">

<td>	
<div style="font-style:italic; font-size:13px">
<form name="debts" method="post" action="#">
<table width='100%' border='0' cellspacing='2' cellpadding='4' align="center">
<tbody>

<tr bgcolor='#D3DCE3'>
<td align="center" colspan=7><strong> Reducing Debt Payoff Calculator </strong></td>
</tr>

<tr>
<td colspan=7>

This calculator will show you how much time and money you could save by paying off your debts using the "rollover" method. Using the rollover method, as each smaller debt is paid off, the freed-up payment amount is then applied to the next larger debt, and so on until all debts are paid off. As you are about to see, the rollover method can save you a ton of money in interest charges, and get you debt free in a very short period of time.
<br/><br/>
<b>Instructions:</b> Ordered from smallest balance to highest balance, enter the name, current balance, interest rate and minimum payment amount for all of your debts. Next, enter a monthly dollar amount you could add to your accelerated debt payoff plan. Then, click the "Calculate Results" button.</p>
<br/>
<br/>
<b>Note:</b> If you include your mortgage in your Reducing Debt Payoff Plan, be sure to enter only the principal & interest portion of your monthly mortgage payment (don't include monthly tax and insurance portion).

</p>

</td>
</tr>

<tr bgcolor='#D3DCE3'>
<td align="right"> </td>
<td align="center" colspan="4">
<font face='arial'><small><strong>
Entry Columns
</strong></small></font>
</td>
<td align="center" colspan="2">
<font face='arial'><small><strong>
Calculated Columns
</strong></small></font>
</td>
</tr>

<tr bgcolor='#D3DCE3'>
<td align="right">
<font face='arial'><small><strong>
<b>#</b>
</strong></small></font>
</td>
<td align="center">
<font face='arial'><small><strong>
Loan
</strong></small></font>
</td>
<td align="center">
<font face='arial'><small><strong>
Principal<br />Balance ($)
</strong></small></font>
</td>
<td align="center">
<font face='arial'><small><strong>
Interest<br />Rate (%)
</strong></small></font>
</td>
<td align="center">
<font face='arial'><small><strong>
Payment<br />Amount ($)
</strong></small></font>
</td>
<td align="center">
<font face='arial'><small><strong>
Interest<br />Cost
</strong></small></font>
</td>
<td align="center">
<font face='arial'><small><strong>
# of Pmts<br />Left
</strong></small></font>
</td>
</tr>
<?php $i=1;
while ($list = mysql_fetch_array ($result)) {
?>
<tr bgcolor='#CCCCCC'>
<td bgcolor='#CCCCCC' align="right"><font face='tahoma'><small><b><?=$i;?></b></small></font></td>
<td bgcolor='#CCCCCC' align="center"><input type="text" id="D<?=$i;?>" name="D<?=$i;?>" style='background-color:FFFFFF' size="15"  tabindex="2" value="<?=$list[loan];?>" /></td>
<td bgcolor='#CCCCCC' align="center"><input type="text" id="prin<?=$i;?>" name="prin<?=$i;?>" style='background-color:FFFFFF' size="9" tabindex="3" value="<?=number_format($list[amount],2,'.','');?>" onChange="computeLoan(<?=$i?>)" /></td>
<td bgcolor='#CCCCCC' align="center"><input type="text" id="intRate<?=$i;?>" name="intRate<?=$i;?>" style='background-color:FFFFFF' size=5 tabindex="4" onChange="computeLoan(<?=$i?>)" /></td>
<td bgcolor='#CCCCCC' align="center"><input type="text" id="pmt<?=$i;?>" name="pmt<?=$i;?>" style='background-color:FFFFFF' size="9" tabindex="5" onChange="computeLoan(<?=$i?>)" /></td>
<td bgcolor='#CCCCCC' align="center"><input type="text" id="intLeft<?=$i;?>" name="intLeft<?=$i;?>" style='background-color:CCCCCC' size="9" /></td>
<td bgcolor='#CCCCCC' align="center"><input type="text" id="pmtLeft<?=$i;?>" name="pmtLeft<?=$i;?>" style='background-color:CCCCCC' size="9" /></td>
</tr>
<?php $i++;}?>

<tr bgcolor='#CCCCCC'>
<td bgcolor='#CCCCCC' colspan="6">
<p align="right"><font face='tahoma'><strong>
Enter a monthly dollar amount you can add to your debt payoff plan:</strong>
</font></p>
</td>
<td bgcolor='#CCCCCC' align="center">
<input type="text" name="accel_pmt" style='background-color:FFFFFF' tabindex="44" size="9" onKeyUp="clearResults(this.form)" />
</td>
</tr>

<tr>
<td align="center" bgcolor='silver' colspan="7">
<input type="button" style='background-color:D3DCE3' tabindex="45" value="Calculate Results" onClick="computeForm(this.form)" /> 
<input type="reset"  style='background-color:D3DCE3' value="Clear Form" />
</td>
</tr>

<tr bgcolor='#D3DCE3'>
<td colspan="2" align="center">
<font face='arial'><small><strong>
Results
</strong></small></font>
</td>
<td align="center">
<font face='arial'><small><strong>
Principal<br />Balance
</strong></small></font>
</td>
<td align="center">
<font face='arial'><small><strong>
Payment<br />Amount
</strong></small></font>
</td>
<td align="center">
<font face='arial'><small><strong>
Interest<br />Cost
</strong></small></font>
</td>
<td align="center">
<font face='arial'><small><strong>
# of Pmts<br />Left
</strong></small></font>
</td>
<td align="center">
<font face='arial'><small><strong>
Payoff<br />Date
</strong></small></font>
</td>
</tr>

<tr bgcolor='#DDDDDD'>
<td bgcolor='#DDDDDD' colspan="2">
<font face='tahoma'>
Current totals:
</font>
</td>
<td bgcolor='#DDDDDD' align="center"><input type="text" name="totalprin" style='background-color:DDDDDD' size="9" /></td>
<td bgcolor='#DDDDDD' align="center"><input type="text" name="totalpmt" style='background-color:DDDDDD' size="9" /></td>
<td bgcolor='#DDDDDD' align="center"><input type="text" name="totalint" style='background-color:DDDDDD' size="9" /></td>
<td bgcolor='#DDDDDD' align="center"><input type="text" name="totalnprs" style='background-color:DDDDDD' size="9" /></td>
<td bgcolor='#DDDDDD' align="center"><input type="text" name="totaldate" style='background-color:21374E' size="9" /></td>
</tr>

<tr bgcolor='#CCCCCC'>
<td bgcolor='#CCCCCC' colspan="2">
<font face='tahoma'>
<strong>BDP totals:</strong></font></td>
<td bgcolor='#CCCCCC' align="center"><input type="text" name="adp_totalprin" style='background-color:CCCCCC' size="9" /></td>
<td bgcolor='#CCCCCC' align="center"><input type="text" name="adp_totalpmt" style='background-color:CCCCCC' size="9" /></td>
<td bgcolor='#CCCCCC' align="center"><input type="text" name="adp_totalint" style='background-color:CCCCCC' size="9" /></td>
<td bgcolor='#CCCCCC' align="center"><input type="text" name="adp_totalnprs" style='background-color:CCCCCC' size="9" /></td>
<td bgcolor='#CCCCCC' align="center"><input type="text" name="adp_totaldate" style='background-color:21374E' size="9" /></td>
</tr>

<tr bgcolor='#DDDDDD'>
<td bgcolor='#DDDDDD' colspan="4">
<font face='tahoma'>
Time and interest savings from Reducing Debt Payoff Plan:</font></td>
<td bgcolor='#DDDDDD' align="center"><input type="text" name="adp_int_save" style='background-color:DDDDDD' size="9" /></td>
<td bgcolor='#DDDDDD' align="center"><input type="text" name="adp_npr_save" style='background-color:DDDDDD' size="9" /></td>
<td bgcolor='#DDDDDD' align="center">&nbsp;</td>
</tr>

<tr bgcolor='#CCCCCC'>
<td bgcolor='#CCCCCC' colspan=7 align="center">
<div id="summary" align="left">
</div>
<input type="hidden" name="schedule_head" />
<input type="hidden" name="schedule_rows" />
<input type="hidden" name="summary_head" />
<input type="hidden" name="summary_rows" />
</td>
</tr>

<!--<tr>
<td align="center" bgcolor='silver' colspan="7">
<input type="button" style='background-color:D3DCE3' value="Create Payment Schedule"  onClick="createSchedule(this.form)" /> 
<input type="button" style='background-color:D3DCE3' value="Create Payoff Summary"  onClick="createSummary(this.form)" />
</td>
</tr>-->



<!--calc row end-->

</tbody>
</table>
</form>
 </div>
</td>
</tr>
</table>
