<?php
// No direct access to this file
defined('_JEXEC') or die('Restricted access');
 
// import Joomla modelitem library
jimport('joomla.application.component.modelitem');
 

class SurveyModelAnswer extends JModelItem
{
	/**
	 * @var object item
	 */
	protected $item;
 
	/**
	 * Method to auto-populate the model state.
	 *
	 * This method should only be called once per instantiation and is designed
	 * to be called on the first call to the getState() method unless the model
	 * configuration flag to ignore the request is set.
	 *
	 * Note. Calling getState in this method will result in recursion.
	 *
	 * @return	void
	 * @since	1.6
	 */
	protected function populateState() 
	{
		$app = JFactory::getApplication();
		// Get the message id
		$id = JRequest::getInt('id');
		$this->setState('question.id', $id);
 
		// Load the parameters.
		$params = $app->getParams();
		$this->setState('params', $params);
		parent::populateState();
	}
 
	/**
	 * Returns a reference to the a Table object, always creating it.
	 *
	 * @param	type	The table type to instantiate
	 * @param	string	A prefix for the table class name. Optional.
	 * @param	array	Configuration array for model. Optional.
	 * @return	JTable	A database object
	 * @since	1.6
	 */
	public function getTable($type = 'Answer', $prefix = 'SurveyTable', $config = array()) 
	{
		return JTable::getInstance($type, $prefix, $config);
	}
	
	public function surveyData($surveyID){
		$db = JFactory::getDBO();
		$query = "SELECT * FROM #__survey WHERE id=".$surveyID;
		$db->setQuery($query);
		return $db->loadObject();
	}
	
	public function allAnswerChangeToReport($IDs,$showed){
		echo $updateQuery = "UPDATE #__survey_question_answer SET showed=".$showed." WHERE id IN (".implode(',',$IDs).")";
		$db = JFactory::getDBO();
		$db->setQuery($updateQuery);
		$db->query();
	}
	
	/**
	 * Get the message
	 * @return object The message to be displayed to the user
	 */
	public function getItem() 
	{
		$getPrams = JRequest::getVar('param');
		if($getPrams){
			$decodePrams = explode('@',base64_decode($getPrams));
			if(count($decodePrams)==3){
				if((int)$decodePrams[1]!=0 && (int)$decodePrams[2]!=0){
					$getData =  new stdClass ;					
				    $surveyID = (int)$decodePrams[1];
				    $expertID = (int)$decodePrams[2];					  
					$this->_db->setQuery($this->_db->getQuery(true)
					  	   ->from('#__question as q')
						   ->leftJoin('#__survey as s ON s.id = q.survey_id')
						   ->select('q.* , s.name as survey_name , s.combine_name as combineName,s.payment_type')
						   ->where('q.survey_id='.$surveyID)
						   ->order('q.question_order ASC'));
					$getData = $this->_db->loadObjectList();
        			return $getData;
				} else {
					$this->setError('Page not found!');
					return;
				}
			} else {
				$this->setError('Page not found!');
				return;
			}
		} else {
			$this->setError('Page not found!');
			return;
		}
		
	}
	
	public function save($data)

	 {

		 $row = $this->getTable('Answer');

		 if (!$row->bind($data)) {

			$this->setError($this->_db->getErrorMsg());

			return false;

		}

		if (!$row->check()) {

			$this->setError($this->_db->getErrorMsg());

			return false;

		}

		if (!$row->store()) {

			$this->setError( $row->getErrorMsg() );

			return false;

		}

		return $row->id; 

	 }
	
	function updateSurveyAmountExpert($getSurveyID,$getExpertDataID,$target,$target_product,$runReport){
		$query = "UPDATE #__survey_amount_expert SET run_report=".$runReport." WHERE expert_id=".(int)$getExpertDataID." AND survey_id=".(int)$getSurveyID." AND target='".$target."' AND target_product='".$target_product."'";
		$db = JFactory::getDBO();
		$db->setQuery($query);
		return $db->query();
	}
	
	function checkAnswerByExpert($questionID,$expertID,$target,$targetProduct){
		$db =  JFactory::getDBO();
		$sql = "SELECT * FROM #__survey_question_answer WHERE ques_id='".$questionID."' AND expert_id='".$expertID."' AND target ='".$target."' AND target_product ='".$targetProduct."'";
		$db->setQuery($sql);
		return $db->loadObject();
	}
	
	function checkAnswerByExpertPrior($questionID,$expertID){
		$db =  JFactory::getDBO();
		$sql = "SELECT * FROM #__survey_question_answer WHERE ques_id='".$questionID."' AND expert_id='".$expertID."' AND target='' AND target_product=''";
		$db->setQuery($sql);
		return $db->loadObject();
	}
	
	function expertUserData($expertID){
		$db = JFactory::getDBO();
		$sql = "SELECT * FROM #__expert WHERE user_id='" . $expertID. "'";
		$db->setQuery($sql);
		return $db->loadObject();
	}
	
