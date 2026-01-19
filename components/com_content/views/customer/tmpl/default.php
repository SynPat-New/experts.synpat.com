<?php
// No direct access to this file
defined('_JEXEC') or die('Restricted access');
$expert = $this->expert;
$rating = $this->rating;
$name = "";
if((int)$expert->expert_type==2){
	$name = $expert->company_name;
} else {
	$name = $expert->name;
}
$profileUser = JFactory::getUser();
$file = JRequest::getVar('sla','');
$imageUrl = '';
if(!empty($file)){
	$fileName = base64_decode(JRequest::getVar('sla'));
	$fileName = str_replace('/home/claimcha/public_html/',JUri::base(),$fileName);
?>	
	<script>window.open('<?php echo $fileName?>','_blank');</script>
<?php
}
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
$staticContent .='<p style="margin:0px">'.$name.'&nbsp;</p>';
}
$staticContent .='</h2>';
$staticContent.='<div style="float:right" id="skills_diagram" data-attr="9" data-class="" data-char="0">
	<div class="legend">';		
if(!empty($expert->skills)){
	$staticContent.=stripslashes($expert->skills);
} else {		
		$staticContent.='<ul class="skills">
<li style="background-color:#97BE0D;" data-percent="80">Audio/radio</li><li style="background-color:#D84F5F;" data-percent="90">Bipolar transistors</li><li style="background-color:#88B8E6;" data-percent="80">Data converters</li><li style="background-color:#BEDBE9;" data-percent="53">Diodes</li><li style="background-color:#EDEBEE;" data-percent="45">Signal conditioning</li>	
		</ul><!-- end the skills -->';
	}	
		
	$staticContent.='</div>
	<div data-textcolor="#ffffff" data-fontsize="20px Arial" data-maintext="Skills" data-maincolor="#193340" data-height="600" data-width="600" id="thediagram"></div>
</div>';
$staticContent.='<div id="image_desc" data-char="640" data-attr="1" data-class="">';
if(!empty($expert->profile_desc)){
	$desc = preg_replace('/\n/','<br/>',$expert->profile_desc);
	$desc = str_replace("claimcharts.info","claimcharts.synpat.com",$desc);
	$desc = str_replace("www.claimcharts.synpat.com","claimcharts.synpat.com",$desc);
	$staticContent.=stripslashes($desc);
	preg_match_all('~<img.*?src=["\']+(.*?)["\']+~', $desc, $urls);
	$imageUrl = $urls[1];
	$imageUrl = str_replace("claimcharts.info","claimcharts.synpat.com",$imageUrl);
	$imageUrl = str_replace("www.claimcharts.synpat.com","claimcharts.synpat.com",$imageUrl);
} else {
$staticContent.='<img border="0" alt="" src="'.JUri::base().'images/kallyas_images/aboutus.jpg" class="alignleftborder"><p>Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat.</p>';
$staticContent.='<p>Sed ut perspiciatis unde omnis iste natus error sit voluptatem accusantium doloremque laudantium, totam rem aperiam, eaque ipsa quae ab illo inventore veritatis et quasi architecto beatae vitae dicta sunt explicabo. Nemo enim ipsam voluptatem quia voluptas sit aspernatur aut odit aut fugit, sed quia consequuntur magni dolores eos qui ratione voluptatem sequi nesciunt.</p>';
}
$staticContent.='</div>';
$staticContent.='<p class="m_title"></p>';
$staticContent.='<div id="choose_us" data-char="760" data-attr="2" data-class="">';
if(!empty($expert->choose_us)){
	$staticContent.='<h4 style="text-align:left; ;" class="m_title ">MAIN AREAS OF EXPERTISE&nbsp;</h4>';
	$staticContent.=stripslashes($expert->choose_us);
} else {
$staticContent.='<h4 style="text-align:left; ;" class="m_title ">MAIN AREAS OF EXPERTISE&nbsp;</h4>';
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
$staticContent.='<blockquote><p>&nbsp;Neque porro quisquam est, qui dolorem ipsum quia dolor sit amet, consectetur, adipisci velit, sed quia non numquam eius modi tempora.&nbsp;</p><small>BRIAN NUNN - Company CEO</small></blockquote>';
}
$staticContent.='</div>';
$staticContent.='<div style="height:35px;"></div>';
if((int)$expert->expert_type==2){
	$TEAMS = "TEAMS'S";
$staticContent.='<div class="custom ">
	<div class="tabbable vertical_tabs "><ul class="nav fixclear"><li class="active"><a data-toggle="tab" href="#custom-tab-main-area"><span><span class="icon-comment icon-white"></span></span>EDUCATION AND AWARDS</a></li><li><a data-toggle="tab" href="#custom-tab-standard-expertise"><span><span class="icon-book icon-white"></span></span>WHITEPAPERS/ WEBINARS</a></li><li><a data-toggle="tab" href="#custom-tab-membership"><span><span class="icon-tint icon-white"></span></span>'.$TEAMS.' PATENTS</a></li><li><a data-toggle="tab" href="#custom-tab-standardgroup"><span><span class="icon-map-marker icon-white"></span></span>EXPERT WITNESS ACTIVITES</a></li><li><a data-toggle="tab" href="#custom-tab-cvresume"><span><span class="icon-th-large icon-white"></span></span>STANDARD WORKING GROUPS</a></li><li><a data-toggle="tab" href="#custom-tab-professional-membership"><span><span class="icon-certificate icon-white"></span></span>PROFESSIONAL MEMBERSHIP</a></li><li><a data-toggle="tab" href="#custom-tab-my-clients"><span><span class="icon-user icon-white"></span></span>OUR CLIENTS</a></li><li><a data-toggle="tab" href="#custom-tab-other"><span><span class="icon-cog icon-white"></span></span>OTHER</a></li></ul><div class="tab-content">
<div class="tab-pane active" id="custom-tab-main-area" data-char="800" data-attr="4" data-class="rRight">';
} else {
	$staticContent.='<div class="custom ">
	<div class="tabbable vertical_tabs "><ul class="nav fixclear"><li class="active"><a data-toggle="tab" href="#custom-tab-main-area"><span><span class="icon-star icon-white"></span></span>EDUCATION AND AWARDS</a></li><li><a data-toggle="tab" href="#custom-tab-standard-expertise"><span><span class="icon-book icon-white"></span></span>PUBLICATION AND RESEARCH</a></li><li><a data-toggle="tab" href="#custom-tab-membership"><span><span class="icon-tint icon-white"></span></span>MY PATENTS</a></li><li><a data-toggle="tab" href="#custom-tab-standardgroup"><span><span class="icon-map-marker icon-white"></span></span>EXPERT WITNESS ACTIVITES</a></li><li><a data-toggle="tab" href="#custom-tab-cvresume"><span><span class="icon-th-large icon-white"></span></span>STANDARD WORKING GROUPS</a></li><li><a data-toggle="tab" href="#custom-tab-professional-membership"><span><span class="icon-certificate icon-white"></span></span>PROFESSIONAL MEMBERSHIP</a></li><li><a data-toggle="tab" href="#custom-tab-my-clients"><span><span class="icon-user icon-white"></span></span>MY CLIENTS</a></li><li><a data-toggle="tab" href="#custom-tab-other"><span><span class="icon-cog icon-white"></span></span>OTHER</a></li></ul><div class="tab-content">
<div class="tab-pane active" id="custom-tab-main-area" data-char="800" data-attr="4" data-class="rRight">';
}
if(!empty($expert->main_area)){
	$mainArea = stripslashes($expert->main_area);
	
	$staticContent.=stripslashes($expert->main_area);
} else {
	if((int)$expert->expert_type==2){
		$phd = "PhD's";
		$staticContent.='<h4 data-char="47">Our Team - Education and Awards:</h4>
		<p><img border="0" alt="" src="'.JUri::base().'images/Patentex%20-%20Team.JPG" class="alignright" width="372" height="279"></p>
		<p data-char="800"><strong>We have 5 '.$phd.' 3 Masters and 4 Researchers</strong></p>
		<p data-char="800">Ph.D. in Electrical Engineering and Computer Science</p>
		<p data-char="800">M.S. in Electrical Engineering and Computer Science</p>	
		<p data-char="800"></p>
		<p data-char="800"><strong>UNDERGRADUATE</strong></p>
		<p data-char="800">B.S. in Electrical Engineering</p>
		<p data-char="800"></p>
		<p data-char="800"></p>';
	} else{
		$staticContent.='<h4 data-char="47">My Education and Awards:</h4>
		<p><img border="0" alt="" src="'.JUri::base().'images/kallyas_images/site_images/support.jpg" class="alignright"></p>
		<p><img class="alignright" style="border: 0;" src="images/kallyas_images/site_images/support.jpg" alt="" width="248" height="258" border="0" /></p><p><strong>GRADUATE</strong></p><p><em>UNIVERSITY OF CALIFORNIA, DAVIS June 2011</em></p><p>Ph.D. in Electrical Engineering and Computer Science </p><p>M.S. in Electrical Engineering and Computer Science, June 2004</p><p> </p><p><strong>UNDERGRADUATE</strong></p><p><em>UNIVERSITY OF CALIFORNIA, BERKELEY 2003</em></p><p>B.S. in Electrical Engineering (Emphasis in Digital Electronics), June 2003</p><p>Minor in Technology Management, UC Berkeley Graduate School of Management</p><p> </p><p>Awarded M.S. Ghausi Medal, the highest honor awarded for scholastic excellence to a student earning a bachelor’s degree in the College of Engineering.</p><p> </p><p><strong>EXCHANGE</strong></p><p><em>NATIONAL UNIVERSITY OF SINGAPORE, SINGAPORE (FALL 2010)</em></p><p>Exchange student, Department of Electrical and Computer Engineering </p><p> </p>';
	}
}

