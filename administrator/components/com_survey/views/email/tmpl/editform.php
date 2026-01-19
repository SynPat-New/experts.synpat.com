<?php

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
			} else if(!jQuery('input[name="area_expertise[]"]').is(':checked')){
				alert('Please check area of expertise.');
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
	$surveyID = $this->surveyID;
	$areaExpertise = $this->getExpertise;
	$questionList = $this->questionList;
	$tabs =& JPane::getInstance('tabs');
	$areaExpertiseSelect = SurveyModelQuestion::getAreaExpertiseForSurvey($surveyID);
	
?>
<form action="index.php" method="post" name="adminForm" enctype="multipart/form-data">	
	<?php
		echo $tabs->startPane("EditUsers");
		echo $tabs->startPanel("Enter Questions","authors-general-tab");
	?>
	<?php 
		foreach($surveyList as $value){
			if($value->id==$surveyID){
				
				JToolBarHelper::title(JText::_( $value->combine_name));
			}
	    }
	?>
	
	
		<table class="adminform" >
				<tr>
					<th colspan="2">
						<span style="float:right"><a href="javascript://" onclick="addMore();">Add more</a></span>
					</th>
				</tr>
				<tr>
					<td valign="top">
						<table id="question_list">
					<?php
						$oldQuestion = count($questionList);
						$newQuestions = 0;
						$oldQuestionID = "";
						$questionStart = count($questionList);
						if(count($questionList)>0){
							$d=1;
							for($i=0;$i<count($questionList);$i++){
								$oldQuestionID .=$questionList[$i]->id.",";
					?>
							<tr>
								<td width="100%">
									<label>Q No:-<?php echo $d++;?></label>
									<textarea style="width:400px;"  name="question_<?php echo $questionList[$i]->id?>" id="question_<?php echo $questionList[$i]->id;?>"><?php echo $questionList[$i]->description;?></textarea>
								</td>
							</tr>
					<?php
							}
							$oldQuestionID =  substr($oldQuestionID,0,-1);
						} else{
							$newQuestions = 1;
							$questionStart = 1;
					?>
					<tr>
					<td width="100%">
							<label>Q No:-1</label>
							<textarea style="width:400px;"  name="question_new_1" id="question_new_1"></textarea>
					</td>
					</tr>
					<?php	
						}
					?>
					</table></td>
					<td>
						<textarea style="width:500px;height:700px;"></textarea>
					
					</td>
					</tr>
						       
	</table>
	
		<?php
			echo $tabs->endPanel();
			echo $tabs->startPanel("Area Of Expertise","area-of-expertise");
			
		?>
			<table class="adminform" >
				<tr>
					<th>
						<input type="checkbox" name="checkAll" id="checkAll" onclick="checkAllExpert(jQuery(this));" />
						&nbsp;Check All
					</th>
				</tr>
				<?php 
					if(count($areaExpertise)>0){
						for($e=0;$e<count($areaExpertise);$e++){
							$checked = "";
							if(count($areaExpertiseSelect)>0){
								for($ea=0;$ea<count($areaExpertiseSelect);$ea++){
									if($areaExpertiseSelect[$ea]->area_id==$areaExpertise[$e]->id){
										$checked='CHECKED="CHECKED"';
									}
								}
							}
				?>
							<tr>
								<td>
									<input type="checkbox" <?php echo $checked;?> name="area_expertise[]" id="area_expertise_<?php echo $areaExpertise[$e]->id ?>" value="<?php echo $areaExpertise[$e]->id;?>"/>
									&nbsp;<?php echo $areaExpertise[$e]->name;?>
								</td>
							</tr>
				<?php
						}
					}
				?>
			</table>
		<?php			
			echo $tabs->endPanel();
			echo $tabs->endPane();
		?>	
		<input type="hidden" name="option" value="com_survey" />
		<input type="hidden" name="task" value="" />
		<input type="hidden" name="survey_id" value="<?php echo $surveyID ;?>" />
		<input type="hidden" name="hidemainmenu" value="0" />
		<input type="hidden" name="controller" value="question" />
		<input type="hidden" name="oldQuestion" value="<?php echo $oldQuestion;?>" />
		<input type="hidden" name="newQuestions" id="newQuestions" value="<?php echo $newQuestions;?>" />
		<input type="hidden" name="oldQuestionID" id="oldQuestionID" value="<?php echo $oldQuestionID;?>" />
		<input type="hidden" name="questionStart" id="questionStart" value="<?php echo $questionStart;?>" />
        <input type="hidden" name="this_form" value="true" />
</form>

<script>
function addMore(){
	_questionsVal = parseInt(jQuery("#newQuestions").val());
	_idQuestion = 0;
	_labelQuestion = 0;
	if(_questionsVal==0){
		_labelQuestion = parseInt(jQuery("#questionStart").val()) + 1;
		_idQuestion = 1;
	} else {
		_questionsVal++;
		_idQuestion = _questionsVal;
		_labelQuestion = parseInt(jQuery("#questionStart").val()) + parseInt(_questionsVal);
		
	}
	
	jQuery("#question_list").append("<tr><td><label>Q No:-"+_labelQuestion+"</label><textarea style='width:400px;' name='question_new_"+_idQuestion+"' id='question_new_"+_idQuestion+"' ></textarea></td></tr>")
	jQuery("#newQuestions").val(_idQuestion);
}

function checkAllExpert(e){
	if(e.is(':checked')){
		jQuery("input[name='area_expertise[]']").each(function(){
			jQuery(this).attr('checked','checked');
		});
	} else {
		jQuery("input[name='area_expertise[]']").each(function(){
			jQuery(this).removeAttr('checked');
		});
	}
}
</script>
