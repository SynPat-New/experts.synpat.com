<h2>Transaction Lists</h2>
<script type="text/javascript" src="<?php echo $Layout->baseUrl;?>public/widgets/datatable/datatable.js"></script>
<script type="text/javascript" src="<?php echo $Layout->baseUrl;?>public/widgets/datepicker-ui/datepicker.js"></script>
<script type="text/javascript" src="<?php echo $Layout->baseUrl;?>public/widgets/datatable/datatable-fixedheader.js"></script>
<script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/moment.js/2.22.1/moment.min.js"></script>
<script type="text/javascript">

    /* Datatables basic */
	var dataTables;
	var typeList;
	function callDataTable(){
		dataTables = $('#transactionTable').DataTable({
			fixedHeader: true,
			"scrollY": 500,
			paging:false ,
			searching:false ,
			"oLanguage": {
				"sEmptyTable": "No record found!"
			}
		});
	}
    $(document).ready(function() {
        callDataTable();
		$(".datepicker").datepicker({
			dateFormat:'yy-mm-dd' 
		});
		$("#frmTransactions").on('submit',function(e){
			e.preventDefault();			
			if(jQuery("#start_date").val()!=""){
				jQuery("#btn-search").text('Please wait...');
				dataTables.destroy();
				jQuery("#transactionTable").find('tbody').empty();
				jQuery.ajax({
					url:'<?php echo $Layout->baseUrl;?>api/findTransactionList',
					type:'post',
					data:$("#frmTransactions").serializeArray(),
					dataType:'json'
				}).done(function(d){
					jQuery("#btn-search").text('Find');
					typeList = d;
					if(typeof(typeList.L_TIMESTAMP0)!='undefined'){
						trnsList = d;
						var allKeys = Object.keys(trnsList);
						totalNumber = 0;
						oldNumber = 0;
						tapFound = false;
						if(allKeys.length>0){
							allKeys.map(function(t){
								if(t.indexOf('L_TIMESTAMP')>=0){
									tapFound = true;
									_newNumber = t.replace('L_TIMESTAMP','');
									if(parseInt(_newNumber)>0){
										oldNumber = _newNumber;
									}
								}
							});
						}
						if(tapFound===true){
							_upto = oldNumber + 1;
							var tbody;
							for(i=0;i<_upto;i++){
								if(typeof(trnsList['L_TIMESTAMP'+i])!="undefined"){
									_transactionID = trnsList['L_TRANSACTIONID'+i];
									_name = trnsList['L_NAME'+i];
									_email = trnsList['L_EMAIL'+i];
									if(_email==undefined){
										_email = "";
									}
									_amt = trnsList['L_AMT'+i];
									console.log(_amt);
									_feesAmt = trnsList['L_FEEAMT'+i];
									_netAmt = trnsList['L_NETAMT'+i];
									_status = trnsList['L_STATUS'+i];
									_currencyCode = trnsList['L_CURRENCYCODE'+i];
									_type = trnsList['L_TYPE'+i];
									_timeZone = trnsList['L_TIMEZONE'+i];
									_timeStamp = decodeURIComponent(trnsList['L_TIMESTAMP'+i]);
									_timeStamp = moment(new Date(_timeStamp)).format('MMM DD, YYYY');
									tbody +="<tr><td>"+_transactionID+"</td><td>"+decodeURIComponent(_name)+"</td><td>"+decodeURIComponent(_email)+"</td><td>"+parseInt(decodeURIComponent(_amt))+"</td><td>"+decodeURIComponent(_feesAmt)+"</td><td>"+decodeURIComponent(_netAmt)+"</td><td>"+decodeURIComponent(_type)+"</td><td>"+decodeURIComponent(_status)+"</td><td>"+decodeURIComponent(_timeStamp)+"</td></tr>";
								}
							}
							jQuery("#transactionTable").find('tbody').append(tbody);
							callDataTable();
						}
					}
				}).always(function(){jQuery("#btn-search").text('Find');});
			} else {
				alert("Please select start date for searching..");
			}
			return false;
		});
    });
</script>
<style>
@media (min-width: 768px){
	.form-inline .form-control {
		display: inline-block;
		width: auto;
		vertical-align: middle;
	}
}
</style>
<div class="row">
	<div class="col-lg-12">
		<form action="" class="form-inline" method="post" id="frmTransactions" autocomplete="off">
			<div class="form-group">
				<label for="start_date">Start date:</label>
				<input type="text"  class="form-control datepicker" id="start_date" name="start_date"/>
			</div>
			<div class="form-group">
				<label for="end_date">End date:</label>
				<input type="text"  class="form-control datepicker" id="end_date" name="end_date"/>
			</div>
			<div class="form-group">
				<label for="end"></label>
				<button type="submit" id="btn-search" class="btn btn-default">Find</button>
			</div>
		</form>
	</div>
	<div class="col-lg-12" style='margin-top:30px;'>
		<table class="table" id="transactionTable">
			<thead>
				<tr>
					<th style="width:150px;">TransactionID</th>
					<th>Name</th>
					<th>Email</th>
					<th style="width:60px;">Amount</th>
					<th style="width:60px;">PayPal</th>
					<th style="width:60px;">Net</th>
					<th style="width:80px;">Type</th>
					<th style="width:80px;">Status</th>
					<th style="width:150px;">Timestamp</th>
				</tr>
			</thead>
			<tbody>			
			</tbody>
		</table>
	</div>
</div>
