<?php
/**
 * @package		Joomla.Site
 * @subpackage	com_users
 * @copyright	Copyright (C) 2005 - 2013 Open Source Matters, Inc. All rights reserved.
 * @license		GNU General Public License version 2 or later; see LICENSE.txt
 * @since		1.6
 */

defined('_JEXEC') or die;
$redirect_to=JRequest::getVar('re',base64_encode('index.php?option=com_survey&task=project.projectList'));
$doc = JFactory::getDocument();
$doc->addScript('components/com_survey/js/jquery-1.4.2.min.js');
$doc->addScript('components/com_survey/js/jquery.noconflict.js');
?>
<div>
	<h1>Expert Login</h1>
	<form id="loginForm" action="index.php" method="post">
	<p>
		<label>Email Address</label>
		<input type="text" name="email"  id="email"/>
	</p>
	<p>
		<label>Password</label>
		<input type="password" name="password" id="password"  />
	</p>
	<p>
		<?php echo JHtml::_('form.token'); ?>
		<input type="submit" name="btn_login" value="Login" /></p>
	
		<input type="hidden" name="option" value="com_survey"/>
		<input type="hidden" name="task" value="survey.logincheck"/>
		<input type="hidden" name="redirect" value="<?php echo $redirect_to;?>"/>
	</form>
</div>
<script>
	jQuery(document).ready(function(){
		jQuery("#loginForm").submit(function(){
			if(jQuery("#email").val()==""){
				alert("Please enter email address.");
				jQuery("#email").focus();
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
