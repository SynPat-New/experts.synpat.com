<?php
/**
 * @package		Joomla.Site
 * @subpackage	mod_whosonline
 * @copyright	Copyright (C) 2005 - 2014 Open Source Matters, Inc. All rights reserved.
 * @license		GNU General Public License version 2 or later; see LICENSE.txt
 */
// no direct access
defined('_JEXEC') or die;

$db = JFactory::getDBO();
$sql = "SELECT * FROM #__paypal_setting";
$db->setQuery($sql);
$getPaypalData = $db->loadObject();
$paypalEmail = $getPaypalData->email_id;
$paypalURL = "";
if ($getPaypalData->mode == 1) {
    $paypalURL = "https://www.paypal.com/cgi-bin/webscr?cmd=_xclick&notify_version=2.9";
} else { 
    $paypalURL = "https://www.sandbox.paypal.com/cgi-bin/webscr?cmd=_xclick&notify_version=2.9";
}
$backyardLeadID = JRequest::getVar('smp','');
$projectName = JRequest::getVar('rod','');
$deadLine = "";
$maximumPrice = "";
$synPatPrice = "";
$projectComment ="";
$targetProduct = "";
$avoidedProduct = "";
$claimComment = "";
$supportingDocuments = "";
$projectID = 0;
$priordeadLine = "";
$priormaximumPrice = "";
$priorsynPatPrice = "";
$priorprojectComment ="";
$priortargetProduct = "";
$priorclaimComment = "";
$priorSupportingDocuments = "";
$priorprojectID = 0;
$btnText = "Place Your Order";
$task = "customer.projectSurveyQuestionMultiple";
if($projectName!=""){
	$query = "SELECT * FROM #__projects WHERE name='".$projectName."' AND type=2";
	$db->setQuery($query);
	$getProjectData = $db->loadObject();
	if(count($getProjectData)>0){
		$query = "SELECT * FROM #__survey WHERE project_id=".$getProjectData->id." order by id desc LIMIT 1";
		$db->setQuery($query);
		$getSurveyData = $db->loadObject();
		if(count($getSurveyData)>0){
			$synPatPrice = $getProjectData->synpat_price;
			$projectComment = $getProjectData->description;
			$projectID = $getProjectData->id;
			$deadLine = date('Y-m-d',strtotime($getSurveyData->deadline));
			$maximumPrice = $getSurveyData->maximum_price_claim;
			$targetProduct = $getSurveyData->target;
			$avoidedProduct = $getSurveyData->avoided;
			$claimComment = $getSurveyData->comment;
			$supportingDocuments = $getSurveyData->document_evidence;
			$btnText = "Update Your Order";
			$task = "customer.projectSurveyQuestionMultipleUpdate";
		}		
	}
	
	$query = "SELECT * FROM #__projects WHERE name='".$projectName."' AND type=1";
	$db->setQuery($query);
	$getProjectData = $db->loadObject();
	if(count($getProjectData)>0){
		$query = "SELECT * FROM #__survey WHERE project_id=".$getProjectData->id." order by id desc LIMIT 1";
		$db->setQuery($query);
		$getSurveyData = $db->loadObject();
		if(count($getSurveyData)>0){
			$priorsynPatPrice = $getProjectData->synpat_price;
			$priorprojectComment = $getProjectData->description;
			$priorprojectID = $getProjectData->id;
			$priordeadLine = date('Y-m-d',strtotime($getSurveyData->deadline));
			$priormaximumPrice = $getSurveyData->maximum_price_claim;
			$priortargetProduct = $getSurveyData->target;
			$priorclaimComment = $getSurveyData->comment;
			$priorSupportingDocuments = $getSurveyData->document_evidence;
			$btnText = "Update Your Order";
			$task = "customer.projectSurveyQuestionMultipleUpdate";
		}		
	}
}
?>
<style>
.gobox.ok{
	background:#797979 !important;text-transform:none;
}
.gobox.ok h4{
	font-size:17.5px;margin-top:5px;
}
/*.table th, .table td{border-top:1px solid #DDDDDD;}*/
#header{background:rgba(0,0,0,0.5);}
nav#main_menu > ul.sf-menu > li > a{color:#fff;}
.topnav > li > a, .topnav li .menu li a{color:#fff;}
div.span1.btnDeleteSpan{margin-left:2.014102564102564% !important;}
.lastChild{
	margin-bottom:10px;
}
#patentImplementedAll .elementClaim:nth-child(odd){
	/*background-color:#dff0d8;border:1px solid #d6e9c6 !important*/
	border:1px solid #cccccc !important;
}
#patentImplementedAll .elementClaim:nth-child(even){
	border:1px solid #cccccc !important
}


	@media (min-width: 768px) {
		.nextButton {
			position: relative;
		}
		.nextButton [type=file] {
			position: absolute;
			top: 84px;
		}
	}

	@media (max-width: 767px) {
		.nextButton [type=file] {
			/*position: relative;
			top: 55px;*/
		}
		.row [class*=span]{
			margin-bottom:10px;
		}
	}


	/** Tooltips */
	.tooltip-inner {
		background-color: #404040 !important;
		border-radius: 2px !important;
		font-size: 13px !important;
		opacity: 0.8 !important;
	}
	.tooltip.top .tooltip-arrow {
  		border-top-color: #404040 !important;
		opacity: 0.8 !important;
	}

