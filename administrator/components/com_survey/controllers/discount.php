<?php
// No direct access to this file
defined('_JEXEC') or die('Restricted access');
 
// import Joomla controllerform library
jimport('joomla.application.component.controllerform');
 
/**
 * HelloWorld Controller
 */
class SurveyControllerDiscount extends JControllerForm{
	var $_model = null;
	
	function __construct () {
		parent::__construct();
		$this->registerTask ("list", "DiscountList");
		$this->registerTask ("", "DiscountList");
		$this->registerTask ("new", "DiscountNew");
		$this->registerTask ("remove", "delete");		
		$this->_model =& $this->getModel("discount");

	}
	function DiscountList() {
		JRequest::setVar ("view", "discount");
		$view = $this->getView("discount", "html");
		$view->setModel($this->_model, true);
		parent::display();
		
	}
	
	function DiscountNew() {
        JRequest::setVar("view", "discount");
        $view = $this->getView("discount", "html");
        $view->setLayout("editform");
        $view->setModel($this->_model, true);
        $view->editform();
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
	
	function save() {
        $app = JFactory::getApplication('administrator');
        $data = JRequest::get('post');
        $flag = 0;
		$findDiscount = $this->getModel('discount')->findDiscountCouponCode($data['discount']['coupon_code']);
		if($findDiscount->countDiscount==0){
			$model = $this->getModel('Discount');
			$id = $model->save($data['discount']);
			if($id>0){
				$this->setRedirect("index.php?option=com_survey&task=discount.list", 'Coupon added', "success");
			} else {
				$this->setRedirect("index.php?option=com_survey&task=discount.new", 'Server busy, Please try after sometime', "notice");
			}
		} else {
			$this->setRedirect("index.php?option=com_survey&task=discount.new", 'Coupon already exist', "notice");
		}
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
