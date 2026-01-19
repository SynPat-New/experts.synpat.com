<?php
    $user = json_decode($get_data);
    
	//$user = $this->user;
	
	$max_upload = (int)(ini_get('upload_max_filesize'));
	$max_post = (int)(ini_get('post_max_size'));
	$memory_limit = (int)(ini_get('memory_limit'));
	$upload_mb = min($max_upload, $max_post, $memory_limit);
	if($upload_mb == 0){
		$upload_mb = 10;
	}
	$upload_mb *= 1048576; //transform in bytes
    /*
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
								jQuery(\'#view_imagelist23\').attr("src", "../"+responseJSON.locate +"/"+ fileName+"?timestamp=" + new Date().getTime());
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
	*/

?>
<form action="<?php  echo site_url() ?>api/saveExpertDetail/" method="post" name="adminForm" id="adminForm" enctype="multipart/form-data"  onsubmit="return check_validation();">	
	<?php
	//	echo $tabs->startPane("EditUsers");
	//	echo $tabs->startPanel("General","authors-general-tab");
		if((int)$user->pub==1 && !empty($user->text_data)){
			$textData = json_decode($user->text_data);
			$firstName = (isset($textData->f))?$textData->f:'';
			$lastName = (isset($textData->l))?$textData->l:'';
			$companyName = (isset($textData->c))?$textData->c:'';
			$address = (isset($textData->a))?$textData->a:'';
			$city = (isset($textData->ci))?$textData->ci:'';
			$state = (isset($textData->st))?$textData->st:'';
			$zip = (isset($textData->zi))?$textData->zi:'';
			$country = (isset($textData->co))?$textData->co:'';
			$email = (isset($textData->em))?$textData->em:'';
			$phone = (isset($textData->p))?$textData->p:'';
			$web = (isset($textData->w))?$textData->w:'';
		} else {
			$firstName = $user->first_name;
			$lastName = $user->last_name;
			$companyName = $user->company_name;
			$address = $user->address;
			$city = $user->city;
			$state = $user->state;
			$zip = $user->zip;
			$country = $user->country;
			$email = $user->email;
			$phone = $user->phone;
			$web = $user->web;
		}
	?>
	<table class="adminform">
		<tr>
			<td width="15%">
				First Name
				<span style="color:#FF0000">*</span>
			</td>
			<td>
				<input type="text" name="first_name" value="<?php echo $firstName; ?>" class="inputbox" size="40" />
				<span class="editlinktip hasTip" title="Expert First Name" >
					<img border="0" src="<?php echo site_url() ?>/public/images/tooltip.png">
				</span>
			</td>
	  	</tr>	
	  	<tr>
			<td width="15%">
				Last Name
				<span style="color:#FF0000">*</span>
			</td>
			<td>
				<input type="text" name="last_name" value="<?php echo $lastName; ?>" class="inputbox" size="40" />
				<span class="editlinktip hasTip" title="Expert Last Name" >
					<img border="0" src="<?php echo site_url() ?>/public/images/tooltip.png">
				</span>
			</td>
	  	</tr>	
		<tr>
			<td width="15%">
				Company Name
				<span style="color:#FF0000">*</span>
			</td>
			<td>
				<input type="text" name="company_name" value="<?php echo $companyName; ?>" class="inputbox" size="40" />
				<span class="editlinktip hasTip" title="Expert Company Name" >
					<img border="0" src="<?php echo site_url() ?>/public/images/tooltip.png">
				</span>
			</td>
	  	</tr>	
		<tr>
			<td width="15%">
				Street
				<span style="color:#FF0000">*</span>
			</td>
			<td>
				<input type="text" name="address" value="<?php echo $address; ?>" class="inputbox" />
				<span class="editlinktip hasTip" title="Expert Street Address" >
					<img border="0" src="<?php echo site_url() ?>/public/images/tooltip.png">
				</span>
			</td>
	  	</tr>	
		<tr>
			<td width="15%">
				City
				<span style="color:#FF0000">*</span>
			</td>
			<td>
				<input type="text" name="city" value="<?php echo $city; ?>" class="inputbox" size="40" />
				<span class="editlinktip hasTip" title="Expert City" >
					<img border="0" src="<?php echo site_url() ?>/public/images/tooltip.png">
				</span>
			</td>
	  	</tr>	
		<tr>
			<td width="15%">
				State
				<span style="color:#FF0000">*</span>
			</td>
			<td>
				<input type="text" name="state" value="<?php echo $state; ?>" class="inputbox" size="40" />
				<span class="editlinktip hasTip" title="Expert State" >
					<img border="0" src="<?php echo site_url() ?>/public/images/tooltip.png">
				</span>
			</td>
	  	</tr>
		<tr>
			<td width="15%">
				Zip/Postal Code
				<span style="color:#FF0000">*</span>
			</td>
			<td>
				<input type="text" name="zip" value="<?php echo $zip; ?>" class="inputbox" size="40" />
				<span class="editlinktip hasTip" title="Expert Zip/Postal Code" >
					<img border="0" src="<?php echo site_url() ?>/public/images/tooltip.png">
				</span>
			</td>
	  	</tr>	
	  	<tr>
			<td width="15%">
				Country
				<span style="color:#FF0000">*</span>
			</td>
			<td>
				<input type="text" name="country" value="<?php echo $country; ?>" class="inputbox" size="40" />
				<span class="editlinktip hasTip" title="Expert Country" >
					<img border="0" src="<?php echo site_url() ?>/public/images/tooltip.png">
				</span>
			</td>
	  	</tr>	
		<tr>
			<td width="15%">
				Email
				<span style="color:#FF0000">*</span>
			</td>
			<td>
				<input type="text" name="email" value="<?php echo $email; ?>" class="inputbox" size="40" />
				<span class="editlinktip hasTip" title="Expert Email Address" >
					<img border="0" src="<?php echo site_url() ?>/public/images/tooltip.png">
				</span>
			</td>
	  	</tr>	
		<tr>
			<td width="15%">
				Phone Number
				<span style="color:#FF0000">*</span>
			</td>
			<td>
				<input type="text" name="phone" value="<?php echo $phone; ?>" class="inputbox" size="40" />
				<span class="editlinktip hasTip" title="Expert Phone Number" >
					<img border="0" src="<?php echo site_url() ?>/public/images/tooltip.png">
				</span>
			</td>
	  	</tr>	
		<tr>
			<td width="15%">
				Website Address
				<span style="color:#FF0000">*</span>
			</td>
			<td>
				<input type="text" name="web" value="<?php echo $web; ?>" class="inputbox" size="40" />
				<span class="editlinktip hasTip" title="Expert Website Address" >
					<img border="0" src="<?php echo site_url() ?>/public/images/tooltip.png">
				</span>
			</td>
	  	</tr>	
	</table>
		<?php
		//	echo $tabs->endPanel();
		?>
        	
        <?php		