.elementClaim1{padding:10px;border:1px solid #cccccc !important}
</style>
<div class="visible-desktop visible-phone visible-tablet"> 
    <div id="order_scripts">
        <link rel="stylesheet" href="https://code.jquery.com/ui/1.8.2/themes/smoothness/jquery-ui.css" />
        <script src="https://code.jquery.com/ui/1.8.2/jquery-ui.js"></script>
    </div>
    <form action='index.php' method="POST" enctype="multipart/form-data" autocomplete="off">
	<h4>EoU Reports <div class="controls pull-right" style="text-align:center;">
							<input type="submit" class="btn btn-flat" name="submit" value="<?php echo $btnText?>" />
						</div></h4>
	<div class="row-fluid" style=''>
		<div style="">
		<div class="span6 ">
			<div class='span7 noMargin'>
				<div class="form-group">
					<label class="span4">Deadline:</label>
					<div class="span8 noMargin">
						<input type="text" id="project_deadline_multiple" data-placement="top" data-rel="tooltip" data-trigger="manual" data-original-title="Deadline for Delivery" class="input-block-level" placeholder="Dealine for Delivery" name="project_deadline_multiple" value="<?php echo $deadLine?>">
					</div>
				</div>			
			</div>	
			<div class='span5 noMargin'>
				<div class="form-group">
					<label class="span4">Price: </label>
					<div class="span8 noMargin">
						<input type="text" id="synpat_price" class="input-block-level" placeholder="SynPat price for Experts" name="synpat_price" value="<?php echo $synPatPrice?>" title="SynPat price for Experts"/>
						<input type="hidden" id="maximum_price_claim" data-placement="top" data-rel="tooltip" data-trigger="manual" data-original-title="Please state here how highly you would be willing to reward Experts for a good report. We would like to encourage Experts to invest as much time and efforts as they could in order to provide you with reports of the highest quality. This field is not mandatory, but if you like Experts to know that your budget allows high rewards for high quality reports - this is the place to do that!" class="input-block-level" placeholder="Maximum Price/Claim" name="maximum_price_claim"  value="<?php echo $maximumPrice?>">
					</div>	
				</div>
			</div>
		</div>
		<div class="span6 noMargin">
			<div class="form-group">
				<label class="span2">Target:</label>
				<div class="span10 noMargin">
					<input class="input-block-level target" name="target" type='text' id="target" class='span12' placeholder="List target products/servces/companies to research"  name="target"  value="<?php echo $targetProduct?>"/>
				</div>	
			</div>	
		</div>	
		</div>		
	</div>		
	<div class="row-fluid tM" id="patentImplementedAll">
		<div style="">
		<div class="span12 ">
			<div class="form-group">
				<label class="">Provide general instructions for the project:</label>
				<div class="span12 noMarginLeft"><textarea class="input-block-level comment" name="comment" style="min-height:60px;height:60px"  ><?php echo $projectComment?></textarea></div>
			</div>
			<div class="form-group ">
				<label class="">Provide instructions on specific patents:</label>
				<div class="span12 noMarginLeft"><textarea class="span12 " style="min-height:60px;height:60px"  name="claim_comment" type="text" ><?php echo $claimComment?></textarea></div>
			</div>
			<div class="form-group ">
				<label class="">Enter links to supporting materials:</label>
				<div class="span12 noMarginLeft"><textarea class="span12 document_evidence" style="min-height:60px;height:60px" name="document_evidence" placeholder=""><?php echo $supportingDocuments;?></textarea></div>
			</div>
		</div>
		</div>
	</div>	
	<h4>Invalidation Reports</h4>
	<div class="row-fluid" style=''>
		<div style="">
		<div class="span6 ">
			<div class='span7 noMargin'>
				<div class="form-group ">
					<label class="span4">Deadline: </label>
					<div class="span8 noMargin">
						<input type="text" id="prior_project_deadline_multiple" data-placement="top" data-rel="tooltip" data-trigger="manual" data-original-title="Deadline for Delivery" class="input-block-level" placeholder="Deadline for Delivery" name="prior_project_deadline_multiple" value="<?php echo $priordeadLine?>">
					</div>
				</div>
			</div>
			<div class='span5 noMargin'>
				<div class="form-group ">
					<label class="span8">SynPat's Price:</label>
					<div class="span4 noMargin">
						<input type="text" id="prior_synpat_price" class="input-block-level" placeholder="SynPat price for Experts" name="prior_synpat_price" value="<?php echo $priorsynPatPrice?>"/>
						<input type="hidden" id="prior_maximum_price_claim" data-placement="top" data-rel="tooltip" data-trigger="manual" data-original-title="Please state here how highly you would be willing to reward Experts for a good report. We would like to encourage Experts to invest as much time and efforts as they could in order to provide you with reports of the highest quality. This field is not mandatory, but if you like Experts to know that your budget allows high rewards for high quality reports - this is the place to do that!" class="input-block-level" placeholder="Maximum Price/Claim" name="prior_maximum_price_claim"  value="<?php echo $priormaximumPrice?>">
					</div>	
				</div>
			</div>
		</div>
		<div class="span6 ">
			<div class="controls">
				
			</div>	
		</div>	
		</div>		
	</div>		
	<div class="row-fluid tM" id="patentImplementedAll">
		<div class="span12" style='margin-left:0px;margin-top:5px;'>
			<div class="form-group ">
				<label>Provide general instructions for the project:</label>
				<div class="span12 noMarginLeft">
					<textarea id="prior_comment" style='min-height:60px;height:60px' class='span12' placeholder=""  name="prior_comment" ><?php echo $priorprojectComment?></textarea>
				</div>
			</div>
			<div class="form-group ">
				<label>Provide instructions on specific patents:</label>
				<div class="span12 noMarginLeft">
					<textarea class="span12 " style="min-height:60px;height:60px"  name="prior_claim_comment" type="text"><?php echo $priorclaimComment?></textarea>
				</div>
			</div>
			<div class="form-group ">
				<label>Enter links to supporting materials:</label>
				<div class="span12 noMarginLeft">
					<textarea class="span12 " style="min-height:60px;height:60px" name="prior_document_evidence" type="text"><?php echo $priorSupportingDocuments?></textarea>
				</div>
			</div>
		</div>	
	</div>
	
	
	<div class="row-fluid" style='margin-bottom:0px'>		
		<div class="span12" style='margin:10px 0 0 0;'>
			<div class="form-horizontal-1 visible-desktop visible-phone visible-tablet">
				<div class="control-group">
					<div class="controls controls-row">
						
					</div>
				</div>
			</div> 
		</div> 
    </div> 
		<input type="hidden" id="project_name_multiple" name="project_name_multiple" value="">
		<input type="hidden" name="order_smp" value="<?php echo $backyardLeadID;?>"/>
		<input type="hidden" id="specific_expert" name="specific_expert" value=""/>
		<input type="hidden"  id="email_sms" name="email_sms" >
		<input type="hidden" name="payment_type" id="payment_type" value="0"/>
		<input type="hidden" name="project_id" id="project_id" value="<?php echo $projectID;?>"/>
		<input type="hidden" name="priorproject_id" id="priorproject_id" value="<?php echo $priorprojectID;?>"/>
		<input type="hidden" name="rod" id="rod" value="<?php echo $projectName;?>"/>
		<input type="hidden" id="coupon_code" name="coupon_code"/>
		<input type="hidden" name="option" value="com_survey"/>
		<input type="hidden" name="task" value="<?php echo $task;?>"/>
	</form>
    <script>
		jQuery(document).ready(function() {               
			jQuery("#project_deadline_multiple,#prior_project_deadline_multiple").datepicker({dateFormat: 'yy-mm-dd'/*,minDate: '+1M'*/});
		});
    </script>
</div>
