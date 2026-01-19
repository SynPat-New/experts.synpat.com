<?php
/**
 * @package		Joomla.Site
 * @subpackage	com_users
 * @copyright	Copyright (C) 2005 - 2013 Open Source Matters, Inc. All rights reserved.
 * @license		GNU General Public License version 2 or later; see LICENSE.txt
 * @since		1.6
 */

defined('_JEXEC') or die;
SurveyControllerSurvey::getAuthenticateUser();
$firstname = "";
$lastname ="";
$emailaddress = "";
$profilePic = "";
$getUrl = "";
$linkedID = 0;   
if (isset($_GET['error'])) {
    // LinkedIn returned an error
    print $_GET['error'] . ': ' . $_GET['error_description'];
} elseif (isset($_GET['code'])) {
    // User authorized your application
    if ($_SESSION['state'] == $_GET['state']) {
        // Get token so you can make API calls
        SurveyControllerSurvey::getAccessToken();
        $user = SurveyControllerSurvey::fetch('GET', '/v1/people/~:(id,first-name,last-name,email-address,picture-url,public-profile-url)');
        $firstname = $user->firstName;
        $lastname = $user->lastName;
        $emailaddress = $user->emailAddress;
        $profilePic = $user->pictureUrl;
        $linkedin_profile_url = $user->publicProfileUrl;
		$linkedID  =  $user->id;
    }
} else {
	if ((empty($_SESSION['expires_at'])) || (time() > $_SESSION['expires_at'])) {
        // Token has expired, clear the state
        $_SESSION = array();
    }
    unset($_SESSION['access_token']);
    if (empty($_SESSION['access_token'])) {
        // Start authorization process
		$getUrl =  SurveyControllerSurvey::getAuthorizationCode();
    }
}
	
?>
<div class="row-fluid">
	<div class="span12">
		<div class="displayB solid-all dP-all-s xRound relative">
			<legend>Individual Assets:</legend>
			<form action="index.php" method="POST" onsubmit="return validateForm();">
				<div class="form-horizontal">
					<div class="control-group">
						<label class="control-label">Name:</label>
						<div class="controls">
							<?php 
								$name ="";
								if(!empty($firstname)){
									$name = $firstname." ".$lastname;
								}
							?>
							<input type="text" id="name" value="<?php echo $name;?>" name="name" placeholder="Enter Your Name">
						</div>
					</div>
					<div class="absolute" style="right:0px;">
					<?php
							if($profilePic!=""):
						?>
							<img src="<?php echo $profilePic;?>" width="80" height="80"/>
						<?php
							endif;
						?>
					</div>
				</div>
				<div class="form-horizontal">
					<div class="control-group">
						<label class="control-label">Email Address:</label>
						<div class="controls">
							<input type="text" id="email_address" value="<?php echo $emailaddress;?>" name="email_address" placeholder="Enter Email Address">
						</div>
					</div>
				</div>
				<div class="form-horizontal">
					<div class="control-group">
						<label class="control-label">Password:</label>
						<div class="controls">
							<input type="password" id="password" value="" name="password" placeholder="Enter Password">
						</div>
					</div>
				</div>
				<div class="form-horizontal">
					<div class="control-group">
						<label class="control-label">Confirm Password:</label>
						<div class="controls">
							<input type="password" id="password2" value="" name="password2" placeholder="Enter Confirm Password">
						</div>
					</div>
				</div>
				
				<div class="form-horizontal">
					<div class="control-group">
						<label class="control-label">Captcha:</label>
						<div class="controls">
							<?php 
								JPluginHelper::importPlugin('captcha');
								$dispatcher = JDispatcher::getInstance();
								$dispatcher->trigger('onInit','dynamic_recaptcha_1');
							?>
							<div id="dynamic_recaptcha_1"></div>
						</div>
					</div>
				</div>
				<div class="form-horizontal">
					<div class="control-group">
						<label class="control-label"></label>
						<div class="controls">
							<input type="submit" name="btn_submit" value="Register"/>
							<?php 
								
								if (empty($_SESSION['access_token'])) {
							?>
							  OR 
								<a href="<?php echo $getUrl;?>"><img src="<?php echo JUri::base();?>templates/survey/img/linked_in_signin.jpeg"/></a>
							<?php
								}
							?>
						</div>
					</div>
				</div>
				<?php echo JHtml::_('form.token'); ?>
				<input type="hidden" name="option" value="com_survey"/>
				<input type="hidden" name="linkedin_pic" value="<?php echo  $profilePic;?>"/>
				<input type="hidden" name="linkedin_id" value="<?php echo $linkedID;?>"/>
				<input type="hidden" name="linkedin_profile_url" value="<?php echo $linkedin_profile_url;?>"/>
				<input type="hidden" name="task" value="survey.registerExpert"/>
			</form>
		</div>
	</div>
</div>
<script>
	function validateForm(){
		if(jQuery("#name").val()==""){
			alert('Please enter name.');
			jQuery("#name").focus();
			return false;
		}
		if(jQuery("#email").val()==""){
			alert('Please enter email.'); 
			jQuery("#email").focus();
			return false;
		}
		if(jQuery("#password").val()==""){
			alert('Please enter password.');
			jQuery("#password").focus();
			return false;
		}
		if(jQuery("#password2").val()==""){
			alert('Please enter confirm password.');
			jQuery("#password2").focus();
			return false;
		} else if(jQuery("#password2").val()!=jQuery("#password").val()){
			alert('Confirm password not match.');
			jQuery("#password2").val('');
			jQuery("#password").focus();
			return false;
		}
		return true;
	}
</script>
