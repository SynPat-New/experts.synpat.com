<?php
// No direct access to this file
defined('_JEXEC') or die('Restricted access');
 
// import Joomla view library
jimport('joomla.application.component.view');
 
/**
 * HTML View class for the HelloWorld Component
 */
class SurveyViewAnswer extends JView
{
	// Overwriting JView display method
	function display($tpl = null) 
	{
		/*Check Expert Session*/
		$user = JFactory::getUser();
		$app	= JFactory::getApplication();
		if($user->id==0){
			$app->redirect('index.php/profile');
			exit;
		}
		/*End Checking expert Session*/
		// Assign data to the view
		$this->item = $this->get('Item');
 		// Check for errors.
 		if(JRequest::getVar('layout')!='thanks' && JRequest::getVar('layout')!='fail'){
 			if (count($errors = $this->get('Errors'))) 
			{
				JError::raiseError(500, implode('<br />', $errors));
				return false;
			}
			$getPrams = JRequest::getVar('param');
			$decodePrams = explode('@',base64_decode($getPrams));
			$getSession = SurveyModelAnswer::expertUserData($user->id);
			if(count($getSession)>0 && (int)$decodePrams[2] == $getSession->id){
				$expertID = (int)$decodePrams[2];	
				$getPaypalData= $this->getExpertPaypalData($expertID);
				$surveyData = $this->surveyData((int)$decodePrams[1]);
				if($surveyData->report_type==2){
					$surveyAmtData= $this->surveyAmtData($expertID,(int)$decodePrams[1], JRequest::getVar('target'), JRequest::getVar('target_product'));
				} else {
					$surveyAmtData= $this->surveyAmtDataPrior($expertID,(int)$decodePrams[1]);
				}
				$projectData = $this->getModel()->getProjectDetailFromSurvey($surveyData->id);
				$this->assignRef('surveyData',$surveyData);
				$this->assignRef('projectData',$projectData);
				$this->assignRef('expert',$expertID);
				$this->assignRef('paypalData',$getPaypalData);
				$this->assignRef('surveyAmtData',$surveyAmtData);
			} else {
				$app->redirect('index.php/profile');
				exit;
			}			
 		}
		
		// Display the view
		parent::display($tpl);
	}
	
	function getExpertPaypalData($expertID){
		$model = $this->getModel();
		return $model->getExpertPaypalData($expertID);
	}
	
	function surveyData($surveyID){
		$model = $this->getModel();
		return $model->surveyData($surveyID);
	}
	
	function surveyAmtData($expertID,$surveyID,$target,$targetProduct){
		$model = $this->getModel();
		return $model->surveyAmtData($expertID,$surveyID,$target,$targetProduct);
	}
	
	function surveyAmtDataPrior($expertID,$surveyID){
		$model = $this->getModel();
		return $model->surveyAmtDataPrior($expertID,$surveyID);
	}
	
	function expertAnsQues($questionID,$expertID,$target,$targetProduct){
		$model = $this->getModel();
		return $model->expertAnsQues($questionID,$expertID,$target,$targetProduct);
	}
	function expertAnsQuesPrior($questionID,$expertID){
		$model = $this->getModel();
		return $model->expertAnsQuesPrior($questionID,$expertID);
	}
}
