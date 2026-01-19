<?php
if (!class_exists('SurveyControllerSurvey', false)) {
    require JPATH_BASE . DS . 'components' . DS . 'com_survey' . DS . 'controllers' . DS . 'survey.php';
}
SurveyControllerSurvey::getAuthenticateUser();
$firstname = "";
$lastname = "";
$emailaddress = "";
$profilePic = "";
$getUrl = "";
$linkedID = 0;
$linkedin_profile_url = "";
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
        $linkedID = $user->id;
    }
} else {
    if ((empty($_SESSION['expires_at'])) || (time() > $_SESSION['expires_at'])) {
        // Token has expired, clear the state
        $_SESSION = array();
    }
    unset($_SESSION['access_token']);
    if (empty($_SESSION['access_token'])) {
        // Start authorization process
        $getUrl = SurveyControllerSurvey::getAuthorizationCode();
    }
}
?>

<div class="span12  visible-desktop visible-tablet visible-phone">
    <!-- Start Desktop Version Form -->
    <div class="displayB relative">			
        <form action="index.php" method="post" id="registerForm" autocomplete="off" onsubmit="return validateForm();">
            <div class="row-fluid" style='margin-bottom:0px'>
				<div class="span6">
					<div class="control-group">
						<!-- <label class="control-label"></label> -->
						<div class="controls">
							<?php
							$name = "";
							if (!empty($firstname)) {
								$name = $firstname . " " . $lastname;
							}
							?>
							<input type="text"  autocomplete="false" id="first_name" value="<?php echo $firstname; ?>"  class="input-block-level" name="first_name" placeholder="Enter Your First Name">
							<input type="hidden" id="name" value="<?php echo $name; ?>"   name="name" />
							<span class="help-block">Please enter your first name.</span>
						</div>
					</div>
					<div class="absolute" style="right:0px;">
						<?php
						if ($profilePic != ""):
							?>
							<img src="<?php echo $profilePic; ?>" width="80" height="80"/>
							<?php
						endif;
						?>
					</div>
				</div>
				<div class="span6">
					<div class="control-group">
						<!-- <label class="control-label"></label> -->
						<div class="controls">
							<input type="text" autocomplete="false" id="last_name" value="<?php echo $lastname; ?>" class="input-block-level" name="last_name" placeholder="Enter Your Last Name">
							<span class="help-block">Please enter your last name.</span>
						</div>
					</div>
				</div>
            </div>
            <div class="row-fluid" style='margin-bottom:0px'>
				<div class="span6">
					<div class="control-group">
						<!-- <label class="control-label"></label> -->
						<div class="controls">
							<input type="text" autocomplete="false" id="username" value="" class="input-block-level" name="username" placeholder="Enter Username">
							<span class="help-block">Please enter username.</span>
						</div>
					</div>
				</div>
				<div class="span6">
					<div class="control-group">
						<!-- <label class="control-label"></label> -->
						<div class="controls">
							<input type="text" autocomplete="false" id="email_address" value="<?php echo $emailaddress; ?>" class="input-block-level" name="email_address" placeholder="Enter Email Address">
							<span class="help-block">Please enter your email address.</span>
						</div>
					</div>
				</div>
            </div>
            <div class="row-fluid" style='margin-bottom:0px'>
				<div class="span6">
					<div class="control-group">
						<!-- <label class="control-label"></label> -->
						<div class="controls">
							<input type="password" autocomplete="false" id="password" value="" name="password" class="input-block-level" placeholder="Enter Password">
							<span class="help-block">Please enter password.</span>
						</div>
					</div>
				</div>
				<div class="span6">
					<div class="control-group">
						<!-- <label class="control-label"></label> -->
						<div class="controls">
							<input type="password" autocomplete="false" id="password2" value="" name="password2" class="input-block-level" placeholder="Confirm Password">
							<span class="help-block">Please re-enter password.</span>
						</div>
					</div>
				</div>	
            </div>	
            <div class="row-fluid" style='margin-bottom:0px'>		
				<div class="span12">
					<div class="control-group">
						<div class="controls controls-row">
							<!--                        <div style="width:auto; float:left; width:112px; background-color: #FFFFFF; ">
														<div id="capchaImage" style='width:90px;height:30px;float:left;'>
															<img  src="<?php echo JUri::base() ?>index.php?option=com_survey&format=&task=customer.getCaptcha1&rand=<?php echo rand(); ?>"/>											
														</div>
														&nbsp; <a href='javascript:void(0);' onclick='refreshImage("<?php echo JUri::base() ?>index.php?option=com_survey&format=&task=customer.getCaptcha1");'><img src='<?php echo JUri::base(); ?>templates/survey/images/1367927304_arrow-circle-225-left.png'/></a>
														<a href="javascript://" class="pull-left" style='margin-top:6px;' onclick="refreshCaptchaImage();">
															<img src="<?php echo JUri::base(); ?>templates/survey/images/reload-16.png"/>
														</a>
													</div>-->
							<!--                        <div style="float:left; width:120px; margin-right:7px; margin-left:7px"> 
														<input type="text" autocomplete="false" placeholder="Captcha" name="captcha_code_register" id="captcha_code_register" class="input-block-level noMargin" /></div>-->

							<div class="span12 pull-left">
								<?php
							if (empty($_SESSION['access_token'])) {
								?>

								<a class='pull-left' style="margin-left:0; margin-right:5px;" href="<?php echo $getUrl; ?>"><img src="<?php echo JUri::base(); ?>templates/kallyas/img/linked_in_signin.png"/></a>
									<?php
								}
								?>
								<button  type="submit" name="btn_submit" class="btn btn-large btn-flat"  >Register <span>&raquo;</span></button>
							</div>
						</div>
					</div>
				</div>
            </div>
