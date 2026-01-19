<?php
// No direct access to this file
defined('_JEXEC') or die('Restricted access');
 
// import Joomla controllerform library
jimport('joomla.application.component.controllerform');
 
/**
 * HelloWorld Controller
 */
class SurveyControllerOrder extends JControllerForm{
	var $_model = null;
	
	function __construct () {
		parent::__construct();
		$this->registerTask ("list", "OrderList");
		$this->registerTask ("", "OrderList");
		$this->registerTask ("remove", "delete");		
		$this->_model =& $this->getModel("order");

	}
	function OrderList() {		
		JRequest::setVar ("view", "order");
		$view = $this->getView("order", "html");
		$view->setModel($this->_model, true);
		parent::display();
	}
	
	function cancel(){
		$app = JFactory::getApplication('administrator');
		$app->redirect('index.php?option=com_survey&task=');
	}
	function cancelSurvey(){
		$app = JFactory::getApplication('administrator');
		$app->redirect('index.php?option=com_survey&task=survey.list');
	}
	function delete(){
		$result = $this->_model->delete();
		$msg = "";
		if($result === true){
			$msg = JText::_('SURVEY_DELETED');
		} 
		elseif($result === false){
			$msg = JText::_('SURVEY_DELETED_ERROR');
		}
		$link = "index.php?option=com_survey&task=survey.list";
		$this->setRedirect($link, $msg, "notice");
	}
	
	function answerList(){
		JRequest::setVar ("view", "survey");
		$view = $this->getView("survey", "html");
		$view->setLayout("answer");		
		$view->setModel($this->_model, true);
		$view->answer();
	}
	
	function saveanswer(){
		$post = JRequest::get('post');
		$getAnswerList = explode(',',$post['answer']);
		if(count($getAnswerList)>0 && $getAnswerList[0]!=""){
			for($i=0;$i<count($getAnswerList);$i++){
				if($getAnswerList[$i]!=""){
					$model = $this->getModel('Answer');
					$ans = "";
					if(isset($post['answer_pub_'.$getAnswerList[$i]])){
						$ans = array('publish'=>$post['answer_pub_'.$getAnswerList[$i]],'id'=>$getAnswerList[$i]);
					} else {
						$ans = array('publish'=>1,'id'=>$getAnswerList[$i]);
					}
					$model->save($ans);
				}
			}
		}
		$app = JFactory::getApplication();
		$link = 'index.php?option=com_survey&task=survey.answerList&expert_id='.$post['expert_id'].'&survey_id='.$post['survey_id'];
		$this->setRedirect($link,"Data updated successfully","notice");
	}
}
