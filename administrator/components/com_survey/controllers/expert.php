<?php
// No direct access to this file
defined('_JEXEC') or die('Restricted access');
 
// import Joomla controllerform library
jimport('joomla.application.component.controllerform');
 
/**
 * HelloWorld Controller
 */

class SurveyControllerExpert extends JControllerForm{
	var $_model = null;
	
	function __construct () {
		parent::__construct();
		$this->registerTask ("", "ExpertList");
		$this->registerTask ("list", "ExpertList");
		$this->registerTask ("new", "newExpert");
		$this->registerTask ("edit", "editExpert");
		$this->registerTask ("delete", "delete");		
		$this->_model =& $this->getModel("expert");

	}
	function ExpertList() {		
		JRequest::setVar ("view", "expert");
		$view = $this->getView("expert", "html");		
		$view->setModel($this->_model, true);
		parent::display();
	}
	function newExpert(){
		JRequest::setVar ("view", "expert");
		$view = $this->getView("expert", "html");
		$view->setLayout("editform");
		$view->setModel($this->_model, true);
		$view->editform();
	}
	function editExpert(){
		JRequest::setVar ("view", "expert");
		$view = $this->getView("expert", "html");
		$view->setLayout("editform");
		$view->setModel($this->_model, true);
		$view->editform();
	}
	function save(){
		$app = JFactory::getApplication('administrator');
		$data = JRequest::get('post');	
		if(count($data)>0){
			$getData = $this->_model->getExpertData($data['id']);
			if(count($getData)>0){
				$textData  = json_decode($getData->text_data);
				$newData = array();
				$newData['first_name'] = (isset($textData->f))?$textData->f:$getData->first_name;
				$newData['last_name'] = (isset($textData->l))?$textData->l:$getData->first_name;
				$newData['name'] = $newData['first_name']." ".$newData['last_name'];
				$newData['email'] = (isset($textData->em))?$textData->em:$getData->email;
				$newData['company_name'] = (isset($textData->c))?$textData->c:$getData->company_name;
				$newData['description'] = (isset($textData->expl))?$textData->expl:$getData->description;
				$newData['phone'] = (isset($textData->p))?$textData->p:$getData->phone;
				$newData['address'] = (isset($textData->a))?$textData->a:$getData->address;
				$newData['web'] = (isset($textData->w))?$textData->w:$getData->web;
				$newData['state'] = (isset($textData->st))?$textData->st:$getData->state;
				$newData['city'] = (isset($textData->ci))?$textData->ci:$getData->city;
				$newData['zip'] = (isset($textData->zi))?$textData->zi:$getData->zip;
				$newData['membership'] = (isset($textData->me))?$textData->me:$getData->membership;
				$newData['areas_of_expertise'] = (isset($textData->ae))?$textData->ae:$getData->areas_of_expertise;
				$newData['standards_groups'] = (isset($textData->sg))?$textData->sg:$getData->standards_groups;
				$newData['standards_groups'] = (isset($textData->cv))?$textData->cv:$getData->cv;
				$newData['profile_image_file_name'] = (isset($textData->img))?$textData->img:$getData->profile_image_file_name;
				$newData['pub'] = 0;
				$newData['text_data'] = '';
				$newData['id'] = $data['id'];
				if($this->_model->save($newData)){
					$msg = JText::_( 'Expert details published' );
					$this->setRedirect( 'index.php?option=com_survey&task=expert.list', $msg );
				}else{
					$msg = JText::_('Error in published expert details');
					$this->setRedirect( 'index.php?option=com_survey&task=expert.list', $msg, "notice");
				}
			} else {
				$msg = JText::_('Expert not found!');
			$this->setRedirect( 'index.php?option=com_survey&task=expert.list', $msg, "notice");
			}
		} else {
			$msg = JText::_('Not able to find data');
			$this->setRedirect( 'index.php?option=com_survey&task=expert.list', $msg, "notice");
		}
	}
	
