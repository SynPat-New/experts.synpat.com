<?php

defined ('_JEXEC') or die ("Go away.");

/*$app = JFactory::getApplication('administrator');
$limistart = $app->getUserStateFromRequest('com_guru', 'limitstart', 0);
$limit = $app->getUserStateFromRequest('com_guru'.'.list.limit', 'limit');	*/

$rows = $this->authorList;
$total = count($rows);
$pageNav = $this->pagination;

?>

<form action="index.php" method="post" name="adminForm">	
	<table class="adminlist1 table table-bordered table-striped">
    	<thead>
			<tr>
				<th>
					#
				</th>
				<!--
				<th>
					<input type="checkbox" name="toggle" value="" onClick="checkAll(<?php echo count($rows); ?>);" />
				</th>-->
				<th>
					<?php echo JText::_("Name"); ?>
				</th>
				<!--<th>
					<?php echo JText::_("Last name"); ?>
				</th>
				<th>
					<?php echo JText::_("Company"); ?>
				</th>-->
				<th>
					<?php echo JText::_("Rate"); ?>
				</th>				
				<th><?php echo JText::_("# Of Questionare Sent"); ?></th>
				<th><?php echo JText::_("# Of Area Of Expertise"); ?></th>
				<th><?php echo JText::_("# Of Reports Submitted"); ?></th>
				<th><?php echo JText::_("# Of Reports Sold"); ?></th>
				<th><?php echo JText::_("Revenue Generated"); ?></th>
				<!--<th><?php echo JText::_("Profile Updated"); ?></th>-->
				<th><?php echo JText::_("Status"); ?></th>
				<th><?php echo JText::_("Feedback"); ?></th>
			</tr>
        </thead>
		<?php
		$k = 0;		
		$i = 0;
		$n = count($rows);
		if($n>0):
		foreach($rows as $key=>$row) {		
			$link 	= 'index.php?option=com_survey&task=expert.edit&id='.$row['id'].'&hidemainmenu=1';
		?>
			<tr class="<?php echo "row$k"; ?>">
				<td>
					<?php echo $i+1+$pageNav->limitstart;?>
				</td>
				<!--
				<td>
					<?php echo JHTML::_('grid.id', $i, $row['id'] ); ?>
				</td>
				-->
				<td>
					<a class="a_guru" href="<?php echo $link; ?>">
						<?php echo $row['name']; ?>
					</a>
				</td>
				<!--<td><?php echo $row['last_name']; ?></td>
				<td><?php echo $row['company_name']; ?></td>-->
				<td>
					<?php 
							$calcRating = 0;
							$overAllRating = 0; 
							$totalProject = 0;
							$rating = SurveyModelExpert::expertRatingData($row['id']);
							if(count($rating)>0){
								for($i=0;$i<count($rating);$i++){
									$overAllRating = $overAllRating+$rating[$i]->rating;
									$totalProject = $totalProject + $rating[$i]->countSurvey;
								}
								$calcRating = round($overAllRating/$totalProject,1);
							}
							
					?>
					<?php echo $calcRating;?> out of 5 stars
				</td>
				<td>
					<?php 
						$noOfSurvey = SurveyModelExpert::getExpertSurveySent($row['id']);
						if(count($noOfSurvey)>0){
							echo $noOfSurvey->noOfSurveySend;
						} else {
							echo "0";
						}
					?>
				</td>
				<td>	
					<?php
						$noOfExpertArea = SurveyModelExpert::getExpertAreaExpertise($row['id']);
						echo count($noOfExpertArea);
					?>
				
				</td>
				<td>
					<?php
						$reportSubmit = SurveyModelExpert::getNoOfReportSubmit($row['id']);
						if(count($reportSubmit)){
						echo $reportSubmit->surveyCount;
						} else {
							echo "0";
						}
					?>
				</td>
				<td>
					<?php
						$reportSold = SurveyModelExpert::getNoOfReportSold($row['id']);
						if(count($reportSold)){
							echo $reportSold->reportSold;
						} else {
							echo "0";
						}
					?>
				</td>
				<td>
					<?php
						$revenueGenerate = SurveyModelExpert::getRevenueGenerate($row['id']);
						if(count($revenueGenerate)){							
							echo ($revenueGenerate->revenueGenerate!="")?'$'.$revenueGenerate->revenueGenerate:'$0';
						} 
					?>
				</td>
				<!--<td>
					<?php if($row['pub']=='1'){ ?>
						<a class="a_guru" href="<?php echo $link; ?>">Yes</a>
					<?php }?>
				</td>-->
				<td>
					<?php 
						if($row['published']=='1'){
					?>
						<a href="index.php?option=com_survey&task=expert.unpublish&cid[]=<?php echo $row['id'];?>">
							<img src="<?php echo JUri::base();?>templates/bluestork/images/admin/tick.png"/>
						</a>
					<?php
						} else {
					?>
						<a href="index.php?option=com_survey&task=expert.publish&cid[]=<?php echo $row['id'];?>">
							<img src="<?php echo JUri::base();?>templates/bluestork/images/admin/publish_x.png"/>
						</a>
					<?php	
						}
						
					?>
				</td>
				<td><a href="index.php?option=com_survey&task=expert.feedback&id=<?php echo $row['id'];?>">Check</a></td>
			</tr>
			<?php
			$k = 1 - $k;
			$i ++;
		}
		?>

		<?php else:?>
			<tr>
				<td colspan="6">No Experts added.</td>
			</tr>
		<?php endif;?>
		</table>
		<input type="hidden" name="option" value="com_survey" />
		<input type="hidden" name="task" value="expert.list" />
		<input type="hidden" name="boxchecked" value="0" />
		<input type="hidden" name="hidemainmenu" value="0" />
		<input type="hidden" name="controller" value="expert" />
</form>