$staticContent.='</div>
<div class="tab-pane " id="custom-tab-standard-expertise" data-char="800" data-attr="5" data-class="">';

if(!empty($expert->standard_area)){
	$staticContent.=stripslashes($expert->standard_area);
} else {
	if((int)$expert->expert_type==2){
		$staticContent.='<h4 data-char="47">Whitepapers and Webinars:</h4>
		<p data-char="800"></p><ul>
		<li><a href="http://www.google.com" target="_blank"><em><strong>The Case for the Holistic Language Runtime System </strong></em></a></li>
		</ul><p data-char="800">International Workshop on Rack-scale Computing (WRSC 14), Amsterdam, Netherlands, April 2014 <img class="alignright" src="http://upload.wikimedia.org/wikipedia/commons/8/85/BandDiagram-Semiconductors-E.PNG" alt="" width="250" height="260" /></p><p> </p>
		<ul>
		<li><a href="http://www.google.com" target="_blank"><em><strong>Callisto: Co-Scheduling Serial Runtime Systems </strong></em></a></li>
		</ul><p data-char="800">ACM European Conference on Computer Systems (EuroSys 14), Amsterdam, Netherlands, April 2014 </p>
		<p data-char="800"> </p><ul>
		<li><a href="http://www.google.com" target="_blank"><em><strong>A High-Performance Oblivious ROM Controller on the Convey HC-2ex Heterogeneous Computing Platform </strong></em></a></li>
		</ul><p>Workshop on the Intersections of Computer Architecture and Reconfigurable Logic (CARL 13), Davis, CA, December 2013 </p>
		<p data-char="800"> </p><ul>
		<li><a href="http://www.google.com" target="_blank"><strong><em>PHANTOM: Practical Oblivious Computation in a Server Processor </em></strong></a></li>
		</ul>
		<p data-char="800">ACM Conference on Computer and Communications Security (CCS 13), Berlin, Germany, November 2013 </p><p>Finalist for NYU-Poly (formerly AT&amp;T) Best Applied Security Paper Award 2013 </p>
		<p data-char="800"> </p><ul>
		<li><strong><em><a href="http://www.google.com" target="_blank">GPUs as an Opportunity for Uploading Garbage Collection </a><br /></em></strong></li>
		</ul>
		<p data-char="800">International Symposium on Memory Management (ISMM 12), Beijing, China, June 2012 <img class="alignright" src="http://1.bp.blogspot.com/_7UH1P0Umjhk/SWwtwLw2oBI/AAAAAAAABkg/EM1NqGT2gYg/s320/p-type+semiconductor.jpg" alt="" width="250" height="260" /></p>
		<p data-char="800"> </p>
		<ul>
		<li><strong><em><a href="http://www.google.com" target="_blank">A JBM for the Barrelfish Operating System</a> </em></strong></li>
		</ul><p>Workshop on Systems for Future Multi-core Architectures (SFMA 12), Bern, Switzerland, April 2012 </p>
		<p data-char="800"> </p>';	
	} else {
		$staticContent.='<h4 data-char="47">My Publications and Research:</h4>
		<p data-char="800"></p><ul>
		<li><a href="http://www.google.com" target="_blank"><em><strong>The Case for the Holistic Language Runtime System </strong></em></a></li>
		</ul><p data-char="800">International Workshop on Rack-scale Computing (WRSC 14), Amsterdam, Netherlands, April 2014 <img class="alignright" src="http://upload.wikimedia.org/wikipedia/commons/8/85/BandDiagram-Semiconductors-E.PNG" alt="" width="250" height="260" /></p><p> </p>
		<ul>
		<li><a href="http://www.google.com" target="_blank"><em><strong>Callisto: Co-Scheduling Serial Runtime Systems </strong></em></a></li>
		</ul><p data-char="800">ACM European Conference on Computer Systems (EuroSys 14), Amsterdam, Netherlands, April 2014 </p>
		<p data-char="800"> </p><ul>
		<li><a href="http://www.google.com" target="_blank"><em><strong>A High-Performance Oblivious ROM Controller on the Convey HC-2ex Heterogeneous Computing Platform </strong></em></a></li>
		</ul><p>Workshop on the Intersections of Computer Architecture and Reconfigurable Logic (CARL 13), Davis, CA, December 2013 </p>
		<p data-char="800"> </p><ul>
		<li><a href="http://www.google.com" target="_blank"><strong><em>PHANTOM: Practical Oblivious Computation in a Server Processor </em></strong></a></li>
		</ul>
		<p data-char="800">ACM Conference on Computer and Communications Security (CCS 13), Berlin, Germany, November 2013 </p><p>Finalist for NYU-Poly (formerly AT&amp;T) Best Applied Security Paper Award 2013 </p>
		<p data-char="800"> </p><ul>
		<li><strong><em><a href="http://www.google.com" target="_blank">GPUs as an Opportunity for Uploading Garbage Collection </a><br /></em></strong></li>
		</ul>
		<p data-char="800">International Symposium on Memory Management (ISMM 12), Beijing, China, June 2012 <img class="alignright" src="http://1.bp.blogspot.com/_7UH1P0Umjhk/SWwtwLw2oBI/AAAAAAAABkg/EM1NqGT2gYg/s320/p-type+semiconductor.jpg" alt="" width="250" height="260" /></p>
		<p data-char="800"> </p>
		<ul>
		<li><strong><em><a href="http://www.google.com" target="_blank">A JBM for the Barrelfish Operating System</a> </em></strong></li>
		</ul><p>Workshop on Systems for Future Multi-core Architectures (SFMA 12), Bern, Switzerland, April 2012 </p>
		<p data-char="800"> </p>';	
	}
}
	
