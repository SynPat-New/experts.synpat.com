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
$doc = &JFactory::getDocument();
$expertID = $this->expert_id;
?>
<dl class="article-info clearfix">
			<dd class="active category-name"><a href="<?php echo JRoute::_('index.php?option=com_survey&task=customer.expertProfile&display='.$expertID)?>">Profile</a></dd>
			<dd class="published"><a href="<?php echo JRoute::_('index.php?option=com_survey&task=customer.expertFeedback&display='.$expertID)?>">Feedback</a></dd>
			<dd class="createdby"><a href="<?php echo JRoute::_('index.php?option=com_survey&task=customer.expertReport&display='.$expertID)?>">My Report</a></dd>
			<dd class="createdby"><a href="<?php echo JRoute::_('index.php?option=com_survey&task=customer.expertProcess&display='.$expertID)?>">In Process</a></dd>
			<?php if($expertID>0):?>
			<dd class="createdby"><a href="<?php echo JRoute::_('index.php?option=com_survey&task=customer.expertOpportunites&display='.$expertID)?>" >Opportunities</a></dd>
			<dd class="createdby"><a href="<?php echo JRoute::_('index.php?option=com_survey&task=customer.expertArea&display='.$expertID)?>" >My Experties</a></dd>
			<?php endif;?>
		</dl>

<form action="index.php" method="post" name="adminForm">	
	<table class="table table-striped table-bordered arial table-hover">
    	<thead>
			<tr>
				<th>
					#
				</th>
				<th>
					<?php echo JText::_("Combine Name"); ?>
				</th>
				<th>
					<?php echo JText::_("Project Name"); ?>
				</th>
				<!--
				<th>
					<?php echo JText::_("Description"); ?>
				</th>	-->				
				<th>
					<?php echo JText::_("Action"); ?>
				</th>				
			</tr>
        </thead>
		<?php
		$k = 0;		
		$i = 0;
		$n = count($rows);
		$project_id = 0;
		$projectName = "";

		if($n>0):

		foreach($rows as $key=>$row) {
				if($i==0){
					$project_id = $row['projectID'];	
					$projectName = $row['project_name'];	
				}
		?>
			<tr class="<?php echo "row$k"; ?>">
				<td>
					<?php echo $i+1+$pageNav->limitstart;?>
				</td>
				<td>					
						<?php echo $row['combine_name']; ?>					
				</td>
				<td>
					<?php echo $row['project_name']; ?>
					
				</td>
				<!--
				<td>
					<?php echo $row['description']; ?>
				</td>
				-->
				<td align="center">					
						<a class='btn btn-flat' href="<?php echo JUri::base();?>index.php?option=com_survey&view=answer&param=<?php echo base64_encode($row['name'].'@'.$row['id'].'@'.$expertID);?>">Answer Questions</a>
				</td>
			</tr>
		<?php
			$k = 1 - $k;
			$i ++;
		}
		?>
		<tr>
            	<td colspan="14" align="center">
					<?php echo $this->pagination->getListFooter(); ?>
                </td>
            </tr>
		<?php else:?>
			<tr>
				<td colspan="8">No survey added in this project.</td>
			</tr>
		<?php endif;?>
		</table>
		<input type="hidden" name="option" value="com_survey" />
		<input type="hidden" name="task" value="survey.surveylist" />
		<input type="hidden" name="boxchecked" value="0" />
		<input type="hidden" name="hidemainmenu" value="0" />
		<input type="hidden" name="controller" value="survey" />
		<input type="hidden" name="project_id" value="<?php echo $project_id?>" />
		<input type="hidden" name="ps" value="<?php echo base64_encode($projectName."@".$project_id."@".$expertID);?>" />
</form>
