<?php
// No direct access to this file
header('X-Frame-Options: Google.com'); 
defined('_JEXEC') or die('Restricted access');
if(count($this->item)>0):
$paypalData = $this->paypalData;
$paypalID = "";
$surveyDetail = $this->surveyData;
$surveyAmtData = $this->surveyAmtData;
$projectDetails = $this->projectData;
$surveyAmount = "";
$runReport = 3;
$reportOptionType = 1;
if(count($surveyAmtData)>0){
	$surveyAmount = $surveyAmtData->amount;
	$runReport = $surveyAmtData->run_report;
	$reportOptionType = $surveyAmtData->report_option_type;
}

if(count($paypalData)>0){
	$paypalID = $paypalData->paypal_id;
}
$surveyID = 0;
$staticContent = "";
$session = JFactory::getUser();
$getSession = new stdClass();
if ($session->id > 0) {
	$getSession = SurveyModelAnswer::expertUserData($session->id);
	
	$sessionEXpertID = $getSession->id;
	$imageUrl = array();
    if(!empty($getSession->profile_desc)){
		$staticContent =stripslashes($getSession->profile_desc);
		preg_match_all('~<img.*?src=["\']+(.*?)["\']+~', $getSession->profile_desc, $urls);
		$imageUrl = $urls[1];
	}
	if((int)$getSession->expert_type==2){
		$name = $getSession->company_name;
	} else {
		$name = $getSession->name;
	}
}
?>
<style>
#editor-xtd-buttons, .toggle-editor{
display:none;	
}
.mceToolbarRow3{
	display:inline-block;
	position:relative;
	left:-9999px;
	width:0px !important;
	height:0px !important;
}.mceToolbarRow4{/*margin-top:-15px !important;*/}
table.mceToolbarRow1,.mceToolbarRow4,.mceToolbarRow2{float:left}
table.mceToolbarRow1 tr td:nth-child(11),table.mceToolbarRow1 tr td:nth-child(12),table.mceToolbarRow1 tr td:nth-child(13){position:relative;left:-9999px;width:0px;height:0px;display:inline-block;}
table.mceToolbarRow2 tr td:nth-child(1),table.mceToolbarRow2 tr td:nth-child(2),table.mceToolbarRow2 tr td:nth-child(3),table.mceToolbarRow2 tr td:nth-child(4),table.mceToolbarRow2 tr td:nth-child(5),table.mceToolbarRow2 tr td:nth-child(6),table.mceToolbarRow2 tr td:nth-child(7),table.mceToolbarRow2 tr td:nth-child(10),table.mceToolbarRow2 tr td:nth-child(11),table.mceToolbarRow2 tr td:nth-child(12),table.mceToolbarRow2 tr td:nth-child(13),table.mceToolbarRow2 tr td:nth-child(14),table.mceToolbarRow2 tr td:nth-child(15),table.mceToolbarRow2 tr td:nth-child(16),table.mceToolbarRow2 tr td:nth-child(17){position:relative;left:-9999px;width:0px;height:0px;display:inline-block;}
.uneditable-input, input, textarea{width:120px;}
.lWidth{width:235px;}
.dMxxx{margin-bottom:30px !important;}
div#profileData > div.current{
		float:left;
	}


	/** Ans form */

	.ans-form-title {
		position: relative;
	}
	.ans-form-title span {
		font-weight: normal;
  		left: 210px;
		position: absolute;
	}
	.ans-form-right textarea {
		  box-sizing: border-box;
		  cursor: default;
		  min-height: 120px;
		  margin-top: 16px;
		  overflow: scroll;
		  resize: none;
		  width: 100%;
	}
	.ans-form-buttons {

	}
	.ans-form-buttons a {
		/*margin-left: 3px;
		margin-right: 3px;*/
	}
	.ans-form-buttons a:first-child {
		/*margin-left: -5px;*/
	}
	.ans-form-buttons a:last-child {
		margin-right: 0;
	}

	@media (max-width: 991px) {
		.ans-form-title span {
			display: block;
			position: static;
		}
	}

	@media (min-width: 768px) {
		/*.ans-form-left {
			width: 41.6666% !important;
		}
		.ans-form-right {
			width: 58.3333% !important;
		}*/
	}

	@media (max-width: 767px) {
		.ans-form-right textarea {
			margin-top: 0;
		}
	}
	

	/** Slidebar */
	.slidebar-close {
		left: 10px;
		right: auto;
	}
	.mceStatusbar span{display:none;}
.nav>li>a{display:inline;}
.mrgR5{margin-left:5px;}
.ans-form-left label{padding-top:5px;}
</style>
<script>
function toggleInstructions(){
					if(jQuery("#instructions").is(':visible')){
						jQuery(".sign").removeClass('minus').addClass('plus').text('+');
					} else {
						jQuery(".sign").removeClass('plus').addClass('minus').text('-');
					}
					jQuery("#instructions").toggle();
				}
