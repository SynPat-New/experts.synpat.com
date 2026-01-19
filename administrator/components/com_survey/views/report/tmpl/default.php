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

$rows = $this->authorList;
$total = count($rows);
$pageNav = $this->pagination;

$doc = &JFactory::getDocument();
$doc->addScript('components/com_survey/js/jquery-1.4.2.min.js');	
$doc->addScript('components/com_survey/js/jquery.noconflict.js');
$doc->addScript('components/com_survey/js/jquery.DOMWindow.js');
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

											td {
												
											}
											td.odd {
												/*
												background-color: #666;
												color: white;
												*/
											}
											
											td.hovered {
											
											  /*
											  color: #666;
											  */
											}
</style>
<form action="index.php" method="post" name="adminForm">
	<div id="search">
		<label for="filter">Filter</label> <input type="text" name="filter" value="" id="filter" />
	</div>	
	<table id="resultTable" class="adminlist1 table table-bordered table-striped">
    	<thead>
			<tr>
				<th width="2%">
					#
				</th>
				<th width="10%">
					<?php echo JText::_("Project"); ?>
				</th>
				<th width="10%">
					<?php echo JText::_("Claim"); ?>
				</th>
				<th width="10%">
					<?php echo JText::_("Expert"); ?>
				</th>
				<th width="10%">
					<?php echo JText::_("Target"); ?>
				</th>
				<th width="10%">
					<?php echo JText::_("Ordered"); ?>
				</th>
				<th width="10%">
					<?php echo JText::_("Sent to Expert"); ?>
				</th>
				<th width="10%">
					<?php echo JText::_("Created"); ?>
				</th>
				<th width="10%">
					<?php echo JText::_("Answered Elements"); ?>
				</th>
				
				<th width="10%">
					<?php echo JText::_("Price"); ?>
				</th>	
				
				<th width="10%">
					<?php echo JText::_("Sold"); ?>
				</th>
			</tr>
        </thead>
        <tbody>
		<?php
		$k = 0;		
		$i = 0;
		$n = count($rows);
		if($n>0):
		foreach($rows as $key=>$row) {		
			
		?>
			<tr class="<?php echo "row$k"; ?>">
				<td>
					<?php echo $i+1+$pageNav->limitstart;?>
				</td>
				<td><?php echo $row['ProjectName']; ?></td>				
				<td><?php echo $row['combineName']; ?></td>				
				<td><a href="index.php?option=com_survey&task=report.viewreport&expert_id=<?php echo $row['expertID']?>&survey_id=<?php echo $row['surveyID']?>"><?php echo strtoupper($row['expertName']); ?></a></td>				
				<td><?php echo $row['target']; ?></td>
				<td>
					<?php 
						$getData = SurveyModelReport::getClaimOrderDate($row['projectID']);
						if(count($getData)>0){
							echo date('M d, Y',strtotime($getData->create_date));
						}
					?>
				</td>				
				<td>
					<?php 
						$getData = SurveyModelReport::getClaimDateToExpert($row['surveyID']);
						if(count($getData)>0){
							echo date('M d, Y',strtotime($getData->send_date));
						}
					?>
				</td>	
				<?php 
					$getAnswerList = SurveyModelReport::getQuestionAnswerList($row['surveyID'],$row['expertID'] , $row['target']);
				?>
				<td>
					<?php 
						if(count($getAnswerList)>0){
							echo date('M d, Y', strtotime($getAnswerList[0]->created_date));
						}
					?>
				
				</td>				
				<td>
					<?php 
						
						if(count($getAnswerList)==0){
							echo "0/0";
						} else {
							$answerCount = 0;
							for($qa=0;$qa<count($getAnswerList);$qa++){
								if(!empty($getAnswerList[$qa]->qaID)){
									$answerCount = $answerCount + 1;
								}
							}
							echo $answerCount."/".count($getAnswerList);
						}
					?>
				</td>	
							
				<td>
					<?php 
						$getData = SurveyModelReport::getPriceSetByExpertForSurvey($row['expertID'],$row['surveyID'], $row['target']);
						if(count($getData)>0){
							echo $getData->amount;
						}
					?>
				</td>				
						
				<td>
					<?php 
						$getData = SurveyModelReport::getSurveyPurchaseTransaction($row['surveyID']);
						echo count($getData);
					?>
				</td>				
			</tr>
			<?php
			$k = 1 - $k;
			$i ++;
		}
		?>
			<!--
        	<tr>
            	<td colspan="14" align="center">
					<?php echo $this->pagination->getListFooter(); ?>
                </td>
            </tr>
            -->
		<?php else:?>
			<tr>
				<td colspan="6">No question added.</td>
			</tr>
		<?php endif;?>
		</tbody>
		</table>
		<input type="hidden" name="option" value="com_survey" />
		<input type="hidden" name="task" value="question.list" />
		<input type="hidden" name="boxchecked" value="0" />
		<input type="hidden" name="hidemainmenu" value="0" />
		<input type="hidden" name="controller" value="question" />
		<input type="hidden" name="survey_id" value="<?php echo JRequest::getVar('survey_id','');?>" />
</form>
