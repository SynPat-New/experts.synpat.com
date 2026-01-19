<?php
// No direct access to this file
defined('_JEXEC') or die('Restricted access');
$expert = $this->expert;
$rating = $this->rating;
$session = JFactory::getSession();
$getSession = $session->get('expertSession', '');
$sessionEXpertID = 0;
if (is_object($getSession) && count($getSession) > 0) {

    $sessionEXpertID = $getSession->id;
}

/* print_r($getSession); */
$document = JFactory::getDocument();
$document->setTitle('ClaimCharts');

if (count($expert) > 0):
    ?>
    <div id="profileData">
        <?php
        $calcRating = 0;
        $list = "";
        if (count($rating) > 0) {
            $overAllRating = 0;
            $list = "<ul class='square-list'>";
            $totalProject = 0;
            for ($i = 0; $i < count($rating); $i++) {
                $calcRating = round(($rating[$i]->rating / $rating[$i]->countSurvey), 1);
                $list .= "<li style='color:grey' title='" . $calcRating . " out of 5 stars'><span style='color:#006699 !important;'>" . $rating[$i]->surveyName . "</span><br><span style='float:right;color:#004B91;font-size:11px;'>(<b>" . $rating[$i]->countSurvey . " customer feedbacks</b>)</span>";
                if ($calcRating > 0) {
                    if ($calcRating == 1) {
                        $class = "s_star_1_0";
                    } else if (($calcRating > 1 && $calcRating < 1.5) || ($calcRating > 1.5 && $calcRating < 2)) {
                        $class = "s_star_1_5";
                    } else if ($calcRating == 2) {
                        $class = "s_star_2_0";
                    } else if (($calcRating > 2 && $calcRating < 2.5) || ($calcRating > 2.5 && $calcRating < 3)) {
                        $class = "s_star_2_5";
                    } else if ($calcRating == 3) {
                        $class = "s_star_3_0";
                    } else if (($calcRating > 3 && $calcRating < 3.5) || ($calcRating > 3.5 && $calcRating < 4)) {
                        $class = "s_star_3_5";
                    } else if ($calcRating == 4) {
                        $class = "s_star_4_0";
                    } else if (($calcRating > 4 && $calcRating < 4.5) || ($calcRating > 4.5 && $calcRating < 5)) {
                        $class = "s_star_4_5";
                    } else if ($calcRating == 5) {
                        $class = "s_star_5_0";
                    }
                }
                $list .= '<span title="' . $calcRating . 'out of 5 stars" class="swSprite ' . $class . ' "><span>' . $calcRating . 'out of 5 stars</span></span></li>';
                $overAllRating = $overAllRating + $rating[$i]->rating;
                $totalProject = $totalProject + $rating[$i]->countSurvey;
            }
            $list .= "</ul>";
            $calcRating = round($overAllRating / $totalProject, 1);
        }
        ?>
        <?php
        $class = "";
        if ($calcRating > 0) {
            if ($calcRating == 1) {
                $class = "s_star_1_0";
            } else if (($calcRating > 1 && $calcRating < 1.5) || ($calcRating > 1.5 && $calcRating < 2)) {
                $class = "s_star_1_5";
            } else if ($calcRating == 2) {
                $class = "s_star_2_0";
            } else if (($calcRating > 2 && $calcRating < 2.5) || ($calcRating > 2.5 && $calcRating < 3)) {
                $class = "s_star_2_5";
            } else if ($calcRating == 3) {
                $class = "s_star_3_0";
            } else if (($calcRating > 3 && $calcRating < 3.5) || ($calcRating > 3.5 && $calcRating < 4)) {
                $class = "s_star_3_5";
            } else if ($calcRating == 4) {
                $class = "s_star_4_0";
            } else if (($calcRating > 4 && $calcRating < 4.5) || ($calcRating > 4.5 && $calcRating < 5)) {
                $class = "s_star_4_5";
            } else if ($calcRating == 5) {
                $class = "s_star_5_0";
            }
        } else {
            $class = "s_star_0_0";
        }
        ?>
        <?php
        jimport('joomla.html.pane');
        $tabs = & JPane::getInstance('tabs');
        echo $tabs->startPane("EditUsers");
        echo $tabs->startPanel("Profile", "expert-profile-tab");
        ?>

        <script src="<?php echo JUri::base(); ?>templates/survey/js/application.js"></script>
        <script>
            _sessionEXpertID = '<?php echo $sessionEXpertID; ?>';
        </script>
        <style>
            th.sortable {
                cursor: pointer;
                color: #1155CC !important;
            }

            th.sortable:hover {
                text-decoration: underline !important;
            }

            th.sorted-asc {
                color: #1155CC !important;
            }

            th.sorted-desc {
                color: #1155CC !important;
            }

            .profile_light_text {
                color: white;
            }

            .a_light{
                color: white;
            }

            .a_light:hover{
                color: yellow;
            }
			.toggle-editor{
				display:none;
				}
        </style>
 

        <?php
        if (!empty($getSession) && $getSession->id == JRequest::getInt('display')) {
            ?>
            <div class="row-fluid viewControl">
                <div class="span6">
                    <a href="javascript://" id="shoBTN" class='btn btn-large btn-flat  ' onclick="showUpdateBox(jQuery(this));">Edit
                        <span style="color: #f98933;">&raquo;</span></a>
                </div>
                <div class="span4 pull-right">
					<span class="span1" style='margin-right:3px;'><a href='javascript:window.print();'><img src="<?php echo JUri::base();?>components/com_survey/images/print_small.png" alt="Print" title="Print"/></a></span>
					
						<span class="rating displayI"> Customer Average Rating: </span>
						<span title="<?php echo $calcRating; ?> out of 5 stars" class="swSprite <?php echo $class; ?>"></span>
					
                </div>
            </div>
            <div class="row-fluid editControl" style='display:none'>
                <a href="javascript://"  class='btn btn-large btn-flat tM '
                   onclick="updateDescription(<?php echo $getSession->id; ?>)">Update <span  style="color: #f98933;">&raquo;</span></a>
                &nbsp;<a href="javascript://" class='btn btn-large btn-flat tM '  onclick="cancelDesc()">Cancel <span style="color: #f98933;">&raquo;</span></a>
            </div>
            <?php
        }
        ?>
        <div id="profile_edit_click" class="row-fluid" style="min-height:420px;">
            <div class="row-fluid span12 well well-small" style="background: #414e5e;padding:0px;">
                <div class="span2"></div>
				<div class="span4 profile_light_text" style='margin-left:10px;'>
                    <input id="profile_image_file_name" name="profile_image_file_name" type="hidden" value="<?php echo $expert->profile_image_file_name; ?>"/>
					<?php 
						if(empty($expert->text_data)):
					?>
                    <input id="profile_image_file_name" name="profile_image_file_name" type="hidden" value="<?php echo $expert->profile_image_file_name; ?>"/>
					<?php else:	?>
						<?php 
							$textData = json_decode($expert->text_data);
							if(!empty($textData->img)){
						?>
							<input id="profile_image_file_name" name="profile_image_file_name" type="hidden" value="<?php echo $textData->img; ?>"/>
						<?php
							} else {
						?>
							<input id="profile_image_file_name" name="profile_image_file_name" type="hidden" value=""/>
						<?php
							}
						?>
					<?php endif;?>

				   <?php 
                    if($expert->profile_image_file_name === null || $expert->profile_image_file_name === ""){
                    ?>
                    <img id="profile_image" 
                         src="<?php echo JUri::base() ?>components/com_survey/images/empty_image.png" style="height: 180px; width: 180px; background-color: white;">
                    <?php
                    }else{
                    ?>
                    <img id="profile_image" 
                         src="<?php echo JUri::base() ?>media/com_survey/profile_images/<?php echo $expert->profile_image_file_name; ?>"                    style="height: 180px; width: 180px; background-color: white;">
                    <?php 
                    }
                    ?>
                    <div class="editControl"  style='display:none'>
						<span class="span12">
							<label>Upload a photo (150x150px)</label>
							<input type="file" id="profileImage" name="profileImage" accept="image/*" title="Browse..." />
						</span>							
						<span class="span12" style='margin-top:10px;margin-left:0px;'><a href="javascript://" class='floatLeft btn btn-default' onclick="uploadProfileImage(<?php echo $getSession->id; ?>)">Upload</a></span>
                    </div>
                </div>
                <div class="span4 text-center profile_light_text">
					<div class="viewControl" style='margin-top:20px; width:320px;'>
						<p class="viewControl span12"  id="full_name" name="full_name" style='margin-bottom:0px;min-height:20px !important;'><?php echo $expert->name; ?></p>
						<p class="viewControl span12" id="company_name" name="company_name" style='margin-bottom:0px;min-height:20px !important;'><?php echo $expert->company_name; ?></p>
						<p class="viewControl span12" id="address" name="address" style='margin-bottom:0px;min-height:20px !important;'><?php echo $expert->address; ?></p>
						<p class="viewControl span12" id="city" name="city" style='margin-bottom:0px;min-height:20px !important;'><?php echo $expert->city; ?></p>
						<p class="viewControl span12" style='margin-bottom:0px;min-height:20px !important;'>
							<span class="span12" style='min-height:20px !important;' id="state" name="state"><?php echo $expert->state; ?><?php echo " ".$expert->zip; ?></span>							
						</p>						
						<p class="viewControl span12" style='margin-bottom:0px;min-height:20px !important;'>
							<span class="viewControl span5" id="phone" name="phone" style='min-height:20px !important;'>P: <?php echo $expert->phone; ?></span><span class="viewControl span1" style='min-height:20px !important;width:5px;margin-left:1px;margin-right:1px;'>|</span><span style='min-height:20px !important;' class="viewControl span6" id="email" name="phone">E: <a style='color:#fff;text-decoration:underline;' href="mailto:<?php echo $expert->email; ?>"><?php echo $expert->email; ?></a></span><br/>
						</p>
						<p class="viewControl span12" style='margin-bottom:0px;min-height:20px !important;' id="web" name="web">Web: <?php if(!empty($expert->web)):?><a style='color:#fff;text-decoration:underline;' href="http://<?php echo $expert->web; ?>" target="_BLANK"><?php echo $expert->web; ?><?php endif;?></a> </p>
					</div>
                    <?php 
						$firstName = "";
						$lastName ="";
						$companyName ="";
						$address ="";
						$city ="";
						$state ="";
						$zip ="";
						$country ="";
						$email ="";
						$phone ="";
						$web ="";
						if(empty($expert->text_data)){
							$firstName = $expert->first_name;
							$lastName = $expert->last_name;
							$companyName = $expert->company_name;
							$address = $expert->address;
							$city = $expert->city;
							$state = $expert->state;
							$zip = $expert->zip;
							$country = $expert->country;
							$email = $expert->email;
							$phone = $expert->phone;
							$web = $expert->web;
						} else {
							$textData = json_encode($expert->text_data);
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
						
						}
					?>
                    <div class="editControl" style='margin-top:20px;display:none'> 
                        <input type="text" name="first_nameEditor" id="first_nameEditor" value="<?php echo $expert->first_name; ?>" placeholder="First name"  class="span6"/>
                        <input type="text" name="last_nameEditor"  id="last_nameEditor"  value="<?php echo $expert->last_name; ?>"  placeholder="Last name"   class="span6"/>
                    </div>
                    
                    <div class="editControl" style='display:none'>
                        <input type="text" name="company_nameEditor" id="company_nameEditor"  value="<?php echo $expert->company_name; ?>" placeholder="Company name" class="span12"/>
                    </div>
                    
                    <div class="editControl" style='display:none'>
                        <input type="text" name="addressEditor" id="addressEditor" value="<?php echo $expert->address; ?>" placeholder="Street..."  class="span12"/>
                    </div>
                    
                    <div class="editControl" style='display:none'>>
                        <input type="text" name="cityEditor" id="cityEditor" value="<?php echo $expert->city; ?>"  placeholder="City"  class="span5"/>
                        <input type="text" name="stateEditor" id="stateEditor" value="<?php echo $expert->state; ?>"  placeholder="State"  class="span4"/>
                        <input type="text" name="zipEditor" id="zipEditor" value="<?php echo $expert->zip; ?>"  placeholder="zip/postal code" class="span3"/>
                    </div>
                    <div class="editControl" style='display:none'>
                        <input type="text" name="countryEditor" id="countryEditor" value="<?php echo $expert->country; ?>"  placeholder="Country"   class="span12"/>
                    </div>
					<div class="editControl" style='display:none'>
                        <input type="text" name="emailEditor" id="emailEditor" value="<?php echo $expert->email; ?>"  placeholder="Email Address"   class="span12"/>
                    </div>
                    <div class="editControl" style='display:none'>
                        <input type="text" name="phoneEditor"  id="phoneEditor" value="<?php echo $expert->phone; ?>"placeholder="Phone Number"  class="span6"/>
						<input type="text" name="webEditor"  id="webEditor" value="<?php echo $expert->web; ?>"placeholder="Website Address"  class="span6"/>
                    </div>
                </div>
            </div>

            <div class="row-fluid">
                <div class="span10 offset1">
                    <h4 class="text-info">INTRODUCTION</h4>
                    <div id="description" class="viewControl"><?php echo $expert->description; ?></div>
                    <div class="editControl" style='display:none'>
                        <?php
							$editorDescription = JFactory::getEditor();
							$descriptionData = "";
							if(empty($expert->text_data)){
								$descriptionData = $expert->description;
							} else {
								$textData = json_decode($expert->text_data);
								$descriptionData = (isset($textData->expl))?$textData->expl:''; 
							}
							echo $editorDescription->display('descriptionEditor', $descriptionData, '100%', '200', '60', '10', false);
                        ?>
                    </div>
                    <br/>
                </div>
            </div>
            <div class="row-fluid">
                <div class="span10 offset1">
                    <h4 class="text-info">AREAS OF EXPERTISE</h4>
                    <div id="areas_of_expertise" class="viewControl">
						<?php
							$standardGroup = explode(',', $expert->areas_of_expertise) ;
							
							if(is_array($standardGroup) && count($standardGroup)>0){
						?>
							<table class="table">
						<?php
							$standardText = "";
								for($m=0;$m<count($standardGroup);$m++){
									if($m>0 && $m%2==0){
										$standardText .= "</tr>";
									}
									if($m==0 || $m%2==0){
										$standardText .= "<tr>";
									}
									$standardText .= "<td>".$standardGroup[$m]."</td>";
									if($m==count($standardGroup)-1){
										$standardText .= "</tr>";
									}
								}
							echo $standardText;
						?>
							</table>
						<?php
							}
						?>
					</div>
                    <div class="editControl" style='display:none'>
                        <?php
							$editorAreas_of_expertiseitorText = "";
							if(empty($expert->text_data)){
								$editorAreas_of_expertiseitorText = $expert->areas_of_expertise;
							} else {
								$textData = json_decode($expert->text_data);
								$editorAreas_of_expertiseitorText = (isset($textData->ae))?$textData->ae:''; 
							}
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
										<input name="editor_area_expertise_text[]" class="span12" value="<?php echo $editorAreas_of_expertiseitorText0;?>"/>
									</td>
									<td>
										<input name="editor_area_expertise_text[]" class="span12" value="<?php echo $editorAreas_of_expertiseitorText1;?>"/>
									</td>
								</tr>
								<tr>
									<td>
										<input name="editor_area_expertise_text[]" class="span12" value="<?php echo $editorAreas_of_expertiseitorText2;?>"/>
									</td>
									<td>
										<input name="editor_area_expertise_text[]" class="span12" value="<?php echo $editorAreas_of_expertiseitorText3;?>"/>
									</td>
								</tr>
								<tr>
									<td>
										<input name="editor_area_expertise_text[]" class="span12" value="<?php echo $editorAreas_of_expertiseitorText4;?>"/>
									</td>
									<td>
										<input name="editor_area_expertise_text[]" class="span12" value="<?php echo $editorAreas_of_expertiseitorText5;?>"/>
									</td>
								</tr>
								<tr>
									<td>
										<input name="editor_area_expertise_text[]" class="span12" value="<?php echo $editorAreas_of_expertiseitorText6;?>"/>
									</td>
									<td>
										<input name="editor_area_expertise_text[]" class="span12" value="<?php echo $editorAreas_of_expertiseitorText7;?>"/>
									</td>
								</tr>
							</tbody>
						</table>
                    </div>
                    <br/>
                </div>
            </div>
            <div class="row-fluid">
                <div class="span10 offset1">
                    <h4 class="text-info">MEMBERSHIPS</h4>
                    <div id="membership" class="viewControl">
						
						<?php
							$standardGroup = explode(',', $expert->membership) ;
							if(is_array($standardGroup) && count($standardGroup)>0){
						?>
							<table class="table">
						<?php
							$standardText = "";
								for($m=0;$m<count($standardGroup);$m++){
									if($m>0 && $m%2==0){
										$standardText .= "</tr>";
									}
									if($m==0 || $m%2==0){
										$standardText .= "<tr>";
									}
									$standardText .= "<td>".$standardGroup[$m]."</td>";
									if($m==count($standardGroup)-1){
										$standardText .= "</tr>";
									}
								}
							echo $standardText;
						?>
							</table>
						<?php
							}
						?>
					</div>
                    <div class="editControl" style='display:none'>
                        <?php							
							$editorMembershipText = "";
							if(empty($expert->text_data)){
								$editorMembershipText = $expert->membership;
							} else {
								$textData = json_decode($expert->text_data);
								$editorMembershipText = (isset($textData->me))?$textData->me:''; 
							}
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
										<input name="area_membership_text[]" class="span12" value="<?php echo $editorMembershipText0;?>"/>
									</td>
									<td>
										<input name="area_membership_text[]" class="span12" value="<?php echo $editorMembershipText1;?>"/>
									</td>
								</tr>
								<tr>
									<td>
										<input name="area_membership_text[]" class="span12" value="<?php echo $editorMembershipText2;?>"/>
									</td>
									<td>
										<input name="area_membership_text[]" class="span12" value="<?php echo $editorMembershipText3;?>"/>
									</td>
								</tr>
								<tr>
									<td>
										<input name="area_membership_text[]" class="span12" value="<?php echo $editorMembershipText4;?>"/>
									</td>
									<td>
										<input name="area_membership_text[]" class="span12" value="<?php echo $editorMembershipText5;?>"/>
									</td>
								</tr>								
							</tbody>
						</table>
                    </div>
                    <br/>
                </div>
            </div>
            <div class="row-fluid">
                <div class="span10 offset1">
                    <h4 class="text-info">STANDARDS GROUPS</h4>
                    <div id="standards_groups" class="viewControl">
						<?php
							$standardGroup = explode(',', $expert->standards_groups) ;
							if(is_array($standardGroup) && count($standardGroup)>0){
						?>
							<table class="table">
						<?php
							$standardText = "";
								for($m=0;$m<count($standardGroup);$m++){
									if($m>0 && $m%2==0){
										$standardText .= "</tr>";
									}
									if($m==0 || $m%2==0){
										$standardText .= "<tr>";
									}
									$standardText .= "<td>".$standardGroup[$m]."</td>";
									if($m==count($standardGroup)-1){
										$standardText .= "</tr>";
									}
								}
							echo $standardText;
						?>
							</table>
						<?php
							}
						?>
					
					</div>
                    <div class="editControl" style='display:none'>
                        <?php							
							$editorStandards_groupsText = "";
							if(empty($expert->text_data)){
								$editorStandards_groupsText = $expert->standards_groups;
							} else {
								$textData = json_decode($expert->text_data);
								$editorStandards_groupsText = (isset($textData->sg))?$textData->sg:''; 
							}
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
										<input name="area_standardgroup_text[]" class="span12" value="<?php echo $editorStandards_groupsText0;?>"/>
									</td>
									<td>
										<input name="area_standardgroup_text[]" class="span12" value="<?php echo $editorStandards_groupsText1;?>"/>
									</td>
								</tr>
								<tr>
									<td>
										<input name="area_standardgroup_text[]" class="span12" value="<?php echo $editorStandards_groupsText2;?>"/>
									</td>
									<td>
										<input name="area_standardgroup_text[]" class="span12" value="<?php echo $editorStandards_groupsText3;?>"/>
									</td>
								</tr>
								<tr>
									<td>
										<input name="area_standardgroup_text[]" class="span12" value="<?php echo $editorStandards_groupsText4;?>"/>
									</td>
									<td>
										<input name="area_standardgroup_text[]" class="span12" value="<?php echo $editorStandards_groupsText5;?>"/>
									</td>
								</tr>								
							</tbody>
						</table>
						
                    </div>
                    <br/>
                </div>
            </div>
            <div class="row-fluid">
                <div class="span10 offset1">
                    <h4 class="text-info">CV/RESUMES</h4>
					<?php 
						if(empty($expert->text_data)):
					?>
                    <input id="profile_resume_file_name" name="profile_resume_file_name" type="hidden" value="<?php echo $expert->cv; ?>"/>
					<?php else:	?>
						<?php 
							$textData = json_decode($expert->text_data);
							if(!empty($textData->cv)){
						?>
							<input id="profile_resume_file_name" name="profile_resume_file_name" type="hidden" value="<?php echo $textData->cv; ?>"/>
						<?php
							} else {
						?>
							<input id="profile_resume_file_name" name="profile_resume_file_name" type="hidden" value=""/>
						<?php
							}
						?>
					<?php endif;?>
                    <div class="editControl"  style='display:none'>
                        <label>Upload a resume/CV</label>
                        <input type="file" id="profileResume" name="profileResume" accept=".pdf,.doc,.docx,.rtf" title="Browse..." />
                        <a href="javascript://" class='btn btn-large btn-flat  ' onclick="uploadProfileResume(<?php echo $getSession->id; ?>)">Upload <span style="color: #f98933;">&raquo;</span></a>
                    </div>
                </div>
            </div>
            <?php
            if (!empty($getSession) && $getSession->id == JRequest::getInt('display')) {
                ?>
                <div class="row-fluid viewControl" >
                    <a href="javascript://" id="shoBTN" class='btn btn-large btn-flat  ' onclick="showUpdateBox(jQuery(this));">Edit
                        <span style="color: #f98933;">&raquo;</span></a>
                </div>
                <div class="row-fluid editControl" style='margin-top:10px;display:none;'>
                    <a href="javascript://" class='btn btn-large btn-flat tM '  onclick="updateDescription(<?php echo $getSession->id; ?>)">Update <span style="color: #f98933;">&raquo;</span></a>
                    &nbsp;<a href="javascript://" class='btn btn-large btn-flat tM ' onclick="cancelDesc()">Cancel <span style="color: #f98933;">&raquo;</span></a>
					<div class="editControl floatRight" style='display:none' >
					<input type="hidden" name="publish_data" id="publish_data" value="0"/>
						Click here when ready to <a href="javascript://" class='btn btn-large btn-flat  '  onclick="updatePublish(<?php echo $getSession->id; ?>)">Publish <span style="color: #f98933;">&raquo;</span></a>
                    
					</div> 
                </div>
				
                <?php
            }
            ?>
        </div>

        <!-- END - VIEW PROFILE -->
        <!-- START - EDIT PROFILE FORM -->

        <?php
        if (!empty($getSession) && $getSession->id == JRequest::getInt('display')) {
            ?>
            <div id="showUpdateBox" style='display:none;margin-top:20px;'>

                <h4 class="text-info">
                    Change Password (Optional)
                </h4>
                <div class="form-horizontal-1">
                    <div class="control-group">
                        <div class="controls">
                            <input type="password" name="current_password" class="span6" id="current_password" value=""
                                   placeholder="Current Password"/>
                        </div>
                    </div>
                </div>
                <div class="form-horizontal-1">
                    <div class="control-group">
                        <div class="controls">
                            <input type="password" name="new_password" class="span6" id="new_password" value=""
                                   placeholder="New Password"/>
                        </div>
                    </div>
                </div>
			</div>
                <?php
            }
            ?>
		
            <!-- START - EDIT PROFILE FORM -->

            <script>

                jQuery(document).ready(function() {
                    cancelDesc();
                });

                /*
                 * uploadResume
                 * uses ajax to upload profile cv/resume file
                 * and present it in the view onsuccess
                 * or present an error if failed.
                 */
                 ___data = 
                function uploadProfileResume(profile_id) {
                    var id = profile_id;
                    //debugger;
                    var aFormData = new FormData();

                    aFormData.append("profileResume", $('#profileResume').get(0).files[0]);
                    aFormData.append("profileId", id);

                    $.ajax(
                            {
                                url: 'index.php?option=com_survey&task=customer.uploadProfileResume',
                                type: "POST",
                                contentType: false,
                                processData: false,
                                data: aFormData,
                                dataType: "json",
                                success: function(data) {
                                    //debugger;
                                    ___data = data;
                                    if (data.status === true) {
                                        var filename = data.filename;
                                        jQuery('#profile_resume_file_name').attr('value', filename);
                                        jQuery('#profile_resume').attr('href', '<?php echo JUri::base() ?>media/com_survey/profile_resumes/' + filename);
                                        jQuery('#profileResume').attr('value', '');
                                        jQuery('#profile_resume_wrapper').slideDown('slow', function() {
                                        });
                                    }
                                    else {
                                        alert("CV/Resume upload - FAILED.");
                                    }
                                },
                                error: function(error) {
                                    alert("Error uploading CV/Resume.");
                                    console.log(error);
                                }
                            }
                    );

                }

                /*
                 * uploadProfileImage
                 * uses ajax to upload profile image
                 * and present it in the view onsuccess
                 * or present an error if failed.
                 */
                function uploadProfileImage(profile_id) {
                    var id = profile_id;
                    //debugger;
                    var aFormData = new FormData();

                    aFormData.append("profileImage", $('#profileImage').get(0).files[0]);
                    aFormData.append("profileId", id);

                    $.ajax(
                            {
                                url: 'index.php?option=com_survey&task=customer.uploadProfileImage',
                                type: "POST",
                                contentType: false,
                                processData: false,
                                data: aFormData,
                                dataType: "json",
                                success: function(data) {
                                    //debugger;
                                    ___data = data;
                                    if (data.status === true) {
                                        var filename = data.filename;
                                        jQuery('#profile_image_file_name').attr('value', filename);
                                        jQuery('#profile_image').attr('src', '<?php echo JUri::base() ?>media/com_survey/profile_images/' + filename);
                                        jQuery('#profileImage').attr('value', '');                                        
                                        jQuery('#profile_image').slideDown('slow', function() {
                                        });
                                    }
                                    else {
                                        alert("Image upload - FAILED.");
                                    }
                                },
                                error: function(error) {
                                    alert("Error uploading image.");
                                    console.log(error);
                                }
                            }
                    );

                }
				
				function updatePublish(e){
					jQuery("#publish_data").val(1);
					updateDescription(e)
				}
				
                function updateDescription(e) {   
                <?php
    echo $editorDescription->save('descriptionEditor');
	?>
					//if (desc != "") {
					
					/*_intro = descriptionEditor.value;*/
					_intro = parseInt(jQuery("#descriptionEditor-word-count").html());
					//_characterWord = _intro.split(' ');
					if(_intro<=200){
                    jQuery.ajax({
                        url: 'index.php?option=com_survey&task=customer.updateDesc',
                        type: 'POST',
                        data: {
                            d: e,
                            expl: descriptionEditor.value,
                            f: jQuery("#first_nameEditor").val(),
                            l: jQuery("#last_nameEditor").val(),
                            c: jQuery("#company_nameEditor").val(),
                            p: jQuery("#phoneEditor").val(),
                            em: jQuery("#emailEditor").val(),
                            w: jQuery("#webEditor").val(),
                            a: jQuery("#addressEditor").val(),
                            s: jQuery("#skype_name").val(),
                            de: jQuery("#degree").val(),
                            h: jQuery("#hourly_rate").val(),
                            pp: jQuery("#paypal_id").val(),
                            cu: jQuery("#current_password").val(),
                            pa: jQuery("#new_password").val(),
                            co: jQuery("#countryEditor").val(),
                            st: jQuery("#stateEditor").val(),
                            ci: jQuery("#cityEditor").val(),
                            zi: jQuery("#zipEditor").val(),
                            me: jQuery( "input[name='area_membership_text[]']" ).serializeArray(),
                            ae: jQuery( "input[name='editor_area_expertise_text[]']" ).serializeArray(),
                            sg: jQuery( "input[name='area_standardgroup_text[]']" ).serializeArray(),
                            cv: jQuery("#profile_resume_file_name").val(),
                            img: jQuery('#profile_image_file_name').val(),
							pub:jQuery('#publish_data').val(),
                            format: ''},
                        success: function(data) {
                            if (parseInt(data) > 0) {
                                //window.location = window.location.href;
                                //debugger;
								/*
                                jQuery("#full_name").html(first_nameEditor.value + ' ' + last_nameEditor.value);
                                jQuery("#company_name").html(company_nameEditor.value);
                                jQuery("#address").html(addressEditor.value);
                                jQuery("#city").html(cityEditor.value);
                                jQuery("#state").html(stateEditor.value+" "+zipEditor.value);*/
                                /*jQuery("#zip").html(zipEditor.value);*/
								/*
                                jQuery("#country").html(countryEditor.value);
                                jQuery("#phone").html("P:"+phoneEditor.value);
                                jQuery("#email").html("E:"+emailEditor.value);
                                jQuery("#web").html("Web:"+webEditor.value);
                                jQuery("#description").html(descriptionEditor.value);
								__memberShipArea = "<table>";
								for(m=0;m<jQuery( "input[name='area_membership_text[]']" ).length;m++){
									___areaMembership = jQuery( "input[name='area_membership_text[]']" ).eq(m);
									if(m>0&& m%2==0){
										__memberShipArea += "</tr>";
									}
									if(m==0 || m%2==0){
										__memberShipArea += "<tr>";
									}
									__memberShipArea += "<td>"+___areaMembership.val()+"</td>";
									if(m==jQuery( "input[name='area_membership_text[]']" ).length-1){
										__memberShipArea += "</tr>";
									}
								}
								__memberShipArea += "</table>";
								jQuery("#membership").html(__memberShipArea);
								__memberShipArea = "<table>";
								for(m=0;m<jQuery( "input[name='editor_area_expertise_text[]']" ).length;m++){
									___areaMembership = jQuery( "input[name='editor_area_expertise_text[]']" ).eq(m);
									if(m>0&& m%2==0){
										__memberShipArea += "</tr>";
									}
									if(m==0 || m%2==0){
										__memberShipArea += "<tr>";
									}
									__memberShipArea += "<td>"+___areaMembership.val()+"</td>";
									if(m==jQuery( "input[name='editor_area_expertise_text[]']" ).length-1){
										__memberShipArea += "</tr>";
									}
								}
								__memberShipArea += "</table>";
								jQuery("#areas_of_expertise").html(__memberShipArea);
								jQuery("#membership").html(__memberShipArea);
								__memberShipArea = "<table>";
								for(m=0;m<jQuery( "input[name='area_standardgroup_text[]']" ).length;m++){
									___areaMembership = jQuery( "input[name='area_standardgroup_text[]']" ).eq(m);
									if(m>0&& m%2==0){
										__memberShipArea += "</tr>";
									}
									if(m==0 || m%2==0){
										__memberShipArea += "<tr>";
									}
									__memberShipArea += "<td>"+___areaMembership.val()+"</td>";
									if(m==jQuery( "input[name='area_standardgroup_text[]']" ).length-1){
										__memberShipArea += "</tr>";
									}
								}
								__memberShipArea += "</table>";
								jQuery("#standards_groups").html(__memberShipArea);	
								*/								
                                cancelDesc();
                            } 
                        }
                    });
					} else {
						 alert('Please enter introduction word length upto 700.');
					}
                    //} else {
                    //    alert('Please enter description');
                    //}
                }
                function cancelDesc() {
                    jQuery("#showUpdateBox").css('display', 'none');
                    jQuery("#profile_edit_click").css('min-height', '420px');
                    //jQuery("#description").css('display', 'block');
                    jQuery("#shoBTN").css('display', '');
                    jQuery(".viewControl").css('display', 'block');
                    jQuery(".editControl").css('display', 'none');
                    scrollToTop();
                }
                function scrollToTop() {
                    jQuery("html, body").animate({'scrollTop': 0}, 1000);
                }

                function showUpdateBox(object) {
                    if (_sessionEXpertID === null || _sessionEXpertID === "0") {
                        alert('You do not have permission to perform this action.');
                        return;
                    }
                    object.hide();
                    jQuery("#profile_edit_click").css('min-height', '1050px');
                    //jQuery("#description").css('display', 'none');
                    jQuery("#showUpdateBox").css('display', 'block');

                    jQuery(".viewControl").css('display', 'none');
                    jQuery(".editControl").css('display', 'block');
                    tinyMCEOBJECTFUN();
                }

            </script>
            <?php
            echo $tabs->endPanel();
            echo $tabs->startPanel("Feedback", "expert-feedback-tab");
            ?>
            <div class="row-fluid">
                <div class="span12">
                    <?php
                    $getExpertFeedback = SurveyModelCustomer::expertRatingDataDetail(JRequest::getInt('display'));
                    if (count($getExpertFeedback) > 0) {
                        ?>
                        <ul class="nav nav-stacked">
                            <?php
                            for ($r = 0; $r < count($getExpertFeedback); $r++) {
                                $class = 's_star_' . $getExpertFeedback[$r]->rating . '_0';
                                ?>
                                <li>
                                    <div class="media xRound" style="margin:20px 0; border:1px solid #ccc; padding:10px;">
                                        <span title="<?php echo $getExpertFeedback[$r]->rating; ?> out of 5 stars"
                                              class="pull-left swSprite <?php echo $class; ?>"></span>

                                        <div class="media-body">
                                            <h4 class="media-heading"><?php echo $getExpertFeedback[$r]->surveyName; ?></h4>

                                            <small><?php
														echo date('M d,Y H:i', strtotime($getExpertFeedback[$r]->created_date));
													?>
											</small>
                                            <p><?php echo $getExpertFeedback[$r]->feedback; ?></p>
                                        </div>
                                    </div>
                                </li>
                                <?php
                            }
                            ?>
                        </ul>
                        <?php
                    } else {
                        ?>
                        <div class="displayB" style="min-height:100px;">
                            <p class="alert alert-info">No feedback history for this expert!</p>
                        </div>
                        <?php
                    }
                    ?>
                </div>
            </div>
            <?php
            echo $tabs->endPanel();
            echo $tabs->startPanel("My Report", "expert-report-tab");
            ?>

            <style>
                .loader, .loader1 {
                    display: none;
                    margin: 0 auto;
                    width: 50px;
                    height: 50px;
                }

                table.result-table tr td {
                    /*padding:10px !important;*/
                }

                .nav-tabs > li > a {
                    padding-left: 10px !important;
                    padding-right: 10px !important;
                }

                .nav > li > a:hover, .nav > li > a:focus, #projectList li a.button-link:hover {
                    background: none !important;
                }

                #questionlist thead tr th, #expertList tbody tr td {
                    border-top: 0px !important;
                }

                #surveylist {
                    margin-top: 15px !important;
                }

                .nav-tabs.nav-stacked > li a.active {
                    color: red !important;
                    background: none !important;
                }
            </style>
            <div class="row-fluid">

                <?php
                $expertReports = SurveyModelCustomer::getExpertReportsWithProject(JRequest::getInt('display'));
                if (count($expertReports) > 0) {
                    ?>
                    <div class="span2" style="width:65px;margin-left: 0px;">
                        <legend style="font-size:14px; font-weight:bold; color:#005580; border:none; white-space:nowrap;"
                                class="noMargin">Project
                        </legend>
                        <ul id="projectList" class="nav nav-tabs nav-stacked noMargin"
                            style="margin-left:-10px !important;margin-top:15px !important">

        <?php for ($i = 0; $i < count($expertReports); $i++) { ?>
                                <li>
                                    <a href='javascript://' class="button-link" data-url=""
                                       onclick="cData(jQuery(this),<?php echo $expertReports[$i]->pID ?>,<?php echo JRequest::getInt('display'); ?>);"><?php echo $expertReports[$i]->projectName; ?></a>
                                </li>
        <?php } ?>
                        </ul>
                    </div>

                    <div class="span2" style=" margin-left:0px; width:124px;">
                        <div id="survey" style="margin-left:-10px !important;">
                            <div class="loader">
                                <img src="<?php echo JUri::base(); ?>components/com_survey/images/loader.gif"/>
                            </div>
                        </div>
                    </div>
                    <div class="span8" style='margin-left: -13px; width: 742px;'>
                        <div class="row-fluid" id="question">
                            <div class="loader1">
                                <img src="<?php echo JUri::base(); ?>components/com_survey/images/loader.gif"/>
                            </div>
                        </div>
                    </div>
                    <?php
                } else {
                    ?>
                    <div class="displayB" style="min-height:100px;">
                        <p class="alert alert-info">No report submit by this expert.</p>
                    </div>

                    <?php
                }
                ?>
            </div>

            <script>
                _siteURL = '<?php echo JUri::base(); ?>';

                function cData(object, pID, expertID) {
                    object.addClass('active');
                    jQuery("#question").find('div.span8').remove();
                    jQuery("#question").find('div.span4').remove();
                    jQuery("#expertList").remove();
                    if (pID !== "") {
                        jQuery("#surveylist").remove();
                        jQuery("#survey").find('legend').remove();
                        jQuery(".loader").before('<legend class="noMargin" style="font-size: 14px; font-weight: bold; color: rgb(0, 85, 128); border: medium none; white-space: nowrap; padding-left: 10px;">Claim</legend>');
                        jQuery('.loader').css('display', 'block');
                        jQuery.ajax({
                            url: _siteURL + 'index.php?option=com_survey&task=customer.expertClaim',
                            data: {p: pID, f: expertID, format: ''},
                            cache: false,
                            success: function(html) {
                                __data = jQuery.parseJSON(html);
                                jQuery("#surveylist").remove();
                                _HTML = jQuery('<ul/>').attr('id', 'surveylist').addClass('nav nav-tabs nav-stacked noMargin');
                                if (__data.length > 0) {
                                    for (i = 0; i < __data.length; i++) {
                                        _LI = jQuery('<li/>').data('surveyID', __data[i].id).click(
                                                function() {
                                                    qu(jQuery(this), jQuery(this).data('surveyID'), <?php echo JRequest::getInt('display'); ?>);
                                                }).append('<a style="width: 102px;" class="button-link" href="javascript://">' + __data[i].combine_name + '</a>');
                                        jQuery(_HTML).append(_LI);
                                    }
                                } else {
                                    jQuery(_HTML).append("<li>No record found</li>");
                                }
                                jQuery("#survey").append(_HTML);
                                jQuery('.loader').css('display', 'none');
                            }
                        });
                    }
                }

                function qu(object, su, expertID) {
                    __PPURL = "https://www.sandbox.paypal.com/cgi-bin/webscr?cmd=_xclick&notify_version=2.9&business=";
                    __SU = parseInt(su);
                    jQuery("#surveylist li a").removeClass('active');
                    object.find('a').addClass('active');
                    if (__SU != 0 && __SU != 'NAN' && __SU != 'NAN') {

                        jQuery("#questionlist").parent().remove();
                        jQuery("#questionlist").remove();
                        jQuery("#expertList").parent().remove();
                        jQuery("#expertList").remove();
                        jQuery('.loader1').css('display', 'block');
                        jQuery.ajax({
                            url: _siteURL + 'index.php?option=com_survey&task=customer.quListExpert',
                            data: {ps: __SU, f: expertID, format: ''},
                            cache: false,
                            success: function(html) {
                                __data = jQuery.parseJSON(html);
                                jQuery("#questionlist").remove();
                                jQuery("#expertList").remove();
                                __GRID2Div = jQuery('<div/>').addClass('span8').css({marginLeft: '10px'});
                                __GRID5Div = jQuery('<div/>').addClass('grid_6 alpha omega');
                                __LegendGrid2 = jQuery('<legend/>').addClass('noMargin').append('Elements').css({height: '53px', fontSize: '14px', fontWeight: 'bold', color: '#005580', whiteSpace: 'wrap'});
                                jQuery(__GRID2Div).append(__LegendGrid2);
                                _HTML = jQuery('<table/>').attr('id', 'questionlist').addClass('table');
                                __ETable = jQuery("<table/>").attr('id', 'expertList').addClass('table result-table').css('background', 'none').css('margin-top', '4px');
                                __GRID10Div = jQuery('<div/>').addClass('span4').css({overflowX: 'scroll', margin: '0'});
                                __GRID7Div = jQuery('<div/>').addClass('grid_6').css({overflowX: 'scroll', margin: '0'});
                                if (__data['question'].length > 0) {
                                    for (i = 0; i < __data['question'].length; i++) {
                                        _QueThread = jQuery("<thead/>");
                                        if (i == (__data['question'].length - 1)) {
                                            _MAINTR = jQuery("<tr/>").css({borderBottom: '0px !important'}).data('quData', __data['question'][i]);
                                        } else {
                                            _MAINTR = jQuery("<tr/>").css({borderBottom: '0px !important'}).data('quData', __data['question'][i]);
                                        }
                                        _TH = jQuery("<th/>").css({borderBottom: '0px !important'}).append(__data['question'][i]['data'].description);
                                        jQuery(_MAINTR).append(_TH);
                                        jQuery(_QueThread).append(_MAINTR);
                                        jQuery(_HTML).append(_QueThread);
                                        if (i == 0) {

                                            _Thead = jQuery("<thead/>");
                                            _TR = jQuery("<tr/>");
                                            for (s = 0; s < __data['expert'].length; s++) {
                                                if (__data['expert'][s].linkedin_profile_url == "") {
                                                    jQuery(_TR).append("<th valign='top' class='" + __data['expert'][s].id + "' style='text-align:center;height:33px;border-bottom:1px solid #E5E5E5 !important;'>" + __data['expert'][s].name + "</th>");
                                                } else {
                                                    jQuery(_TR).append("<th valign='top' class='" + __data['expert'][s].id + "' style='text-align:center;height:33px;border-bottom:1px solid #E5E5E5 !important'><a target='_BLANK' href='" + _siteURL + "index.php?option=com_survey&task=customer.expertProfile&display=" + __data['expert'][s].id + "'>" + __data['expert'][s].name + "</a></th>");
                                                }

                                                jQuery.ajax({
                                                    url: _siteURL + 'index.php?option=com_survey&task=customer.showExpertRating',
                                                    data: {expert_id: __data['expert'][s].id, format: ''},
                                                    type: 'POST',
                                                    cache: false,
                                                    success: function(html) {
                                                        _ratingData = jQuery.parseJSON(html);
                                                        if (_ratingData.data.length) {
                                                            expertID = 0;
                                                            totalProject = 0;
                                                            totalRate = 0;
                                                            for (r = 0; r < _ratingData.data.length; r++) {
                                                                if (r == 0) {
                                                                    expertID = _ratingData.data[r].id;
                                                                }
                                                                totalProject = totalProject + _ratingData.data[r].countSurvey;
                                                                totalRate = totalRate + _ratingData.data[r].rating;
                                                            }

                                                            if (totalProject > 0 && totalRate > 0) {
                                                                $calcRating = totalRate / totalProject;
                                                                if ($calcRating == 1) {
                                                                    $class = "s_star_1_0";
                                                                } else if (($calcRating > 1 && $calcRating < 1.5) || ($calcRating > 1.5 && $calcRating < 2)) {
                                                                    $class = "s_star_1_5";
                                                                } else if ($calcRating == 2) {
                                                                    $class = "s_star_2_0";
                                                                } else if (($calcRating > 2 && $calcRating < 2.5) || ($calcRating > 2.5 && $calcRating < 3)) {
                                                                    $class = "s_star_2_5";
                                                                } else if ($calcRating == 3) {
                                                                    $class = "s_star_3_0";
                                                                } else if (($calcRating > 3 && $calcRating < 3.5) || ($calcRating > 3.5 && $calcRating < 4)) {
                                                                    $class = "s_star_3_5";
                                                                } else if ($calcRating == 4) {
                                                                    $class = "s_star_4_0";
                                                                } else if (($calcRating > 4 && $calcRating < 4.5) || ($calcRating > 4.5 && $calcRating < 5)) {
                                                                    $class = "s_star_4_5";
                                                                } else if ($calcRating == 5) {
                                                                    $class = "s_star_5_0";
                                                                }
                                                                if (jQuery("." + expertID).find('.swSprite').length == 0) {
                                                                    jQuery("." + expertID).append('<br/><span title="' + $calcRating + ' out of 5 stars" class="swSprite ' + $class + '"></span>');
                                                                }
                                                            } else {
                                                                _class = "s_star_0_0";
                                                                if (jQuery("." + expertID).find('.swSprite').length == 0) {
                                                                    jQuery("." + expertID).append('<br/><span title="0 out of 5 stars" class="swSprite ' + _class + '"></span>');
                                                                }
                                                            }
                                                        } else {
                                                            _class = "s_star_0_0";
                                                            if (jQuery("." + _ratingData.id).find('.swSprite').length == 0) {
                                                                jQuery("." + _ratingData.id).append('<br/><span title="0 out of 5 stars" class="swSprite ' + _class + '"></span>');
                                                            }
                                                        }
                                                    }
                                                });
                                            }
                                            jQuery(_Thead).append(_TR);
                                            jQuery(__ETable).append(_Thead);
                                        }
                                        __TR = jQuery("<tr/>");
                                        for (s = 0; s < __data['expert'].length; s++) {
                                            if (__data['question'][i]['answer'].length > 0) {
                                                __parseFlag = 0;
                                                __DipTo = 0;
                                                for (an = 0; an < __data['question'][i]['answer'].length; an++) {
                                                    if (__DipTo == 0) {
                                                        if (__data['expert'][s].id == __data['question'][i]['answer'][an].expert_id) {
                                                            __DipTo = 1;
                                                            if (__data['question'][i]['answer'][an].status == 1) {
                                                                _TD = jQuery("<td/>").addClass('aCenter').append('<i class="icon-ok aCenter"> </i>');
                                                            } else {
                                                                _TD = jQuery("<td/>").addClass('aCenter');
                                                            }
                                                            __parseFlag = 1;
                                                        }
                                                    }
                                                    jQuery(__TR).append(_TD);
                                                }
                                                if (__parseFlag == 0) {
                                                    _TD = jQuery("<td/>").append("");
                                                    jQuery(__TR).append(_TD);
                                                }
                                            } else {
                                                _TD = jQuery("<td/>").append("");
                                                jQuery(__TR).append(_TD);
                                            }
                                        }
                                        jQuery(__ETable).append(__TR);
                                    }

                                    __TR = jQuery("<tr/>");
                                    if (__data['survey'].length > 0) {
                                        for (s = 0; s < __data['expert'].length; s++) {
                                            __DIP2 = 0;
                                            for (am = 0; am < __data['survey'].length; am++) {
                                                if (__DIP2 == 0) {
                                                    if ((__data['expert'][s].id == __data['survey'][am].expert_id) && (__data['expert'][s].target == __data['survey'][am].target)) {
                                                        __DIP2 = 1;
                                                        __SUR = __data['survey'][am].survey_id;
                                                        __EXP = __data['survey'][am].expert_id;
                                                        _TD = jQuery("<td/>").css('background', 'none').addClass('aCenter').data('expertAmount', __data['survey'][am].amount).append('<span >' + __data['survey'][am].target + '</span><br/><span >$' + __data['survey'][am].amount + '</span><br/>');
                                                        if (_sessionEXpertID == 0) {
                                                            __A = jQuery("<a/>").addClass('btn btn-danger').attr('data-target', __data['survey'][am].target).data('expertEmail', __data['expert'][s].paypal_id).click(function() {
                                                                _TTHISS = jQuery(this);
                                                                _TTHISS.attr('disabled', true);
                                                                __cEM = jQuery(this).data('expertEmail');
                                                                __target = jQuery(this).attr('data-target');
                                                                __amTT = jQuery(this).parent().data('expertAmount');
                                                                jQuery.ajax({
                                                                    url: _siteURL + 'index.php?option=com_survey&task=customer.transaction',
                                                                    data: {amt: __amTT, su: __SUR, ex: __EXP, target: __target, format: ''},
                                                                    cache: false,
                                                                    success: function(data) {
                                                                        if (data > 0) {
                                                                            __ram = data;
                                                                            __PPURL = __PPURL + __cEM + "&lc=US&item_name=Survey Purchase&amount=" + __amTT + "&currency_code=USD&item_number=" + __ram + "&notify_url=<?php echo urlencode(JUri::base() . 'index.php?option=com_survey&task=customer.notify&raw='); ?>" + __ram + "&return=<?php echo urlencode(JUri::base() . 'index.php?option=com_survey&task=customer.success&raw='); ?>" + __ram + "&cancel=<?php echo urlencode(JUri::base() . 'index.php?option=com_survey&task=customer.cancel&raw='); ?>" + __ram;
                                                                            _TTHISS.removeAttr('disabled');
                                                                            window.location.href = __PPURL;
                                                                        }
                                                                    }
                                                                });
                                                            }).append('Buy');
                                                        } else {
                                                            __A = jQuery("<a/>").addClass('btn ').attr('data-target', __data['survey'][am].target).data('expertEmail', __data['expert'][s].paypal_id).click(function() {
                                                                _TTHISS = jQuery(this);
                                                                _TTHISS.attr('disabled', true);
                                                                __cEM = jQuery(this).data('expertEmail');
                                                                __target = jQuery(this).attr('data-target');
                                                                __amTT = jQuery(this).parent().data('expertAmount');
                                                                /*
                                                                 jQuery.ajax({
                                                                 url:_siteURL+'index.php?option=com_survey&task=customer.transaction',
                                                                 data:{amt:__amTT,su:__SUR,ex:__EXP,target:__target,format:''},
                                                                 cache:false,
                                                                 success:function(data){
                                                                 if(data>0){
                                                                 __ram = data;
                                                                 __PPURL = __PPURL+__cEM+"&lc=US&item_name=Survey Purchase&amount="+__amTT+"&currency_code=USD&item_number="+__ram+"&notify_url=
    <?php echo urlencode(JUri::base() . 'index.php?option=com_survey&task=customer.notify&raw='); ?>"+__ram+"&return=
    <?php echo urlencode(JUri::base() . 'index.php?option=com_survey&task=customer.success&raw='); ?>"+__ram+"&cancel=
    <?php echo urlencode(JUri::base() . 'index.php?option=com_survey&task=customer.cancel&raw='); ?>"+__ram;
                                                                 _TTHISS.removeAttr('disabled');
                                                                 window.location.href=__PPURL;
                                                                 }
                                                                 }
                                                                 
                                                                 });
                                                                 */
                                                                window.location.href = _siteURL + 'index.php?option=com_survey&task=customer.reEditReport&target=' + __target + '&su=' + __SUR + '&ex=' + __EXP;
                                                            }).append('Edit');
                                                        }
                                                        jQuery(_TD).append(__A);
                                                        jQuery(__TR).append(_TD);
                                                    }
                                                }
                                            }
                                        }
                                        jQuery(__ETable).append(__TR);
                                    }
                                    jQuery(__GRID2Div).append(_HTML);
                                    jQuery(__GRID10Div).append(__ETable);
                                } else {
                                    jQuery(_HTML).append('<tr><td>No record found!</td></tr>');
                                    jQuery(__GRID2Div).append(_HTML);
                                    jQuery(__GRID10Div).css('display', 'none');
                                }
                                jQuery("#question").append(__GRID2Div).append(__GRID10Div);

                                /*Change height for the Questions*/
                                jQuery('#questionlist>thead').each(function(index) {
                                    _height = jQuery(this).height();
                                    jQuery("#expertList>tbody>tr").eq(index).css('height', _height + 'px');
                                });
                                /*End Change height for the Questions*/
                                jQuery('.loader1').css('display', 'none');
                            }
                        });
                    }
                }

            </script>
            <?php
            echo $tabs->endPanel();
            echo $tabs->startPanel("In Process", "expert-inprocess-tab");
            ?>
            <script>
                getInProcessArray = []
            </script>
            <div class="row-fluid">
                <div class="span12">
                    <div class="row-fluid">
                        <?php
                        $getInProcessData = SurveyModelCustomer::expertInProcessData(JRequest::getInt('display'));
                        if (count($getInProcessData) > 0) {
                            ?>
                            <div class="span12" style="text-align:left">
                                <span>Select a ClaimChart and <a class='button-link' id="button-claim1" href="javascript://">Continue
                                        Editing</a>.&nbsp;
                                    If you wish to delete a ClaimChart, select it and <a class='button-link' id="button-claim2"
                                                                                         href="javascript://"
                                                                                         onclick="deleteInProcessClaim();">Delete</a>.</span>
                            </div>
                        </div>
                        <div class="span4" style="margin-left: 0px;">
                            <input type="hidden" name="process_delete" id="process_delete"/>
                            <table id="process-data" class="table sortingTable1">
                                <thead>
                                    <tr>
                                        <!--<th align="left" width="">#</th>-->
                                        <th align="left" style='padding:8px 0px;border-bottom: 1px solid #DDDDDD;'>Deadline</th>
                                        <th align="left" style='padding:8px 0px;border-bottom: 1px solid #DDDDDD;'>Claim</th>
                                        <th align="left" style='padding:8px 0px;border-bottom: 1px solid #DDDDDD;'>My Target
                                        </th>
                                    </tr>
                                </thead>
                                <?php
                                for ($i = 0; $i < count($getInProcessData); $i++) {
                                    ?>
                                    <tr>
                                        <?php
                                        $getElements = SurveyModelCustomer::getQuestionList($getInProcessData[$i]->surveyID);
                                        ?>
                                    <script>
                                        getInProcessArray['<?php echo $getInProcessData[$i]->surveyID; ?>_inpp'] = <?php echo json_encode($getElements); ?>;
                                    </script>
                                    <td align='left' style='padding:8px 0px;  border-top:0px; '><?php echo date('m/d/y', strtotime($getInProcessData[$i]->deadline)); ?></td>
                                    <td align="left" style='padding:8px 0px; border-top:0px; '><a class='button-link'
                                                                                                  href='javascript://'
                                                                                                  data-anstarget="<?php echo $getInProcessData[$i]->answerTarget; ?>"
                                                                                                  data-deadline="<?php echo date('m/d/y', strtotime($getInProcessData[$i]->deadline)); ?>"
                                                                                                  data-avoid="<?php echo $getInProcessData[$i]->avoided; ?>"
                                                                                                  data-target="<?php echo $getNotificationData[$i]->target; ?>"
                                                                                                  data-comment="<?php echo $getInProcessData[$i]->comment; ?>"
                                                                                                  data-del="<?php echo $getInProcessData[$i]->answerTarget; ?>@<?php echo JRequest::getInt('display'); ?>@<?php echo $getInProcessData[$i]->surveyID; ?>"
                                                                                                  data-url="<?php echo JUri::base(); ?>index.php?option=com_survey&view=answer&target=<?php echo $getInProcessData[$i]->answerTarget; ?>&param=<?php echo base64_encode($getInProcessData[$i]->surveyName . '@' . $getInProcessData[$i]->surveyID . '@' . $getSession->id); ?>"
                                                                                                  onclick="getInProcessElements(jQuery(this), '<?php echo $getInProcessData[$i]->surveyID ?>');"><?php echo $getInProcessData[$i]->combineName; ?></a>
                                    </td>
                                    <td align="left"
                                        style='padding:8px 0px; border-top:0px; '><?php echo $getInProcessData[$i]->answerTarget; ?></td>
                                    </tr>
                                    <?php
                                }
                                ?>
                            </table>
                        </div>
                        <div class="span8 noMargin" style="width:68%;margin:0 !important;">
                            <div id="dataFlow-1"></div>
                        </div>
                        <?php
                    } else {
                        ?>
                        <div class="span12 noMargin">
                            <div class="displayB" style="min-height:100px;">
                                <p class="alert alert-info">No record found!</p>
                            </div>
                        </div>
                        <?php
                    }
                    ?>
                </div>
            </div>
            <?php
            echo $tabs->endPanel();
            ?>
            <?php
            //echo $tabs->endPanel();
            if (!empty($getSession)) {
                echo $tabs->startPanel("Opportunites", "expert-opportunites-tab");
                $getNotificationData = SurveyModelCustomer::expertNotification(JRequest::getInt('display'));
               
                ?>
                <script>
                    mainAssocArray = [];
                </script>
                <div class="row-fluid">
                    <?php
                    if (count($getNotificationData) > 0) {
                        ?>
                        <div class="span12">

                            <div class="row-fluid">
                                <div class="span12 " style='text-align:left;'>
                                    <span>Select a Claim below and &nbsp;<a class='button-link' id="button-claim"
                                                                            href="javascript://">Start a New ClaimChart</a></span>
                                </div>
                            </div>

                        </div>
                        <div class="span4" style="margin-left: 0px;">
                            <table width="100%" id="opportunites-data" class="table sortingTable">
                                <thead>
                                    <tr>
                                        <th align="left" width="" style='padding:8px 0px;border-bottom: 1px solid #DDDDDD;'>Posted
                                        </th>
                                        <th align="left" width="" style='padding:8px 0px;border-bottom: 1px solid #DDDDDD;'>
                                            Deadline
                                        </th>
                                        <th align="left" width="" style='padding:8px 0px;border-bottom: 1px solid #DDDDDD;'>Claim
                                        </th>
                                    </tr>
                                </thead>
                                <?php
                                for ($i = 0; $i < count($getNotificationData); $i++) {
                                    ?>
                                    <tr>
                                        <td align="left"
                                            style='padding:8px 0px;  border-top:0px; '><?php echo date('m/d/y', strtotime($getNotificationData[$i]->created_date)); ?></td>
                                            <?php
                                            $getElements = SurveyModelCustomer::getQuestionList($getNotificationData[$i]->surveyID);
                                            ?>
                                    <script>
                                        mainAssocArray['<?php echo $getNotificationData[$i]->surveyID; ?>_opp'] = <?php echo json_encode($getElements); ?>;
                                    </script>
                                    <td align='left'
                                        style='padding:8px 0px;  border-top:0px; '><?php echo date('m/d/y', strtotime($getNotificationData[$i]->deadline)); ?></td>
                                    <td align="left" style='padding:8px 0px;  border-top:0px; '><a class='button-link'
                                                                                                   href='javascript://'
                                                                                                   data-deadline="<?php echo date('m/d/y', strtotime($getNotificationData[$i]->deadline)); ?>"
                                                                                                   data-avoid="<?php echo $getNotificationData[$i]->avoided; ?>"
                                                                                                   data-target="<?php echo $getNotificationData[$i]->target; ?>"
                                                                                                   data-comment="<?php echo $getNotificationData[$i]->comment; ?>"
                                                                                                   data-url="<?php echo JUri::base(); ?>index.php?option=com_survey&view=answer&param=<?php echo base64_encode($getNotificationData[$i]->surveyName . '@' . $getNotificationData[$i]->surveyID . '@' . $getSession->id); ?>"
                                                                                                   onclick="getCLAIMElements(jQuery(this), '<?php echo $getNotificationData[$i]->surveyID ?>');"><?php echo $getNotificationData[$i]->combineName; ?></a>
                                    </td>
                                    </tr>
                                    <?php
                                }
                                ?>
                            </table>
                        </div>
                        <div class="span8 noMargin" style="width:68%;margin:0 !important;">
                            <div id="dataFlow"></div>
                        </div>
                        <?php
                    } else {
                        ?>

                        <div class="span12">
                            <div class="displayB" style="min-height:100px;">
                                <p class="alert alert-info">No record found!</p>
                            </div>
                        </div>
                        <?php
                    }
                    ?>
                </div>
            
            <?php
			echo $tabs->endPanel();
        }
		if (!empty($getSession) && $getSession->id == JRequest::getInt('display')) {
			
			echo $tabs->startPanel("My Experties", "expert-myexperties-tab");
		?>
			<div class="row-fluid">
                <div class="span12">
					<a href='<?php echo JUri::base(); ?>index.php?option=com_survey&task=customer.expertArea&display=<?php echo $getSession->id;?>'>Click to See Expert Area</a>					
				</div>
			</div>
			<script>
				jQuery(document).ready(function (){
					jQuery('.expert-myexperties-tab >span').click(function(){
						window.location.href='<?php echo JUri::base(); ?>index.php?option=com_survey&task=customer.expertArea&display=<?php echo $getSession->id;?>';
					});
					jQuery('.expert-myexperties-tab').click(function(){
						window.location.href='<?php echo JUri::base(); ?>index.php?option=com_survey&task=customer.expertArea&display=<?php echo $getSession->id;?>';
					});
				});
			</script>
		<?php
			echo $tabs->endPanel();
		}
       
		
        echo $tabs->endPane();
        ?>
        <script>

            _getQueryString = <?php echo json_encode(JRequest::get('get')); ?>;
            jQuery(document).ready(function() {
                if (_getQueryString.show != undefined) {
                    __SHOW = parseInt(_getQueryString.show);
                    __DD = 0;
                    __FF = 0;
                    switch (__SHOW) {
                        case 1:
                            jQuery("#EditUsers dt").removeClass('open');
                            jQuery("#EditUsers dt").eq(3).addClass('open');
                            __FF = 1;
                            __DD = 3;
                            break;
                        case 2:
                            jQuery("#EditUsers dt").removeClass('open');
                            jQuery("#EditUsers dt").eq(0).addClass('open');
                            __FF = 1;
                            __DD = 0;
                            break;
                        case 3:
                            jQuery("#EditUsers dt").removeClass('open');
                            jQuery("#EditUsers dt").eq(1).addClass('open');
                            __FF = 1;
                            __DD = 1;
                            break;
                        case 4:
                            jQuery("#EditUsers dt").removeClass('open');
                            jQuery("#EditUsers dt").eq(2).addClass('open');
                            __FF = 1;
                            __DD = 2;
                            break;
                        case 5:
                            jQuery("#EditUsers dt").removeClass('open');
                            jQuery("#EditUsers dt").eq(4).addClass('open');
                            __FF = 1;
                            __DD = 4;
                            break;
                    }
                    if (__FF == 1) {
                        jQuery("div#profileData>div.current>dd").css('display', 'none');
                        jQuery("div#profileData>div.current>dd").eq(__DD).css('display', 'block');
                    }
                }
            });

            function getCLAIMElements(object, ID) {
                jQuery("#opportunites-data>tbody>tr>td>a").removeClass('current-active');
                _elements = mainAssocArray[ID + '_opp'];
                object.addClass('current-active');

                /*_Table = jQuery("<table/>"); By Aman for table formatting*/
                _Table = jQuery("<table class='table'>");
                _TH = jQuery("<thead/>").append("<tr><th align='left' style='padding:8px 0px;' width='50%'>Elements</th><th align='left' width='10%'>Target</th><th align='left' width='10%'>Avoided</th><th align='left' width='10%'>Comments</th></tr>");
                _Table.append(_TH);
                _TR = jQuery('<tr/>');
                if (_elements.length > 0) {
                    _TDD = jQuery("<td/>").css('padding-left', '0px');
                    _NEWTable = jQuery("<table>");
                    for (i = 0; i < _elements.length; i++) {
                        /*_NEWTable.append("<tr><td style='border:none;' valign='top'>"+_elements[i].description+"</td></tr>");*/
                        if (i == 0) {
                            _NEWTable.append("<tr><td style='border-top:none; margin:0;padding-top:0px;padding-left:0px;' >" + _elements[i].description + "</td></tr>");
                        } else {
                            _NEWTable.append("<tr><td style='border-top:none; margin:0;padding-left:0px;' >" + _elements[i].description + "</td></tr>");
                        }
                        _TDD.append(_NEWTable);
                    }
                    _TR.append(_TDD);
                } else {
                    _TDD = jQuery("<td/>");
                    _TR.append(_TDD);
                }
                _TDTarget = jQuery('<td/>').attr('valign', 'top').append(object.attr('data-target').toString());
                _TDComment = jQuery('<td/>').attr('valign', 'top').append(object.attr('data-comment').toString());
                /*_TDDeadline = jQuery('<td/>').attr('valign','top').append(object.attr('data-deadline').toString());*/
                _TDAvoided = jQuery('<td/>').attr('valign', 'top').append(object.attr('data-avoid').toString());
                _TR.append(_TDTarget).append(_TDAvoided).append(_TDComment);
                _Table.append(_TR);
                jQuery("#button-claim").attr('href', object.attr('data-url').toString());
                jQuery("#dataFlow").html(_Table);
            }
            function getInProcessElements(object, ID) {
                jQuery("#process-data>tbody>tr>td>a").removeClass('current-active');
                jQuery("#process_delete").val(object.attr('data-del'));
                _elements = getInProcessArray[ID + '_inpp'];
                object.addClass('current-active');
                _Table = jQuery("<table class='table'>");
                _TH = jQuery("<thead/>").append("<tr><th align='left' style='padding:8px 0px;' width='50%'>Elements</th><th align='left' width='10%'>Target</th><th align='left' width='10%'>Avoided</th><th align='left' width='10%'>Comments</th></tr>");
                _Table.append(_TH);
                _TR = jQuery('<tr/>');
                if (_elements.length > 0) {
                    _TDD = jQuery("<td/>").css('padding-left', '0px');
                    _NEWTable = jQuery("<table>");
                    for (i = 0; i < _elements.length; i++) {
                        if (i === 0) {
                            _NEWTable.append("<tr><td style='border-top:none; margin:0;padding-top:0px;padding-left:0px;' >" + _elements[i].description + "</td></tr>");
                        } else {
                            _NEWTable.append("<tr><td style='border-top:none; margin:0;padding-left:0px;' >" + _elements[i].description + "</td></tr>");
                        }
                        _TDD.append(_NEWTable);
                    }
                    _TR.append(_TDD);
                } else {
                    _TDD = jQuery("<td/>");
                    _TR.append(_TDD);
                }
                _TDTarget = jQuery('<td/>').attr('valign', 'top').append(object.attr('data-target').toString());
                _TDComment = jQuery('<td/>').attr('valign', 'top').append(object.attr('data-comment').toString());
                _TDAvoided = jQuery('<td/>').attr('valign', 'top').append(object.attr('data-avoid').toString());
                _TR.append(_TDTarget).append(_TDAvoided).append(_TDComment);
                _Table.append(_TR);
                jQuery("#button-claim1").attr('href', object.attr('data-url').toString());
                jQuery("#dataFlow-1").html(_Table);
            }

            function deleteInProcessClaim() {
                res = confirm('Are you sure you want to delete?');
                if (res === true) {
                    if (jQuery("#process_delete").val().length === 0) {
                        alert('Please select claim.');
                    } else {
                        _string_send = jQuery("#process_delete").val();
                        jQuery.ajax({
                            type: 'POST',
                            url: '<?php echo JUri::base() ?>',
                            data: {option: 'com_survey', task: 'customer.deleteInProcessClaim', string_send: _string_send, format: ''},
                            cache: false,
                            success: function(res) {
                                if (parseInt(res) === 1) {
                                    window.location = window.location.url;
                                } else if (parseInt(res) === 0) {
                                    alert('Please try again later.');
                                }
                            }
                        });
                    }
                }
            }
        </script>
    </div>
    
    
