<?php  defined( '_JEXEC' ) or die( 'Restricted access' );
 $pclmodhelper = new mod_pc_latestHelper();
 $projectName = $params->get( 'count' );
$rows = $pclmodhelper->getPCLModData($projectName);

if(count($rows)>0 && isset($rows['Project']) && count($rows['Project'])>0 && isset($rows['Survey']) && count($rows['Survey'])>0 && isset($rows['Question']) && count($rows['Question'])>0 && isset($rows['Expert']) && count($rows['Expert'])>0 && isset($rows['SurveyAmount']) && count($rows['SurveyAmount'])>0){

?>
<style>
table#projectlist td {
    margin: 0px 12px 0px 12px;
    padding: 0px 12px 0px 12px;
}
table#projectlist {
  border-collapse: separate;
  border-spacing: 10px;
  *border-collapse: expression('separate', cellSpacing = '10px');
}
</style>
<div class="span12 " style="margin-left: 0px !important;"><!-- START PHONE-->
	<div class="row-fluid">
		<div class="container_12" style="width: 100%; margin: 0;">
			<div class="span12">
				<div class="row-fluid">
					<div id="question1" class="span12">
						<div class="span3">
							<div class="span5">
								<legend class="smallm_title" style="color:#cd2122;padding: 34px 0px 7px 2px; vertical-align: bottom; border-bottom: 1px solid #e5e5e5; font-weight: bold !important;line-height:15px;margin-bottom:5px;">Order:</legend>
								<ul style='margin-left:0px;'>
									<li style="padding: 0px 0px 8px 2px;list-style:none;"><a class="active" style="color: red;" href="javascript:void(0)"><?php echo $rows['Project']->name;?></a></li>
								</ul>
							</div>
							<div class="span7">
								<legend class="smallm_title" style="color:#cd2122;padding: 34px 0px 7px 2px; vertical-align: bottom; border-bottom: 1px solid #e5e5e5; font-weight: bold !important;line-height:15px;margin-bottom:5px;">Patent(Claim):</legend>
								<ul style='margin-left:0px;'>
									<li style="padding: 0px 2px 8px 0px;list-style:none;"><a class="active" style="color: red;" href="javascript:void(0)"><?php echo $rows['Survey']->combine_name;?></a></li>
								</ul>
							</div>
							<!--<table id="projectlist" class="table">
								<thead>
									<tr><th class="smallm_title" style="padding: 24px 0px 7px 2px; vertical-align: bottom; border-bottom: 1px solid #e5e5e5; font-weight: bold !important;line-height:15px;">Order:</th><th class="smallm_title" style="padding: 24px 0px 7px 2px; vertical-align: bottom; border-bottom: 1px solid #e5e5e5; font-weight: bold !important;line-height:15px;">Patent(Claim):</th></tr>
								</thead>
								<tbody>
									<tr style="">
										<td style="padding: 0px 0px 8px 2px"><a class="active" style="color: red;" href="javascript:void(0)"><?php echo $rows['Project']->name;?></a></td>
										<td style="padding: 0px 2px 8px 0px;"><a class="active" style="color: red;" href="javascript:void(0)"><?php echo $rows['Survey']->combine_name;?></a></td>
									</tr>
								</tbody>
							</table>-->
						</div>
						<div class="span9">
							<div class="span5 noMarginLeft" style='max-width: 384.838px; float: left;margin-top: 27px;'>
								<table id="questionlist" class="table">
									<thead>
										<tr> 
											<th class="smallm_title" style="padding: 8px 0px 8px 2px; vertical-align: bottom; border-bottom: 1px solid #e5e5e5; font-weight: bold !important;line-height:13px;font-size:14px !important">Claim Elements:</th>	
										</tr>
									</thead>
									<tbody>
										<?php 
											if(count($rows['Question'])>0){
											for($i=0;$i<count($rows['Question']);$i++){
										?>
											<tr style="">
												<td style="padding: 10px 2px;width:45%;"><?php echo $rows['Question'][$i]['data']->description?></td>	
											</tr>
										<?php
											}   
										?>									
										<?php } ?>
									</tbody>
								</table>
							</div>
							<div class="span7" style='overflow-x: scroll; margin: 0px; max-width: 498.598px; float: left;'>
								<table id="expertList" class="table result-table" style="background: none repeat scroll 0% 0% transparent; margin-top: 0px;">
									<thead>
										<?php 
											for($e=0;$e<count($rows['Expert']);$e++){
										?>
											<th class="smallm_title aCenter" style="padding: 8px 2px; vertical-align: top; border-bottom: 1px solid #e5e5e5; font-weight: bold !important;">
												<a style='color:#cd2122' href="<?php echo JRoute::_('index.php?option=com_survey&task=customer.expertProfile&display='.$rows['Expert'][$e]->id)?>"><?php echo $rows['Expert'][$e]->name;?></a>
												
												<?php 
													/*echo $rows['Expert'][$e]->name;*/
													$ratings = $pclmodhelper->expertRatingData($rows['Expert'][$e]->id);													
													$__class="s_star_0_0";
													if(count($ratings)>0){
														$totalProject = 0;
														$totalRate = 0;
														foreach($ratings as $rating){
															$totalProject = $totalProject + $rating->countSurvey;
															$totalRate = $totalRate + $rating->rating;
														}
														if($totalProject>0 && $totalRate>0){
															$calcRating = $totalRate/$totalProject;
															if($calcRating==1){
																$__class="s_star_1_0";
															} else if(($calcRating>1 && $calcRating<1.5) || ($calcRating>1.5 && $calcRating<2)){
																$__class="s_star_1_5";
															} else if($calcRating==2){
																$__class="s_star_2_0";
															} else if(($calcRating>2 && $calcRating<2.5) || ($calcRating>2.5 && $calcRating<3)){
																$__class="s_star_2_5";
															} else if($calcRating==3){
																$__class="s_star_3_0";
															} else if(($calcRating>3 && $calcRating<3.5) || ($calcRating>3.5 && $calcRating<4)){
																$__class="s_star_3_5";
															} else if($calcRating==4){
																$__class="s_star_4_0";
															} else if(($calcRating>4 && $calcRating<4.5) || ($calcRating>4.5 && $calcRating<5)){
																$__class="s_star_4_5";
															} else if($calcRating==5){
																$__class="s_star_5_0";
															}
														}
													}
												?>
												<br/><label class="swSprite <?php echo $__class;?>" title="<?php echo $calcRating;?> out of 5 stars" style='cursor:default;'></label>
											</th>
										<?php
											}
										?>
									</thead>
									<tbody>
										<?php 
											if(count($rows['Question'])>0){
											for($i=0;$i<count($rows['Question']);$i++){
										?>
										<tr>
										<?php 
												for($e=0;$e<count($rows['Expert']);$e++){
													$currentExpert = "";
													for($a=0;$a<count($rows['Question'][$i]['answer']);$a++){
														if($rows['Question'][$i]['answer'][$a]->expert_id==$rows['Expert'][$e]->id){
															if((int)$rows['Question'][$i]['answer'][$a]->status==1){
																$currentExpert = "icon-ok";
															}
														}
													}
											?>
													<td class="aCenter" style="padding: 8px 2px;"><label class="<?php echo $currentExpert;?> aCenter" style='cursor:default'>&nbsp;</label></td>
											<?php
												}
											?>
										</tr>
										<?php
											}
										?>			
											<script>
												jQuery('#questionlist>tbody>tr').each(function(index){
														_height = jQuery(this).outerHeight();		
														jQuery("#expertList>tbody>tr").eq(index).css('height',_height+'px');		
												});
											</script>
										<?php } ?>
											<tr>
												
												<?php 											
													for($e=0;$e<count($rows['Expert']);$e++){
														$amount = 0;
														$target = "";
														$target_product = "";
														for($sa=0;$sa<count($rows['SurveyAmount']);$sa++){													
															if($rows['SurveyAmount'][$sa]->expert_id==$rows['Expert'][$e]->id){
																$amount = $rows['SurveyAmount'][$sa]->amount;
																$target = $rows['SurveyAmount'][$sa]->target;
																$target_product = $rows['SurveyAmount'][$sa]-> target_product ;
															}
														}
												?>
													<td class="aCenter" style="background: none; padding: 8px 2px;"><span class="dM"><b><?php echo $target;?></span></b><br /><span class="dM"><b><?php echo $target_product;?></span></b><br /> <span class="dM"><b>$<?php echo $amount;?></b></span><br /> <a class="btn btn-flat" href="javascript:void(0)" data-target="<?php echo $target;?>">Buy</a></td>
												<?php
													}
												?>
											</tr>
									</tbody>
								</table>
							</div>
						</div>
					</div>
				</div>
			</div>
		</div>
	</div>
