<?php

// no direct access
defined('_JEXEC') or die;
//JHtml::_('behavior.keepalive');
$ref = JRequest::getInt('ref',0);
$tapSet = 0;
if($ref == 0){
	if(isset($_GET['ref'])){
		$ref = 1;
		$tapSet = 1;
	}
} else if($ref>0){
	$tapSet = 1;
}
?>
<?php if (JFactory::getUser()->guest){ ?>
<link type='text/css' href='https://synpat.com/wp-content/themes/synpat/basic-2/css/basic.css' rel='stylesheet' media='screen' />
<script src="https://synpat.com/wp-content/themes/synpat/basic-2/js/jquery.simplemodal.js"></script>
<style>
	#simplemodal-container{width:355px !important;height:auto !important; top:80px !important}
	#basic-modal-content{height:auto !important;}
	.login-panel .remember-field{width:135px;}
	.login-panel .inputbox{width:165px;}
	.forgot-panel input[type=submit], .login-panel input[type=submit], .register-panel input[type=submit]{height:auto !important;}
	input:focus:invalid:focus, select:focus:invalid:focus, textarea:focus:invalid:focus{box-shadow:none !important;}
	.basic-modal-content {
		margin-top: 30px;
		padding: 0 10px 0 20px;
		overflow: auto !important;
		height: auto !important;
		width: 100% !important;
		background: rgb(71, 71, 71);
		/*display:none;*/
	}
	#register_panel, .register-panel,#forgot_panel{width:auto;padding-bottom:10px;}
	.forgot-panel, .login-panel, .register-panel{padding-top:0px}
	.auth-page .primary-button{min-width:auto !important;}
</style>

<div id="login_panel" class="simplemodal-data basic-modal-content">
	<?php if ($type == 'login') : 
				$start = JRequest::getVar('start');
				if(!empty($start)){
					$return = JRoute::_('index.php?option=com_survey&start='.$start.'&amp;task=customer.start_report', true, $params->get('usesecure'));
					$return = base64_encode($return);
				}
				$currentData = $_SERVER['QUERY_STRING'];
				parse_str($currentData, $ppC);
				$keysA = array_keys($ppC);
				if(count($keysA)==1 && !empty($keysA[0]) && trim($keysA[0])!='' && is_string($keysA[0])){
					$db = JFactory::getDBO();
					$sql = "SELECT p.* FROM #__projects as p INNER JOIN #__survey as s ON s.project_id =  p.id LEFT JOIN #__question as q ON q.survey_id = s.id  INNER JOIN #__transactions as t ON t.survey_id = p.id WHERE p.name = '" . trim($keysA[0]) . "' AND t.success ='Paid' AND t.type=1 GROUP BY p.id";
					$db->setQuery($sql);
					$dataProject  =  $db->loadObject();
					if(count($dataProject)>0){
						$return = JRoute::_('index.php?option=com_survey&tap='.$dataProject->name.'&amp;task=customer.show_list', true, $params->get('usesecure'));
						$return = base64_encode($return);
					}
				}
			?>
	<?php
		/*if($params->get('registration_enable',1)):
		$usersConfig = JComponentHelper::getParams('com_users');
		if ($usersConfig->get('allowUserRegistration')) : ?>
			<div class="inner-container login-panel" style='padding-top:30px;padding-bottom: 25px;'><a href="javascript://" class="primary-button" onClick="formOpen('#register_panel', '280');"><?php echo $params->get('modlog2'); ?></a>
			</div>
		<?php endif;
		endif;*/
		?>
	<div class="inner-container login-panel" style='padding-bottom:10px;'>		
		<h2 class="headingPOP mainMarginBottom20" >WELCOME TECH EXPERT</h2>
		<form action="<?php echo JRoute::_('index.php', true, $params->get('usesecure')); ?>" method="post" id="login_form" name="login_form" style='margin-bottom:3px;'>
			
			<input type="text" id="username" name="username" title=" " class="inputbox tertext " placeholder="Username" required="required">
			<input type="password" id="password" name="password" title=" " class="inputbox tertext " placeholder="<?php echo $params->get('modlog4'); ?>" required="required">
			<?php /*if (JPluginHelper::isEnabled('system', 'remember')) : ?>
			<div class="remember-field">
				<label id="remember-lbl" for="remember"><?php echo JText::_('JGLOBAL_REMEMBER_ME') ?></label>
				<input id="remember" type="checkbox" name="remember" class="inputbox" value="yes" />
			</div>
			<?php endif;*/ ?>
			<a href="javascript://" onClick="formOpen('#forgot_panel', '350');">Forgot Username/Password?</a>
			<span  class='auth-page'><button type="submit" id="lgnBtn" class='primary-button' name="Submit" style='float:right;margin:0px;'>Login</button></span>
			<input type="hidden" name="option" value="com_users" />
			<input type="hidden" name="task" value="user.login" />			
			<input type="hidden" name="return" value="<?php echo $return; ?>" />
			<?php echo JHtml::_('form.token'); ?>
		</form>
		<div class="mainColor ">
			Not registered? <a href="javascript://" onClick="formOpen('#register_panel', '350');"><strong>Join now</strong></a>
		</div>
		<?php /*if($params->get('forget_enable',1)): ?>
		<div class="links">
			<a href="#" onClick="formOpen('#forgot_panel', '350');"><?php echo $params->get('modlog7'); ?></a>
		</div>
		<?php endif; */?>
		
	</div>
	<?php endif; ?>
</div><!-- end login panel -->
<style>
.deactive{display:none;}
.active{display:block;}
</style>
<?php if($params->get('registration_enable',1)): ?>
<div id="register_panel" class="simplemodal-data basic-modal-content">
	<div class="inner-container register-panel">
		<h2 class="headingPOP mainMarginBottom20">CREATE YOUR ACCOUNT</h2>
		
		<form id="register_form" style='margin-bottom:0px;' onsubmit="return checkValidationForm();" name="register_form" method="post" action="<?php echo JRoute::_('index.php?option=com_users'); ?>">
			
			<div class='common' >
				<p>
					<input type="text" maxlength="50" id="jform_username" name="jform[username]" class="tertext inputbox required" placeholder="Username" />
				</p>
				<p>
					<input type="text" maxlength="50" onchange="changeName();" id="jform_first_name" name="jform[first_name]" class="tertext inputbox required" placeholder="First Name" />
				</p>
				<p>
					<input type="text" maxlength="50" onchange="changeName();" id="jform_last_name" name="jform[last_name]" class="tertext inputbox required" placeholder="Last Name" />
				</p>
				<p><input type="text" maxlength="50"  id="jform_company_name" onchange="changeName1();" name="jform[company_name]" class="tertext inputbox required" placeholder="Company Name (If applicable)" />
				</p>
			</div>
			
			
			<p>
				<input type="text" maxlength="100" id="jform_email1" name="jform[email1]" class="tertext inputbox required" placeholder="Your Email" />
			</p>
			<p>
				<input type="text" maxlength="100" id="jform_email2" name="jform[email2]" class="tertext inputbox required" placeholder="Verify Email" />
			</p>
			
			<p>
				<input type="text" id="jform_password1" onchange="changeName();" minlength="6"  name="jform[password1]" class="tertext inputbox required" placeholder="Desired Password (6 characters)"/>
			</p>
			
			<p style='margin-bottom:3px;'  class='auth-page'>
			<span class="mainColor">Have an account? <a href="javascript://" onClick="formOpen('#login_panel', '800');"><strong>Sign in</strong></a></span>
				<button type="submit" id="signup" class='primary-button' style='float:right;margin:0px;' name="submit">Sign up</button>
			</p>
			<input type="hidden" id="jform_password2" name="jform[password2]" class="inputbox required" placeholder="<?php echo $params->get('modlog13'); ?>" required="required"> 
			<input type='hidden'  value='1' name="jform[expert_type]" id="jform_expert_type"/>
			<input type="hidden" maxlength="50" id="jform_name" name="jform[name]" class="inputbox required" placeholder="<?php echo $params->get('modlog10'); ?>" required="required">
			<input type='hidden' value='<?php echo $ref;?>' name='jform[profile_type]' id='jform_profile_type'/>
			<input type='hidden' value='<?php echo $tapSet;?>' name='jform_post' id='jform_post'/>
			<input type="hidden" name="option" value="com_users" />
			<input type="hidden" name="task" value="registration.register" />
			<input type="hidden" name="return" value="<?php echo $return; ?>" />
			<?php echo JHtml::_('form.token');?>
		</form>
	</div>
</div><!-- end register panel -->
<script>
	function getThisBlock(v){		
		if(v==1){
			jQuery('.pp_hoverContainer,.pp_content').css('height','500px');
			jQuery('.individual').removeClass('deactive').addClass('active');
			jQuery('.company').removeClass('active').addClass('deactive');			
		} else if(v==2){
			jQuery('.pp_hoverContainer,.pp_content').css('height','450px');
			jQuery('.company').removeClass('deactive').addClass('active');
			jQuery('.individual').removeClass('active').addClass('deactive');			
		}
		jQuery('.common').removeClass('deactive').addClass('active');
	}
	
	function checkValidationForm(){
		var emailReg = /^(([^<>()\[\]\\.,;:\s@"]+(\.[^<>()\[\]\\.,;:\s@"]+)*)|(".+"))@((\[[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}])|(([a-zA-Z\-0-9]+\.)+[a-zA-Z]{2,}))$/;		
		if(jQuery('input[name="jform[expert_type]"]').val()== 0){
			alert('Please enter first name.');
			jQuery("input[name='jform[username]']").focus();
			return false;
		} else {
			/*if(jQuery('input[name="jform[expert_type]"]:checked').val()=='2'){				
				if(jQuery("input[name='jform[company_name]']").eq(1).val()==""){
					jQuery("input[name='jform[company_name]']").eq(1).focus();
					alert('Please enter company name.');
					return false;
				}
			}else if(jQuery('input[name="jform[expert_type]"]:checked').val()=='1'){
				if(jQuery("input[name='jform[first_name]']").eq(1).val()==""){
					jQuery("input[name='jform[first_name]']").eq(1).focus();
					alert('Please enter first name.');
					return false;
				}
				if(jQuery("input[name='jform[last_name]']").eq(1).val()==""){
					jQuery("input[name='jform[last_name]']").eq(1).focus();
					alert('Please enter last name.');
					return false;
				}
			}*/
		}
		if(jQuery("input[name='jform[username]']").val()==""){
			jQuery("input[name='jform[username]']").focus();
			alert('Please enter username.');
			return false;
		}
		if(jQuery("input[name='jform[email1]']").val()==""){
			jQuery("input[name='jform[email1]']").focus();
			alert('Please enter your email.');
			return false;
		} else if(!emailReg.test( jQuery("input[name='jform[email1]']").val())){
			alert('Please enter correct email.');
			console.log(jQuery("input[name='jform[email1]']").val());
			jQuery("input[name='jform[email1]']").focus();
			return false;
		}
		if(jQuery("input[name='jform[email2]']").val()==""){
			alert('Please enter verify email.');
			return false;
		}else if(!emailReg.test( jQuery("input[name='jform[email2]']").val())){
			console.log('not working');
			alert('Please enter correct verify email.');
			console.log(jQuery("input[name='jform[email2]']").val());
			jQuery("input[name='jform[email2]']").focus();
			return false;
		}
		if(jQuery("input[name='jform[email1]']").val()!="" && jQuery("input[name='jform[email2]']").val()!=""){
			if(jQuery("input[name='jform[email1]']").val()!=jQuery("input[name='jform[email2]']").val()){
				alert('Please enter your email and verfiy email not match.');
				return false;
			}			
		}
		if(jQuery("input[name='jform[password1]']").eq(1).val()==""){
			alert('Please enter desired password.');
			jQuery("input[name='jform[password1]']").eq(1).focus();
			return false;
		} else {
			if(jQuery("input[name='jform[password1]']").eq(1).val().length<6){
				alert('Please enter min six character for password.');
				jQuery("input[name='jform[password1]']").eq(1).focus();
				return false;
			}
		}
		return true;
	}
