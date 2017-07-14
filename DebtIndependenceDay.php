<?php 
global $bp;
$aWhere .= (getLastLoanDate($bp->displayed_user->id) ? "AND ll.timestamp = '".getLastLoanDate($bp->displayed_user->id)."'" : "");

$sql = "SELECT l.loan, l.ID,  ll.amount FROM loans l LEFT JOIN loans_log ll ON ll.loanID = l.ID WHERE l.memberID = '".$bp->displayed_user->id."' ".$aWhere." ";


$result = @mysql_query($sql); if (mysql_error()) { echo mysql_error() . "<br /><br />" . $sql; }
$list = mysql_num_rows ($result);

?>
<script type="text/javascript">
// JavaScript Document

function fn(num, places, comma) {

var isNeg=0;

    if(num < 0) {
       num=num*-1;
       isNeg=1;
    }

    var myDecFact = 1;
    var myPlaces = 0;
    var myZeros = "";
    while(myPlaces < places) {
       myDecFact = myDecFact * 10;
       myPlaces = Number(myPlaces) + Number(1);
       myZeros = myZeros + "0";
    }
    
	onum=Math.round(num*myDecFact)/myDecFact;
		
	integer=Math.floor(onum);

	if (Math.ceil(onum) == integer) {
		decimal=myZeros;
	} else{
		decimal=Math.round((onum-integer)* myDecFact)
	}
	decimal=decimal.toString();
	if (decimal.length<places) {
        fillZeroes = places - decimal.length;
	   for (z=0;z<fillZeroes;z++) {
        decimal="0"+decimal;
        }
     }

   if(places > 0) {
      decimal = "." + decimal;
   }

   if(comma == 1) {
	integer=integer.toString();
	var tmpnum="";
	var tmpinteger="";
	var y=0;

	for (x=integer.length;x>0;x--) {
		tmpnum=tmpnum+integer.charAt(x-1);
		y=y+1;
		if (y==3 & x>1) {
			tmpnum=tmpnum+",";
			y=0;
		}
	}

	for (x=tmpnum.length;x>0;x--) {
		tmpinteger=tmpinteger+tmpnum.charAt(x-1);
	}


	finNum=tmpinteger+""+decimal;
   } else {
      finNum=integer+""+decimal;
   }

    if(isNeg == 1) {
       finNum = "-" + finNum;
    }

	return finNum;
}


function sn(num) {

   num=num.toString();


   var len = num.length;
   var rnum = "";
   var test = "";
   var j = 0;

   var b = num.substring(0,1);
   if(b == "-") {
      rnum = "-";
   }

   for(i = 0; i <= len; i++) {

      b = num.substring(i,i+1);

      if(b == "0" || b == "1" || b == "2" || b == "3" || b == "4" || b == "5" || b == "6" || b == "7" || b == "8" || b == "9" || b == ".") {
         rnum = rnum + "" + b;

      }

   }

   if(rnum == "" || rnum == "-") {
      rnum = 0;
   }

   rnum = Number(rnum);

   return rnum;

}

