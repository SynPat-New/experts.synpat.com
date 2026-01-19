<?php

// No direct access.
defined('_JEXEC') or die;

// Include dependancy of the main controllerform class
jimport('joomla.application.component.controllerform');

class SurveyControllerProject extends JControllerForm
{

	public function getModel($name = 'Project', $prefix = 'SurveyModel', $config = array('ignore_request' => true))
	{
		return parent::getModel($name, $prefix, array('ignore_request' => false));
	}
	
	public function projectList(){
		$this->checkSession();
		JRequest::setVar('view','project');
		$view = $this->getView("project", "html");
		$view->setLayout("default");
		$view->setModel($this->getModel(), true);
		$view->projectlist();
	}

	public function checkSession(){
		$session = JFactory::getSession();
		$getSession = $session->get('expertSession','');
		if(empty($getSession)){
			$app = JFactory::getApplication();
			$app->redirect('index.php?option=com_survey&task=survey.login');
			jexit;
		}
	}
	/*
	public function submit()
	{
		// Check for request forgeries.
		JRequest::checkToken() or jexit(JText::_('JINVALID_TOKEN'));

		// Initialise variables.
		$app	= JFactory::getApplication();
		$model	= $this->getModel('updhelloworld');

		// Get the data from the form POST
		$data = JRequest::getVar('jform', array(), 'post', 'array');

        // Now update the loaded data to the database via a function in the model
        $upditem	= $model->updItem($data);

    	// check if ok and display appropriate message.  This can also have a redirect if desired.
        if ($upditem) {
            echo "<h2>Updated Greeting has been saved</h2>";
        } else {
            echo "<h2>Updated Greeting failed to be saved</h2>";
        }

		return true;
	}
	*/
}
