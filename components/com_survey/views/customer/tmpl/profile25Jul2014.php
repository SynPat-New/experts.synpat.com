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

$staticContent='<div class="row-fluid"><div class="span8"><h2 class="subtitle hugetitle" style="font-size: 36px; color: #595959;">Welcome to Kallyas Joomla Template, a wonderful and premium product for multipurpose websites&nbsp;</h2></div><div class="span4"><address>
  <strong>Twitter, Inc.</strong><br>
  795 Folsom Ave, Suite 600<br>
  San Francisco, CA 94107<br>
  <abbr title="Phone">P:</abbr> (123) 456-7890
</address>
<address>
  <strong>Full Name</strong><br>
  <a href="mailto:#">first.last@gmail.com</a>
</address></div></div>';
$staticContent.='<div style="float:right" id="skills_diagram">
	<div class="legend">
		<h4>Legend:</h4>		<ul class="skills">
<li style="background-color:#97BE0D;" data-percent="95">JavaScript</li><li style="background-color:#D84F5F;" data-percent="90">CSS3</li><li style="background-color:#88B8E6;" data-percent="80">HTML5</li><li style="background-color:#BEDBE9;" data-percent="53">PHP</li><li style="background-color:#EDEBEE;" data-percent="45">MySQL</li>	
		</ul><!-- end the skills -->
	</div>
	<div data-textcolor="#ffffff" data-fontsize="20px Arial" data-maintext="Skills" data-maincolor="#193340" data-height="600" data-width="600" id="thediagram"></div>
</div>';
$staticContent.='<p><img border="0" alt="" src="/new/images/kallyas_images/aboutus.jpg" class="alignleftborder"></p>';
$staticContent.='<p>Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat.</p>';
$staticContent.='<p>Sed ut perspiciatis unde omnis iste natus error sit voluptatem accusantium doloremque laudantium, totam rem aperiam, eaque ipsa quae ab illo inventore veritatis et quasi architecto beatae vitae dicta sunt explicabo. Nemo enim ipsam voluptatem quia voluptas sit aspernatur aut odit aut fugit, sed quia consequuntur magni dolores eos qui ratione voluptatem sequi nesciunt.</p>';
$staticContent.='<p class="m_title"></p>';
$staticContent.='<h4 style="text-align:left; ;" class="m_title "> WHY CHOOSE US&nbsp;</h4>';
$staticContent.='<ul style="margin-bottom: 20px;" class="list-style1">
<li>Fusce sit amet orci quis arcu vestibulum vestibulum sed ut felis. Phasellus in risus quis lectus iaculis vulputate id quis nisl.</li>
<li>Phasellus in risus quis lectus iaculis vulputate id quis nisl.</li>
<li>Fusce sit amet orci quis arcu vestibulum vestibulum sed ut felis.</li>
<li>Phasellus in risus quis lectus iaculis vulputate id quis nisl.</li>
</ul>';
$staticContent.='<blockquote><p>&nbsp;Neque porro quisquam est, qui dolorem ipsum quia dolor sit amet, consectetur, adipisci velit, sed quia non numquam eius modi tempora.&nbsp;</p><small>BRIAN NUNN - <cite>Company CEO</cite></small></blockquote>';
$staticContent.='<div style="height:35px;"></div>';
$staticContent.='<div class="custom ">
	<div class="tabbable vertical_tabs "><ul class="nav fixclear"><li class="active"><a data-toggle="tab" href="#custom-tab-main-area"><span><span class="icon-comment icon-white"></span></span>MAIN AREAS OF EXPERTISE</a></li><li><a data-toggle="tab" href="#custom-tab-standard-expertise"><span><span class="icon-book icon-white"></span></span>STANDARD AREAS OF EXPERTISE</a></li><li><a data-toggle="tab" href="#custom-tab-membership"><span><span class="icon-tint icon-white"></span></span>MEMBERSHIPS</a></li><li><a data-toggle="tab" href="#custom-tab-standardgroup"><span><span class="icon-align-left icon-white"></span></span>STANDARDS GROUPS</a></li><li><a data-toggle="tab" href="#custom-tab-cvresume"><span><span class="icon-wrench icon-white"></span></span>CV/RESUMES</a></li></ul><div class="tab-content">