$staticContent.='</div>
<div class="tab-pane " id="custom-tab-membership" data-attr="6" data-char="800" data-class="">';
if(!empty($expert->new_membership)){
	$staticContent.=stripslashes($expert->new_membership);
} else {
	$staticContent.='<h4 data-char="47">Patents I Invented and Co-Invented:</h4>
	<p data-char="800"><strong><a href="http://patft.uspto.gov/netacgi/nph-Parser?Sect1=PTO1&amp;Sect2=HITOFF&amp;d=PALL&amp;p=1&amp;u=%2Fnetahtml%2FPTO%2Fsrchnum.htm&amp;r=1&amp;f=G&amp;l=50&amp;s1=7626941.PN.&amp;OS=PN/7626941&amp;RS=PN/7626941" target="_blank"><span style="font-size: large; font-family: Times; line-height: normal;">Method and apparatus for analyzing proposed service features in a communication network </span></a></strong></p><center style="font-family: Times; font-size: medium; line-height: normal;"><strong>Abstract</strong></center><p data-char="800"><img class="alignright" style="font-family: Times; font-size: medium; line-height: normal; cursor: se-resize !important;" src="https://patentimages.storage.googleapis.com/US7626941B1/US07626941-20091201-D00002.png" alt="" width="165" height="172" /></p><p data-char="800" style="font-family: Times; font-size: medium; line-height: normal;">Method and apparatus for analyzing a proposed service feature in a communication network is described. In one example, a call flow for supporting the service feature in the communication network is created, where at least one network component supports the call flow. First cost data for internally developing the at least one network component is determined. Second cost data for procuring the at least one network component from third party entity is determined. The first cost data and the second cost data are processed to generate a recommendation for either internally developing or externally procuring the at least one network element.</p><p data-char="800" class="alignright" style="font-family: Times; font-size: medium; line-height: normal;"> </p><p data-char="800" style="font-family: Times; font-size: medium; line-height: normal;"> </p><p data-char="800"><strong><a href="http://patft.uspto.gov/netacgi/nph-Parser?Sect1=PTO1&amp;Sect2=HITOFF&amp;d=PALL&amp;p=1&amp;u=%2Fnetahtml%2FPTO%2Fsrchnum.htm&amp;r=1&amp;f=G&amp;l=50&amp;s1=7662311.PN.&amp;OS=PN/7662311&amp;RS=PN/7662311"><span style="font-family: Times; line-height: normal; font-size: large;">US7662311 - Fluorescent substance for light-emitting diode</span></a><span style="font-family: Times; line-height: normal; font-size: large;"> </span></strong></p><center style="font-family: Times; font-size: medium; line-height: normal;"><strong>Abstract</strong></center><p data-char="800" class="alignright" style="font-family: Times; font-size: medium; line-height: normal;"><img src="https://patentimages.storage.googleapis.com/US7626941B1/US07626941-20091201-D00003.png" alt="" width="165" height="172" /></p><p data-char="800" style="font-family: Times; font-size: medium; line-height: normal;">A novel fluorescent substance for a light-emitting diode, emitting light of any one of three primary colors by excitation of an ultraviolet light-emitting diode. Alternatively, a novel fluorescent substance for a light-emitting diode, emitting light in a red region of a spectrum by excitation of a blue light-emitting diode. Na.sub.2SrSi.sub.2O.sub.6 is doped with Eu.sup.3+. Preferably, Eu.sup.3+ is added so as to account for 1 to 80 mol % in concentration in a host crystal, while sites of Si.sup.4+ in Na.sub.2SrSi.sub.2O.sub.6. are replaced by Al.sup.3+ and/or Ga.sup.3+. Alternatively, Ca.sub.3Si.sub.2O.sub.7 is doped with Ce.sup.3+ and Tb.sup.3+. Preferably, Ce.sup.3+ and Tb.sup.3+ are added so as to account for 0.1 to 80 mol % and 0.1 to 20 mol % in concentration in a host crystal, respectively. Still alternatively, Ca.sub.3Si.sub.2O.sub.7 is doped with Eu.sup.2+. Preferably, Eu.sup.2+ is added so as to account for 0.5 to 10 mol % in concentration in the host crystal.</p><p data-char="800" style="font-family: Times; font-size: medium; line-height: normal;"> </p><p data-char="800"><strong><a href="http://patft.uspto.gov/netacgi/nph-Parser?Sect1=PTO1&amp;Sect2=HITOFF&amp;d=PALL&amp;p=1&amp;u=%2Fnetahtml%2FPTO%2Fsrchnum.htm&amp;r=1&amp;f=G&amp;l=50&amp;s1=7885523.PN.&amp;OS=PN/7885523&amp;RS=PN/7885523" target="_blank"><span style="font-family: Times; line-height: normal; font-size: large;">US7885523 - Image pickup apparatus</span><span style="font-family: Times; line-height: normal; font-size: large;"><br /></span></a></strong></p><center style="font-family: Times; font-size: medium; line-height: normal;"><strong>Abstract</strong></center><p data-char="800" class="alignright" style="font-family: Times; font-size: medium; line-height: normal;"><img src="https://patentimages.storage.googleapis.com/US7626941B1/US07626941-20091201-D00001.png" alt="" width="165" height="172" /></p><p data-char="800" style="font-family: Times; font-size: medium; line-height: normal;">An image pickup apparatus includes a gyro sensor 1240 that detects camera shakes, a feed forward value is calculated by multiplying a first coefficient c1 to an output value of the gyro sensor 1240 when the output value of the gyro sensor 1240 is less than a first predetermined value, another feed forward value is calculated by multiplying a second coefficient c2 smaller than the first coefficient c1 to an output value of the gyro sensor 1240 when the output value of the gyro sensor 1240 is greater than or equal to the first predetermined value, each of the products is respectively added by an addition device to an output value of a drive signal.</p>';

}
$staticContent.='</div>
<div class="tab-pane " id="custom-tab-standardgroup" data-attr="7" data-char="800" data-class="">';
if(!empty($expert->standard_group)){
	$staticContent.=stripslashes($expert->standard_group);
} else {
$staticContent.='<h4 data-char="75">Patent Litigation in which I Participated in as an Expert Witness:</h4><p data-char="800"> </p><p data-char="800"><em><strong>SynQor, Inc. v. Artesyn Technologies, Inc. et al</strong></em></p><p data-char="800">November 13 2007 - Emerson Network Power, Inc. sued by SynQor, Inc. for patent infringement in Texas Eastern District Court</p><p data-char="800">2:07-cv-00497 Filed: 11/13/2007 Closed: 08/17/2011 Latest Docket Entry: 07/31/2014 <strong><a href="https://ecf.txed.uscourts.gov/cgi-bin/iqquerymenu.pl?106578" target="_blank">PACER </a></strong></p><p data-char="800"> </p><p data-char="800"><em><strong>Vicor Corporation v. Synqor, Inc.</strong></em></p><p data-char="800">January 26 2011 - Synqor, Inc. sued by Vicor Corporation for patent infringement in Massachusetts District Court</p><p data-char="800">1:11-cv-10146 Filed: 01/26/2011 Closed: 02/18/2011 <strong><a href="https://ecf.mad.uscourts.gov/cgi-bin/iqquerymenu.pl?134151" target="_blank">PACER</a></strong></p><p data-char="800"> </p><p data-char="800"><em><strong>Power-One, Inc., v. Artesyn Technologies, INC.,</strong></em></p><p data-char="800">September 30 2005 - Artesyn Technologies, Inc. sued by Power-One, Inc., for patent infringement in Texas Eastern District Court</p><p data-char="800">2:05-cv-00463 Filed: 09/30/2005 Closed: 07/02/2008 Latest Docket Entry: 05/10/2010 <strong><a href="https://ecf.txed.uscourts.gov/cgi-bin/iqquerymenu.pl?92965" target="_blank">PACER</a></strong></p><p data-char="800"> </p>';
}
$staticContent.='</div>
<div class="tab-pane " id="custom-tab-cvresume" data-attr="8" data-char="800" data-class="">';
if(!empty($expert->cv_resume)){
	$staticContent.=stripslashes($expert->cv_resume);
} else {
$staticContent.='
<h4 data-char="47">My Industry Standard Activities:/h4><p data-char="800"> </p><p data-char="800"><a style="text-decoration: none; color: #0b0080; background: none;" title="ITU-T" href="http://en.wikipedia.org/wiki/ITU-T">ITU-T</a><span style="color: #252525; font-family: sans-serif; line-height: 22.3999996185303px;"> - ITU Telecommunications Sector (formerly known as CCITT)</span></p><p data-char="800">Member of:</p><div class="contentNew _invisibleIfEmpty" style="margin: 0px; padding: 0px; border: 0px; font-family: Arial, Helvetica, sans-serif; font-size: 12px; line-height: 18px; vertical-align: baseline; color: #444444;"><div id="ctl00_PlaceHolderMain_ctl00__ControlWrapper_RichHtmlField" class="ms-rtestate-field" style="margin: 0px; padding: 0px; border: 0px; font-family: inherit; font-size: inherit; font-style: inherit; font-variant: inherit; font-weight: inherit; line-height: inherit; vertical-align: baseline; word-wrap: break-word; display: inline;"><h1 style="margin: 0px; font-weight: inherit; font-family: DroidSerifRegular, Georgia, sans-serif; font-size: 1.5em; color: #052d53; font-style: inherit; padding: 5px 0px; border: 0px; font-variant: inherit; line-height: 1.5; vertical-align: baseline;"><a href="http://handle.itu.int/11.1002/1000/9317-en?locatt=format:pdf&amp;auth">Study Group 9 (Study Period 2013-2016)</a></h1></div></div><h1 class="content-webpart" style="margin: 0px; padding: 0px; border: 0px; font-family: Arial, Helvetica, sans-serif; font-size: 12px; line-height: 18px; vertical-align: baseline; color: #444444;"><a style="font-size: 1.5em; font-family: DroidSansBold, Arial, Helvetica, sans-serif; font-style: inherit; font-variant: inherit; line-height: inherit; text-transform: uppercase; font-weight: inherit;" href="http://www.itu.int/ITU-T/recommendations/rec.aspx?rec=9317">TELEVISION AND SOUND TRANSMISSION AND INTEGRATED BROADBAND CABLE NETWORKS</a></h1><div class="row contentNew  _invisibleIfEmpty" style="margin: 0px; padding: 0px; border: 0px; font-family: Arial, Helvetica, sans-serif; font-size: 12px; line-height: 18px; vertical-align: baseline; clear: both; width: 460px; overflow: hidden; color: #444444;"><div class="module module-caps  module-thumbnail clearfix _invisibleIfEmpty" style="margin: 0px; padding: 15px 0px; border: 0px; font-family: inherit; font-size: inherit; font-style: inherit; font-variant: inherit; font-weight: inherit; line-height: inherit; vertical-align: baseline; zoom: 1; position: relative; float: left; width: 460px;"><div style="margin: 0px; padding: 0px; border: 0px; font-family: inherit; font-size: inherit; font-style: inherit; font-variant: inherit; font-weight: inherit; line-height: inherit; vertical-align: baseline;"><div id="ctl00_PlaceHolderMain_ctl05_ctl01__ControlWrapper_RichHtmlField" class="ms-rtestate-field" style="margin: 0px; padding: 0px; border: 0px; font-family: inherit; font-size: inherit; font-style: inherit; font-variant: inherit; font-weight: inherit; line-height: inherit; vertical-align: baseline; word-wrap: break-word; display: inline;"><div><p data-char="800">Responsible for studies relating to:</p><p data-char="800">use of telecommunication systems for contribution, primary distribution and secondary distribution of television, sound programmes and related data services including interactive services and applications, extendable to advanced capabilities such as ultra-high definition television, 3D television, etc.;</p><p data-char="800">use of cable and hybrid networks, primarily designed for television and sound programme delivery to the home, as integrated broadband networks to also carry voice or other time-critical services, video on demand, interactive services, etc., to home and enterprise customer premises equipment (CPE).</p></div></div></div></div></div>';
}
$staticContent.='</div>';

