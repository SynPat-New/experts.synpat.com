<?php
/**
 * @package		Joomla.Site
 * @subpackage	com_users
 * @copyright	Copyright (C) 2005 - 2013 Open Source Matters, Inc. All rights reserved.
 * @license		GNU General Public License version 2 or later; see LICENSE.txt
 * @since		1.5
 */

defined('_JEXEC') or die;
JHtml::_('behavior.keepalive');
?>
<style>
section#content{margin-top:10px;}
#system-message{margin-top:40px;margin-left:30px;}
#system-message>.message>ul, #system-message{margin-bottom:0px;}
section#content.hasMessages{margin-top:0px;}
.login-links li{margin-bottom:20px;}
label{text-align:left;}
.form-horizontal .control-label{width:105px;}
.form-horizontal .controls{margin-left:110px;}
#system-message > dd > ul > li{padding-left:30px;}
.page-title, .subtitle{margin-bottom:15px;padding-bottom:5px;line-height:40px;}
a.active{color:#cd2122;}
</style>
<div class="login<?php echo $this->pageclass_sfx?>">
	<?php //if ($this->params->get('show_page_heading')) : ?>
	<h1 class="page-title">
		<?php echo $this->escape($this->params->get('page_heading')); ?>
	</h1>
	<?php //endif; ?>

	<?php if (($this->params->get('logindescription_show') == 1 && str_replace(' ', '', $this->params->get('login_description')) != '') || $this->params->get('login_image') != '') : ?>
	<div class="login-description">
	<?php endif ; ?>

		<?php if($this->params->get('logindescription_show') == 1) : ?>
			<?php echo $this->params->get('login_description'); ?>
		<?php endif; ?>

		<?php if (($this->params->get('login_image')!='')) :?>
			<img src="<?php echo $this->escape($this->params->get('login_image')); ?>" class="login-image" alt="<?php echo JTEXT::_('COM_USER_LOGIN_IMAGE_ALT')?>"/>
		<?php endif; ?>

	<?php if (($this->params->get('logindescription_show') == 1 && str_replace(' ', '', $this->params->get('login_description')) != '') || $this->params->get('login_image') != '') : ?>
	</div>
	<?php endif ; ?>
	<div class='row'>
		<div class='span4'>
	<form action="<?php echo JRoute::_('index.php?option=com_users&task=user.login'); ?>" method="post" class="form-horizontal">

		<fieldset>

			<?php foreach ($this->form->getFieldset('credentials') as $field): ?>
				<?php if (!$field->hidden): ?>
					<div class="control-group">
						<label class="control-label"><?php echo $field->label; ?></label>
						<div class="controls">
							<?php echo $field->input; ?>
						</div>
					</div>
				<?php endif; ?>
			<?php endforeach; ?>
			
			<?php /*if (JPluginHelper::isEnabled('system', 'remember')) : ?>
			<div class="control-group">
				
				<div class="controls">
					<label id="remember-lbl" for="remember" class="control-label" style='margin-left:97px;'><?php echo JText::_('JGLOBAL_REMEMBER_ME') ?></label>
					<input id="remember" type="checkbox" name="remember" class="inputbox" value="yes"  alt="<?php echo JText::_('JGLOBAL_REMEMBER_ME') ?>" style='margin-left:5px;'/>
				</div>
			</div>
			<?php endif; */?>
			<div class="control-group">
				<div class="controls">
					<button type="submit" class="btn btn-flat"><?php echo JText::_('JLOGIN'); ?></button>
					<button type="button" class="btn btn-flat" onclick="https://synpat.com/experts" style='margin-left:90px;'><?php echo JText::_('Cancel'); ?></button>
				</div>
				<ul class="login-links" style='margin-top:20px;'>
						<li style='width:100%;'>
							Retrieve <a style='text-decoration:underline;' href="<?php echo JRoute::_('index.php?option=com_users&view=reset'); ?>">
							Username / Password</a>
						</li>
						<?php
						/*$usersConfig = JComponentHelper::getParams('com_users');
						if ($usersConfig->get('allowUserRegistration')) : ?>
						<li style='width:100%;margin-left:0px;padding:0px;'>
							<a href="<?php echo JRoute::_('index.php?option=com_users&view=registration'); ?>">
								<?php echo JText::_('COM_USERS_LOGIN_REGISTER'); ?></a>
						</li>
						<?php endif;*/ ?>
					</ul>
			</div>
			<input type="hidden" name="return" value="<?php echo base64_encode($this->params->get('login_redirect_url', $this->form->getValue('return'))); ?>" />
			<?php echo JHtml::_('form.token'); ?>
		</fieldset>
	</form>
	</div>
	</div>
</div>