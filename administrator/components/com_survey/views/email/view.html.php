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

class SurveyViewEmail extends JView {
	
	function display ($tpl =  null ){			
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
	
	function emailLayout($tpl=null){
		$post = JRequest::get('post');
		if(isset($post['survey_id'])){
			JToolBarHelper::custom('question.emailSend','forward.png','forward_f2.png','Send',false);
			JToolBarHelper::cancel('question.cancel');	
			/*			
			$getSurveyData = $this->getModel()->expertListAccAreaInClaim($post['survey_id']);
			$getAllExpert = $this->getModel()->allExpert();
			$this->assignRef('expertData',$getSurveyData);
			*/
			$parentData = $this->getModel()->getParentExpertise();		
			$childData = "";
			if(count($parentData)>0){
				$childData = $this->getModel()->getChildExpertise($parentData->id);
			}
			$this->assignRef('parentData',$parentData);
			$this->assignRef('childData',$childData);
			/*
			$this->assignRef('getAllExpert',$getAllExpert);
			*/
			$this->assignRef('survey_id',$post['survey_id']);
		}
		parent::display($tpl);
	}
	
	
}

?>
