<?php
// No direct access to this file
defined('_JEXEC') or die('Restricted access');
 
// Access check.
if (!JFactory::getUser()->authorise('core.manage', 'com_survey')) 
{
	return JError::raiseWarning(404, JText::_('JERROR_ALERTNOAUTHOR'));
}
 
// require helper file
JLoader::register('SurveyHelper', dirname(__FILE__) . DS . 'helpers' . DS . 'survey.php');
 
// import joomla controller library
jimport('joomla.application.component.controller');
 
// Get an instance of the controller prefixed by Survey
		
$doc = &JFactory::getDocument();

$doc->addScript('components/com_survey/js/jquery-1.4.2.min.js');
	
$doc->addScript('components/com_survey/js/jquery.noconflict.js');
?>
<?php	 	 
if(JRequest::getCmd('task')!="question.childData" && JRequest::getCmd('task')!="question.findExpertWithCode"):
?>
<link  href="components/com_survey/css/bootstrap.min.css" rel="stylesheet"/>
		<link  href="components/com_survey/css/bootstrap-responsive.min.css" rel="stylesheet"/>	
		<script src="components/com_survey/js/bootstrap.min.js"></script>
<?php	 	 endif;?>
		<?php	 	

if(JRequest::getCmd('task')=="" || JRequest::getCmd('task')=="cancel"):
	
?>
<table width="100%">
		<tr>
<?php	 	 endif;?>
		<?php	 	
$controller = JController::getInstance('Survey');
 
// Perform the Request task
$controller->execute(JRequest::getCmd('task'));
 
// Redirect if set by the controller
$controller->redirect();
?>


<?php	 	
if(JRequest::getCmd('task')==""):
?>
</td>
</tr>

	</table>
	<?php	 	 endif;?>
	<?php	 	 
		/*if(JRequest::getCmd('task')!="childData"):
	?>
	<table><tr><td><a href="http://www.avistechnologies.com">Powered By Avis Technologies</a></td></tr></table>
<?php	 	 endif; */?>