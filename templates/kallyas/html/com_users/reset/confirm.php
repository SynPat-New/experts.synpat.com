<?php
/**
 * @package		Joomla.Site
 * @subpackage	com_users
 * @copyright	Copyright (C) 2005 - 2014 Open Source Matters, Inc. All rights reserved.
 * @license		GNU General Public License version 2 or later; see LICENSE.txt
 * @since		1.5
 */

defined('_JEXEC') or die;

JHtml::_('behavior.keepalive');
JHtml::_('behavior.formvalidation');
$u = (isset($_GET['u']))?$_GET['u']:'';
$verification = (isset($_GET['token']))?$_GET['token']:'';
?>
<?php 
	if($u!="" && $verification!=""):
?>
<div class="reset-confirm<?php echo $this->pageclass_sfx?>">
	<?php if ($this->params->get('show_page_heading')) : ?>
	<h1>
		<?php /*echo $this->escape($this->params->get('page_heading')); */?>
		Reset Password
	</h1>
	<?php endif; ?>

	<form action="<?php echo JRoute::_('index.php?option=com_users&task=reset.confirm'); ?>" method="post" class="form-validate" style="display:none">

		<?php foreach ($this->form->getFieldsets() as $fieldset): ?>
		<p><?php echo JText::_($fieldset->label); ?></p>		<fieldset>
			<dl>
			<?php foreach ($this->form->getFieldset($fieldset->name) as $name => $field): ?>
				<dt><?php echo $field->label; ?></dt>
				<dd><?php echo $field->input; ?></dd>
			<?php endforeach; ?>
			</dl>
		</fieldset>
		<?php endforeach; ?>

		<div>
			<button type="submit" class="validate"><?php echo JText::_('JSUBMIT'); ?></button>
			<?php echo JHtml::_('form.token'); ?>
		</div>
	</form>
</div>

<script>
	jQuery(document).ready(function(){
		jQuery("#jform_username").val('<?php echo $u;?>');
		jQuery("#jform_token").val('<?php echo $verification;?>');
		document.getElementsByClassName('form-validate')[0].submit();
	})
</script>
<?php else:?>
<script>
	jQuery(document).ready(function(){
		if(jQuery("#system-message-container").find('.notice').length==0){
			jQuery('.span12').append("<p style='margin-top:50px;'>Please check your inbox for the Username and a link to reset your password.</p>")
		}
	})
</script>

<?php endif;?>
