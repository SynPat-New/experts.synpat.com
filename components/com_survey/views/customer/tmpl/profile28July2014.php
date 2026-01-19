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
$doc = JFactory::getDocument();
$modpath = JURI::base(true)."/modules/mod_hg_skillsdiagram";
$doc->addScript($modpath."/assets/raphael-min.js");
$doc->addScript($modpath."/assets/init.js");

$staticContent='<h2 class="subtitle hugetitle" style="font-size: 36px; color: #595959;">Welcome to Kallyas Joomla Template, a wonderful and premium product for multipurpose websites&nbsp;</h2>';
$staticContent.='<div style="float:right" id="skills_diagram" data-attr="9" data-class="">
	<div class="legend">
		<h4>Legend:</h4>		<ul class="skills">
<li style="background-color:#97BE0D;" data-percent="95">JavaScript</li><li style="background-color:#D84F5F;" data-percent="90">CSS3</li><li style="background-color:#88B8E6;" data-percent="80">HTML5</li><li style="background-color:#BEDBE9;" data-percent="53">PHP</li><li style="background-color:#EDEBEE;" data-percent="45">MySQL</li>	
		</ul><!-- end the skills -->
	</div>
	<div data-textcolor="#ffffff" data-fontsize="20px Arial" data-maintext="Skills" data-maincolor="#193340" data-height="600" data-width="600" id="thediagram"></div>
</div>';
$staticContent.='<div id="image_desc" data-attr="1" data-class=""><img border="0" alt="" src="/new/images/kallyas_images/aboutus.jpg" class="alignleftborder">';
$staticContent.='<p>Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat.</p>';
$staticContent.='<p>Sed ut perspiciatis unde omnis iste natus error sit voluptatem accusantium doloremque laudantium, totam rem aperiam, eaque ipsa quae ab illo inventore veritatis et quasi architecto beatae vitae dicta sunt explicabo. Nemo enim ipsam voluptatem quia voluptas sit aspernatur aut odit aut fugit, sed quia consequuntur magni dolores eos qui ratione voluptatem sequi nesciunt.</p></div>';
$staticContent.='<p class="m_title"></p>';
$staticContent.='<div id="choose_us" data-attr="2" data-class=""><h4 style="text-align:left; ;" class="m_title "> WHY CHOOSE US&nbsp;</h4>';
$staticContent.='<ul style="margin-bottom: 20px;" class="list-style1">
<li>Fusce sit amet orci quis arcu vestibulum vestibulum sed ut felis. Phasellus in risus quis lectus iaculis vulputate id quis nisl.</li>
<li>Phasellus in risus quis lectus iaculis vulputate id quis nisl.</li>
<li>Fusce sit amet orci quis arcu vestibulum vestibulum sed ut felis.</li>
<li>Phasellus in risus quis lectus iaculis vulputate id quis nisl.</li>
</ul></div>';
$staticContent.='<div id="testimonial" data-attr="3" data-class="rLeft"><blockquote><p>&nbsp;Neque porro quisquam est, qui dolorem ipsum quia dolor sit amet, consectetur, adipisci velit, sed quia non numquam eius modi tempora.&nbsp;</p><small>BRIAN NUNN - <cite>Company CEO</cite></small></blockquote></div>';
$staticContent.='<div style="height:35px;"></div>';
$staticContent.='<div class="custom ">
	<div class="tabbable vertical_tabs "><ul class="nav fixclear"><li class="active"><a data-toggle="tab" href="#custom-tab-main-area"><span><span class="icon-comment icon-white"></span></span>MAIN AREAS OF EXPERTISE</a></li><li><a data-toggle="tab" href="#custom-tab-standard-expertise"><span><span class="icon-book icon-white"></span></span>STANDARD AREAS OF EXPERTISE</a></li><li><a data-toggle="tab" href="#custom-tab-membership"><span><span class="icon-tint icon-white"></span></span>MEMBERSHIPS</a></li><li><a data-toggle="tab" href="#custom-tab-standardgroup"><span><span class="icon-align-left icon-white"></span></span>STANDARDS GROUPS</a></li><li><a data-toggle="tab" href="#custom-tab-cvresume"><span><span class="icon-wrench icon-white"></span></span>CV/RESUMES</a></li></ul><div class="tab-content">