function computeFutureDate(now_mo, now_day, now_yr, months_to_add, dt_format) {

   var dbl_dgt = new Array("00", "01", "02", "03", "04", "05", "06", "07", "08", "09");

   var day_str = new Array("Sunday", "Monday", "Tuesday", "Wednesday", "Thursday", "Friday", "Saturday");

   var day_str_abrev = new Array("Sun", "Mon", "Tue", "Wed", "Thu", "Fri", "Sat");

   var month_str = new Array("January", "February", "March", "April", "May", "June", "July", "August", "September", 

"October", "November", "December");

   var month_str_abrev = new Array("Jan", "Feb", "Mar", "Apr", "May", "Jun", "Jul", "Aug", "Sep", "Oct", "Nov", 

"Dec");



   var now_date_str = month_str[now_mo-1] + " " + now_day + ", " + now_yr + " 12:00:00";
   var now_date = new Date(now_date_str);
   var now_ms = now_date.getTime();
   var now_year = now_date.getFullYear();

   var ms_per_mo = 365 * 86400000 / 12;
   var ms_to_add = ms_per_mo * months_to_add;
   var future_ms = eval(now_ms) + eval(ms_to_add);

   var future_date = new Date(future_ms);
   //var future_date = future_date.setTime(future_ms);

   var future_mo = eval(future_date.getMonth()) + eval(1);
   var future_day = future_date.getDate();
   var future_wkday = future_date.getDay();
   var future_yr = future_date.getFullYear();



   var future_mo_str = future_mo.toString();
   var future_day_str = future_day.toString();
   var future_yr_str = future_yr.toString();
   var future_date_str = "";

   if(dt_format == 0) {
      future_date_str = future_mo + "/" + future_day + "/" + future_yr;
   } else

   if(dt_format == 1) {

      if(future_mo < 10) {
         future_mo_str = dbl_dgt[future_mo];
      }
      if(future_day < 10) {
         future_day_str = dbl_dgt[future_day];
      }
      if(future_yr_str.length == 4) {
         future_yr_str = future_yr_str.substring(2,4);
      }

      future_date_str = future_mo_str + "/" + future_day_str + "/" + future_yr_str;

   } else

   if(dt_format == 2) {

      if(future_mo < 10) {
         future_mo_str = dbl_dgt[future_mo];
      }
      if(future_day < 10) {
         future_day_str = dbl_dgt[future_day];
      }
      future_date_str = future_mo_str + "/" + future_day_str + "/" + future_yr;

   } else

   if(dt_format == 3) {
      if(future_mo < 10) {
         future_mo_str = dbl_dgt[future_mo];
      }
      if(future_day < 10) {
         future_day_str = dbl_dgt[future_day];
      }
      future_date_str = future_yr + "-" + future_mo_str + "-" + future_day_str;

   } else

   if(dt_format == 4) {
      future_date_str = month_str_abrev[future_mo-1] + " " + " " + future_yr;
   } else
   if(dt_format == 5) {
      future_date_str = month_str[future_mo-1] + " " + future_day + ", " + future_yr;
   } else
   if(dt_format == 6) {
      future_date_str = day_str_abrev[future_wkday] + " " + month_str_abrev[future_mo-1] + " " + future_day + ", " + 

future_yr;

   } else

   if(dt_format == 7) {
      future_date_str = day_str[future_wkday] + " " + month_str[future_mo-1] + " " + future_day + ", " + future_yr;

   }


   return future_date_str;

}

function computeLoan(line) {


   var my_prin_cell = document.getElementById("prin" + line + "");
   var my_rate_cell = document.getElementById("intRate" + line + "");
   var my_pmt_cell = document.getElementById("pmt" + line + "");

   var my_prin = sn(my_prin_cell.value);
   var my_rate = sn(my_rate_cell.value);
   var my_pmt = sn(my_pmt_cell.value);

   var my_intLeft_cell = document.getElementById("intLeft" + line + "");
   var my_pmtLeft_cell = document.getElementById("pmtLeft" + line + "");


   var my_intPort = 0;
   var my_i = 0;
   var my_prinPort = 0;
   var my_accumInt = 0;
   var my_count = 0;

   if(my_prin > 0 && my_pmt > 0) {

      if(my_rate == 0) {
         my_i = 0;
      } else {
         my_i = my_rate;
         if(my_i >= 1) {
            my_i /= 100;
         }
         my_i /= 12;
      }

      while(my_prin > 0) {
         my_intPort = my_prin * my_i;
         my_accumInt = Number(my_accumInt) + Number(my_intPort);
         my_prinPort = Number(my_pmt) - Number(my_intPort);
         my_prin = Number(my_prin) - Number(my_prinPort);
         my_count = Number(my_count) + Number(1);
         if(my_count > 1000) {break; } else {continue; }
      }

      if(my_count >= 1000) {
         alert("At the terms you entered, debt #" + line + " will never be paid off. Please either decrease the balance, decrease the interest rate, or increase the payment amount until this message not longer pops up.");
         my_intLeft_cell.value = "ERROR";
         my_pmtLeft_cell.value = "ERROR";
      } else {
         my_intLeft_cell.value = "$" + fn(my_accumInt,2,1);
         my_pmtLeft_cell.value = my_count;
      }


   }

     clearResults(document.debts);

}