$staticContent.='<div class="tab-pane " id="custom-tab-professional-membership" data-attr="16" data-char="800" data-class="">';
if(!empty($expert->professtional_membership)){
	$staticContent.=stripslashes($expert->professtional_membership);
} else {
$staticContent.='
<h4 data-char="100">My Memberships in Technological, Legal and Licensing Organizations</h4><p data-char="800"> </p><ul style="line-height: 22.3999996185303px; margin: 0.3em 0px 0px 1.6em; padding: 0px; list-style-image: url(data:image/png; base64,ivborw0kggoaaaansuheugaaaauaaaanaqmaaabb8jblaaaablbmvex///8auow5qsojaaaaaxrstlmaqobyzgaaabnjrefucb1jyeabbqw/wlcagqeagpidyt0ivcsaaaaasuvork5cyii=); color: #252525; font-family: sans-serif;"><li style="margin-bottom: 0.1em; text-align: left;"><a style="text-decoration: none; color: #0b0080; background: none;" title="3GPP" href="http://en.wikipedia.org/wiki/3GPP">3GPP</a> - 3rd Generation Partnership Project</li>
</ul><p data-char="800"><span style="color: #252525; font-family: sans-serif; line-height: 22.3999996185303px;"> </span><img style="vertical-align: top; float: left;" src="http://www.extremetech.com/wp-content/uploads/2012/08/3gpp.gif" alt="" width="101" height="100" /></p><p data-char="800"> </p><p> </p>
<p data-char="800"> </p><p data-char="800"><a class="mw-redirect" style="text-decoration: none; color: #0b0080; background: none;" title="ANSI" href="http://en.wikipedia.org/wiki/ANSI">ANSI</a><span style="color: #252525; font-family: sans-serif; line-height: 22.3999996185303px;"> - </span><a style="text-decoration: none; color: #0b0080; background: none;" title="American National Standards Institute" href="http://en.wikipedia.org/wiki/American_National_Standards_Institute">American National Standards Institute</a><br /><img style="color: #252525; font-family: sans-serif; line-height: 22.3999996185303px; text-align: right; vertical-align: top; float: left;" src="http://www.acca.org/wp-content/uploads/2014/01/ANSI_logo.jpg" alt="" width="88" height="87" /><span style="color: #252525; font-family: sans-serif;"><span style="line-height: 22.3999996185303px;"><br /></span></span></p><p data-char="800"><span style="color: #252525; font-family: sans-serif;"><span style="line-height: 22.3999996185303px;"> </span></span></p><p data-char="800"><span style="color: #252525; font-family: sans-serif;"><span style="line-height: 22.3999996185303px;"> </span></span></p><ul style="line-height: 22.3999996185303px; margin: 0.3em 0px 0px 1.6em; padding: 0px; color: #252525; font-family: sans-serif;"><li style="margin-bottom: 0.1em;"><a style="text-decoration: none; color: #0b0080; line-height: 22.3999996185303px; background-image: none; background-attachment: initial; background-size: initial; background-origin: initial; background-clip: initial; background-position: initial; background-repeat: initial;" title="Institute of Electrical and Electronics Engineers" href="http://en.wikipedia.org/wiki/Institute_of_Electrical_and_Electronics_Engineers">IEEE</a><span style="line-height: 22.3999996185303px;"> - Institute of Electrical and Electronics Engineers</span></li></ul><p data-char="800"><span style="color: #252525; font-family: sans-serif;"><span style="line-height: 22.3999996185303px;"><img style="float: left;" src="" alt="" width="120" height="87" /></span></span></p><p data-char="800"><span style="font-family: Verdana;"><span style="font-size: 12px; line-height: 20px;"> </span></span></p><p data-char="800"><span style="font-family: Verdana;"><br /><span style="font-size: 12px; line-height: 20px;"><br /></span></span></p><p data-char="800"><span style="font-family: Verdana;"><span style="font-size: 12px; line-height: 20px;"> </span></span></p><ul style="line-height: 22.3999996185303px; margin: 0.3em 0px 0px 1.6em; padding: 0px; list-style-image: url(data:image/png; base64,ivborw0kggoaaaansuheugaaaauaaaanaqmaaabb8jblaaaablbmvex///8auow5qsojaaaaaxrstlmaqobyzgaaabnjrefucb1jyeabbqw/wlcagqeagpidyt0ivcsaaaaasuvork5cyii=); color: #252525; font-family: sans-serif;"><li style="margin-bottom: 0.1em;"><span style="font-family: Verdana; font-size: 12px; line-height: 20px; text-align: justify; color: #000000;">The World Association of Industrial and Technological Research Organizations (WAITRO)</span></li></ul><p data-char="800"><span style="font-family: Verdana; font-size: 12px; line-height: 20px; text-align: justify;"> </span><img style="vertical-align: top; float: left;" src="http://www.waitro.org/templates/waitro/images/logo.jpg" alt="" width="88" height="87" /></p><p data-char="800"> </p><p data-char="800"> </p><p data-char="800"> </p>';
}
$staticContent.='</div><div class="tab-pane " id="custom-tab-my-clients" data-attr="17" data-char="800" data-class="">';
if(!empty($expert->main_clients)){
	$staticContent.=stripslashes($expert->main_clients);
} else {
$staticContent.='
<h4 data-char="47">Companies and Institutions to which I Provided Services:</h4><p><img src="http://s3.amazonaws.com/corpsite2010-production/client_logos/original/13.png?1364589760" alt="" width="280" height="100" /><img src="http://s3.amazonaws.com/corpsite2010-production/client_logos/original/12.png?1364589765" alt="" width="280" height="100" /><img src="http://s3.amazonaws.com/corpsite2010-production/client_logos/original/4.png?1364589807" alt="" width="280" height="100" /><img src="http://s3.amazonaws.com/corpsite2010-production/client_logos/original/11.png?1364589813" alt="" width="280" height="100" /></p><p> </p><p> </p>';
}
$staticContent.='</div><div class="tab-pane " id="custom-tab-other" data-attr="18" data-char="800" data-class="">';
if(!empty($expert->other_area)){
	$staticContent.=stripslashes($expert->other_area);
} else {
$staticContent.='
<h4 data-char="47">Others</h4>
<p data-char="800"></p>';
}
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