<div class="tab-pane active" id="custom-tab-main-area" data-attr="4" data-class="rRight">
<h4>Support is given through a well organized forum</h4>
<p><img border="0" alt="" src="/new/images/kallyas_images/site_images/support.jpg" class="alignright"></p>
<p>Sed ut perspiciatis unde omnis iste natus error sit voluptatem accusantium doloremque laudantium, totam rem aperiam, eaque ipsa quae ab illo inventore veritatis et quasi architecto beatae vitae dicta sunt explicabo.</p>
<p>Nemo enim ipsam voluptatem quia voluptas sit aspernatur aut odit aut fugit, sed quia consequuntur magni dolores eos qui ratione voluptatem sequi nesciunt. Neque porro quisquam est, qui dolorem ipsum quia dolor sit amet, consectetur, adipisci velit, sed quia non numquam eius modi tempora incidunt ut labore et dolore magnam aliquam quaerat voluptatem.</p>
<p>Ut enim ad minima veniam, quis nostrum exercitationem ullam corporis suscipit laboriosam, nisi ut aliquid ex ea commodi consequatur? Quis autem vel eum iure reprehenderit qui in ea voluptate velit esse quam nihil molestiae consequatur, vel illum qui dolorem.</p>
</div>
<div class="tab-pane " id="custom-tab-standard-expertise" data-attr="5" data-class="">
<h4>Pane 2 Content</h4>
<p>Phasellus eget justo lacus. Vivamus pharetra ullamcorper massa, nec ultricies metus gravida egestas. Duis congue viverra arcu, ac aliquet turpis rutrum a. Donec semper vestibulum dapibus. Integer et sollicitudin metus. Vivamus at nisi turpis.</p>
</div>
<div class="tab-pane " id="custom-tab-membership" data-attr="6" data-class="">
<h4>Pane 3 Content</h4>
<p>Donec semper vestibulum dapibus. Integer et sollicitudin metus. Vivamus at nisi turpis. Phasellus vel tellus id felis cursus hendrerit. Suspendisse et arcu felis, ac gravida turpis. Suspendisse potenti. Ut porta rhoncus ligula, sed fringilla felis feugiat eget. In non purus quis elit iaculis tincidunt. Donec at ultrices est.</p>
</div>
<div class="tab-pane " id="custom-tab-standardgroup" data-attr="7" data-class="">
<h4>Pane 4 Content</h4>
<p>Phasellus eget justo lacus. Vivamus pharetra ullamcorper massa, nec ultricies metus gravida egestas. Duis congue viverra arcu, ac aliquet turpis rutrum a. Donec semper vestibulum dapibus. Integer et sollicitudin metus. Vivamus at nisi turpis.</p>
</div>
<div class="tab-pane " id="custom-tab-cvresume" data-attr="8" data-class="">
<h4>Pane 5 Content</h4>
<p>Donec semper vestibulum dapibus. Integer et sollicitudin metus. Vivamus at nisi turpis. Phasellus vel tellus id felis cursus hendrerit. Suspendisse et arcu felis, ac gravida turpis. Suspendisse potenti. Ut porta rhoncus ligula, sed fringilla felis feugiat eget. In non purus quis elit iaculis tincidunt. Donec at ultrices est.</p>
</div>
</div></div>
</div>';
$staticContent.='<div style="height:35px;"></div>';
$staticContent.='<div class="custom ">
	<div data-grid="first" class="row"><div class="span12"><h3 class="mb_title"><img alt="" src="/new/images/kallyas_images/icons/ico-stats.png"> STATS</h3>
</div>
<div class="span3"><div class="statbox">
		<img alt="" src="/new/images/kallyas_images/icons/stats/ico-finished-projects.png">
<h4>150+</h4>
<h6>FINISHED PROJECTS</h6>
	</div>
</div>
<div class="span3"><div class="statbox">
		<img alt="" src="/new/images/kallyas_images/icons/stats/ico-code-lines.png">
<h4>2500+</h4>
<h6>CODE LINES THIS MONTH</h6>
	</div>
&nbsp;<p></p>
</div>
<div class="span3"><div class="statbox">
		<img alt="" src="/new/images/kallyas_images/icons/stats/ico-working-hours.png">
