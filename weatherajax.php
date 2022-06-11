<?php

$location = $_POST['location'];
if (!empty($location)) {
	$city=$_POST['location'];
	$url = "http://api.weatherapi.com/v1/forecast.json?key=b40fb1d567604d97b7562130221006&q=$city&days=7";
    $ch=curl_init();
    curl_setopt($ch,CURLOPT_URL,$url);
    curl_setopt($ch,CURLOPT_RETURNTRANSFER,true);
    $response=curl_exec($ch);
    $err = curl_error($ch);
    curl_close($ch);

	if ($err) {
		echo "cURL Error #:" . $err;
	} else {
		$div ="";
		$response = json_decode($response,true);


		try {
			if (!empty($response)) {
				foreach ($response['forecast']['forecastday'] as $key => $value) {
					$current = date('l',$value['date_epoch']);
					$date = date('l', time());
					if( $current == $date){
						$date = "Today (" . date('l',$value['date_epoch']) . ")";
					}
					else {
						$date = date('l',$value['date_epoch']);
					}
					$div .= "<p class='sat'>".$date." <br><span>max - ".$value['day']['maxtemp_c']."</span><br><span>min - ".$value['day']['mintemp_c']."</span></p>";
				}
			}
			echo $div;
		} catch (Exception $e) {
			echo $e;
		}
	}
}
?>
