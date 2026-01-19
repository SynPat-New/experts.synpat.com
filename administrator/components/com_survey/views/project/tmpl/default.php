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
?>
<script language="javascript" type="text/javascript">        
	jQuery(function() {
		var w = 745,
			h = 430; 	
		set_modal('.modal2', w, h);		
	});
</script>
<form action="index.php" method="post" name="adminForm">	
	<table class="adminlist1 table table-bordered table-striped">
    	<thead>
			<tr>
				<th>
					#
				</th>
				<th>
					<input type="checkbox" name="toggle" value="" onClick="checkAll(<?php echo count($rows); ?>);" />
				</th>
				<th>
					<?php echo JText::_("PROJECT_NAME"); ?>
				</th>
				<th>
					<?php echo JText::_("PROJECT_DESCRIPTION"); ?>
				</th>
				<th>
					<?php echo JText::_("PROJECT_IMAGE"); ?>
				</th>
				<th>
					<?php echo JText::_("PROJECT_SURVEY_LIST"); ?>
				</th>
				<th>
					<?php echo JText::_("PROJECT_ID"); ?>
				</th>
							
			</tr>
        </thead>
		<?php
		$k = 0;		
		$i = 0;
		$n = count($rows);
		if($n>0):
		foreach($rows as $key=>$row) {		
			$link 	= 'index.php?option=com_survey&task=project.edit&id='.$row['id'].'&hidemainmenu=1';
		?>
			<tr class="<?php echo "row$k"; ?>">
				<td>
					<?php echo $i+1+$pageNav->limitstart;?>
				</td>
				<td>
					<?php echo JHTML::_('grid.id', $i, $row['id'] ); ?>
				</td>
				<td>
					<a class="a_guru" href="<?php echo $link; ?>">
						<?php echo $row['name']; ?>
					</a>
				</td>
				<td>
					<?php echo substr($row['description'],0,100)."..."; ?>
				</td>
				<td align="center">
					<a href="javascript: void(0);">
						<img src="<?php echo JURI::base(); ?>../<?php echo substr($row['project_image'],2);?>" width="100" height="100" border="0"  />
					</a>
				</td>  
				<td align="right">
					<a href="index.php?option=com_survey&task=survey.surveyList&project_id=<?php echo $row['id']; ?>"><?php echo JText::_("SURVEY_LIST"); ?></a>
				</td>             
				<td align="right">
					<?php echo $row['id']; ?>
				</td>
				
			</tr>
			<?php
			$k = 1 - $k;
			$i ++;
		}
		?>
        	<tr>
            	<td colspan="14" align="center">
					<style>					.container{width:auto;}					.container .pagination{float:left;}				</style>
					<?php echo $this->pagination->getListFooter(); ?>
                </td>
            </tr>
		<?php else:?>
			<tr>
				<td colspan="7">No project added.</td>
			</tr>
		<?php endif;?>
		</table>
		<input type="hidden" name="option" value="com_survey" />
		<input type="hidden" name="task" value="project.list" />
		<input type="hidden" name="boxchecked" value="0" />
		<input type="hidden" name="hidemainmenu" value="0" />
		<input type="hidden" name="controller" value="project" />
</form>
