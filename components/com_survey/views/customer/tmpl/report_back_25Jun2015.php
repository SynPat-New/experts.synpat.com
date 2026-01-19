<?php
// No direct access to this file 
defined('_JEXEC') or die('Restricted access');
$getExpertData = $this->expertData;
$getSurveyInfo = $this->surveyInfo;
$expertRatingData = $this->expertRatingData;
$getQueAnsData = $this->report;
$patentNumber = "";
$claimNumber ="";
if(count($getSurveyInfo)>0){
	/*$claimNumber = substr($getSurveyInfo->combine_name,strlen($getSurveyInfo->combine_name)-2 , -1);*/	
	$patentNumber = $getSurveyInfo->name;
	$claimNumber = str_replace($patentNumber,"",$getSurveyInfo->combine_name);
	if(strpos(strtolower($getSurveyInfo->name),"us")===false){
		$patentNumber = "US".$patentNumber;
	}
}
$name = $getExpertData->name;
$profileImage = $getExpertData->linkedin_pic;
preg_match_all('/<img[^>]+>/i',$getExpertData->profile_desc, $resultProfileImage);

if(isset($resultProfileImage[0]) && isset($resultProfileImage[0][0])){
	$profileImage = $resultProfileImage[0][0];
}
if($profileImage==""){
$profileImage = "<img src='http://placehold.it/120x120' class='alignleftborder' style='width:200px;' style='width:120px; height:120px;'>";
}
$profileUrl = $getExpertData->linkedin_profile_url;

$overAllRating = 0;				
$totalProject = 0;
$calcRating = 0;
for($i=0;$i<count($expertRatingData);$i++){
	if($i==0){
		
	}
	$overAllRating = $overAllRating+$expertRatingData[$i]->rating;
	$totalProject = $totalProject + $expertRatingData[$i]->countSurvey;
}
if($totalProject>0 && $overAllRating>0){
$calcRating = round($overAllRating/$totalProject,1);
}
$class="";
if($calcRating>0){
	if($calcRating==1){
		$class="s_star_1_0";
	} else if(($calcRating>1 && $calcRating<1.5) || ($calcRating>1.5 && $calcRating<2)){
		$class="s_star_1_5";
	} else if($calcRating==2){
		$class="s_star_2_0";
	}else if(($calcRating>2 && $calcRating<2.5) || ($calcRating>2.5 && $calcRating<3)){
		$class="s_star_2_5";
	}else if($calcRating==3){
		$class="s_star_3_0";
	}else if(($calcRating>3 && $calcRating<3.5) || ($calcRating>3.5 && $calcRating<4)){
		$class="s_star_3_5";
	}else if($calcRating==4){
		$class="s_star_4_0";
	}else if(($calcRating>4 && $calcRating<4.5) || ($calcRating>4.5 && $calcRating<5)){
		$class="s_star_4_5";
	}else if($calcRating==5){
		$class="s_star_5_0";
	}
} else {
$class="s_star_0_0";
}
?>

<SCRIPT TYPE="text/javascript">
<!--
var message="Sorry, right-click has been disabled";
function clickIE() {if (document.all) {(message);return false;}}
function clickNS(e) {if
(document.layers||(document.getElementById&&!document.all)) {
if (e.which==2||e.which==3) {(message);return false;}}}
if (document.layers)
{document.captureEvents(Event.MOUSEDOWN);document.onmousedown=clickNS;}
else{document.onmouseup=clickNS;document.oncontextmenu=clickIE;}
document.oncontextmenu=new Function("return false")
// -->
<!--

function disableselect(e){
return false
}
function reEnable(){
return true
}
//if IE4+
document.onselectstart=new Function ("return false")
//if NS6
if (window.sidebar){
document.onmousedown=disableselect
document.onclick=reEnable
}
// -->
</SCRIPT>