</div>
<?php
} else {
?>
<div class="span12 " style="margin-left: 0px !important;"><!-- START PHONE-->
	<div class="row-fluid">
		<div class="container_12" style="width: 100%; margin: 0;">
			<div class="span12">
				<div class="row-fluid">
					<div id="question1" class="span12">
						<div class="span2">
							<table id="questionlist" class="table">
								<thead>
									<tr><th class="smallm_title" style="padding: 8px 2px; vertical-align: top; border-bottom: 1px solid #e5e5e5; font-weight: bold !important;">Project<br /><br /></th><th class="smallm_title" style="padding: 8px 2px; vertical-align: top; border-bottom: 1px solid #e5e5e5; font-weight: bold !important;">Claim<br /><br /></th></tr>
								</thead>
								<tbody>
									<tr style="margin-top: 10px;">
										<td style="padding: 8px 2px;"><a class="active" style="color: red;" href="javascript:void(0)">P66425</a></td>
										<td style="padding: 8px 2px;"><a class="active" style="color: red;" href="javascript:void(0)">US66426(01)</a></td>
									</tr>
								</tbody>
							</table>
						</div>
						<div class="span10" style="overflow-x: scroll;">
							<table id="questionlist" class="table">
								<thead>
									<tr><th class="smallm_title" style="padding: 8px 2px; vertical-align: top; border-bottom: 1px solid #e5e5e5; font-weight: bold !important;">Elements</th><th class="smallm_title aCenter" style="padding: 8px 2px; vertical-align: top; border-bottom: 1px solid #e5e5e5; font-weight: bold !important;"><a style='color:#cd2122'  href="<?php echo JRoute::_('index.php?option=com_survey&task=customer.expertProfile&display=6');?>">Barry G. Dickey</a> <label class="swSprite s_star_4_0" title="4 out of 5 stars"></label></th><th class="smallm_title aCenter" style="padding: 8px 2px; vertical-align: top; border-bottom: 1px solid #e5e5e5; font-weight: bold !important;"><a style='color:#cd2122'  href="<?php echo JRoute::_('index.php?option=com_survey&task=customer.expertProfile&display=1');?>">Nile Nickel</a> <label class="swSprite s_star_4_0" title="4 out of 5 stars"></label></th><th class="smallm_title aCenter" style="padding: 8px 2px; vertical-align: top; border-bottom: 1px solid #e5e5e5; font-weight: bold !important;"><a style='color:#cd2122'  href="<?php echo JRoute::_('index.php?option=com_survey&task=customer.expertProfile&display=2');?>">John Cosgrove</a> <label class="swSprite s_star_4_0" title="4 out of 5 stars"></label></th></tr>
								</thead>
								<tbody>
									<tr style="margin-top: 10px;">
										<td style="padding: 8px 2px;">1. A system, comprising:</td>
										<td class="aCenter" style="padding: 8px 2px;"><label class="icon-ok aCenter">&nbsp;</label></td>
										<td class="aCenter" style="padding: 8px 2px;"><label class="icon-ok aCenter">&nbsp;</label></td>
										<td class="aCenter" style="padding: 8px 2px;"><label class="icon-ok aCenter">&nbsp;</label></td>
									</tr>
									<tr>
										<td style="padding: 8px 2px;">an ionizing device,</td>
										<td class="aCenter" style="padding: 8px 2px;"><label class="icon-ok aCenter">&nbsp;</label></td>
										<td class="aCenter" style="padding: 8px 2px;"><label class="icon-ok aCenter">&nbsp;</label></td>
										<td class="aCenter" style="padding: 8px 2px;"><label class="icon-ok aCenter">&nbsp;</label></td>
									</tr>
									<tr>
										<td style="padding: 8px 2px;">comprising a substrate having at least one opening,</td>
										<td class="aCenter" style="padding: 8px 2px;"><label class="icon-ok aCenter">&nbsp;</label></td>
										<td class="aCenter" style="padding: 8px 2px;"><label class="icon-ok aCenter">&nbsp;</label></td>
										<td class="aCenter" style="padding: 8px 2px;"><label class="icon-ok aCenter">&nbsp;</label></td>
									</tr>
									<tr>
										<td style="padding: 8px 2px;">a first conductive electrode extending on a first surface of the substrate and</td>
										<td class="aCenter" style="padding: 8px 2px;"><label class="icon-ok aCenter">&nbsp;</label></td>
										<td class="aCenter" style="padding: 8px 2px;"><label class="icon-ok aCenter">&nbsp;</label></td>
										<td class="aCenter" style="padding: 8px 2px;"><label class="icon-ok aCenter">&nbsp;</label></td>
									</tr>
									<tr>
										<td style="padding: 8px 2px;">and a separator insulating element, having a thickness less than 1 micron,</td>
										<td class="aCenter" style="padding: 8px 2px;"><label class="icon-ok aCenter">&nbsp;</label></td>
										<td class="aCenter" style="padding: 8px 2px;"><label class="icon-ok aCenter">&nbsp;</label></td>
										<td class="aCenter" style="padding: 8px 2px;"><label class="icon-ok aCenter">&nbsp;</label></td>
									</tr>
									<tr>
										<td style="padding: 8px 2px;">separating said first and second conductive electrodes at said at least one opening,</td>
										<td class="aCenter" style="padding: 8px 2px;"><label class="icon-ok aCenter">&nbsp;</label></td>
										<td class="aCenter" style="padding: 8px 2px;"><label class="icon-ok aCenter">&nbsp;</label></td>
										<td class="aCenter" style="padding: 8px 2px;"><label class="icon-ok aCenter">&nbsp;</label></td>
									</tr>
									<tr>
										<td style="padding: 8px 2px;">said first and second conductive electrodes being separated by a width of said separator insulating element.</td>
										<td class="aCenter" style="padding: 8px 2px;"><label class="icon-ok aCenter">&nbsp;</label></td>
										<td class="aCenter" style="padding: 8px 2px;"><label class="icon-ok aCenter">&nbsp;</label></td>
										<td class="aCenter" style="padding: 8px 2px;"><label class="icon-ok aCenter">&nbsp;</label></td>
									</tr>
									
								</tbody>
							</table>
						</div>
					</div>
				</div>
			</div>
		</div>
	</div>
</div>
<!-- FOR PHONE -->
<?php } ?>
