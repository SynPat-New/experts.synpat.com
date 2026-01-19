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
$doc->addScript('components/com_survey/js/open_modal.js');
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
	<table id="resultTable" class="adminlist1 table table-bordered table-striped">
    	<thead>
			<tr>
				<th width="2%">
					#
				</th>
				<!--
				<th width="2%">
					<input type="checkbox" name="toggle" value="" onClick="checkAll(<?php echo count($rows); ?>);" />
				</th>		
				-->		
				<th width="6%">
					<?php echo JText::_("Ordered"); ?>
				</th>
				<th width="6%">
					<?php echo JText::_("Specific Expert"); ?>
				</th>
				<th width="6%">
					<?php echo JText::_("Paypal"); ?>
				</th>
				<th width="5%">
					<?php echo JText::_("Deadline"); ?>
				</th>
				<th width="5%">
					<?php echo JText::_("Project"); ?>
				</th>
				
				<!--
				<th width="33%">
					<?php echo JText::_("List Of Claims"); ?>
				</th>
				-->
				<th width="5%">
					<?php echo JText::_("# Of Claims"); ?>
				</th>
				<th width="10%">
					<?php echo JText::_("Order Comment"); ?>
				</th>
				<th width="8%">
					<?php echo JText::_("Questionares Prepared"); ?>
				</th>
				<th width="8%">
					<?php echo JText::_("Questionares Sent"); ?>
				</th>
				<th width="3%">
					<?php echo JText::_("CC In Process"); ?>
				</th>
				<th width="3%">
					<?php echo JText::_("CC Submitted"); ?>
				</th>	
			</tr>
        </thead>
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
				<!--
				<td>
					<?php echo JHTML::_('grid.id', $i, $row['id'] ); ?>
				</td>
				-->		
				<td><?php echo date('M d, Y',strtotime($row['create_date']));?></td>  
				<td><b><?php echo $row['specific_expert'];?></b></td>  
				<td>
					<?php
						echo strtoupper($row['success']);
					?>
				</td>				
				<td>
					<?php
						if(!empty($row['deadline'])):
							echo date('M d, Y',strtotime($row['deadline']));
						endif;
					?>
				</td>     		
				<td>
					<a href="index.php?option=com_survey&task=survey.surveyList&project_id=<?php echo $row['projectID'];?>"><?php echo $row['projectName']; ?></a>
				</td>
				
				 <td><?php  
				 			$getClaimNumber = SurveyModelOrder::getPatentList($row['projectID']);
				 			echo count($getClaimNumber);
				 	
				 	?></td>   
				<td><?php echo $row['description']; ?></td>
				 <td>
					<?php 
						$getQuestionaresPrepared = SurveyModelOrder::getQuestionaresPrepared($row['projectID']);
						
						echo (count($getQuestionaresPrepared)>0)?$getQuestionaresPrepared->countQuestionare:'';
					?>
				 </td>  
				 <td><?php 
					$getEmailSendData = SurveyModelOrder::getClaimsSendToExpert($row['projectID']);
					echo (count($getEmailSendData)>0)?$getEmailSendData->emailSend:'';					
					
					?></td>  
				 <td>
					<?php 
						$getCCInProcess = SurveyModelOrder::getCCInProcess($row['projectID']);
						if(count($getCCInProcess)>0){
							if($getCCInProcess->inProcess>0){
						?>
							<a href="<?php echo JRoute::_('index.php?option=com_survey&task=expert.inProcessReport&project_id='.$row['projectID'])?>"><?php echo $getCCInProcess->inProcess;?></a>
						<?php
							} else {
								echo $getCCInProcess->inProcess;
							}
					    }
					?>
				 </td>        
				 <td><?php 
					$getReportsData = SurveyModelOrder::getReportsCreatedByExpert($row['projectID']);
					
					echo count($getReportsData);
				 ?></td>          
				
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
		</table>
		<input type="hidden" name="option" value="com_survey" />
		<input type="hidden" name="task" value="question.list" />
		<input type="hidden" name="boxchecked" value="0" />
		<input type="hidden" name="hidemainmenu" value="0" />
		<input type="hidden" name="controller" value="question" />
		<input type="hidden" name="survey_id" value="<?php echo JRequest::getVar('survey_id','');?>" />
</form>