<div class="row-fluid">
	<div class="span12 solid-all">
		<div style='margin:0 auto; width:95%'>
		<table cellspacing="0" class="tM" border="0" cellpadding="0" width="100%" bgcolor="#efefef">
  <tr>
    <td>

  
   <table style="" width="700" border="0" align="left" cellpadding="5" cellspacing="0">
	
	<tr>
		<td>
			<table width="681" border="0" cellspacing="0" cellpadding="5" align="center">
				<tr>
					<td valign="top" width="150"><?php echo $profileImage;?></td>
					<td width="10"></td>
					<td valign="top" width="540">
						<p style="display:block;">
						<span style='color:#126792;'><?php echo $name;?></span> <span class="swSprite <?php echo $class;?>"></span><br /><span style="color:#126792;"><?php echo $getExpertData->degree;?></span><br/><span style="color:#126792;"><?php echo $getExpertData->company_name; ?>,</span><br/>
						<span style="color:#126792;"><?php echo $getExpertData->address;?>,</span><br /> <span style="color:#126792;"><?php echo $getExpertData->email;?></span><br/> <span style="color:#126792;"><?php echo $getExpertData->phone?></span><br/><span style="color:#126792;"><?php echo $getExpertData->skype_name?></span></p>
					</td>
				</tr>
			</table>
		</td>
	</tr>

	</table>
	<!--<table width="917" border="0" cellspacing="0" cellpadding="0" align="left"   style='margin-left:13px;border:3px solid #b90022 !important;'>
		<tr>
			<td>&nbsp;</td>
		</tr>
	</table>
	<table width="917" border="0" cellspacing="0" cellpadding="0" align="left" class='solid-all tM3 dMx' style='margin-left:13px;border-color:#b90022 !important;'>
		<tr>
			<td>&nbsp;</td>
		</tr>
	</table>-->
    
    <table  cellspacing="0" border="0" align="center" cellpadding="10" width="910" style=''>
  <tr>
    <td>
    
    <table cellspacing="0" border="0" id="email-content" cellpadding="0" width="910">
  <tr>
    <td>
    <?php 
		if((int)$getSurveyInfo->report_type==2):
	?>
    <table cellspacing="0" border="0" cellpadding="0" width="920" style='text-transform:uppercase; width:920px;height:auto;overflow:hidden;'>
	  <tr>
		<td valign="top" align="left">
			<h5 style="font-size: 14px; font-weight: bold; color: #333333; font-family: times new roman; margin-top: 0px; margin-bottom: 5px;">Report of Evidence of Use</h5>
			<p  class="solid-all dP-all-s" style="font-size: 14px; line-height: 16px; font-family: times new roman; color: #333; margin: 0px;">
			The views presented here are of the author only and do not necessarily reflect the views of others. The author is an independent contractor that acts on behalf of neither the patent owner nor any other third party, including ClaimCharts.info. We would like to thank ClaimCharts.info for introducing to us the opportunity to prepare this report.  For comments and questions, please feel free to contact us directly, or via my profile at ClaimCharts.info.</p>
		</td>
	  </tr>
	</table>
	<?php endif;?>
	
    <table cellspacing="0" border="0" cellpadding="0" style='width:910px;height:auto;overflow:hidden;'>
	  <tr>
		<td height="10">&nbsp; </td>
	  </tr>
	</table>
	
	
    <table cellspacing="0" border="0" cellpadding="0" style='width:910px;height:auto;overflow:hidden;'>
	  <tr>
		<td valign="top" align="left">
			<h5 style="font-size: 14px; font-weight: bold; color: #126792; font-family: times new roman; margin-top: 0px; margin-bottom: 10px;">Patent Number: <?php echo $patentNumber;?></h5>
			<h5 style="font-size: 14px; font-weight: bold; color: #126792; font-family: times new roman; margin-top: 0px; margin-bottom: 10px;">Claim Number: <?php echo $claimNumber;?></h5>
			<p style="font-size: 16px; line-height: 16px; font-family: times new roman; color: #333; margin: 0px;">
			<?php 
				$textShow = "";
				for($i=0;$i<count($getQueAnsData);$i++){
					$textShow .= $getQueAnsData[$i]->description ." ";
				}
				echo $textShow;
			?></p>
		</td>
	  </tr>
	</table>
	
	
    <table cellspacing="0" border="0" cellpadding="0" style='width:910px;height:auto;overflow:hidden;'>
	  <tr>
		<td height="20">&nbsp; </td>
	  </tr>
	</table>