/*
			echo $tabs->startPanel("Description","project-description-tab");
			$editor1  = & JFactory::getEditor();
			if((int)$user->pub==1 && !empty($user->text_data)){
				$textData = json_decode($user->text_data);
				$introduction = (isset($textData->expl))?$textData->expl:''; 
				$editorAreas_of_expertiseitorText = (isset($textData->ae))?$textData->ae:''; 
				$editorMembershipText = (isset($textData->me))?$textData->me:''; 
				$editorStandards_groupsText = (isset($textData->sg))?$textData->sg:''; 
			} else {
				$introduction = $user->description;
				$editorAreas_of_expertiseitorText = $user->areas_of_expertise;
				$editorMembershipText = $user->membership;
				$editorStandards_groupsText = $user->standards_groups;
			}
		?>
		<table class="adminform">
			<tr>
				<th colspan="2">
                    <?php echo JText::_('Introduction');?>
				</th>
			</tr>
			<tr>					
				<td width="100%">
				<?php
				// parameters : areaname, content, hidden field, width, height, rows, cols'full_bio',
				echo $editor1->display( 'description',  $introduction ,  '100%;', '300px', '20', '60' ) ; ?>
				</td>
				<td valign="top">
					<span class="editlinktip hasTip" title="<?php echo JText::_("EXPERT_DESCRIPTION")."::".JText::_("EXPERT_TIP_DESCRIPTION"); ?>" >
						<img border="0" src="<?php echo site_url() ?>/public/images/tooltip.png">
					</span>
				</td>
			</tr>
			<tr>
				<th colspan="2">
                    <?php echo JText::_('Areas OF Expertise');?>
				</th>
			</tr>
			<tr>					
				<td width="100%">
					<?php 
						$editorAreas_of_expertiseitorText0="";
						$editorAreas_of_expertiseitorText1="";
						$editorAreas_of_expertiseitorText2="";
						$editorAreas_of_expertiseitorText3="";
						$editorAreas_of_expertiseitorText4="";
						$editorAreas_of_expertiseitorText5="";
						$editorAreas_of_expertiseitorText6="";
						$editorAreas_of_expertiseitorText7="";		
						if(!empty($editorAreas_of_expertiseitorText)){
							$editorAreas_of_expertiseitorText = explode(',',$editorAreas_of_expertiseitorText);
							if(isset($editorAreas_of_expertiseitorText[0])){
								$editorAreas_of_expertiseitorText0= $editorAreas_of_expertiseitorText[0];
							}
							if(isset($editorAreas_of_expertiseitorText[1])){
								$editorAreas_of_expertiseitorText1= $editorAreas_of_expertiseitorText[1];
							}
							if(isset($editorAreas_of_expertiseitorText[2])){
								$editorAreas_of_expertiseitorText2= $editorAreas_of_expertiseitorText[2];
							}
							if(isset($editorAreas_of_expertiseitorText[3])){
								$editorAreas_of_expertiseitorText3= $editorAreas_of_expertiseitorText[3];
							}
							if(isset($editorAreas_of_expertiseitorText[4])){
								$editorAreas_of_expertiseitorText4= $editorAreas_of_expertiseitorText[4];
							}
							if(isset($editorAreas_of_expertiseitorText[5])){
								$editorAreas_of_expertiseitorText5= $editorAreas_of_expertiseitorText[5];
							}
							if(isset($editorAreas_of_expertiseitorText[6])){
								$editorAreas_of_expertiseitorText6= $editorAreas_of_expertiseitorText[6];
							}
							if(isset($editorAreas_of_expertiseitorText[7])){
								$editorAreas_of_expertiseitorText7= $editorAreas_of_expertiseitorText[7];
							}
						}
					?>
					<table class="table">
						<tbody>
							<tr>
								<td>
									<?php echo $editorAreas_of_expertiseitorText0;?>
								</td>
								<td>
									<?php echo $editorAreas_of_expertiseitorText1;?>
								</td>
							</tr>
							<tr>
								<td>
									<?php echo $editorAreas_of_expertiseitorText2;?>
								</td>
								<td>
									<?php echo $editorAreas_of_expertiseitorText3;?>
								</td>
							</tr>
							<tr>
								<td>
									<?php echo $editorAreas_of_expertiseitorText4;?>
								</td>
								<td>
									<?php echo $editorAreas_of_expertiseitorText5;?>
								</td>
							</tr>
							<tr>
								<td>
									<?php echo $editorAreas_of_expertiseitorText6;?>
								<td>
									<?php echo $editorAreas_of_expertiseitorText7;?>
								</td>
							</tr>
						</tbody>
					</table>
				</td>
			</tr>
			<tr>
				<th colspan="2">
                    <?php echo JText::_('Memberships');?>
				</th>
			</tr>
			<tr>					
				<td width="100%">
					<?php 
						$editorMembershipText0="";
						$editorMembershipText1="";
						$editorMembershipText2="";
						$editorMembershipText3="";
						$editorMembershipText4="";
						$editorMembershipText5="";	
						if(!empty($editorMembershipText)){
							$editorMembershipText = explode(',',$editorMembershipText);
							if(isset($editorMembershipText[0])){
								$editorMembershipText0= $editorMembershipText[0];
							}
							if(isset($editorMembershipText[1])){
								$editorMembershipText1= $editorMembershipText[1];
							}
							if(isset($editorMembershipText[2])){
								$editorMembershipText2= $editorMembershipText[2];
							}
							if(isset($editorMembershipText[3])){
								$editorMembershipText3= $editorMembershipText[3];
							}
							if(isset($editorMembershipText[4])){
								$editorMembershipText4= $editorMembershipText[4];
							}
							if(isset($editorMembershipText[5])){
								$editorMembershipText5= $editorMembershipText[5];
							}								
						}
					?>
					<table class="table">
						<tbody>
							<tr>
								<td>
									<?php echo $editorMembershipText0;?>
								</td>
								<td>
									<?php echo $editorMembershipText1;?>
								</td>
							</tr>
							<tr>
								<td>
									<?php echo $editorMembershipText2;?>
								</td>
								<td>
									<?php echo $editorMembershipText3;?>
								</td>
							</tr>
							<tr>
								<td>
									<?php echo $editorMembershipText4;?>
								</td>
								<td>
									<?php echo $editorMembershipText5;?>
								</td>
							</tr>								
						</tbody>
					</table>
				</td>
			</tr>
			<tr>
				<th colspan="2">
                    <?php echo JText::_('Standards Groups');?>
				</th>
			</tr>
			<tr>					
				<td width="100%">
					<?php 
						$editorStandards_groupsText0="";
						$editorStandards_groupsText1="";
						$editorStandards_groupsText2="";
						$editorStandards_groupsText3="";
						$editorStandards_groupsText4="";
						$editorStandards_groupsText5="";	
						if(!empty($editorStandards_groupsText)){
							$editorStandards_groupsText = explode(',',$editorStandards_groupsText);
							if(isset($editorStandards_groupsText[0])){
								$editorStandards_groupsText0= $editorStandards_groupsText[0];
							}
							if(isset($editorStandards_groupsText[1])){
								$editorStandards_groupsText1= $editorStandards_groupsText[1];
							}
							if(isset($editorStandards_groupsText[2])){
								$editorStandards_groupsText2= $editorStandards_groupsText[2];
							}
							if(isset($editorStandards_groupsText[3])){
								$editorStandards_groupsText3= $editorStandards_groupsText[3];
							}
							if(isset($editorStandards_groupsText[4])){
								$editorStandards_groupsText4= $editorStandards_groupsText[4];
							}
							if(isset($editorStandards_groupsText[5])){
								$editorStandards_groupsText5= $editorStandards_groupsText[5];
							}								
						}
					?>
					<table class="table">
						<tbody>
							<tr>
								<td>
									<?php echo $editorStandards_groupsText0;?>
								</td>
								<td>
									<?php echo $editorStandards_groupsText1;?>
								</td>
							</tr>
							<tr>
								<td>
									<?php echo $editorStandards_groupsText2;?>
								</td>
								<td>
									<?php echo $editorStandards_groupsText3;?>
								</td>
							</tr>
							<tr>
								<td>
									<?php echo $editorStandards_groupsText4;?>
								</td>
								<td>
									<?php echo $editorStandards_groupsText5;?>
								</td>
							</tr>								
						</tbody>
					</table>
				</td>
			</tr>
			<tr>
				<th colspan="2">
                    <?php echo JText::_('Uploaded CV/Resume');?>
				</th>
			</tr>
			<tr>					
				<td width="100%">
					<?php 
						if((int)$user->pub==1 && !empty($user->text_data)){ 
							$textData = json_decode($user->text_data);
							$cv = $textData->cv;
						} else {
							$cv = $user->cv;
						}
						if(!empty($cv)){
					?>	
						<a href="<?php echo JUri::base() ?>../media/com_survey/profile_resumes/<?php echo $cv; ?>" target="_BLANK"><?php echo $cv?></a>
					<?php	
						}
					?>
					
				</td>
			</tr>
			<tr>
				<th colspan="2">
                    <?php echo JText::_('Profile Image');?>
				</th>
			</tr>
			<tr>					
				<td width="100%">
					<?php 
						if((int)$user->pub==1 && !empty($user->text_data)){ 
							$textData = json_decode($user->text_data);
							$profile_image_file_name = $textData->img;
						} else {
							$profile_image_file_name = $user->profile_image_file_name;
						}
					
						if(!empty($profile_image_file_name)){
					?>
						<img id="profile_image" src="<?php echo JUri::base() ?>../media/com_survey/profile_images/<?php echo $profile_image_file_name; ?>" style="height: 180px; width: 180px;" />
					<?php
						}
					?>
					
				</td>
			</tr>
       </table>
		<?php			
			echo $tabs->endPanel();
			echo $tabs->endPane();*/
		?>	
		<input type="hidden" name="option" value="com_survey" />
		<input type="hidden" name="task" value="" />
		<input type="hidden" name="hidemainmenu" value="0" />
		<input type="hidden" name="controller" value="expert" />
        <input type="hidden" name="id" value="<?php echo $user->id;?>" />
        <input type="hidden" name="this_form" value="true" id="this_form"/>
        
        <a href="#" onclick="form_submit();">Publish</a> | <a href="<?php  echo site_url() ?>api/expert_list/">Cancel</a>