<!--            <div class="form-horizontal-1">
                <div class="control-group">
                    <div class="controls">

                        <?php
                        if (empty($_SESSION['access_token'])) {
                            ?>

                            <a style="margin-left:0;" href="<?php echo $getUrl; ?>"><img src="<?php echo JUri::base(); ?>templates/survey/img/linked_in_signin.png"/></a>
                                <?php
                            }
                            ?>
                    </div>
                </div>
            </div>-->

            <input type="hidden" name="option" value="com_survey"/>				
            <input type="hidden" name="linkedin_pic" value="<?php echo $profilePic; ?>"/>
            <input type="hidden" name="linkedin_id" value="<?php echo $linkedID; ?>"/>
            <input type="hidden" name="linkedin_profile_url" value="<?php echo $linkedin_profile_url; ?>"/>
            <input type="hidden" name="task" value="survey.registerExpert"/>
        </form>
    </div>
</div>
<!-- End Desktop Form Version-->




<script>
__SiteURL = '<?php echo JUri::base();?>';
    function refreshCaptchaImage() {
        jQuery("#capchaImage").empty().html('<img src="' + __SiteURL + 'index.php?option=com_survey&format=&task=customer.getCaptcha1"/>');
    }
    function refreshCaptchaImage1() {
        jQuery("#capchaImage1").empty().html('<img src="' + __SiteURL + 'index.php?option=com_survey&format=&task=customer.getCaptcha1"/>');
    }
    var emailReg = /^([\w-\.]+@([\w-]+\.)+[\w-]{2,4})?$/;
    function validateForm() {
        _error = 0;

        if (jQuery("#first_name").val() == "") {
            alert('Please enter your first name.');
            jQuery("#first_name").focus();
            _error = 1;
            return false;
        }
        if (jQuery("#last_name").val() == "") {
            alert('Please enter your last name.');
            jQuery("#last_name").focus();
            _error = 1;
            return false;
        } else {
            jQuery("#name").val(jQuery("#first_name").val() + " " + jQuery("#last_name").val());
        }
        if (jQuery("#username").val() == "") {
            alert('Please enter username.');
            jQuery("#username").focus();
            _error = 1;
            return false;
        }
        if (jQuery("#email_address").val() == "") {
            alert('Please enter email.');
            jQuery("#email_address").focus();
            _error = 1;
            return false;
        } else if (!emailReg.test(jQuery("#email_address").val())) {
            alert('Please enter correct email.');
            jQuery("#email_address").focus();
            _error = 1;
            return false;
        }
        if (jQuery("#password").val() == "") {
            alert('Please enter password.');
            jQuery("#password").focus();
            _error = 1;
            return false;
        }
        if (jQuery("#password2").val() == "") {
            alert('Please enter confirm password.');
            jQuery("#password2").focus();
            _error = 1;
            return false;
        } else if (jQuery("#password2").val() != jQuery("#password").val()) {
            alert('Confirm password not match.');
            jQuery("#password2").val('');
            jQuery("#password").focus();
            _error = 1;
            return false;
        } else if (jQuery("#captcha_code_register").val() == "") {
            alert('Please enter captcha.');
            jQuery("#captcha_code_register").focus();
            _error = 1;
            return false;
        }
        if (_error == 0) {
            jQuery.ajax({
                url: __SiteURL + 'index.php?option=com_survey&format=&task=survey.checkCaptcha',
                type: 'POST',
                data: {captcha_code: jQuery("#captcha_code_register").val()},
                cache: false,
                success: function(data) {
                    if (data == 0) {
                        document.forms['registerForm'].submit();
                        //return true;
                    } else {
                        alert('Invalid captcha');
                        return false;
                    }
                }
            });
        }
        return false;
        //return true;		
    }


</script>
