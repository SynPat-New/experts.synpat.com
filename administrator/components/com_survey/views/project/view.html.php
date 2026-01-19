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

class SurveyViewProject extends JView {
	
	function display ($tpl =  null ){			
		JToolBarHelper::title(JText::_( 'SURVEY_PROJECTS'));
		JToolBarHelper::addNew('project.new');
		JToolBarHelper::editList('project.edit');
		JToolBarHelper::deleteList('Are you sure want to delete Project','project.delete');
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
			JToolBarHelper::title(JText::_('SURVEY_PROJECT').":<small>[".trim(JText::_("SURVEY_NEW"))."]</small>");
		}
		else{
			JToolBarHelper::title(JText::_('SURVEY_PROJECT').":<small>[".trim(JText::_("SURVEY_EDIT"))."]</small>");
		}
		JToolBarHelper::custom('next','forward.png','forward_f2.png','Next',false);
		JToolBarHelper::cancel();
		parent::display($tpl);
	}
	
	function editform($tpl = null){
		$id = JRequest::getVar("id", "0");
		if($id == "0"){
			JToolBarHelper::title(JText::_('SURVEY_PROJECT').":<small>[".trim(JText::_("SURVEY_NEW"))."]</small>");
		}
		else{
			JToolBarHelper::title(JText::_('SURVEY_PROJECT').":<small>[".trim(JText::_("SURVEY_EDIT"))."]</small>");
		}
		
		JToolBarHelper::save('project.save');
		JToolBarHelper::apply('project.apply');
		JToolBarHelper::cancel('project.cancelProject');	
			
		$user = & $this->get('ProjectDetails');
		$this->assignRef("user",$user);
		parent::display($tpl);
	}

}

?>
