<?php
// No direct access to this file
defined('_JEXEC') or die('Restricted access');
 
// import Joomla view library
jimport('joomla.application.component.view');
 
/**
 * HTML View class for the HelloWorld Component
 */
class SurveyViewProject extends JView
{
	// Overwriting JView display method
	function display($tpl = null) 
	{
		// Display the view
		parent::display($tpl);
	}
	
	function projectlist($tpl=null)
	{	
		$session = JFactory::getSession();
		$getSession = $session->get('expertSession','');
		if(empty($getSession)){
			$app = JFactory::getApplication();
			$app->redirect('index.php?option=com_survey&task=survey.login','Please select area of expertise.','notice');
		}
		$getAreaOfExpertise = $this->getModel()->getExpertAreaOfExpertise($getSession->id);
		
		if(count($getAreaOfExpertise)==0){
			$app = JFactory::getApplication();
			$app->redirect('index.php?option=com_survey&task=customer.expertProfile&show=1&display='.$getSession->id);
		} 
		$projectList =& $this->get('Items');
		$pagination = & $this->get( 'Pagination' );	
		$this->assignRef('projectList', $projectList);
		$this->assignRef('pagination', $pagination);
		$this->assignRef('expert_id',$getSession->id);
		parent::display($tpl);
	}
	
	function login($tpl=null)
	{
		parent::display($tpl);	
	}
}
