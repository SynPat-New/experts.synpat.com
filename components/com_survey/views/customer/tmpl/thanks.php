<?php
// No direct access to this file 
defined('_JEXEC') or die('Restricted access');
$transID = $this->id;  
?>
<div class="row-fluid">
	<form action="index.php" method="post" name="customer-thanks" id='customer-thanks'>
	<div class="span12 white solid-all dP-all-m tM dM">
		<div class="row-fluid">
			<div class="span12">
				<h1 style="font-family:arial; line-height:28px;">Thank You<br /><br />
				<!--<span style="font:16px arial;">For Your purchasing </span>-->
				</h1>
			</div>
		</div>
		<div class="row-fluid">
			<div class="span12"> 
				<p class="arial">You may download the report.</p>
				<a href="javascript://" onclick="submitForm();" class=" btn btn-flat">Download pdf</a>
			</div>
		</div>
	</div>
	<input type="hidden" name="option" value="com_survey"/>
	<input type="hidden" name="task" value="customer.downloadSurvey"/>
	<input type="hidden" name="date_status" value="<?php echo $transID;?>"/>
	</form>
</div>
<script>
window.onload = function(e){
	submitForm();
}
/*
jQuery(document).ready(function(){
	submitForm();
})*/
function submitForm(){
document.forms['customer-thanks'].submit();	
}
</script>
