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
$profileID = $this->profileID;
$displayID = $this->id;
if($sessionEXpertID==0){
	if($profileID>0){
		$getExpertData = SurveyModelCustomer::expertData($profileID);
		if(count($getExpertData)>0){
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
		}		
	}	
}

?>

<style>

	@media (max-width: 767px) {
		.media table,
		.media table tbody,
		.media table tbody tr,
		.media table tbody tr td {
			display: block;
		}
		.media .swSprite {
			display: block;
			float: none;
		}
	}

</style>


<!-- Expert Feedback -->
<dl class="article-info clearfix">
			<?php if($sessionEXpertID>0):?>
			<dd class="createdby"><a href="<?php echo JRoute::_('index.php?option=com_survey&task=customer.expertOpportunites&display='.$displayID)?>" >Projects</a></dd>
			
			<dd class="createdby"><a href="<?php echo JRoute::_('index.php?option=com_survey&task=customer.expertProcess&display='.$displayID)?>">In Process</a></dd>
			<?php endif;?>
			<dd class="createdby"><a href="<?php echo JRoute::_('index.php?option=com_survey&task=customer.expertReport&display='.$displayID)?>">My Reports</a></dd>			
			<dd class="published"><a style='color:#cd2122' href="<?php echo JRoute::_('index.php?option=com_survey&task=customer.expertFeedback&display='.$displayID)?>">Feedback</a></dd>
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
	$getExpertFeedback = SurveyModelCustomer::expertRatingDataDetail($profileID);
		if (count($getExpertFeedback) > 0) {
?>
		<ul class="nav nav-stacked" style="margin-top: 43px;">
			<?php
			for ($r = 0; $r < count($getExpertFeedback); $r++) {
				$class = 's_star_' . $getExpertFeedback[$r]->rating . '_0';
				?>
				<li>
					<div class="media xRound" style="margin:20px 0; border:1px solid #ccc; padding:10px;">
						<span title="<?php echo $getExpertFeedback[$r]->rating; ?> out of 5 stars"
							  class="pull-left swSprite <?php echo $class; ?>"></span>

						<div class="media-body">
							<table>
								<tr>
									<td>Order:</td>
									<td><b><?php echo $getExpertFeedback[$r]->projectName; ?></b></td>
									<td>Patent(Claim):</td>
									<td><b><?php echo $getExpertFeedback[$r]->surveyName; ?></b></td>
								</tr>
								<tr>
									<td>Date report was acquired:</td>
									<td colspan="3">
										<?php 
											$recordString = explode('@',base64_decode($getExpertFeedback[$r]->digital_code));
											$findTransactionDate = SurveyModelCustomer::getTransDetails($recordString[2]);
											if(count($findTransactionDate)>0){
												echo date('M d,Y H:i', strtotime($findTransactionDate->create_date));
											}
										?>
									</td>
								</tr>
								<tr>
									<td>Date feedback was made:</td>
									<td colspan="3"><?php echo date('M d,Y H:i', strtotime($getExpertFeedback[$r]->created_date));?></td>
								</tr>
								<tr>
									<td>Feedback:</td>
									<td colspan="3"><?php echo $getExpertFeedback[$r]->feedback; ?></td>
								</tr>
								<tr>
									<td>Client name and company (optional):</td>
									<td colspan="3"></td>
								</tr>
							</table>							
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
	<div style="margin-top: 43px;"><p class="alert alert-danger">No feedback history for this expert!</p>
	</div>
<?php
	}
?>
<!-- End Expert Feedback -->
<script>
jQuery(document).ready(function() {
                jQuery('title').html('EXPERT FEEDBACK');
            });
</script>
