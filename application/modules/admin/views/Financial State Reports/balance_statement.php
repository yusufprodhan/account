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
					<div class="col-md-12">
						<style>
							table tfoot{display:table-row-group;}
						</style>
						<table class="table table-striped table-bordered dt-responsive nowrap datatable" cellspacing="0" width="100%">
							<thead>
								<tr>
									<th>Account name</th>
									<th>Type</th>
									<th>O/P Balance</th>
									<th>Debit Balance</th>
									<th>Credit Balance</th>
									<th>C/L Balance</th>
								</tr>
							</thead>
							<tbody>
								<?php
									if(!empty($balance_data)){
										$total_op_balance = 0;
										$total_debit = 0;
										$total_credit = 0;
										foreach ($balance_data as $balance){
											$total_op_balance += $balance['op_balance'];
											$total_debit += $balance['debit'];
											$total_credit  += $balance['credit'];
											?>
											<tr>
												<td><?php echo $balance['ledger_name'] ?></td>
												<td><?php echo 'Ledger' ?></td>
												<td><?php echo $balance['op_balance'] ?></td>
												<td><?php echo $balance['debit'] ?></td>
												<td><?php echo $balance['credit'] ?></td>
												<td><?php echo $balance['credit'] -  $balance['debit']?></td>
											</tr>
										<?php }
									}
								?>
							</tbody>
							<tfoot>
								<tr>
									<td></td>
									<td>Total</td>
									<td><?php echo $total_op_balance ?></td>
									<td><?php echo $total_debit ?></td>
									<td><?php echo $total_credit ?></td>
									<td><?php echo $total_debit + $total_credit ?></td>
								</tr>
							</tfoot>
						</table>
					</div>
				</div>
			</div>
		</div>
	</div>
</div>
