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
		
		if(eval(form.this_form) && form.this_form.value == "true"){
			//var isNew = getUrlVars()["author_type"];
			var r = new RegExp("[\<|\>|\"|\'|\%|\;|\(|\)|\&|\+|\-]", "i");
			var x = new RegExp("[\<|\>|\"]","i");
			var filter = /^([\w-]+(?:\.[\w-]+)*)@((?:[\w-]+\.)*\w[\w-]{0,66})\.([a-z]{2,6}(?:\.[a-z]{2})?)$/i
			if (form.survey_id.value == "") {
				alert("<?php echo JText::_("QUESTION_SURVEY_NAME"); ?>");
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
		}					
	}
		
	
	
	
</script>
<?php
	jimport( 'joomla.html.pane' );
	$surveyList = $this->surveyList;
	$user = $this->user;
	$tabs =& JPane::getInstance('tabs');

?>
<form action="index.php" method="post" name="adminForm" enctype="multipart/form-data">	
	<?php
		echo $tabs->startPane("EditUsers");
		echo $tabs->startPanel("General","authors-general-tab");
	?>
	<table class="adminform">
		<tr>
			<th colspan="2">
				<?php echo JText::_('QUESTION_DETAILS'); ?>
			</th>
		</tr>
		<tr>
			<td width="15%">
				<?php echo JText::_('SURVEY_NAME'); ?>:
				<span style="color:#FF0000">*</span>
			</td>
			<td>
				<select name="survey_id" id="survey_id">
					<option value="">Select Survey</option>
					<?php 
						foreach($surveyList as $value){
					?>
						<option value="<?php echo $value->id?>" <?php echo ($value->id==$user->survey_id)?'SELECTED="SELECTED"':"";?>><?php echo $value->name;?></option>
					<?php
						}
					?>
				</select>
				<span class="editlinktip hasTip" title="<?php echo JText::_("SURVEY_PROJECT_NAME")."::".JText::_("SURVEY_PROJECT_NAME_TIP"); ?>" >
					<img border="0" src="components/com_survey/images/icons/tooltip.png">
				</span>
			</td>
	  	</tr>
			</table>
			<?php
			echo $tabs->endPanel();

			echo $tabs->startPanel("Description","project-description-tab");
			
		?>
		<table class="adminform">
			<tr>
				<th colspan="2">
                    <?php echo JText::_('QUESTION_DESCRIPTION');?>
					</th>
				</tr>
				<tr>					
					<td width="100%">
                    <?php
					
					$editor1  = & JFactory::getEditor();
					echo $editor1->display( 'description',  $user->description ,  '100%;', '300px', '20', '60' ) ; ?>
					</td>
					<td valign="top">
						<span class="editlinktip hasTip" title="<?php echo JText::_("QUESTION_DESCRIPTION")."::".JText::_("QUESTION_TIP_DESCRIPTION"); ?>" >
							<img border="0" src="components/com_survey/images/icons/tooltip.png">
						</span>
					</td>
				</tr>		       
	</table>
		<?php
			echo $tabs->endPanel();
			
			
		?>
        	
        
		<?php			
			echo $tabs->endPanel();
			echo $tabs->endPane();

		?>	
		<input type="hidden" name="option" value="com_survey" />
		<input type="hidden" name="task" value="" />
		<input type="hidden" name="hidemainmenu" value="0" />
		<input type="hidden" name="controller" value="question" />
        <input type="hidden" name="id" value="<?php echo $user->id;?>" />
        <input type="hidden" name="this_form" value="true" />
</form>
