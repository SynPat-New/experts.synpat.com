<?php
/**
 * @package		Joomla.Site
 * @subpackage	com_content
 * @copyright	Copyright (C) 2005 - 2013 Open Source Matters, Inc. All rights reserved.
 * @license		GNU General Public License version 2 or later; see LICENSE.txt
 */

// no direct access
defined('_JEXEC') or die;

JHtml::_('behavior.keepalive');
JHtml::_('behavior.tooltip');
JHtml::_('behavior.calendar');
JHtml::_('behavior.formvalidation');

// Create shortcut to parameters.
$params = $this->state->get('params');
//$images = json_decode($this->item->images);
//$urls = json_decode($this->item->urls);

// This checks if the editor config options have ever been saved. If they haven't they will fall back to the original settings.
$editoroptions = isset($params->show_publishing_options);
if (!$editoroptions):
	$params->show_urls_images_frontend = '0';
endif;

$getSession = JFactory::getUser();
$sessionEXpertID = 0;
if ($getSession->id==0) {			
	$app->redirect('index.php', 'Please Login First', 'Error');
}
$db = JFactory::getDBO();
$sql = "SELECT * FROM #__expert WHERE user_id='" . $getSession->id. "'";
$db->setQuery($sql);
$getSession = $db->loadObject();
?>

<script type="text/javascript">
	Joomla.submitbutton = function(task) {
		if (task == 'article.cancel' || document.formvalidator.isValid(document.id('adminForm'))) {
			<?php echo $this->form->getField('articletext')->save(); ?>
			Joomla.submitform(task);
		} else {
			alert('<?php echo $this->escape(JText::_('JGLOBAL_VALIDATION_FORM_FAILED'));?>');
		}
	}
	jQuery(document).ready(function(){
		jQuery("#editor-xtd-buttons").remove();
		jQuery(".toggle-editor").remove();
	});
</script>
<div class="edit item-page<?php echo $this->pageclass_sfx; ?>">
<?php if ($params->get('show_page_heading')) : ?>
<h1>
	<?php echo $this->escape($params->get('page_heading')); ?>
</h1>
<?php endif; ?>

