<style>
	.content a {
		color: #15C;
	}
	.content a:hover {
		text-decoration: underline;
	}

	.sortingTable thead th {
		text-align: center;
	}
	.sortingTable a {
		color: #15C;
		display: inline-block;
		
		overflow: hidden;
		text-overflow: ellipsis;
	}
	.sortingTable a.btn {
		color: #ffffff;
	}
	.sortingTable-column {
		max-height: 400px;
		overflow-x: hidden;
		overflow-y: auto;
	}
	.sortingTable-column a {
		-ms-word-break: break-all;
    	word-break: break-all;
     	word-break: break-word;
		-webkit-hyphens: auto;
   		-moz-hyphens: auto;
        hyphens: auto;
	}


	.article-info-form {
  		float: left;
  		margin-bottom: -4px;
  		margin-left: 20px;
  		margin-top: -5px;
	}
	.article-info-form input {
  		margin-bottom: 0;
		text-align: center;
  		width: 45px;
	}
	.article-info-form button {

	}
	@media screen and (max-width: 979px) {
		.article-info-form {
			clear: both;
  			float: none;
			margin-left: 20px;
  			margin-top: 0;
  			padding-top: 5px;
		}
	}
	.sortingTable a:hover{
		text-decoration:underline;
	}
	.m_title{margin-bottom:10px !important;}
	a:focus{text-decoration:none;outline:0}
	body{overflow:scroll}
		tr.odd td, tr.even td{background-color:#F1F3F4}
	tr.odd:hover td, tr.even:hover td{background-color:#E8EAED}
	tr.white:hover td, tr.white td{background-color:#ffffff; border:1px solid #efefef}
	tr.current-active td, tr.current-active td a.current-active, tr.current-active td a{color:#cd2122 !important;}
	tr.current-active td a.btn-flat{color:#fff !important;}
	.gray-area{border:1px solid #E8EAED;padding:8px 5px; }
	.gray-area .m_title{color:#cd2122;}
	.supporting_docs td{border:0px !important;}
</style>

<?php
// No direct access to this file
defined('_JEXEC') or die('Restricted access');
$getSession = JFactory::getUser();
$sessionEXpertID = 0;
$imageUrl="";
$name="";
$staticContent="";
$userData = array();
if ($getSession->id > 0) {
	$getExpertData = SurveyModelCustomer::expertUserData($getSession->id);
    $sessionEXpertID = $getExpertData->id;
	if(!empty($getExpertData->profile_desc)){
		$staticContent.=stripslashes($getExpertData->profile_desc);
		preg_match_all('~<img.*?src=["\']+(.*?)["\']+~', $getExpertData->profile_desc, $urls);
		$imageUrl = $urls[1];
	}
	if((int)$getExpertData->expert_type==2){
		$name = $getExpertData->company_name;
	} else {
		$name = $getExpertData->name;
	}
	$userData = SurveyModelCustomer::getUserData($getSession->id);
}
if($sessionEXpertID==0){
	$app= JFactory::getApplication();
	$app->redirect('index.php/profile','You are not authorise to view this page.','error');
}
$displayID = $this->profileID;
$ID = $this->id;
?>
<!-- Expert Feedback -->
<dl class="article-info clearfix">
	<?php if($sessionEXpertID>0):?>
	<dd class="createdby"><a href="<?php echo JRoute::_('index.php?option=com_survey&task=customer.expertOpportunites&display='.$displayID)?>" >Projects</a></dd>
	<?php endif;?>
	<dd class="createdby"><a style='color:#cd2122' href="<?php echo JRoute::_('index.php?option=com_survey&task=customer.expertProcess&display='.$displayID)?>">In Process</a></dd>
	<dd class="createdby"><a href="<?php echo JRoute::_('index.php?option=com_survey&task=customer.expertReport&display='.$displayID)?>">My Reports</a></dd>	
	<dd class="published"><a href="<?php echo JRoute::_('index.php?option=com_survey&task=customer.expertFeedback&display='.$displayID)?>">Feedback</a></dd>
	<?php if($sessionEXpertID>0):?>
	<dd class="createdby"><a href="<?php echo JRoute::_('index.php?option=com_survey&task=customer.expertArea&display='.$displayID)?>" >My Expertise</a></dd>
	<?php endif;?>
	<!--<dd class="published"><a href="<?php echo JRoute::_('index.php?option=com_survey&task=customer.blog&display='.$displayID)?>">My Blog</a></dd>-->
	
	<dd class="published"><a href="<?php echo JRoute::_('index.php?option=com_survey&task=customer.termsOfUse&display='.$displayID)?>">Terms of Use</a></dd>
	<dd class="published"><a href="<?php echo JRoute::_('index.php?option=com_survey&task=customer.privacyPolicy&display='.$displayID)?>">Privacy Policy</a></dd>
	<dd class="published"><a href="<?php echo JRoute::_('index.php?option=com_survey&task=customer.smeAgreement&display='.$displayID)?>">SME Agreement</a></dd>
	<?php if(count($userData)>0 && $userData->nda==1){?>
			<dd class="published"><a href="<?php echo JRoute::_('index.php?option=com_survey&task=customer.smeNda&display='.$displayID)?>">NDA</a></dd>
			<?php } ?>
	<?php if($sessionEXpertID>0):?>
	<dd class="createdby" ><a href="<?php echo JRoute::_('index.php?option=com_users&task=user.logout&'.JUtility::getToken().'=1');?>" >Logout</a></dd>
	<?php endif;?>
	<dd style='float:right'>
		<a  style='color:#1a73e8;' href="<?php echo JRoute::_('index.php?option=com_survey&task=customer.expertProfile&display='.$displayID)?>"><?php if(is_array($imageUrl) && !empty($imageUrl[0])):?> <img src='<?php echo $imageUrl[0]?>' width="30px"/><?php else:?><img src='<?php echo JURI::root();?>templates/kallyas/images/user.png' width="30px"/> <?php endif;?>&nbsp;&nbsp;<?php echo $name;?></a>
	</dd>
	
</dl>
<?php
$getInProcessData = SurveyModelCustomer::expertInProcessData($ID);
	if (count($getInProcessData) > 0) {
?>
<script>
jQuery(document).ready(function() {
                jQuery('title').html('EXPERT PROCESS');
            });
</script>
<script>
getInProcessArray = []
mainAssocArray = [];
mainAssocProject = [];
mainAssocReport = [];
</script>

<div class="span12 clearfix" style="margin-left: 0px; /*overflow-x: auto; overflow-y: hidden;*/">
	<table width="100%" id="opportunites-data" class="table sortingTable" style="">
		<thead>
			<tr>
				<th align="left"  style="padding:8px 5px;border-bottom: 1px solid #DDDDDD;color:#cd2122 !important">Claim</th>
				<th align="left"style="padding:8px 5px;border-bottom: 1px solid #DDDDDD;color:#cd2122 !important">View</th>
				<th align="left"style="padding:8px 5px;border-bottom: 1px solid #DDDDDD;color:#cd2122 !important">Deadline</th>
				<th align="right" style="padding:8px 5px;border-bottom: 1px solid #DDDDDD;color:#cd2122 !important;text-align:right;">My&nbsp;Price</th>
				<th align="left" style="padding:8px 5px;border-bottom: 1px solid #DDDDDD;color:#cd2122 !important">My&nbsp;Target</th>			
				<th align="left" style="padding:8px 5px;border-bottom: 1px solid #DDDDDD;color:#cd2122 !important">Targets</th>
				<th align="left" style="padding:8px 5px;border-bottom: 1px solid #DDDDDD;color:#cd2122 !important;">Reports in Process</th>
				<th align="left"style="padding:8px 5px;border-bottom: 1px solid #DDDDDD;color:#cd2122 !important;">Delete</th>
				</tr>
		</thead>
		<tbody>
			<?php
				for ($i = 0; $i < count($getInProcessData); $i++) {			
				$getElements = SurveyModelCustomer::getQuestionList($getInProcessData[$i]->surveyID);
				$myprice = SurveyModelCustomer::getMyClaimPriceInProcess($getInProcessData[$i]->surveyID,$getInProcessData[$i]->answerTargetProduct,$getInProcessData[$i]->answerTarget,$sessionEXpertID);
			?>
			<script>
				getInProcessArray['<?php echo $getInProcessData[$i]->surveyID; ?>_inpp'] = <?php echo json_encode($getElements); ?>;
			</script>
			<tr class="odd">				
				<td align="left" style="padding:8px;border-top:0px; "><a class="" href="javascript://" onclick="getCLAIMElements(jQuery(this), '<?php echo $getInProcessData[$i]->surveyID ?>');"><?php echo $getInProcessData[$i]->combineName; ?></a></td>
				<td align="left" style="padding:8px 3px;  border-top:0px; text-align: center;">
					<a href="" class="" onclick="return showSlidebar('slidebarView<?php echo $i?>')">Report</a>
					<div id="slidebarView<?php echo $i?>" class="slidebar slidebar-right">
						<div class="slidebar-content">
							<iframe class="slidebar-content-iframe" src="<?php echo JUri::base()?>index.php?option=com_survey&task=customer.viewReport&report_type=<?php echo $getInProcessData[$i]->report_type;?>&target_product=<?php echo $getInProcessData[$i]->answerTargetProduct;?>&target=<?php echo $getInProcessData[$i]->answerTarget; ?>&param=<?php echo base64_encode($getInProcessData[$i]->surveyName . '@' . $getInProcessData[$i]->surveyID . '@' . $sessionEXpertID); ?>" width="100%" height="600" frameborder="0" allowfullscreen=""></iframe>
						</div>
						<a href="" class="slidebar-close" onclick="return hideSlidebar('slidebarView<?php echo $i?>')"></a>
					</div>
				</td>
				<td align="left" style="padding:8px 3px;  border-top:0px; text-align: center;" onclick="getCLAIMElements(jQuery(this).parent().find('td').eq(1).find('a'), '<?php echo $getInProcessData[$i]->surveyID ?>');"><?php echo date('m/d/y', strtotime($getInProcessData[$i]->deadline)); ?></td>
				<td align="right" onclick="getCLAIMElements(jQuery(this).parent().find('td').eq(1).find('a'), '<?php echo $getInProcessData[$i]->surveyID ?>');" style="padding:8px 3px;  border-top:0px; text-align: right;">
					<?php 
						if(count($myprice)>0){
							setlocale(LC_MONETARY, 'en_US');
							echo  '$'.number_format($myprice->amount);
						}
					?>
				</td>
				<td align="left" onclick="getCLAIMElements(jQuery(this).parent().find('td').eq(1).find('a'), '<?php echo $getInProcessData[$i]->surveyID ?>');" style="padding:8px 3px;  border-top:0px; text-align: center;"><?php echo $getInProcessData[$i]->answerTarget; ?><?php if($getInProcessData[$i]->answerTargetProduct!=""){echo ", ".$getInProcessData[$i]->answerTargetProduct;}?></td>
				<td align="left" onclick="getCLAIMElements(jQuery(this).parent().find('td').eq(1).find('a'), '<?php echo $getInProcessData[$i]->surveyID ?>');" style="padding:8px 3px;  border-top:0px; text-align: left;">
				<div class="sortingTable-column"><?php $target =  preg_replace(
              "~[[:alpha:]]+://[^<>[:space:]]+[[:alnum:]/]~",
              "<a href=\"\\0\" target='_blank'>\\0</a>", 
              $getInProcessData[$i]->target); echo nl2br($target);?></div>
				
				</td>
				<td align="center"  style="padding:8px 5px 1px 0; border-top:0px; text-align: center;">
						<?php 
							$name="";
							if($getInProcessData[$i]->report_type==2){
								$name="EOU";
							} else if($getInProcessData[$i]->report_type==1){
								$name="Invalidation";
							}
						?>
						<a class="btn btn-medium btn-flat" href="<?php echo JUri::base(); ?>index.php?option=com_survey&view=answer&target=<?php echo $getInProcessData[$i]->answerTarget; ?>&target_product=<?php echo $getInProcessData[$i]->answerTargetProduct; ?>&param=<?php echo base64_encode($getInProcessData[$i]->surveyName . '@' . $getInProcessData[$i]->surveyID . '@' . $sessionEXpertID); ?>">Continue <?php echo $name;?></a>	
				</td>
				<td align="center"  style='text-align: center;'><a style='' onclick="deleteInProcessClaim(jQuery(this));" href='javascript://' data-del="<?php echo $getInProcessData[$i]->answerTarget; ?>@<?php echo $getInProcessData[$i]->answerTargetProduct; ?>@<?php echo $ID; ?>@<?php echo $getInProcessData[$i]->surveyID; ?>"><img src="<?php echo JUri::base(); ?>media/media/images/trash-16.png"/></a></td>
			</tr>
			<tr class="even" style="display: none;">
				<td colspan="8" style="padding:0px;">
					<div class="gray-area">
						<div class="inner-container login-panel" style="padding-bottom:0;padding-top:10px;">		
							<h3 class="m_title" style=""><strong>Project Instructions:</strong></h3>
							<div class="content" style="background-color:#fff;padding:5px;">
								<?php 
									if(!empty($getInProcessData[$i]->project_comment)):
									echo nl2br(preg_replace("~[[:alpha:]]+://[^<>[:space:]]+[[:alnum:]/]~","<a href=\"\\0\">\\0</a>",               $getInProcessData[$i]->project_comment));
									else:
									/*echo "No special instructions for this project.";*/
									endif;
									?>
							</div>
						</div>
						<div class="inner-container login-panel" style="padding-bottom:0;">		
							<h3 class="m_title" style=""><strong>Claim Instructions:</strong></h3>
							<div class="content" style="background-color:#fff;padding:8px;">
								<?php 
									if(!empty($getInProcessData[$i]->comment)):
										echo nl2br(preg_replace("~[[:alpha:]]+://[^<>[:space:]]+[[:alnum:]/]~","<a href=\"\\0\">\\0</a>",               $getInProcessData[$i]->comment)); 
									else:
										/*echo "No special instructions for this project.";*/
									endif;
									?>
							</div>
						</div>
						<div class="inner-container login-panel" style="padding-bottom:1px;">		
							<h3 class="m_title" style=""><strong>Supporting Documents:</strong></h3>
							<div class="content" style='background-color:#fff;'>
								<table class="table supporting_docs">
									<tbody>
										<?php 
											if(!empty($getNotificationData[$i]->supportingDocuments)){
										?>
											<tr>
												<td><?php echo preg_replace("~[[:alpha:]]+://[^<>[:space:]]+[[:alnum:]/]~","<a href=\"\\0\" target='_blank' style='position:relative;top:5px;'>\\0</a>",               $getNotificationData[$i]->supportingDocuments);?></td>
											</tr>
											<?php				
											}
										 ?>
									</tbody>
								</table>
							</div>
						</div>
						<div class="inner-container login-panel" style="padding-bottom:1px;">
							<?php 
								$dataIllustration = SurveyModelCustomer::getIllustrationData($getInProcessData[$i]->combineName);
								if(count($dataIllustration)>0 && $dataIllustration->file!=""){
									$fileUrl = $dataIllustration->file;
									$fileUrl = str_replace('edit?usp=drivesdk','preview',$fileUrl);
									$fileUrl = str_replace('view?usp=drivesdk','preview',$fileUrl);
						?>
									<iframe id="frame_illustration" src="about:blank" data-src="<?php echo $fileUrl?>" style="width:100%;height:718px;"></iframe>
									<div class="illustration-iframe-overlay" style="position: relative; left: 5px;"><div style="height: 29px;left: 297px;position:absolute;top: -34px;width: 818px;background:#323232;"></div></div>
						<?php
								}
						?>
						
						</div>
					</div>
				</td>
			</tr>
			<?php
				}
			?>
			
		</tbody>
	</table>
</div>

<?php } else {?>
		
	<div style="margin-top: 43px;"><p class="alert alert-danger">No record found!</p></div>
			
<?php } ?>

<script>
	function getCLAIMElements(object, ID) {
        //jQuery("#opportunites-data>tbody>tr>td>a").removeClass('current-active');
		if(object.hasClass('current-active')){
				object.parents('tr').removeClass('current-active')
					object.parents('tr').next().removeClass('white');
					object.removeClass('current-active');
			} else {
				jQuery("#opportunites-data>tbody>tr").removeClass('white').removeClass('current-active');
					jQuery("#opportunites-data>tbody>tr>td>a").removeClass('current-active');
					object.addClass('current-active');	
					object.parents('tr').addClass('current-active').next().addClass('white');
			}
		_tab = object.parent().parent().next("tr");
				_oldD = _tab.css('display');
				object.parent().parent().parent().find("tr.even").css("display","none");
				_tab.css("display",_oldD);
				_tab.find("iframe#frame_illustration").attr('src',_tab.find("iframe#frame_illustration").attr('data-src'));
				_tab.toggle();
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

	function deleteInProcessClaim(object) {
		res = confirm('Are you sure you want to delete?');
		if (res === true) {
			if (object.attr("data-del")=="" || object.attr("data-del")==undefined) {
				alert('Please select claim.');
			} else {
				_string_send = object.attr("data-del");
				jQuery.ajax({
					type: 'POST',
					url: '<?php echo JUri::base() ?>',
					data: {option: 'com_survey', task: 'customer.deleteInProcessClaim', string_send: _string_send, format: ''},
					cache: false,
					success: function(res) {
						if (parseInt(res) === 1) {
							_mainTr = object.parents('tr');
							_mainTr.next().remove();
							_mainTr.remove();
						} else if (parseInt(res) === 0) {
							alert('Please try again later.');
						}
					}
				});
			}
		}
	}
</script>