</script>
<div class="span12 noMargin"> 
	<div id="profileData" class='ansewerQuestionareAll'>
		<dl class="article-info clearfix">
			<?php if($session->id>0):?>
			<dd class="createdby"><a style='color:#cd2122' href="javascript:alertFunction();" >Projects</a></dd>
			<?php endif;?>
			<dd class="createdby"><a href="javascript:alertFunction();">In Process</a></dd>
			<dd class="createdby"><a href="javascript:alertFunction();">My Report</a></dd>			
			<?php if($session->id>0):?>
			<dd class="createdby"><a href="javascript:alertFunction();" >My Experties</a></dd>
			<?php endif;?>
			<!--<dd class="published"><a href="avascript:alertFunction();">My Blog</a></dd>-->
			<dd class="published"><a href="javascript:alertFunction();">Feedback</a></dd>
			<dd class="published"><a href="javascript:alertFunction();">Terms of Use</a></dd>
			<?php if($session->id>0):?>
			<dd class="createdby" ><a href="<?php echo JRoute::_('index.php?option=com_users&task=user.logout&'.JUtility::getToken().'=1');?>" >Logout</a></dd>
			<dd style='float:right'>
				<a style='color:#1a73e8;' href='javascript:alertFunction();'>
				<?php if(isset($imageUrl) && is_array($imageUrl) && !empty($imageUrl[0])):?> <img src='<?php echo $imageUrl[0]?>' width="30px"/><?php else:?><img src='<?php echo JURI::root();?>templates/kallyas/images/user.png' width="30px"/> <?php endif;?>&nbsp;&nbsp;<?php echo $name;?></a>
			</dd>
			<?php endif;?>
		</dl>
		<div class="">
			<div class="alert alert-danger hide" id='alert_show'></div>
			<div class="span12 noMarginLeft">
				<a href='javascript://' style='color:#cd2122;' onclick="toggleInstructions();"><strong><span class='sign plus' style='display:inline-block;width:8px;'>+</span> Instructions</strong></a>
				<div id="instructions" style="display:none;margin-top:20px;">
					<?php if($surveyDetail->report_type==2):?>
					<p>Dear SME, please follow these instructions in creating your report:</p>
					<ul class="nav">
						<li>1.<span class='mrgR5'>Try to provide evidence showing the implementation of each of the claim elements. You can paste into the editor images as well as text. Make sure to paste text as a simple text (right click, "paste as simple text") otherwise the functionality of the editor might be compromised. To capture screenshots, make annotations and paste images in the editors, we recommend using this application for chrome browser: <a class='button-link' href="https://jasonsavard.com/explainAndSendScreenshots" target="_blank">https://jasonsavard.com/explainAndSendScreenshots</a> or for other browsers: <a class='button-link' href="https://qsnapnet.com/" target="_blank">https://qsnapnet.com/</a></span></li>
						<li>2.<span class='mrgR5'>For each element that you cover, please provide explanations, and upload documentations that support your conclusion regarding the target.</span></li>
						<li>3.<span class='mrgR5'>Under each element, mark the corresponding check box. If you believe you provided qualifying evidence.</span></li>
						<?php if($this->item[0]->payment_type=="1"):?>
						<li>4.<span class='mrgR5'>Provide your hourly rate for this report. Keep in mind that this hourly rate will not show on your profile, rather it is used for this project only.</span></li>
						<?php else:?>
						<li>4.<span class='mrgR5'>Provide your asking price for your report, in U.S. Dollars.</span></li>
						<?php endif;?>
						<li>5.<span class='mrgR5'>In the Target line, use the formal name of the target product/system/service that you cover, preceded by the name of its maker. That would allow an accurate retrieval in future searches.</span></li>
						<li>6.<span class='mrgR5'>Please remember to Save and Close before leaving this editor.<br/> <a href="javascript:void(0)" onclick="openExampleReport();" class='button-link'>See example report</a></span></li>					
					</ul>
					<?php else:?>
					<p>Dear SME, please follow these instructions in creating your Prior Art report:</p>
					<ul class="nav">
						<li>1.<span class='mrgR5'>Since Prior art is any evidence that an invention was already publicly known or available in whole or in part before its effective filing date, please try to provide evidence showing that each of the claim elements was publicly known or available before its filling date. You may use the link to Google Patents in order to identify that date, and make sure all the evidence you provide precede that date.</li>
						<li>2.<span class='mrgR5'>You may paste into the editor images as well as text. Make sure to paste text as a simple text (right click, "paste as simple text") otherwise the functionality of the editor might be compromised. To capture screenshots, make annotations and paste images in the editors, we recommend using this application for chrome browser: <a class='button-link' href="https://jasonsavard.com/explainAndSendScreenshots" target="_blank">https://jasonsavard.com/explainAndSendScreenshots</a> or for other browsers: <a class='button-link' href="https://qsnapnet.com/" target="_blank">https://qsnapnet.com/</a></span></li>
						<li>3.<span class='mrgR5'>For each element that you cover, please provide explanations, and upload documentations that support your conclusion that 1) the evidence shows the claim element was known 2) before the application's effective filing date.</span></li>
						<?php if($this->item[0]->payment_type=="1"):?>
						<li>4.<span class='mrgR5'>Under each element, mark the corresponding check box. If you believe you provided qualifying evidence.</span></li>
						<li>5.<span class='mrgR5'>Provide your hourly rate for this report. Keep in mind that this hourly rate will not show on your profile, rather it is used for this project only.</span></li>
						<?php else:?>
						<li>5.<span class='mrgR5'>Provide your asking price for your report, in U.S. Dollars.</span></li>
						<?php endif;?>						
						<li>6.<span class='mrgR5'>Please remember to Save and Close before leaving this editor.<br/> <a href="javascript:void(0)" onclick="openExampleReport();" class='button-link'>See example report</a></span></li>					
					</ul>
					<?php endif;?>
				</div>
				<p class='error-message' style='color:#cd2122'></p>
			</div>
			<?php 
				if($runReport==0 && $surveyDetail->report_type==1 && count($surveyAmtData)>0){
			?>
				<div class="row">
					<div class="span12">
					<p class="alert alert-warning">You have already created Prior Art report for Claim: <?php echo $surveyDetail->name;?> </p>
					</div>
				</div>
				<script>
				function alertFunction(){
					window.location = '<?php echo JURI::base()?>/component/survey/?task=customer.expertProfile&display=<?php echo $sessionEXpertID;?>';
				}
				</script>
			<?php
					
				} else {
			?>
				<script>
				function alertFunction(){
					alert('Please click Save and Close');
				}
				</script>
			
			
			
			<form id="ans-form" action="index.php" method="post" enctype="multipart/form-data" class="clearfix">
			<div class="ans-form-left span12 noMargin">
			<?php 
				$patent = $this->item[0]->survey_name;
				if(strpos(strtolower($this->item[0]->survey_name),"us")===false){
					$patent = "US".$patent;
				}
			?>
			<h1 class="ans-form-title arial noMargin form-inline" style="font-size:14px; font-weight:bold;"><?php echo $this->item[0]->combineName;?>
				<span>See at
					<a href="https://patents.google.com/patent/<?php echo $patent?>/en?oq=<?php echo $patent?>" target="_blank" class='button-link' >Google Patents</a>
				</span>
			</h1>
				<div class="row">
					<?php /*<div class="arial bold">
						<label class="pull-left lWidth" style="margin-top: 6px;">Your Paypal ID</label>
						<input type="text" name="paypal_id" id="paypal_id" style='font-size:14px !important' value="<?php echo $paypalID;?>"/>
					</div>*/?>
					<?php 
						$target='';
						$target_product = '';
						if($surveyDetail->report_type==2):
						$target =(JRequest::getVar('target')!="")?JRequest::getVar('target'):'';
						$target_product = (JRequest::getVar('target_product')!="")?JRequest::getVar('target_product'):'';
						if(count($surveyAmtData)>0){
							$target_product = $surveyAmtData->target_product;
						}
						
					?>
					<div class="span4" style=''>
						<label class="pull-left" style="width:120px;">Target Company:</label>
						<input type="text"  name="target" id="target" style='margin-bottom:0px;font-size:14px !important;width:230px;' value="<?php echo $target;?>" maxlength="15"/>						
					</div>
					<div class="span4" style=''>
						<label class="pull-left" style="width:120px;">Target Product:</label>
						<input type="text"  name="target_product" id="target_product" style='margin-bottom:0px;font-size:14px !important;width:230px;' value="<?php echo $target_product;?>" maxlength="30"/>
						
					</div>
					<?php else:?>
					<input type="hidden" value=""  name="target" id="target"/>
					<input type="hidden" value=""  name="target_product" id="target_product"/>
					<?php endif;?>
					<div class="span4">
						<?php /*
						<label class="pull-left" style="width:138px;margin-top: 6px;"><?php if($this->item[0]->payment_type=="1"):?>Your hourly rate ($)<?php else:?>Your Asking Price ($) <?php endif;?></label>
						<input type="text" name="amount" id="amount" value="<?php echo $surveyAmount;?>" style='margin-bottom:0;font-size:14px !important'/>
						<?php */?>
						<label class="pull-left lWidth" style='padding-top:0px;'>
							<select name="report_option_type" id="report_option_type" style="width:200px;margin-bottom:0px;" data-price="<?php echo $projectDetails->synpat_price;?>" onchange="priceUpdation(jQuery(this))">
								<option value="1" <?php if($reportOptionType==2):?> selected='selected' <?php endif;?>>Sell to SynPat's customers</option>
								<option value="2" <?php if($reportOptionType==2):?> selected='selected' <?php endif;?>>Sell to SynPat</option>
							</select> for $
						</label>
						<?php 
							
						?>
						<input type="text" name="amount" id="amount" value="<?php echo (is_numeric($surveyAmount))?number_format($surveyAmount,0):'';?>" style='margin-bottom:0;font-size:14px !important;width:120px;'/>
					</div>
					<div class="span12">
						<span style='font-size:14px; float: left; '>(Changing the Target Company / Product would create a new Report.)</span>
					</div>
				</div>
				</div>
			<div class='ans-form-right span12 noMargin'>
				<?php 
					$concatString ="";
					foreach($this->item as $item){
						$concatString .=$item->description.' ';
					}
					$concatString = preg_replace('/;/',';<br/>',$concatString);
					$concatString = preg_replace('/:/',':<br/>',$concatString);
				?>
				<p style='background-color:#eee;padding:5px;border-radius:4px;border:1px solid #ccc'><?php echo $concatString;?></p>
			</div>
			<div style='position:relative'>
				<div class="ans-form-buttons arial bold" style='margin:10px 0;font-size:14px;position:fixed; top:35px;right:15px;display:none;'>
					<a  onclick="<?php if($runReport>0):?>saveStatus(2);<?php else:?>saveStatus(2);<?php endif;?>" href='javascript://' id="btn-claim-submit" class=' btn btn-flat tM' style='float:right;'>Submit Report</a>
					<a href='javascript://' class=' btn btn-flat tM' onclick="saveStatus(1);" style='float:right;margin-right:10px;'>Save and Close</a>
					<?php if($surveyDetail->report_type==2):?>
					<a href="javascript:void(0)" id='viewReport' class='btn btn-flat tM' <?php if(JRequest::getVar('target')!="" && JRequest::getVar('target_product')!=""):?>onclick="jQuery('#frame_report_view').attr('src',jQuery(this).attr('data-href'));return showSlidebar('slidebarViewReport')"<?php endif;?> data-href='<?php echo JUri::base()?>index.php?option=com_survey&task=customer.viewReport&target_product=<?php echo JRequest::getVar('target_product');?>&target=<?php echo JRequest::getVar('target');?>&report_type=<?php echo $surveyDetail->report_type;?>&param=<?php echo JRequest::getVar('param');?>' style='float:right;margin-right:10px;'>View Report</a><?php else:?><a href="javascript:void(0)" id='viewReport' class=' btn btn-flat tM' onclick="jQuery('#frame_report_view').attr('src',jQuery(this).attr('data-href'));return showSlidebar('slidebarViewReport')" data-href='<?php echo JUri::base()?>index.php?option=com_survey&task=customer.viewReport&report_type=<?php echo $surveyDetail->report_type;?>&param=<?php echo JRequest::getVar('param');?>' style='float:right;margin-right:10px;'>View Report</a><?php endif;?>
				</div>
			</div>
				<div class="span12 arial noMargin" style="padding-top: 51px;">
					<?php
					$i=0;
					$allQuestions = "";
					$concatString ="";
					foreach($this->item as $item){		
						if($i==0){
							$surveyID = $item->survey_id;
						}
					?>
						<div class='elementsAns span12 noMarginLeft dMxxx' style='margin-top:15px;'>
							<label style='color:#cd2122'><b>Q <?php echo ++$i; ?>: <?php echo $item->description ;?></b></label>
							<?php			
								$concatString .=" ".$item->description;
								$editor1  = & JFactory::getEditor();	
								$variablename = base64_encode('data_'.$item->id);
								$allQuestions .= $item->id.",";
								$getDataByExpert = array();
								if($surveyDetail->report_type==2){
									if(JRequest::getVar('target')!=''){
										$getDataByExpert = $this->expertAnsQues($item->id,$this->expert , JRequest::getVar('target'),$target_product);
									}
								}else{
									$getDataByExpert = $this->expertAnsQuesPrior($item->id,$this->expert);
								}
								$answer = "";
								$status = "0";
								$fileUploaded = "";
								$id = 0;
							
								if(count($getDataByExpert)>0){
									$id = $getDataByExpert->id;
									$answer = $getDataByExpert->answer;
									if($getDataByExpert->supporting_document!=""){
										$fileUploaded = $getDataByExpert->supporting_document;
									}
									$status = $getDataByExpert->status;
								}
								
								echo $editor1->display( $variablename, $answer,  '100%;', '220px', '10', '10') ;
								if($i==1):
								?>
							<script>
								_instID = '<?php echo $variablename;?>';
							</script>
							<?php endif;?>
							<div style="margin-top:10px;">
								<label style="display:inline-block; margin-right: 20px;">Upload a supporting document in a JPEG OR PNG format.</label>
								<input type="file" class='<?php echo $variablename?>' name="file_<?php echo $item->id;?>[]" multiple="multiple" />
								<span style='font-size:14px;' class='support_document_<?php echo $variablename;?>' id="delete_file_button_<?php echo $id;?>"></span>
							</div>
								<?php 
									
									if($fileUploaded!=""){
										$allFiles = array();
										try{
											$allFiles = explode(',',$fileUploaded);
										}catch(Exception $e){
											
										}
										if(count($allFiles)>0){
											for($i=0;$i<count($allFiles);$i++){
												if($allFiles[$i]!=""){
								?>
											<div class="span12 noMargin image_support_<?php echo $id;?>" style='margin-bottom:10px !important;' id="delete_file_<?php echo $id;?>">
										<label>Supporting Document Uploaded by you <?php if($fileUploaded!=""):?><a href='javascript://' class='button-link' onclick='delete_file(<?php echo $id;?>,<?php echo $i?>,jQuery(this));'><img src="https://s3-us-west-1.amazonaws.com/knzbeoknwf/public/images/discard.png"/></a><?php endif;?></label>
										<img src="<?php echo JUri::base();?>components/com_survey/document/<?php echo $allFiles[$i];?>"/>
									</div>
								<?php
												}
											}
										}
									}
								?>
							
							<div class="pull-left" style="margin-top: 10px;">
								<input class="<?php echo $variablename?>_check" type="checkbox" <?php if($status==1):?>checked="checked" <?php endif;?> name="publish_<?php echo $item->id;?>" value="1" style='float:left'/><label class="pull-left" style="margin-left:5px;">The above explanations and documentations show that the claim element reads on the Target.</label>
							</div>							
						</div>
					<?php
					}
					$allQuestions =  substr($allQuestions,0,-1);
					?>
					
				</div>
				 <?php echo JHtml::_('form.token'); ?>
				<input type="hidden" name="option" value="com_survey" />
				<input type="hidden" name="task" value="answer.save" />
				<input type="hidden" name="ans_status" id="ans_status" value="1" />
				<input type="hidden" name="to_data" value="<?php echo base64_encode($allQuestions);?>" />
				<input type="hidden" id="expert_id" name="expert_id" value="<?php echo $this->expert;?>" />
				<input type="hidden" id="survey_id" name="survey_id" value="<?php echo $surveyID;?>" />
				<input type="hidden" name="id" value="<?php echo $id;?>" />
				
			</form>
			<script type="text/javascript">
(function(f){function l(g,h){function d(a){if(!e){e=true;c.start&&c.start(a,b)}}function i(a,j){if(e){clearTimeout(k);k=setTimeout(function(){e=false;c.stop&&c.stop(a,b)},j>=0?j:c.delay)}}var c=f.extend({start:null,stop:null,delay:400},h),b=f(g),e=false,k;b.keypress(d);b.keydown(function(a){if(a.keyCode===8||a.keyCode===46)d(a)});b.keyup(i);b.blur(function(a){i(a,0)})}f.fn.typing=function(g){return this.each(function(h,d){l(d,g)})}})(jQuery);
</script>
<script>
	 __cFS = false;
	 __TARGET = '<?php echo JRequest::getVar('target');?>';
	 __param = '<?php echo JRequest::getVar('param');?>'; 
	 _surveyReportType = 2;
	 __runReport = '<?php echo $runReport;?>';
	 <?php 
		if(count($surveyDetail)>0){
	?>
		_surveyReportType = <?php echo $surveyDetail->report_type;?>;
	<?php
		}
	?>
	_instID='';_startTime='';
	function checkValidation(){
		if(_surveyReportType==2){
			if(jQuery("#target").val()==""){
				alert("Please file in the Target Company");
				jQuery("#target").focus();
				return false;
			}
			if(jQuery("#target_product").val()==""){
				alert("Please file in the Target Product");
				jQuery("#target").focus();
				return false;
			}
			if(jQuery("#report_option_type").val()=="1"){
				if(jQuery("#amount").val()==""){
					alert("Please enter your asking price.");
					jQuery("#amount").focus();
					return false;
				}
			}
		}else if(_surveyReportType==1){
			if(jQuery("#report_option_type").val()=="1"){
				if(jQuery("#amount").val()==""){
					alert("Please enter your asking price.");
					jQuery("#amount").focus();
					return false;
				}
			}
		} 
		/*if(jQuery("#amount").val()==""){
			alert("Please enter your asking price.");
			jQuery("#amount").focus();
			return false;
		}*/
		return true;
	}
	jQuery(document).ready(function(){
		jQuery("#ans-form").live("submit", function(event) {
			event.preventDefault();       
		});
	});
	
	function saveStatus(id){
		jQuery("#ans_status").val(id);
		if(id=='1'){
			if(_surveyReportType==2 && jQuery.trim(jQuery("#target").val())==""){
				alert("Please fill in the Target Company.");
			} else if(_surveyReportType==2 && jQuery.trim(jQuery("#target_product").val())==""){
				alert("Please fill in the Target product.");
			} else {
				document.forms['ans-form'].submit();
			}
		} else if(id==0){			
			if(__runReport>0){				/*window.open(jQuery('#viewReport').attr('data-href')+"&show=1",'View Report','width=500,height=400');*/
				jQuery('#frame_report_view').attr('src',jQuery('#viewReport').attr('data-href')+"&show=1");
				jQuery("#slidebarClose").attr('onclick','saveStatus(2)');
				showSlidebar('slidebarViewReport');
				__runReport--;				
				jQuery.ajax({
					type:'POST',
					url:'<?php echo JUri::base()?>index.php?option=com_survey&task=customer.reportView',
					data:{p:__param,t:jQuery("#target").val(),t_p:jQuery("#target_product").val(),r:__runReport},
					cache:false,
					success:function(res){
						if(__runReport==0){
							jQuery("#btn-claim-submit").attr('onclick','saveStatus(2)');
						}
					}
				});
				jQuery('.error-message').html("You have "+__runReport+" remaining view request of file.");
			} else {
				jQuery("#btn-claim-submit").attr('onclick','saveStatus(2)');
			}
			
		} else if(id==2){
			res = confirm("Please confirmed that your report is ready for submittal. You'll still be able to edit your report three times after its first submittal.");			
			if(res==true){
				returnVal = checkValidation();
				if(returnVal==true){
					jQuery("#ans_status").val(0);
					document.forms['ans-form'].submit();
				}
			} else {
				hideSlidebar('slidebarViewReport');
				jQuery("#slidebarClose").attr('onclick',"jQuery('#frame_report_view').attr('src',jQuery('#viewReport').attr('data-href'));return hideSlidebar('slidebarViewReport')");
				return false;
			}
		}
	}
	
	
	jQuery(document).ready(function(){
		jQuery('input[name="amount"]').keyup(function(e)
		{  
			if (/\D/g.test(this.value))
			{
				// Filter non-digits from input value.
				this.value = this.value.replace(/\D/g, '');
			}
		});	
		jQuery(".ansewerQuestionareAll").find('input[type="text"]').typing({
			start: function (event, $elem) {
				__cFS = true;
				console.log('start typing...');
			},
			stop: function (event, $elem) {
				/**/
			},
			delay: 1000
		});	
		jQuery(".ansewerQuestionareAll").find('textarea').typing({
			start: function (event, $elem) {
				__cFS = true;
				console.log('start typing...');
				console.log("ID:"+jQuery(this).attr('id'));
				autoSave(0);
			},
			stop: function (event, $elem) {
				/**/
			},
			delay: 1000
		});
		jQuery('.ansewerQuestionareAll').find('textarea:hidden').on('input selectionchange propertychange',function(){
			__cFS = true;
			console.log('Stop typing..');autoSave(0);
		});
		jQuery('.ansewerQuestionareAll').find('textarea').change(function(){
			__cFS = true;autoSave(0);
			console.log('Stop typing..');
		});
		jQuery('.ansewerQuestionareAll').find('input[type="text"]').change(function(){
			__cFS = true;
			autoSave(0);
		});
		jQuery('.ansewerQuestionareAll').find('input[type="checkbox"]').change(function(){
			__cFS = true;
			_className = jQuery(this).attr('class');
			_class = _className.split('_check');
			_instID = _class[0];
			_newDate = new Date();
			_startTime = moment.tz(_newDate, 'America/Los_Angeles').format('YYYY-MM-DD HH:mm:ss');
			updateSingleElement();
		});
		files = [];
		jQuery('input[type="file"]').change(function(event){
			_thisMain = jQuery(this);
			_target = "";	
			if(_surveyReportType==2){
				_target = jQuery("#target").val();	
			}
			_ID = jQuery(this).attr('class');
			fileElement = document.getElementsByClassName(_ID);
			_fileName = jQuery(fileElement).attr('name');
			_fileValue = jQuery('input[name="'+_fileName+'"]').get(0).files;
			var aFormData = new FormData();
			aFormData.append("option", "com_survey");
			aFormData.append("task", "answer.saveImage");
			aFormData.append("expert_id", jQuery("#expert_id").val());
			aFormData.append("survey_id", jQuery("#survey_id").val());
			aFormData.append("ans_status", jQuery("#ans_status").val());
			aFormData.append("data_to", _ID);
			aFormData.append("target", _target);
			aFormData.append("target_product",jQuery("#target_product").val());
			if(typeof _fileValue!="undefined"){
				/*if(_fileValue.length>0){
					for(s=0;s<_fileValue.length;s++){
						aFormData.append(_fileName, _fileValue[s].name);
					}
				}*/
				var i = 0, len = fileElement[0].files.length, img, reader, file;

				for (; i < len; i++) {
					file = fileElement[0].files[i];

					/*if (window.FileReader) {
						reader = new FileReader();
						reader.onloadend = function(e) {
							showUploadedItem(e.target.result, file.fileName);
						};
						reader.readAsDataURL(file);
					}*/
					if (aFormData) {
						aFormData.append(_fileName, file);
					}
				}
				
				
				
				aFormData.append("format", '');
				jQuery.ajax({
					type:'POST',
					url:'<?php echo JUri::base()?>',
					contentType: false,
					processData: false,
					data: aFormData,
					dataType: "json",
					cache:false,
					success:function(d){
						_thisMain.val('');
						if(d.file_name!="" && d.file_name!=null){
							fileElement = document.getElementsByClassName("support_document_"+_ID);
							_files = d.file_name;
							_files = _files.toString();
							_files = _files.split(',');
							jQuery(fileElement).attr('id','delete_file_button_'+d.image_d);
							_string["amount"] = jQuery("#amount").val();
							_string["target_product"] = jQuery("#target_product").val();
							_string["target"] = _target;
							_string["explanation"] = '';
							_string["supporting_document"] = '<?php echo JUri::base();?>components/com_survey/document/'+d.file_name;
							if(jQuery('.image_support_'+d.image_d).length>0){
								jQuery('.image_support_'+d.image_d).remove();
							}
							if(_files.length>0){
								_sp = jQuery(fileElement).parent();
								_files.map(function(f,i){
									if(f!=""){
										_sp.after('<div clss="span12 noMargin image_support_'+d.image_d+'" style="margin-bottom:10px !important;" id="delete_file_'+d.image_d+'"><label>Supporting Document Uploaded by you <a href="javascript://" class="button-link" onclick="delete_file('+d.image_d+','+i+',jQuery(this));"><img src="https://s3-us-west-1.amazonaws.com/knzbeoknwf/public/images/discard.png"/></a></label><img src="<?php echo JUri::base();?>components/com_survey/document/'+f+'"></div>');
									}
								})
							}
							/*if(jQuery("#delete_file_"+d.image_d).length>0){
								jQuery("#delete_file_"+d.image_d).html('<label>Supporting Document Uploaded by you</label><img src="<?php echo JUri::base();?>components/com_survey/document/'+d.file_name+'">');
							} else {
								jQuery(fileElement).html('<a href="javascript://" class="button-link" onclick="delete_file('+d.image_d+');"><img src="https://s3-us-west-1.amazonaws.com/knzbeoknwf/public/images/discard.png"/></a>');
								_sp = jQuery(fileElement).parent();
								console.log(_sp.html());
								_sp.after('<div clss="span12 noMargin" style="margin-bottom:10px !important;" id="delete_file_'+d.image_d+'"><label>Supporting Document Uploaded by you</label><img src="<?php echo JUri::base();?>components/com_survey/document/'+d.file_name+'"></div>');
							}*/
						} else {
							alert("Please try after sometime.");
						}
					},
					error:function(){
						
					}
					
				})
			}
		});
		/*setInterval(function(){autoSave()},2000);*/
	});
	__DataArray = {};
	_processStart= 0;
	total=0;
	_implementedAlready = false;
	_queue = 0;
	function autoSave(startWith){
		if(typeof startWith=="undefined"){
			startWith = 0;
		}
		console.log("Lets Start from: "+startWith);
		if(__cFS===true && _implementedAlready==false){
			_saveFlag = 0;
			if(_surveyReportType==2 && jQuery.trim(jQuery("#target").val())==""){
				_saveFlag = 1;
			} else if(_surveyReportType==2 && jQuery.trim(jQuery("#target_product").val())==""){
				_saveFlag = 1;
			}
			if(_saveFlag==0){
				runSaveUpdate(0);				
			} else {
				if(_saveFlag==1 && (jQuery.trim(jQuery("#target").val())=="" || jQuery.trim(jQuery("#target_product").val())=="")){
					_message = '<a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>To ensure automatic savings of your work, please fill in both the Target Company and the Target Product.';
					jQuery('#alert_show').addClass('show').css({position:'relative',top:(jQuery(window).scrollTop() + 50)+'px'}).html(_message);
					__cFS = false;_processStart=0;
				}
			}
		} else {
			_queue = 1;
		}		
	} 
	
	function updateSingleElement(){
		__EditorArea = tinyMCE.get(_instID).getContent();					
		_getCheckBox = document.getElementsByClassName(_instID+'_check');
		if(typeof __EditorArea!="undefined"){
			console.log('Start processing..');
			_processStart = 1;
			_saveStatus = 0;				
			_saveStatusString = "No"; 
			if(jQuery(_getCheckBox).is(':checked')){
				_saveStatus = 1;
				_saveStatusString = "Yes";
			}
			_target = "";	
			if(_surveyReportType==2){
				_target = jQuery("#target").val();	
			}	
			
			var aFormData = new FormData();
			aFormData.append("text_editor", __EditorArea);
			aFormData.append("option", "com_survey");
			aFormData.append("task", "answer.saveAjax");
			aFormData.append("expert_id", jQuery("#expert_id").val());
			aFormData.append("ans_status", jQuery("#ans_status").val());
			aFormData.append("survey_id", jQuery("#survey_id").val());
			aFormData.append("report_option_type", jQuery("#report_option_type").val());
			aFormData.append("save_status", _saveStatus);
			aFormData.append("data_to", _instID);
			aFormData.append("target", _target);
			aFormData.append("target_product",jQuery("#target_product").val());
			aFormData.append("amount", jQuery("#amount").val());
			aFormData.append("format", '');		
			_string["amount"] = jQuery("#amount").val();
			_string["report_option_type"] = jQuery("#report_option_type").val();
			_string["target_product"] = jQuery("#target_product").val();
			_string["target"] = _target;
			_string["explanation"] = __EditorArea;
			_string["supporting_document"] = '';
			_string["published"] = _saveStatusString;
			jQuery.ajax({
				type:'POST',
				url:'<?php echo JUri::base()?>',
				contentType: false,
				processData: false,
				data: aFormData,
				dataType: "json",
				cache:false,
				success:function(){
					__cFS = true;
				},
				error:function(){
					__cFS = true;					
				}				
			}).done(function(){
															
			});
		}
	}
	jQuery(document).ready(function(){
		window.onbeforeunload =function(e){
			if(_lastEntry!=_instID){
				recordEntryForUser(_instID);
			}
		}
		setTimeout(function(){jQuery('.mceResize').parent().find('div').remove();jQuery('.mceResize').trigger('click');},2000);
	});
	function priceUpdation(o){
		if(o.val()==2){
			jQuery("#amount").val(o.attr('data-price'));
		} else {
			jQuery("#amount").val('');
		}
	}
	function runSaveUpdate(startWith){
		_textArea = jQuery('textarea.mce_editable').length;
		total = _textArea;
		if(startWith<total){
			_ID = jQuery('textarea.mce_editable')[startWith].id.toString();				
			__EditorArea = tinyMCE.get(_ID).getContent();					
			_getCheckBox = jQuery('.elementsAns').eq(startWith).find('input[type="checkbox"]');
			if(typeof __EditorArea!="undefined"){
				_processStart = 1;
				_saveStatus = 0;				
				if(_getCheckBox.is(':checked')){
					_saveStatus = 1;
				}
				_target = "";	
				if(_surveyReportType==2){
					_target = jQuery("#target").val();	
				}	
				fileElement = document.getElementsByClassName(_ID);
				_fileName = jQuery(fileElement).attr('name');
				_fileValue = jQuery('input[name="'+_fileName+'"]')[0].files[0];
				var aFormData = new FormData();
				aFormData.append("text_editor", __EditorArea);
				aFormData.append("option", "com_survey");
				aFormData.append("task", "answer.saveAjax");
				aFormData.append("expert_id", jQuery("#expert_id").val());
				aFormData.append("survey_id", jQuery("#survey_id").val());
				aFormData.append("report_option_type", jQuery("#report_option_type").val());
				aFormData.append("save_status", _saveStatus);
				aFormData.append("data_to", _ID);
				aFormData.append("target", _target);
				aFormData.append("target_product",jQuery("#target_product").val());
				aFormData.append("amount", jQuery("#amount").val());
				if(typeof _fileValue!="undefined"){
					aFormData.append(_fileName, _fileValue);
				}
				aFormData.append("format", '');		
				_string["amount"] = jQuery("#amount").val();
				_string["report_option_type"] = jQuery("#report_option_type").val();
				_string["target_product"] = jQuery("#target_product").val();
				_string["target"] = _target;
				_string["explanation"] = __EditorArea;
				_string["supporting_document"] = '';
				jQuery.ajax({
					type:'POST',
					url:'<?php echo JUri::base()?>',
					contentType: false,
					processData: false,
					data: aFormData,
					dataType: "json",
					cache:false,
					success:function(){
						__cFS = true;
						runSaveUpdate(startWith+1);
						
					},
					error:function(){
						__cFS = true;
						runSaveUpdate(startWith+1);
					}
					
				}).done(function(){															
				});
			} else {
				_processStart = 0;
			}
		} else {
			__cFS = false;_processStart=0;
			if(_queue==1){
				__cFS = true;_processStart=0;
				runSaveUpdate(0);
			}
		}
	}
	
	pType=<?php echo $this->item[0]->payment_type?>;
	_startTime = moment.tz(new Date(), 'America/Los_Angeles').format('YYYY-MM-DD HH:mm:ss'),_lastEntry="";
	_checkEntry = false;
	_string = {};
	function recordEntryForUser(ind){
		_lastEntry = _instID;
		console.log("INSTD:"+_instID);
		if(typeof ind!="undefined"){
			_lastEntry = ind;
		}
		_entryFlag=0;
		if(_surveyReportType==2 && jQuery.trim(jQuery("#target").val())==""){
			_entryFlag = 1;
		} else if(_surveyReportType==2 && jQuery.trim(jQuery("#target_product").val())==""){
			_entryFlag = 1;
		}
		console.log(_startTime);
		if(_entryFlag==0 && _lastEntry!="" && _startTime!=""){
			console.log("timing..");
			_historyString = "";
			for(var key in _string){
				var stringText = _string[key];
				var text = stringText.toString() .replace(/\n/g, '<br/>');
				_historyString += key+': '+text+'<br/>';
			}
			_historyString = _historyString.substring(0,_historyString.length-5);
			_string = {};
			_newDate = new Date();
			_endTime = moment.tz(_newDate, "America/Los_Angeles").format('YYYY-MM-DD HH:mm:ss');
			jQuery.ajax({
				type:'POST',
				data:{s:_startTime,e:_endTime,inst:_lastEntry,target:jQuery.trim(jQuery("#target").val()),target_product:jQuery.trim(jQuery("#target_product").val()),survey_id:jQuery("#survey_id").val(),expert_id:jQuery("#expert_id").val(),option:'com_survey',task:'customer.user_log_activity',str:_historyString},
				url:'<?php echo JUri::base()?>',
				success:function(){			
					_newDate = new Date();
					_startTime = moment.tz(_newDate, 'America/Los_Angeles').format('YYYY-MM-DD HH:mm:ss');__cFSS = false;
				}
			});
		}		
	}
	
	
	
	function tabingIndex(object,index){
		if(index==0){
			jQuery("#EditUsers dt").eq(5).addClass('open').removeClass('closed');
			jQuery("#EditUsers dt").eq(6).addClass('closed').removeClass('open');
		} else {
			jQuery("#EditUsers dt").eq(6).addClass('open').removeClass('closed');
			jQuery("#EditUsers dt").eq(5).addClass('closed').removeClass('open');
		}
		jQuery('.current>dd').css('display','none');
		jQuery('.current>dd').eq(index).css('display','block');
	}
	function openExampleReport(){
		showSlidebar('slidebarViewReport');
		jQuery('#frame_report_view').attr('src','<?php echo JUri::base()?>index.php?option=com_survey&task=customer.viewReport&report_type=2&target_product=LEDALITE&target=Philips&param=VVM3NTU3NTI0QDI0QDY=');
	}

				jQuery(window).load(function(){
					/*jQuery(".mceToolbarRow2,.mceToolbarRow3").css('display','none');
					jQuery(".mceStatusbar").find('div').remove();
					jQuery(".mceStatusbar").find('a').before('<div><b>Paste at the bottom of your answer links to your sources.</b></div>');*/
					jQuery(".mceLayout").css('height','177px');
					/**/
					/*jQuery(".mceToolbarRow1").each(function(){
						_parent = jQuery(this);
						for(d=4;d<=18;d++){
							_parent.find('td').eq(d).css('display','none');
						}
					});*/
					_offset = jQuery("#ans-form").offset();
					jQuery('.ans-form-buttons').css({right:_offset.left+'px',display:'block'});
				});
				function delete_file(d,e,o){
					jQuery.ajax({
						type:'POST',
						url:'<?php echo JUri::base()?>index.php?option=com_survey&task=answer.deleteFile',
						data:{s:d,i:e},
						cache:false,
						success:function(res){
							if(res>0){
								o.parent().parent().remove();
							}
						}
					});
				}
				
			</script>
			<?php
				}
			?>
			
		</div>
		<div style='display:none;'>
			<div class="row-fluid">
		<div class="span12">
			<p>The purpose of this questionnaire is to assist your clients in identifying existing systems that may implement the invention protected by the patent claim stated bellow.</p>
			<ul class='nav'>
				<li>1. Please read the patent (you may use the link bellow to Google Patents), and after understanding the nature, depth and scope of the claim, elaborately explain the way each of the elements stated bellow is implemented in the Target that you suspect that the claim reads on. Do not compromise! Where you cannot find evidence that a certain element is being implemented - leave the question unanswered. It is much better than guessing and risking your credibility as an expert. </li>
				<li>2. For each element that you address, provide explanations to the basis upon which you conclude that the specific claim element is implemented in the Target, and upload documentations that support your explanations and conclusion.  Next to each claim element, there is a checkbox. Check it only if you believe that the evidence that you provided indeed shows that the element is used in the Target.<br/>
				Please provide your asking price for your ClaimChart report, in U.S. Dollars. Use only digits, without the US Dollar sign $.</li>
				<li>In the Target textbox, enter the formal name of the target product/system/service that you cover, preceded by the name of its maker.</li>
				<li>Please remember to Save & Close before leaving this editor.</li>
				<li>When done, please click on the "View Complete ClaimChart", to make sure that the end result is satisfactory.  If you agree to everything that is written in your Complete ClaimChart report, and ready to submit it to be offered for sale at the Store, Click "Submit ClaimChart". <br/>Good luck!</li>
			</ul>
		</div>
		</div>
		</div>

	</div>
