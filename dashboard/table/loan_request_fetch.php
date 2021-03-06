<?php
session_start();

require_once('../../function/functions.php');

try
{
	#-.Getting records (listAction)
	if($_GET["action"] == "list")
	{		
		$jTableResult = array();
		
		if(isset($_REQUEST['search_name']) && trim($_REQUEST['search_name']) != ""){
			$searchFilter = $_REQUEST['search_name'];
		}else{
			$searchFilter = "0";
		}
		
		$apiUrl = 'http://127.0.0.1:5000/getLoanRequestListApi/';
		
		$result = _curlGetToApi($apiUrl,$searchFilter,'0',$_GET['jtPageSize']);
		
		print($result);
		
		exit(0);
		
	}
	#-.Deleting a record (deleteAction)
	else if($_GET["action"] == "delete")
	{
		del_inquiry($_REQUEST['_id']);
		
		$jTableResult = array();
		$jTableResult['Result'] = "OK";
		
		print(json_encode($jTableResult));	

		exit(0);
	}
}
catch(Exception $ex)
{
    #-.Return error message
	$jTableResult = array();
	$jTableResult['Result'] = "ERROR";
	$jTableResult['Message'] = $ex->getMessage();
	
	print(json_encode($jTableResult));
	
	exit(0);
}
	
?>