<?php 
	$d=1;
	for($i=0;$i<count($getQueAnsData);$i++){
	?>
		<table cellspacing="0" border="0" cellpadding="0" style='width:910px;height:auto;overflow:hidden;font-family: times new roman;'>
				  <tr>
					<td valign="top" align="left">
						<h5 style="font-size: 14px; font-weight: bold; color: #126792; font-family: times new roman; margin-top: 0px; margin-bottom: 10px;">Element <?php echo $d;?>:</h5>
						<p style="font-size: 16px; line-height: 16px; font-family: times new roman; color: #333; margin: 0px;">
						<?php echo $getQueAnsData[$i]->description;?><br /><br /></p>
						<div style='font-family: times new roman;font-size: 16px;'><?php echo $getQueAnsData[$i]->answer;?> </div>
					</td>
				  </tr>
				  <tr>
					<td height="20">&nbsp; </td>
				  </tr>
				  <?php
				  if($getQueAnsData[$i]->supporting_document!=""){
				  ?>
				 <tr>
					<td valign="top" align="left">
						<p style="font-size: 14px;font-weight:bold; line-height: 30px; font-family: times new roman; color: #126792; margin: 0px;">Supporting Evidence:</p>
						<img style='max-width:918px !important;' src="<?php echo JUri::base();?>components/com_survey/document/<?php echo $getQueAnsData[$i]->supporting_document;?>"/>
					</td>
				  </tr>
				  <tr>
					<td height="20">&nbsp; </td>
				  </tr>
				  <tr>
					<td height="20">&nbsp; </td>
				  </tr>
				  <?php
				  }
				  ?>
				</table>
				
				
				<table cellspacing="0" border="0" cellpadding="0" style='width:910px;height:auto;overflow:hidden;'>
				  <tr>
					<td height="20">&nbsp; </td>
				  </tr>
				</table>
				<?php
		$d++;
	}
	?>
    
    <table cellspacing="0" border="0" cellpadding="0" style='width:910px;height:auto;overflow:hidden;'>
	  <tr>
		<td align="center">*&nbsp;&nbsp;*&nbsp;&nbsp;*&nbsp;&nbsp;*&nbsp;&nbsp;*</td>
	  </tr>
	   <tr>
		<td height="20" align="center"><p style="font-size:14px">End of Report</p></td>
	  </tr>
	</table>
	
	
    <table cellspacing="0" border="0" cellpadding="0" width="100%" style='width:910px;height:auto;overflow:hidden;'>
	  <tr>
		<td valign="top" align="left" height="10px">&nbsp;</td>
	  </tr>
	  <?php
	 /*Generate Digital Code for Expert Rating*/
	 /*
				$checkCodeGenerate = $this->getModel('Customer')->checkDigiCodeGenerate($post['date_status']);
				$urlQueryString = "";
				$urlQueryString = base64_encode($getSurevyData->survey_id."@".$getSurevyData->expert_id."@".$post['date_status']);
				$getDigiID = $this->getModel('Customer')->generateDigiCode($urlQueryString,$post['date_status']); 
					if($getDigiID>0){
				if(count($checkCodeGenerate)==0){
					$urlQueryString = base64_encode($getSurevyData->survey_id."@".$getSurevyData->expert_id."@".$post['date_status']."@".$getDigiID);
				} else {
					$urlQueryString = $checkCodeGenerate->code_generate;
					$urlQueryString = base64_decode($urlQueryString);
					$urlQueryString .="@".$checkCodeGenerate->id;
					$urlQueryString  = base64_encode($urlQueryString);
				}
				$URL = JUri::base().'index.php?option=com_survey&task=customer.expertRating&display='.$urlQueryString;
				*/ ?>
	
	<tr>
		<td valign="top" align="left">
			<p style="font-size: 14px; line-height: 16px; font-family: times new roman; color: #333; margin: 0px;">
			Please rank my report. The following link leads to our profile at ClaimCharts.info, where you could rank our report.<br/><a href="javascript:void(0);" style='color:#126792;'>Rank Here</a></p>
		</td>
	  </tr>
	 
	 
	  <tr>
		<td valign="top" align="left" height="10px">&nbsp;</td>
	  </tr>
	  
	  <tr>
		<td valign="top" align="left">
			<p style="font-size: 14px; line-height: 16px; font-family: times new roman; color: #333; margin: 0px;">
			We are available to answer follow up questions, provide clarifications and search for additional materials upon request. For public contact - please refer to our profile at <a href="<?php echo JUri::base();?>index.php?option=com_survey&task=customer.expertProfile&display=<?php echo $getSurevyData->expert_id;?>#commenting" style='color:#126792;'>ClaimCharts.info</a>. For private contact - please call/email us.</p>
		</td>
	  </tr>
	  
	  <tr>
		<td valign="top" align="left" height="10px">&nbsp;</td>
	  </tr>
	  
	   <tr>
		<td valign="top" align="left">
			<p style="font-size: 14px; line-height: 16px; font-family: times new roman; color: #333; margin: 0px;">
			Our hourly rate is: - - -</p>
		</td>
	  </tr>
	  
	</table>
	
	
    <table cellspacing="0" border="0" cellpadding="0" style='width:910px;height:auto;overflow:hidden;'>
	  <tr>
		<td valign="top" align="left" height="40px">&nbsp;</td>
	  </tr>
	 
	 <tr>
		<td valign="top" align="left">
			<p style="font-size: 14px; font-weight:bold; line-height: 16px; font-family: times new roman; color: #333; margin: 0px; text-transform:uppercase;">Non-Disclosure Agreement:</p>
		</td>
	  </tr>
	  
	  <tr>
		<td valign="top" align="left" height="10px">&nbsp;</td>
	  </tr>
	  
	  <tr>
		<td valign="top" align="left">
			<p style="font-size: 14px; line-height: 16px; font-family: times new roman; color: #333; margin: 0px;">
			We understand that for the purpose of assisting you in collecting data, you may disclose to us certain confidential information that you want to keep confidential; therefore, for good and valuable consideration, the receipt and sufficiency of which is hereby acknowledged, we agree as follows:</p>
		</td>
	  </tr>
	  
	  <tr>
		<td valign="top" align="left" height="10px">&nbsp;</td>
	  </tr>
	  
	     
	   <tr>
		<td valign="top" align="left">
			<p style="font-size: 14px; line-height: 16px; font-family: times new roman; color: #333; margin: 0px;">
			1.	For a period of twelve (36) months from the date we receive your confidential information ("Effective Date"), we will not use or disclose the information, except: (a) in the event that such information (i) comes into the public domain not through us; (ii) is already known to us at the time of disclosure; (iii) is lawfully otherwise learnt or independently developed by us; or (iv) is required to be disclosed by law.</p>
		</td>
	  </tr>
	  
	  <tr>
		<td valign="top" align="left" height="10px">&nbsp;</td>
	  </tr>
	  
	   <tr>
		<td valign="top" align="left">
			<p style="font-size: 14px; line-height: 16px; font-family: times new roman; color: #333; margin: 0px;">
			2.	Since a breach of our obligations hereunder may result in irreparable harm to you, we agree that upon such breach or threat thereof, you shall be entitled to specific performance and other injunctive relief without posting a bond, and in the event of disclosures required by court order, we shall promptly notify you of the proceeding.</p>
		</td>
	  </tr>
	  
	   <tr>
		<td valign="top" align="left" height="10px">&nbsp;</td>
	  </tr>
	  
	  <tr>
		<td valign="top" align="left">
			<p style="font-size: 14px; line-height: 16px; font-family: times new roman; color: #333; margin: 0px;">
			3.	This agreement supersedes all prior discussions and writings and constitutes the entire agreement between you and us with respect to the subject matter hereof.  This Agreement shall be binding upon the successors and assigns of the respective parties, and may not be modified except by an instrument executed by both parties.</p>
		</td>
	  </tr>
	</table>
	
	
    <table cellspacing="0" border="0" cellpadding="0" width="100%" style='width:910px;height:auto;overflow:hidden;'>
	  
	  
	  <tr>
		<td valign="top" align="left" height="10px">&nbsp;</td>
	  </tr>
	  
	  <tr>
		<td valign="top" align="left">
			<p style="font-size: 14px; line-height: 16px; font-family: times new roman; color: #333; margin: 0px;">
			<?php echo $name;?><br /><?php echo $getExpertData->company_name;?></p>
		</td>
	  </tr>
	</table>
	
    </td>
  </tr>
</table>
    </td>
  </tr>
</table>


    <table width="680" border="0" align="center" cellpadding="30" cellspacing="0">
	  <tr>
		<td height="30"></td>
		<td height="30"></td>
	  </tr>
	</table>
    </td>
  </tr>
</table>
		</div>
	</div>
</div>
