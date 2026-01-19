<?php

defined ('_JEXEC') or die ("Go away.");

jimport ("joomla.application.component.view");

class SurveyViewQuestion extends JView {
	
	function display ($tpl =  null ){			
		JToolBarHelper::title(JText::_( 'SURVEY_QUESTION_LIST'));
		JToolBarHelper::addNew('question.new','Start/Edit Questionare');
		/*
		JToolBarHelper::editList('question.edit');
		JToolBarHelper::deleteList('Are you sure want to delete question','question.delete');
		*/
		JToolBarHelper::cancel();		
		$projectList =& $this->get('Items');
		$surveyID = JRequest::getInt('survey_id');
		$pagination = & $this->get( 'Pagination' );	
		if(count($projectList)>0){
			JToolBarHelper::custom( 'question.sendEmail', 'send', 'send', 'Send Questionnaire to Expert', false );
		}	
		$this->assignRef('surveyID', $surveyID);
		$this->assignRef('authorList', $projectList);
		$this->assignRef('pagination', $pagination);		
		parent::display($tpl);

	}
	
	function settypeform($tpl = null){
		$id = JRequest::getVar("id", "0");
		if($id == "0"){
			JToolBarHelper::title(JText::_('SURVEY_QUESTION').":<small>[".trim(JText::_("SURVEY_NEW"))."]</small>");
		}
		else{
			JToolBarHelper::title(JText::_('SURVEY_QUESTION').":<small>[".trim(JText::_("SURVEY_EDIT"))."]</small>");
		}
		JToolBarHelper::custom('next','forward.png','forward_f2.png','Next',false);
		JToolBarHelper::cancel();
		parent::display($tpl);
	}
	
	function editform($tpl = null){
		/*
		$id = JRequest::getVar("id", "0");
		if($id == "0"){
			JToolBarHelper::title(JText::_('SURVEY_QUESTION').":<small>[".trim(JText::_("SURVEY_NEW"))."]</small>");
		}
		else{
			JToolBarHelper::title(JText::_('SURVEY_QUESTION').":<small>[".trim(JText::_("SURVEY_EDIT"))."]</small>");
		}
		*/
		$surveyID = JRequest::getVar("survey_id", "0");
		
		JToolBarHelper::title(JText::_('SURVEY_QUESTION'));
		JToolBarHelper::save('question.save');
		JToolBarHelper::apply('question.apply');
		JToolBarHelper::cancel('question.cancelquestion');	
		$surveyData = & $this->getModel()->getSurveyData($surveyID);
		$this->assignRef("surveyData",$surveyData);
		if($surveyID>0){
			$getQuestionList = $this->getModel()->getQuestionUpdateList($surveyID);
		} else {
			$getData = $this->getModel()->getQuestionDetails();
			if(count($getData)>0){
				$surveyID = $getData->survey_id;
				$getQuestionList = $this->getModel()->getQuestionUpdateList($surveyID);
			}
		}
		$getAreaExpertise = $this->getModel()->getAreaExpertise();
		$this->assignRef("questionList",$getQuestionList);
		$this->assignRef("getExpertise",$getAreaExpertise);
		$this->assignRef("surveyID",$surveyID);
		parent::display($tpl);
	}
	
	function surveyDetail($surveyID){
		return $this->getModel()->surveyDetail($surveyID);
	}

}

?>
