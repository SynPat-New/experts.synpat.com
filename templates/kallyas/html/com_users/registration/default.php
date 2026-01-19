<?php
/**
 * @package		Joomla.Site
 * @subpackage	com_users
 * @copyright	Copyright (C) 2005 - 2013 Open Source Matters, Inc. All rights reserved.
 * @license		GNU General Public License version 2 or later; see LICENSE.txt
 * @since		1.6
 */

defined('_JEXEC') or die;

JHtml::_('behavior.keepalive');
JHtml::_('behavior.tooltip');
JHtml::_('behavior.formvalidation');
?>
<style>
.form-horizontal .control-label{width:170px;}
.star{display:none;}
.tip-wrap {
display: none !important;
}
.btn-cancel{margin-left:75px}
@media only screen and (min-width:768px) and (max-width:979px){
	.form-horizontal .control-label{width:125px;}
	.form-horizontal .controls{margin-left:135px;}
	.uneditable-input, input, textarea{width:90px;}
	.btn-cancel{margin-left:0px !important;}
}
@media only screen and (min-width:980px) and (max-width:1199px){
	.form-horizontal .control-label{width:155px;}
	.form-horizontal .controls{margin-left:160px;}
	.uneditable-input, input, textarea{width:135px;}
	.btn-cancel{margin-left:0px !important;}
}
@media only screen and (min-width:1200px){
	.form-horizontal .control-label{width:160px;}
	.form-horizontal .controls{margin-left:170px;}
	.uneditable-input, input, textarea{width:190px;}
	.btn-cancel{margin-left:55px !important;}
}
</style>
<div class="registration<?php echo $this->pageclass_sfx?> row">
<?php if ($this->params->get('show_page_heading')) : ?>
	<h1 class="page-title"><?php echo $this->escape($this->params->get('page_heading')); ?></h1>
<?php endif; ?>

	<form id="member-registration" action="<?php echo JRoute::_('index.php?option=com_users&task=registration.register'); ?>" method="post" class="form-validate form-horizontal">
<?php foreach ($this->form->getFieldsets() as $fieldset): // Iterate through the form fieldsets and display each one.?>
	<?php $fields = $this->form->getFieldset($fieldset->name);?>
	<?php if (count($fields)):?>
		<fieldset>
		<?php if (isset($fieldset->label)):// If the fieldset has a label set, display it as the legend.
		?>
			<legend><?php echo JText::_($fieldset->label);?></legend>
		<?php endif;?>
			<div class="span4">
		<?php foreach($fields as $field):// Iterate through the fields in the set and display them.?>
			<?php if ($field->hidden):// If the field is hidden, just display the input.?>
				<?php echo $field->input;?>
			<?php else:?>
			
				<div class="control-group">
					<label class="control-label"><?php echo $field->label; ?>
					<?php /*if (!$field->required && $field->type!='Spacer'): ?>
						<span class="optional"><?php echo JText::_('COM_USERS_OPTIONAL'); ?></span>
					<?php endif;*/ ?></label>
					<div class="controls">
						<?php echo ($field->type!='Spacer') ? $field->input : "&#160;"; ?>
					</div>
				</div>
				
				
				
			<?php endif;?>
		<?php endforeach;?>
			<div class="control-group">
			<div class="controls">
				<button type="submit" class="btn btn-flat tM validate"><?php echo JText::_('JREGISTER');?></button>
				<?php /*echo ' '.JText::_('COM_USERS_OR').' ';*/?>
				<a href="<?php echo JRoute::_('');?>" title="<?php echo JText::_('JCANCEL');?>" class="btn btn-flat tM btn-cancel" style=''><?php echo JText::_('JCANCEL');?></a>
			</div>
			<input type="hidden" name="option" value="com_users" />
			<input type="hidden" name="task" value="registration.register" />
			<input type="hidden" name="return" value="<?php echo JRequest::getVar('return');?>" />
			<?php echo JHtml::_('form.token');?>
		</div>
			</div>
			<div class="span8">
				<iframe src="https://docs.google.com/document/d/1vFT5g_FEFHmf3rAFPNqhZ1BdxlnXAOEue0pNq7q_sJk/preview" id="agreement" style="width:100%;height:553px;"></iframe>
			</div>
		</fieldset>
	<?php endif;?>
<?php endforeach;?>
	</form>
</div>
<script>
	document.getElementById('agreement').style.height = (screen.availHeight - 200)+'px';
</script>