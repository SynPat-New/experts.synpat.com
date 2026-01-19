<?php
// No direct access to this file
defined('_JEXEC') or die('Restricted access');

$notification = $this->notification; 
$expertID = $this->expertID; 
$doc = JFactory::getDocument();
$doc->addScript('components/com_survey/js/jquery-1.4.2.min.js');
$doc->addScript('components/com_survey/js/jquery.noconflict.js');
?>
<div class="row-fluid">
	<div class="span12 arial">
		<h1>Notifications</h1>
		<?php 
			if(count($notification)>0){
		?>
				<ul class="nav">
					<?php 
						for($i=0;$i<count($notification);$i++){
					?>
						<li style="border-bottom: 1px solid #C0C1C1;height:15px;">
							
							<a style="color:#0093F0;float:left; width:auto;" href="<?php echo JRoute::_('index.php?option=com_survey&task=survey.surveylist&ps='.base64_encode($notification[$i]->projectName.'@'.$notification[$i]->pID.'@'.$expertID));?>"><?php echo $notification[$i]->projectName;?></a>
							<span style="float:right">
								<?php echo date('M d',strtotime($notification[$i]->created_date));?>
							</span>
						</li>
					<?php
						}
					?>
				</ul>
		<?php	
			}
		?>
	</div>
</div>