<div class="tab-pane active" id="custom-tab-main-area">
<h4>Support is given through a well organized forum</h4>
<p><img border="0" alt="" src="/new/images/kallyas_images/site_images/support.jpg" class="alignright"></p>
<p>Sed ut perspiciatis unde omnis iste natus error sit voluptatem accusantium doloremque laudantium, totam rem aperiam, eaque ipsa quae ab illo inventore veritatis et quasi architecto beatae vitae dicta sunt explicabo.</p>
<p>Nemo enim ipsam voluptatem quia voluptas sit aspernatur aut odit aut fugit, sed quia consequuntur magni dolores eos qui ratione voluptatem sequi nesciunt. Neque porro quisquam est, qui dolorem ipsum quia dolor sit amet, consectetur, adipisci velit, sed quia non numquam eius modi tempora incidunt ut labore et dolore magnam aliquam quaerat voluptatem.</p>
<p>Ut enim ad minima veniam, quis nostrum exercitationem ullam corporis suscipit laboriosam, nisi ut aliquid ex ea commodi consequatur? Quis autem vel eum iure reprehenderit qui in ea voluptate velit esse quam nihil molestiae consequatur, vel illum qui dolorem.</p>
</div>
<div class="tab-pane " id="custom-tab-standard-expertise">
<h4>Pane 2 Content</h4>
<p>Phasellus eget justo lacus. Vivamus pharetra ullamcorper massa, nec ultricies metus gravida egestas. Duis congue viverra arcu, ac aliquet turpis rutrum a. Donec semper vestibulum dapibus. Integer et sollicitudin metus. Vivamus at nisi turpis.</p>
</div>
<div class="tab-pane " id="custom-tab-membership">
<h4>Pane 3 Content</h4>
<p>Donec semper vestibulum dapibus. Integer et sollicitudin metus. Vivamus at nisi turpis. Phasellus vel tellus id felis cursus hendrerit. Suspendisse et arcu felis, ac gravida turpis. Suspendisse potenti. Ut porta rhoncus ligula, sed fringilla felis feugiat eget. In non purus quis elit iaculis tincidunt. Donec at ultrices est.</p>
</div>
<div class="tab-pane " id="custom-tab-standardgroup">
<h4>Pane 4 Content</h4>
<p>Phasellus eget justo lacus. Vivamus pharetra ullamcorper massa, nec ultricies metus gravida egestas. Duis congue viverra arcu, ac aliquet turpis rutrum a. Donec semper vestibulum dapibus. Integer et sollicitudin metus. Vivamus at nisi turpis.</p>
</div>
<div class="tab-pane " id="custom-tab-cvresume">
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
$staticContent.='<div class="process_steps fixclear ">
<div class="step intro"><h3>our working process <strong>in 3 steps</strong></h3>
<p>Sed ut perspiciatis unde omnis iste natus error sit voluptatem accusantium doloremque laudantium, totam rem aperiam, eaque ipsa quae ab illo inventore veritatis et quasi.</p>
<p style="margin-bottom: 0;"><a href="#">MORE ABOUT US +</a></p></div><div class="step step1 "><div data-animation="tada" class="icon"><img alt="planning &amp; strategy" src="/new/images/kallyas_images/icons/steps/ico-plan.png"></div><h3>planning &amp; strategy</h3><p>Sed ut perspiciatis unde omnis iste natus error sit voluptatem accusantium doloremque laudantium.</p></div><!-- end step --><div class="step step2 "><div data-animation="pulse" class="icon"><img alt="design &amp; develop" src="/new/images/kallyas_images/icons/steps/ico-designdev.png"></div><h3>design &amp; develop</h3><p>Sed ut perspiciatis unde omnis iste natus error sit voluptatem accusantium doloremque laudantium.</p></div><!-- end step --><div class="step step3 last_step"><div data-animation="fadeOutRightBig" class="icon"><a target="_self" href="#"><img alt="test &amp; deliver" src="/new/images/kallyas_images/icons/steps/ico-launch.png"></a></div><h3>test &amp; deliver</h3><p>Sed ut perspiciatis unde omnis iste natus error sit voluptatem accusantium doloremque laudantium.</p></div><!-- end step -->	
</div>';
$staticContent.='<div style="height:35px;"></div>';

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
		 
		<div class="tabbable tabs_style1">
			<ul class='nav fixclear'>
				<li class='active'><a href="#profile-tab" data-toggle="tab">Profile</a></li>
				<li class=''><a href="#feedback-tab" data-toggle="tab">Feedback</a></li>
				<li class=''><a href="#report-tab" data-toggle="tab">My Report</a></li>
				<li class=''><a href="#process-tab" data-toggle="tab">In Process</a></li>
				<?php if($sessionEXpertID>0):?>
				<li class=''><a href="#oppotunities-tab" data-toggle="tab">Opportunities</a></li>
				<li class=''><a href="#expertise-tab" data-toggle="tab">My Experties</a></li>
				<?php endif;?>
			</ul>
			<div class='tab-content'>
				<div id="profile-tab" class="tab-pane active">
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
							$descriptionData = $expert->description;
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
				</div>
				<div id="feedback-tab" class="tab-pane ">
					<div class="row-fluid">
						
							<?php
							$getExpertFeedback = SurveyModelCustomer::expertRatingDataDetail(JRequest::getInt('display'));
							if (count($getExpertFeedback) > 0) {
								?>
								<div class="span12">
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
								</div>
								<?php
							} else {
								?>
								<div class="span11">
									<div class="displayB" style="min-height:100px;">
										<p class="alert alert-info">No feedback history for this expert!</p>
									</div>
								</div>
								<?php
							}
							?>
						
					</div>
				</div>
				<div id="report-tab" class="tab-pane ">
					<div class="row-fluid">

                <?php
                $expertReports = SurveyModelCustomer::getExpertReportsWithProject(JRequest::getInt('display'));
                if (count($expertReports) > 0) {
                    ?>
                    <div class="span2" style="width:65px;margin-left: 0px;">
                        <legend style="font-size:14px;height:60px; font-weight:bold; color:#cd2122 !important; white-space:nowrap;"
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
                        jQuery(".loader").before('<legend class="noMargin" style="font-size: 14px; font-weight: bold; color: #cd2122 !important; white-space: nowrap; padding-left: 10px;height:60px">Claim</legend>');
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
                                __LegendGrid2 = jQuery('<legend/>').addClass('noMargin').append('Elements').css({height: '60px', fontSize: '14px', fontWeight: 'bold', color: '#cd2122', whiteSpace: 'wrap'});
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
                                                    jQuery(_TR).append("<th valign='top' class='" + __data['expert'][s].id + "' style='text-align:center;height:33px;border-bottom:1px solid #E5E5E5 !important;color:#cd2122 !important'>" + __data['expert'][s].name + "</th>");
                                                } else {
                                                    jQuery(_TR).append("<th valign='top' class='" + __data['expert'][s].id + "' style='text-align:center;height:33px;border-bottom:1px solid #E5E5E5 !important;color:#cd2122 !important'><a target='_BLANK' href='" + _siteURL + "index.php?option=com_survey&task=customer.expertProfile&display=" + __data['expert'][s].id + "'>" + __data['expert'][s].name + "</a></th>");
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
                                                            __A = jQuery("<a/>").addClass('btn btn-medium btn-flat').attr('data-target', __data['survey'][am].target).data('expertEmail', __data['expert'][s].paypal_id).click(function() {
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
                                                            __A = jQuery("<a/>").addClass('btn btn-medium btn-flat').attr('data-target', __data['survey'][am].target).data('expertEmail', __data['expert'][s].paypal_id).click(function() {
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
				</div>
				<div id="process-tab" class="tab-pane ">
					<script>
						getInProcessArray = []
					</script>   
					<div class="row-fluid">
						<div class="span12">
							<?php
								$getInProcessData = SurveyModelCustomer::expertInProcessData(JRequest::getInt('display'));
								if (count($getInProcessData) > 0) {
                            ?>
								<div class="span12" style="text-align:left">
									<span class='m_title'>Select a ClaimChart and <a class='btn btn-medium btn-flat' id="button-claim1" href="javascript://">Continue Editing</a>.&nbsp;If you wish to delete a ClaimChart, select it and <a class='btn btn-medium- btn-flat' id="button-claim2" href="javascript://"onclick="deleteInProcessClaim();">Delete</a>.</span>
								</div>
								<div class="span4" style="margin-left: 0px;">
                            <input type="hidden" name="process_delete" id="process_delete"/>
                            <table id="process-data" class="table sortingTable1">
                                <thead>
                                    <tr>
                                        <!--<th align="left" width="">#</th>-->
                                        <th align="left" style='padding:8px 0px;border-bottom: 1px solid #DDDDDD;color:#cd2122 !important'>Deadline</th>
                                        <th align="left" style='padding:8px 0px;border-bottom: 1px solid #DDDDDD;color:#cd2122 !important'>Claim</th>
                                        <th align="left" style='padding:8px 0px;border-bottom: 1px solid #DDDDDD;color:#cd2122 !important'>My Target
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
							<?php } else {?>
									<div class="span11 noMargin">
										<div class="displayB" style="min-height:100px;">
											<p class="alert alert-info">No record found!</p>
										</div>
									</div>
							<?php } ?>
						</div>
					</div>
				</div>
				<?php if($sessionEXpertID>0):?>
				<div id="oppotunities-tab" class="tab-pane ">
					<?php 
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
                                    <span class='m_title'>Select a Claim below and &nbsp;<a class='btn btn-medium btn-flat' id="button-claim"
                                                                            href="javascript://">Start a New ClaimChart</a></span>
                                </div>
                            </div>

                        </div>
                        <div class="span4" style="margin-left: 0px;">
                            <table width="100%" id="opportunites-data" class="table sortingTable">
                                <thead>
                                    <tr>
                                        <th align="left" width="" style='padding:8px 0px;border-bottom: 1px solid #DDDDDD;color:#cd2122 !important'>Posted
                                        </th>
                                        <th align="left" width="" style='padding:8px 0px;border-bottom: 1px solid #DDDDDD;color:#cd2122 !important'>
                                            Deadline
                                        </th>
                                        <th align="left" width="" style='padding:8px 0px;border-bottom: 1px solid #DDDDDD;color:#cd2122 !important'>Claim
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

                        <div class="span11">
                            <div class="displayB" style="min-height:100px;">
                                <p class="alert alert-info">No record found!</p>
                            </div>
                        </div>
                        <?php
                    }
                    ?>
                </div>
				</div>
				<div id="expertise-tab" class="tab-pane ">
					<?php 
						$parent = ($this->parentData);
						$child = ($this->childData);
						$expert = $this->expertSession;
						$expertArea = $this->expertExpertiseArea;
						$firstMainAreaParent = $this->firstMainAreaParent;		
						$expertAreaArray = array();
						if(count($expertArea)>0){
							for($i=0;$i<count($expertArea);$i++){
								$expertAreaArray[] = $expertArea[$i]->area_id;
							}
						}

					?>
					<style>
#patent tbody tr td label a{font-weight: bold; color: hsl(3, 95%, 38%) !important; font-size:12px; font-family:arial}
#patent tbody tr td p{font-weight: bold; text-align:left !important;  color: #0E2034; font-size:12px; font-family:arial}
#patent thead tr th p{font-weight: bold; text-align:left !important; color: #0E2034; font-size:12px; font-family:arial}
#patent tbody tr td{padding:0px; line-height:14px !important;}
#patent tbody tr td label{margin:0px; line-height:normal}
#patent tbody tr td{border-bottom: 1px solid hsl(210, 3%, 77%); background:none !important; padding-top:4px; padding-bottom:4px;}

#patent thead tr th{border-bottom: 1px solid hsl(210, 3%, 77%); background:none !important; padding-top:4px; padding-bottom:4px; padding-left:0px}

td.dot{font-weight:bold; font-size:14px; color:#000; padding-left:2px !important; padding-right:2px !important; padding-top:6px !important;}
table.customTable tbody tr td{border:0px solid #fff !important}
table.customTable tbody tr td{padding-top:0px !important; padding-bottom:0px}
#patent tbody tr td.arrow{background:#3A414D url(../img/arrowTop.png) no-repeat 4px 7px !important; width:2%}
#patent tbody tr td.arrow2{background:#E9E7D9 url(../img/aow.jpg) no-repeat 4px 7px !important; width:2%}
#patent.table.table > tbody > tr.hover1:hover > td{ border-top:1px solid #000000 !important; border-bottom:1px solid #000 !important;}

#patent tbody tr td.check-align{
	padding-left:10px !important;
	text-align:right !important;
}
.classitemFocus{
	background-color:#EFEFEF !important;
	color:#0E2034 !important;
}
span.dot{
	display:inlin-block;
	font-size:150%;
	line-height:50%;
	padding-top:0.15em;
	margin-right:3px;
}
</style>
<form action="index.php" method="post">
<div class="row-fluid">
				<div class="span12" style="background:#fff;">
					<table class="table table-striped" id="patent">						
							<thead>
								<tr style="background:#BDC2C7; border-top:1px solid hsl(210, 4%, 62%);">
									<th width="5%"></th>
									<th width="7%"  style="text-align:center;"><p class="noMargin">Symbol</p></th>
									<th width="88%"><p class="noMargin">Classification and description</p></th>
								</tr>
							</thead>
							<tbody>
							<?php 
								if(count($parent)>0){
							?>
								<tr class="classitemFocus">
									<td class="check-align"><input type="checkbox" name="parent_checked" style="margin-right:5px !important;" value="<?php echo $parent->id;?>" onclick="checkBoxClick(jQuery(this),0);"></td>
									<td style="width:7%">	
										<label>									
											<a href="javascript:void(0);" onclick="getChildData(jQuery(this),0)" rel="<?php echo $parent->id;?>" style="padding-top:3px; display:inline-block;"><?php echo $parent->name;?></a>
										 </label>
									</td>
									<td style="width:88%">
										<p class="noMargin" style="margin-top:4px !important;"><?php echo $parent->classification_description;?></p>
									</td>
								</tr>
								<tr>
									<td height="20px;" colspan="3">
									
									</td>
								</tr>
							<?php
									if(count($child)>0){
										for($i=0;$i<count($child);$i++){
											$row = $child[$i];
											$checked = "";
											$spanC="";
											if(in_array($row->id,$expertAreaArray)){
												$checked = "CHECKED='CHECKED'";
											}
											if(count($firstMainAreaParent)>0){
												if($firstMainAreaParent->id==$row->id){
													$spanC="<span class='highlighterC' style='float:left;margin-top:3px;'>C</span>";
												}
											}
							?>
											<tr class='child'>
												<td class="check-align">
												<?php echo $spanC;?>
												<input type="checkbox" onclick="checkBoxClick(jQuery(this),1);" <?php echo $checked;?> name="child_1[]" class="" style="margin-right:5px !important;" value="<?php echo $row->id; ?>"></td>
												<td style="width:7%">
													<label>
														<a href="javascript:void(0);"   onclick="getChildData(jQuery(this),1)" rel="<?php echo $row->id;?>" style="padding-top:3px; display:inline-block;"><?php echo $row->name;?></a>
													</label>
												</td>
												<td style="width:88%">
													<p class="noMargin" style="margin-top:4px !important;"><?php echo $row->classification_description;?></p>
												</td>
											</tr>
							<?php
										}
									}
								}
							?>
						</tbody>
					</table>
				</div>
			</div>
			<script>
				_siteURL = '<?php echo JUri::base();?>';
				_expertArea = [
				<?php
					for($i=0;$i<count($expertArea);$i++){
						echo (int)$expertArea[$i]->area_id;
						if($i<count($expertArea)-1){
							echo ",";
						}
					}
					?>
				];
				function getChildData(object,level){					
					_getParentID = object.attr('rel');					
					object.addClass('active');
					_parentObject = object.parent().parent().parent().index();
					jQuery("#patent>tbody>tr").each(function(index){
						if(index>0){
							jQuery(this).removeClass('classitemFocus');
						}		 					
					});	
					jQuery('#child1Table>tbody>tr').each(function(index){
						jQuery(this).removeClass('classitemFocus');
					});	
					jQuery('#child2Table>tbody>tr').each(function(index){
						jQuery(this).removeClass('classitemFocus');
					});						
					object.parent().parent().parent().addClass('classitemFocus');
					if(parseInt(_getParentID)>0){
						jQuery.ajax({
							url:_siteURL+'index.php',
							type:'POST',
							data:{option:'com_survey',task:'customer.childData',pat:_getParentID,l:level,format:''},
							cache:false,
							success:function(data){
								_parsingData = jQuery.parseJSON(data);
								if(_parsingData.length>0){	
																		
									switch(parseInt(level)){
										case 0:
											jQuery('#patent>tbody>tr').each(function(index){
												if(index>1){
													jQuery(this).remove();
												}
											});					
											_checkCheckBox = object.parent().parent().parent().find('input[name="parent_checked"]').is(':checked');
											_checkString = "";												
											if(_checkCheckBox==true){
												_checkString = 'CHECKED="CHECKED"';
											}
																							
											for(i=0;i<_parsingData.length;i++){
												if(_expertArea.length>0 && _checkString==''){
													_checkString = '';
													if(jQuery.inArray(_parsingData[i].id,_expertArea)){
														_checkString = 'CHECKED="CHECKED"';
													} else {
														_checkString = 'CHECKED="CHECKED"';
													}
												}
												appendChildTr = jQuery('<tr/>').addClass('child');
												jQuery(appendChildTr).append('<td class="check-align"><input '+_checkString+' type="checkbox" name="child_1[]" onclick="checkBoxClick(jQuery(this),1)" value="'+_parsingData[i].id+'" style="margin-right:5px !important;"/></td><td width="7%"><label><a style="padding-top:3px; display:inline-block;" rel="'+_parsingData[i].id+'" href="javascript:void(0);" onclick="getChildData(jQuery(this),1)">'+_parsingData[i].name+'</a></label></td><td width="88%;"><p style="margin-top:4px !important;" class="noMargin">'+_parsingData[i].classification_description+'</p></td>');
												jQuery('#patent>tbody').append(appendChildTr);
											}													
										break;
										case 1:																					
											if(jQuery('#patent>tbody>tr').eq(_parentObject).next().attr('class')=='relatedData'){
												if(jQuery('#patent>tbody>tr').eq(_parentObject).next().css('display')=='none'){
													jQuery('#patent>tbody>tr').eq(_parentObject).next().css('display','table-row');
												} else {
													jQuery('#patent>tbody>tr').eq(_parentObject).next().css('display','none');
												}
											} else {
											appendTr = jQuery('<tr/>').addClass('relatedData').css('display','table-row');
											appendTd = jQuery('<td/>').attr('colspan','3');
											appendTable = jQuery('<table/>').addClass('table table-striped').attr('id','child1Table');		 		
											_checkCheckBox = object.parent().parent().parent().parent().find('input[name="child_1[]"]').is(':checked');
											_checkString = "";												
											if(_checkCheckBox==true){
												_checkString = 'CHECKED="CHECKED"';
											} 
											_flag=0;
											for(i=0;i<_parsingData.length;i++){
												if(_checkString==""){
													if(_expertArea.length>0){
														_checkString = '';							
														if(jQuery.inArray(parseInt(_parsingData[i].id),_expertArea)>=0){									
															
															_flag=1;
															_checkString = 'CHECKED="CHECKED"';
														}else {
															_checkString = '';
														}
													}
												}
												appendChildTr = jQuery('<tr/>');
												jQuery(appendChildTr).append('<td class="check-align"><input '+_checkString+' type="checkbox" name="child_2[]" onclick="checkBoxClick(jQuery(this),2)" value="'+_parsingData[i].id+'" style="margin-right:5px !important;"/></td><td width="7%"><label><a style="padding-top:3px; display:inline-block;" rel="'+_parsingData[i].id+'" href="javascript:void(0);" onclick="getChildData(jQuery(this),2)">'+_parsingData[i].name+'</a></label></td><td width="88%;"><p style="margin-top:4px !important;" class="noMargin">'+_parsingData[i].classification_description+'</p></td>');
												jQuery(appendTable).append(appendChildTr);
												if(_flag==1){
													_checkString = '';
												}
											}
											jQuery(appendTd).append(appendTable);
											jQuery(appendTr).append(appendTd);
											jQuery('#patent>tbody>tr').eq(_parentObject).after(appendTr);
											}
										break;
										case 2:											
											if(jQuery('#child1Table>tbody>tr').eq(_parentObject).next().attr('class')=='relatedData1'){
												if(jQuery('#child1Table>tbody>tr').eq(_parentObject).next().css('display')=='none'){
													jQuery('#child1Table>tbody>tr').eq(_parentObject).next().css('display','table-row');
												} else {
													jQuery('#child1Table>tbody>tr').eq(_parentObject).next().css('display','none');
												}
											} else {
											appendTr = jQuery('<tr/>').addClass('relatedData1').css('display','table-row');
											appendTd = jQuery('<td/>').attr('colspan','3');
											appendTable = jQuery('<table/>').addClass('table table-striped').attr('id','child2Table');		
											_checkCheckBox = object.parent().parent().parent().parent().find('input[name="child_2[]"]').is(':checked');
											_checkString = "";												
											if(_checkCheckBox==true){
												_checkString = 'CHECKED="CHECKED"';
											}
											_flag=0;
											for(i=0;i<_parsingData.length;i++){
												if(_checkString==""){
													if(_expertArea.length>0){
														_checkString = '';														
														if(jQuery.inArray(parseInt(_parsingData[i].id),_expertArea)>=0){														
															_flag=1;
															_checkString = 'CHECKED="CHECKED"';
														}else {
															_checkString = '';
														}
													}
												}
												appendChildTr = jQuery('<tr/>').css({background:'#E9E7D9'});
												jQuery(appendChildTr).append('<td class="check-align"><input '+_checkString+' type="checkbox" name="child_3[]" onclick="checkBoxClick(jQuery(this),3)" value="'+_parsingData[i].id+'" style="margin-right:5px !important;"/></td><td width="7%"><label><a style="padding-top:3px; display:inline-block;"  rel="'+_parsingData[i].id+'" href="javascript:void(0);" onclick="getChildData(jQuery(this),3)">'+_parsingData[i].name+'</a></label></td><td width="88%;"><p style="margin-top:4px !important;" class="noMargin">'+_parsingData[i].classification_description+'</p></td>');
												jQuery(appendTable).append(appendChildTr);
												if(_flag==1){
													_checkString = '';
												}
											}
											jQuery(appendTd).append(appendTable);
											jQuery(appendTr).append(appendTd);
											jQuery('#child1Table>tbody>tr').eq(_parentObject).after(appendTr);
											}
										break;
										case 3:											
											if(jQuery('#child2Table>tbody>tr').eq(_parentObject).next().attr('class')=='relatedData2'){
												if(jQuery('#child2Table>tbody>tr').eq(_parentObject).next().css('display')=='none'){
													jQuery('#child2Table>tbody>tr').eq(_parentObject).next().css('display','table-row');
												} else {
													jQuery('#child2Table>tbody>tr').eq(_parentObject).next().css('display','none');
												}
											} else {
											appendTr = jQuery('<tr/>').addClass('relatedData2').css('display','table-row');								
											appendTd = jQuery('<td/>').attr('colspan','3');
											appendTable = jQuery('<table/>').addClass('table table-striped').attr('id','child3Table');		
											_checkCheckBox = object.parent().parent().parent().find('input[name="child_3[]"]').is(':checked');
											_checkString = "";												
											if(_checkCheckBox==true){
												_checkString = 'CHECKED="CHECKED"';
											}
											_flag=0;
											for(i=0;i<_parsingData.length;i++){
												appendChildTr = jQuery('<tr/>').css({background:'#000000'});
												_stringDot = '';
												if(parseInt(_parsingData[i].level)>0){
													for(st=0;st<parseInt(_parsingData[i].level);st++){
														_stringDot+="<span class='dot'>&#8226;</span>";
													}
												}
												if(_checkString==""){
													if(_expertArea.length>0){
														_checkString = '';
														if(jQuery.inArray(parseInt(_parsingData[i].id),_expertArea)>=0){												
															_flag=1;
															_checkString = 'CHECKED="CHECKED"';
														}else {
															_checkString = '';
														}
													}
												}
												jQuery(appendChildTr).append('<td class="check-align"><input '+_checkString+' type="checkbox" name="child_4[]" onclick="checkBoxClickWithParent(jQuery(this),'+_parsingData[i].id+')" big_parent="'+_parsingData[i].big_parent+'" parent="'+_parsingData[i].parent+'" value="'+_parsingData[i].id+'" style="margin-right:5px !important;"/></td><td width="12%"><label><a style="padding-top:3px; display:inline-block;"  href="javascript:void(0);" >'+_parsingData[i].name+'</a></label></td><td width="83%;"><p style="margin-top:4px !important;" class="noMargin">'+_stringDot+' '+_parsingData[i].classification_description+'</p></td>');
												jQuery(appendTable).append(appendChildTr);
												if(_flag==1){
													_checkString = '';
												}
											}
											jQuery(appendTd).append(appendTable);
											jQuery(appendTr).append(appendTd);
											jQuery('#child2Table>tbody>tr').eq(_parentObject).after(appendTr);
											}
										break;
									}
									
								}
							}
						});
					}
				}
				
				function checkBoxClick(object,level){
					switch(level){
						case 0:
							if(object.is(':checked')){
								jQuery("#patent>tbody>tr.child").each(function(){
									jQuery(this).find('input[name="child_1[]"]').attr('checked','checked');
									jQuery(this).find('input[name="child_2[]"]').attr('checked','checked');
									jQuery(this).find('input[name="child_3[]"]').attr('checked','checked');
									jQuery(this).find('input[name="child_4[]"]').attr('checked','checked');
								}); 
							} else {
								jQuery("#patent>tbody>tr.child").each(function(){
									jQuery(this).find('input[name="child_1[]"]').removeAttr('checked');
									jQuery(this).find('input[name="child_2[]"]').removeAttr('checked','checked');
									jQuery(this).find('input[name="child_3[]"]').removeAttr('checked','checked');
									jQuery(this).find('input[name="child_4[]"]').removeAttr('checked','checked');
								});
							}							
						break;
						case 1:
							if(object.is(':checked')){								
								jQuery(".relatedData>td>#child1Table>tbody>tr").each(function(){
									jQuery(this).find('input[name="child_2[]"]').attr('checked','checked');
									jQuery(this).find('input[name="child_3[]"]').attr('checked','checked');
									jQuery(this).find('input[name="child_4[]"]').attr('checked','checked');
								});
							} else {
								jQuery(".relatedData>td>#child1Table>tbody>tr").each(function(){
									jQuery(this).find('input[name="child_2[]"]').removeAttr('checked');
									jQuery(this).find('input[name="child_3[]"]').removeAttr('checked','checked');
									jQuery(this).find('input[name="child_4[]"]').removeAttr('checked','checked');
								});
							}
						break;
						case 2:
							if(object.is(':checked')){								
								jQuery(".relatedData1>td>#child2Table>tbody>tr").each(function(){
									jQuery(this).find('input[name="child_3[]"]').attr('checked','checked');
									jQuery(this).find('input[name="child_4[]"]').attr('checked','checked');
								});
							} else {
								jQuery(".relatedData1>td>#child2Table>tbody>tr").each(function(){
									jQuery(this).find('input[name="child_3[]"]').removeAttr('checked');
									jQuery(this).find('input[name="child_4[]"]').removeAttr('checked','checked');
								});
							}
						break;
						case 3:
							if(object.is(':checked')){								
								jQuery(".relatedData2>td>#child3Table>tbody>tr").each(function(){
									jQuery(this).find('input[name="child_4[]"]').attr('checked','checked');
								});
							} else {
								jQuery(".relatedData2>td>#child3Table>tbody>tr").each(function(){
									jQuery(this).find('input[name="child_4[]"]').removeAttr('checked');
								});
							}
						break;
					}					
				}
				
				function checkBoxClickWithParent(object,parentVal){
					if(object.is(':checked')){
						jQuery(".relatedData2>td>#child3Table>tbody>tr").each(function(){
								_getParent = jQuery(this).find('input[name="child_4[]"]').attr('parent');
								_getBigParent = jQuery(this).find('input[name="child_4[]"]').attr('big_parent');
								if(_getParent ==parentVal || _getBigParent==parentVal){
									jQuery(this).find('input[name="child_4[]"]').attr('checked','checked');
								}
							});
					} else {
						jQuery(".relatedData2>td>#child3Table>tbody>tr").each(function(){
								_getParent = jQuery(this).find('input[name="child_4[]"]').attr('parent');
								_getBigParent = jQuery(this).find('input[name="child_4[]"]').attr('big_parent');
								if(_getParent ==parentVal || _getBigParent==parentVal){
									jQuery(this).find('input[name="child_4[]"]').removeAttr('checked');
								}
							});
					}					
				}
			</script>
<div class='displayB'>
<button type="submit" class="btn btn-medium btn-flat" style='border:0 !important'>Save Changes <span>&raquo;</span></button>
</div>
					<input type="hidden" name="option" value="com_survey"/>
					<input type="hidden" name="e" value="<?php echo $expert->id;?>"/>
					<input type="hidden" name="task" value="customer.updateAreaExpertise"/>
				</form>
				</div>
				<?php endif;?>
			</div>
		</div>
     </div>
    
    
<?php else: ?>
    <div class="row-fluid">
        <div class="span12">
            <p>Sorry Page not found!</p>
        </div>
    </div>
<?php endif; ?>

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
                _TH = jQuery("<thead/>").append("<tr><th align='left' style='padding:8px 0px;color:#cd2122 !important;border-bottom: 1px solid #DDDDDD' width='50%'>Elements</th><th align='left' style='color:#cd2122 !important;border-bottom: 1px solid #DDDDDD' width='10%'>Target</th><th align='left' width='10%' style='color:#cd2122 !important;border-bottom: 1px solid #DDDDDD'>Avoided</th><th align='left' style='color:#cd2122 !important;border-bottom: 1px solid #DDDDDD' width='10%'>Comments</th></tr>");
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
                _TH = jQuery("<thead/>").append("<tr><th align='left' style='padding:8px 0px;color:#cd2122 !important;border-bottom: 1px solid #DDDDDD' width='50%'>Elements</th><th align='left' style='color:#cd2122 !important;border-bottom: 1px solid #DDDDDD' width='10%'>Target</th><th align='left' width='10%' style='color:#cd2122 !important;border-bottom: 1px solid #DDDDDD'>Avoided</th><th align='left' style='color:#cd2122 !important;border-bottom: 1px solid #DDDDDD' width='10%'>Comments</th></tr>");
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
