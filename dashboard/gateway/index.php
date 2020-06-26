<?php

require_once('../../function/functions.php');

$raw = file_get_contents("php://input");

$obj = json_decode($raw);

if($obj->head == 'approval_operation'){
	$url = 'http://127.0.0.1:5000/loanApprovalOperation/';
	$res = curlToPythonApi($raw,$url);
	print($res);
	exit(0);
}else if($obj->head == 'authentication'){
	$url = 'http://127.0.0.1:5000/userAuthentication/';
	$res = curlToPythonApi($raw,$url);
	exit(print($res));
}else{
	print('no');
	exit(0);
}

?>