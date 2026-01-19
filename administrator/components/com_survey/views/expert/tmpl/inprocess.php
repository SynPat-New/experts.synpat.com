<?php
/**
 * @copyright   (C) 2010 iJoomla, Inc. - All rights reserved.
 * @license  GNU General Public License, version 2 (http://www.gnu.org/licenses/gpl-2.0.html)
 * @author  avistechnologies.com <avitcengg@gmail.com>
 * @url   http://www.avistechnologies.com/licensing/
 * the PHP code portions are distributed under the GPL license. If not otherwise stated, all images, manuals, cascading style sheets, and included JavaScript  *are NOT GPL, and are released under the IJOOMLA Proprietary Use License v1.0 
 * More info at http://www.avistechnologies.com/licensing/
*/
defined ('_JEXEC') or die ("Go away.");

$rows = $this->inprocess;

?>

<form action="index.php" method="post" name="adminForm">	
	<table class="adminlist1 table table-bordered table-striped">
    	<thead>
			<tr>
				<th width="1%">
					#
				</th>
				<th>
					<?php echo JText::_("Claim No"); ?>
				</th>
				<th>
					<?php echo JText::_("Target"); ?>
				</th>
				<th>
					<?php echo JText::_("Expert"); ?>
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
					<?php echo $i+1;?>
				</td>
				<td>
					<?php echo $row['combineName']; ?>
				</td>
				<td><?php echo $row['target']; ?></td>
				<td>
					<a href="<?php echo JRoute::_('index.php?option=com_survey&task=expert.sendMessage&expert_id='.$row['expertID']);?>"><?php echo $row['name']; ?></a>
				</td>				
			</tr>
			<?php
			$k = 1 - $k;
			$i ++;
		}
		?>
		<?php else:?>
			<tr>
				<td colspan="6">No in process report.</td>
			</tr>
		<?php endif;?>
		</table>
		<input type="hidden" name="option" value="com_survey" />
		<input type="hidden" name="project_id" value="<?php echo JRequest::getInt('project_id');?>" />
		<input type="hidden" name="task" value="" />
		<input type="hidden" name="boxchecked" value="0" />
		<input type="hidden" name="hidemainmenu" value="0" />
		<input type="hidden" name="controller" value="expert" />
</form>
