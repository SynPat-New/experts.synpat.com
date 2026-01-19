<?php 
/*('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);*/
?>
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
		max-width: 0;
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
	tr.odd td, tr.even td{background-color:#F1F3F4}
	tr.odd:hover td, tr.even:hover td{background-color:#E8EAED}
	tr.white:hover td, tr.white td{background-color:#ffffff; border:1px solid #efefef}
	tr.current-active td, tr.current-active td a.current-active{color:#cd2122 !important;}
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
$agreement = array();
$getPriortArtReportIDs = array();
if ($getSession->id > 0) {
	$getExpertData = SurveyModelCustomer::expertUserData($getSession->id);
	$userData = SurveyModelCustomer::getUserData($getSession->id);
	$agreement = SurveyModelCustomer::getAgreementData(4);
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
	$getPriortArtReportList = SurveyModelCustomer::getPriorArtReport($sessionEXpertID);
	if(count($getPriortArtReportList)>0){
		foreach($getPriortArtReportList as $p){
			$getPriortArtReportIDs[] = $p->id;
		}
	}
}
if($sessionEXpertID==0){
	$app= JFactory::getApplication();
	$app->redirect('index.php','You are not authorise to view this page.','error');
}
$profileID = $this->id;
$displayID = $this->profileID;

/* print_r($getSession); */

?>
<!-- Expert Feedback -->
<dl class="article-info clearfix">
			<?php if($sessionEXpertID>0):?>
			<dd class="createdby"><a style='color:#cd2122' href="<?php echo JRoute::_('index.php?option=com_survey&task=customer.expertOpportunites&display='.$displayID)?>" >Projects</a></dd>
			
			<dd class="createdby"><a href="<?php echo JRoute::_('index.php?option=com_survey&task=customer.expertProcess&display='.$displayID)?>">In Process</a></dd>
			<?php endif;?>
			<dd class="createdby"><a href="<?php echo JRoute::_('index.php?option=com_survey&task=customer.expertReport&display='.$displayID)?>">My Reports</a></dd>	
			<dd class="published"><a href="<?php echo JRoute::_('index.php?option=com_survey&task=customer.expertFeedback&display='.$displayID)?>">Feedback</a></dd>			
			<?php if($sessionEXpertID>0):?>
			<dd class="createdby"><a href="<?php echo JRoute::_('index.php?option=com_survey&task=customer.expertArea&display='.$displayID)?>" >My Expertise</a></dd>
			
			<!--<dd class="published"><a href="<?php echo JRoute::_('index.php?option=com_survey&task=customer.blog&display='.$displayID)?>">My Blog</a></dd>-->
			
			<dd class="published"><a href="<?php echo JRoute::_('index.php?option=com_survey&task=customer.termsOfUse&display='.$displayID)?>">Terms of Use</a></dd>
			<dd class="published"><a href="<?php echo JRoute::_('index.php?option=com_survey&task=customer.privacyPolicy&display='.$displayID)?>">Privacy Policy</a></dd>
			<dd class="published"><a href="<?php echo JRoute::_('index.php?option=com_survey&task=customer.smeAgreement&display='.$displayID)?>">SME Agreement</a></dd>
			<?php endif;?>
			<?php if(count($userData)>0 && $userData->nda==1){?>
			<dd class="published"><a href="<?php echo JRoute::_('index.php?option=com_survey&task=customer.smeNda&display='.$displayID)?>">NDA</a></dd>
			<?php } ?>
			<?php if($sessionEXpertID>0):?>
			<dd class="createdby" ><a href="<?php echo JRoute::_('index.php?option=com_users&task=user.logout&'.JUtility::getToken().'=1');?>" >Logout</a></dd>
			<?php endif;?>
			<dd style='float:right'>
				<a style='color:#1a73e8;' href="<?php echo JRoute::_('index.php?option=com_survey&task=customer.expertProfile&display='.$displayID)?>"><?php if(is_array($imageUrl) && !empty($imageUrl[0])):?> <img src='<?php echo $imageUrl[0]?>' width="30px"/><?php else:?><img src='<?php echo JURI::root();?>templates/kallyas/images/user.png' width="30px"/> <?php endif;?>&nbsp;&nbsp;<?php echo $name;?></a>
			</dd>
			
		</dl>
<?php 
	$getNotificationData = array();
	if($userData->nda==1){
		$getNotificationData = SurveyModelCustomer::expertNotification((int)$getSession->id);
	}
?>
<script>
	function retrievalProject(){
		if(jQuery("#retrieve_code").val()!="" && jQuery("#retrieve_code").val().length==5 && parseInt(jQuery("#retrieve_code").val())>0){
			jQuery('#btnRetrieval').css('display','none');
			jQuery.ajax({
				type:'POST',
				url:'<?php echo JUri::root()?>index.php?option=com_survey&task=customer.retrieve_project',
				data:{c:jQuery("#retrieve_code").val(),s:'<?php echo $getSession->id?>'},
				cache:false,
				success:function(data){
					jQuery('#btnRetrieval').css('display','inline-block');
					if(data>0){
						window.location = window.location.href;
					} else {
						alert("Invalid code.");					
					}
				}
			}); 
		}
	}

	function sortingTableLinkWidths() {
		jQuery('.sortingTable a').css('max-width', 0);
		jQuery('.sortingTable a').each(function(index, obj) {
			var $obj = jQuery(obj),
				$parent = $obj.parent();

			if($parent.hasClass('sortingTable-column') && !$obj.hasClass('btn')) {
				$obj.css('max-width', $parent.width()-20 + 'px');
			}
			else {
				$obj.css('max-width', '100%');
			}
		});
	}

	jQuery(document).ready(function() {
        jQuery('title').html('EXPERT OPPORTUNITES');

        sortingTableLinkWidths();
        jQuery(window).on('resize', function() {
        	sortingTableLinkWidths();
        });
    });

if(!String.linkify) {
    String.prototype.linkify = function() {

        // http://, https://, ftp://
        var urlPattern = /\b(?:https?|ftp):\/\/[a-z0-9-+&@#\/%?=~_|!:,.;]*[a-z0-9-+&@#\/%=~_|]/gim;

        // www. sans http:// or https://
        var pseudoUrlPattern = /(^|[^\/])(www\.[\S]+(\b|$))/gim;

        // Email addresses
        var emailAddressPattern = /[\w.]+@[a-zA-Z_-]+?(?:\.[a-zA-Z]{2,6})+/gim;

        _aa =  this
            .replace(urlPattern, '<a href="$&" target="_blank">$&</a>')
            .replace(pseudoUrlPattern, '$1<a href="http://$2" target="_blank">$2</a>')
            .replace(emailAddressPattern, '<a href="mailto:$&">$&</a>');
		return _aa.replace("/http","http");
    };
}

function deleteOpportunity(o,d){
	jQuery.ajax({
		type:'POST',
		url:'<?php echo JUri::base()?>index.php',
		data:{option:'com_survey',task:'customer.deleteNotification',d:d,format:''},
		success:function(b){
			if(b>0){
				o.parents('tr').remove();
			} else {
				alert("Please try after sometime.");
			}
		}
	})
}
</script>
 <script>
mainAssocArray = [];
mainAssocProject = [];
mainAssocReport = [];
</script>
<?php
if (count($getNotificationData) > 0) {
	?>
	<!-- <div class="span12 noMargin" style="text-align:left">
		<div class="row-fluid">
			<div class="span12 tMx" id="project_comment">
			</div>
		</div>
	</div> -->
	<div class="span12 clearfix" style="margin-left: 0px; overflow-x: auto; overflow-y: hidden;">
		<table width="100%" id="opportunites-data" class="table sortingTable">
			<thead>
				<tr>
					<th  style='padding:8px 5px;border-bottom: 1px solid #DDDDDD;color:#cd2122 !important;text-align:center'>Project</th>
					<th style='padding:8px 5px;border-bottom: 1px solid #DDDDDD;color:#cd2122 !important;text-align:center'>Patent</th>
					<th align="left" style='padding:8px 5px;border-bottom: 1px solid #DDDDDD;color:#cd2122 !important'>Deadline</th>
					<?php /*<th align="right" width="" style='padding:8px 5px;border-bottom: 1px solid #DDDDDD;color:#cd2122 !important;text-align:right;'>
						SynPat's Offer
					</th>*/?>
					<th align="right" style='padding:8px 5px;border-bottom: 1px solid #DDDDDD;color:#cd2122 !important;text-align:right'>SME's Avg. Price</th>
					<th align="left" style='padding:8px 5px 8px 10px;border-bottom: 1px solid #DDDDDD;color:#cd2122 !important;width:500px;'>Target</th>
					<th align="center" style='padding:8px 5px;border-bottom: 1px solid #DDDDDD;color:#cd2122 !important;'>Report</th>
					<th align="left" style='padding:8px 5px;border-bottom: 1px solid #DDDDDD;color:#cd2122 !important;'>Delete</th>
				</tr>
			</thead>
			<?php
			for ($i = 0; $i < count($getNotificationData); $i++) {
				?>
				<tr class='odd'>
					
						<?php
							$getElements = SurveyModelCustomer::getQuestionList($getNotificationData[$i]->surveyID);
						?>
						
				<script>
					mainAssocArray['<?php echo $getNotificationData[$i]->surveyID; ?>_opp'] = <?php echo json_encode($getElements); ?>;
					mainAssocProject['<?php echo $getNotificationData[$i]->surveyID; ?>_project'] = '<?php echo preg_replace('/(\v|\s)+/', " ", addslashes($getNotificationData[$i]->project_comment))?>';
					mainAssocReport['<?php echo $getNotificationData[$i]->surveyID; ?>_report'] = '<?php echo $getNotificationData[$i]->report_type?>';
				</script>
				<td style='padding:8px 3px;  border-top:0px; text-align: center;' onclick="getCLAIMElements(jQuery(this).parent().find('td').eq(1).find('a'), '<?php echo $getNotificationData[$i]->surveyID ?>');"><?php echo $getNotificationData[$i]->projectName;?></td>
				<td style='min-width:90px;padding:8px 3px;  border-top:0px;text-align:center '>
				<a class='' href='javascript://' data-deadline="<?php echo date('m/d/y', strtotime($getNotificationData[$i]->deadline)); ?>"  data-avoid="<?php echo $getNotificationData[$i]->avoided; ?>" data-target="<?php echo $getNotificationData[$i]->target; ?>" data-comment="<?php echo $getNotificationData[$i]->comment; ?>" data-id="<?php echo $getNotificationData[$i]->surveyID ?>" data-url="<?php echo JUri::base(); ?>index.php?option=com_survey&view=answer&param=<?php echo base64_encode($getNotificationData[$i]->surveyName . '@' . $getNotificationData[$i]->surveyID . '@' . $sessionEXpertID); ?>" onclick="getCLAIMElements(jQuery(this), '<?php echo $getNotificationData[$i]->surveyID ?>');"><?php echo $getNotificationData[$i]->combineName; ?></a></td>
				<td align='left' style='padding:8px 3px;  border-top:0px; text-align: center;' onclick="getCLAIMElements(jQuery(this).parent().find('td').eq(1).find('a'), '<?php echo $getNotificationData[$i]->surveyID ?>');"><?php echo date('m/d/y', strtotime($getNotificationData[$i]->deadline)); ?></td>
				<?php /*<td align="right" style='padding:8px 3px;  border-top:0px; text-align: right;' onclick="getCLAIMElements(jQuery(this).parent().find('td').eq(1).find('a'), '<?php echo $getNotificationData[$i]->surveyID ?>');">
				<?php
					setlocale(LC_MONETARY, 'en_US');
					echo ($getNotificationData[$i]->synpat_price>0)?'$'.number_format($getNotificationData[$i]->synpat_price):''; 
				?>
				</td>*/?>
				<td align="right" style='padding:8px 3px;  border-top:0px; text-align: right;' onclick="getCLAIMElements(jQuery(this).parent().find('td').eq(1).find('a'), '<?php echo $getNotificationData[$i]->surveyID ?>');">
					<?php 
						$getReportsAmountList = SurveyModelCustomer::findReportsPriceList((int)$getNotificationData[$i]->surveyID);
						if(count($getReportsAmountList)>0){
							$amount = 0;
							$counter = 0;
							foreach($getReportsAmountList as $report){
								if($report->amount>0){
									$amount +=$report->amount;$counter++;
								}
							}
							if($amount>0){
								$avg = $amount / $counter;
								echo '$'.number_format($avg);
							}
						}
					?>
				</td>
				<td align="left"  style='padding:8px 3px 8px 10px;  border-top:0px; text-align: left;width:500px;' onclick="getCLAIMElements(jQuery(this).parent().find('td').eq(1).find('a'), '<?php echo $getNotificationData[$i]->surveyID ?>');"><div class="sortingTable-column"><?php $target =  preg_replace(
              "~[[:alpha:]]+://[^<>[:space:]]+[[:alnum:]/]~",
              "<a href=\"\\0\" target='_blank'>\\0</a>", 
              $getNotificationData[$i]->target); echo nl2br($target);?></div></td>
				<td align="center" style='padding:8px 5px 1px 0; border-top:0px; text-align: center;'>
					<?php 
						if($getNotificationData[$i]->report_type==2){
					?>
						<button type="button" class="btn btn-medium btn-flat" onclick="window.open('<?php echo JUri::base(); ?>index.php?option=com_survey&view=answer&param=<?php echo base64_encode($getNotificationData[$i]->surveyName . '@' . $getNotificationData[$i]->surveyID . '@' . $sessionEXpertID); ?>','_self')">Find EoU!</button>
					<?php
						} else if($getNotificationData[$i]->report_type==1){
							$findID = false;
							if(count($getPriortArtReportIDs)>0 && in_array($getNotificationData[$i]->surveyID,$getPriortArtReportIDs)){
								$findID = true;
							}
					?>
						<button type="button" class="btn btn-medium btn-flat" <?php if($findID===false):?> onclick="window.open('<?php echo JUri::base(); ?>index.php?option=com_survey&view=answer&param=<?php echo base64_encode($getNotificationData[$i]->surveyName . '@' . $getNotificationData[$i]->surveyID . '@' . $sessionEXpertID); ?>','_self')" <?php else:?>style='background:rgb(205,33,34,0.4);cursor:not-allowed' <?php endif;?>>Invalidate!</button>
					<?php
						}
					?>
				</td>
				<td align="left" style='padding:8px 3px;border-top:0px; text-align: center;'><a href='javascript://' onclick='deleteOpportunity(jQuery(this),<?php echo $getNotificationData[$i]->surveyID?>);'><img src="<?php echo JUri::base();?>media/media/images/trash-16.png"/></a></td>
				</tr>
				<tr class="even" style='display:none;'>
					<td colspan="8" style="padding:0px;">
						<div class="gray-area">
							<div class="inner-container login-panel" style="padding-bottom:0;padding-top:10px;">		
								<h3 class="m_title" style=""><strong>Project Instructions:</strong></h3>
								<div class="content" style='background-color:#fff;padding:5px;'>
									<?php 
									if(!empty($getNotificationData[$i]->project_comment)):
									echo nl2br(preg_replace("~[[:alpha:]]+://[^<>[:space:]]+[[:alnum:]/]~","<a href=\"\\0\" target='_blank'>\\0</a>",               $getNotificationData[$i]->project_comment));
									else:
									/*echo "No special instructions for this project.";*/
									endif;
									?>
								</div>
							</div>
							<div class="inner-container login-panel" style="padding-bottom:0;">		
								<h3 class="m_title" style=""><strong>Claim Instructions:</strong></h3>
								<div class="content" style='background-color:#fff;padding:8px;'>
									<?php 
									if(!empty($getNotificationData[$i]->comment)):
									echo nl2br(preg_replace("~[[:alpha:]]+://[^<>[:space:]]+[[:alnum:]/]~","<a href=\"\\0\" target='_blank'>\\0</a>",               $getNotificationData[$i]->comment)); 
									else:
									/*echo "No special instructions for this project.";*/
									endif;
									?>
								</div>
							</div>
							<?php /*<div class="inner-container login-panel" style="padding-bottom:1px;">		
								<h3 class="m_title" style=""><strong>Claim Elements:</strong></h3>
								<div class="content" style='background-color:#fff;'>
									<?php 
										$concatString ="";
										foreach($getElements as $item){
											$concatString .=$item->description.' ';
										}
										$concatString = preg_replace('/;/',';<br/>',$concatString);
										$concatString = preg_replace('/:/',':<br/>',$concatString);
										echo $concatString;
									?>
								</div>
							</div>*/?>
							<div class="inner-container login-panel" style="padding-bottom:1px;">		
								<h3 class="m_title" style=''><strong>Supporting Documents:</strong></h3>
								<div class="content" style='background-color:#fff;'>
									<table class="table supporting_docs">
										<tbody>
											<?php 
												if(!empty($getNotificationData[$i]->supportingDocuments)){
											?>
												<tr>
													<td><?php echo nl2br(preg_replace("~[[:alpha:]]+://[^<>[:space:]]+[[:alnum:]/]~","<a href=\"\\0\" target='_blank' style='position:relative;top:5px;'>\\0</a>",               $getNotificationData[$i]->supportingDocuments));?></td>
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
									$dataIllustration = SurveyModelCustomer::getIllustrationData($getNotificationData[$i]->combineName);
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
		</table>
	</div>
	<div class="span7 noMargin" style="margin:0 !important;">
		<div id="dataFlow"></div>
	</div>
	<?php
} else {
	
	if(count($userData)>0 && $userData->nda==0){
?>
<style>
.btn-flat{font-family:'Roboto',sans-serif !important;}
#agreement{font: 400 14px/24px Roboto,sans-serif !important;color:#4a5960;margin:30px auto;width:856px;background: rgba(247,247,247,0.92);padding:70px 158px 50px;}
#frmNDA{margin:0px;}
</style>
<form method="post" action="<?php echo JURI::root();?>index.php" enctype='multipart/form-data' id="frmNDA">
	<div id="agreement" style="">
		<?php echo $agreement->content;?>
		<p style="display: flex;justify-content: space-between;">
			<span style="flex:1">Syndicated Patent Acquisitions Corp.</span>
			<span style="text-align: right;flex: 1;"><?php echo $name;?></span>
		</p>
		<p style="text-align: right;"><button class="btn btn-medium btn-flat" type="button" onclick="ndaIAgree()">I Agree</button></p>
	</div>
<input type="hidden" name="option" value="com_survey"/>
<input type="hidden" name="task" value="customer.nda"/>
<input type="hidden" name="default_type" id="default_type" value="0"/>
</form>

<script>
function ndaIAgree(){
	jQuery("#frmNDA").find("#default_type").val(1);
	document.getElementById("frmNDA").submit();
}
</script>
<?php } else {?>
	
		<div style="margin-top: 43px;">	<p class="alert alert-danger">No record found!</p></div>
	  
	<?php
	}
}
?>
<div id="flow_elements" style="display:none">

	
</div>

<div id="slidebarView1" class="slidebar slidebar-right">
	<div class="slidebar-content">
		<iframe class="slidebar-content-iframe" src="" id="frameDisplay" width="100%" height="300" frameborder="0" allowfullscreen=""></iframe>
	</div>
	<a href="" class="slidebar-close" onclick="return hideSlidebar('slidebarView1')"></a>
</div>
 <script>
function openFromP(u){
	jQuery("#frameDisplay").attr('src',u);
	showSlidebar('slidebarView1');
}
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
</script>
