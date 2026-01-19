<?php
    $get_data = json_decode($get_data);
	$surveyData = $get_data->surveyData;
  //  print_r($surveyData);
	$surveyID = $surveyData->id;//$_REQUEST['survey_id'];
//	$checkClaimSend = SurveyModelQuestion::getClaimSendReport($surveyID);
?>
<link rel="stylesheet" type="text/css" href="<?php echo $Layout->baseUrl; ?>/public/helpers/grid.css">
<style>
.up_arrow_class{
float:left;
width:32px;
height:32px;	
}

.up_arrow_class {
    background: url("https://claimcharts.synpat.com/components/com_survey/images/1367340184_arrow_sans_up.png") no-repeat scroll 0 0 rgba(0, 0, 0, 0);
    float: left;
    height: 32px;
    width: 32px;
}
.down_arrow_class {
    background: url("https://claimcharts.synpat.com/components/com_survey/images/1367340233_arrow_sans_down.png") no-repeat scroll 0 0 rgba(0, 0, 0, 0);
    float: left;
    height: 32px;
    width: 32px;
}
.down_arrow_class{
float:left;	
width:32px;
height:32px;
}
textarea{resize:none;}
</style>
<script>
(function(){var e;!function(t,l){return t.fn.autogrow=function(i){if(null==i&&(i={}),null==i.horizontal&&(i.horizontal=!0),null==i.vertical&&(i.vertical=!0),null==i.debugx&&(i.debugx=-1e4),null==i.debugy&&(i.debugy=-1e4),null==i.debugcolor&&(i.debugcolor="yellow"),null==i.flickering&&(i.flickering=!0),null==i.postGrowCallback&&(i.postGrowCallback=function(){}),null==i.verticalScrollbarWidth&&(i.verticalScrollbarWidth=e()),i.horizontal!==!1||i.vertical!==!1)return this.filter("textarea").each(function(){var e,n,r,o,a,c,d;if(e=t(this),!e.data("autogrow-enabled"))return e.data("autogrow-enabled"),a=e.height(),c=e.width(),o=1*e.css("lineHeight")||0,e.hasVerticalScrollBar=function(){return e[0].clientHeight<e[0].scrollHeight},n=t('<div class="autogrow-shadow"></div>').css({position:"absolute",display:"inline-block","background-color":i.debugcolor,top:i.debugy,left:i.debugx,"max-width":e.css("max-width"),padding:e.css("padding"),fontSize:e.css("fontSize"),fontFamily:e.css("fontFamily"),fontWeight:e.css("fontWeight"),lineHeight:e.css("lineHeight"),resize:"none","word-wrap":"break-word"}).appendTo(document.body),i.horizontal===!1?n.css({width:e.width()}):(r=e.css("font-size"),n.css("padding-right","+="+r),n.normalPaddingRight=n.css("padding-right")),d=function(t){return function(l){var r,d,s;return d=t.value.replace(/&/g,"&amp;").replace(/</g,"&lt;").replace(/>/g,"&gt;").replace(/\n /g,"<br/>&nbsp;").replace(/"/g,"&quot;").replace(/'/g,"&#39;").replace(/\n$/,"<br/>&nbsp;").replace(/\n/g,"<br/>").replace(/ {2,}/g,function(e){return Array(e.length-1).join("&nbsp;")+" "}),/(\n|\r)/.test(t.value)&&(d+="<br />",i.flickering===!1&&(d+="<br />")),n.html(d),i.vertical===!0&&(r=Math.max(n.height()+o,a),e.height(r)),i.horizontal===!0&&(n.css("padding-right",n.normalPaddingRight),i.vertical===!1&&e.hasVerticalScrollBar()&&n.css("padding-right","+="+i.verticalScrollbarWidth+"px"),s=Math.max(n.outerWidth(),c),e.width(s)),i.postGrowCallback(e)}}(this),e.change(d).keyup(d).keydown(d),t(l).resize(d),d()})}}(window.jQuery,window),e=function(){var e,t,l,i;return e=document.createElement("p"),e.style.width="100%",e.style.height="200px",t=document.createElement("div"),t.style.position="absolute",t.style.top="0px",t.style.left="0px",t.style.visibility="hidden",t.style.width="200px",t.style.height="150px",t.style.overflow="hidden",t.appendChild(e),document.body.appendChild(t),l=e.offsetWidth,t.style.overflow="scroll",i=e.offsetWidth,l===i&&(i=t.clientWidth),document.body.removeChild(t),l-i}}).call(this);
</script>
<form action="<?php echo site_url(); ?>api/save_qus" method="post" name="adminForm" onsubmit="return checkValidation();" enctype="multipart/form-data" id="adminForm">	

<a class="btn btn-info pull-right mrg5L" href="<?php echo site_url(); ?>api/order_list">Cancel</a>
<a class="btn btn-default pull-right mrg5L" href="javascript://"  onclick="submitform(2);">Save</a> 
<a href="javascript://" class="btn btn-info pull-right" onclick="submitform(1);">Done</a>


<br />
Enter Questions
<?php 
echo $get_data->surveyData->combine_name;
$name = $get_data->surveyData->name;
if(strtoupper(strtolower(substr($surveyData->name,0,2)))!='US'){
	$name = 'US'.$name;
}
?>
<table class="adminform" >
	<tr>
		<td colspan="0">
			
			See patent at  <a target="_blank" class="btn" href="https://patents.google.com/patent/<?php echo $name;?>/en">Google Patents</a>
			
			<!--&nbsp;&nbsp; To delete the entire page, Click <a class="btn" href="<?php echo site_url().'api/deleteQuestionare/'.$surveyID;?>">Clear</a>-->
			<!--&nbsp;&nbsp; To undo last action, Click <a href=''>Undo</a>-->
		</td>
		<td></td>
		
	</tr>
</table>
<div class="example-box-wrapper">
	<div class="row">				
		<div class="col-lg-5">
			<table id="question_list" style='width:100%'>
            <?php
            $questionList = $get_data->QuestionList;
			$bigText = "";
			$oldQuestion = count($questionList);
			$newQuestions = 0;
			$oldQuestionID = "";
			$questionStart = count($questionList);
			$originalText = "";
			if(count($questionList)>0){
				$d=1;
				for($i=0;$i<count($questionList);$i++){
					$oldQuestionID .=$questionList[$i]->id.",";
					      $bigText .=$questionList[$i]->description;
						  $originalText = $questionList[$i]->original_text;
            ?>
				<tr id="<?php echo $questionList[$i]->id?>">
					<td width="100%">
						<label style="max-width:42px !important;min-width:42px !important;">No:<?php echo $d++;?></label>
						<textarea style="width:100%;"  name="question_<?php echo $questionList[$i]->id?>" id="question_<?php echo $questionList[$i]->id;?>"><?php echo $questionList[$i]->description;?></textarea>
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
    				<textarea style="width:100%;"  name="question_new_1" id="question_new_1"></textarea>
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
		</div>
		<div class="col-lg-1">
		&nbsp;
		</div>
		<div class="col-lg-5">		
			<p>Copy the claim from Google Patents and paste (Ctrl + V not right click) in the top right box.</p>
			<table width="100%">
				<tr>
					<td><textarea id="cp_content" style="width:100%;height:80px;" onpaste="checkData(jQuery(this));"></textarea></td>
				</tr>
				<tr>
					<td>
						<?php 
							if($originalText!=""){
								$bigText = $originalText;
							}
						?>
						<textarea id="original_patent_content" name="original_patent_content" style="width:100%;height:80px;" readonly="readonly"><?php echo $bigText;?></textarea>
					</td>
				</tr>
			</table>											
		</div>
		<div class="col-lg-1">
		&nbsp;
		</div>
	</div>				  
</div>
	
		<input type="hidden" name="option" value="com_survey" />
		<input type="hidden" name="task" value="" />
		<input type="hidden" name="survey_id" value="<?php echo $surveyID ;?>" id="survey_id" />
		<input type="hidden" name="hidemainmenu" value="0" />
		<input type="hidden" name="controller" value="question" />
		<input type="hidden" name="oldQuestion" value="<?php echo $oldQuestion;?>" />
		<input type="hidden" name="newQuestions" id="newQuestions" value="<?php echo $newQuestions;?>" />
		<input type="hidden" name="oldQuestionID" id="oldQuestionID" value="<?php echo $oldQuestionID;?>" />
		<input type="hidden" name="questionStart" id="questionStart" value="<?php echo $questionStart;?>" />
        <input type="hidden" name="this_form" value="true" />
        <input type="hidden" name="type" value="0" id="type"/>
</form>
<script language="javascript" type="text/javascript">		
    var survey_id = jQuery("#survey_id").val();
    function submitform(type){
		jQuery("#type").val(type);
		if(type==1){
			_flag = checkValidation();
		} else {
			_flag = true;
		}       
		if(_flag){
			jQuery("#adminForm").get(0).submit();
		}    
    }

function checkValidation(){
	var r = new RegExp("[\<|\>|\"|\'|\%|\;|\(|\)|\&|\+|\-]", "i");
	var x = new RegExp("[\<|\>|\"]","i");
	var filter = /^([\w-]+(?:\.[\w-]+)*)@((?:[\w-]+\.)*\w[\w-]{0,66})\.([a-z]{2,6}(?:\.[a-z]{2})?)$/i
	if (survey_id == "") {
		alert("QUESTION_SURVEY_NAME");
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
					console.log('No:'+q,_FLAG);
					if(_FLAG === 0){
						jQuery("#question_list tbody tr td textarea").eq(q).css('border','1px solid #CCCCCC');
					} else {
						_FLAG = 1;
					}
				}
				/*console.log('No:'+q,_FLAG);*/
				if(_FLAG===1){
					break;
				}
			}
			/*console.log('ORG:',_originalTextSearch);*/
			if(_originalTextSearch!=""){
				_FLAG = 1;
			}
			if(_FLAG === 0){
				return true;
			}	else {
				alert('There is some problem in form.');
			}						
		} else if(_originalTextSearch!=""){
			alert('There is some problem in form.');
		}
	}
	return false;
}
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
	setTimeout(function(){
		if(jQuery("#cp_content").val().length>0){
			jQuery("#original_patent_content").val(object.val()).css('height',jQuery("#cp_content").height());
		}
	},1000);		
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
	jQuery("#question_list").append("<tr id='' new_id='"+_idQuestion+"'><td><label style='min-width:42px !important;max-width:42px !important;'>No:"+_labelQuestion+"</label><textarea style='width:100%;' name='question_new_"+_idQuestion+"' id='question_new_"+_idQuestion+"' ></textarea><input type='hidden' id='question_new_order_"+_idQuestion+"' name='question_new_order_"+_idQuestion+"' value='"+_newOrder+"' /><a href='javascript:void(0)' onclick='upElement(jQuery(this));' class='up_arrow_class'></a>&nbsp;<a href='javascript:void(0)' onclick='downElement(jQuery(this));' class='down_arrow_class'></a></td></tr>");
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
jQuery(document).ready(function(){
	jQuery('textarea').autogrow({vertical: true, horizontal: false,flickering: false});
});
</script>
