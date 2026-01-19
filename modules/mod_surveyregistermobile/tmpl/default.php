	<?php	
	if (!class_exists('SurveyControllerSurvey', false)) {
		require JPATH_BASE.DS.'components'.DS.'com_survey'.DS.'controllers'.DS.'survey.php';
	}	
SurveyControllerSurvey::getAuthenticateUser();
$firstname = "";
$lastname ="";
$emailaddress = "";
$profilePic = "";
$getUrl = "";
$linkedID = 0;   
$linkedin_profile_url ="";
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

		
		<!-- Start Mobile Form Version -->
		<div class="span5  hidden-desktop">
			<div class="displayB relative " >			
			<form action="index.php" method="post" id="registerForm1" autocomplete="off"  onsubmit="return validateForm1();">
				<div class="form-horizontal-1">
					<div class="control-group">
						<!-- <label class="control-label"></label> -->
						<div class="controls">
							<?php 
								$name ="";
								if(!empty($firstname)){
									$name = $firstname." ".$lastname;
								}
							?>
							<input type="text" autocomplete="false" id="first_name1" value="<?php echo $firstname;?>"  class="input-block-level" name="first_name1" placeholder="Enter Your First Name">
							<input type="hidden" id="name1" value="<?php echo $name;?>"   name="name1" />
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
				<div class="form-horizontal-1">
					<div class="control-group">
						<!-- <label class="control-label"></label> -->
						<div class="controls">
							<input type="text" autocomplete="false" id="last_name1" value="<?php echo $lastname;?>" class="input-block-level" name="last_name1" placeholder="Enter Your Last Name">
						</div>
					</div>
				</div>
				<div class="form-horizontal-1">
					<div class="control-group">
						<!-- <label class="control-label"></label> -->
						<div class="controls">
							<input type="text" autocomplete="false" id="username1" value="" class="input-block-level" name="username1" placeholder="Enter Username">
						</div>
					</div>
				</div>
				<div class="form-horizontal-1">
					<div class="control-group">
						<!-- <label class="control-label"></label> -->
						<div class="controls">
							<input type="text" autocomplete="false" id="email_address1" value="<?php echo  $emailaddress;?>" class="input-block-level" name="email_address1" placeholder="Enter Email Address">
						</div>
					</div>
				</div>
				<div class="form-horizontal-1">
					<div class="control-group">
						<!-- <label class="control-label"></label> -->
						<div class="controls">
							<input type="password" autocomplete="false" id="password1" value="" name="password1" class="input-block-level" placeholder="Enter Password">
						</div>
					</div>
				</div>
				<div class="form-horizontal-1">
					<div class="control-group">
						<!-- <label class="control-label"></label> -->
						<div class="controls">
							<input type="password" autocomplete="false" id="password21" value="" name="password21" class="input-block-level" placeholder="Confirm Password">
						</div>
					</div>
				</div>				
				<div class="form-horizontal-1">
					<div class="control-group">
						<div class="controls controls-row">
							  <div style="float:left; width:35%; background-color: #FFFFFF;">
								<!--<img id="capchaImage" src="<?php echo JUri::base()?>index.php?option=com_survey&format=&task=customer.getCaptcha1&rand=<?php echo rand();?>"/>-->
								<!--&nbsp; <a href='javascript:void(0);' onclick='refreshImage1("<?php echo JUri::base()?>index.php?option=com_survey&format=&task=customer.getCaptcha1");'><img src='<?php echo JUri::base();?>templates/survey/images/1367927304_arrow-circle-225-left.png'/></a>-->
								<div id="capchaImage1" style='width:90px;height:30px;float:left;'>
									<img  src="<?php echo JUri::base()?>index.php?option=com_survey&format=&task=customer.getCaptcha3&rand=<?php echo rand();?>"/>											
								</div>
							<!--&nbsp; <a href='javascript:void(0);' onclick='refreshImage("<?php echo JUri::base()?>index.php?option=com_survey&format=&task=customer.getCaptcha1");'><img src='<?php echo JUri::base();?>templates/survey/images/1367927304_arrow-circle-225-left.png'/></a>-->
								<a href="javascript://" class="pull-left" style='margin-top:6px;' onclick="refreshCaptchaImage1();">
									<img src="<?php echo JUri::base();?>templates/kallyas/images/reload-16.png"/>
								</a>
							  </div>
							  <div style="float:left; width:30%; margin-right:7px; margin-left:7px">
								  <input type="text" autocomplete="false" placeholder="Captcha" name="captcha_code_register1" id="captcha_code_register1" class="input-block-level noMargin" />
								  
								  
							  </div>
							  <div style="width:30%; float:right;">
								<!--  <button onclick="validateForm();" type="button" name="btn_submit" class="large button lg-l-r" style="border-top:0px;border-right:0px;border-left:0px;">Register <span>&raquo;</span></button>-->
								  <button  type="submit" name="btn_submit" class="large button lg-l-r" style="border-top:0px;border-right:0px;border-left:0px;">Register <span>&raquo;</span></button>
							 </div>
						</div>
					</div>
				</div>
				<div class="form-horizontal-1">
					<div class="control-group">
						<!-- <label class="control-label"></label> -->
						<div class="controls">
							
							<?php 
								
								if (empty($_SESSION['access_token'])) {
							?>
							 
								<a style="margin-left:0;" href="<?php echo $getUrl;?>"><img src="<?php echo JUri::base();?>templates/kallyas/img/linked_in_signin.png"/></a>
							<?php
								}
							?>
						</div>
					</div>
				</div>
				
				<input type="hidden" name="option" value="com_survey"/>				
				<input type="hidden" name="linkedin_pic1" value="<?php echo  $profilePic;?>"/>
				<input type="hidden" name="linkedin_id1" value="<?php echo $linkedID;?>"/>
				<input type="hidden" name="linkedin_profile_url1" value="<?php echo $linkedin_profile_url;?>"/>
				<input type="hidden" name="task" value="survey.registerExpert1"/>
			</form>
		</div>
		
	</div>


