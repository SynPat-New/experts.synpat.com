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
JHTML::_('behavior.tooltip');
$siteURL = JURI::root();
//$parameter =base64_encode(JRequest::getVar('name')."@".JRequest::getVar('id'));
//$generateURL = $siteURL."index.php?option=com_survey&task=survey.surveylist&ps=".$parameter;
$getProjectList = $this->getProjectList();
?>
<h1>Expert URL</h1>
<input type="text" name="showURL" id="showURL"  style="display:block;width:400px;height:40px;"/>
<ul>
	<?php 
		if(count($getProjectList)>0):
	?>
		<?php 
			for($i=0;$i<count($getProjectList);$i++){
		?>
			<li><a href="javascript://" onclick="generateUrl('<?php echo $siteURL."index.php?option=com_survey&task=survey.surveylist&ps=".base64_encode($getProjectList[$i]->name."@".$getProjectList[$i]->id."@".JRequest::getVar('id'));?>')"><?php echo $getProjectList[$i]->name;?></a></li>
		<?php
			}
		?>
	<?php
		else:
	?>
		<li>No Project Found.</li>
	<?php
		endif;
	?>
</ul>
<script>
function generateUrl(getURL){
document.getElementById('showURL').value = getURL;
}
</script>
