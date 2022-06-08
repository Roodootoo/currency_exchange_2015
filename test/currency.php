<?php header ("Content-Type: text/html; charset=utf-8");?>
<meta http-equiv="content-type" content="text/html; charset=UTF-8" />

<!DOCTYPE html>
<html>

    <head>
        <link type='text/css' rel='stylesheet' href='style.css'/>
        <title>Currency Exchange Information</title>
		<style>
	    	body {
    			margin: 50; /* отступы */
   	    	}
   	    	table {
    			//width: 50%; /* Ширина таблицы в процентах */
   	    	}
   	    	.broad {
    			width: 20px; /* Ширина ячейки */
   	    	}
  		</style>
 		
 		<script type="text/javascript"> <!--Показываем нужные инпуты-->
			function mChangeV(obj){
				var el, s, n, v;
				el=obj.options;
				n=el.selectedIndex;
				v=el[n].value;
				s=obj.id+'_show';
				if(v=="????"){
					if(document.getElementById(s)){
						document.getElementById(s).style.visibility="visible";}};
			};
			function mChangeDCard(obj){
				var el, s, n, v;
				el=obj.options;
				n=el.selectedIndex;//индекс выбранного оптиона
				v=el[n].value;
				alert(v);
				if(v=="sel_visa"){//только если выбран нужный оптион
					<table>
 		   	 			<tr><td><a href=http://usa.visa.com/personal/card-benefits/travel/exchange-rate-calculator.jsp target="_blank">Курсы Visa (перейти на сайт Visa) - валюта операции к валюте карты</a></tr>
       					<tr><td>Курс Visa USD</td>          <td><input type=int name="visa_usd"
        	 			  	value="<?php echo isset($_POST['visa_usd']) ? htmlspecialchars($_POST['visa_usd']) : ''; ?>" 
                   			size=12 placeholder="Введите курс с сайта Visa" required>
                   		</td></tr>
        		    	<tr><td>Курс Visa EUR</td>          <td><input type=int name="visa_eur"
        	    			value="<?php echo isset($_POST['visa_eur']) ? htmlspecialchars($_POST['visa_eur']) : ''; ?>" 
                    		size=12 placeholder="Введите курс с сайта Visa" required>
                    	</td></tr>
                    </table>
				}
				else{
  					<table>
          	    		<tr><td><a href=https://www.mastercard.com/global/currencyconversion/ target="_blank">Курс MasterCard (перейти на сайт MasterCard) - валюта операции к валюте карты</a></tr>
             	   		<tr><td>Курс MC USD</td> <td><input type=int name="mc_usd" 
                			value="<?php echo isset($_POST['mc_usd']) ? htmlspecialchars($_POST['mc_usd']) : ''; ?>"
                			size=12 placeholder="Введите курс с сайта MC">
               			</td></tr>
            	   		<tr><td>Курс MC EUR</td> <td><input type=int name="mc_eur" 
            				value="<?php echo isset($_POST['mc_eur']) ? htmlspecialchars($_POST['mc_eur']) : ''; ?>"
                			size=12 placeholder="Введите курс с сайта MC">
                		</td></tr>
                    </table>
				};
			};
		</script>  <!--Показываем нужные инпуты-->
   </head>
    
    <body>
	
	<?  
	function VAL($id){  //R01235 - USD   //R01239 - Euro
		$cache=0;
		$time_cache=108000; // время жизни кеша  
		$time = time();
		if(file_exists('tmp/'.$id)){
			$str = file_get_contents('tmp/'.$id);
			$str = explode(":", $str);
			if($str[0]<$time) {
				$cache=1;
			}
			else{
				return $str[1];
			}	
		}
		else{
			$cache=1;
		}	
		if($cache==1){
			date_default_timezone_set('Europe/Moscow');
			$date = date("d/m/Y"); 
			$link = "http://www.cbr.ru/scripts/XML_daily.asp?date_req=$date"; 
			$str = file_get_contents ($link);
			preg_match('#<Valute ID="'.$id.'">.*?.<Value>(.*?)</Value>.*?</Valute>#is', $str, $value);
			preg_match('#<Valute ID="'.$id.'">.*?.<CharCode>(.*?)</CharCode>.*?</Valute>#is', $str, $code);
			if($value[1]!=''){
				$write = $value[1];
				file_put_contents($id, $time+$time_cache.':'.$write);
				return $write;
			}
		}	
	}
	?> <!--Функция Val. Получаем курс с сайта CBR.ru - не используется-->
	
	<!--Проверка заполненности формы-->
	<?	
	function check_input($data, $problem = "")
	{
		$data = trim($data);
		$data = stripslashes($data);
		$data = htmlspecialchars($data);
		if ($problem && strlen($data) == 0)
		{
			show_error($problem);
		}
		if ($data == 0)
		{
			show_error($problem);
		}
		return $data;
	}
	function show_error($myError)
		{echo "Пожалуйста, исправьте следующую ошибку: ".$myError; exit();}
	?> <!--Проверка заполненности формы-->

    <h2>Сколько снимут бабла с карты?</h2>

	<form method = "post">
        <!--<form action="exchange.php" method=POST>--> <!--создаем форму-->
            <!--данные формы будет обрабатывать файл 1.php, при
            отправке запроса будет использован метод POST-->
                    
	    <table>
        	<tr>
			<td valign="top">
				<table>  <!--Выбор опции операции-->     
				<tr> <!--Введите сумму операции:-->
					<td>
 	 					<p><b>Введите сумму операции:</b></p> 
 	 				</td> 
					<td>
						<input type=int name="summa" 
        					value="<?php echo isset($_POST['summa']) ? htmlspecialchars($_POST['summa']) : '30000'; ?>" 
        					size=20 placeholder="Сумма операции" required>
					</td>
				</tr> <!--Введите сумму операции:-->
				<tr> <!--Выберите валюту операции:-->
					<td>
 	 					<p><b>Выберите валюту операции:</b></p> 
 	 				</td> 
					<td>
						<select name="SelValOper" size="1">
							<option value="sel_rub">Рубль - Rub</option>
							<option value="sel_usd">Доллары США - USD</option>
							<option value="sel_eur">Евро - Euro</option>
							<option value="sel_loc" selected="selected">Местная валюта - Local Currency</option>
						</select>
					</td>
				</tr> <!--Выберите валюту операции:-->
 	 	  		<tr> <!--Выберите тип операции:-->
 	 	  			<td>
 	 	  				<p><b>Выберите тип операции:</b></p>
 	 	  			</td> 
					<td>
						<select name="SelOper" size="1">
							<option value="sel_take" selected="selected">Снимаем деньги в банкомате / банке</option>
							<option value="sel_pay">Расплачиваемся в магазине</option>
						</select>				
					</td>
				</tr> <!--Выберите тип операции:-->
				<tr> <!--Выберите платёжную систему вашей банковской карты:-->
					<td>
 	 	  				<p><b>Выберите платёжную систему вашей банковской карты:</b></p>
 	 	  			</td> 
					<td>
						<select name="SelCars" size="1" onchange="mChangeDCard(this);">
							<option value="sel_visa" selected="selected">Visa (USD)</option>
							<option value="sel_mc">Master Card (Euro)</option>
						</select>
					</td>
				</tr> <!--Выберите платёжную систему вашей банковской карты:-->
				<tr> <!--Выберите валюту вашей банковской карты:-->
					<td>
   	 					<p><b>Выберите валюту вашей банковской карты:</b></p>
   	 				</td> 
					<td>
						<select name="SelValCard" size="1">
							<option value="sel_card_rub">Рубль - Rub</option>
							<option value="sel_card_usd" selected="selected">Доллары США - USD</option>
							<option value="sel_card_eur">Евро - Euro</option>
						</select>
					</td>
				</tr> <!--Выберите валюту вашей банковской карты:-->
			</table>  <!--Выбор опции операции-->
			</td>
			</tr>
			<tr valign="top" >
				<td class="broad">
					<p><b>Введите курсы:</b></p>
					<table>
        				<p>
		  	 		<tr><td><a href=http://usa.visa.com/personal/card-benefits/travel/exchange-rate-calculator.jsp target="_blank">Курсы Visa (перейти на сайт Visa) - валюта операции к валюте карты</a></tr>
        			    <tr><td>Курс Visa USD</td>          <td><input type=int name="visa_usd"
        	 		   		value="<?php echo isset($_POST['visa_usd']) ? htmlspecialchars($_POST['visa_usd']) : ''; ?>" 
                 			size=12 placeholder="Введите курс с сайта Visa" required>
                   		</td></tr>
        		    	<tr><td>Курс Visa EUR</td>          <td><input type=int name="visa_eur"
        	    			value="<?php echo isset($_POST['visa_eur']) ? htmlspecialchars($_POST['visa_eur']) : ''; ?>" 
                        	size=12 placeholder="Введите курс с сайта Visa" required>
                        </td></tr>
       	    			</p>
						<p>  
            	    	<tr><td><a href=https://www.mastercard.com/global/currencyconversion/ target="_blank">Курс MasterCard (перейти на сайт MasterCard) - валюта операции к валюте карты</a></tr>
             	   		<tr><td>Курс MC USD</td> <td><input type=int name="mc_usd" 
                			value="<?php echo isset($_POST['mc_usd']) ? htmlspecialchars($_POST['mc_usd']) : ''; ?>"
                			size=12 placeholder="Введите курс с сайта MC">
               		</td></tr>
            	    	<tr><td>Курс MC EUR</td> <td><input type=int name="mc_eur" 
                			value="<?php echo isset($_POST['mc_eur']) ? htmlspecialchars($_POST['mc_eur']) : ''; ?>"
                			size=12 placeholder="Введите курс с сайта MC">
                		</td></tr>
           			</p>
						<p>
               	 		<tr><td><a href=http://alfabank.ru/peterburg/retail/currency/>Курсы вашего Банка (перейти на сайт Альфа Банка)</a></tr>
                		<tr><td>Курс снятия USD в вашем Банке</td> <td><input type=int name="ab_take_usd"
                			value="<?php echo isset($_POST['ab_take_usd']) ? htmlspecialchars($_POST['ab_take_usd']) : Val(R01235); ?>"
                    	    size=12 placeholder="Введите курс с сайта вашего банка">
                    	</td></tr>
        	    		<tr><td>Курс снятия EUR в вашем Банке</td> <td><input type=int name="ab_take_eur"
        	    			value="<?php echo isset($_POST['ab_take_eur']) ? htmlspecialchars($_POST['ab_take_eur']) : Val(R01239); ?>"
                    		size=12 placeholder="Введите курс с сайта вашего банка">
                    	</td></tr>

                		<tr><td>Курс оплаты USD в вашем Банке</td> <td><input type=int name="ab_pay_usd"
                			value="<?php echo isset($_POST['ab_pay_usd']) ? htmlspecialchars($_POST['ab_pay_usd']) : Val(R01235); ?>"
                  	      	size=12 placeholder="Введите курс с сайта вашего банка">
                  	  	</td></tr>
                		<tr><td>Курс оплаты EUR в вашем Банке</td> <td><input type=int name="ab_pay_eur"
                			value="<?php echo isset($_POST['ab_pay_eur']) ? htmlspecialchars($_POST['ab_pay_eur']) : Val(R01239); ?>"
                	        size=12 placeholder="Введите курс с сайта вашего банка">
                	    </td></tr>
						</p>
            			<p>
        	   		 	<tr><td>Комиссия вашего Банка, %</td> <td><input type=int name="ab_fee" 
                	        value="<?php echo isset($_POST['ab_fee']) ? htmlspecialchars($_POST['ab_fee']) : '1'; ?>"
               	       		size=12 placeholder="Введите комиссию вашего банка" required>
               	       	</td></tr>
               	 		<tr><td>Комиссия платёжной системы для вашего банка, %</td> <td><input type=int name="ab_fee_plus"
                        	value="<?php echo isset($_POST['ab_fee_plus']) ? htmlspecialchars($_POST['ab_fee_plus']) : '2.5'; ?>"
                        	size=12 placeholder="Введите комиссию вашего банка" required>
                        </td></tr>
            			</p>
    				</table>
    			</td>
  				<script type="text/javascript">
					document.getElementById('visa_usd').style.display="block";
					document.getElementById('visa_eur').style.display="block";
					document.getElementById("mc_usd").style.display="block";
					document.getElementById("mc_eur").style.display="block";
				</script>	
       	</tr> <!--Курсы-->
	    </table>
        <p>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
        <input type=submit name = "Exchange" value="Вычислить" style="width:200Px;height:20Px"></p>
    </form>
	
	<br>
	<h2>
	
	<?
	if($_POST['Exchange'])
	{
		/* Осуществляем проверку вводимых данных и их защиту от враждебных скриптов */
		$ex_summa = htmlspecialchars($_POST["summa"]);
		
		/* Проверяем заполнены ли обязательные поля ввода, используя check_input функцию */
		$ex_summa = check_input($_POST["summa"], "Введите сумму операции!");
		$ex_visa_usd = check_input($_POST["visa_usd"], "Введите курс Visa Usd!");
		$ex_visa_eur = check_input($_POST["visa_eur"], "Введите курс Visa Euro!");
		$ex_mc_usd = check_input($_POST["mc_usd"], "Введите курс MC Usd");
		$ex_mc_eur = check_input($_POST["mc_eur"], "Введите курс MC Euro!");
		$ex_ab_take_usd = check_input($_POST["ab_take_usd"], "Введите курс снятия Банка Usd!");
		$ex_ab_take_eur = check_input($_POST["ab_take_eur"], "Введите курс снятия Банка Euro!");
		$ex_ab_pay_usd = check_input($_POST["ab_pay_usd"], "Введите курс оплаты Банка Usd!");
		$ex_ab_pay_eur = check_input($_POST["ab_pay_eur"], "Введите курс оплаты Банка Euro!");
		$ex_ab_fee = check_input($_POST["ab_fee"], "Введите комиссию Банка!");
		$ex_ab_fee_plus = check_input($_POST["ab_fee_plus"], "Введите комиссия платёжной системы!");
				
		$SelOper = $_POST["SelOper"]; //sel_take & sel_pay
		$SelValOper = $_POST["SelValOper"]; //sel_rub & sel_usd & sel_eur & sel_loc
		$SelCars = $_POST["SelCars"]; //sel_visa & sel_mc
		$SelValCard = $_POST["SelValCard"]; //sel_card_rub & sel_card_usd & sel_card_eur
		
		if ($SelCars = "sel_visa")  //Курс валют платёжной системы
			{$ex_usd = $ex_visa_usd; $ex_eur = $ex_visa_eur; $ex_val_card = $ex_usd;}
		elseif ($SelCars = "sel_mc")
			{$ex_usd = $ex_mc_usd; $ex_eur = $ex_mc_eur; $ex_val_card = $ex_eur;};
				 
		if ($SelOper == "sel_take")  //Снимаем в банке
		{
			if ($SelValCard == "sel_card_rub") //Снимаем с рублей
			{
				if ($SelValOper == "sel_rub")  //Снимаем рубли
				{
		    		$ex_itog = $ex_summa * (1+$ex_ab_fee/100);
		    		echo "Снимаем в банке рубли с рублей : " . $ex_summa . " * (1 + " . $ex_ab_fee . "/100) = " . $ex_itog;
				}
				elseif ($SelValOper == "sel_usd")  //Снимаем баксы
				{
		 		   $ex_itog = $ex_summa / (1/$ex_ab_pay_usd);
		 		   echo "Снимаем в банке баксы с рублей : " . $ex_summa . " / (1/" . $ex_ab_pay_usd . ")  = " . $ex_itog;
				}
				elseif ($SelValOper == "sel_eur")  //Снимаем евро
				{
		 		   $ex_itog = $ex_summa / (1/$ex_ab_pay_eur);
		 		   echo "Снимаем в банке евро с рублей : " . $ex_summa . " / (1/" . $ex_ab_pay_eur . ")  = " . $ex_itog;
				}
				elseif ($SelValOper == "sel_loc")  //Снимаем местное
				{
				    $ex_itog = $ex_summa / (1/$ex_visa_usd) * $ex_ab_take_usd * (1+$ex_ab_fee_plus/100) * (1+$ex_ab_fee/100);
				    echo "Снимаем в банке местные с рублей : " . $ex_summa . " / (1/" . $ex_visa_usd . ") * " . $ex_ab_take_usd . " * (1 + " . $ex_ab_fee_plus . "/100) * (1 + " . $ex_ab_fee . "/100) = " . $ex_itog;
				}
			}
			elseif ($SelValCard == "sel_card_usd") //Снимаем с баксов
			{
				if ($SelValOper == "sel_rub")  //Снимаем рубли
				{
		 			$ex_itog = $ex_summa / (1/$ex_ab_pay_usd);
		 		   	echo "Снимаем в банке рубли с баксов : " . $ex_summa . " / (1/" . $ex_ab_pay_usd . ")  = " . $ex_itog;
				}
				elseif ($SelValOper == "sel_usd")  //Снимаем баксы
				{
		    		$ex_itog = $ex_summa * (1+$ex_ab_fee/100);
		    		echo "Снимаем в банке баксы с баксов : " . $ex_summa . " * (1 + " . $ex_ab_fee . "/100) = " . $ex_itog;
				}
				elseif ($SelValOper == "sel_eur")  //Снимаем евро
				{
		 		   $ex_itog = $ex_summa / (1/$ex_ab_pay_eur);
		 		   echo "Снимаем в банке евро с баксов : " . $ex_summa . " / (1/" . $ex_ab_pay_eur . ")  = " . $ex_itog;
				}
				elseif ($SelValOper == "sel_loc")  //Снимаем местное
				{
		 		   $ex_itog = $ex_summa / (1/$ex_val_card) * (1+$ex_ab_fee_plus/100) * (1+$ex_ab_fee/100);
				    echo "Снимаем в банке местные с баксов : " . $ex_summa . " / (1/" . $ex_val_card . ") * (1 + " . $ex_ab_fee_plus . "/100) * (1 + " . $ex_ab_fee . "/100) = " . $ex_itog;
				}
						
			}
			elseif ($SelValCard == "sel_card_eur") //Снимаем с евро
			{
				
			}
			}
		elseif ($SelOper == "sel_pay")  //Расплачиваемся
		{
		}
		
		
	}; // if($_POST['Exchange'])
	
    ?>  <!--Обработка-->
	
	</h2>
    </body>

</html>