</div>
</div>
<!-- Timeline  slidebar -->
<div id="slidebarTimeLineActivity" class="slidebar slidebar-right">
	<div class="slidebar-content">
		<iframe class="slidebar-content-iframe" src="<?php echo JUri::base();?>index.php?option=com_survey&task=customer.myactivity&tmpl=component&p=<?php echo $getSession->id;?>" width="100%" height="300" frameborder="0" allowfullscreen=""></iframe>
	</div>
	<a href="" class="slidebar-close" onclick="return hideSlidebar('slidebarTimeLineActivity')"></a>
</div>
<!-- /Timeline Patents slidebar -->

<!-- Google Patents slidebar -->
<div id="slidebarGooglePatents" class="slidebar slidebar-right">
	<div class="slidebar-content">
		<iframe class="slidebar-content-iframe" src="about:blank" width="100%" height="300" frameborder="0" allowfullscreen=""></iframe>
	</div>
	<a href="" class="slidebar-close" onclick="return hideSlidebar('slidebarGooglePatents')"></a>
</div>
<!-- /Google Patents slidebar -->


<!-- View Report slidebar -->
<div id="slidebarViewReport" class="slidebar slidebar-right">
	<div class="slidebar-content">
		<?php if(JRequest::getVar('param')!=""):?>
		<iframe class="slidebar-content-iframe" id="frame_report_view"  src="about:blank" width="100%" height="600" frameborder="0" allowfullscreen=""></iframe>
		<?php endif;?>
	</div>
	<a href="javascript://" class="slidebar-close" id="slidebarClose" onclick="jQuery('#frame_report_view').attr('src','about:blank');return hideSlidebar('slidebarViewReport')"></a>
</div>
<?php 
	else:
?>
<div class="span12">
	<p class="alert alert-warning">
		No questionnaire created.
	</p>
</div>
<?php endif;?>
<?php 
/*die;*/
?>
<!-- /View Report slidebar -->