<?php
// No direct access to this file
defined('_JEXEC') or die('Restricted access');
 
// import Joomla controllerform library
jimport('joomla.application.component.controllerform');
 
/**
 * HelloWorld Controller
 */
class SurveyControllerProject extends JControllerForm{
	var $_model = null;
	
	function __construct () {
		parent::__construct();
		$this->registerTask ("", "ProjectList");
		$this->registerTask ("list", "ProjectList");
		//$this->registerTask ("orderdown", "reorder");
		//$this->registerTask ("orderup", "reorder");
		$this->registerTask("orderup", "saveorder");
        $this->registerTask("orderdown", "saveorder");
		//$this->registerTask ("saveorder", "saveorder");
		$this->registerTask ("new", "newProject");
		$this->registerTask ("edit", "editProject");
		$this->registerTask ("remove", "delete");		
		$this->_model =& $this->getModel("project");

	}
	function ProjectList() {		
		JRequest::setVar ("view", "project");
		$view = $this->getView("project", "html");		
		$view->setModel($this->_model, true);
		parent::display();
	}
	function newProject(){
		JRequest::setVar ("view", "project");
		$view = $this->getView("project", "html");
		$view->setLayout("editform");
		$view->setModel($this->_model, true);
		$view->editform();
	}
	function editProject(){
		JRequest::setVar ("view", "project");
		$view = $this->getView("project", "html");
		$view->setLayout("editform");
		$view->setModel($this->_model, true);
		$view->editform();
	}
	function save(){
		$app = JFactory::getApplication('administrator');
		$data = JRequest::get('post');	
		$data["description"] = JRequest::getVar("description","","post","string",JREQUEST_ALLOWRAW);
		$data["project_image"] = $data['images'];
		unset($data['images']);
		if($this->_model->save($data)){
			$msg = JText::_( 'PROJECT_DETAILS_SAVED' );
			$this->setRedirect( 'index.php?option=com_survey&task=project.list', $msg );
		}
		else{
			$msg = JText::_('PROJECT_DETAILS_SAVED_ERROR');
			$this->setRedirect( 'index.php?option=com_survey&task=project.list', $msg, "notice");
		}
		
	}
	
	function apply(){
		$app = JFactory::getApplication('administrator');
		$db= & JFactory::getDBO();		
		$data = JRequest::get('post');	
		$data["description"] = JRequest::getVar("description","","post","string",JREQUEST_ALLOWRAW);
		$data["project_image"] = $data['images'];
		unset($data['images']);		
		$result = $this->_model->save($data);
		if(isset($result) && $result != false){
			$msg = JText::_( 'PROJECT_DETAILS_SAVED' );
			$this->setRedirect( 'index.php?option=com_survey&task=project.edit&id='.$result.'&hidemainmenu=1', $msg );
		}
		else{
			$author_type = JRequest::getVar("author_type", "0");
			$this->setRedirect("index.php?option=com_survey&task=project.new", JText::_('PROJECT_DETAILS_SAVED_ERROR'));
		}				
	}
	
	function cancel(){
		$app = JFactory::getApplication('administrator');
		$app->redirect('index.php?option=com_survey&task=');
	}
	function cancelProject(){
		$app = JFactory::getApplication('administrator');
		$app->redirect('index.php?option=com_survey&task=project.list');
	}
	function delete(){
		$result = $this->_model->delete();
		$msg = "";
		if($result === true){
			$msg = JText::_('PROJECT_DELETED');
		} 
		elseif($result === false){
			$msg = JText::_('PROJECT_DELETED_ERROR');
		}
		$link = "index.php?option=com_survey&task=project.list";
		$this->setRedirect($link, $msg, "notice");
	}
}
