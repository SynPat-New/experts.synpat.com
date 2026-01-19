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

$rows = $this->ansList;
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
    	<?php
		$k = 0;		
		$i = 1;
		$n = count($rows);
		$answer = "";
		if($n>0):
		foreach($rows as $key=>$row) {		
			$answer .= $row->answerID.",";
		?>
			<tr class="<?php echo "row$k"; ?>">
				<td>Q No <?php echo $i;?>:- <?php echo $row->description;?></td>
			</tr>
			<tr class="<?php echo "row$k"; ?>">
				<td>Ans:- <?php echo $i;?>:- <?php echo $row->answer;?>
				<table>
					<tr>
						<td>
							<label>Publish</label>
							<input type="checkbox" name="answer_pub_<?php echo $row->answerID;?>" value="0" <?php if($row->publish==0):?> CHECKED="CHECKED" <?php endif;?>/>
							<?php
								if($row->supporting_document!=""):
							?>
							<label>Supporting Document</label>
							<a target="_BLANK" href="<?php echo JUri::root().$row->supporting_document; ?>"><?php echo $row->supporting_document; ?></a>
							<?php endif;?>
						</td>
					</tr>
				</table>
				</td>
			</tr>
			<?php
			$k = 1 - $k;
			$i ++;
		}
		$answer = substr($answer,0,-1);
		?>
        	
		<?php else:?>
			<tr>
				<td colspan="8">No survey added in this project.</td>
			</tr>
		<?php endif;?>
		</table>
		<input type="hidden" name="option" value="com_survey" />
		<input type="hidden" name="task" value="" />
		<input type="hidden" name="boxchecked" value="0" />
		<input type="hidden" name="hidemainmenu" value="0" />
		<input type="hidden" name="answer" value="<?php echo $answer;?>" />
		<input type="hidden" name="survey_id" value="<?php echo JRequest::getVar('survey_id','');?>"/>
		<input type="hidden" name="expert_id" value="<?php echo JRequest::getVar('expert_id','');?>"/>
		<input type="hidden" name="controller" value="survey" />
</form>