</form>
<script language="javascript" type="text/javascript">		

	
		function form_submit(){
		  _flag = check_validation();
          alert(_flag);
          if(_flag)
          {
            jQuery('#adminForm').get('0').submit();
          }
		}
		function check_validation(){
		  this_form = $('#this_form').val();
		//  alert($('#adminForm').this_form);
          
    		  if(eval($('#adminForm')) && this_form == "true"){
    		      alert('A');
    			//var isNew = getUrlVars()["author_type"];
    			var r = new RegExp("[\<|\>|\"|\'|\%|\;|\(|\)|\&|\+|\-]", "i");
    			var x = new RegExp("[\<|\>|\"]","i");
    			var filter = /^([\w-]+(?:\.[\w-]+)*)@((?:[\w-]+\.)*\w[\w-]{0,66})\.([a-z]{2,6}(?:\.[a-z]{2})?)$/i
    			
    			if ($('#adminForm') == "") {
    				alert("EXPERT_PROVIDE_NAME");
    			} 
    			else if (x.exec(this_form)){
    				alert ("EXPERT_INVALID_CHARACTERS_NAME");
    			} 
    			else {
    				return true;;
    			}			
    		}
    		else{
    		  alert('B');
    			return false;;
    		}
		}					
	function setModertorg(){
		document.getElementById('forummoderator1').style.display = 'none';
		document.getElementById('forummoderator2').style.display = 'table-row';
	}
	
</script>