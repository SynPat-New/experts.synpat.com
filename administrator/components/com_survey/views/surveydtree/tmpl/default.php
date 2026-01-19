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

?>
	<link rel="StyleSheet" href="components/com_survey/css/dtree.css" type="text/css"/>
    <script type="text/javascript" src="components/com_survey/js/dtree.js"></script>
    
    <div class="dtree">
        <div class="dTreeNode">
                <a class="node" href="javascript: d.openAll();"><?php echo JText::_("SURVEY_OPENALL");?></a> | <a class="node" href="javascript: d.closeAll();"><?php echo JText::_("SURVEY_CLOSEALL")?></a><br /><br />
        </div>
    </div>
    <style>.icon-48-generic {padding-left:340px !important;}</style>
    <script type="text/javascript">
		d = new dTree('d');
		d.add(0,-1,'&nbsp;<?php  echo JText::_('Claim');?>','index.php?option=com_survey','','','','components/com_survey/images/lm/guru_icon.png','components/com_survey/images/lm/guru_icon.png');	
		d.add(860,0,'&nbsp;<?php echo JText::_('Orders');?>','','<?php echo JText::_('Orders');?>','','components/com_survey/images/lm/manual_tn.png','components/com_survey/images/lm/manual_tn.png');
		d.add(861,860,'&nbsp;<?php echo JText::_('Order List');?>','index.php?option=com_survey&task=order.list','<?php echo JText::_('Order List');?>','','components/com_survey/images/lm/manual_tn.png','components/com_survey/images/lm/manual_tn.png');
		d.add(870,0,'&nbsp;<?php echo JText::_('Discount');?>','','<?php echo JText::_('Orders');?>','','components/com_survey/images/lm/manual_tn.png','components/com_survey/images/lm/manual_tn.png');
		d.add(871,870,'&nbsp;<?php echo JText::_('Discount List');?>','index.php?option=com_survey&task=discount.list','<?php echo JText::_('Discount List');?>','','components/com_survey/images/lm/manual_tn.png','components/com_survey/images/lm/manual_tn.png');
		d.add(840,0,'&nbsp;<?php  echo JText::_('SURVEY_PROJECTS');?>','','','','components/com_survey/images/lm/gen_settings.png','components/com_survey/images/lm/gen_settings.png');
		d.add(841,840,'&nbsp;<?php  echo JText::_('SURVEY_PROJECTS_LIST');?>','index.php?option=com_survey&task=project.list&tab=0','General','','components/com_survey/images/lm/gen_settings.png','components/com_survey/images/lm/gen_settings.png');	
		d.add(810,0,'&nbsp;<?php echo JText::_('SURVEY_EXPERT');?>','','','','components/com_survey/images/lm/orders_th.png','components/com_survey/images/lm/orders_th.png');
		d.add(811,810,'&nbsp;<?php  echo JText::_('SURVEY_EXPERT_LIST');?>','index.php?option=com_survey&task=expert.list','<?php  echo JText::_('SURVEY_EXPERT_LIST');?>','','components/com_survey/images/lm/guru_icon.png','components/com_survey/images/lm/guru_icon.png');
		
		d.add(850,0,'&nbsp;<?php echo JText::_('Reports');?>','','','','components/com_survey/images/lm/guru_icon.png','components/com_survey/images/lm/guru_icon.png');
		d.add(821,850,'&nbsp;<?php  echo JText::_('Reports');?>','index.php?option=com_survey&task=report.list','<?php  echo JText::_('Reports');?>','','components/com_survey/images/lm/courses_th.png','components/com_survey/images/lm/courses_th.png','components/com_survey/images/lm/courses_th.png');
		d.add(890,0,'&nbsp;<?php  echo JText::_('Paypal Settings');?>','','','','components/com_survey/images/paypal-icon.jpg','components/com_survey/images/paypal-icon.jpg');
		d.add(891,890,'&nbsp;<?php  echo JText::_('Paypal Settings');?>','index.php?option=com_survey&task=paypal.setting','<?php  echo JText::_('Paypal Settings');?>','','components/com_survey/images/paypal-icon.jpg','components/com_survey/images/paypal-icon.jpg');
		document.write(d);

	</script>

<?php 
/*
 * d.add(870,0,'&nbsp;<?php  echo JText::_('SURVEY_SETTINGS');?>','','<?php  echo JText::_('SURVEY_SETTINGS');?>', '', 'components/com_survey/images/lm/gen_settings.png','components/com_survey/images/lm/gen_settings.png');
		d.add(871,870,'&nbsp;<?php  echo JText::_('SURVEY_PAYPAL_ID');?>', 'http://www.ijoomla.com/redirect/general/support.htm','<?php  echo JText::_('SURVEY_PAYPAL_ID');?>','http://www.ijoomla.com/redirect/general/support.htm','','components/com_survey/images/lm/payment_th.png','components/com_survey/images/lm/payment_th.png');
		d.add(872,870,'&nbsp;<?php  echo JText::_('SURVEY_ORDERS');?>','http://www.ijoomla.com/redirect/guru/manual.htm', '<?php  echo JText::_('SURVEY_ORDERS');?>', 'http://www.ijoomla.com/redirect/guru/manual.htm','','components/com_survey/images/lm/manual_tn.png','components/com_survey/images/lm/manual_tn.png');		
		
 * */
?>
