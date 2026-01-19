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
JToolBarHelper::title(JText::_('Email Template'));

/*$parent = $this->parentData;
$child = $this->childData;*/

$getSurveyID = $this->survey_id;
//$allExperts = $this->getModel()->allExpert();
$surveyDetail = $this->getModel()->surveyDetail($getSurveyID); 
$mode = 1;
?>
<form action="index.php" method="post" name="adminForm">
    <div class="row-fluid">
	<div class="span6">
		<label>Email Message: </label>
		<textarea name="email_message" id="email_message" style="width:80%; min-height: 200px;"></textarea>
	</div>
	<?php 
		if(count($surveyDetail)>0 && empty($surveyDetail->specific_expert)):
	?>
    <div class="span6">
    	<div class="controls">
        	<label>Search Expertise Code:</label>
            <input type="text" name="expertise_code" id="expertise_code"/>
        </div>
        <div class="controls">
        	<input type="button" name="find_expert" value="Find" onClick="findExpertWithCode();"/>
        </div>
        <div id="found_expert"></div>        
    </div>
	<?php 
		else:
			$findExpert = $this->getModel()->findExpertFromUserName($surveyDetail->specific_expert);
			if(count($findExpert)>0):
			$mode = 2;
	?>
			<h5>Claim has Specific Expert</h5>
			<table>
				<tr>
					<td><input type="checkbox" checked="checked" name="selected_expert[]" id="selected_expert[<?php echo $findExpert->id;?>]" value="<?php echo $findExpert->id;?>"/></td>
					<td><?php echo $findExpert->name; ?></td>
					<td><?php echo $findExpert->email;?></td>
				</tr>
			</table>
	<?php
			endif;
		endif;
	?>
    </div>
    <input type="hidden" name="option" value="com_survey" />
	<input type="hidden" name="task" value="question.emailSend" />
	<input type="hidden" name="controller" value="question" />
    <input type="hidden" name="mode" id="mode" value="<?php echo $mode;?>" />
	<input type="hidden" name="survey_id" value="<?php echo $getSurveyID;?>" />
</form>
<script>
	function findExpertWithCode(){
		if(jQuery("#expertise_code").val()==""){
			alert('Please enter expertise code.');	
		}	else {
			jQuery("#found_expert").html('Loading...');
			jQuery.ajax({
				url:'index.php',
				type:'POST',
				data:{option:'com_survey',task:'question.findExpertWithCode',code:jQuery("#expertise_code").val(),tmpl:'component',mode:jQuery("#mode").val()},
				dataType:"json",
				cache:false,
				success: function(data){
					if(jQuery("#mode").val()=='1'){
						count = 0;
						if(data.count!=null && data.count>0){
							count = data.count;
						}
						jQuery("#found_expert").html("<b>"+count+'</b> expertise found. <a href="javascript://" onclick="findExpertWithCode();">Click here</a> to show the list.');
						jQuery("#mode").val(2);
					} else {
						jQuery("#mode").val(1);
						/*Implement table with list of Expertise Under this code.*/
						_htmlCode = '<table id="expertsTable" class="table table-condensed table-striped">'+
							'<thead>'+
							'<th>[ ]</th>'+
							'<th>Name</th>'+
							'<th>Email</th>'+
							'</thead>'+
							'<tbody>';							
							for(i=0;i<data.length;i++){
								_htmlCode +='<tr><td><input type="checkbox" name="selected_expert[]" id="selected_expert['+data[i].expert_id+']" value="'+data[i].expert_id+'"/></td>';
								_htmlCode +='<td>'+data[i].name+'</td>';
								_htmlCode +='<td>'+data[i].email+'</td>';
								_htmlCode +='</tr>';
							}									
						_htmlCode +='</tbody></table>';
						jQuery("#found_expert").html(_htmlCode);
					}
				}	
			});	
		}
	}	
</script>