<h4>1400+</h4>
<h6>WORKING HOURS THIS YEAR</h6>
	</div>
</div>
<div class="span3"><div class="statbox">
		<img alt="" src="/new/images/kallyas_images/icons/stats/ico-testimonials.png">
<h4>120+</h4>
<h6>TESTIMONIALS RECEIVED</h6>
	</div>
</div></div>
</div>';
$staticContent.='<div class="row">
										
					<div class="span12">
						 
<div class="item-page">

	<h2 class="page-title">
		Contact Us
	</h2>

<div class="clear"></div>


<div class="row "> <div class="span6">
<p><span>Use this form to send us a message:</span></p>
<div id="contact_form" class="rapid_contact ">
<form action="index.php" method="post" class="form-horizontal">
<div class="intro_text "></div>
<div class="control-group">
	<label class="control-label" for="rp_name">Name:</label>
<div class="controls">
<input class=" inputbox input-xlarge" type="text" placeholder="Name:" name="rp_name" id="rp_name" value="">
	</div>
</div>
<!-- end control group -->
<div class="control-group">
	<label class="control-label" for="rp_email">Email:</label>
<div class="controls">
<input class=" inputbox input-xlarge" type="text" placeholder="Email:" name="rp_email" id="rp_email" value="" required="required">
	</div>
</div>
<!-- end control group -->
<div class="control-group">
	<label class="control-label" for="rp_subject">Subject:</label>
<div class="controls">
<input class=" inputbox input-xlarge" type="text" placeholder="Subject:" name="rp_subject" id="rp_subject" value="">
	</div>
</div>
<!-- end control group -->
<div class="control-group">
	<label class="control-label" for="rp_message">Message:</label>
<div class="controls">
		<textarea class="textarea span4" placeholder="Message:" name="rp_message" id="rp_message" required="required"></textarea>
	</div>
</div>
<!-- end control group -->
<div class="control-group">
<div class="controls">
		<label for="rp_anti_spam_answer">How many eyes has a typical person?</label>
<input class=" inputbox input-mini" type="text" name="rp_anti_spam_answer" id="rp_anti_spam_answer" value="">
	</div>
</div>
<!-- end control group -->
<div class="control-group">
<div class="controls">
<input class=" btn " id="submit-form" type="submit" name="submit" value="Send Message">
<input type="hidden" name="option" value="com_survey"/>
<input type="hidden" name="task" value="customer.contact_us"/>
	</div>
</div>
<!-- end control group -->
</form>
</div>
</div>
<div class="span6">
<h3>Get in touch with us</h3>
<div class="qrCode" style="float:right; margin:0px 0px 15px 15px; width:160px; ">
<h6>Scan me!</h6>
	<img src="http://api.qrserver.com/v1/create-qr-code/?data=MECARD%3AN%3AMarius+Hogas%3BADR%3AMyStreet+22%2C+Bucuresti%3BTEL%3A%2B+%2850%29+555+89+89%3BTEL%3A%2B+%2850%29+555+88+88%3BTEL%3A%2B+%2850%29+555+87+87%3BTEL%3A%2B+%2850%29+555+86+86%3BEMAIL%3Ahogash.themeforest%40gmail.com%3BURL%3Ahttp%3A%2F%2Fwww.hogash.com%2F%3B%3B&amp;size=140x140" alt="Scan this QR Code!" class="img-polaroid">
</div>
<p><strong>Address:</strong>&nbsp;Street Address nr 100, 4536534, Your Town, United States</p>
<p><strong>Phone:</strong> (212) 555 55 00<br> <strong>Email:</strong> office [ @ ] yourwebsite.com<br> <strong>Web:</strong> <a href="http://&lt;strong&gt;&lt;/strong&gt;www.yourwebsite.com" target="_blank">www.yourwebsite.com</a></p>
<p>Pellentesque habitant morbi tristique senectus et netus et malesuada fames ac turpis egestas. Vestibulum tortor quam, feugiat vitae, ultricies eget, tempor sit amet, ante. Donec eu libero sit amet quam egestas semper. Aenean ultricies mi vitae est. Mauris placerat eleifend leo.</p>
</div>
</div>

<div class="clear"></div>


	
</div>

					</div><!-- end main component -->
					
									</div>';

