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
$userLogged = JFactory::getUser();
?>
<script language="javascript" type="text/javascript">		

	Joomla.submitbutton = function(pressbutton){
		var form = document.adminForm;
		if (pressbutton == 'survey.cancelSurvey') {		
			submitform( pressbutton );
			return;
		}
		
		if(eval(form.this_form) && form.this_form.value == "true"){
			//var isNew = getUrlVars()["author_type"];
			var r = new RegExp("[\<|\>|\"|\'|\%|\;|\(|\)|\&|\+|\-]", "i");
			var x = new RegExp("[\<|\>|\"]","i");
			var filter = /^([\w-]+(?:\.[\w-]+)*)@((?:[\w-]+\.)*\w[\w-]{0,66})\.([a-z]{2,6}(?:\.[a-z]{2})?)$/i
			
			if (form.name.value == "") {
				alert("<?php echo JText::_("SURVEY_PROVIDE_NAME"); ?>");
			} 
			else if (x.exec(form.name.value)){
				alert ("<?php echo JText::_("SURVEY_INVALID_CHARACTERS_AUTHOR_NAME"); ?>");
			}
			else if(form.project_id.value==""){
				alert("<?php echo JText::_("SURVEY_PROJECT_NAME_SELECT"); ?>");
			}			 
			else {
				submitform( pressbutton );
				
			}			
		}
		else{
			submitform( pressbutton );
		}					
	}
		
	function deleteImage(){
		document.getElementById("view_imagelist23").src = "";
		document.getElementById("images").value = "";
	}
	function setModertorg(){
		document.getElementById('forummoderator1').style.display = 'none';
		document.getElementById('forummoderator2').style.display = 'table-row';
	}
	
