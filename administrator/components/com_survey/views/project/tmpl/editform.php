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
$loggedUser = JFactory::getUser();
?>
<script language="javascript" type="text/javascript">		

	Joomla.submitbutton = function(pressbutton){
		var form = document.adminForm;		
		if (pressbutton == 'project.cancelProject') {
			submitform( pressbutton );
			return;
		}
		
		if(eval(form.this_form) && form.this_form.value == "true"){
			//var isNew = getUrlVars()["author_type"];
			var r = new RegExp("[\<|\>|\"|\'|\%|\;|\(|\)|\&|\+|\-]", "i");
			var x = new RegExp("[\<|\>|\"]","i");
			var filter = /^([\w-]+(?:\.[\w-]+)*)@((?:[\w-]+\.)*\w[\w-]{0,66})\.([a-z]{2,6}(?:\.[a-z]{2})?)$/i
			
			if (form.name.value == "") {
				alert("<?php echo JText::_("PROJECT_PROVIDE_NAME"); ?>");
			} 
			else if (x.exec(form.name.value)){
				alert ("<?php echo JText::_("PROJECT_INVALID_CHARACTERS_AUTHOR_NAME"); ?>");
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
				<?php echo JText::_('PROJECT_DETAILS'); ?>
			</th>
		</tr>
		<tr>
			<td width="15%">
				<?php echo JText::_('PROJECT_NAME'); ?>:
				<span style="color:#FF0000">*</span>
			</td>
			<td>
				<input type="text" name="name" value="<?php echo $user->name; ?>" class="inputbox" size="40" />
				<span class="editlinktip hasTip" title="<?php echo JText::_("PROJECT_NAME")."::".JText::_("PROJECT_NAME_TIP"); ?>" >
					<img border="0" src="components/com_survey/images/icons/tooltip.png">
				</span>
			</td>
	  	</tr>									
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
						<?php echo JText::_('POJECT_UPLOAD_IMAGE'); ?>
					</td>
                    <td>
                        <div id="fileUploader"></div>
                        <input type="hidden" name="images" id="images" value="<?php echo $user->project_image; ?>" />
						&nbsp;
						<span class="editlinktip hasTip" title="<?php echo JText::_("POJECT_UPLOAD_IMAGE")."::".JText::_("PROJECT_TIP_UPLOAD_IMAGE"); ?>" >
							<img border="0" src="components/com_survey/images/icons/tooltip.png">
						</span>
                    </td>
                 </tr>	
			<?php
            	if(isset($user->project_image) && $user->project_image!=""){ 	?>
                
					<tr>
						<td valign='top'>
							<?php echo JText::_('PROJECT_SEL_IMAGE'); ?>
						</td>
						<td>
							<div id='authorImageSelected'>
								<img id="view_imagelist23" name="view_imagelist" src='../<?php echo $user->project_image;?>'/><br />
							</div>
							<br />
							<input type="button" value="<?php echo JText::_('PROJECT_REMOVE_IMAGE'); ?>" onclick="return deleteImage();"/>
							<input type="hidden" value="<?php echo $user->project_image; ?>" name="img_name" id="img_name" />
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
                    <?php echo JText::_('PROJECT_DESCRIPTION');?>
					</th>
				</tr>
                <tr>					
					<td width="100%">
                    <?php
					// parameters : areaname, content, hidden field, width, height, rows, cols'full_bio',
					echo $editor1->display( 'description',  $user->description ,  '100%;', '300px', '20', '60' ) ; ?>
					</td>
					<td valign="top">
						<span class="editlinktip hasTip" title="<?php echo JText::_("PROJECT_DESCRIPTION")."::".JText::_("PROJECT_TIP_DESCRIPTION"); ?>" >
							<img border="0" src="components/com_survey/images/icons/tooltip.png">
						</span>
					</td>
				</tr>
       </table>
		<?php			
			echo $tabs->endPanel();
			echo $tabs->endPane();

		?>	
		<input type="hidden" name="option" value="com_survey" />
		<input type="hidden" name="task" value="" />
		<input type="hidden" name="hidemainmenu" value="0" />
		<input type="hidden" name="controller" value="project" />
        <input type="hidden" name="id" value="<?php echo $user->id;?>" />
        <input type="hidden" name="user_id" value="<?php echo $loggedUser->id;?>" />
        <input type="hidden" name="this_form" value="true" />
</form>
