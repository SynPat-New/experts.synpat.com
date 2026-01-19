<?php

defined ('_JEXEC') or die ("Go away.");
JHTML::_('behavior.tooltip');
?>
<script language="javascript" type="text/javascript">		

	Joomla.submitbutton = function(pressbutton){
		var form = document.adminForm;
		if (pressbutton == 'cancelExpert') {
			submitform( pressbutton );
			return;
		}
		
		if(eval(form.this_form) && form.this_form.value == "true"){
			if (form.message.value == "") {
				alert("<?php echo JText::_("EXPERT_PROVIDE_NAME"); ?>");
			} 
			else {
				submitform( pressbutton );
				
			}			
		}
		else{
			submitform( pressbutton );
		}					
	}
	
</script>
<form action="index.php" method="post" name="adminForm" enctype="multipart/form-data">	
	
		<table class="adminform">
			<tr>					
				<td width="100%">
					<dl>Message</dl>
					<dd><textarea name="message" style="width:500px;height:300px;"></textarea></dd>
				</td>
			</tr>
       </table>
		<input type="hidden" name="option" value="com_survey" />
		<input type="hidden" name="task" value="" />
		<input type="hidden" name="hidemainmenu" value="0" />
		<input type="hidden" name="controller" value="expert" />
        <input type="hidden" name="expert_id" value="<?php echo $this->expert_id;?>" />        
</form>