	function apply(){
		$app = JFactory::getApplication('administrator');
		$data = JRequest::get('post');	
		$data["description"] = JRequest::getVar("description","","post","string",JREQUEST_ALLOWRAW);
		$result = $this->_model->save($data);
		if(isset($result) && $result != false){
			$msg = JText::_( 'EXPERT_DETAILS_SAVED' );
			$this->setRedirect( 'index.php?option=com_survey&task=expert.edit&id='.$result.'&hidemainmenu=1', $msg );
		}
		else{
			$author_type = JRequest::getVar("author_type", "0");
			$this->setRedirect("index.php?option=com_survey&task=expert.new", JText::_('EXPERT_DETAILS_SAVED_ERROR'));
		}				
	}
	
	function publishExpert(){
		$app = JFactory::getApplication('administrator');
		$db= & JFactory::getDBO();		
		$data = JRequest::get('post');	
		echo "<pre>";
		print_r($data);
		die;
	}
	
	function cancel(){
		$app = JFactory::getApplication('administrator');
		$app->redirect('index.php?option=com_survey&task=');
	}
	function cancelExpert(){
		$app = JFactory::getApplication('administrator');
		$app->redirect('index.php?option=com_survey&task=expert.list');
	}
	function delete(){
		$result = $this->_model->delete();
		$msg = "";
		if($result === true){
			$msg = JText::_('EXPERT_DELETED');
		} 
		elseif($result === false){
			$msg = JText::_('EXPERT_DELETED_ERROR');
		}
		$link = "index.php?option=com_survey&task=expert.list";
		$this->setRedirect($link, $msg, "notice");
	}
	
	function publish(){
		$cid = JRequest::getVar('cid', array(), 'default', 'array');
        $model = & $this->_model->publishList($cid, 1);
        $this->setRedirect('index.php?option=com_survey&task=expert.list');
	}
	
	function unpublish(){
		$cid = JRequest::getVar('cid', array(), 'default', 'array');
        $model = & $this->_model->publishList($cid, 0);
        $this->setRedirect('index.php?option=com_survey&task=expert.list');
	}
	
	function feedbackDelete(){
		$cid = JRequest::getVar('cid', array(), 'default', 'array');
		$data = JRequest::get('post');
		$model = & $this->_model->deleteList($cid);
		$this->setRedirect('index.php?option=com_survey&task=expert.feedback&id='.$data['expert_id']);
	}
	
	function feedback(){
		JRequest::setVar ("view", "expert");
		$view = $this->getView("expert", "html");
		$view->setLayout("feedback");
		$view->setModel($this->_model, true);
		$view->feedback();
	}
	
	function inProcessReport(){
		JRequest::setVar("view","expert");
		$view = $this->getView("expert","html");
		$view->setLayout('inprocess');
		$view->setModel($this->_model,true);
		$view->inprocess();
	}
	
	function sendMessage(){
		JRequest::setVar("view","expert");
		$view = $this->getView('expert','html');
		$view->setLayout("message");
		$view->setModel($this->_model, true);
		$view->message();
	}
	
	function customMessage(){
		$post = JRequest::get('post');
		$expertData = $this->_model->getExpertData($post['expert_id']);
		$mailer =& JFactory::getMailer();
		$config =& JFactory::getConfig();
		$sender = array( 
						$config->getValue( 'config.mailfrom' ),
						$config->getValue( 'config.fromname' ) 
					);
		$mailer->setSender($sender);
		$mailer->addRecipient($expertData->email);
		$mailer->setSubject('Message from ClaimCharts.info');
		$body = $post['message'];
		$mailer->setBody($body);
		$mailer->isHTML(true);
		$mailer->Encoding = 'base64';
		$app = JFactory::getApplication();
		if($mailer->Send()){
			$app->redirect('index.php?option=com_survey','Message send successfully.');
		} else {
			$app->redirect('index.php?option=com_survey','Message not send.');
		}
	}
}
