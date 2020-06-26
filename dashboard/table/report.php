<?php
require_once('../../function/functions.php');
require_once('PHPExcel/Classes/PHPExcel.php');
require_once('PHPExcel/Classes/PHPExcel/Writer/Excel5.php');

if(isset($_REQUEST['page']) && trim($_REQUEST['page']) != ''){
	$nav_page = $_REQUEST['page'];
}else {
	$nav_page = '';
}

$apiUrl = 'http://127.0.0.1:5000/getAccountSummaryApi/';
$findItem = '0';
$leadPage = '0';
$pageSize = '1000';


$json = _curlGetToApi($apiUrl,$findItem,$leadPage,$pageSize);


$obj = json_decode($json,true);

print("Comming soon");

exit(0);

$extension = ".xls";
$file_name = "FREKNUR_".$nav_page."_".date("Y/m/d");
$firm_name = "FREKNUR";
$head_info = "COMPANY……………………………………………………………………………………………………DATE………………………………………………………………………";

header("Content-Type: application/xls");
header("Content-Disposition: attachment; filename=".$file_name.$extension);
header("Pragma: no-cache");
header("Expires: 0");


$objPHPExcel = new PHPExcel();

$highestRow = $objPHPExcel->getActiveSheet()->getHighestRow();
$highestColumn = $objPHPExcel->getActiveSheet()->getHighestColumn();

$objPHPExcel->setActiveSheetIndex(0); 
$objPHPExcel->getActiveSheet()->getColumnDimension('A')->setWidth(12);

$objPHPExcel->getActiveSheet()->SetCellValue('A1', $head_info);
$objPHPExcel->getActiveSheet()->mergeCells('A1:C1');
$objPHPExcel->getActiveSheet()->SetCellValue('D1', $firm_name);
$objPHPExcel->getActiveSheet()->mergeCells('D1:E1');
$objPHPExcel->getActiveSheet()->SetCellValue('F1', date('d-m-Y'));


#-define the headers.
$objPHPExcel->getActiveSheet()->SetCellValue('A2', "ACCOUNT CODE");
$objPHPExcel->getActiveSheet()->SetCellValue('B2', "ACCOUNT NAME");
$objPHPExcel->getActiveSheet()->SetCellValue('C2', "RUNNING BALANCE");
$objPHPExcel->getActiveSheet()->SetCellValue('D2', "DATE CREATED");

#-freeze pane.
$objPHPExcel->getActiveSheet()->freezePane('A3');
#-ensure the column size is autosized for column A-G
for($col = 'A'; $col !== 'E'; $col++) {
	$objPHPExcel->getActiveSheet()->getColumnDimension($col)->setAutoSize(true);
}
#-define the style for the header.
$styleArray1 = array(
                   'font'    => array('bold'   => true,),
				   'borders' => array('outline'=> array('style' => PHPExcel_Style_Border::BORDER_THIN,),
				                      'inside' => array('style' => PHPExcel_Style_Border::BORDER_THIN,),
									 ),
				   'fill'    => array('type'   => PHPExcel_Style_Fill::FILL_SOLID,
				                      'color'  => array('rgb'  => 'C0C0C0',),
									 ),
);

#-define the style for the body.
$styleArray2 = array(
                   'font'    => array('bold'   => false, 'size' => '10'),
				   'borders' => array('top'    => array('style' => PHPExcel_Style_Border::BORDER_THIN,),
				                      'bottom' => array('style' => PHPExcel_Style_Border::BORDER_THIN,)),
				   'fill'    => array('type'   => PHPExcel_Style_Fill::FILL_SOLID,
				                      'color'  => array('rgb'  => 'FFEE82',),),
);	
$styleArray3 = array(
                   'font'    => array('bold'   => false, 'size' => '10'),
				   'borders' => array('top'    => array('style' => PHPExcel_Style_Border::BORDER_THIN,),
				                      'bottom' => array('style' => PHPExcel_Style_Border::BORDER_THIN,),),
);
$styleArray4 = array(
                   'font'    => array('bold'   => false, 'size' => '10'),
				   'borders' => array('top'    => array('style' => PHPExcel_Style_Border::BORDER_THIN,),
				                      'bottom' => array('style' => PHPExcel_Style_Border::BORDER_THIN,)),
				   'fill'    => array('type'   => PHPExcel_Style_Fill::FILL_SOLID,
				                      'color'  => array('rgb'  => 'B2FFFF',),),
);

#-set the style.
$objPHPExcel->getActiveSheet()->getStyle('A2:D2')->applyFromArray($styleArray1);
#-loop through the record provided via PDO.
$rowCount = 3;  


foreach($rows as $row){
	$schema_insert = "";
	$column = 'A';
	for($j=0; $j<5;$j++){
		if(!isset($row[$j]))
			$schema_insert = "NULL";
		elseif ($row[$j] != "")
			$schema_insert = strip_tags($row[$j]);
		else
			$schema_insert = "";
		
		$objPHPExcel->getActiveSheet()->setCellValue($column.$rowCount, $schema_insert);
		
		if(strtolower(trim($schema_insert))=='completed'){
			$objPHPExcel->getActiveSheet()->getStyle('A'.$rowCount.':F'.$rowCount)->applyFromArray($styleArray2);
		}else if(strtolower(trim($schema_insert))=='pending'){
			$objPHPExcel->getActiveSheet()->getStyle('A'.$rowCount.':F'.$rowCount)->applyFromArray($styleArray4);
		}else{
			$objPHPExcel->getActiveSheet()->getStyle($column.$rowCount)->applyFromArray($styleArray3);
		}
		$column++;
	}	
	$rowCount++;
}


$objPHPExcel->getActiveSheet()->setTitle('Sheet 1');
$objWriter = PHPExcel_IOFactory::createWriter($objPHPExcel, 'Excel5');
$objWriter->save('php://output');
exit(0);
?>