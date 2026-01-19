<?php
$obj = json_decode($get_data);
$i=1;
foreach($obj as $k=>$v)
{
      
?>
<h2><b>Email Template</b></h2>
<form action="<?php echo site_url() ?>api/emailSend" method="post" name="adminForm">
    <div class="row-fluid">
	<div class="span6">
		<label>Email Message: </label>
		<textarea name="email_message" id="email_message" style="width:80%; min-height: 200px;"></textarea>
	</div>
	<?php 
		if(count($obj)>0 && empty($v->specific_expert)):
	?>
    <br />
    <div class="span6">
    	<div class="controls">
        	<label>Search Expertise Code:</label>
            <input type="text" name="expertise_code" id="expertise_code"/><input type="button" name="find_expert" value="Find" onClick="findExpertWithCode();"/>
        </div>
        <div id="found_expert"></div>        
    </div>
	<?php 
		else:
			//$findExpert = $this->getModel()->findExpertFromUserName($surveyDetail->specific_expert);
			if(count($v->findExpert)>0):
			$mode = 2;
	?>
			<h5>Claim has Specific Expert</h5>
			<table>
				<tr>
					<td><input type="checkbox" checked="checked" name="selected_expert[]" id="selected_expert[<?php echo $findExpert->id;?>]" value="<?php echo $findExpert->id;?>"/></td>
					<td><?php echo $findExpert->name; ?></td>
					<td><?php echo $findExpert->email;?></td>
				</tr>
			</table>
	<?php
			endif;
		endif;
	?>
    </div>
    <input type="hidden" name="option" value="com_survey" />
	<input type="hidden" name="task" value="question.emailSend" />
	<input type="hidden" name="controller" value="question" />
    <input type="hidden" name="mode" id="mode" value="<?php if(isset($mode)) : echo $mode; else: echo '1'; endif; ?>" />
	<input type="hidden" name="survey_id" value="<?php echo $v->id;?>" />
    <!--a href="<?php echo site_url() ?>api/emailSend">Send</a> | <a href="">Cancel</a-->
    <div class="controls"> 
    <input type="submit" name="submit" value="submit"/>
    <a href="<?php echo site_url() ?>api/emailSendCancel">Cancel</a>
    </div>
</form>
<?php
}
?>
<script>
	function findExpertWithCode(){
	   var site_url = '<?php echo site_url(); ?>';
		if(jQuery("#expertise_code").val()==""){
			alert('Please enter expertise code.');	
		}	else {
			jQuery("#found_expert").html('Loading...');
			jQuery.ajax({
				url:site_url+'api/findExpertWithCode',
				type:'POST',
				data:{code:jQuery("#expertise_code").val(),mode:jQuery("#mode").val()},
				dataType:"json",
				cache:false,
				success: function(data){
					if(jQuery("#mode").val()=='1'){
						count = 0;
                      //  alert(data);
						if(data.count!=null && data.count>0){
							count = data.count;
						}
						jQuery("#found_expert").html("<b>"+count+'</b> expertise found. <a href="javascript://" onclick="findExpertWithCode();">Click here</a> to show the list.');
						jQuery("#mode").val(2);
					} else {
						jQuery("#mode").val(1);
						/*Implement table with list of Expertise Under this code.*/
						_htmlCode = '<table id="expertsTable" class="table table-condensed table-striped">'+
							'<thead>'+
							'<th>[ ]</th>'+
							'<th>Name</th>'+
							'<th>Email</th>'+
							'</thead>'+
							'<tbody>';							
							for(i=0;i<data['count'].length;i++){
							     
								_htmlCode +='<tr><td><input type="checkbox" name="selected_expert[]" id="selected_expert['+data['count'][i].expert_id+']" value="'+data['count'][i].expert_id+'"/></td>';
								_htmlCode +='<td>'+data['count'][i].name+'</td>';
								_htmlCode +='<td>'+data['count'][i].email+'</td>';
								_htmlCode +='</tr>';
							}									
						_htmlCode +='</tbody></table>';
						jQuery("#found_expert").html(_htmlCode);
					}
				}	
			});	
		}
	}	
</script>