</script>
<?php
	jimport( 'joomla.html.pane' );
	$user = $this->user;
	$projects = $this->projectList;
	$tabs =& JPane::getInstance('tabs');
	
	$max_upload = (int)(ini_get('upload_max_filesize'));
	$max_post = (int)(ini_get('post_max_size'));
	$memory_limit = (int)(ini_get('memory_limit'));
	$upload_mb = min($max_upload, $max_post, $memory_limit);
	if($upload_mb == 0){
		$upload_mb = 10;
	}
	$upload_mb *= 1048576; //transform in bytes
	$doc = &JFactory::getDocument();
	$doc->addScript('components/com_survey/js/jquery-1.4.2.min.js');
	
	$config_author = '33554432';
	$author_t_prop =  "width" ;
	//echo'<pre>'; print_r($config_author); die();
	$doc->addScriptDeclaration('
		jQuery.noConflict();
		jQuery(function(){
			function createUploader(){
				var uploader = new qq.FileUploader({
					element: document.getElementById(\'fileUploader\'),
					action: \'components/com_survey/helpers/fileuploader.php\',
					params:{
						folder:\'images\',
						mediaType:\'image\',
						size: '.$config_author.',
						type: \''.$author_t_prop.'\'
					},
					onSubmit: function(id,fileName){
						jQuery(\'.qq-upload-list li\').css(\'display\',\'none\');
					},
					onComplete: function(id,fileName,responseJSON){
						//alert(\'id: \'+ id + \'; filename:\' + fileName);
						if(responseJSON.success == true){						
							jQuery(\'.qq-upload-success\').append(\'- <span style="color:#387C44;">Upload successful</span>\');
							if(responseJSON.locate) {
								jQuery(\'#view_imagelist23\').attr("src", "../"+responseJSON.locate +"/"+ fileName+"?timestamp=" + new Date().getTime()).css({width:"150px",height:"150px"});
								jQuery(\'#images\').val("/"+responseJSON.locate +"/"+ fileName);
							}
						}
					},
					allowedExtensions: [\'jpg\', \'jpeg\', \'png\', \'gif\', \'JPG\', \'JPEG\', \'PNG\', \'GIF\'],
					sizeLimit: '.$upload_mb.',
					multiple: false,
					maxConnections: 1
				});           
			}
			createUploader();
		});
	');
	$doc->addScript('components/com_survey/js/fileuploader.js');
	$doc->addStyleSheet('components/com_survey/css/fileuploader.css');
	

?>

<form action="index.php" method="post" name="adminForm" enctype="multipart/form-data">	
	<?php
		echo $tabs->startPane("EditUsers");
		echo $tabs->startPanel("General","authors-general-tab");
	?>
	<table class="adminform">
		<tr>
			<th colspan="2">
				<?php echo JText::_('SURVEY_DETAILS'); ?>
			</th>
		</tr>
		<tr>
			<td width="15%">
				<?php echo JText::_('SURVEY_NAME'); ?>:
				<span style="color:#FF0000">*</span>
			</td>
			<td>
				<input type="text" name="name" value="<?php echo $user->name; ?>" class="inputbox" size="40" />
				<span class="editlinktip hasTip" title="<?php echo JText::_("SURVEY_NAME")."::".JText::_("SURVEY_NAME_TIP"); ?>" >
					<img border="0" src="components/com_survey/images/icons/tooltip.png">
				</span>
			</td>
	  	</tr>
		<tr>
			<td width="15%">
				<?php echo JText::_('PROJECT_NAME'); ?>:
				<span style="color:#FF0000">*</span>
			</td>
			<td>
				<select name="project_id" id="project_id">
					<option value="">Select Project</option>
					<?php 
						foreach($projects as $value){
					?>
						<option value="<?php echo $value->id?>" <?php echo ($value->id==$user->project_id)?'SELECTED="SELECTED"':"";?>><?php echo $value->name;?></option>
					<?php
						}
					?>
				</select>
				<span class="editlinktip hasTip" title="<?php echo JText::_("SURVEY_PROJECT_NAME")."::".JText::_("SURVEY_PROJECT_NAME_TIP"); ?>" >
					<img border="0" src="components/com_survey/images/icons/tooltip.png">
				</span>
			</td>
	  	</tr>	
	  	<!--
		<tr>
			<td width="15%">
				<?php echo JText::_('SURVEY_AMOUNT'); ?>:
				<span style="color:#FF0000">*</span>
			</td>
			<td>
				<input type="text" name="amount" id="amount" value="<?php echo (int)$user->amount; ?>" class="inputbox"  />
				<span class="editlinktip hasTip" title="<?php echo JText::_("SURVEY_AMOUNT")."::".JText::_("SURVEY_AMOUNT_TIP"); ?>" >
					<img border="0" src="components/com_survey/images/icons/tooltip.png">
				</span>
			</td>
		</tr>	
		-->	
	</table>
		<?php
			echo $tabs->endPanel();
			
			echo $tabs->startPanel("Photo","authors-photo-tab");
		?>
        		<?php //start new version for author photo tab ?>

			<table width="100%" class="adminform" cellpadding="3" cellspacing="3">
            	<tr>
                	<td colspan="2">&nbsp;</td>
                </tr>
				<tr>
					<td style="width: 25%;" valign="top">
						<?php echo JText::_('SURVEY_UPLOAD_IMAGE'); ?>
					</td>
                    <td>
                        <div id="fileUploader"></div>
                        <input type="hidden" name="images" id="images" value="<?php echo $user->image; ?>" />
						&nbsp;
						<span class="editlinktip hasTip" title="<?php echo JText::_("SURVEY_UPLOAD_IMAGE")."::".JText::_("SURVEY_TIP_UPLOAD_IMAGE"); ?>" >
							<img border="0" src="components/com_survey/images/icons/tooltip.png">
						</span>
                    </td>
                 </tr>	
			<?php
            	if(isset($user->image) && $user->image!=""){ 	?>
                
					<tr>
						<td valign='top'>
							<?php echo JText::_('SURVEY_SEL_IMAGE'); ?>
						</td>
						<td>
							<div id='authorImageSelected'>
								<img id="view_imagelist23" name="view_imagelist" src='../<?php echo $user->image;?>'/><br />
							</div>
							<br />
							<input type="button" value="<?php echo JText::_('SURVEY_REMOVE_IMAGE'); ?>" onclick="return deleteImage();"/>
							<input type="hidden" value="<?php echo $user->image; ?>" name="img_name" id="img_name" />
					</td></tr>
					
			<?php 
				} else {
					echo "<tr><td></td><td><div id='authorImageSelected'><img id='view_imagelist23' name='view_imagelist' src='components/com_survey/images/blank.png'/></div></td></tr>";
				}
			?>
				</td>
				</tr>
			</table>		
       
        <?php
			echo $tabs->endPanel();

			echo $tabs->startPanel("Description","project-description-tab");
			$editor1  = & JFactory::getEditor();
		?>
		<table class="adminform">
			<tr>
				<th colspan="2">
                    <?php echo JText::_('SURVEY_DESCRIPTION');?>
					</th>
				</tr>
                <tr>					
					<td width="100%">
                    <?php
					// parameters : areaname, content, hidden field, width, height, rows, cols'full_bio',
					echo $editor1->display( 'description',  $user->description ,  '100%;', '300px', '20', '60' ) ; ?>
					</td>
					<td valign="top">
						<span class="editlinktip hasTip" title="<?php echo JText::_("SURVEY_DESCRIPTION")."::".JText::_("SURVEY_TIP_DESCRIPTION"); ?>" >
							<img border="0" src="components/com_survey/images/icons/tooltip.png">
						</span>
					</td>
				</tr>
       </table>
		<?php			
			echo $tabs->endPanel();
			echo $tabs->startPanel("Questions","project-questions-tab");
		?>
			<table class="adminform" id="question_container">
			<tr>
				<th colspan="2">
                    <?php echo JText::_('SURVEY_DESCRIPTION');?>
                    <a style="float:right" href="javascript://" onclick="addMore();">Add More</a>
				</th>
				</tr>
				<?php 
					$oldTotalCount = 0;
					$questionID ="";
					$newQuestionCount = 0;
					if($user->id==0):
						$newQuestionCount = 1;
				?>
				<tr>					
					<td width="100%">
						<div>
							<label>Q.No 1:-</label>
							<textarea rows="2" cols="10" name="questions_1"  style="width: 909px; height: 59px;"></textarea>
						</div>						
					</td>
				</tr>
				<?php else:
						$getQuestionList = $this->getQuestionList($user->id);
						$oldTotalCount=count($getQuestionList);
						$newQuestionCount = 0;
						$questionID ="";
						if(count($getQuestionList)>0):
							$qm=1;
							for($q=0;$q<count($getQuestionList);$q++){
								$questionID .= $getQuestionList[$q]->id.",";
						?>
							<tr>					
								<td width="100%">
									<div>
										<label>Q.No <?php echo $qm;?>:-</label>
										<textarea rows="2" cols="10"  name="questions_<?php echo $getQuestionList[$q]->id;?>"  style="width: 909px; height: 59px;"><?php echo $getQuestionList[$q]->description;?></textarea>
									</div>						
								</td>
							</tr>
						<?php
								$qm++;
							}
							$questionID = substr($questionID,0,-1);
						else:
							$newQuestionCount = 1;
						?>
							<tr>					
								<td width="100%">
									<div>
										<label>Q.No 1:-</label>
										<textarea rows="2" cols="10" name="questions_1" style="width: 909px; height: 59px;"></textarea>
									</div>						
								</td>
							</tr>
						<?php
						endif;
					?>
				<?php  endif;?>
			</table>
		<?php
			echo $tabs->endPanel();
			echo $tabs->endPane();

		?>	
		<input type="hidden" name="option" value="com_survey" />
		<input type="hidden" name="task" value="" />
		<input type="hidden" name="hidemainmenu" value="0" />
		<input type="hidden" name="controller" value="survey" />
        <input type="hidden" name="id" value="<?php echo $user->id;?>" />
        <input type="hidden" name="user_id" value="<?php echo $userLogged->id;?>"/>
        <input type="hidden" name="this_form" value="true" />
        <input type="hidden" id="no_of_questions" name="no_of_questions" value="<?php echo $oldTotalCount;?>" />
        <input type="hidden" id="no_of_questions_new" name="no_of_questions_new" value="<?php echo $newQuestionCount;?>" />
        <input type="hidden" id="question_ids" name="question_ids" value="<?php echo $questionID;?>"/>
        
</form>
<script>
	function addMore(){
		jQuery("#no_of_questions_new").val(parseInt(jQuery("#no_of_questions_new").val()) + 1);
		_newNo = parseInt(jQuery("#no_of_questions_new").val()) + parseInt(jQuery("#no_of_questions").val());
		if(jQuery("#question_ids").val()==""){
			jQuery("#question_container").append("<tr><td width='100%'><div><label>Q.No "+_newNo+":-</label><textarea rows='2' cols='10' name='questions_"+_newNo+"' style='width: 909px; height: 59px;' ></textarea></div></td></tr>");
		} else {
			jQuery("#question_container").append("<tr><td width='100%'><div><label>Q.No "+_newNo+":-</label><textarea rows='2' cols='10' name='questions_new_"+_newNo+"' style='width: 909px; height: 59px;'></textarea></div></td></tr>");
		}
	}
	
</script>
