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
<table class="adminform" style="background-color:#FFFFFF !important;margin-top:0px;">
	<tr>
		<td>
<div id="cpanel" style="width:500px; margin-left:20px;">
	<!--
	<div style="float:left;">
		<div class="icon">
        	<a href="<?php echo JRoute::_("index.php?option=com_survey&controller=guruConfigs");?>">
            	<img src="components/com_survey/images/icons/settings.png" alt="<?php  echo JText::_('SURVEY_PAYPAL_ID');?>" align="middle" name="" border="0" />
				<span><?php  echo JText::_('SURVEY_PAYPAL_ID');?></span>
			</a>
		</div>		
	</div>
-->
	<!--
	<div style="float:left;">
		<div class="icon">
			<a href="<?php echo JRoute::_("index.php?option=com_survey&task=survey.list");?>">
				<img src="components/com_survey/images/icons/courses.png" alt="<?php  echo JText::_('SURVEY_SURVEY_LIST');?>" align="middle" name="" border="0" />
				<span><?php  echo JText::_('SURVEY_SURVEY_LIST');?></span>
			</a>
		</div>
	</div>
	-->
	<div style="float:left;">
		<div class="icon">
			<a href="<?php echo JRoute::_("index.php?option=com_survey&task=order.list");?>">
				<img src="components/com_survey/images/icons/payment.png" alt="<?php  echo JText::_('Order List');?>" align="middle" name="" border="0" />
					<span><?php  echo JText::_('Orders');?></span>
			</a>
		</div>
	</div>
	<div style="float:left;">
		<div class="icon">
			<a href="<?php echo JRoute::_("index.php?option=com_survey&task=project.list");?>">
				<img src="components/com_survey/images/icons/teachers.png" alt="<?php echo JText::_('SURVEY_PROJECTS_LIST');?>" align="middle" name="" border="0" />
                    <span><?php  echo JText::_('Projects');?></span>
			</a>
		</div>
	</div>
	<div style="float:left;">
		<div class="icon">
			<a href="<?php echo JRoute::_("index.php?option=com_survey&task=report.list");?>">
				<img src="components/com_survey/images/icons/orders.png" alt="<?php  echo JText::_('Reports');?>" align="middle" name="" border="0" />
					<span><?php  echo JText::_('Reports');?></span>
			</a>
		</div>
	</div>
	
	<div style="float:left;">
		<div class="icon">
			<a href="<?php echo JRoute::_("index.php?option=com_survey&task=expert.list");?>">
				<img src="components/com_survey/images/icons/students.png" alt="<?php echo JText::_('SURVEY_EXPERT_LIST');?>" align="middle" name="" border="0" />
                <span><?php  echo JText::_('Experts');?></span>
			</a>
		</div>
	</div>
	<!--
	<div style="float:left;">
		<div class="icon">
			<a href="<?php echo JRoute::_("index.php?option=com_survey&task=project.list");?>">
				<img src="components/com_survey/images/icons/teachers.png" alt="<?php echo JText::_('SURVEY_PROJECTS_LIST');?>" align="middle" name="" border="0" />
                    <span><?php  echo JText::_('SURVEY_PROJECTS_LIST');?></span>
			</a>
		</div>
	</div>
	-->
	<!--
	<div style="float:left;">
		<div class="icon">
			<a href="<?php echo JRoute::_("index.php?option=com_survey&task=question.list");?>">
				<img src="components/com_survey/images/icons/orders.png" alt="<?php  echo JText::_('SURVEY_QUESTION_LIST');?>" align="middle" name="" border="0" />
					<span><?php  echo JText::_('SURVEY_QUESTION_LIST');?></span>
			</a>
		</div>
	</div>
	-->
	
	
	
</div>
		</td>
	</tr>
</table>
