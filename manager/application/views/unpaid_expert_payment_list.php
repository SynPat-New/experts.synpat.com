<h2>Unpaid Expert Report Payment Lists </h2>
<p class='alert alert-info' id='statusMessage'>
	
</p>
<script type="text/javascript" src="<?php echo $Layout->baseUrl;?>public/widgets/datatable/datatable.js"></script>
<script type="text/javascript" src=".<?php echo $Layout->baseUrl;?>public/widgets/datatable/datatable-bootstrap.js"></script>
<script type="text/javascript" src="<?php echo $Layout->baseUrl;?>public/widgets/datatable/datatable-tabletools.js"></script>

<script type="text/javascript">

    /* Datatables basic */

    $(document).ready(function() {
        $('#report-list').dataTable({
			pageLength:100,columnDefs: [ { orderable: false, targets: [0] } ],order: [[ 1, 'asc' ]]
		});
    });
	function payToUser(){
		if(jQuery('input[name="paid_to_expert[]"]').is(':checked')===false){
			alert("Please select checkbox.");
		} else {
			_userPaidList = [];
			jQuery('input[name="paid_to_expert[]"]:checked').each(function(){
				var expertData = {};
				if(jQuery(this).val()>0 && jQuery("#amount_specific_"+jQuery(this).val()).val()>0 && jQuery(this).data('expert')>0 && jQuery(this).data('survey')>0){
					expertData.report_id = jQuery(this).val();
					expertData.expert_id = jQuery(this).data('expert');
					expertData.survey_id = jQuery(this).data('survey');
					expertData.business_id = jQuery(this).data('business');
					expertData.amount = jQuery("#amount_specific_"+jQuery(this).val()).val();
					_userPaidList.push(expertData);
				}				
			});
			console.log(_userPaidList);
		}
		if(_userPaidList.length>0){
			jQuery("#statusMessage").html('Please wait....');
			jQuery.ajax({
				type:'POST',
				url:'<?php echo $Layout->baseUrl;?>api/mass_payment_initiate',
				data:{user_list:JSON.stringify(_userPaidList)},
				success:function(d){
					jQuery("#statusMessage").html(d);
					console.log(d);
				}
			})
		} else {
			alert('Please try after sometime.');
		}
	}
	function selectAll(o){
		if(o.is(':checked')){
			jQuery('input[name="paid_to_expert[]"]').prop('checked',true);
		} else {
			jQuery('input[name="paid_to_expert[]"]').prop('checked',false);
		}
	}
</script>
<style>
a.paginate_button{
	padding:5px;
	cursor:pointer;
}
a.paginate_button.current,a.paginate_button.current:hover{
	cursor:text;text-decoration:none;
}
</style>
<div class="row">
	<div class='col-lg-12'>
		<a href="<?php  echo site_url() ?>api/home" class='float-right btn '>Cancel</a>
		<button class='btn btn-primary float-right' onclick="payToUser();">Pay Now</button>		
	</div>
</div>

<table cellpadding="0" cellspacing="0" border="0" class="table table-striped table-bordered" id="report-list">
	<thead>
    <tr>
        <th>
            # <input type="checkbox" name="selectAll" onclick="selectAll(jQuery(this))"/>
        </th>
        <th>
            Project  
        </th>
        <th>
            Claim
        </th>
        <th>
            Expert  
        </th>
        <th>
            Target 
        </th>
				<th>
            Target Product
        </th>
        <th>
            Ordered 
        </th>
        <th>
            Sent to Expert  
        </th>
        <th>
            Created 
        </th>
        <th>
            Answered Elements  
        </th>
        <th>
            Price 
        </th>
				<th>Action</th>
    </tr>
	</thead>
	<tbody>
    <?php
    $obj = json_decode($get_data);
    $i=1;
    foreach($obj as $k=>$v)
    {
        
   ?>
    <tr>
        <td>
			 <a href="<?php echo site_url(); ?>api/view_report/<?php echo $v->expertID; ?>/<?php echo $v->surveyID; ?>/<?php echo $v->target; ?>/<?php echo $v->target_product; ?>" style='color:#025A8D;text-decoration:underline' target='_blank'>
				<?php if(!empty($v->business_id)){?>
				 	<input type="checkbox" name="paid_to_expert[]" value="<?php echo $v->specific_amount_id?>" data-expert="<?php echo $v->expertID; ?>" data-survey="<?php echo $v->surveyID; ?>" data-business="<?php echo $v->business_id;?>" />
				<?php  } ?>
         <?php echo $i; ?> 
			 </a>
        </td>
        <td>
             <?php echo $v->ProjectName; ?> 
        </td>
         <td>
             <?php echo $v->combineName; ?> 
        </td>
         <td>
             <a href="http://claimcharts.info/component/survey/?task=customer.expertProfile&display=<?php echo $v->expertID; ?>" style='color:#025A8D;text-decoration:underline'>
                <?php echo $v->expertName; ?>
             </a>
        </td>
        <td>
             <?php echo $v->target; ?> 
        </td>
				<td>
             <?php echo $v->target_product; ?> 
        </td>
        <td>
            <?php  echo $v->Ordered; ?>
        </td>
         <td>
              <?php echo $v->create_date; ?> 
        </td>
        <td>
            <?php echo $v->created; ?> 
        </td>
        <td>
             <?php echo $v->count_answer; ?> 
        </td>
        <td>
             <?php echo $v->expertSetAmount; ?> 
        </td>		
				<td>
				<?php if($v->payment_type==1 && $v->expertSetAmount>0):?>
				<input type='text' name="amount_specific_<?php echo $v->specific_amount_id?>" id="amount_specific_<?php echo $v->specific_amount_id?>" value="<?php echo $v->expertSetAmount?>" readonly="readonly"/>		
				<?php endif;?>
				</td>
    </tr>
    <?php
    $i = $i+1;
     }
    ?>
	</tbody>
</table>