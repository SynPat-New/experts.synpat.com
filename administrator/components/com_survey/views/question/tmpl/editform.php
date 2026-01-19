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
			} else if(jQuery("#original_patent_content").val()!=""){
				_originalTextSearch = jQuery("#original_patent_content").val().toString();
				_originalTextSearch = _originalTextSearch.replace(/\n/g,'');
				_originalTextSearch = _originalTextSearch.replace(/ /g,'');
				_FLAG = 0;
				if(jQuery("#question_list tbody tr td textarea").length>0){
					_bigText = "";
					for(q=0;q<jQuery("#question_list tbody tr td textarea").length;q++){ 
						_searchText = jQuery("#question_list tbody tr td textarea").eq(q).val().toString();
						_searchText = _searchText.replace(/\n/g,'');
						_searchText = _searchText.replace(/ /g,'');
						if(_searchText!=''){							
							for(ts=0;ts<_searchText.length;ts++){
									_firstCharcterFromOriginalString = _originalTextSearch.substr(0,1);
								if(_searchText[ts]== _firstCharcterFromOriginalString){
									 _originalTextSearch = _originalTextSearch.substr(1);									 
								} else {
									_FLAG = 1;
									(function(){
										_searchText = jQuery("#question_list tbody tr td textarea").eq(q).css('border','1px solid red').focus();
										
									})();
								}
								if(_FLAG===1){
									break;
								}
							}
							if(_FLAG === 0){
								jQuery("#question_list tbody tr td textarea").eq(q).css('border','1px solid #CCCCCC');
							}
						}
						if(_FLAG===1){
							break;
						}
					}
					if(_FLAG === 0){
						submitform( pressbutton );
					}							
				} else {
					submitform( pressbutton );
				}
			} /*else if(!jQuery('input[name="area_expertise[]"]').is(':checked')){
				alert('Please check area of expertise.');
			}*/ else {
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
	$surveyData = $this->surveyData;
	$surveyID = $this->surveyID;
	/*
	$areaExpertise = $this->getExpertise;
	*/
	$questionList = $this->questionList;
	$tabs =& JPane::getInstance('tabs');
	$areaExpertiseSelect = SurveyModelQuestion::getAreaExpertiseForSurvey($surveyID);
	$checkClaimSend = SurveyModelQuestion::getClaimSendReport($surveyID);
?>
<style>
.up_arrow_class{
float:left;
background:url('<?php echo JUri::base();?>../components/com_survey/images/1367340184_arrow_sans_up.png') no-repeat;
width:32px;
height:32px;	
}
.down_arrow_class{
float:left;
background:url('<?php echo JUri::base();?>../components/com_survey/images/1367340233_arrow_sans_down.png') no-repeat;	
width:32px;
height:32px;
}

</style>
<form action="index.php" method="post" name="adminForm" enctype="multipart/form-data">	
	<?php
		echo $tabs->startPane("EditUsers");
		echo $tabs->startPanel("Enter Questions","authors-general-tab");
	?>
	<?php 
		JToolBarHelper::title(JText::_( $surveyData->combine_name));
		$name = $surveyData->name;
		if(strtoupper(strtolower(substr($surveyData->name,0,2)))!='US'){
			$name = 'US'.$name;
		}
	?>
		<table class="adminform" >
				<tr>
					<td colspan="0">
						
						See patent at  <a target="_blank" class="btn" href="http://www.google.com/patents/<?php echo $name;?>">Google Patents</a>
						<?php
							if(count($checkClaimSend)>0):
						?>
						&nbsp;&nbsp; To delete the entire page, Click <a class="btn" href="index.php?option=com_survey&task=question.deleteQuestionare&survey_id=<?php echo $surveyID;?>">Clear</a>
						<?php endif;?>
						<!--&nbsp;&nbsp; To undo last action, Click <a href=''>Undo</a>-->
					</td>
					<td></td>
					
				</tr>
				<tr>
					<td valign="top" width="48%" style="float:left;">
						<table id="question_list">
					<?php
						$bigText = "";
						$oldQuestion = count($questionList);
						$newQuestions = 0;
						$oldQuestionID = "";
						$questionStart = count($questionList);
						if(count($questionList)>0){
							$d=1;
							for($i=0;$i<count($questionList);$i++){
								$oldQuestionID .=$questionList[$i]->id.",";
								      $bigText .=$questionList[$i]->description." ";
					?>
							<tr id="<?php echo $questionList[$i]->id?>">
								<td width="100%">
									<label style="max-width:42px !important;min-width:42px !important;">No:<?php echo $d++;?></label>
									<textarea style="width:516px;"  name="question_<?php echo $questionList[$i]->id?>" id="question_<?php echo $questionList[$i]->id;?>"><?php echo $questionList[$i]->description;?></textarea>
									<input type="hidden" id="question_order_<?php echo $questionList[$i]->id?>" name="question_order_<?php echo $questionList[$i]->id?>" value="<?php echo $questionList[$i]->question_order;?>" />
									
									<a href="javascript:void(0)" onclick="upElement(jQuery(this));" class="up_arrow_class"></a>
									<a href="javascript:void(0)" onclick="downElement(jQuery(this));" class="down_arrow_class"></a>
									
								</td>
								
							</tr>
					<?php
							}
							$oldQuestionID =  substr($oldQuestionID,0,-1);
						} else{
							$newQuestions = 1;
							$questionStart = 0;
					?>
					<tr id="1">
					<td width="100%">
							<label style="min-width:42px !important;max-width:42px !important;">No:1</label>
							<textarea style="width:516px;"  name="question_new_1" id="question_new_1"></textarea>
							<input type="hidden" id="question_new_order_1" name="question_new_order_1" value="1" />
							
							<a href="javascript:void(0)" onclick="upElement(jQuery(this));" class="up_arrow_class"></a>
							<a href="javascript:void(0)" onclick="downElement(jQuery(this));" class="down_arrow_class"></a>
							
					</td>
					</tr>
					<?php	
						}
					?>
					
					</table>
						<table>
							<tr>
								<td><span style="float:left">Add a textbox for Another <a href="javascript://" class="btn" onclick="addMore();">Claim Element</a></span></td>
							</tr>
						</table>
					</td>
					<td valign="top" width="50%" style="float:left;">
						<p>Copy the claim from Google Patents and paste in the top right box. If the text was pasted satisfactorily, click outside the box to seal it.</p>
						<table width="50%">
							<tr>
								<td><textarea style="width:592px;height:250px;" onchange="checkData(jQuery(this));"></textarea></td>
							</tr>
							<tr>
								<td>
									<textarea id="original_patent_content" name="original_patent_content" style="width:592px;height:250px;" readonly="readonly"><?php echo $bigText;?></textarea>
								</td>
							</tr>
						</table>											
					</td>
					</tr>
					  
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
	__FIRST = 0;
	function upElement(object){
		_findParentIndex = object.parent().parent().index();
		
		if(_findParentIndex!=0){			
			_oldData = jQuery("#question_list tr").eq(_findParentIndex-1).html();
			_oldID = jQuery("#question_list tr").eq(_findParentIndex-1).attr('id');
			_oldFlag = 0;
			_newQuestionData = "";
			_oldQuestionData = "";			
			_oldOrderNo = jQuery("#question_order_"+_oldID).val();
			if(_oldID==""){
				_oldID = jQuery("#question_list tr").eq(_findParentIndex-1).attr('new_id');
				_oldQuestionData = jQuery("#question_new_"+_oldID).val();
				_oldOrderNo = jQuery("#question_new_order_"+_oldID).val();
				_oldFlag = 1;
			}			
			_newID = jQuery("#question_list tr").eq(_findParentIndex).attr('id');
			_newOrderNo = jQuery("#question_order_"+_newID).val();
			_newFlag = 0;
			if(_newID==""){
				_newID = jQuery("#question_list tr").eq(_findParentIndex).attr('new_id');
				_newQuestionData = jQuery("#question_new_"+_newID).val();
				_newOrderNo = jQuery("#question_new_order_"+_newID).val();
				_newFlag = 1;
			}					
			jQuery("#question_list tr").eq(_findParentIndex-1).html(object.parent().parent().html());
			if(_newFlag==0){
				jQuery("#question_list tr").eq(_findParentIndex-1).attr('id',_newID);				
				jQuery("#question_list tr").eq(_findParentIndex-1).attr('new_id','');
				jQuery("#question_order_"+_newID).val(_oldOrderNo);														
			} else {	
				jQuery("#question_list tr").eq(_findParentIndex-1).attr('new_id',_newID);				
				jQuery("#question_list tr").eq(_findParentIndex-1).attr('id','');	
				jQuery("#question_new_order_"+_newID).val(_oldOrderNo);	
				jQuery("#question_new_"+_newID).val(_newQuestionData);	
			}			
			jQuery("#question_list tr").eq(_findParentIndex).html(_oldData);
			if(_oldFlag==0){
				jQuery("#question_list tr").eq(_findParentIndex).attr('id',_oldID);
				jQuery("#question_list tr").eq(_findParentIndex).attr('new_id','');
				jQuery("#question_order_"+_oldID).val(_newOrderNo);				
			} else {
				jQuery("#question_list tr").eq(_findParentIndex).attr('new_id',_oldID);
				jQuery("#question_list tr").eq(_findParentIndex).attr('id','');
				jQuery("#question_new_order_"+_oldID).val(_newOrderNo);				
				jQuery("#question_new_"+_oldID).val(_oldQuestionData);				
			}
			
		}
	}
	function downElement(object){
		_totalLength = jQuery("#question_list tr").length;
		_findParentIndex = object.parent().parent().index();
		if(_findParentIndex<_totalLength-1){
			_oldData = jQuery("#question_list tr").eq(_findParentIndex+1).html();
			_oldID = jQuery("#question_list tr").eq(_findParentIndex+1).attr('id');
			_oldFlag = 0;
			_newQuestionData = "";
			_oldQuestionData = "";			
			_oldOrderNo = jQuery("#question_order_"+_oldID).val();
			if(_oldID==""){
				_oldID = jQuery("#question_list tr").eq(_findParentIndex+1).attr('new_id');
				_oldQuestionData = jQuery("#question_new_"+_oldID).val();
				_oldOrderNo = jQuery("#question_new_order_"+_oldID).val();
				_oldFlag = 1;
			}			
			_newID = jQuery("#question_list tr").eq(_findParentIndex).attr('id');
			_newOrderNo = jQuery("#question_order_"+_newID).val();
			_newFlag = 0;
			if(_newID==""){
				_newID = jQuery("#question_list tr").eq(_findParentIndex).attr('new_id');
				_newQuestionData = jQuery("#question_new_"+_newID).val();
				_newOrderNo = jQuery("#question_new_order_"+_newID).val();
				_newFlag = 1;
			}					
			jQuery("#question_list tr").eq(_findParentIndex+1).html(object.parent().parent().html());			
			if(_newFlag==0){
				jQuery("#question_list tr").eq(_findParentIndex).html('');
				jQuery("#question_list tr").eq(_findParentIndex+1).attr('id',_newID);				
				jQuery("#question_list tr").eq(_findParentIndex+1).attr('new_id','');
				jQuery("#question_order_"+_newID).val(_oldOrderNo);		
													
			} else {	
				jQuery("#question_list tr").eq(_findParentIndex).html('');
				jQuery("#question_list tr").eq(_findParentIndex+1).attr('new_id',_newID);				
				jQuery("#question_list tr").eq(_findParentIndex+1).attr('id','');	
				jQuery("#question_new_order_"+_newID).val(_oldOrderNo);	
				jQuery("#question_new_"+_newID).val(_newQuestionData);					
			}			
			jQuery("#question_list tr").eq(_findParentIndex).html(_oldData);
			
			if(_oldFlag==0){
				jQuery("#question_list tr").eq(_findParentIndex).attr('id',_oldID);
				jQuery("#question_list tr").eq(_findParentIndex).attr('new_id','');
				jQuery("#question_order_"+_oldID).val(_newOrderNo);				
			} else {
				jQuery("#question_list tr").eq(_findParentIndex).attr('new_id',_oldID);
				jQuery("#question_list tr").eq(_findParentIndex).attr('id','');
				jQuery("#question_new_order_"+_oldID).val(_newOrderNo);		
				jQuery("#question_new_"+_oldID).val(_oldQuestionData);				
			}
		}
	}
	function checkData(object){
		if(__FIRST==0 && object.val().length>0){
			jQuery("#original_patent_content").val(object.val());
			__FIRST = 1;
			
		}
	}
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
	_newOrder = jQuery("#question_list tr").length+1;
	jQuery("#question_list").append("<tr id='' new_id='"+_idQuestion+"'><td><label style='min-width:42px !important;max-width:42px !important;'>No:"+_labelQuestion+"</label><textarea style='width:516px;' name='question_new_"+_idQuestion+"' id='question_new_"+_idQuestion+"' ></textarea><input type='hidden' id='question_new_order_"+_idQuestion+"' name='question_new_order_"+_idQuestion+"' value='"+_newOrder+"' /><a href='javascript:void(0)' onclick='upElement(jQuery(this));' class='up_arrow_class'></a>&nbsp;<a href='javascript:void(0)' onclick='downElement(jQuery(this));' class='down_arrow_class'></a></td></tr>");
	jQuery("#question_new_"+_idQuestion).focus();
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