function computeForm(form)  {

   var debtCnt = 0;
   var i = 0;
   var totalDebtInt = 0;
   var totalDebtPmts = 0;
   var max_npr = 0;

   var name_arr = new Array()
   var prin_arr = new Array()
   var adp_bal_arr = new Array()
   var rate_arr = new Array()
   var pmt_arr = new Array()
   var adp_pmt_arr = new Array()
   var npr_arr = new Array()
   var cost_arr = new Array()
   var sum_rows_arr = new Array()


   var Vschedule_head = "<tr><td><font face='arial'><small><b>Pmt#</b></small></font></td>";

   var count = 0;
   var prinPort = 0;
   var intPort = 0;
   var name = "";
   var prin = 0;
   var intRate = 0;
   var intLeft = 0;
   var accumInt = 0;
   var accumPrin = 0;
   var pmt = 0;

   var Vtotalprin = 0;

   while(i < <?php echo $list;?>) {

      i = Number(i) + Number(1);

      var name_cell = document.getElementById("D" + i + "");
      var prin_cell = document.getElementById("prin" + i + "");
      var intRate_cell = document.getElementById("intRate" + i + "");
      var pmt_cell = document.getElementById("pmt" + i + "");
      var intLeft_cell = document.getElementById("intLeft" + i + "");
      var pmtLeft_cell = document.getElementById("pmtLeft" + i + "");

      name = name_cell.value;
      prin = sn(prin_cell.value);
      intRate = sn(intRate_cell.value);
      pmt = sn(pmt_cell.value);
      intLeft = sn(intLeft_cell.value);


      Vtotalprin = Number(Vtotalprin) + Number(prin);


      if(prin > 0 && pmt > 0) {

         debtCnt = Number(debtCnt) + Number(1);
         accumPrin = Number(accumPrin) + Number(prin);

         Vschedule_head = Vschedule_head + "<td align='center'><font face='arial'><small><b>" + debtCnt + "</b></small></font></td>\n";
         sum_rows_arr[i] = "<tr><td><font face='arial'><small>" + name + "</small></font></td>\n";

         accumInt = 0;
         count = 0;

         if(intRate == 0) {
            intRate = 0;
         } else {
            if(intRate >= 1) {
               intRate /= 100;
            }
            intRate /= 12;
         }

         name_arr[debtCnt] = name;
         prin_arr[debtCnt] = prin;
         adp_bal_arr[debtCnt] = prin;
         rate_arr[debtCnt] = intRate;
         pmt_arr[debtCnt] = pmt;
         adp_pmt_arr[debtCnt] = pmt;

      if(i == 1) {
         var test = prin_arr[1];
      }

         while(prin > 0) {
            intPort = prin * intRate;
            accumInt = Number(accumInt) + Number(intPort);
            prinPort = Number(pmt) - Number(intPort);
            prin = Number(prin) - Number(prinPort);
            count = Number(count) + Number(1);
            if(count > 1000) {break; } else {continue; }
         }
         totalDebtInt = Number(totalDebtInt) + (accumInt);
         totalDebtPmts = Number(totalDebtPmts) + Number(pmt);

         if(count > max_npr) {
            max_npr = count;
         }

         npr_arr[debtCnt] = count;
         cost_arr[debtCnt] = accumInt;

         pmtLeft_cell.value = count;
         intLeft_cell.value = "$" + fn(accumInt,2,1);
         

      } //if


    } //while

    document.debts.totalprin.value = "$" + fn(Vtotalprin,2,1);
    document.debts.adp_totalprin.value = "$" + fn(Vtotalprin,2,1);

    document.debts.totalint.value = "$" + fn(totalDebtInt,2,1);

    document.debts.totalnprs.value = max_npr;

    var gv_now_date = new Date();
    var gv_now_year = gv_now_date.getFullYear();
    if(gv_now_year < 2000) {
       gv_now_year += 1900;
    }
    var gv_now_month = gv_now_date.getMonth() + 1;
    var gv_now_day = gv_now_date.getDate();

    var v_totaldate = computeFutureDate(gv_now_month, gv_now_day, gv_now_year, max_npr, 4); 
    document.debts.totaldate.value = v_totaldate;

    document.debts.totalpmt.value = "$" + fn(totalDebtPmts,2,1);

    Vschedule_head = Vschedule_head + "</tr>\n";
    document.debts.schedule_head.value = Vschedule_head;

    var Vaccel_pmt = sn(document.debts.accel_pmt.value);
    var Vadp_totalpmt = Number(totalDebtPmts) + Number(Vaccel_pmt);
    document.debts.adp_totalpmt.value = "$" + fn(Vadp_totalpmt ,2,1);

    var v_summary_cell = document.getElementById("summary");

    var v_summary_txt = "The total of your current monthly debt ";
    v_summary_txt += "payments ($" + fn(totalDebtPmts,2,1) + "), plus the ";
    v_summary_txt += "additional monthly amount of $" + fn(Vaccel_pmt,2,1) + ", is ";
    v_summary_txt += "equal to $" + fn(Vadp_totalpmt,2,1) + ".  This is how ";
    v_summary_txt += "much you will allocate to paying off your debts until ";
    v_summary_txt += "all of the above debts are paid off.";

    v_summary_cell.innerHTML = "<font face='arial'><small>" + v_summary_txt + "</small></font>";


    i = 0;
    var npr_cnt = 0;
    var adp_bal = 0;
    var adp_combo_prin = accumPrin;
    var debts_paid_off = 0;
    var next_debt_paid_off = 1;
    var Vadp_totalint = 0;
    var sum_col_print = 0;

    //VARIABLES FOR EACH PAYMENT ON EACH DEBT
    var adp_bal = 0;
    var adp_intPort = 0;
    var adp_prinPort = 0;
    var adp_rate = 0;
    var adp_excess_pmt = 0;
  

    //AMOUNT TO APPLY TO DEBT BEING FOCUSED ON
    var adp_pmt_amt = 0;

    //TOTAL OF ADP_PMTS PER PERIOD
    var tot_period_pmts = 0;

    //DEBT THAT EXTRA IS BEING APPLIED TO
    var cur_adp_debt = 1;

    //VARIEBLE TO COLLECT CHART ROWS
    var num_pmts = 0;
    var Vschedule_cols = "";
    var Vschedule_rows = "";
    var Vsummary_head = "<tr><td><font face='arial'><small><b>Name of Debt</b></small></font></td><td><font face='arial'><small><b>Begin<br>Bal:<br>Pmt:</b></small></font></td>";

    //DO UNTIL ALL DEBTS ARE PAID
    while(debts_paid_off< debtCnt) {

      npr_cnt = Number(npr_cnt) + Number(1);
      i = 0;
      adp_pmt_amt = Vaccel_pmt;

    

      //MAKE PMTS THIS PERIOD
      while(i < debtCnt) {

         //WHICH DEBTS ARE PAID OFF

         i = Number(i) + Number(1);
         num_pmts = Number(num_pmts) + Number(1);

         //GET THIS PAYMENTS CURRENT TERMS FROM ARRAY
         adp_bal = adp_bal_arr[i];
         adp_rate = rate_arr[i];
         adp_pmt = pmt_arr[i];

         if(npr_cnt == 1) {
            sum_rows_arr[i] = sum_rows_arr[i] + "<td><font face='arial'><small>$" + fn(adp_bal,0,1) + "<br>$" + fn(adp_pmt,0,1) + "</small></font></td>";
         }



         //IF THIS DEBT's BAL GREATER THAN ZERO, MAKE PMT
         if(adp_bal > 0) {
            adp_intPort = adp_bal * adp_rate;
            //adp_pmt = Number(adp_pmt) + Number(adp_pmt_amt);
            //adp_pmt_amt = 0;
            Vadp_totalint = Number(Vadp_totalint) + Number(adp_intPort);
            adp_prinPort = Number(adp_pmt) - Number(adp_intPort);
            adp_bal = Number(adp_bal) - Number(adp_prinPort);
            if(adp_bal <= 0) {
               adp_excess_pmt = Number(adp_bal * -1);
               adp_pmt = Number(adp_pmt) - Number(adp_excess_pmt);
               adp_prinPort = Number(adp_prinPort) - Number(adp_excess_pmt);
               //ADD EXCESS PMT AMT TO ACCELERATOR AMT
               adp_pmt_amt = Number(adp_pmt_amt) + Number(adp_excess_pmt);
               adp_bal = 0;
               debts_paid_off = Number(debts_paid_off) + 1;
               sum_col_print = 1;

            }
            adp_bal_arr[i] = adp_bal;
            adp_combo_prin = Number(adp_combo_prin) - Number(adp_prinPort);
         } else { //ADD PMT AMOUNT TO ACCELERATOR

            //INCREMENT NUMBER TO NEXT DEBT
            cur_adp_debt = Number(cur_adp_debt) + Number(1);

            //ADD UNEEDED PMT AMT TO ACCELERATOR AMT
            adp_pmt_amt = Number(adp_pmt_amt) + Number(adp_pmt);

            //SET THIS DEBT's PERIOD PAYMENT TO ZERO
           adp_pmt = 0;
         }

         adp_pmt_arr[i] = adp_pmt;

         if(i > 10) {
            break;
         } else {
            continue;
         }

      } //WHILE MAKING PATMENTS ON DEBTS THIS PERIOD



      i = 0;

      //IF EXCESS PAYMENT AMOUNT HAS NOT BEEN USED UP
      if(adp_pmt_amt > 0) {

         adp_combo_prin = Number(adp_combo_prin) - Number(adp_pmt_amt);

         while(i < debtCnt) {

            i = Number(i) + Number(1);

            if(adp_bal_arr[i] > 0) {

               adp_bal_arr[i] = Number(adp_bal_arr[i]) - Number(adp_pmt_amt);

               if(adp_bal_arr[i] > 0) {

                  adp_pmt_arr[i] = Number(adp_pmt_arr[i]) + Number(adp_pmt_amt);
                  adp_pmt_amt = 0;

               } else {

                  adp_pmt_arr[i] = Number(adp_pmt_arr[i]) + Number(adp_pmt_amt) + Number(adp_bal_arr[i]);
                  adp_pmt_amt = Number(adp_pmt_amt) - (Number(adp_pmt_amt) + Number(adp_bal_arr[i]));
                  if(npr_cnt == 6 && i == 1) {
                     //document.debts.test2.value = adp_pmt_amt;
                  }
                  adp_bal_arr[i] = 0;
                  debts_paid_off = Number(debts_paid_off) + 1;
                  sum_col_print = 1;

               }

            }


         }


      }

      i = 0;

      while(i < debtCnt) {

         i = Number(i) + Number(1);

         tot_period_pmts = Number(tot_period_pmts) + Number(adp_pmt_arr[i]);
         if(adp_pmt_arr[i] == 0) {
            Vschedule_cols = Vschedule_cols + "<td align='right'> </td>";
         } else {
            Vschedule_cols = Vschedule_cols + "<td align='right'><font face='arial'><small>" + fn(adp_pmt_arr[i],2,1) + "</small></font></td>";
         }

         if(adp_pmt_arr[debts_paid_off] == 0 && sum_col_print == 1 || debts_paid_off == debtCnt) {
            if(i ==1) {
               Vsummary_head = Vsummary_head + "<td><font face='arial'><small><b>Month " + npr_cnt + "<br>Bal:<br>Pmt:</b></small></font></td>";
            }

            if(adp_bal_arr[i] == 0) {
                sum_rows_arr[i] = sum_rows_arr[i] + "<td align='top'><font face='arial'><small>$0</small></font></td>";
            } else {
            sum_rows_arr[i] = sum_rows_arr[i] + "<td align='top'><font face='arial'><small>$" + fn(adp_bal_arr[i],0,1) + "<br>$" + fn(adp_pmt_arr[i],0,1) + "</small></font></td>";
            }

            if(i == debtCnt) {
               sum_col_print = 0;
            }
         }


      }



      //IF ACCUM UNEEDED AMT GREATER THAN ZERO, APPLY TO CURRENT DEBT's BALANCE
      //adp_bal_arr[cur_adp_debt] = Number(adp_bal_arr[cur_adp_debt]) - Number(adp_pmt_amt);
      //adp_combo_prin = Number(adp_combo_prin) - Number(adp_pmt_amt);

     Vschedule_rows = Vschedule_rows + "<tr><td align='right'><font face='arial'><small>" + npr_cnt + "</small></font></td>" + Vschedule_cols + "</tr>\r";
     tot_period_pmts = 0;
     Vschedule_cols = "";


      if(npr_cnt > 600) {
         break;
      } else {
         continue;
      }


   } //WHILE ALL DEBTS ARE NOT PAID OFF

   document.debts.adp_totalnprs.value = npr_cnt;
   document.debts.adp_totalint.value = "$" + fn(Vadp_totalint,2,1);

   var v_adp_totaldate = computeFutureDate(gv_now_month, gv_now_day, gv_now_year, npr_cnt, 4); 
   document.debts.adp_totaldate.value = v_adp_totaldate;

   var Vadp_npr_save = Number(max_npr) - Number(npr_cnt);
   document.debts.adp_npr_save.value = Vadp_npr_save;

   var Vadp_int_save = Number(totalDebtInt) - Number(Vadp_totalint);
   document.debts.adp_int_save.value = "$" + fn(Vadp_int_save,2,1);

   Vsummary_head = Vsummary_head + "</tr>";

   document.debts.schedule_rows.value = Vschedule_rows;
   document.debts.summary_head.value = Vsummary_head;

   i = 0;
   var Vsummary_rows = "";

   while(i < debtCnt) {

      i = Number(i) + Number(1);

      Vsummary_rows =  Vsummary_rows + "" + sum_rows_arr[i] + "</tr>";

   }

   document.debts.summary_rows.value = Vsummary_rows;


   } 


