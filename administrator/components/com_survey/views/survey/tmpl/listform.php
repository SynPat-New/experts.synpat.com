<?php
/**
 * @copyright   (C) 2010 iJoomla, Inc. - All rights reserved.
 * @license  GNU General Public License, version 2 (http://www.gnu.org/licenses/gpl-2.0.html)
 * @author  iJoomla.com <webmaster@ijoomla.com>
 * @url   http://www.ijoomla.com/licensing/
 * the PHP code portions are distributed under the GPL license. If not otherwise stated, all images, manuals, cascading style sheets, and included JavaScript  *are NOT GPL, and are released under the IJOOMLA Proprietary Use License v1.0 
 * More info at http://www.ijoomla.com/licensing/
*/
defined ('_JEXEC') or die ("Go away.");

/*$app = JFactory::getApplication('administrator');
$limistart = $app->getUserStateFromRequest('com_guru', 'limitstart', 0);
$limit = $app->getUserStateFromRequest('com_guru'.'.list.limit', 'limit');	*/

$rows = $this->surveyList;
$total = count($rows);
$pageNav = $this->pagination;
$getData = SurveyModelSurvey::getProjectDetail(JRequest::getInt('project_id'));
$doc = &JFactory::getDocument();
$doc->addScript('components/com_survey/js/jquery-1.4.2.min.js');	
$doc->addScript('components/com_survey/js/jquery.noconflict.js');
$doc->addScript('components/com_survey/js/jquery.DOMWindow.js');
$doc->addScript('components/com_survey/js/open_modal.js');
if(count($getData)>0){
JToolBarHelper::title(JText::_($getData->name .'(Claim List)'));
}
$doc->addScript('components/com_survey/js/application.js');
?>
<style>

th.sortable {
												
	cursor: pointer;
	text-decoration: underline;
}
th.sortable:hover {  }
th.sorted-asc{color:#0088CC;}

th.sorted-desc  { color: black; }
</style>

<form action="index.php" method="post" name="adminForm">	
	<table id="resultTable" class="adminlist1 table table-bordered table-striped">
    	<thead>
			<tr>
				<th>
					#
				</th>
				<!--
				<th>
					<input type="checkbox" name="toggle" value="" onClick="checkAll(<?php echo count($rows); ?>);" />
				</th>-->
				<th width="5%">
					<?php echo JText::_("Claim"); ?>
				</th>
				<th width="7%">
					<?php echo JText::_("Target"); ?>
				</th>
				<th width="20%">
					<?php echo JText::_("Avoided"); ?>
				</th>
				<th width="7%">
					<?php echo JText::_("Ordered"); ?>
				</th>
				<th width="7%">
					<?php echo JText::_("Deadline"); ?>
				</th>
				<th width="20%">
					<?php echo JText::_("Comment"); ?>
				</th>
				<th width="12%">
					<?php echo JText::_("Questionare Created"); ?>
				</th>
				<th width="9%">
					<?php echo JText::_("Sent to Expert"); ?>
				</th>
				<th>
					<?php echo JText::_("# of Experts"); ?>
				</th>
				<th>
					<?php echo JText::_("Failed"); ?>
				</th>
				<th>
					<?php echo JText::_("CC InProcess"); ?>
				</th>
				<th>
					<?php echo JText::_("CC Submitted"); ?>
				</th>
				<th>
					<?php echo JText::_("Sold"); ?>
				</th>
				<!--
				<th>
					<?php echo JText::_("Price"); ?>
				</th>	
				-->					
			</tr>
        </thead>
		<?php
		$k = 0;		
		$i = 0;
		$n = count($rows);
		if($n>0):
		foreach($rows as $key=>$row) {		
			$link 	= 'index.php?option=com_survey&task=survey.edit&id='.$row['id'].'&hidemainmenu=1';
		?>
			<tr class="<?php //echo "row$k"; ?>">
				<td>
					<?php echo $i+1+$pageNav->limitstart;?>
				</td>
				<td>
					<a href="index.php?option=com_survey&task=question.list&survey_id=<?php echo $row['id']; ?>">
						<?php echo $row['combine_name']; ?>
					</a>
				</td>
				<td><?php echo $row['target'];?></td>
				<td><?php echo $row['avoided'];?></td>
				<td>
					
					<?php 
						$getClaimOrderedDate = SurveyModelSurvey::getSurveyOrderedDate($row['id']);
						if(count($getClaimOrderedDate)>0){
							echo date('M d, Y',strtotime($getClaimOrderedDate['create_date']));
						}
					?>
				</td>
				<td><?php echo date('M d, Y',strtotime($row['deadline']));?></td>
				<td><?php echo $row['comment'];?></td>
				<td>	
					<?php 
						$getCreatedDate = SurveyModelSurvey::getLastQuestionClaim($row['id']);
						if(count($getCreatedDate)>0){
							echo date('M d, Y',strtotime($getCreatedDate->created_date));
						}
					?>
				</td>
				<td>
					<?php 
						$sendToExpertData = SurveyModelSurvey::getClaimDateToExpert($row['id']);
						if(count($sendToExpertData)>0){
							echo date('M d, Y',strtotime($sendToExpertData->send_date ));
						}
					?>
				</td>
				 
				
				<td>
					<a href="index.php?option=com_survey&task=survey.sendSuccess&survey_id=<?php echo $row['id'];?>&status=0">
						<?php 
							$successSend = SurveyModelSurvey::getClaimsSendToExpertSuccess($row['id']);
							echo $successSend->emailSend;
						?>
					</a>
				</td>
				<td>
					<a href="index.php?option=com_survey&task=survey.sendSuccess&survey_id=<?php echo $row['id'];?>&status=1">
						<?php 
							$failedSend = SurveyModelSurvey::getClaimsSendToExpertFailed($row['id']);
							echo $failedSend->emailSend;
						?>
					</a>
				</td>
				<td>
					<?php 
						$inProcessClaim = SurveyModelSurvey::getInProcessClaim($row['id']);
						echo (count($inProcessClaim)>0)?$inProcessClaim->inProcess:'0';
					?>
				</td>
				<td>
					<?php 
						$getExpertList = $this->getExpertListBySurveyAns($row['id']);
						echo count($getExpertList);
					?>
				</td>
				
				<?php 
					$noOfReportSold = SurveyModelSurvey::claimSoldReport($row['id']);
				?>
				<td>
					<?php 
						echo count($noOfReportSold );
					?>
				</td>
						
				
			</tr>
			<?php
			$k = 1 - $k;
			$i ++;
		}
		?>
        	<tr>
            	<td colspan="14" align="center">	
            	<style>					.container{width:auto;}					.container .pagination{float:left;}					</style>
					<?php //echo $this->pagination->getListFooter(); ?>
                </td>
            </tr>
		<?php else:?>
			<tr>
				<td colspan="8">No survey added in this project.</td>
			</tr>
		<?php endif;?>
		</table>
		<input type="hidden" name="option" value="com_survey" />
		<input type="hidden" name="task" value="survey.list" />
		<input type="hidden" name="boxchecked" value="0" />
		<input type="hidden" name="hidemainmenu" value="0" />
		<input type="hidden" name="project_id" value="<?php echo JRequest::getVar('project_id','');?>"/>
		<input type="hidden" name="controller" value="survey" />
</form>
