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
	$agreement = SurveyModelCustomer::getAgreementData(4);
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
#agreement{font: 400 14px/24px Roboto,sans-serif !important;color:#4a5960;margin:30px auto;width:856px;background: rgba(247,247,247,0.92);padding:70px 158px 50px;}
#frmNDA{margin:0px;}
</style>
<!-- Expert Feedback -->
<dl class="article-info clearfix">
	<?php if($sessionEXpertID>0):?>
	<dd class="createdby"><a  href="<?php echo JRoute::_('index.php?option=com_survey&task=customer.expertOpportunites&display='.$displayID)?>" >Projects</a></dd>
	<dd class="createdby"><a  href="<?php echo JRoute::_('index.php?option=com_survey&task=customer.expertProcess&display='.$displayID)?>">In Process</a></dd>
	<?php endif;?>
	<dd class="createdby"><a  href="<?php echo JRoute::_('index.php?option=com_survey&task=customer.expertReport&display='.$displayID)?>">My Reports</a></dd>
	<dd class="published"><a  href="<?php echo JRoute::_('index.php?option=com_survey&task=customer.expertFeedback&display='.$displayID)?>">Feedback</a></dd>	
	<?php if($sessionEXpertID>0):?>
	<dd class="createdby"><a  href="<?php echo JRoute::_('index.php?option=com_survey&task=customer.expertArea&display='.$displayID)?>" >My Expertise</a></dd>
	<?php endif;?>
	<!--<dd class="published"><a href="<?php echo JRoute::_('index.php?option=com_survey&task=customer.blog&display='.$displayID)?>">My Blog</a></dd>-->
	<dd class="published"><a href="<?php echo JRoute::_('index.php?option=com_survey&task=customer.termsOfUse&display='.$displayID)?>">Terms of Use</a></dd>
	<dd class="published"><a href="<?php echo JRoute::_('index.php?option=com_survey&task=customer.privacyPolicy&display='.$displayID)?>">Privacy Policy</a></dd>
	<dd class="published"><a href="<?php echo JRoute::_('index.php?option=com_survey&task=customer.smeAgreement&display='.$displayID)?>" >SME Agreement</a></dd>
	<?php if(count($userData)>0 && $userData->nda==1){?>
	<dd class="published"><a href="" style='color:#cd2122'>NDA</a></dd>
	<?php } ?>
	<?php if($sessionEXpertID>0):?>
	<dd class="createdby" ><a href="<?php echo JRoute::_('index.php?option=com_users&task=user.logout&'.JUtility::getToken().'=1');?>" >Logout</a></dd>
	<?php endif;?>
	<dd style='float:right'>
		<a style='color:#1a73e8;' href="<?php echo JRoute::_('index.php?option=com_survey&task=customer.expertProfile&display='.$displayID)?>"><?php if(is_array($imageUrl) && !empty($imageUrl[0])):?> <img src='<?php echo $imageUrl[0]?>' width="30px"/><?php else:?><img src='<?php echo JURI::root();?>templates/kallyas/images/user.png' width="30px"/> <?php endif;?>&nbsp;&nbsp;<?php echo $name;?></a>
	</dd>
	
</dl>
<div class='viewControl'>
	
	<h2 class="subtitle hugetitle" style="font-size: 36px; color: #595959;" id="subtitle" data-attr="15" data-class="rLeft" data-char="120"><p style="margin:0px;"><?php echo $name;?>&nbsp;</p></h2>
	<?php if(count($userData)>0 && $userData->nda==1){?>
		<div id="agreement" style="">
			<?php echo $agreement->content;?>
		</div>
	<?php }?>
</div>