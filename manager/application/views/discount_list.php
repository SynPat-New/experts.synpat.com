<h2>Discount Lists</h2>
<script type="text/javascript" src="<?php echo $Layout->baseUrl;?>public/widgets/datatable/datatable.js"></script>
<script type="text/javascript" src=".<?php echo $Layout->baseUrl;?>public/widgets/datatable/datatable-bootstrap.js"></script>
<script type="text/javascript" src="<?php echo $Layout->baseUrl;?>public/widgets/datatable/datatable-tabletools.js"></script>

<script type="text/javascript">

    /* Datatables basic */

    $(document).ready(function() {
        $('#discount-list').dataTable();
    });
</script>
<table cellpadding="0" cellspacing="0" border="0" class="table table-striped table-bordered" id="discount-list">
	<thead>
		<tr>
			<th>#</th>
			<th>Name</th>
			<th>Coupon Code</th>
			<th>Discount</th>
			<th>Start Date</th>
			<th>End Date</th>
		</tr>
	</thead>
	<tbody>
		<?php 
			$discounts = json_decode($get_data);
			if(count($discounts)>0){
				$i = 1;
				foreach($discounts as $discount){
		?>
				<tr>
					<td><?php echo $i;?></td>
					<td><?php echo $discount->name;?></td>
					<td><?php echo $discount->coupon_code;?></td>
					<td><?php echo $discount->discount;?></td>
					<td><?php echo $discount->start_date;?></td>
					<td><?php echo $discount->end_date;?></td>
				</tr>
		<?php
					$i++;
				}
			}
		?>
	</tbody>
</table>