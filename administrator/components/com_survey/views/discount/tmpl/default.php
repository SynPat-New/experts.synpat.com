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
					<?php echo JText::_("Name"); ?>
				</th>
				<th width="6%">
					<?php echo JText::_("Coupon Code"); ?>
				</th>
				<th width="5%">
					<?php echo JText::_("Discount"); ?>
				</th>
				<th width="5%">
					<?php echo JText::_("Start Date"); ?>
				</th>
				
				<th width="3%">
					<?php echo JText::_("End Date"); ?>
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
				<td>
					<?php echo $row['name'];?>
				</td>
				<td>
					<?php echo $row['coupon_code'];?>
				</td>
				<td>
					<?php echo $row['discount'];?>
				</td>
				<td>
					<?php echo $row['start_date'];?>
				</td>
				<td>
					<?php echo $row['end_date'];?>
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
		</table>
		<input type="hidden" name="option" value="com_survey" />
		<input type="hidden" name="task" value="discount.list" />
		<input type="hidden" name="boxchecked" value="0" />
		<input type="hidden" name="hidemainmenu" value="0" />
		<input type="hidden" name="controller" value="discount" />
		<input type="hidden" name="survey_id" value="<?php echo JRequest::getVar('survey_id','');?>" />
</form>
