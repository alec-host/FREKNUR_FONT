<?php
include('conn/clsdbase.php');

/*
================================================================================
#-.php curl.
================================================================================
*/

Function _curlPostToApi($url,$data){
	//-.init curl.
	$ch = curl_init($url);
	
	curl_setopt($ch,CURLOPT_POSTFIELDS,json_encode($data));
	curl_setopt($ch,CURLOPT_HEADER,array('Content-Type:application/json'));
	curl_setopt($ch,CURLOPT_RETURNTRANSFER,true);
	//-.send request.
	$result = curl_exec($ch);	
	
	curl_close($ch);
	
	$result = preg_replace('/HTTP(.*)UTF-8/s',"",$result);
	
	return $result;
}

#-.php curl.
Function curlToPythonApi($data,$url){
	$curl = curl_init();
	curl_setopt_array($curl, array(
		CURLOPT_URL => $url,
		CURLOPT_RETURNTRANSFER => true,
		CURLOPT_ENCODING => "",
		CURLOPT_MAXREDIRS => 10,
		CURLOPT_TIMEOUT => 0,
		CURLOPT_FOLLOWLOCATION => true,
		CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
		CURLOPT_CUSTOMREQUEST => "POST",
		CURLOPT_POSTFIELDS => $data,
		CURLOPT_HTTPHEADER => array("Content-Type: application/json"),
	));

	$response = curl_exec($curl);

	curl_close($curl);
	
	$response = preg_replace('/HTTP(.*)UTF-8/s',"",$response);
	
	print($response);
}

#-.php curl.
Function _curlGetToApi($url,$searchFilter,$min,$max){
	if(strpos($searchFilter,'|') !== false){
		$qry_str = "?flag=0&min=".$min."&max=".$max."&search=".explode('|',$searchFilter)[0]."&account_code=".explode('|',$searchFilter)[1];
	}else{
		$qry_str = "?flag=0&min=".$min."&max=".$max."&search=".$searchFilter;		
	}
	//-.init curl.
	$ch = curl_init($url);
	
	curl_setopt($ch,CURLOPT_URL,$url.$qry_str);
	curl_setopt($ch,CURLOPT_RETURNTRANSFER,true);
	curl_setopt($ch,CURLOPT_TIMEOUT,3);
	//-.send request.
	$result = trim(curl_exec($ch));
	curl_close($ch);
	
	
	return $result;
}

#-.validate if email is well constructed.
Function valid_email($email) {
    return filter_var($email, FILTER_VALIDATE_EMAIL) 
        && preg_match('/@.+\./', $email);
}
#-.get integers from a combinations of integers and chars.
Function get_int_from_string($stngval){
	$int = intval(preg_replace('/[^0-9]+/', '', $stngval), 10);
	return $int;
}
#-.get chars from a combination of chars + integers.
Function get_letter_from_alphanumeric($stngval){
	$char = preg_replace('/[0-9]/','',$stngval);
	return $char;
}
#-.do clean up of user input.
Function sanitize($var){
	if(is_array($var)){
		return array_map('sanitize',$var);
	}
	else{
		if(get_magic_quotes_gpc()){
			$var = stripslashes($var);
		}
		//$var = str_replace("'","\'",$var);
		return $var;
	}
}
?>