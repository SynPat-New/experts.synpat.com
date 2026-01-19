<?php
/**
 * @copyright   (C) 2010 iJoomla, Inc. - All rights reserved.
 * @license  GNU General Public License, version 2 (http://www.gnu.org/licenses/gpl-2.0.html)
 * @author  iJoomla.com <webmaster@ijoomla.com>
 * @url   http://www.ijoomla.com/licensing/
 * the PHP code portions are distributed under the GPL license. If not otherwise stated, all images, manuals, cascading style sheets, and included JavaScript  *are NOT GPL, and are released under the IJOOMLA Proprietary Use License v1.0 
 * More info at http://www.ijoomla.com/licensing/
*/
defined ('_JEXEC') or die ("Go away.");

jimport ("joomla.application.component.view");

class SurveyViewExpert extends JView {
	
	function display ($tpl =  null ){			
		JToolBarHelper::title(JText::_( 'SURVEY_EXPERT'));
		JToolBarHelper::addNew('expert.new');
		JToolBarHelper::editList('expert.edit');
		JToolBarHelper::deleteList('Are you sure want to delete?','expert.delete');
		JToolBarHelper::cancel();		
		$projectList =& $this->get('Items');
		$pagination = & $this->get( 'Pagination' );		
		$this->assignRef('authorList', $projectList);
		$this->assignRef('pagination', $pagination);		
		parent::display($tpl);
	}	
	function settypeform($tpl = null){
		$id = JRequest::getVar("id", "0");
		if($id == "0"){
			JToolBarHelper::title(JText::_('SURVEY_EXPERT').":<small>[".trim(JText::_("SURVEY_NEW"))."]</small>");
		}
		else{
			JToolBarHelper::title(JText::_('SURVEY_EXPERT').":<small>[".trim(JText::_("SURVEY_EDIT"))."]</small>");
		}
		JToolBarHelper::custom('next','forward.png','forward_f2.png','Next',false);
		JToolBarHelper::cancel();
		parent::display($tpl);
	}	
	function editform($tpl = null){
		$id = JRequest::getVar("id", "0");
		if($id == "0"){
			JToolBarHelper::title(JText::_('SURVEY_EXPERT').":<small>[".trim(JText::_("SURVEY_NEW"))."]</small>");
		}
		else{
			JToolBarHelper::title(JText::_('SURVEY_EXPERT').":<small>[".trim(JText::_("SURVEY_EDIT"))."]</small>");
		}		
		JToolBarHelper::publish('expert.save');
		JToolBarHelper::cancel('expert.cancelExpert');			
		$user = & $this->get('ExpertDetails');
		$this->assignRef("user",$user);
		parent::display($tpl);
	}	
	function getSurveyList(){
		$getSurveryList = & $this->get('SurveyList');
		return $getSurveryList;
	}
	function getProjectList(){
		$getSurveryList = & $this->get('ProjectList');
		return $getSurveryList;
	}
	function feedback($tpl=null){
		JToolBarHelper::deleteList('Are you sure want to delete?','expert.feedbackDelete');
		$getFeedbackData = $this->getModel()->getExpertFeedback(JRequest::getInt('id'));
		JToolBarHelper::cancel();		
		JToolBarHelper::title(JText::_('Expert Feedback'));
		$this->assignRef("getFeedbackData",$getFeedbackData);
		parent::display($tpl);
	}
	function inprocess($tpl=null){
		JToolBarHelper::title(JText::_('Expert InProcess List'));
		JToolBarHelper::cancel('expert.cancel');	
		$getProjectID = JRequest::getInt('project_id');
		$inprocess = $this->getModel()->inProcessReport($getProjectID);
		$this->assignRef("inprocess",$inprocess);
		parent::display($tpl);
	}	
	function message(){
		JToolBarHelper::title(JText::_('Message'));
		JToolBarHelper::custom('expert.customMessage','forward.png','forward_f2.png','Send',false);
		JToolBarHelper::cancel();		
		$getExpertID = JRequest::getInt('expert_id');
		$this->assignRef("expert_id",$getExpertID);
		parent::display($tpl);
	}
}

?>
