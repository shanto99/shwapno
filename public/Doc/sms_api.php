	<?php  
	$apikey='$2y$10$zqmgq8liZZn.TopicM55s.fZu1sVYO8QHjZkf92BrxZESh9XW6.S2';

	if (isset($_POST["msg"]) ) {
		$sendto = $_POST["to"];
		$fullNumber = '880' . substr(preg_replace('/\D/', '', $sendto), -10);
		$msg = urlencode($_POST["msg"]);
	//	$masking='CITY PORTER';
	//	$masking=urlencode($masking);
		
 
		
	$url='http://connect.primesoftbd.com/smsapi/non-masking?api_key='.$apikey.'&smsType=text&mobileNo='.$fullNumber.'&smsContent='.$msg.'';
	//print_r($url);exit();	
		if ( !empty($_POST["to"])  && !empty($_POST["msg"])) {
			
                        $curl = curl_init();

			curl_setopt_array($curl, array(
				CURLOPT_RETURNTRANSFER => 1,
				CURLOPT_URL =>$url,
				CURLOPT_USERAGENT =>'My Browser'
			));
	                //echo '<pre/>';print_r($curl);exit();	
			$resp = curl_exec($curl);

			curl_close($curl);

		} 

		else

			{ echo "Field is empty";}
	}

	?>