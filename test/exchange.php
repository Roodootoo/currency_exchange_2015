<?php
$summa = $_POST["summa"];

$visa_usd = $_POST["visa_usd"];   // сохраним в этой переменной
$visa_eur = $_POST["visa_eur"]; 

$mc_usd = $_POST["mc_usd"]; 
$mc_eur = $_POST["mc_eur"]; 

$ab_take_usd = $_POST["ab_take_usd"]; 
$ab_take_eur = $_POST["ab_take_eur"]; 

$ab_pay_usd = $_POST["ab_pay_usd"]; 
$ab_pay_eur = $_POST["ab_pay_eur"]; 

$ab_fee = $_POST["ab_fee"];
$ab_fee_plus = $_POST["ab_fee_plus"];
 
$oper = $_POST["oper"];

switch ($oper){
   //Снимаем Local Currency с RUB. Visa. Debt
  case "TakeCurRub":
    $itog = $summa / (1/$visa_usd) * $ab_take_usd * (1+$ab_fee_plus/100) * (1+$ab_fee/100) ;
    echo $summa . " / (1/" . $visa_usd . ") * " . $ab_take_usd . " * (1 + " . $ab_fee_plus . "/100) * (1 + " . $ab_fee . "/100) = " . $itog;
    break;

   //Снимаем Local Currency с USD. Visa. Debt
  case "TakeCurUsd":
    $itog = $summa / (1/$visa_usd) * (1+$ab_fee_plus/100) * (1+$ab_fee/100);
    echo $summa . " / (1/" . $visa_usd . ") * (1 + " . $ab_fee_plus . "/100) * (1 + " . $ab_fee . "/100) = " . $itog;    
    break;

   //Платим Local Currency с RUB. MasterCard. Credit
  case "PayCurRubMC":
    $itog = $summa / $mc_usd * $ab_take_usd;
    echo $summa . " / " . $mc_usd . " * " . $ab_take_usd ."  = " . $itog;  
    break;

   //Платим Local Currency с RUB. Visa. Debt
  case "PayCurRubVisa":
    $itog = $summa / (1/$visa_usd) * $ab_pay_usd;
    echo $summa . " / (1/" . $visa_usd . ") * " . $ab_pay_usd ."  = " . $itog;
    break;

   //Платим Local Currency с USD. Visa. Debt
  case "PayCurUsdVisa":
    $itog = $summa / (1/$visa_usd);
    echo $summa . " / (1/" . $visa_usd . ")  = " . $itog;
    break;

   //Платим USD с RUB. MasterCard. Credit
  case "PayUsdRubMC":
    $itog = $summa / (1/$ab_pay_usd);
    echo $summa . " / (1/" . $ab_pay_usd . ")  = " . $itog;
    break;

   //Платим USD с RUB. Visa. Debt
  case "PayUsdRubVisa":
    $itog = $summa / (1/$ab_pay_usd);
    echo $summa . " / (1/" . $ab_pay_usd . ")  = " . $itog;
    break;

   //Платим USD с USD. Visa. Debt
  case "PayUsdUsdVisa":
    $itog = $summa;
    echo $summa . "  = " . $itog;
    break;

   //Платим EUR с RUB. MasterCard. Credit
  case "PayEurRubMC":
    $itog = $summa / $ab_pay_eur;
    echo $summa . " / " . $ab_pay_eur . "  = " . $itog;
    break;

   //Платим EUR с RUB. Visa. Debt
  case "PayEurRubMC":
     $itog = $summa / $ab_pay_eur;
    echo $summa . " / " . $ab_pay_eur . "  = " . $itog;
    break;

   //Платим EUR с USD. Visa. Debt
  case "PayEurUsdVisa":
    $itog = $summa / ($ab_pay_usd);
    echo $summa . " / " . $ab_pay_usd . "  = " . $itog;
    break;
} 


?>
