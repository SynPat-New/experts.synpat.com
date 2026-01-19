<?php
// No direct access to this file
defined('_JEXEC') or die('Restricted access');
 
// import Joomla controllerform library
jimport('joomla.application.component.controllerform');
 
/**
 * HelloWorld Controller
 */
class SurveyControllerPaypal extends JControllerForm{
	var $_model = null;
	
	function __construct () {
		parent::__construct();
		$this->registerTask ("", "Setting");
		$this->registerTask ("setting", "Setting");
		$this->_model =& $this->getModel("paypal");

	}
	function Setting() {		
		JRequest::setVar ("view", "paypal");
		$view = $this->getView("paypal", "html");		
		$view->setModel($this->_model, true);
		parent::display();
	}
	
	function save(){
		$app = JFactory::getApplication('administrator');
		$data = JRequest::get('post');	
		if($this->_model->save($data)){
			$msg = JText::_( 'Paypal Settings Saved' );
			$this->setRedirect( 'index.php?option=com_survey', $msg,'success' );
		}
		else{
			$msg = JText::_('Unable to save paypal settings');
			$this->setRedirect( 'index.php?option=com_survey', $msg,'error' );
		}
		
	}
	
	function cancel(){
		$app = JFactory::getApplication('administrator');
		$app->redirect('index.php?option=com_survey&task=');
	}
	
}
