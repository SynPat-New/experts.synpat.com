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
$getList = $this->getReport;
?>

<form action="index.php" method="post" name="adminForm" enctype="multipart/form-data">	
	
	<table class="adminform">
		<?php 
			if(count($getList)>0):
				for($i=0;$i<count($getList);$i++){
		?>
				<tr>
					<td>
						Ques:-<b>
						<?php 
							echo $getList[$i]['description'];
						?></b>
					</td>
				</tr>
				<tr>
					<td> Ans:-
						<?php 
							echo $getList[$i]['answer'];
						?>
						<?php 
							if($getList[$i]['supporting_document']!=""){
								echo "<br/> Supporting Document:- ".$getList[$i]['supporting_document'];
							}
						?>
					</td>
				</tr>
		<?php
			}
		?>
		
		<?php endif;?>
	</table>
		<input type="hidden" name="option" value="com_survey" />
		<input type="hidden" name="task" value="" />
		<input type="hidden" name="hidemainmenu" value="0" />
		<input type="hidden" name="controller" value="question" />
        <input type="hidden" name="this_form" value="true" />
</form>
