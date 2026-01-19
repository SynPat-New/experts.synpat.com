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

$rows = $this->getFeedbackData;
$total = count($rows);
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
					<?php echo JText::_("Claim"); ?>
				</th>
				<th>
					<?php echo JText::_("Feedback"); ?>
				</th>
				<th>
					<?php echo JText::_("Date"); ?>
				</th>				
				<th><?php echo JText::_("Rating"); ?></th>
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
					<?php echo JHTML::_('grid.id', $i, $row['id'] ); ?>
				</td>
				
				<td>
					
						<?php echo $row['combineName']; ?>
					
				</td>
				<td><?php echo $row['feedback']; ?></td>
				<td>
					<?php 
							echo date('M d, Y: H:i',strtotime($row['created_date']));
							
					?>
					
				</td>
				
				<td>
					
						<?php echo $row['rating']; ?>
					
				</td>				
			</tr>
			<?php
			$k = 1 - $k;
			$i ++;
		}
		?>

		<?php else:?>
			<tr>
				<td colspan="6">No Experts feedback.</td>
			</tr>
		<?php endif;?>
		</table>
		<input type="hidden" name="option" value="com_survey" />
		<input type="hidden" name="expert_id" value="<?php echo JRequest::getInt('id');?>" />
		<input type="hidden" name="task" value="" />
		<input type="hidden" name="boxchecked" value="0" />
		<input type="hidden" name="hidemainmenu" value="0" />
		<input type="hidden" name="controller" value="expert" />
</form>
