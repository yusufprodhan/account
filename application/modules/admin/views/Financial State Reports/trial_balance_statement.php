<div class="row">
	<div class="col-md-12 col-sm-12 col-xs-12">
		<div class="x_panel">
			<div class="x_title">
				<h2><?php if(!empty($title)){echo $title;}else{echo '';}?></h2>
				<ul class="nav navbar-right panel_toolbox">
					<li><a class="collapse-link"><i class="fa fa-chevron-up"></i></a></li>
				</ul>
				<div class="clearfix"></div>
			</div>
			<div class="x_content">
				<div class="row">
					<div class="col-md-3 col-sm-12">
						<div class="form-group">
							<label for="start_date">Start Date</label>
							<br>
							<input type="text" id="start_date" name="start_date" class="form-control dateinput">
						</div>
					</div>
					<div class="col-md-3 col-sm-12">
						<div class="form-group">
							<label for="end_date">End Date</label>
							<br>
							<input type="text" id="end_date" name="end_date" class="form-control dateinput">
						</div>
					</div>
					<div class="col-md-2 col-sm-12">
						<div class="form-group">
							<button class="btn btn-success" id="search" name="search" type="submit" style="margin-top: 22px;">Search </button>
						</div>
					</div>
				</div>
				<div class="row">
					<div class="col-md-12">
						<style>
							table tfoot{display:table-row-group;}
						</style>
						<table class="table table-striped table-bordered dt-responsive nowrap datatable" cellspacing="0" width="100%">
							<thead>
								<tr>
									<th>SL</th>
									<th width="25%">Ledger name</th>
									<th>Group name</th>
									<th>O/P Balance</th>
									<th>Debit Balance</th>
									<th>Credit Balance</th>
									<th>C/L Balance</th>
								</tr>
							</thead>
							<tbody>

							</tbody>
							<tfoot>

							</tfoot>
						</table>
					</div>
				</div>
			</div>
		</div>
	</div>
</div>
<script>
	$(document).ready(function () {

		//for date
		$('.dateinput').datetimepicker({
			format: 'DD-MM-YYYY',
			//defaultDate:new Date(),
		});

		trialBalanceStatement();
	});

	//alert function
	function alert_massage(massage, type){
		var html = '<div class="alert '+ type +' alert-dismissible" role="alert">'+
			'                        <button type="button" class="close" data-dismiss="alert" aria-label="Close">'+
			'                            <span aria-hidden="true">&times;</span>'+
			'                        </button>'+ massage +
			'                    </div>';
		$(document).find('.head_alert').html(html);

		//for showing alert
		$('.alert-success').delay(2000).hide(1000).css({'color': '#fff'});
		$('.alert-danger').delay(2000).hide(1000).css({'color': '#fff'});
	}

	//for data
	$(document).on('click', '#search',  function () {
		$(document).find('.datatable tbody').html('');
		var start_date = $('input[name="start_date"]').val();
		var end_date = $('input[name="end_date"]').val();
		trialBalanceStatement(start_date, end_date);
	});

	function trialBalanceStatement(start_date =null, end_date = null) {
		$(document).find('.datatable tbody').html('');
		$.ajax({
			url: "<?php echo site_url('/admin/getTrialBalanceStatement'); ?>",
			type: 'post',
			data: { start_date: start_date,end_date:end_date},
			beforeSend: function(){
				$('.loadingImage').show();
			},
			success: function (data) {
				var res = JSON.parse(data);
				console.log(res);
				var total_op_balance= 0;
				var total_credit = 0;
				var total_debit = 0;
				var html = '';
				var sl = 1;
				var ac_type = '';
				$.each(res.trial_balance_statement,function (index, val) {
					total_op_balance += parseFloat(val.op_balance);
					total_credit += parseFloat(val.credit);
					total_debit += parseFloat(val.debit);
					if(parseFloat(val.credit) > parseFloat(val.debit)){
						 ac_type = 'C';
					}else{
						 ac_type = 'D';
					}
					html+= '<tr>' +
								'<td>'+sl+'</td>' +
								'<td>'+val.ledger_name+'</td>' +
								'<td>'+val.group_name+'</td>' +
								'<td>'+parseFloat(val.op_balance)+'</td>' +
								'<td>'+parseInt(val.debit)+'</td>' +
								'<td>'+parseInt(val.credit)+'</td>' +
								'<td>'+ Math.abs(val.credit - val.debit)+' '+ac_type+'</td>' +
							'</tr>';
					sl++;
				});
				if(total_credit > total_debit){
					ac_type = 'C';
				}else{
					ac_type = 'D';
				}
				var footer_html = '<tr>' +
									  '<td></td>' +
									  '<td></td>' +
									  '<td>Total</td>' +
									  '<td>'+total_op_balance+'</td>' +
									  '<td>'+total_debit+'</td>' +
									  '<td>'+total_credit+'</td>' +
									  '<td>'+Math.abs(total_credit-total_debit) +' '+ac_type+'</td>' +
								  '</tr>';

				$(document).find('.datatable tbody').html(html);
				$(document).find('.datatable tfoot').html(footer_html);



				$('.loadingImage').hide();
				$(document).find('.datatable').DataTable({
					dom: 'Bfrtip',
					"bRetrieve": true,
					"bDestroy": true,
					"bPaginate":true,
					"lengthMenu": [[-1], ["All"]],
					buttons: [
						{
							extend: 'csv',
							footer: true,
							filename: 'Truck Statement Report Memberwise'
						},
						{
							extend: 'print',
							footer: true,
							filename: 'Truck Statement Report Memberwise'
						},
						{
							extend: 'pageLength',
							footer: true
						}
					],
				});
			}
		});
	}
</script>
