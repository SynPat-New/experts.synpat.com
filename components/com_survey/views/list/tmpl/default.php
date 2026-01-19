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
?>
<form action="index.php" method="post" name="adminForm">	
	<table class="adminlist">
    	<thead>
			<tr>
				<th width="2%">
					#
				</th>
				<th width="15%">
					<?php echo JText::_("SURVEY_NAME"); ?>
				</th>
				<th width="10%">
					<?php echo JText::_("PROJECT_NAME"); ?>
				</th>
				<th width="6%">
					<?php echo JText::_("SURVEY_DESCRIPTION"); ?>
				</th>
				<th width="6%">
					<?php echo JText::_("SURVEY_IMAGE"); ?>
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
						<?php echo $row['name']; ?>					
				</td>
				<td>
					<?php echo $row['project_name']; ?>
					
				</td>
				<td>
					<?php echo $row['description']; ?>
				</td>
				<td align="center">					
						<img src="<?php echo JURI::base(); ?>../<?php echo substr($row['image'],2);?>" width="100" height="100" border="0"  />
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
		<input type="hidden" name="controller" value="survey" />
</form>