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
JHTML::_('behavior.tooltip');
?>
<script language="javascript" type="text/javascript">		

	Joomla.submitbutton = function(pressbutton){
		var form = document.adminForm;
		if (pressbutton == 'cancel') {
			submitform( pressbutton );
			return;
		}
		/*
		if(eval(form.this_form) && form.this_form.value == "true"){
			//var isNew = getUrlVars()["author_type"];
			if (form.survey_id.value == "") {
				alert("");
			} 
			else if (form.description.value == "<p><br/></p>"){
				alert ("<?php echo JText::_("QUESTION_PROVIDE_DETAILS"); ?>");
			} 
			else {
				submitform( pressbutton );				
			}			
		}
		else{
			submitform( pressbutton );
		}*/		
		submitform( pressbutton );	
	}
</script>
<form action="index.php" method="post" name="adminForm" enctype="multipart/form-data">	
	<table class="adminform">
		<tr>
			<th colspan="2">
				<?php echo JText::_('New Discount Coupon'); ?>
			</th>
		</tr>
		<tr>
			<td width="15%">
				<?php echo JText::_('Name'); ?>:
				<span style="color:#FF0000">*</span>
			</td>
			<td>
				<input type="text" name="discount[name]" id="discountName">
			</td>
	  	</tr>
		<tr>
			<td width="15%">
				<?php echo JText::_('Coupon Code'); ?>:
				<span style="color:#FF0000">*</span>
			</td>
			<td>
				<input type="text" name="discount[coupon_code]" id="discountCouponCode">
			</td>
		</tr>
		<tr>
			<td width="15%">
				<?php echo JText::_('Discount %'); ?>:
				<span style="color:#FF0000">*</span>
			</td>
			<td>
				<input type="text" name="discount[discount]" id="discountDiscount">
			</td>
		</tr>
		<tr>
			<td width="15%">
				<?php echo JText::_('Start Date'); ?>:
				<span style="color:#FF0000">*</span>
			</td>
			<td>
				<?php echo JHTML::calendar(date('Y-m-d'),'discount[start_date]','discountStartDate','%Y-%m-%d');?>
			</td>
		</tr>
		<tr>
			<td width="15%">
				<?php echo JText::_('End Date'); ?>:
				<span style="color:#FF0000">*</span>
			</td>
			<td>
				<?php echo JHTML::calendar(date('Y-m-d'),'discount[end_date]','discountEndDate','%Y-%m-%d');?>
			</td>
		</tr>
			</table>
		
		<input type="hidden" name="option" value="com_survey" />
		<input type="hidden" name="task" value="" />
		<input type="hidden" name="controller" value="question" />
        <input type="hidden" name="this_form" value="true" />
</form>
