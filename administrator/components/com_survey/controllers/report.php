<?php
// No direct access to this file
defined('_JEXEC') or die('Restricted access');
 
// import Joomla controllerform library
jimport('joomla.application.component.controllerform');
 
/**
 * HelloWorld Controller
 */
class SurveyControllerReport extends JControllerForm{
	var $_model = null;
	
	function __construct () {
		parent::__construct();
		$this->registerTask ("list", "ReportList");
		$this->registerTask ("", "ReportList");	
		$this->_model =& $this->getModel("report");

	}
	function ReportList() {		
		JRequest::setVar ("view", "report");
		$view = $this->getView("report", "html");
		$view->setModel($this->_model, true);
		parent::display();
	}
	function cancel(){
		$app = JFactory::getApplication('administrator');
		$app->redirect('index.php?option=com_survey&task=');
	}
	function viewreport(){
		JRequest::setVar ("view", "report");
		$view = $this->getView("report", "html");
		$view->setLayout('viewreport');
		$view->setModel($this->_model, true);
		$view->viewreport();
	}
	
}
