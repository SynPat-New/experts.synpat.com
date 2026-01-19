<h2>
    <?php
    $obj = json_decode($get_data);
    echo '<div class="col-lg-12"><b>'.$obj[0]->project_name.' (Claim List)</b> <input type="text" name="new_claim" id="new_claim" placeholder="Add Claim" class="form-control" style="width:200px;display:inline-block;"/><a class="btn btn-default" style="
    margin-left: 5px;position:relative;top:1px;" href="href://" onclick="addNewClaim();">Add</a></div>';
    ?>
</h2>
<script type="text/javascript" src="<?php echo $Layout->baseUrl;?>public/widgets/datatable/datatable.js"></script>
<script type="text/javascript" src="<?php echo $Layout->baseUrl;?>public/widgets/datatable/datatable-fixedheader.js"></script>

<script type="text/javascript">

    /* Datatables basic */

    $(document).ready(function() {
        $('#survey-list').dataTable({
			fixedHeader: true,
			"scrollY": 500,
			paging:false ,
			searching:false 
		});
    });
	function deleteMe(ID,o){
		res = confirm("Are you sure?");
		if(res){
			jQuery.ajax({
				type:'POST',
				url:'<?php echo $Layout->baseUrl;?>api/delete_claim',
				data:{id:ID}				
			}).done(function(d){
				if(d>0){
					o.parents('tr').remove();
				}
			});
		}		
	}
	function addNewClaim(){
		jQuery.ajax({
			type:'POST',
			url:'<?php echo $Layout->baseUrl;?>api/add_new_claims',
			data:{project_id:<?php echo $project_id?>,claim:jQuery("#new_claim").val()}				
		}).done(function(d){
			console.log(d);
			window.location = window.location.href;
		});
	}
	function updateClaim(projectID){
		jQuery.ajax({
			type:'POST',
			url:'<?php echo $Layout->baseUrl;?>api/update_project_claims',
			data:{project_id:projectID}				
		}).done(function(d){
			window.location = window.location.href;
		});
	}
</script>
<table cellpadding="0" cellspacing="0" border="0" class="table table-striped table-bordered" id="survey-list">
    <thead>
	<tr>
        <th style='width:20px;'>#</th>
        <th style='width:100px;'>Claim</th>
        <th style='width:50px;'>Type</th>
		<th style='width:40px;'>Code</th>
        <th>Target</th>
        <th>Avoided</th>
        <th style='width:130px;'>Ordered</th>
        <th style='width:130px;'>Deadline</th>
        <th style='width:130px;'>Created</th>
        <th style='width:80px;'>InProcess</th>
        <th style='width:80px;'>Submitted</th>
        <th style='width:40px;'>Sold</th>
    </tr>
	<thead>
	<tbody>
    <?php
    $obj = json_decode($get_data);
   $i=1;
    foreach($obj as $k=>$v)
    {
        
   ?>
    <tr>
        <td valign='top'><a href="javascript:;" onclick="deleteMe(<?php echo $v->id;?>,jQuery(this))"><i class='glyph-icon icon-trash'></i></a>
        </td>
        <td valign='top'>
             <a href="<?php echo site_url(); ?>api/question_list/<?php echo $v->id; ?>" style='color:#025A8D;text-decoration:underline'>
                <?php echo $v->combine_name; ?> 
             </a>
        </td>
		<td valign='top'>
             <?php echo ($v->report_type==2)?'CC':'PA'; ?> 
        </td>
		<td valign='top'>
             <?php echo $v->code; ?> 
        </td>
        <td valign='top'>
             <?php echo $v->target; ?> 
        </td>
        <td valign='top'>
             <?php echo $v->avoided; ?> 
        </td>
        <td valign='top'>
             <?php echo $v->create_date; ?> 
        </td>
        <td valign='top'>
            <?php  echo $v->deadline; ?>
        </td>        
        <td valign='top'>
            <?php echo $v->Questionare_Created; ?> 
        </td>        
         <td valign='top'>
             <?php echo $v->CC_InProcess; ?> 
        </td>
         <td valign='top'>
             <?php echo $v->CC_Submitted; ?> 
        </td>
        <td valign='top'>
             <?php echo $v->sold; ?> 
        </td>
    </tr>
    <?php
    $i = $i+1;
     }
    ?>
	</tbody>
</table>