<?php
// No direct access to this file
defined('_JEXEC') or die('Restricted access');
$expert = $this->expert;
$rating = $this->rating;

$profileUser = JFactory::getUser();

$sessionEXpertID = 0;
if (is_object($profileUser) && $profileUser->id > 0) {

    $sessionEXpertID = $expert->id;
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

$staticContent='<h2 class="subtitle hugetitle" style="font-size: 36px; color: #595959;" id="subtitle" data-attr="15" data-class="rLeft" data-char="120">';
if(!empty($expert->sub_title)){
	$staticContent.=stripslashes($expert->sub_title);
} else {
$staticContent .='<p style="margin:0px">Welcome to Kallyas Joomla Template, a wonderful and premium product for multipurpose websites&nbsp;</p>';
}
$staticContent .='</h2>';
$staticContent.='<div style="float:right" id="skills_diagram" data-attr="9" data-class="" data-char="0">
	<div class="legend">
		<h4>Legend:</h4>';		
if(!empty($expert->skills)){
	$staticContent.=stripslashes($expert->skills);
} else {		
		$staticContent.='<ul class="skills">
<li style="background-color:#97BE0D;" data-percent="95">JavaScript</li><li style="background-color:#D84F5F;" data-percent="90">CSS3</li><li style="background-color:#88B8E6;" data-percent="80">HTML5</li><li style="background-color:#BEDBE9;" data-percent="53">PHP</li><li style="background-color:#EDEBEE;" data-percent="45">MySQL</li>	
		</ul><!-- end the skills -->';
	}	
		
	$staticContent.='</div>
	<div data-textcolor="#ffffff" data-fontsize="20px Arial" data-maintext="Skills" data-maincolor="#193340" data-height="600" data-width="600" id="thediagram"></div>
</div>';
$staticContent.='<div id="image_desc" data-char="640" data-attr="1" data-class="">';
if(!empty($expert->profile_desc)){
	$staticContent.=stripslashes($expert->profile_desc);
} else {
$staticContent.='<img border="0" alt="" src="'.JUri::base().'images/kallyas_images/aboutus.jpg" class="alignleftborder"><p>Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat.</p>';
$staticContent.='<p>Sed ut perspiciatis unde omnis iste natus error sit voluptatem accusantium doloremque laudantium, totam rem aperiam, eaque ipsa quae ab illo inventore veritatis et quasi architecto beatae vitae dicta sunt explicabo. Nemo enim ipsam voluptatem quia voluptas sit aspernatur aut odit aut fugit, sed quia consequuntur magni dolores eos qui ratione voluptatem sequi nesciunt.</p>';
}
$staticContent.='</div>';
$staticContent.='<p class="m_title"></p>';
$staticContent.='<div id="choose_us" data-char="760" data-attr="2" data-class="">';
if(!empty($expert->choose_us)){
	$staticContent.='<h4 style="text-align:left; ;" class="m_title ">MAIN AREA OF EXPERTISE&nbsp;</h4>';
	$staticContent.=stripslashes($expert->choose_us);
} else {
$staticContent.='<h4 style="text-align:left; ;" class="m_title ">MAIN AREA OF EXPERTISE&nbsp;</h4>';
$staticContent.='<ul style="margin-bottom: 20px;" class="list-style1">
<li data-char="190">Fusce sit amet orci quis arcu vestibulum vestibulum sed ut felis. Phasellus in risus quis lectus iaculis vulputate id quis nisl.</li>
<li data-char="190">Phasellus in risus quis lectus iaculis vulputate id quis nisl.</li>
<li data-char="190">Fusce sit amet orci quis arcu vestibulum vestibulum sed ut felis.</li>
<li data-char="190">Phasellus in risus quis lectus iaculis vulputate id quis nisl.</li>
</ul>';
}
$staticContent.='</div>';
$staticContent.='<div id="testimonial" data-char="195" data-attr="3" data-class="rLeft">';
if(!empty($expert->testimonial)){
	$staticContent.=stripslashes($expert->testimonial);
} else {
$staticContent.='<blockquote><p>&nbsp;Neque porro quisquam est, qui dolorem ipsum quia dolor sit amet, consectetur, adipisci velit, sed quia non numquam eius modi tempora.&nbsp;</p><small>BRIAN NUNN - <cite>Company CEO</cite></small></blockquote>';
}
$staticContent.='</div>';
$staticContent.='<div style="height:35px;"></div>';
$staticContent.='<div class="custom ">
	<div class="tabbable vertical_tabs "><ul class="nav fixclear"><li class="active"><a data-toggle="tab" href="#custom-tab-main-area"><span><span class="icon-comment icon-white"></span></span>EDUCATION AND AWARDS</a></li><li><a data-toggle="tab" href="#custom-tab-standard-expertise"><span><span class="icon-book icon-white"></span></span>PUBLICATION AND RESEARCH</a></li><li><a data-toggle="tab" href="#custom-tab-membership"><span><span class="icon-tint icon-white"></span></span>MY PATENTS</a></li><li><a data-toggle="tab" href="#custom-tab-standardgroup"><span><span class="icon-align-left icon-white"></span></span>EXPERT WITNESS ACTIVITES</a></li><li><a data-toggle="tab" href="#custom-tab-cvresume"><span><span class="icon-wrench icon-white"></span></span>STANDARD WORKING GROUPS</a></li><li><a data-toggle="tab" href="#custom-tab-professional-membership"><span><span class="icon-wrench icon-white"></span></span>PROFESSIONAL MEMBERSHIP</a></li><li><a data-toggle="tab" href="#custom-tab-my-clients"><span><span class="icon-wrench icon-white"></span></span>MY CLIENTS</a></li><li><a data-toggle="tab" href="#custom-tab-other"><span><span class="icon-wrench icon-white"></span></span>OTHER</a></li></ul><div class="tab-content">
<div class="tab-pane active" id="custom-tab-main-area" data-char="800" data-attr="4" data-class="rRight">';
if(!empty($expert->main_area)){
	$staticContent.=stripslashes($expert->main_area);
} else {

$staticContent.='<h4 data-char="47">Support is given through a well organized forum</h4>
<p><img border="0" alt="" src="'.JUri::base().'images/kallyas_images/site_images/support.jpg" class="alignright"></p>
<p data-char="800">Sed ut perspiciatis unde omnis iste natus error sit voluptatem accusantium doloremque laudantium, totam rem aperiam, eaque ipsa quae ab illo inventore veritatis et quasi architecto beatae vitae dicta sunt explicabo.</p>
<p data-char="800">Nemo enim ipsam voluptatem quia voluptas sit aspernatur aut odit aut fugit, sed quia consequuntur magni dolores eos qui ratione voluptatem sequi nesciunt. Neque porro quisquam est, qui dolorem ipsum quia dolor sit amet, consectetur, adipisci velit, sed quia non numquam eius modi tempora incidunt ut labore et dolore magnam aliquam quaerat voluptatem.</p>
<p data-char="800">Ut enim ad minima veniam, quis nostrum exercitationem ullam corporis suscipit laboriosam, nisi ut aliquid ex ea commodi consequatur? Quis autem vel eum iure reprehenderit qui in ea voluptate velit esse quam nihil molestiae consequatur, vel illum qui dolorem.</p>';
}

$staticContent.='</div>
<div class="tab-pane " id="custom-tab-standard-expertise" data-char="800" data-attr="5" data-class="">';

if(!empty($expert->standard_area)){
	$staticContent.=stripslashes($expert->standard_area);
} else {
$staticContent.='<h4 data-char="47">Pane 2 Content</h4>
<p data-char="800">Phasellus eget justo lacus. Vivamus pharetra ullamcorper massa, nec ultricies metus gravida egestas. Duis congue viverra arcu, ac aliquet turpis rutrum a. Donec semper vestibulum dapibus. Integer et sollicitudin metus. Vivamus at nisi turpis.</p>';
}
if(!empty($expert->new_membership)){
	$staticContent.=stripslashes($expert->new_membership);
} else {
$staticContent.='</div>
<div class="tab-pane " id="custom-tab-membership" data-attr="6" data-char="800" data-class="">';
$staticContent.='<h4 data-char="47">Pane 3 Content</h4>
<p data-char="800">Donec semper vestibulum dapibus. Integer et sollicitudin metus. Vivamus at nisi turpis. Phasellus vel tellus id felis cursus hendrerit. Suspendisse et arcu felis, ac gravida turpis. Suspendisse potenti. Ut porta rhoncus ligula, sed fringilla felis feugiat eget. In non purus quis elit iaculis tincidunt. Donec at ultrices est.</p>';

}
if(!empty($expert->standard_group)){
	$staticContent.=stripslashes($expert->standard_group);
} else {
$staticContent.='</div>
<div class="tab-pane " id="custom-tab-standardgroup" data-attr="7" data-char="800" data-class="">';
$staticContent.='<h4 data-char="47">Pane 4 Content</h4>
<p data-char="800">Phasellus eget justo lacus. Vivamus pharetra ullamcorper massa, nec ultricies metus gravida egestas. Duis congue viverra arcu, ac aliquet turpis rutrum a. Donec semper vestibulum dapibus. Integer et sollicitudin metus. Vivamus at nisi turpis.</p>';

}
$staticContent.='</div>
<div class="tab-pane " id="custom-tab-cvresume" data-attr="8" data-char="800" data-class="">';
if(!empty($expert->cv_resume)){
	$staticContent.=stripslashes($expert->cv_resume);
} else {
$staticContent.='
<h4 data-char="47">Pane 5 Content</h4>
<p data-char="800">Donec semper vestibulum dapibus. Integer et sollicitudin metus. Vivamus at nisi turpis. Phasellus vel tellus id felis cursus hendrerit. Suspendisse et arcu felis, ac gravida turpis. Suspendisse potenti. Ut porta rhoncus ligula, sed fringilla felis feugiat eget. In non purus quis elit iaculis tincidunt. Donec at ultrices est.</p>';
}
$staticContent.='</div>';

$staticContent.='<div class="tab-pane " id="custom-tab-professional-membership" data-attr="15" data-char="800" data-class="">';
$staticContent.='
<h4 data-char="47">Pane 6 Content</h4>
<p data-char="800">Donec semper vestibulum dapibus. Integer et sollicitudin metus. Vivamus at nisi turpis. Phasellus vel tellus id felis cursus hendrerit. Suspendisse et arcu felis, ac gravida turpis. Suspendisse potenti. Ut porta rhoncus ligula, sed fringilla felis feugiat eget. In non purus quis elit iaculis tincidunt. Donec at ultrices est.</p>';
$staticContent.='</div><div class="tab-pane " id="custom-tab-my-clients" data-attr="16" data-char="800" data-class="">';
$staticContent.='
<h4 data-char="47">Pane 7 Content</h4>
<p data-char="800">Donec semper vestibulum dapibus. Integer et sollicitudin metus. Vivamus at nisi turpis. Phasellus vel tellus id felis cursus hendrerit. Suspendisse et arcu felis, ac gravida turpis. Suspendisse potenti. Ut porta rhoncus ligula, sed fringilla felis feugiat eget. In non purus quis elit iaculis tincidunt. Donec at ultrices est.</p>';
$staticContent.='</div><div class="tab-pane " id="custom-tab-other" data-attr="17" data-char="800" data-class="">';
$staticContent.='
<h4 data-char="47">Pane 8 Content</h4>
<p data-char="800">Donec semper vestibulum dapibus. Integer et sollicitudin metus. Vivamus at nisi turpis. Phasellus vel tellus id felis cursus hendrerit. Suspendisse et arcu felis, ac gravida turpis. Suspendisse potenti. Ut porta rhoncus ligula, sed fringilla felis feugiat eget. In non purus quis elit iaculis tincidunt. Donec at ultrices est.</p>';
$staticContent.='</div>

</div></div>
</div>';
$staticContent.='<div style="height:35px;"></div>';
$staticContent.='<div class="custom ">
	<div data-grid="first" class="row"><div class="span12"><h3 class="mb_title"><img alt="" src="'.JUri::base().'images/kallyas_images/icons/ico-stats.png"> STATS</h3>
</div>
<div class="span3"><div class="statbox">
		<img alt="" src="'.JUri::base().'images/kallyas_images/icons/stats/ico-finished-projects.png">
<h4 id="completed_claim" data-attr="11" data-class="" data-char="0"><p style="display:inline-block;">';
if(!empty($expert->completed_claim)){
	$staticContent.=stripslashes($expert->completed_claim);
} else {
$staticContent.='150';
}
$staticContent.='</p>+</h4>
<h6>COMPLETED CLAIMCHARTS</h6>
	</div>
</div>
<div class="span3"><div class="statbox">
		<img alt="" src="'.JUri::base().'images/kallyas_images/icons/stats/ico-code-lines.png">
<h4 id="completed_priorart" data-attr="12" data-class="" data-char="0"><p style="display:inline-block;">';
if(!empty($expert->completed_priorart)){
	$staticContent.=stripslashes($expert->completed_priorart);
} else {
$staticContent.='2500';
}
$staticContent.='</p>+</h4>
<h6>COMPLETED PRIORARTS</h6>
	</div>
</div><div class="span3"><div class="statbox">
		<img alt="" src="'.JUri::base().'images/kallyas_images/icons/stats/ico-testimonials.png">
<h4 id="sold_report" data-attr="13" data-class="" data-char="0"><p style="display:inline-block;">';
if(!empty($expert->sold_report)){
	$staticContent.=stripslashes($expert->sold_report);
} else {
$staticContent.='120';
}

$staticContent.='</p>+</h4>
<h6>SOLD REPORTS</h6>
	</div>
</div>
<div class="span3"><div class="statbox">
		<img alt="" src="'.JUri::base().'images/kallyas_images/icons/stats/ico-working-hours.png">
<h4 id="working_hours" data-attr="14" data-class="" data-char="0"><p style="display:inline-block;">';
if(!empty($expert->working_hour)){
	$staticContent.=stripslashes($expert->working_hour);
} else {
$staticContent.='1400';
}
$staticContent.='</p>+</h4>
<h6>WORKING HOURS THIS YEAR</h6>
	</div>
</div>
</div>
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
<input class=" btn btn-flat" id="submit-form" type="submit" name="submit" value="Send Message">
<input type="hidden" name="option" value="com_survey"/>
<input type="hidden" name="task" value="customer.contact_us"/>
<input type="hidden" name="form_usage" value="'.$expert->id.'"/>
	</div>
</div>
<!-- end control group -->
</form>
</div>
</div>
<div class="span6" id="user_address" data-attr="10" data-char="0" data-class="">
<h3>Get in touch with us</h3>
<p class="address"><strong>Address:</strong>&nbsp;';
if(!empty($expert->address)){
	$staticContent.=stripslashes($expert->address);
} else {
$staticContent.='Street Address nr 100, 4536534, Your Town, United States';
}
$staticContent.='</p>
<p class="phone"><strong>Phone:</strong> ';
if(!empty($expert->phone)){
	$staticContent.=stripslashes($expert->phone);
} else {
$staticContent.='(212) 555 55 00';
}


$staticContent.='<br> <strong>Email:</strong> ';

if(!empty($expert->contact_email)){
	$staticContent.=stripslashes($expert->contact_email);
} else {
$staticContent.='office [ @ ] yourwebsite.com';
}

$staticContent.='<br> <strong>Web:</strong> ';
if(!empty($expert->web)){
	$staticContent.='<a href="http://'.stripslashes($expert->web).'" target="_blank">'.stripslashes($expert->web).'</a>';
} else {
$staticContent.='<a href="http://www.yourwebsite.com" target="_blank">www.yourwebsite.com</a>';
}

$staticContent.='</p>
<p class="freetext" data-char="">';

if(!empty($expert->free_text)){
	$staticContent.=stripslashes($expert->free_text);
} else {
$staticContent.='Pellentesque habitant morbi tristique senectus et netus et malesuada fames ac turpis egestas. Vestibulum tortor quam, feugiat vitae, ultricies eget, tempor sit amet, ante. Donec eu libero sit amet quam egestas semper. Aenean ultricies mi vitae est. Mauris placerat eleifend leo.';
}


$staticContent.='</p>
</div>
</div>

<div class="clear"></div>


	
</div>

					</div><!-- end main component -->
					
									</div>';

if (count($expert) > 0):
    
	?>
	<script src="<?php echo JURI::root();?>media/editors/tinymce/jscripts/tiny_mce/tiny_mce.js"></script>
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
			<?php if($sessionEXpertID>0):?>
			<dd class="createdby"><a href="<?php echo JRoute::_('index.php?option=com_survey&task=customer.expertOpportunites&display='.JRequest::getInt('display'))?>" >Opportunities</a></dd>
			<?php endif;?>
			<dd class="createdby"><a href="<?php echo JRoute::_('index.php?option=com_survey&task=customer.expertProcess&display='.JRequest::getInt('display'))?>">In Process</a></dd>
			<dd class="createdby"><a href="<?php echo JRoute::_('index.php?option=com_survey&task=customer.expertReport&display='.JRequest::getInt('display'))?>">My Report</a></dd>			
			<?php if($sessionEXpertID>0):?>
			<dd class="createdby"><a href="<?php echo JRoute::_('index.php?option=com_survey&task=customer.expertArea&display='.JRequest::getInt('display'))?>" >My Experties</a></dd>
			<?php endif;?>
			<dd class="published"><a href="<?php echo JRoute::_('index.php?option=com_survey&task=customer.blog&display='.JRequest::getInt('display'))?>">My Blog</a></dd>
			<dd class="published"><a href="<?php echo JRoute::_('index.php?option=com_survey&task=customer.expertFeedback&display='.JRequest::getInt('display'))?>">Feedback</a></dd>
			<?php if($sessionEXpertID>0):?>
			<dd class="createdby"><a href="<?php echo JRoute::_('index.php?option=com_users&task=user.logout&'.JUtility::getToken().'=1');?>" >Logout</a></dd>
			<?php endif;?>
		</dl>
	
					
			<!-- Profile data-->			
				<ul class="actions">
					<li class="print-icon">
						<a href="<?php echo JRoute::_(JURI::base()."index.php?option=com_survey&task=customer.expertProfile&display=".JRequest::getInt('display')."&tmpl=component&print=1&page=")?>" data-rel="tooltip" onclick="window.open(this.href,'win2','status=no,toolbar=no,scrollbars=yes,titlebar=no,menubar=no,resizable=yes,width=640,height=480,directories=no,location=no');return false;" rel="nofollow" data-original-title="Print"><span class='icon-print icon-white'></span></a>
					</li>					
				 </ul>
					
				<div class="viewControl">
				<?php 
					echo $staticContent;				
					
				?>
				</div>
					
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
				<button class="btn" data-dismiss="modal" aria-hidden="true">Cancel</button>
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
	
	if(_sessionEXpertID>0){
		/*
		jQuery("#image_desc,#choose_us,#testimonial,#custom-tab-main-area,#custom-tab-standard-expertise,#custom-tab-membership,#custom-tab-standardgroup,#custom-tab-cvresume,#skills_diagram,#user_address,#completed_claim,#completed_priorart,#sold_report,#working_hours,#subtitle").mouseover(function(){
			if(jQuery(this).find('span.edit').length>0){
				jQuery(this).find('span.edit').removeClass('disable_edit').addClass('enable_edit');
			} else {
				jQuery(this).prepend('<span class="edit '+jQuery(this).attr('data-class')+' enable_edit edit-icon"><a href="javascript:void(0);" onclick="editPanel(jQuery(this),'+jQuery(this).attr('data-attr')+')";><span class="icon-edit"></span></a></span>');
			} 
		}).mouseout(function(){
			jQuery(this).find('span.edit').removeClass('enable_edit').addClass('disable_edit');
		});
		*/
		jQuery(document).ready(function(){		
			jQuery("#image_desc,#choose_us,#testimonial,#custom-tab-main-area,#custom-tab-standard-expertise,#custom-tab-membership,#custom-tab-standardgroup,#custom-tab-cvresume,#skills_diagram,#user_address,#completed_claim,#completed_priorart,#sold_report,#working_hours,#subtitle").prepend(function(){
				jQuery(this).prepend('<span class="edit '+jQuery(this).attr('data-class')+' enable_edit edit-icon"><a href="javascript:void(0);" onclick="editPanel(jQuery(this),'+jQuery(this).attr('data-attr')+')";><span class="icon-pencil"></span></a></span>');
			});
			jQuery('#myModal').on('hidden', function () {
				destroyZIndexToA();
			});
		});
	}
	function addElement(){
		jQuery("#modalBody").append('<div class="control-group"><div class="controls"><input class="span5" type="text" name="field_choose_us[]" value=""></div></div>');
	}
	
	function addElementSkills(){
		jQuery("#modalBody").append("<div class='control-group'><div class='controls'><input class='span3' style='margin-right:5px' type='text' name='field_skill_name[]' placeholder='Skill Heading'/><input class='span2' type='text' name='field_skill_value[]' placeholder='Skill Value' /></div></div>");
	}
	
	function addEditor(){
		tinyMCE.init({
			mode : "textareas",
			theme : "advanced",
			editor_selector : "mceAdvanced"
		});
	}
	
	function addZIndexToA(){
		jQuery('.enable_edit>a').css('z-index','-9999');
	}
	function destroyZIndexToA(){
		jQuery('.enable_edit>a').css('z-index','9999');
	}
	function editPanel(object,element_type){
		addZIndexToA();
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
				//jQuery("#modalBody").html("<div class='control-group'><div class='controls'><input class='span5' type='text' name='field_choose_heading' value='"+_heading+"'/></div></div>"+_elementData);		
				jQuery("#modalBody").html(_elementData);		
			break;
			case 3:
				/*Testimonial*/
				jQuery("#modalBody").html("<div class='control-group'><div class='controls'><input class='span5' type='text' name='testimonial' value='"+jQuery("#testimonial").find('blockquote').find('p').html()+"'/></div></div>");
				jQuery("#modalBody").append("<div class='control-group'><div class='controls'><input class='span5' type='text' name='testimonial_by' value='"+jQuery("#testimonial").find('blockquote>small').html()+"'/></div></div>");
			break;
			case 4:
				/*Main Area*/
				//jQuery("#modalBody").html("<div class='control-group'><label>Title</label><div class='controls'><input class='span5' type='text' name='main_area_heading' value='"+jQuery("#custom-tab-main-area").find('h4').html()+"'/></div></div>");
				_desc = "";
				if(jQuery("#custom-tab-main-area").find('p').length>1){
					jQuery("#custom-tab-main-area").find('p').each(function(index){
						if(index>0){							
							_desc +=jQuery(this).html()+'<br/>';
						}
					});
				}
				//jQuery("#modalBody").append("<div class='control-group'><lable>Image</label><div class='controls'><input type='file' name='main_area_image' /><input type='hidden' name='old_image' value='"+jQuery("#custom-tab-main-area").find('img.alignright').attr('src')+"' /></div></div>");
				jQuery("#modalBody").append("<div class='control-group'><lable>Description</label><div class='controls'><textarea name='main_area_description' class='mceAdvanced' style='width:98%;height:100px'>"+_desc+"</textarea></div></div>");
				addEditor();
			break;
			case 5:
				/*Standard Main Area*/
				//jQuery("#modalBody").html("<div class='control-group'><label>Title</label><div class='controls'><input class='span5' type='text' name='main_standard_area_heading' value='"+jQuery("#custom-tab-standard-expertise").find('h4').html()+"'/></div></div>");
				_desc = "";
				if(jQuery("#custom-tab-standard-expertise").find('p').length>1){
					jQuery("#custom-tab-standard-expertise").find('p').each(function(index){
						if(jQuery(this).find('img').length==0){
							if(index>0){							
								_desc +=jQuery(this).html()+'<br/>';
							}
						}
					});
				}
				//jQuery("#modalBody").append("<div class='control-group'><lable>Image</label><div class='controls'><input type='file' name='main_standard_area_image' /><input type='hidden' name='old_image' value='"+jQuery("#custom-tab-standard-expertise").find('img.alignright').attr('src')+"' /></div></div>");
				jQuery("#modalBody").append("<div class='control-group'><lable>Description</label><div class='controls'><textarea name='main_standard_area_description' class='mceAdvanced' style='width:98%;height:100px'>"+_desc+"</textarea></div></div>");
				addEditor();
			break;
			case 6:
				/*Membership*/
				//jQuery("#modalBody").html("<div class='control-group'><label>Title</label><div class='controls'><input class='span5' type='text' name='main_membership_heading' value='"+jQuery("#custom-tab-membership").find('h4').html()+"'/></div></div>");
				_desc = "";
				if(jQuery("#custom-tab-membership").find('p').length>1){
					jQuery("#custom-tab-membership").find('p').each(function(index){
						if(jQuery(this).find('img').length==0){
							if(index>0){							
								_desc +=jQuery(this).html()+'<br/>';
							}
						}
					});
				}
				//jQuery("#modalBody").append("<div class='control-group'><lable>Image</label><div class='controls'><input type='file' name='main_membership_image' /><input type='hidden' name='old_image' value='"+jQuery("#custom-tab-membership").find('img.alignright').attr('src')+"' /></div></div>");
				jQuery("#modalBody").append("<div class='control-group'><lable>Description</label><div class='controls'><textarea name='main_membership_description' class='mceAdvanced' style='width:98%;height:100px'>"+_desc+"</textarea></div></div>");
				addEditor();
			break;
			case 7:
				/*Standard Group*/
				//jQuery("#modalBody").html("<div class='control-group'><label>Title</label><div class='controls'><input class='span5' type='text' name='main_standard_group_heading' value='"+jQuery("#custom-tab-standardgroup").find('h4').html()+"'/></div></div>");
				_desc = "";
				if(jQuery("#custom-tab-standardgroup").find('p').length>1){
					jQuery("#custom-tab-standardgroup").find('p').each(function(index){
						if(jQuery(this).find('img').length==0){
							if(index>0){							
								_desc +=jQuery(this).html()+'<br/>';
							}
						}
					});
				}
				//jQuery("#modalBody").append("<div class='control-group'><lable>Image</label><div class='controls'><input type='file' name='main_standard_group_image' /><input type='hidden' name='old_image' value='"+jQuery("#custom-tab-standardgroup").find('img.alignright').attr('src')+"' /></div></div>");
				jQuery("#modalBody").append("<div class='control-group'><lable>Description</label><div class='controls'><textarea name='main_standard_group_description' class='mceAdvanced' style='width:98%;height:100px'>"+_desc+"</textarea></div></div>");
				addEditor();
			break;
			case 8:
				/*CVResume*/
				//jQuery("#modalBody").html("<div class='control-group'><label>Title</label><div class='controls'><input class='span5' type='text' name='main_cvresume_heading' value='"+jQuery("#custom-tab-cvresume").find('h4').html()+"'/></div></div>");
				_desc = "";
				if(jQuery("#custom-tab-cvresume").find('p').length>1){
					jQuery("#custom-tab-cvresume").find('p').each(function(index){
						if(jQuery(this).find('img').length==0){
							if(index>0){							
								_desc +=jQuery(this).html()+'<br/>';
							}
						}
					});
				}
				//jQuery("#modalBody").append("<div class='control-group'><lable>Image</label><div class='controls'><input type='file' name='main_cvresume_image' /><input type='hidden' name='old_image' value='"+jQuery("#custom-tab-cvresume").find('img.alignright').attr('src')+"' /></div></div>");
				jQuery("#modalBody").append("<div class='control-group'><lable>Description</label><div class='controls'><textarea name='main_cvresume' class='mceAdvanced' style='width:98%;height:100px'>"+_desc+"</textarea></div></div>");
				addEditor();
			break; 
			case 9:				
				/*Skills*/
				_elementData = "";
				if(jQuery(".skills").find('li').length>0){
					jQuery(".skills").find('li').each(function(){
						_elementData +="<div class='control-group'><div class='controls'><input class='span3' style='margin-right:5px' type='text' name='field_skill_name[]' value='"+jQuery(this).html()+"' placeholder='Skill Heading'/><input class='span2' type='text' name='field_skill_value[]' value='"+jQuery(this).attr('data-percent')+"' placeholder='Skill Value'/></div></div>";
					});
				}
				jQuery("#modalBody").html(_elementData);
			break;
			case 10:
				/*Address*/		
				_add = jQuery('p.address').html();
				_address = _add.substr(25,_add.length)
				_phoneAll = jQuery('p.phone').html();
				_phoneSubstr = _phoneAll.substr(24,_phoneAll.length);
				_phonePhone = _phoneSubstr.indexOf('<br/>');
				_phonePosition = -1;
				if(_phonePhone>0){
					_phonePosition = _phonePhone;
				} else {
					_phonePhone = _phoneSubstr.indexOf('<br>');
					_phonePosition = _phonePhone;
				}
				_phoneNumber =  _phoneSubstr.substr(0,_phonePosition);
				_phoneSubstr = _phoneSubstr.substr(_phonePosition + 28,_phoneSubstr.length);
				_emailStringP = _phoneSubstr.indexOf('<br/>');
				_emailPosition = -1;
				if(_emailStringP>0){
					_emailPosition = _emailStringP;
				} else {
					_emailStringP = _phoneSubstr.indexOf('<br>');
					_emailPosition = _emailStringP;
				}
				_emailAddress =  _phoneSubstr.substr(0,_emailPosition);
				_phoneSubstr = _phoneSubstr.substr(_emailPosition + 27,_phoneSubstr.length);
				_anchorTag = '';
				if(_phoneSubstr.indexOf('>')>0){
					_phoneSubstr = _phoneSubstr.substr(_phoneSubstr.indexOf('>'),_phoneSubstr.length);
					_anchorTag = _phoneSubstr.substr(1,_phoneSubstr.indexOf('<')-1);
					
				}
				_elementData = "<div class='control-group'><div class='controls'><input type='text' class='span4' placeholder='Address' name='address' value='"+_address+"'/></div></div><div class='control-group'><div class='controls'><input type='text' class='span4' placeholder='Phone number' name='phone_number' value='"+_phoneNumber+"'/></div></div><div class='control-group'><div class='controls'><input type='text' class='span4' name='email_address' placeholder='Email address' value='"+_emailAddress+"'/></div></div><div class='control-group'><div class='controls'><input type='text' class='span4' name='web' placeholder='Website URL address' value='"+_anchorTag+"'/></div></div><div class='control-group'><div class='controls'><textarea type='text' class='span4' name='free_text' placeholder='Free text'>"+jQuery('p.freetext').html()+"</textarea></div></div>";
				jQuery("#modalBody").html(_elementData);
			break;
			case 11:
				/*Completed Claim*/
				_elementData = "<h4>Completed Claim</h4><div class='control-group'><div class='controls'><input type='text' class='span4' name='completed_claim' value='"+jQuery("#completed_claim").find('p').html()+"'/></div></div>";
				jQuery("#modalBody").html(_elementData);		
			break;
			case 12:
				/*Completed PriorArts*/
				_elementData = "<h4>Completed PriorArts</h4><div class='control-group'><div class='controls'><input type='text' class='span4' name='completed_priorart' value='"+jQuery("#completed_priorart").find('p').html()+"'/></div></div>";
				jQuery("#modalBody").html(_elementData);
			break;
			case 13:
				/*Sold Reports*/
				_elementData = "<h4>Sold Reports</h4><div class='sold_report-group'><div class='controls'><input type='text' class='span4' name='sold_report' value='"+jQuery("#sold_report").find('p').html()+"'/></div></div>";
				jQuery("#modalBody").html(_elementData);
			break;
			case 14:
				/*Working Hours This Year*/
				_elementData = "<h4>Working Hours This Year</h4><div class='control-group'><div class='controls'><input type='text' class='span4' name='working_hour' value='"+jQuery("#working_hours").find('p').html()+"'/></div></div>";
				jQuery("#modalBody").html(_elementData);
			break;
			case 15:
				/*Subtitle*/
				_elementData = "<h4>Title</h4><div class='control-group'><div class='controls'><input type='text' class='span4' name='sub_title' value='"+jQuery("#subtitle").find('p').html()+"'/></div></div>";
				jQuery("#modalBody").html(_elementData);
			break;
		}
		jQuery("#default_type").val(element_type);
		jQuery("#myModal").modal('toggle');
	}
  </script>
