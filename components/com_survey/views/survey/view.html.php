<?php
// No direct access to this file
defined('_JEXEC') or die('Restricted access');
 
// import Joomla view library
jimport('joomla.application.component.view');
 
/**
 * HTML View class for the HelloWorld Component
 */
class SurveyViewSurvey extends JView
{
	// Overwriting JView display method
	function display($tpl = null) 
	{
		// Display the view
		parent::display($tpl);
	}
	
	function listform($tpl=null)
	{		
		$getSession = JFactory::getUser();
		$sessionEXpertID = 0;
		if ($getSession->id > 0) {
			$getExpertData = $this->getModel()->expertUserData($getSession->id);
			$sessionEXpertID = $getExpertData->id;
		}
		if($sessionEXpertID==0){
			$app = JFactory::getApplication();
			$re = JRequest::getVar('ps');
			$app->redirect('index.php?option=com_survey&task=survey.login&re='.$re);
		}
		$surveyList =& $this->get('Items');
		$pagination = & $this->get( 'Pagination' );	
		$this->assignRef('surveyList', $surveyList);
		$this->assignRef('pagination', $pagination);
		$this->assignRef('expert_id',$sessionEXpertID);
		parent::display($tpl);
	}
	
	function login($tpl=null)
	{
		parent::display($tpl);	
	}
	
	function register($tpl=null)
	{
		parent::display($tpl);	
	}
}