<script>
	__SiteURL = '<?php echo JUri::base();?>';	
	function refreshCaptchaImage1(){
		jQuery("#capchaImage1").empty().html('<img src="'+__SiteURL+'index.php?option=com_survey&format=&task=customer.getCaptcha1"/>');		
	}
	var emailReg = /^([\w-\.]+@([\w-]+\.)+[\w-]{2,4})?$/;

		function validateForm1(){
		_error = 0;
		if(jQuery("#first_name1").val()==""){
			alert('Please enter your first name.');
			jQuery("#first_name1").focus();
			_error = 1;
			return false;
		}
		if(jQuery("#last_name1").val()==""){
			alert('Please enter your last name.');
			jQuery("#last_name1").focus();
			_error = 1;
			return false;
		} else {
			jQuery("#name1").val(jQuery("#first_name1").val()+" "+jQuery("#last_name1").val());
		}
		if(jQuery("#username1").val()==""){
			alert('Please enter username.');
			jQuery("#username1").focus();
			_error = 1;
			return false;
		}
		if(jQuery("#email_address1").val()==""){
			alert('Please enter email.'); 
			jQuery("#email_address1").focus();
			_error = 1;
			return false;
		} else  if(!emailReg.test(jQuery("#email_address1").val())) {
			alert('Please enter correct email.'); 
			jQuery("#email_address1").focus();
			_error = 1;
			return false;
		}
		if(jQuery("#password1").val()==""){
			alert('Please enter password.');
			jQuery("#password1").focus();
			_error = 1;
			return false;
		}
		if(jQuery("#password21").val()==""){
			alert('Please enter confirm password.');
			jQuery("#password21").focus();
			_error = 1;
			return false;
		} else if(jQuery("#password21").val()!=jQuery("#password1").val()){
			alert('Confirm password not match.');
			jQuery("#password21").val('');
			jQuery("#password1").focus();
			_error = 1;
			return false;
		} else if(jQuery("#captcha_code_register1").val()==""){
			alert('Please enter captcha.');
			jQuery("#captcha_code_register1").focus();
			_error = 1;
			return false;
		}
		if(_error==0){
			jQuery.ajax({
				url:__SiteURL+'index.php?option=com_survey&format=&task=survey.checkCaptcha',
				type:'POST',
				data:{captcha_code:jQuery("#captcha_code_register1").val()},
				cache:false,
				success:function(data){
					if(data==0){
						document.forms['registerForm1'].submit();
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