<div class="row "> 
<div class="span6" id="user_address" data-attr="10" data-char="0" data-class="">
<h3>Get in touch with us</h3>';
$staticContent.='<p class="name" style="margin-bottom:0px;">';
if(!empty($expert->name)){
	$staticContent.=stripslashes($expert->name);
} else {
	$staticContent.='First Name Last Name';
}
if((int)$expert->expert_type==2){
	if($expert->company_name!=""){
		$staticContent .=" ( <span class='company_name'>".$expert->company_name."</span> ) ";
	}
}
$staticContent.='</p>';
$staticContent.='<p class="first_name" style="display:none">';
if(!empty($expert->first_name)){
	$staticContent.=stripslashes($expert->first_name);
} else {
	$staticContent.='First Name';
}
$staticContent.='</p><p class="last_name" style="display:none">';
if(!empty($expert->last_name)){
	$staticContent.=stripslashes($expert->last_name);
} else {
	$staticContent.='Last Name';
}

$staticContent.='</p>';
$urlUsername = $expert->username;
//$urlUsername = str_replace('.','__',$urlUsername);
$webAddress = JURI::base().$urlUsername;
$webAddress = 'https://synpat.com/experts/'.$urlUsername;
if($expert->web!='' && $expert->web!='www.yourwebsite.com'){
	$webAddress = $expert->web;
}
if(substr($webAddress,0,1)=="/"){
	$webAddress = substr($webAddress,1);
}
$staticContent.='<p class="web" style="margin-bottom:0px;"><a onclick="openProfileLink(jQuery(this))" href="javascript://" data-href="'.$webAddress.'" target="_blank">'.$webAddress.'</a> </p>';
$emailAddress = $expert->email;
if($expert->contact_email!=''){
	$emailAddress = $expert->contact_email;
}
$staticContent.='<p class="email" style="margin-bottom:0px;"><a href="mailto:'.$emailAddress.'">'.$emailAddress.'</a></p>';