	function getExpertPaypalData($expertID){
		$db =  JFactory::getDBO();
		$sql = "SELECT * FROM #__expert_payment WHERE expert_id='".$expertID."'";
		$db->setQuery($sql);
		return $db->loadObject();
	}
	
	function surveyAmtData($expertID,$surveyID,$target,$targetProduct){
		if($target!=""){
			$db =  JFactory::getDBO();
			$sql = "SELECT * FROM #__survey_amount_expert WHERE expert_id='".$expertID."' AND survey_id= '".$surveyID."' AND target='".$target."'AND target_product='".$targetProduct."'";
			
			$db->setQuery($sql);
			return $db->loadObject();
		} else {
			return array();
		}
	}
	
	function surveyAmtDataPrior($expertID,$surveyID){		
		$db =  JFactory::getDBO();
		$checkAnswerData = "SELECT count(id) as counter FROM #__survey_question_answer WHERE ques_id IN (SELECT id FROM #__question where survey_id = '".$surveyID."') AND expert_id='".$expertID."'";
		$db->setQuery($checkAnswerData);
		$resultData = $db->loadObject();
		$data = array();
		if($resultData->counter>0){
			$sql = "SELECT * FROM #__survey_amount_expert WHERE expert_id='".$expertID."' AND survey_id= '".$surveyID."'";			
			$db->setQuery($sql);
			$data = $db->loadObject();
		}
		return $data;
	}
	
	function expertAnsQues($questionID,$expertID , $target,$targetProduct){
		$db =  JFactory::getDBO();
		$sql = "SELECT * FROM #__survey_question_answer WHERE expert_id='".$expertID."' AND ques_id= '".$questionID."' AND target ='".$target."' AND showed=1 AND target_product ='".$targetProduct."'";
		/*echo "A".$sql."B<br/>";*/
		$db->setQuery($sql);
		return $db->loadObject();
	}
	
	function getExpertAnsData($id,$expertID){
		$db =  JFactory::getDBO();
		$sql = "SELECT * FROM #__survey_question_answer WHERE expert_id='".$expertID."' AND id= '".$id."'";
		$db->setQuery($sql);
		return $db->loadObject();
	}
	
	function expertAnsQuesPrior($questionID,$expertID){
		$db =  JFactory::getDBO();
		$sql = "SELECT * FROM #__survey_question_answer WHERE expert_id='".$expertID."' AND ques_id= '".$questionID."'";
		$db->setQuery($sql);
		return $db->loadObject();
	}
	
	function surveyAmount($amount,$expertID,$surveyID,$target,$target_product,$run_report,$reportOptionType){
		$db =  JFactory::getDBO();
		$sql = "DELETE FROM #__survey_amount_expert WHERE expert_id='".$expertID."' AND survey_id='".$surveyID."' AND target ='".$target."' AND target_product = '".$target_product."'";
		$db->setQuery($sql);
		$db->query();
		$sql = "INSERT INTO #__survey_amount_expert (expert_id,survey_id,amount,target,target_product,report_option_type) VALUES ('".$expertID."','".$surveyID."','".$amount."','".$target."','".$target_product."',".$reportOptionType.")";
		$db->setQuery($sql);
		$db->query();
		return $db->insertid();
	}
	
	function updateEditReport($runReport,$ID){
		$query = "UPDATE #__survey_amount_expert SET run_report=".$runReport." WHERE id=".$ID;
		$db =  JFactory::getDBO();
		$db->setQuery($query);
		$db->query();
		return $db->getAffectedRows();
	}
	
	function updateEditReportSpecificAmount($specificAmount,$ID){
		$query = "UPDATE #__survey_amount_expert SET specific_amount='".$specificAmount."' WHERE id=".$ID;
		$db =  JFactory::getDBO();
		$db->setQuery($query);
		$db->query();
		return $db->getAffectedRows();
	}
	
	function paymentData($paypalID,$expertID){
		$db =  JFactory::getDBO();
		$sql = "DELETE FROM #__expert_payment WHERE expert_id='".$expertID."'";
		$db->setQuery($sql);
		$db->query();		
		$sql = "INSERT INTO #__expert_payment (expert_id,paypal_id) VALUES ('".$expertID."','".$paypalID."')";
		$db->setQuery($sql);
		$db->query();		
	}
	
	function getProjectDetailFromSurvey($surveyID){
		$db =  JFactory::getDBO();
		$sql = "SELECT s.* ,p.id as projectID , p.name as projectName, p.synpat_price FROM #__projects as p LEFT JOIN #__survey as s ON s.project_id = p.id WHERE s.id='".$surveyID."'";
		$db->setQuery($sql);
		return $db->loadObject(); 
	}
	
	function findEmailAddressAlert($projectID, $surveyID){
		$db =  JFactory::getDBO();
		$sql = "SELECT * FROM #__email_alert WHERE (project_id='".$projectID."' AND survey_id='".$surveyID."') OR (project_id='".$projectID."' OR survey_id='".$surveyID."')";
		$db->setQuery($sql);
		return $db->loadObjectList();
	}
}
