				<!-- START LOGIN  --->
	<?php		
			
$redirect_to=JRequest::getVar('re','');
if(empty($redirect_to)){
	$redirect_to=base64_encode('index.php?option=com_survey&task=project.projectList');	
} else {
	$redirect_to=base64_encode('index.php?option=com_survey&task=survey.surveyList&ps='.$redirect_to);	
}
/*
$doc = JFactory::getDocument();
$doc->addScript('components/com_survey/js/jquery-1.4.2.min.js');
$doc->addScript('components/com_survey/js/jquery.noconflict.js');
*/
?>
<div class="visible-desktop visible-tablet visible-phone">
<form id="loginForm" action="index.php" method="post" autocomplete="off">
	 <div class="row-fluid" style='margin-bottom:0px'>
		<div class="span6">
			<div class="control-group">
				<!-- <label class="control-label"></label> -->
				<div class="controls">
					<input type="text" name="login_username" placeholder="Enter Username" class="input-block-level" id="login_username"/>
					<span class="help-block">Please enter username.</span>
				</div>
			</div>
		</div>
		<div class="span6">
			<div class="control-group">
				<!-- <label class="control-label"></label> -->
				<div class="controls">
				<input type="password" placeholder="Enter Password" name="login_password" id="login_password" class="input-block-level"  />
				<span class="help-block">Please enter password.</span>
				</div>
			</div>
		</div>
	</div>
	<div class="row-fluid" style='margin-bottom:0px'>
		<div class="span12">
			<div class="control-group">
				<!-- <label class="control-label"></label> -->
				<div class="controls">
					
					<button type="submit" name="btn_login" class="btn btn-large btn-flat" >Login <span>&raquo;</span></button>
				</div>
			</div>
		</div>
	</div>

<input type="hidden" name="option" value="com_survey"/>
<input type="hidden" name="task" value="survey.logincheck"/>
<input type="hidden" name="redirect" value="<?php echo $redirect_to;?>"/>
</form>
<script>
	jQuery(document).ready(function(){
		jQuery("#loginForm").submit(function(){
			if(jQuery("#login_username").val()==""){
				alert("Please enter username.");
				jQuery("#login_username").focus();
				return false;
			} else if(jQuery("#login_password").val()==""){
				alert("Please enter password.");
				jQuery("#login_password").focus();
				return false;
			} else {
				return true;
			}			
		});
	});
</script>
			<!--- LOGIN  -->
			</div>
	