<form action="<?php echo JRoute::_('index.php?option=com_content&a_id='.(int) $this->item->id); ?>" method="post" name="adminForm" id="adminForm" class="form-validate">
	<fieldset>
		<legend><?php echo JText::_('Add New Blog'); ?></legend>

			<div class="formelm">
			<?php echo $this->form->getLabel('title'); ?>
			<?php echo $this->form->getInput('title'); ?>
			</div>

		<?php if (is_null($this->item->id)):?>
			<div class="formelm">
			<?php echo $this->form->getLabel('alias'); ?>
			<?php echo $this->form->getInput('alias'); ?>
			</div>
		<?php endif; ?>

			

			<?php echo $this->form->getInput('articletext'); ?>

	</fieldset>
	<?php if ($params->get('show_urls_images_frontend')  ): ?>
	<fieldset>
		<legend><?php echo JText::_('COM_CONTENT_IMAGES_AND_URLS'); ?></legend>
			<div class="formelm">
			<?php echo $this->form->getLabel('image_intro', 'images'); ?>
			<?php echo $this->form->getInput('image_intro', 'images'); ?>
			</div>
			<div style="clear:both"></div>
			<div class="formelm">
			<?php echo $this->form->getLabel('image_intro_alt', 'images'); ?>
			<?php echo $this->form->getInput('image_intro_alt', 'images'); ?>
			</div>
			<div class="formelm">
			<?php echo $this->form->getLabel('image_intro_caption', 'images'); ?>
			<?php echo $this->form->getInput('image_intro_caption', 'images'); ?>
			</div>
			<div class="formelm">
			<?php echo $this->form->getLabel('float_intro', 'images'); ?>
			<?php echo $this->form->getInput('float_intro', 'images'); ?>
			</div>

			<div class="formelm">
			<?php echo $this->form->getLabel('image_fulltext', 'images'); ?>
			<?php echo $this->form->getInput('image_fulltext', 'images'); ?>
			</div>
			<div style="clear:both"></div>
			<div class="formelm">
			<?php echo $this->form->getLabel('image_fulltext_alt', 'images'); ?>
			<?php echo $this->form->getInput('image_fulltext_alt', 'images'); ?>
			</div>
			<div class="formelm">
			<?php echo $this->form->getLabel('image_fulltext_caption', 'images'); ?>
			<?php echo $this->form->getInput('image_fulltext_caption', 'images'); ?>
			</div>
			<div class="formelm">
			<?php echo $this->form->getLabel('float_fulltext', 'images'); ?>
			<?php echo $this->form->getInput('float_fulltext', 'images'); ?>
			</div>

			<div  class="formelm">
			<?php echo $this->form->getLabel('urla', 'urls'); ?>
			<?php echo $this->form->getInput('urla', 'urls'); ?>
			</div>
			<div  class="formelm">
			<?php echo $this->form->getLabel('urlatext', 'urls'); ?>
			<?php echo $this->form->getInput('urlatext', 'urls'); ?>
			</div>
			<?php echo $this->form->getInput('targeta', 'urls'); ?>
			<div  class="formelm">
			<?php echo $this->form->getLabel('urlb', 'urls'); ?>
			<?php echo $this->form->getInput('urlb', 'urls'); ?>
			</div>
			<div  class="formelm">
			<?php echo $this->form->getLabel('urlbtext', 'urls'); ?>
			<?php echo $this->form->getInput('urlbtext', 'urls'); ?>
			</div>
			<?php echo $this->form->getInput('targetb', 'urls'); ?>
			<div  class="formelm">
			<?php echo $this->form->getLabel('urlc', 'urls'); ?>
			<?php echo $this->form->getInput('urlc', 'urls'); ?>
			</div>
			<div  class="formelm">
			<?php echo $this->form->getLabel('urlctext', 'urls'); ?>
			<?php echo $this->form->getInput('urlctext', 'urls'); ?>
			</div>
			<?php echo $this->form->getInput('targetc', 'urls'); ?>
	</fieldset>
	<?php endif; ?>

	<fieldset>
		<legend><?php echo JText::_('COM_CONTENT_PUBLISHING'); ?></legend>
		<div class="formelm">
		<?php echo $this->form->getLabel('catid'); ?>
		<span class="category">
			<?php   echo $this->form->getInput('catid'); ?>
		</span>

		</div>
		<div class="formelm">
		<?php echo $this->form->getLabel('created_by_alias'); ?>
		<?php echo $this->form->getInput('created_by_alias'); ?>
		</div>

	<?php if ($this->item->params->get('access-change')): ?>
		<div class="formelm">
		<?php echo $this->form->getLabel('state'); ?>
		<?php echo $this->form->getInput('state'); ?>
		</div>

		<div class="formelm">
		<?php echo $this->form->getLabel('featured'); ?>
		<?php echo $this->form->getInput('featured'); ?>
		</div>

		<div class="formelm">
		<?php echo $this->form->getLabel('publish_up'); ?>
		<?php echo $this->form->getInput('publish_up'); ?>
		</div>
		<div class="formelm">
		<?php echo $this->form->getLabel('publish_down'); ?>
		<?php echo $this->form->getInput('publish_down'); ?>
		</div>

	<?php endif; ?>
		<!--<div class="formelm">
		<?php echo $this->form->getLabel('access'); ?>
		<?php echo $this->form->getInput('access'); ?>
		</div>
		<?php if (is_null($this->item->id)):?>
			<div class="form-note">
			<p><?php echo JText::_('COM_CONTENT_ORDERING'); ?></p>
			</div>
		<?php endif; ?>-->
	</fieldset>
	<!--
	<fieldset>
		<legend><?php echo JText::_('JFIELD_LANGUAGE_LABEL'); ?></legend>
		<div class="formelm-area">
		<?php echo $this->form->getLabel('language'); ?>
		<?php echo $this->form->getInput('language'); ?>
		</div>
	</fieldset>
	-->
	<fieldset>
		<legend><?php echo JText::_('COM_CONTENT_METADATA'); ?></legend>
		<div class="formelm-area">
		<?php echo $this->form->getLabel('metadesc'); ?>
		<?php echo $this->form->getInput('metadesc'); ?>
		</div>
		<div class="formelm-area">
		<?php echo $this->form->getLabel('metakey'); ?>
		<?php echo $this->form->getInput('metakey'); ?>
		</div>

		<input type="hidden" name="task" value="" />
		<input type="hidden" name="return" value="<?php echo base64_encode(JRoute::_('index.php?option=com_survey&task=customer.blog&display='.$getSession->id));?>" />
		<?php if($this->params->get('enable_category', 0) == 1) :?>
		<input type="hidden" name="jform[catid]" value="<?php echo $this->params->get('catid', 1);?>"/>
		<?php endif;?>
		<?php echo JHtml::_( 'form.token' ); ?>
	</fieldset>
	<fieldset>
		<div class="formelm-buttons">
			<button type="button" class="btn btn-flat" onclick="Joomla.submitbutton('article.save')">
				<?php echo JText::_('JSAVE') ?>
			</button>
			<button type="button" class="btn btn-flat" onclick="Joomla.submitbutton('article.cancel')">
				<?php echo JText::_('JCANCEL') ?>
			</button>
			<input type="hidden" name="jform[access]" value="1"/>
			<input type="hidden" name="jform[language]" value="*"/>
			<input type="hidden" name="jform[state]" value="1"/>
			<input type="hidden" name="jform[created_by_alias]" value=""/>
		</div>
	</fieldset>
</form>
</div>
