<html>

<head>

	<title>>Muthumala (TMS) | PDF Print</title>
	
<style>
#customers {
  font-family: Arial, Helvetica, sans-serif;
  border-collapse: collapse;
  width: 100%;
}

#customers td, #customers th {
  border: 1px solid #ddd;
  padding: 8px;
}

#customers tr:nth-child(even){background-color: #f2f2f2;}

#customers tr:hover {background-color: #ddd;}

#customers th {
  padding-top: 12px;
  padding-bottom: 12px;
  text-align: left;
  background-color: #04AA6D;
  color: white;
}
</style>

</head>

<body>

<?php 
				$sum=0;
                $total=0;
                $discount=0;
                $totalVat=0;
                $amountTotal=0;
				$totalChargers=0;
				$string = $layout[0]->document_layout;
				$i=1;

				preg_match_all('#table=([^\s]+)#', $string, $matches);

				$value=implode(' ', $matches[1]);
				$list = explode(',', $value);
				$string = str_replace('[our_company]', $muthucompany->company_name, $string);
				$string = str_replace('[contact_person]', $contactPerson->name, $string);
				$string = str_replace('[customer_address]', $company->address, $string);
				$string = str_replace('[customer_name]', $company->customer_name, $string);
				$string = str_replace('[invoice_date]', $invoice->invoice_date, $string);
				$string = str_replace('[invoice_number]', $invoice->invoice_number, $string);
				$string = str_replace('[transport_routes]', $routes->route_name, $string);
				$string = str_replace('[transport_routes]', $routes->route_name, $string);
				$string = str_replace('[customer_vat_Number]', $company->vatNumber, $string);



/*foreach ($tagList as $key => $value): 					
	if($value->type ==1){
		$tag=$value->tag;
		$string = str_replace($value->name, $customer[0]->$tag, $string);  
	}	
endforeach 	;*/

foreach ($tagList as $value): 					
	$tagvalues[] = array('name'=>$value->name, 'value' => $value->value);	
	$tripvalues[] = array('name'=>$value->name, 'dbCell' => $value->tag);	
endforeach 	;

$string = str_replace($matches[1], '', $string);
$string = str_replace('table=', '', $string);



//exit();



								$forecastDiv ='<table id="customers"><tr>';	
								
								foreach($list as $lists):	
								
										foreach($tagvalues as $key => $value):	
											if($value['name'] == $lists){
												$forecastDiv .='<td style=" text-align: center;">'.$value['value'].'</td>';
											}
										endforeach;		
									
								endforeach;	
								$forecastDiv .='</tr>';
								
									foreach($trips as $tripsrecord):		
											$sum += $tripsrecord->paymentAmount ;
											$discount += $tripsrecord->paymentDiscount ;
											$amount =  $tripsrecord->paymentAmount-$tripsrecord->paymentDiscount;
											$amountTotal += $tripsrecord->paymentAmount-$tripsrecord->paymentDiscount;
											
										 $totalChargers +=$amountTotal;
									
									$colspan=sizeof($list)-2;
									
												$rate= number_format($amountTotal,2,'.',',');
																$forecastDiv .='<tr>';      
																	foreach($list as $lists):	
																		foreach($tripvalues as $key => $value):	
																			if($value['name'] == $lists){
																				if($value['name'] =='[rate]'){
																					$forecastDiv .='<td>'.$rate.'</td>';
																				}else{
																					$valuecell=$value['dbCell'];												
																					$forecastDiv .='<td>'.$tripsrecord->$valuecell.'</td>';
																				}
																			}
																		endforeach;		
																			
																	endforeach;	
																		
																$forecastDiv .='</tr>';	
																endforeach;	
											$forecastDiv .='</table>';							
																
										$total='<table id="customers"><tr>';							
																$totalVat=($totalChargers *$invoice->vat_amount )/100;
																$total .='
																	<td style=" text-align: center;" colspan="'.$colspan.'">TOTAL</td>
																	<td>'. number_format($totalChargers,2,'.',',').'</td>
																</tr>';
																$total .='<tr>
																	<td style=" text-align: center;" colspan="'.$colspan.'">VAT('.$invoice->vat_amount.'%)</td>
																	<td>'. number_format($totalVat,2,'.',',').'</td>
																</tr>';
																$total .='<tr>
																	<td style=" text-align: center;" colspan="'.$colspan.'">FULL AMOUNT</td>
																	<td>'. number_format($totalChargers + $totalVat ,2,'.',',').'</td>
																</tr>';
																
																$total .='</table>';
							
											$string = str_replace('[forecast]', $forecastDiv, $string);  
											$string = str_replace('[total]', $total, $string);  
											



?>

    <?php echo $string;  ?>

</body>

</html>