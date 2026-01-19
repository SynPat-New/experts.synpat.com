<?php

defined ('_JEXEC') or die ("Go away.");

/*$app = JFactory::getApplication('administrator');
$limistart = $app->getUserStateFromRequest('com_guru', 'limitstart', 0);
$limit = $app->getUserStateFromRequest('com_guru'.'.list.limit', 'limit');	*/

$rows = $this->authorList;
$total = count($rows);
$pageNav = $this->pagination;

$doc = &JFactory::getDocument();
$doc->addScript('components/com_survey/js/jquery-1.4.2.min.js');	
$doc->addScript('components/com_survey/js/jquery.noconflict.js');
$doc->addScript('components/com_survey/js/jquery.DOMWindow.js');
$doc->addScript('components/com_survey/js/open_modal.js');
$surveyData = $this->surveyDetail(JRequest::getInt('survey_id'));
if(count($surveyData)>0){
	JToolBarHelper::title(JText::_($surveyData->combine_name));
}
?>
<script language="javascript" type="text/javascript">        
	jQuery(function() {
		var w = 745,
			h = 430; 	
		set_modal('.modal2', w, h);		
	});
</script>

<form action="index.php" method="post" name="adminForm">	
	<table class="adminlist adminlist1 table table-bordered table-striped">
    	<thead>
			<tr>
				<th width="1%">
					#
				</th>
				<!--
				<th width="2%">
					<input type="checkbox" name="toggle" value="" onClick="checkAll(<?php echo count($rows); ?>);" />
				</th>
				-->				
				<th width="50%">
					<?php echo JText::_("Element"); ?>
				</th>
				<!--				
				<th width="6%">
					<?php echo JText::_("QUESTION_ID"); ?>
				</th>		
				-->	
			</tr>
        </thead>
		<?php
		$k = 0;		
		$i = 0;
		$n = count($rows);
		if($n>0):
		foreach($rows as $key=>$row) {	
			
			$link 	= 'index.php?option=com_survey&task=question.edit&id='.$row['id'].'&hidemainmenu=1';
		?>
			<tr class="<?php echo "row$k"; ?>">
				<td>
					<?php echo $i+1+$pageNav->limitstart;?>
				</td>
					
				<td>
					<?php echo $row['description']; ?>
				</td>
				
				<!--         
				<td align="right">
					<?php echo $row['id']; ?>
				</td>
				-->
			</tr>
			<?php
			$k = 1 - $k;
			$i ++;
		}
		?>
		<!--
        	<tr>
            	<td colspan="14" align="center">
					<?php echo $this->pagination->getListFooter(); ?>
                </td>
            </tr>
            -->
		<?php else:?>
			<tr>
				<td colspan="6">No question added.</td>
			</tr>
		<?php endif;?>
		</table>
		<input type="hidden" name="option" value="com_survey" />
		<input type="hidden" name="task" value="question.list" />
		<input type="hidden" name="boxchecked" value="<?php echo ($n>0)?'1' :'0';?>" />
		<input type="hidden" name="cid[]" value="<?php if($n>0) { echo $rows[0]->id;}?>"/>
		<input type="hidden" name="hidemainmenu" value="0" />
		<input type="hidden" name="controller" value="question" />
		<input type="hidden" name="survey_id" value="<?php echo JRequest::getVar('survey_id','');?>" />
</form>
