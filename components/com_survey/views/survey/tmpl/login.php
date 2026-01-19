<?php
/**
 * @package		Joomla.Site
 * @subpackage	com_users
 * @copyright	Copyright (C) 2005 - 2013 Open Source Matters, Inc. All rights reserved.
 * @license		GNU General Public License version 2 or later; see LICENSE.txt
 * @since		1.6
 */

defined('_JEXEC') or die;
$redirect_to=JRequest::getVar('re','');
if(empty($redirect_to)){
	$redirect_to=base64_encode('index.php?option=com_survey&task=project.projectList');	
} else {
	$redirect_to=base64_encode('index.php?option=com_survey&task=survey.surveyList&ps='.$redirect_to);	
}
$doc = JFactory::getDocument();
/*$doc->addScript('components/com_survey/js/jquery-1.4.2.min.js');
$doc->addScript('components/com_survey/js/jquery.noconflict.js');*/
?>
<div class="container contCustom tMx dMx">	
	<div class="row-fluid">
		<div class="span12 solid-all dP-all-m xRound" style="background:#fff;">
			<legend>Expert Login</legend>
			<form id="loginForm" action="index.php" method="post" class="form-horizontal">
			<div class="control-group">
				<label class="control-label">Username</label>
				<div class="controls">
					<input type="text" id="username" name="username" class="inputbox" placeholder="PeXpert Username" required="required">
				</div>
			</div>
			
			<div class="control-group">
				<label class="control-label">Password</label>
				<div class="controls">
					<input type="password" id="password" name="password" class="inputbox" placeholder="Password" required="required">
				</div>
			</div>
			
			<div class="control-group">
				<label class="control-label"></label>
				<div class="controls">
					
					<input type="submit" name="btn_login" value="Login" class="btn" />
				</div>
			</div>
				<?php echo JHtml::_('form.token'); ?>
				<input type="hidden" name="option" value="com_users"/>
				<input type="hidden" name="task" value="user.login"/>
				<input type="hidden" name="redirect" value="<?php echo $redirect_to;?>"/>
			</form>
		</div>
	</div>
</div>
<script>
	jQuery(document).ready(function(){
		jQuery("#loginForm").submit(function(){
			if(jQuery("#username").val()==""){
				alert("Please enter email address.");
				jQuery("#username").focus();
				return false;
			} else if(jQuery("#password").val()==""){
				alert("Please enter password.");
				jQuery("#password").focus();
				return false;
			} else {
				return true;
			}			
		});
	});
</script>