<?php else: ?>
    <div class="row-fluid">
        <div class="span12">
            <p>Sorry Page not found!</p>
        </div>
    </div>
<?php endif; ?>
 <script>
	function tinyMCEOBJECTFUN(){
		jQuery("#descriptionEditor_toolbar2").remove();
		jQuery("#descriptionEditor_toolbar3").remove();
		jQuery("#descriptionEditor_toolbar1>tbody>tr").find('td').eq(4).remove();
		jQuery("#descriptionEditor_toolbar1>tbody>tr").find('td').eq(4).remove();
		jQuery("#descriptionEditor_toolbar1>tbody>tr").find('td').eq(4).remove();
		jQuery("#descriptionEditor_toolbar1>tbody>tr").find('td').eq(4).remove();
		jQuery("#descriptionEditor_toolbar1>tbody>tr").find('td').eq(4).remove();
		jQuery("#descriptionEditor_toolbar1>tbody>tr").find('td').eq(4).remove();
		jQuery("#descriptionEditor_toolbar1>tbody>tr").find('td').eq(4).remove();
		jQuery("#descriptionEditor_toolbar1>tbody>tr").find('td').eq(4).remove();
		jQuery("#descriptionEditor_toolbar1>tbody>tr").find('td').eq(4).remove();
		jQuery("#descriptionEditor_toolbar1>tbody>tr").find('td').eq(4).remove();			
	}
	
	
	/*
	function getStats(id) {
    var body = tinymce.get(id).getBody(), text = tinymce.trim(body.innerText || body.textContent);

    return {
        chars: text.length,
        words: text.split(/[\w\u2019\'-]+/).length
    };
} 





function submitForm() {
        // Check if the user has entered less than 10 characters
        if (getStats('content').chars < 10) {
            alert("You need to enter 1000 characters or more.");
            return;
        }

        // Check if the user has entered less than 1 words
        if (getStats('content').words < 1) {
            alert("You need to enter 1 words or more.");
            return;
        }

        // Submit the form
        document.forms[0].submit();
    }
	*/
  </script>
