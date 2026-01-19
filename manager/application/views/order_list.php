<h2>
    <b>
        Order Lists
    </b>
</h2>
<?php
if($this->session->flashdata('email_msg'))
{
    echo $this->session->flashdata('email_msg');
    //$this->session->flashdata('email_msg')='';
}
?>
<script type="text/javascript" src="<?php echo $Layout->baseUrl;?>public/widgets/datatable/datatable.js"></script>
<script type="text/javascript" src="<?php echo $Layout->baseUrl;?>public/widgets/datatable/datatable-fixedheader.js"></script>

<script type="text/javascript">

    /* Datatables basic */

    $(document).ready(function() {
        $('#order-list').dataTable({
			fixedHeader: true,
			"scrollY": 500,
			paging:false ,
			searching:false 
		});
    });
</script>
<table cellpadding="0" cellspacing="0" border="0" class="table table-striped table-bordered" id="order-list">
    <thead>
		<tr>
			<th>#</th>
			<th>Ordered</th>
			<th>Deadline</th>
			<th>Lead</th>
			<th>Type</th>
			<th>Ready</th>
			<th>Price</th>
			<th>Process</th>
			<th>Submitted</th>
		</tr>
	</thead>
	<tbody>
    <?php
    $i=1;
    $obj = json_decode($get_data);
	if(count($obj)):
    foreach($obj as $k=>$v) {
		$leadName = "";
		if($v->leadID>0){
			if(count($v->lead_data)>0){
				$leadName = $v->lead_data->lead_name;
			}
		}
		if($leadName!=""){
			$orderName = $leadName." ( ".$v->projectName." )";
		} else {
			$orderName = $v->projectName;
		}
		
	?>
    <tr>
        <td valign='top'><?php echo $i; ?></td>
        <td valign='top'><?php echo date('M d, Y',strtotime($v->create_date));?></td>
        <td valign='top'><?php if($v->deadline!="0000-00-00 00:00:00") echo date('M d, Y',strtotime($v->deadline)); ?></td>
        <td valign='top'>
            <a href="<?php echo site_url(); ?>api/survey_list/<?php echo $v->projectID; ?>" style='color:#025A8D;text-decoration:underline'>
                <?php echo $orderName; ?>
            </a>
        </td>
		<td valign='top'><?php echo($v->projectType==2)?'CC':'PA';?></td>
        <td valign='top'>
			<?php if(isset($v->Questionares_prepared)){ echo $v->Questionares_prepared." / ".$v->claim_order;} else { echo $v->claim_order;}  ?>
		</td>
        <td valign='top'><?php echo $v->synpat_price; ?></td>
        <td valign='top'><?php echo $v->cc_in_process; ?></td>
        <td valign='top'><?php echo $v->cc_submitted; ?></td>
    </tr>
    <?php
		$i=$i+1;
    }
	endif;
    ?>
	</tbody>
</table>