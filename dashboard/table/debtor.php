<!DOCTYPE html>
<html lang="en">
  <head>

	<link href="ui/jquery-ui.min.css" rel="stylesheet" type="text/css" />
	<script src="ui/jquery-ui.min.js" type="text/javascript"></script>
	
	<link href="themes/metro/blue/jtable.min.css" rel="stylesheet" type="text/css" />
	
	<link href="validate/validationEngine.css" rel="stylesheet" type="text/css" />
	
	<script src="scripts/jquery-1.9.1.js" type="text/javascript"></script>
	<script src="scripts/jquery-ui-1.10.0.min.js" type="text/javascript"></script>
    <script src="jquery.jtable.min.js" type="text/javascript"></script>
	
	<script src="validate/jquery.validationEngine-en.js" type="text/javascript" charset="utf-8"></script>
    <script src="validate/jquery.validationEngine.js" type="text/javascript" charset="utf-8"></script>	
	
	<style type="text/css">
	html{
		/*background:#fff;*/
		padding:1px;
	}
	.card {
		box-shadow: 0 4px 8px 0 rgba(0,0,0,0.2);
		transition: 0.3s;
		background: #000;
		padding: 2px;
		width: 30%;
	}
	.card:hover {
		box-shadow: 0 8px 16px 0 rgba(0,0,0,0.2);
	}

	.container {
		padding: 2px 0px;
	}
	
	.btn {
		font-family: calibri;
		color: #fff;
		padding-left: 25px;
		padding-right: 1px;
		border: 1px solid #fff;
		background: #000 url("img/home.png") no-repeat 1px center;
		cursor: pointer;		
	}
	
	.btn2 {
		width: 80px;
		font-family: calibri;
		color: #fff;
		font-size: 15px;
		font-weight:bold;
		padding: 2px;
		border: 0px solid #fff;
		border-radius: 2px;
	    background: #000 url("img/search.png") no-repeat center;
		cursor: pointer;		
	}
	
	#word{
		border: 1px solid #fff;
		border-radius: 2px;
		font-family: calibri;
		font-size: 14px;
		padding: 2px;
		width: 80%;
	}
		
	.ui-button, .ui-button-text, .ui-button, .jtable-input-label{
		font-size: 13px !important;
	}
		
	#gridSpan{
		color:#6D9900;
		font-family: calibri;
		font-weight:bold;
	}
	</style>
	<script type="text/javascript">
		$(document).ready(function () {	
		    //-.prepare jTable.
			$('#DataViewTable').jtable({
				title: '<span style="color:#000">&nbsp;</span>',
				toolbar:{
					items: [{
						tooltip: 'Click to download',
						icon: 'img/excel.png',
						text: 'Download',
						click: function (){
							window.location = 'report.php?formName=account&action=export-excel';
							e.preventDefault();
						}
					}]
				},
				paging: true,	
				pageSize: 10,
                selecting: true, 
				messages: {
					addNewRecord: ''
				},
				columnResizable: false,
				actions: {
					listAction: 'debtor_fetch.php?action=list&jtStartIndex=0&jtPageSize=10&jtSorting=null'
				},
				fields: {
						id: {
							key: true,
							create: false,
							edit: false,
							list: false
						},
						reference_no: {
							title: 'REFERENCE',
							width: '5%',
							create: false,
							edit: false,
						},								
						msisdn: {
							title: 'MSISDN',
							width: '5%',
							create: false,
							edit: false,
						},							
						amount_requested: {
							title: 'AMOUNT REQUESTED',
							width: '5%',
							create: false,
							edit: false,
							display:function(data){
								return '<span><b>'+formatNumber(data.record.amount_requested)+'</b></span>';
							}
						},
						amount_disbursed: {
							title: 'LOANED AMOUNT',
							width: '5%',
							create: false,
							edit: false,
							display:function(data){
								return '<span><b>'+formatNumber(data.record.amount_disbursed)+'</b></span>';
							}
						},											
						repayment_amount: {
							title: 'REPAYMENT AMOUNT',
							width: '5%',
							create: false,
							edit: false,
							display:function(data){
								return '<span><b>'+formatNumber(data.record.repayment_amount)+'</b></span>';
							}
						},
						repayment_date: {
							title: 'REPAYMENT DATE',
							width: '5%',
							type: 'date',
							create: false,
							edit: false,
							displayFormat: 'yy-mm-dd',
							inputClass: 'validate[required]',
							display: function(data){
								return data.record.repayment_date.replace("'","").replace("'","");
							}
						},							
						date_created: {
							title: 'DATE CREATED',
							width: '5%',
							type: 'date',
							create: false,
							edit: false,
							displayFormat: 'yy-mm-dd',
							inputClass: 'validate[required]',
							display: function(data){
								return data.record.date_created.replace("'","").replace("'","");
							}
						}
					},	
					selectionChanged: function () {
						/*
						//-Get all selected rows
						var $selectedRows = $('#DataViewTable').jtable('selectedRows');
						$('#SelectedRowList').empty();
						if ($selectedRows.length > 0) {
						    //Show selected rows
						    $selectedRows.each(function () {
						        var record = $(this).data('record');
						        $('#SelectedRowList').append(
						            '&nbsp;<b><kbd>Reference</kbd></b>: <kbd>' + record.reference_no + '</kbd> ' +
						            '<b><kbd>Account</kbd></b>: <kbd>' + record.account_code + '</kbd><br />'
						            ); 
						        $("#txt_3").val(record.reference_no+"#"+record.account_code);  
						    }); 
						} else {
						    //No rows selected
						    $('#SelectedRowList').append('&nbsp;<kbd>No row selected! Select rows to see here...</kbd>');
						    $("#txt_3").val('0'); 
						}
						*/
					},					
					//-.
					formCreated: function(event, data){
						return data.form.validationEngine();
					},
					//-.validate form when it is been submitted
					formSubmitting: function (event, data){
						return data.form.validationEngine('validate');
					},
					//-.dispose validation logic when form is closed.
					formClosed: function (event, data){
						data.form.validationEngine('hide');
						data.form.validationEngine('detach');
					},
					//-.reload main datatable upon creation of a new record.
					formAdded: function (event, data){
						$('#DataViewTable').jtable('reload');					
					}					
			});			
			//-.load person list from server.
			$('#DataViewTable').jtable('load',{'empty':'empty'});		
			//-.
			$('#LoadRecordsButton').click(function (e) {
				e.preventDefault();
				$('#DataViewTable').jtable('load', {
					search_name: $('#word').val()
				});
			});			
			//-.
			$('#LoadRecordsButton').click();
		});
		//-.method formats a number.
		function formatNumber(num){
			return  'KES.' + num.toFixed(2).replace(/(\d)(?=(\d{3})+(?!\d))/g, '$1,');
		}
	</script>	
  </head>
  <body>
	<div class="card">
		<div class="container">
			<div class="filtering" >
				<form>
				<span>&nbsp;</span><input type="text" name="word" id="word" style="" placeholder=" TYPE MSISDN TO SEARCH..."/>
				<button type="submit" id="LoadRecordsButton" class="btn2">&nbsp;&nbsp;</button>
				</form>
			</div>
    	</div>		
	</div>
	<div id="DataViewTable" style="width:100%;">
    </div>
	<div id="SelectedRowList" style="width: 100%;background-color:#FFBC49;"></div> 
	<input type="hidden" id="txt_3" value="0"/>
  </body>
</html>