function createSchedule(form) {

   var Vschedule_head = document.debts.schedule_head.value;
   var Vschedule_rows = document.debts.schedule_rows.value;

   var adpPart1 = "<HEAD><TITLE>Reducing Debt-Payoff Plan</TITLE></HEAD>";
   adpPart1 += "<";
   adpPart1 += "BO";
   adpPart1 += "DY ";
   adpPart1 += "BGCOLOR =  '#FFFFFF'>";
   adpPart1 += "<center><font face='arial'><big><strong>";


   adpPart1 += "Reducing Debt-Payoff Plan</strong></big></font>";
   adpPart1 += "<p><font face='arial'><small><b>Payment Schedule</b></small></font></p>";
   adpPart1 += "<p><font face='arial'><small><b>";
   adpPart1 += "Estimated Debt Freedom Date: " + document.debts.adp_totaldate.value + "</b>";
   adpPart1 += "</small></font>";
   adpPart1 += "<p></center></p><p><center><table border='1' cellspacing='0' cellpadding='2'>";
   adpPart1 += "<tbody>" + Vschedule_head + "" + Vschedule_rows + "</tbody></table></center>";
   adpPart1 += "</p><p><center><font face='arial'><small>This report was created with ";
   adpPart1 += "<U>The Reducing Debt Payoff Calculator</U><br />Written by Daniel C. Peterson";
   adpPart1 += "<BR />Calculator can be found at http://www.webwinder.com</small></font>";
   adpPart1 += "</p><p><form method='post'><input type='button' value='Close Window' onClick='window.close()'>";
   adpPart1 += "</form></p></center></body></html>";

   printWin = window.open("","","width=500,height=400,toolbar=yes,menubar=yes,scrollbars=yes");
   printWin.document.write(adpPart1);
   printWin.document.close();
}

