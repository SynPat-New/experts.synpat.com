<?php
// No direct access to this file
defined('_JEXEC') or die('Restricted access');
 
// import Joomla view library
jimport('joomla.application.component.view');
 
/**
 * HTML View class for the HelloWorld Component
 */
class SurveyViewFeedback extends JView
{
	// Overwriting JView display method
	function display($tpl = null) 
	{
		// Assign data to the view
		$getRawID = JRequest::getVar('display','');
		$this->assignRef('stringData',$getRawID);
		if(!empty($getRawID)){
			$getData = $this->getModel()->expertSurveyExist($getRawID);
			$this->assignRef('rating',$getData);
		}
		// Display the view
		parent::display($tpl);
	}
	
}
