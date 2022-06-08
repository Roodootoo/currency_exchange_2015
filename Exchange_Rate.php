<?php 
/*********************************************************************
* exchange.php
*
* Author: Michael DRansfield <mike at(@) blueroot dot(.) net>
* Created: 1 Sept 2001
* 
* 
* Purpose: Gets the uk pound to us dollar conversion rate - thanks to the US FRB.
* Can easily be changed for any currency
* find the file at http://www.stls.frb.org/fred/data/xupdate.html
* and change the file varaible at the top
*
* Latest version always available at http://www.blueroot.net/.
*
* Usage:
* getExDate() - returns the date of the exchange rate (always returns latest)
* getExRate() - returns the rate
*********************************************************************/
Class exchange {

var $exch_file;
var $exch_rate_file_array;
var $num;
var $latest_exch_rate;
var $exch_rate_array;

function exchange(){
$this->exch_file = "http://www.stls.frb.org/fred/data/exchange/update/exch32";
$this->exch_rate_file_array = file($this->exch_file, "r");
$this->num = count($this->exch_rate_file_array);
$this->latest_exch_rate = $this->exch_rate_file_array[$this->num-1];
$this->exch_rate_array = explode(" ", $this->latest_exch_rate);
}

function getExDate()
{
return $this->exch_rate_array[0];
}

function getExRate()
{
return $this->exch_rate_array[1];
}

}
?>

