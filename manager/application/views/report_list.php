<h2>Report Lists</h2>
<div style="float: right;">
    <a href="<?php  echo site_url() ?>api/home">Cancel</a>
</div>
<script type="text/javascript" src="<?php echo $Layout->baseUrl;?>public/widgets/datatable/datatable.js"></script>
<script type="text/javascript" src="<?php echo $Layout->baseUrl;?>public/widgets/datatable/datatable-fixedheader.js"></script>
<script type="text/javascript">

    /* Datatables basic */

    $(document).ready(function() {
        $('#report-list').dataTable({
			fixedHeader: true,
			"scrollY": 500,
			paging:false ,
			searching:false 
		});
    });
	function updateReportPrice(p,o){
		_val = jQuery("#amount_specific_"+p).val();
		if(_val!="" && _val!="undefined"){
			o.css('display','none');
			jQuery.ajax({
				type:'POST',
				url:'<?php echo $Layout->baseUrl;?>api/update_report_price',
				data:{p:p,v:_val},
				dataType:'json',
				success:function(d){
					o.css('display','');
					if(d.id=="" || d.id=="0"){
						alert("Please try after sometime");
					}
				}
			})
		}
	}
	function showReport(o,p){
		var show= 0;
		if(o.is(':checked')){
			show = 1;
		}
		jQuery.ajax({
				type:'POST',
				url:'<?php echo $Layout->baseUrl;?>api/show_report_price',
				data:{p:p,s:show},
				dataType:'json',
				success:function(d){
					if(d.id=="" || d.id=="0"){
						alert("Please try after sometime");
					}
				}
			})
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
.tr-bold td, .tr-bold td a{font-weight:bold;}
</style>
<table cellpadding="0" cellspacing="0" border="0" class="table table-striped table-bordered" id="report-list">
	<thead>
    <tr>
        <th style='width:30px;'>#</th>
        <th>Project</th>
        <th>Claim</th>
        <th>Type</th>
        <th>Expert</th>
        <th>Target</th>
		<th>Product</th>
        <th style='width:150px;'>Ordered</th>
        <th style='width:150px;'>Created</th>
        <th>Answered</th>
        <th>Price</th>
		<th>Sold</th>
		<th style='width:90px;'>Post</th>
    </tr>
	</thead>
	<tbody>
    <?php
    $obj = json_decode($get_data);
    $i=1;
	if(count($obj)>0):
    foreach($obj as $k=>$v)
    {
        
   ?>
    <tr class="<?php echo ($v->notify==1)?'tr-bold':'';?>">
        <td>
			 <a href="<?php echo site_url(); ?>api/view_report/<?php echo $v->expertID; ?>/<?php echo $v->surveyID; ?>/<?php echo $v->target; ?>/<?php echo $v->target_product; ?>" style='color:#025A8D;text-decoration:underline' target='_blank'>
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
             <?php echo ($v->report_type==2)?'CC':'PA'; ?> 
        </td>
         <td>
             <a href="https://claimcharts.synpat.com/component/survey/?task=customer.expertProfile&display=<?php echo $v->expertID; ?>" style='color:#025A8D;text-decoration:underline' target="_blank">
                <?php echo $v->expertName; ?>
             </a>
        </td>
        <td>
             <?php echo $v->target; ?> 
        </td>
		<td>
             <?php echo $v->target_product; ?> 
        </td>
        <td style="width:150px;"><?php  echo $v->Ordered; ?></td>
        <td style="width:150px;"><?php echo $v->created; ?></td>
        <td>
             <?php echo $v->count_answer; ?> 
        </td>
        <td>
             <?php echo $v->price; ?> 
        </td>
         <td>
             <?php echo $v->sold; ?> 
        </td>
		<td>
			<?php if($v->report_option_type==2 && $v->specific_amount_id>0):?>
			<input type='text' name="amount_specific_<?php echo $v->specific_amount_id?>" id="amount_specific_<?php echo $v->specific_amount_id?>" value="<?php echo $v->specific_amount?>" style='width:80px;'/>
			<a href='javascript://' onclick="updateReportPrice(<?php echo $v->specific_amount_id?>,jQuery(this))" style='color:#025A8D;text-decoration:underline'>Update Price</a>
			<?php endif;?>
			<input type="checkbox" <?php echo ($v->show==1)?'CHECKED="CHECKED"':'';?> onchange="showReport(jQuery(this),<?php echo $v->specific_amount_id?>)"/>
		</td>
    </tr>
    <?php
    $i = $i+1;
     }endif;
    ?>
	</tbody>
</table>