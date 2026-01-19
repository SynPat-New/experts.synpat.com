<?php
/**
 * @copyright   (C) 2010 iJoomla, Inc. - All rights reserved.
 * @license  GNU General Public License, version 2 (http://www.gnu.org/licenses/gpl-2.0.html)
 * @author  avistechnologies.com <avistcengg@gmail.com>
 * @url   http://www.ijoomla.com/licensing/
 * the PHP code portions are distributed under the GPL license. If not otherwise stated, all images, manuals, cascading style sheets, and included JavaScript  *are NOT GPL, and are released under the IJOOMLA Proprietary Use License v1.0 
 * More info at http://www.ijoomla.com/licensing/
*/
defined ('_JEXEC') or die ("Go away.");

jimport ("joomla.application.component.view");

class SurveyViewSurvey extends JView {

	function display ($tpl = null){
		JToolBarHelper::title('&nbsp;', 'generic.png');
		$this->status_message = $this->get("CoponentStatus");
		parent::display($tpl);
	}
	function listform($tpl=null){
		JToolBarHelper::title(JText::_( 'Claim List'));
		/*JToolBarHelper::addNew('survey.new');
		JToolBarHelper::editList('survey.edit');
		JToolBarHelper::deleteList('Are you sure you want to delete survey','survey.delete');*/
		JToolBarHelper::cancel();		
		$surveyList =& $this->get('Items');
		$pagination = & $this->get( 'Pagination' );	
		$this->assignRef('surveyList', $surveyList);
		$this->assignRef('pagination', $pagination);		
		parent::display($tpl);
	
	}
	function editform($tpl = null){
		$id = JRequest::getVar("id", "0");
		if($id == "0"){
			JToolBarHelper::title(JText::_('SURVEY_SURVEYY').":<small>[".trim(JText::_("SURVEY_NEW"))."]</small>");
		}
		else{
			JToolBarHelper::title(JText::_('SURVEY_SURVEYY').":<small>[".trim(JText::_("SURVEY_EDIT"))."]</small>");
		}		
		JToolBarHelper::save('survey.save');
		JToolBarHelper::apply('survey.apply');
		JToolBarHelper::cancel('survey.cancelSurvey');	
		$projectList = & $this->get('ProjectList');
		$this->assignRef("projectList",$projectList);
		$user = & $this->get('SurveyDetails');
		$this->assignRef("user",$user);
		parent::display($tpl);
	}
	
	function answer($tpl=null){
		$id = JRequest::getVar("id", "0");
		JToolBarHelper::title(JText::_('SURVEY_ANSWER_BY_EXPERT'));
		JToolBarHelper::save('survey.saveanswer');
		JToolBarHelper::cancel('survey.cancelAnswer');
		$model = $this->getModel();	
		$surveyID = JRequest::getVar('survey_id');
		$expertID = JRequest::getVar('expert_id');
		$getAnsList = $model->answerList($surveyID,$expertID);
		$this->assignRef("ansList",$getAnsList);
		parent::display($tpl);
	}
	
	function getQuestionList($surveyID){
		$model = $this->getModel();
		return $model->getQuestionList($surveyID);
	}
	
	function getExpertListBySurveyAns($surveyID){
		$model = $this->getModel();
		return $model->getExpertListBySurveyAns($surveyID);
	}
	
	function emailSuccess($tpl=null){
		JToolBarHelper::cancel();
		parent::display($tpl);
	}
}

?>
