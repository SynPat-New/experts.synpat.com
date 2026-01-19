<?php
// No direct access to this file
defined('_JEXEC') or die('Restricted access'); 
// import Joomla controller library
jimport('joomla.application.component.controller');
 
/**
 * General Controller of Survey component
 */
class SurveyController extends JController
{
	/**
	 * display task
	 *
	 * @return void
	 */

	function __construct() {
		parent::__construct();
		$document =& JFactory::getDocument();
		$document->addScript("components/com_survey/js/dtree.js");
		$document->addStyleSheet("components/com_survey/css/dtree.css");
		$document->addStyleSheet("components/com_survey/css/general.css");
		$layout = JRequest::getVar('layout');
		if($layout!="surveylist"):
	?>
		<td valign="top" width="15%" rowspan="3">
		<span style="float:left;display:inline;background-color:white;" class="navtreewrap">
			<?php	 	 
				$view = $this->getView('surveyDtree', 'html');
				$view->showDtree();
			?>
		</span>
		</td>
				<td class="mainwrap" valign="top">
	<?php	 	
		
		endif;
	}
	function display($cachable = false) 
	{
		// set default view if not set
		/*
		JRequest::setVar('view', JRequest::getCmd('view', 'HelloWorlds'));
		*/
		// call parent behavior
		parent::display($cachable);
 
		// Set the submenu
		/*HelloWorldHelper::addSubmenu('messages');*/
	}
}
