<?php
// No direct access to this file
defined('_JEXEC') or die('Restricted access');
 
// import Joomla view library
jimport('joomla.application.component.view');
 
/**
 * HTML View class for the HelloWorld Component
 */
class SurveyViewList extends JView
{
	// Overwriting JView display method
	function display($tpl = null) 
	{
		$expertSession = JFactory::getSession();
		$sessionExpert = $expertSession->get('sessionExpert','');
		if(empty($sessionExpert)){
			$getParameter = JRequest::getVar('ps');
			if($getParameter!=""){
				$getPValues = explode('@',base64_decode(JRequest::getVar('ps')));
				if(count($getPValues)==2 && (int)$getPValues[1]!=0){
					/* Check Expert exist*/
						$model = $this->getModel();
						$checkData = $model->checkExperExist((int)$getPValues[1]);
						if(count($checkData)>0){
							$experSession->set('sessionExpert',$getPValues[1]);
						} else {
							JError::raiseError(500, implode('<br />', $errors));
							return false;
						}
					/* End check*/
				} else {
					JError::raiseError(500, implode('<br />', $errors));
					return false;
				}
			} else {
				JError::raiseError(500, implode('<br />', $errors));
				return false;
			}
		}		
		// Display the view
		parent::display($tpl);
	}
	
	function listform(){
		$expertSession = JFactory::getSession();
		$sessionExpert = $expertSession->get('sessionExpert','');
		if(!empty($sessionExpert)){
			$surveyList =& $this->get('Items');
			$pagination = & $this->get( 'Pagination' );		
			$this->assignRef('surveyList', $surveyList);
			$this->assignRef('pagination', $pagination);
		} else {
			JError::raiseError(500, implode('<br />', $errors));
			return false;
		}
		
	
	}
}
