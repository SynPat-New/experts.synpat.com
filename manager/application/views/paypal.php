<?php
$obj = array();
if(!empty($get_data)){
	$obj = json_decode($get_data);
}
?>
<h2><b>Paypal Settings</b></h2>
<form action="<?php echo site_url() ?>api/paypal" method="post" name="adminForm" class="form-horizontal">
    <div class="row-fluid">
		<div class="form-group">
			<label class="col-lg-2">Paypal Email Id: </label>
			 <input type="text" name="email_id" id="email_id" class='form-control col-lg-10' required="required" value="<?php echo $obj->email_id?>"/>
		</div>
		<div class="form-group">
			<label class="col-lg-2">Mode: </label>
			<select name="mode" class='form-control col-lg-10'>
				<option value="1" <?php if($obj->mode=='1'):?> SELECTED="SELECTED"<?php endif;?>>Live Mode</option>
				<option value="0" <?php if($obj->mode=='0'):?> SELECTED="SELECTED"<?php endif;?>>Testing Mode</option>
			</select>
		</div>
		<div class="controls"> 
			<input type="submit" name="submit" value="submit"/>
			<a href="<?php echo site_url() ?>api/emailSendCancel">Cancel</a>
		</div>
    </div>
</form>