</script>
<?php endif; ?>

<?php if($params->get('forget_enable',1)): ?>
<div id="forgot_panel" class="simplemodal-data basic-modal-content">
	<div class="inner-container forgot-panel">
		<h2 class="headingPOP mainMarginBottom20">ENTER YOUR @ ADDRESS</h2>
		
		<form id="forgot_form" name="forgot_form" method="post" action="<?php echo JRoute::_('index.php?option=com_users&task=reset.request'); ?>">
			<p>
				<input type="text" id="jform_email" name="jform[email]" class="tertext mainFont" placeholder="<?php echo $params->get('modlog18'); ?>" required="required">
			</p>
			<p class='auth-page'>
				<button type="submit" id="recover" name="submit" class='primary-button' style='float:right;margin:0px;' value="">Submit</button>
				<?php echo JHtml::_('form.token'); ?>
			</p>
		</form>
		<div class="mainColor floatLeft" style='margin-top:10px;'>Have your password? <a href="javascript://" onClick="formOpen('#login_panel', '800');"><strong>Sign in</strong></a></div> 
	</div>
</div><!-- end reset pass panel -->
<?php endif; ?>
<script>
	function changeName(){
		jQuery("input[name='jform[name]']").eq(1).val(jQuery("#jform_first_name").val()+" "+ jQuery("#jform_last_name").val());
		/*jQuery("input#jform_expert_type").val(1);*/
		jQuery("#jform_password2").val(jQuery("#jform_password1").val());
	}
	function changeName1(){
		/*jQuery("input[name='jform[name]']").eq(1).val(jQuery("input[name='jform[company_name]']").eq(1).val());
		jQuery("input[name='jform[first_name]']").eq(1).val(jQuery("input[name='jform[company_name]']").eq(1).val());
		jQuery("input[name='jform[last_name]']").eq(1).val(jQuery("input[name='jform[company_name]']").eq(1).val());*/
		jQuery("input#jform_expert_type").val(2);
	}
	function formOpen(s){
		__modal.close();
		
		//changePopupPos();		
		if(jQuery(window).scrollTop()>0){
			jQuery('html').animate({scrollTop:0}, 500,function(){
				__modal = jQuery(s).modal();
			});
		} else {
			__modal = jQuery(s).modal();
		}
	}

	</script>
<?php } ?>