if (count($expert) > 0):
    ?>
    <style>
		.process_steps .step.intro:after{border-left-color:#CD2122}
		.process_steps .step.step1:after{border-left-color:#5A5A5A}
		.process_steps .step.step2:after{border-left-color:#4A4A4A}
		.process_steps .step.step3:after{border-left-color:#3E3E3E}
		.process_steps .step.intro{background:none repeat scroll 0 0 #CD2122}
		.process_steps .step.step1{background:none repeat scroll 0 0 #5A5A5A}
		.process_steps .step.step2{background:none repeat scroll 0 0 #4A4A4A}
		.process_steps .step.step3{background:none repeat scroll 0 0 #3E3E3E}

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
    <script>
		_sessionEXpertID = '<?php echo $sessionEXpertID; ?>';
	</script>
    <script>
		function showUpdateBox(object) {
			if (_sessionEXpertID === null || _sessionEXpertID === "0") {
				alert('You do not have permission to perform this action.');
				return;
			}
			object.hide();
			//jQuery("#profile_edit_click").css('min-height', '1050px');
			//jQuery("#description").css('display', 'none');
			//jQuery("#showUpdateBox").css('display', 'block');
			jQuery(".viewControl").css('display', 'none');
			jQuery(".editControl").css('display', 'block');
			/*tinyMCEOBJECTFUN();*/
		}
		function cancelDesc() {
			//jQuery("#showUpdateBox").css('display', 'none');
			//jQuery("#profile_edit_click").css('min-height', '420px');
			//jQuery("#description").css('display', 'block');
			//jQuery("#shoBTN").css('display', '');
			jQuery(".viewControl").css('display', 'block');
			jQuery(".editControl").css('display', 'none');
			scrollToTop();
		}
		function scrollToTop() {
			jQuery("html, body").animate({'scrollTop': 0}, 1000);
		}
    </script>
     <div id="profileData">
										
		<dl class="article-info clearfix">
			<dd class="active category-name"><a href="<?php echo JRoute::_('index.php?option=com_survey&task=customer.expertProfile&display='.JRequest::getInt('display'))?>">Profile</a></dd>
			<dd class="published"><a href="<?php echo JRoute::_('index.php?option=com_survey&task=customer.expertFeedback&display='.JRequest::getInt('display'))?>">Feedback</a></dd>
			<dd class="createdby"><a href="<?php echo JRoute::_('index.php?option=com_survey&task=customer.expertReport&display='.JRequest::getInt('display'))?>">My Report</a></dd>
			<dd class="createdby"><a href="<?php echo JRoute::_('index.php?option=com_survey&task=customer.expertProcess&display='.JRequest::getInt('display'))?>">In Process</a></dd>
			<?php if($sessionEXpertID>0):?>
			<dd class="createdby"><a href="<?php echo JRoute::_('index.php?option=com_survey&task=customer.expertOpportunites&display='.JRequest::getInt('display'))?>" >Opportunities</a></dd>
			<dd class="createdby"><a href="<?php echo JRoute::_('index.php?option=com_survey&task=customer.expertArea&display='.JRequest::getInt('display'))?>" >My Experties</a></dd>
			<?php endif;?>
		</dl>
	
					
			<!-- Profile data-->			
				<ul class="actions">
					<li class="print-icon">
						<a href="<?php echo JRoute::_(JURI::base()."index.php?option=com_survey&task=customer.expertProfile&display=1&tmpl=component&print=1&page=")?>" data-rel="tooltip" onclick="window.open(this.href,'win2','status=no,toolbar=no,scrollbars=yes,titlebar=no,menubar=no,resizable=yes,width=640,height=480,directories=no,location=no');return false;" rel="nofollow" data-original-title="Print"><span class='icon-print icon-white'></span></a>
					</li>
					<?php if($sessionEXpertID>0):?>
					<li class="edit-icon">
						<a href="javascript://" data-rel="tooltip" onclick="showUpdateBox(jQuery(this));" rel="nofollow" data-original-title="Edit"><span class='icon-edit icon-white'></span></a>
					</li>
					<?php endif;?>
				 </ul>
					
					 <div class="viewControl">
					<?php 
						$descriptionData = $staticContent;
						if(empty($expert->text_data)){
							if(!empty($expert->description)){
								$descriptionData = $expert->description;
							} 
						} else {
							$textData = json_decode($expert->text_data);
							$descriptionData = (isset($textData->expl))?$textData->expl:$staticContent; 
						}
						echo $descriptionData;
					?>
					</div>
					<?php
							if($sessionEXpertID>0):
					?>		
						 <div class="editControl" style='display:none'>
							 <form method="post" action='index.php'>
						<?php
								$editorDescription = JFactory::getEditor();
								$descriptionData = $staticContent;
								if(empty($expert->text_data)){
									$descriptionData = $expert->description;
								} else {
									$textData = json_decode($expert->text_data);
									$descriptionData = (isset($textData->expl))?$textData->expl:$staticContent; 
								}
								echo $editorDescription->display('descriptionEditor', $descriptionData, '100%', '500', '60', '10', false);
						?>
								
								<div class="row-fluid">
									<div class="span12">
										<div class="controls">
											<input type="submit" name="submit_profile" value="Save" class="btn btn-medium btn-flat tM"/>&nbsp;
											<input type="button" name="cancel_profile" value="Cancel" onclick="cancelDesc()" class="btn btn-medium btn-flat tM"/>
										</div>
									</div>
								</div>
								<input type="hidden" name="option" value="com_survey"/>
								<input type="hidden" name="task" value="customer.updateProfileUser"/>
								</form>
							</div>
					<?php
							endif;
                     ?>			
			<!-- End Profile data-->
     </div>
	<!-- Modal -->
	<div id="myModal" class="modal hide fade" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
		<form method="post" action="index.php" enctype='multipart/form-data'>
			<div class="modal-header">
				<button type="button" class="close" data-dismiss="modal" aria-hidden="true">x</button>
				<h3 id="myModalLabel">Update Profile</h3>
			</div>
			<div class="modal-body" id="modalBody">
				
			</div>
			<div class="modal-footer">
				<button class='btn btn-medium btn-flat pull-left' id="buttonElement" type="button" onclick='addElement()'>Add Element</button>
				<button class='btn btn-medium btn-flat pull-left' id="buttonElementSkills" type="button" onclick='addElementSkills()'>Add Element</button>
				<button class="btn" data-dismiss="modal" aria-hidden="true">Close</button>
				<button class="btn btn-medium btn-flat" type="submit">Save changes</button>
			</div>	
			<input type="hidden" name="option" value="com_survey"/>
			<input type="hidden" name="task" value="customer.profileUpdate"/>
			<input type="hidden" name="default_type" id="default_type" value="0"/>
		</form>
	</div>
<?php else: ?>    
       <p class='alert alert-danger'>Sorry Page not found!</p>       
<?php endif; ?>

<script>

            _getQueryString = <?php echo json_encode(JRequest::get('get')); ?>;
            jQuery(document).ready(function() {
                jQuery('title').html('EXPERT PROFILE');
            });

            
        </script>
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
	jQuery("#image_desc,#choose_us,#testimonial,#custom-tab-main-area,#custom-tab-standard-expertise,#custom-tab-membership,#custom-tab-standardgroup,#custom-tab-cvresume,#skills_diagram").mouseover(function(){
		if(jQuery(this).find('span.edit').length>0){
			jQuery(this).find('span.edit').removeClass('disable_edit').addClass('enable_edit');
		} else {
			jQuery(this).prepend('<span class="edit '+jQuery(this).attr('data-class')+' enable_edit edit-icon"><a href="javascript:void(0);" onclick="editPanel(jQuery(this),'+jQuery(this).attr('data-attr')+')";><span class="icon-edit"></span></a></span>');
		} 
	}).mouseout(function(){
		jQuery(this).find('span.edit').removeClass('enable_edit').addClass('disable_edit');
	});
	
	function addElement(){
		jQuery("#modalBody").append('<div class="control-group"><div class="controls"><input class="span5" type="text" name="field_choose_us[]" value=""></div></div>');
	}
	
	function addElementSkills(){
		jQuery("#modalBody").append("<div class='control-group'><div class='controls'><input class='span3' style='margin-right:5px' type='text' name='field_skill_name[]' placeholder='Skill Heading'/><input class='span2' type='text' name='field_skill_value[]' placeholder='Skill Value' /></div></div>");
	}
	
	function editPanel(object,element_type){
		switch(element_type){
			case 1: 
				/*description*/
				_desc = "";
				jQuery("#image_desc").find('p').each(function(){
					_desc +=jQuery(this).html()+'\n';
				});
				_htmlContent = "<div class='control-group'><lable>Upload File</label><div class='controls'><input type='file' name='file_image'/><input type='hidden' name='old_image' value='"+jQuery("#image_desc").find('img.alignleftborder').attr('src')+"' /></div></div>";
				_htmlContent +="<div class='control-group'><lable>Description</label><div class='controls'><textarea name='profile_desc' style='width:98%;height:70px'>"+_desc+"</textarea></div></div>";
				jQuery("#modalBody").html(_htmlContent);		
				jQuery("#buttonElement").css('display','none');
				jQuery("#buttonElementSkills").css('display','none');
			break;
			case 2:
				/*choose us*/
				_heading="";
				if(jQuery("#choose_us").find('h4.m_title').length>0){
					_heading = jQuery("#choose_us").find('h4.m_title').html();
				}
				_elementData = "";
				if(jQuery("#choose_us").find('ul.list-style1').find('li').length>0){
					jQuery("#choose_us").find('ul.list-style1').find('li').each(function(){
						_elementData +="<div class='control-group'><div class='controls'><input class='span5' type='text' name='field_choose_us[]' value='"+jQuery(this).html()+"'/></div></div>";
					});
				}
				jQuery("#modalBody").html("<div class='control-group'><div class='controls'><input class='span5' type='text' name='field_choose_heading' value='"+_heading+"'/></div></div>"+_elementData);		
				jQuery("#buttonElement").css('display','block');
				jQuery("#buttonElementSkills").css('display','none');
			break;
			case 3:
				/*Testimonial*/
				jQuery("#modalBody").html("<div class='control-group'><div class='controls'><input class='span5' type='text' name='testimonial' value='"+jQuery("#testimonial").find('blockquote').find('p').html()+"'/></div></div>");
				jQuery("#modalBody").append("<div class='control-group'><div class='controls'><input class='span5' type='text' name='testimonial_by' value='"+jQuery("#testimonial").find('blockquote>small').html()+"'/></div></div>");
				jQuery("#buttonElement").css('display','none');
				jQuery("#buttonElementSkills").css('display','none');
			break;
			case 4:
				/*Main Area*/
				jQuery("#modalBody").html("<div class='control-group'><label>Title</label><div class='controls'><input class='span5' type='text' name='main_area_heading' value='"+jQuery("#custom-tab-main-area").find('h4').html()+"'/></div></div>");
				_desc = "";
				if(jQuery("#custom-tab-main-area").find('p').length>1){
					jQuery("#custom-tab-main-area").find('p').each(function(index){
						if(index>0){							
							_desc +=jQuery(this).html()+'<br/>';
						}
					});
				}
				jQuery("#modalBody").append("<div class='control-group'><lable>Image</label><div class='controls'><input type='file' name='main_area_image' /></div></div>");
				jQuery("#modalBody").append("<div class='control-group'><lable>Description</label><div class='controls'><textarea name='main_area_description' style='width:98%;height:100px'>"+_desc+"</textarea></div></div>");
				jQuery("#buttonElement").css('display','none');	
				jQuery("#buttonElementSkills").css('display','none');	
			break;
			case 5:
				/*Standard Main Area*/
				jQuery("#modalBody").html("<div class='control-group'><label>Title</label><div class='controls'><input class='span5' type='text' name='main_standard_area_heading' value='"+jQuery("#custom-tab-standard-expertise").find('h4').html()+"'/></div></div>");
				_desc = "";
				if(jQuery("#custom-tab-standard-expertise").find('p').length>1){
					jQuery("#custom-tab-standard-expertise").find('p').each(function(index){
						if(index>0){							
							_desc +=jQuery(this).html()+'<br/>';
						}
					});
				}
				jQuery("#modalBody").append("<div class='control-group'><lable>Image</label><div class='controls'><input type='file' name='main_standard_area_image' /></div></div>");
				jQuery("#modalBody").append("<div class='control-group'><lable>Description</label><div class='controls'><textarea name='main_standard_area_description' style='width:98%;height:100px'>"+_desc+"</textarea></div></div>");
				jQuery("#buttonElement").css('display','none');	
				jQuery("#buttonElementSkills").css('display','none');	
			break;
			case 6:
				/*Membership*/
				jQuery("#modalBody").html("<div class='control-group'><label>Title</label><div class='controls'><input class='span5' type='text' name='main_membership_heading' value='"+jQuery("#custom-tab-membership").find('h4').html()+"'/></div></div>");
				_desc = "";
				if(jQuery("#custom-tab-membership").find('p').length>1){
					jQuery("#custom-tab-membership").find('p').each(function(index){
						if(index>0){							
							_desc +=jQuery(this).html()+'<br/>';
						}
					});
				}
				jQuery("#modalBody").append("<div class='control-group'><lable>Image</label><div class='controls'><input type='file' name='main_membership_image' /></div></div>");
				jQuery("#modalBody").append("<div class='control-group'><lable>Description</label><div class='controls'><textarea name='main_membership_description' style='width:98%;height:100px'>"+_desc+"</textarea></div></div>");
				jQuery("#buttonElement").css('display','none');	
				jQuery("#buttonElementSkills").css('display','none');	
			break;
			case 7:
				/*Standard Group*/
				jQuery("#modalBody").html("<div class='control-group'><label>Title</label><div class='controls'><input class='span5' type='text' name='main_standard_group_heading' value='"+jQuery("#custom-tab-standardgroup").find('h4').html()+"'/></div></div>");
				_desc = "";
				if(jQuery("#custom-tab-standardgroup").find('p').length>1){
					jQuery("#custom-tab-standardgroup").find('p').each(function(index){
						if(index>0){							
							_desc +=jQuery(this).html()+'<br/>';
						}
					});
				}
				jQuery("#modalBody").append("<div class='control-group'><lable>Image</label><div class='controls'><input type='file' name='main_standard_group_image' /></div></div>");
				jQuery("#modalBody").append("<div class='control-group'><lable>Description</label><div class='controls'><textarea name='main_standard_group_description' style='width:98%;height:100px'>"+_desc+"</textarea></div></div>");
				jQuery("#buttonElement").css('display','none');	
				jQuery("#buttonElementSkills").css('display','none');	
			break;
			case 8:
				/*CVResume*/
				jQuery("#modalBody").html("<div class='control-group'><label>Title</label><div class='controls'><input class='span5' type='text' name='main_cvresume_heading' value='"+jQuery("#custom-tab-cvresume").find('h4').html()+"'/></div></div>");
				_desc = "";
				if(jQuery("#custom-tab-cvresume").find('p').length>1){
					jQuery("#custom-tab-cvresume").find('p').each(function(index){
						if(index>0){							
							_desc +=jQuery(this).html()+'<br/>';
						}
					});
				}
				jQuery("#modalBody").append("<div class='control-group'><lable>Image</label><div class='controls'><input type='file' name='main_cvresume_image' /></div></div>");
				jQuery("#modalBody").append("<div class='control-group'><lable>Description</label><div class='controls'><textarea name='main_cvresume' style='width:98%;height:100px'>"+_desc+"</textarea></div></div>");
				jQuery("#buttonElement").css('display','none');	
				jQuery("#buttonElementSkills").css('display','none');	
			break;
			case 9:				
				_elementData = "";
				if(jQuery(".skills").find('li').length>0){
					jQuery(".skills").find('li').each(function(){
						_elementData +="<div class='control-group'><div class='controls'><input class='span3' style='margin-right:5px' type='text' name='field_skill_name[]' value='"+jQuery(this).html()+"' placeholder='Skill Heading'/><input class='span2' type='text' name='field_skill_value[]' value='"+jQuery(this).attr('data-percent')+"' placeholder='Skill Value'/></div></div>";
					});
				}
				jQuery("#modalBody").html(_elementData);
				jQuery("#buttonElement").css('display','none');	
				jQuery("#buttonElementSkills").css('display','block');	
			break;
		}
		jQuery("#default_type").val(element_type);
		jQuery("#myModal").modal('toggle');
	}
  </script>