$staticContent.='<p class="phone" style="margin-bottom:0px;"> ';
if(!empty($expert->phone)){
	$staticContent.=stripslashes($expert->phone);
} else {
	$staticContent.='(212) 555 55 00';
}
$staticContent.='</p>';
$staticContent.='<p class="address">';
if(!empty($expert->address)){
	$staticContent.=stripslashes(trim($expert->address));
} else {
$staticContent.='Street Address nr 100, 4536534, Your Town, United States';
}
$staticContent.='</p>';
$staticContent.='<p class="freetext" data-char="">';

if(!empty($expert->free_text)){
	$staticContent.=stripslashes($expert->free_text);
} else {
$staticContent.='Pellentesque habitant morbi tristique senectus et netus et malesuada fames ac turpis egestas. Vestibulum tortor quam, feugiat vitae, ultricies eget, tempor sit amet, ante. Donec eu libero sit amet quam egestas semper. Aenean ultricies mi vitae est. Mauris placerat eleifend leo.';
}


$staticContent.='</p>
</div>
<div class="span6">
';
if($expert->address!="" && $expert->address!="Street Address nr 100, 4536534, Your Town, United States"){
	$staticContent.='<iframe width="640" height="480" frameborder="0" scrolling="no" marginheight="0" marginwidth="0" src="https://maps.google.it/maps?q='.$expert->address.'&output=embed"></iframe>';
}
$staticContent.='</div></div>

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
	<?php 
		$tmpl = JRequest::getVar('tmpl','');
	?>
	<style>
	#image_desc,#choose_us{min-height:150px;}
	#image_desc img{width: auto !important;max-height: 134px;max-width:200px;height:auto !important;}
	#testimonial{min-height:85px;}
	.vertical_tabs .tab-content p, .vertical_tabs .tab-content span, .vertical_tabs .tab-content p span	{letter-spacing:unset !important;line-height:20px;font-family:'Open Sans' !important;}
	@media print and orientation:landscape{
		.tabbable{page-break-before:always;}
	}
	@media print{
		body {-webkit-print-color-adjust: exact;transform: scale(.97);}
		body,p,a,h1,h2,h3,h4,h5,h6,table,.vertical_tabs .tab-content p, .vertical_tabs .tab-content span, .vertical_tabs .tab-content p span{font-family:'Open Sans' !important;}
		a[href]:after {
			content: none !important;
		 }
		blockquote:{border:0px !important;border-left:5px solid #eee !important;}
		.span3{width:210px;}
		#skills_diagram{width:400px;height:300px;}
		#skills_diagram .skills li{color:#fff!important;}
		#testimonial{width:50%;}
		#statbox{/*page-break-before:always;*/margin-top:50px;}
		.tabbable{margin-top:50px;}
		.vertical_tabs.tabbable .nav {width:30%;} 
		.vertical_tabs.tabbable .tab-content{width:70%;padding: 0 0 0 10px;}
		.vertical_tabs.tabbable .nav>li.active>a{color:#cd2122!important;}
	}
	/*@page{size: landscape;}*/
	</style>
     <div id="profileData">
		<?php 
			if(empty($tmpl) ||$tmpl!='component'):
		?>								
		<dl class="article-info clearfix">
			<dd class="active category-name"><a style='color:#cd2122' href="<?php echo JRoute::_('index.php?option=com_survey&task=customer.expertProfile&display='.$this->id)?>">Profile</a></dd>
			<?php if($sessionEXpertID>0):?>
			<dd class="createdby"><a href="<?php echo JRoute::_('index.php?option=com_survey&task=customer.expertOpportunites&display='.$this->id)?>" >Projects</a></dd>
			
			<dd class="createdby"><a href="<?php echo JRoute::_('index.php?option=com_survey&task=customer.expertProcess&display='.$this->id)?>">In Process</a></dd>
			<?php endif;?>
			<dd class="createdby"><a href="<?php echo JRoute::_('index.php?option=com_survey&task=customer.expertReport&display='.$this->id)?>">My Reports</a></dd>			
			<?php if($sessionEXpertID>0):?>
			<dd class="createdby"><a href="<?php echo JRoute::_('index.php?option=com_survey&task=customer.expertArea&display='.$this->id)?>" >My Expertise</a></dd>
			<?php endif;?>
			<!--<dd class="published"><a href="<?php echo JRoute::_('index.php?option=com_survey&task=customer.blog&display='.JRequest::getInt('display'))?>">My Blog</a></dd>-->
			<dd class="published"><a href="<?php echo JRoute::_('index.php?option=com_survey&task=customer.expertFeedback&display='.$this->id)?>">Feedback</a></dd>
			<?php if($sessionEXpertID>0):?>
			<dd class="createdby" ><a href="<?php echo JRoute::_('index.php?option=com_users&task=user.logout&'.JUtility::getToken().'=1');?>" >Logout</a></dd>
			<dd style='float:right'>
				<?php if(is_array($imageUrl) && !empty($imageUrl[0])):?> <img src='<?php echo $imageUrl[0]?>' width="30px"/><?php else:?><img src='<?php echo JURI::root();?>templates/kallyas/images/user.png' width="30px"/> <?php endif;?>&nbsp;&nbsp;<?php echo $name;?>
			</dd>
			<?php endif;?>
		</dl>
		<?php endif;?>
					
			<!-- Profile data-->	
			<?php 
			if(empty($tmpl) ||$tmpl!='component'):
			?>
				<ul class="actions">
					<li class="print-icon">
						<a href="<?php echo JRoute::_(JURI::base()."index.php?option=com_survey&task=customer.expertProfile&display=".$this->id."&tmpl=component&print=1&page=")?>" data-rel="tooltip" onclick="window.open(this.href,'win2','status=no,toolbar=no,scrollbars=yes,titlebar=no,menubar=no,resizable=yes,width=640,height=480,directories=no,location=no');return false;" rel="nofollow" data-original-title="Print"><span class='icon-print icon-white'></span></a>
					</li>
					<?php if($this->id==$sessionEXpertID):?>
					<li class="edit-icon">
						<a href="javascript://" onclick="showEdit();" data-rel="tooltip" title="" data-original-title="Edit Profile"><span class="icon-edit icon-white"></span></a>
					</li>
					<?php endif;?>
				 </ul>
			<?php endif;?>		
				<div class="viewControl">
				<?php 
					echo $staticContent;				
					
				?>
				</div>
					
			<!-- End Profile data-->
     </div>
	<!-- Modal -->
	<style>
		.modal.large {
			 width: 60%; /* desired relative width */
			  left: 20%; /*(100%-width)/2 */ 
			  /* place center */
			  margin-left:auto;
			  margin-right:auto; 
		}


		.actions .edit-icon a {
			background-color: rgba(255,0,0,0.4) !important;
		}
		.actions .edit-icon a:hover {
			background-color: rgba(255,0,0,0.6) !important;
		}
	</style>
	<div id="myModal" class="modal hide fade" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
		<form method="post" action="index.php" enctype='multipart/form-data'>
			<div class="modal-header">
				<button type="button" class="close" data-dismiss="modal" aria-hidden="true">x</button>
				<h3 id="myModalLabel">Update Profile</h3>
			</div>
			<div class="modal-body" id="modalBody" style='text-align:center'>
				
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
			jQuery('#myModal').on('hidden', function () {
				destroyZIndexToA();
			});
		});
	}
	function addElement(){
		jQuery("#modalBody").append('<div class="control-group"><div class="controls"><input class="span5" type="text" name="field_choose_us[]" value=""></div></div>');
	}
	
	function showEdit(){
		jQuery("#image_desc,#choose_us,#testimonial,#custom-tab-main-area,#custom-tab-standard-expertise,#custom-tab-membership,#custom-tab-standardgroup,#custom-tab-cvresume,#skills_diagram,#user_address,#completed_claim,#completed_priorart,#sold_report,#working_hours,#subtitle,#custom-tab-professional-membership,#custom-tab-my-clients,#custom-tab-other").prepend(function(){
			jQuery(this).prepend('<span class="edit '+jQuery(this).attr('data-class')+' enable_edit edit-icon"><a href="javascript:void(0);" onclick="editPanel(jQuery(this),'+jQuery(this).attr('data-attr')+')";><span class="icon-pencil"></span></a></span>');
		});
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
				var regex = /<br\s*[\/]?>/gi;
				_desc = _desc.replace(regex, "\n");
				_htmlContent = "<div class='control-group'><lable>Upload Photo</label><div class='controls'><input type='file' name='file_image'/><input type='hidden' name='old_image' value='"+jQuery("#image_desc").find('img.alignleftborder').attr('src')+"' /></div></div>";
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
						_elementData +="<div class='control-group'><div class='controls'><input class='span8' type='text' name='field_choose_us[]' value='"+jQuery(this).html()+"'/></div></div>";
					});
				}
				//jQuery("#modalBody").html("<div class='control-group'><div class='controls'><input class='span5' type='text' name='field_choose_heading' value='"+_heading+"'/></div></div>"+_elementData);		
				jQuery("#modalBody").html(_elementData);		
			break;
			case 3:
				/*Testimonial*/
				_blockQuote = jQuery("#testimonial").find('blockquote').find('p').html();
				jQuery("#modalBody").html('<div class="control-group"><div class="controls"><input class="span5" type="text" name="testimonial" value="'+_blockQuote+'"/></div></div>');
				jQuery("#modalBody").append("<div class='control-group'><div class='controls'><input class='span5' type='text' name='testimonial_by' value='"+jQuery("#testimonial").find('blockquote>small').text()+"'/></div></div>");
			break;
			case 4:
				/*Main Area*/
				//jQuery("#modalBody").html("<div class='control-group'><label>Title</label><div class='controls'><input class='span5' type='text' name='main_area_heading' value='"+jQuery("#custom-tab-main-area").find('h4').html()+"'/></div></div>");
				_desc = "";
				if(jQuery("#custom-tab-main-area").html().length>1){
					_desc =jQuery("#custom-tab-main-area").html(); 
				}
				//jQuery("#modalBody").append("<div class='control-group'><lable>Image</label><div class='controls'><input type='file' name='main_area_image' /><input type='hidden' name='old_image' value='"+jQuery("#custom-tab-main-area").find('img.alignright').attr('src')+"' /></div></div>");
				jQuery("#modalBody").html("<div class='control-group'><lable>Description</label><div class='controls'><textarea name='main_area_description' class='mceAdvanced' style='width:100%;height:350px'>"+_desc+"</textarea></div></div>");
				addEditor();
			break;
			case 5:
				/*Standard Main Area*/
				//jQuery("#modalBody").html("<div class='control-group'><label>Title</label><div class='controls'><input class='span5' type='text' name='main_standard_area_heading' value='"+jQuery("#custom-tab-standard-expertise").find('h4').html()+"'/></div></div>");
				_desc = "";
				if(jQuery("#custom-tab-standard-expertise").html().length>1){
					_desc =jQuery("#custom-tab-standard-expertise").html();
				}
				//jQuery("#modalBody").append("<div class='control-group'><lable>Image</label><div class='controls'><input type='file' name='main_standard_area_image' /><input type='hidden' name='old_image' value='"+jQuery("#custom-tab-standard-expertise").find('img.alignright').attr('src')+"' /></div></div>");
				jQuery("#modalBody").html("<div class='control-group'><lable>Description</label><div class='controls'><textarea name='main_standard_area_description' class='mceAdvanced' style='width:100%;height:350px'>"+_desc+"</textarea></div></div>");
				addEditor();
			break;
			case 6:
				/*Membership*/
				//jQuery("#modalBody").html("<div class='control-group'><label>Title</label><div class='controls'><input class='span5' type='text' name='main_membership_heading' value='"+jQuery("#custom-tab-membership").find('h4').html()+"'/></div></div>");
				_desc = "";
				if(jQuery("#custom-tab-membership").html().length>1){
					_desc =jQuery("#custom-tab-membership").html();
				}
				//jQuery("#modalBody").append("<div class='control-group'><lable>Image</label><div class='controls'><input type='file' name='main_membership_image' /><input type='hidden' name='old_image' value='"+jQuery("#custom-tab-membership").find('img.alignright').attr('src')+"' /></div></div>");
				jQuery("#modalBody").html("<div class='control-group'><lable>Description</label><div class='controls'><textarea name='main_membership_description' class='mceAdvanced' style='width:100%;height:350px'>"+_desc+"</textarea></div></div>");
				addEditor();
			break;
			case 7:
				/*Standard Group*/
				//jQuery("#modalBody").html("<div class='control-group'><label>Title</label><div class='controls'><input class='span5' type='text' name='main_standard_group_heading' value='"+jQuery("#custom-tab-standardgroup").find('h4').html()+"'/></div></div>");
				_desc = "";
				if(jQuery("#custom-tab-standardgroup").html().length>1){
					_desc =jQuery("#custom-tab-standardgroup").html();
				}
				//jQuery("#modalBody").append("<div class='control-group'><lable>Image</label><div class='controls'><input type='file' name='main_standard_group_image' /><input type='hidden' name='old_image' value='"+jQuery("#custom-tab-standardgroup").find('img.alignright').attr('src')+"' /></div></div>");
				jQuery("#modalBody").html("<div class='control-group'><lable>Description</label><div class='controls'><textarea name='main_standard_group_description' class='mceAdvanced' style='width:100%;height:350px'>"+_desc+"</textarea></div></div>");
				addEditor();
			break;
			case 8:
				/*CVResume*/
				//jQuery("#modalBody").html("<div class='control-group'><label>Title</label><div class='controls'><input class='span5' type='text' name='main_cvresume_heading' value='"+jQuery("#custom-tab-cvresume").find('h4').html()+"'/></div></div>");
				_desc = "";
				if(jQuery("#custom-tab-cvresume").html().length>1){
					_desc =jQuery("#custom-tab-cvresume").html();
				}
				//jQuery("#modalBody").append("<div class='control-group'><lable>Image</label><div class='controls'><input type='file' name='main_cvresume_image' /><input type='hidden' name='old_image' value='"+jQuery("#custom-tab-cvresume").find('img.alignright').attr('src')+"' /></div></div>");
				jQuery("#modalBody").html("<div class='control-group'><lable>Description</label><div class='controls'><textarea name='main_cvresume' class='mceAdvanced' style='width:100%;height:350px'>"+_desc+"</textarea></div></div>");
				addEditor();
			break; 
			case 16:
				/*Professional Memberships*/
				//jQuery("#modalBody").html("<div class='control-group'><label>Title</label><div class='controls'><input class='span5' type='text' name='main_cvresume_heading' value='"+jQuery("#custom-tab-cvresume").find('h4').html()+"'/></div></div>");
				_desc = "";
				if(jQuery("#custom-tab-professional-membership").html().length>1){
					_desc =jQuery("#custom-tab-professional-membership").html();
				}
				//jQuery("#modalBody").append("<div class='control-group'><lable>Image</label><div class='controls'><input type='file' name='main_cvresume_image' /><input type='hidden' name='old_image' value='"+jQuery("#custom-tab-cvresume").find('img.alignright').attr('src')+"' /></div></div>");
				jQuery("#modalBody").html("<div class='control-group'><lable>Description</label><div class='controls'><textarea name='main_professtional_membership' class='mceAdvanced' style='width:100%;height:350px'>"+_desc+"</textarea></div></div>");
				addEditor();
			break; 
			case 17:
				/*My Client*/
				//jQuery("#modalBody").html("<div class='control-group'><label>Title</label><div class='controls'><input class='span5' type='text' name='main_cvresume_heading' value='"+jQuery("#custom-tab-cvresume").find('h4').html()+"'/></div></div>");
				_desc = "";
				if(jQuery("#custom-tab-my-clients").html().length>1){
					_desc =jQuery("#custom-tab-my-clients").html();
				}
				//jQuery("#modalBody").append("<div class='control-group'><lable>Image</label><div class='controls'><input type='file' name='main_cvresume_image' /><input type='hidden' name='old_image' value='"+jQuery("#custom-tab-cvresume").find('img.alignright').attr('src')+"' /></div></div>");
				jQuery("#modalBody").html("<div class='control-group'><lable>Description</label><div class='controls'><textarea name='main_clients' class='mceAdvanced' style='width:100%;height:350px'>"+_desc+"</textarea></div></div>");
				addEditor();
			break; 
			case 18:
				/*Other*/
				//jQuery("#modalBody").html("<div class='control-group'><label>Title</label><div class='controls'><input class='span5' type='text' name='main_cvresume_heading' value='"+jQuery("#custom-tab-cvresume").find('h4').html()+"'/></div></div>");
				_desc = "";
				if(jQuery("#custom-tab-other").html().length>1){
					_desc =jQuery("#custom-tab-other").html();
				}
				//jQuery("#modalBody").append("<div class='control-group'><lable>Image</label><div class='controls'><input type='file' name='main_cvresume_image' /><input type='hidden' name='old_image' value='"+jQuery("#custom-tab-cvresume").find('img.alignright').attr('src')+"' /></div></div>");
				jQuery("#modalBody").html("<div class='control-group'><lable>Description</label><div class='controls'><textarea name='main_other_area' class='mceAdvanced' style='width:100%;height:350px'>"+_desc+"</textarea></div></div>");
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
				_address = jQuery('p.address').html();
				_phoneNumber = jQuery('p.phone').html();
				_firstName = jQuery('p.first_name').html();
				_lastName = jQuery('p.last_name').html();
				_web = jQuery('p.web > a').text();
				_email = jQuery('p.email > a').text();
				_elementData = "<div class='control-group'><div class='controls'><input type='text' class='span4' placeholder='First Name' name='first_name' value='"+_firstName+"'/></div></div><div class='control-group'><div class='controls'><input type='text' class='span4' placeholder='Last Name' name='last_name' value='"+_lastName+"'/></div></div>";
				if(jQuery('span.company_name').length>0){
					_companyName = jQuery('span.company_name').text();
					_elementData +="<div class='control-group'><div class='controls'><input type='text' class='span4' placeholder='Company Name' name='company_name' value='"+_companyName+"'/></div></div>";
				}
				_elementData +="<div class='control-group'><div class='controls'><input type='text' class='span4' placeholder='Address' name='address' value='"+_address+"'/></div></div><div class='control-group'><div class='controls'><input type='text' class='span4' placeholder='Web address' name='web_address' value='"+_web+"'/><p class='span4' style='margin-left:70px;text-align:left;'>If you prefer customers to be addressed to another web address, please provide it here.</p></div></div><div class='control-group'><div class='controls'><input type='text' class='span4' placeholder='Email' name='display_email' value='"+_email+"'/></div></div><div class='control-group'><div class='controls'><input type='text' class='span4' placeholder='Phone number' name='phone_number' value='"+_phoneNumber+"'/></div></div><div class='control-group'><div class='controls'><textarea type='text' class='span4' name='free_text' placeholder='Free text'>"+jQuery('p.freetext').html()+"</textarea></div></div>";
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
				_dataChar = object.parent().parent().attr('data-char');
				_elementData = "<h4>Title</h4><div class='control-group'><div class='controls'><input type='text' class='span8' autocomplete='off' maxlength='"+_dataChar+"' name='sub_title' value='"+jQuery("#subtitle").find('p').html()+"'/></div></div>";
				jQuery("#modalBody").html(_elementData);
			break;
		}
		jQuery("#default_type").val(element_type);
		jQuery("#myModal").modal('toggle');
	}
	function openProfileLink(o){
		_url  = o.text();
		if(_url!="" && (_url.indexOf('http')>=0 || _url.indexOf('www')>=0)){
			if(_url.indexOf('http')<0){
				_url = "http://"+_url;
			}
			window.open(_url,"_blank");
		}
	}
  </script>