function createSummary(form) {

   var Vsummary_head = document.debts.summary_head.value;
   var Vsummary_rows = document.debts.summary_rows.value;

   var adpPart1 = "<head><title>Reducing Debt-Payoff Plan</title></head>";

   adpPart1 += "<";
   adpPart1 += "bo";
   adpPart1 += "d";
   adpPart1 += "y ";
   adpPart1 += "bgcolor='#FFFFFF'>";


   adpPart1 += "<center><font face='arial'><big><strong>Reducing Debt-Payoff Plan</strong></big></font>";
   adpPart1 += "<p><font face='arial'><small><b>Payoff Summary</b></small></font><br />";
   adpPart1 += "<p><font face='arial'><small><b>";
   adpPart1 += "Estimated Debt Freedom Date: " + document.debts.adp_totaldate.value + "</b>";
   adpPart1 += "</small></font><br /></center>";
   adpPart1 += "</p><p><center><table border='1' cellspacing='0' cellpadding='2'>";
   adpPart1 += "<tbody>" + Vsummary_head + "" + Vsummary_rows + "</tbody></TABLE></center>";
   adpPart1 += "</p><p><center><font face='arial'><small>This report was created with ";
   adpPart1 += "<U>The Reducing Debt Payoff Calculator</U><br />Written by Daniel C. Peterson";
   adpPart1 += "<br />Calculator can be found at http://www.webwinder.com</small></font>";
   adpPart1 += "</p><p><form method='post'><input type='button' value='Close Window' onClick='window.close()'>";
   adpPart1 += "</form></p></center></body></html>";

   printWin = window.open("","","width=500,height=400,toolbar=yes,menubar=yes,scrollbars=yes");
   printWin.document.write(adpPart1);
   printWin.document.close();
}

function clearResults(form) {

   document.debts.totalprin.value = "";
   document.debts.totalpmt.value = "";
   document.debts.totalint.value = "";
   document.debts.totalnprs.value = "";
   document.debts.totaldate.value = "";

   document.debts.adp_totalprin.value = "";
   document.debts.adp_totalpmt.value = "";
   document.debts.adp_totalint.value = "";
   document.debts.adp_totalnprs.value = "";
   document.debts.adp_totaldate.value = "";

   document.debts.adp_int_save.value = "";
   document.debts.adp_npr_save.value = "";

   document.debts.schedule_head.value = "";
   document.debts.schedule_rows.value = "";
   document.debts.summary_head.value = "";
   document.debts.summary_rows.value = "";

   var v_summary_cell = document.getElementById("summary");
   v_summary_cell.innerHTML = "";
}
</script>