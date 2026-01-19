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

$getData = SurveyModelSurvey::surveyEmailExpertList(JRequest::getInt('survey_id'),JRequest::getInt('status'));
if(count($getData)>0){
JToolBarHelper::title(JText::_($getData->name .'(Success Send Email Expert List)'));
}

?>
	<table id="resultTable" class="adminlist1 table table-bordered table-striped">
    	<thead>
			<tr>
				<th width="5%">
					#
				</th>
				<th >
					<?php echo JText::_("Experts"); ?>
				</th>
						
			</tr>
        </thead>
		<?php
		$k = 0;		
		$i = 0;
		$n = count($getData);
		if($n>0):
		foreach($getData as $key=>$row) {		
			$k = $k+ 1;
		?>
			<tr class="<?php //echo "row$k"; ?>">
				<td>
					<?php echo $k;?>
				</td>
				<td>
					<?php echo $row['name']." (".$row['email'].") "; ?>
				</td>
				
			</tr>
			<?php
		}
		?>        	
		<?php else:?>
			<tr>
				<td colspan="8">No Expert found.</td>
			</tr>
		<?php endif;?>
		</table>
		<input type="hidden" name="option" value="com_survey" />
		<input type="hidden" name="task" value="" />
		<input type="hidden" name="boxchecked" value="0" />
		<input type="hidden" name="hidemainmenu" value="0" />
		<input type="hidden" name="survey_id" value="<?php echo JRequest::getVar('survey_id','');?>"/>
		<input type="hidden" name="controller" value="survey" />
</form>
