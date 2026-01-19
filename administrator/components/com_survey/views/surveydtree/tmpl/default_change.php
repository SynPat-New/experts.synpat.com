<?php
/**
 * @copyright   (C) 2010 iJoomla, Inc. - All rights reserved.
 * @license  GNU General Public License, version 2 (http://www.gnu.org/licenses/gpl-2.0.html)
 * @author  iJoomla.com <webmaster@ijoomla.com>
 * @url   http://www.ijoomla.com/licensing/
 * the PHP code portions are distributed under the GPL license. If not otherwise stated, all images, manuals, cascading style sheets, and included JavaScript  *are NOT GPL, and are released under the IJOOMLA Proprietary Use License v1.0 
 * More info at http://www.ijoomla.com/licensing/
*/
defined ('_JEXEC') or die ("Go away.");
$data = JRequest::get('post');
 
if((isset($data['controller']) && (isset($data['task']))) && ((($data['controller'] == 'guruMedia') && ($data['task'] == 'savesbox')) || (($data['controller'] == 'guruTasks') && (($data['task'] == 'save2') || ($data['task'] == 'jumpbts_save'))))){
 
} 
else{
	$task = JRequest::getVar("task", "");
	if($task != "export_button" && $task != "savequestion" && $task != "savequestionedit" ){	
?>
	<link rel="StyleSheet" href="components/com_guru/css/dtree.css" type="text/css"/>
    <script type="text/javascript" src="components/com_guru/js/dtree.js"></script>
    
    <div class="dtree">
        <div class="dTreeNode">
                <a class="node" href="javascript: d.openAll();"><?php echo JText::_("GURU_OPENALL");?></a> | <a class="node" href="javascript: d.closeAll();"><?php echo JText::_("GURU_CLOSEALL")?></a><br /><br />
        </div>
    </div>
    <script type="text/javascript">
    	
		d = new dTree('d');
		
		d.add(0,-1,'&nbsp;<?php  echo JText::_('IdealEducate');?>','index.php?option=com_guru','','','','components/com_guru/images/lm/guru_icon.png','components/com_guru/images/lm/guru_icon.png');

		d.add(840,0,'&nbsp;<?php  echo JText::_('GURU_TREESETTINGS');?>','','','','components/com_guru/images/lm/gen_settings.png','components/com_guru/images/lm/gen_settings.png');
		d.add(841,840,'&nbsp;<?php  echo JText::_('GURU_GENERAL');?>','index.php?option=com_guru&controller=guruConfigs&tab=0','General','','components/com_guru/images/lm/gen_settings.png','components/com_guru/images/lm/gen_settings.png');
		d.add(842,840,'&nbsp;<?php  echo JText::_('GURU_MEDIA');?>','index.php?option=com_guru&controller=guruConfigs&tab=1','Files/Media','','components/com_guru/images/lm/gen_settings.png','components/com_guru/images/lm/gen_settings.png');
		d.add(843,840,'&nbsp;<?php  echo JText::_('GURU_LAYOUT');?>','index.php?option=com_guru&controller=guruConfigs&tab=2','Layout','','components/com_guru/images/lm/gen_settings.png','components/com_guru/images/lm/gen_settings.png');
		d.add(844,840,'&nbsp;<?php  echo JText::_('GURU_STYLE');?>','index.php?option=com_guru&controller=guruConfigs&tab=3','Style','','components/com_guru/images/lm/gen_settings.png','components/com_guru/images/lm/gen_settings.png');
		d.add(845,840,'&nbsp;<?php  echo JText::_('GURU_PROGRESS_BAR');?>','index.php?option=com_guru&controller=guruConfigs&tab=4','Progres Bar','','components/com_guru/images/lm/gen_settings.png','components/com_guru/images/lm/gen_settings.png');
		d.add(846,840,'&nbsp;<?php  echo JText::_('GURU_EMAIL');?>','index.php?option=com_guru&controller=guruConfigs&tab=5','Email','','components/com_guru/images/lm/gen_settings.png','components/com_guru/images/lm/gen_settings.png');
		d.add(847,840,'&nbsp;<?php  echo JText::_('GURU_PROMOTION_BOX');?>','index.php?option=com_guru&controller=guruConfigs&tab=6','Promotion Box','','components/com_guru/images/lm/gen_settings.png','components/com_guru/images/lm/gen_settings.png');
		d.add(848,840,'&nbsp;<?php  echo JText::_('GURU_PAYMENT_PLUGINS');?>','index.php?option=com_guru&controller=guruPlugins','<?php  echo JText::_('GURU_PAYMENT_PLUGINS');?>','','components/com_guru/images/lm/gen_settings.png','components/com_guru/images/lm/gen_settings.png');
		d.add(849,840,'&nbsp;<?php  echo JText::_('GURU_QUIZ_COUNTD');?>','index.php?option=com_guru&controller=guruQuizCountdown','<?php  echo JText::_('GURU_QUIZ_COUNTD');?>','','components/com_guru/images/lm/gen_settings.png','components/com_guru/images/lm/gen_settings.png');
		d.add(851,840,'&nbsp;<?php  echo JText::_('GURU_CERTIFICATE');?>','index.php?option=com_guru&controller=guruCertificate','<?php  echo JText::_('GURU_CERTIFICATE');?>','','components/com_guru/images/lm/gen_settings.png','components/com_guru/images/lm/gen_settings.png');	
		d.add(852,840,'&nbsp;<?php  echo JText::_('GURU_KUNENA_FORUM1');?>','index.php?option=com_guru&controller=guruKunenaForum','<?php  echo JText::_('GURU_KUNENA_FORUM1');?>','','components/com_guru/images/lm/gen_settings.png','components/com_guru/images/lm/gen_settings.png');	
																													
		d.add(810,0,'&nbsp;<?php echo JText::_('GURU_TREEMANAGERS');?>','','','','components/com_guru/images/lm/orders_th.png','components/com_guru/images/lm/orders_th.png');
		d.add(811,810,'&nbsp;<?php  echo JText::_('GURU_TREEAUTHOR');?>','index.php?option=com_guru&controller=guruAuthor&task=list','<?php  echo JText::_('GURU_TREEAUTHOR');?>','','components/com_guru/images/lm/guru_icon.png','components/com_guru/images/lm/guru_icon.png');
		d.add(812,810,'&nbsp;<?php  echo JText::_('GURU_TREECUSTOMERS');?>','index.php?option=com_guru&controller=guruCustomers','<?php  echo JText::_('GURU_TREECUSTOMERS');?>','','components/com_guru/images/lm/students_th.png','components/com_guru/images/lm/students_th.png');
		d.add(813,810,'&nbsp;<?php  echo JText::_('GURU_TREEORDERS');?>','index.php?option=com_guru&controller=guruOrders','<?php  echo JText::_('GURU_TREEORDERS');?>','','components/com_guru/images/lm/orders_th.png');
		d.add(814,810,'&nbsp;<?php  echo JText::_('GURU_TREEPROMOS');?>','index.php?option=com_guru&controller=guruPromos','<?php  echo JText::_('GURU_TREEPROMOS');?>','','components/com_guru/images/lm/payment_th.png','components/com_guru/images/lm/payment_th.png');
		d.add(816,810,'&nbsp;<?php  echo JText::_('GURU_TREELANGUAGES');?>','index.php?option=com_guru&controller=guruLanguages&task=edit','<?php  echo JText::_('GURU_TREELANGUAGES');?>','','components/com_guru/images/lm/language_th.png','components/com_guru/images/lm/language_th.png');
			
		d.add(850,0,'&nbsp;<?php echo JText::_('GURU_TREETRAINING');?>','','','','components/com_guru/images/lm/guru_icon.png','components/com_guru/images/lm/guru_icon.png');
		d.add(821,850,'&nbsp;<?php  echo JText::_('GURU_TREECOURSE');?>','index.php?option=com_guru&controller=guruPrograms','<?php  echo JText::_('GURU_TREECOURSE');?>','','components/com_guru/images/lm/courses_th.png','components/com_guru/images/lm/courses_th.png','components/com_guru/images/lm/courses_th.png');
		d.add(822,821,'&nbsp;<?php  echo JText::_('GURU_TREECOURSECAT');?>','index.php?option=com_guru&controller=guruPcategs','<?php  echo JText::_('GURU_TREECOURSECAT');?>','','components/com_guru/images/lm/courses_th.png');
		d.add(827,850,'&nbsp;<?php  echo JText::_('GURU_TREEMEDIA');?>','index.php?option=com_guru&controller=guruMedia','<?php  echo JText::_('GURU_TREEMEDIA');?>','','components/com_guru/images/lm/media_th.png', 'components/com_guru/images/lm/media_th.png', 'components/com_guru/images/lm/media_th.png');
		d.add(828,827,'&nbsp;<?php  echo JText::_('GURU_TREEMEDIACAT');?>','index.php?option=com_guru&controller=guruMediacategs','<?php  echo JText::_('GURU_TREEMEDIACAT');?>','','components/com_guru/images/lm/media_th.png');
		d.add(829,850,'&nbsp;<?php  echo JText::_('GURU_TREEQUIZ');?>','index.php?option=com_guru&controller=guruQuiz','<?php  echo JText::_('GURU_TREEQUIZ');?>','','components/com_guru/images/lm/quizzes_th.png');
	/*
		d.add(860,0,'&nbsp;<?php echo JText::_('GURU_SUBSCRIPTIONS');?>','','<?php echo JText::_('GURU_SUBSCRIPTIONS');?>','','components/com_guru/images/lm/payment_th.png','components/com_guru/images/lm/payment_th.png');
		d.add(861,860,'&nbsp;<?php echo JText::_('GURU_SUBS_PLANS');?>','index.php?option=com_guru&controller=guruSubplan','<?php echo JText::_('GURU_SUBS_PLANS');?>','','components/com_guru/images/lm/payment_th.png','components/com_guru/images/lm/payment_th.png');
		d.add(862,860,'&nbsp;<?php echo JText::_('GURU_EMAIL_REMIND');?>','index.php?option=com_guru&controller=guruSubremind','<?php echo JText::_('GURU_EMAIL_REMIND');?>','','components/com_guru/images/lm/email_th.png','components/com_guru/images/lm/email_th.png');
		
		d.add(870,0,'&nbsp;<?php  echo JText::_('GURU_HELP');?>','','<?php  echo JText::_('GURU_HELP');?>', '', 'components/com_guru/images/lm/support_tn.png','components/com_guru/images/lm/support_tn.png');
		d.add(871,870,'&nbsp;<?php  echo JText::_('VIEWDSADMINSUPPORT');?>', 'http://www.ijoomla.com/redirect/general/support.htm','<?php  echo JText::_('VIEWDSADMINSUPPORT');?>','http://www.ijoomla.com/redirect/general/support.htm','','components/com_guru/images/lm/support_tn.png','components/com_guru/images/lm/support_tn.png');
		d.add(872,870,'&nbsp;<?php  echo JText::_('VIEWDSADMINMANUAL');?>','http://www.ijoomla.com/redirect/guru/manual.htm', '<?php  echo JText::_('VIEWDSADMINMANUAL');?>', 'http://www.ijoomla.com/redirect/guru/manual.htm','','components/com_guru/images/lm/manual_tn.png','components/com_guru/images/lm/manual_tn.png');
		d.add(873,870,'&nbsp;<?php  echo JText::_('VIEWDSADMINFORUM');?>', 'http://www.ijoomla.com/redirect/guru/forum.htm', '<?php  echo JText::_('VIEWDSADMINFORUM');?>', 'http://www.ijoomla.com/redirect/guru/forum.htm','','components/com_guru/images/lm/forum_tn.png','components/com_guru/images/lm/forum_tn.png');
		d.add(874,870,'&nbsp;<?php  echo JText::_('VIEWTREETEMPLATES');?>', 'http://www.ijoomla.com/redirect/general/templates.htm', '<?php  echo JText::_('VIEWTREETEMPLATES');?>', 'http://www.ijoomla.com/redirect/general/templates.htm','','components/com_guru/images/lm/templates_th.png','components/com_guru/images/lm/templates_th.png');
		d.add(875,870,'&nbsp;<?php  echo JText::_('VIEWDSADMINSITE');?>','http://www.ijoomla.com', '<?php  echo JText::_('VIEWDSADMINSITE');?>', 'http://www.ijoomla.com','','components/com_guru/images/lm/ijoomla_tn.png','components/com_guru/images/lm/ijoomla_tn.png');
		d.add(876,870,'&nbsp;<?php  echo JText::_('VIEWTREELV');?>','http://www.ijoomla.com/redirect/general/latestversion.htm', '<?php  echo JText::_('VIEWTREELV');?>', 'http://www.ijoomla.com/redirect/general/latestversion.htm','','components/com_guru/images/lm/ijoomla_tn.png','components/com_guru/images/lm/ijoomla_tn.png');
		d.add(877,870,'&nbsp;<?php  echo JText::_('GURU_TREEABOUT');?>','index.php?option=com_guru&controller=guruAbout','<?php  echo JText::_('GURU_TREEABOUT');?>','','components/com_guru/images/lm/about_th.png','components/com_guru/images/lm/about_th.png');
		d.add(878,870,'&nbsp;<?php  echo JText::_('GURU_RATE_US');?>', 'http://www.ijoomla.com/redirect/guru/rate.htm', '<?php  echo JText::_('GURU_RATE_US');?>', 'http://www.ijoomla.com/redirect/guru/rate.htm','','components/com_guru/images/lm/contact.png','components/com_guru/images/lm/contact.png');
		*/
		document.write(d);

	</script>
<?php 
	}
} ?>
