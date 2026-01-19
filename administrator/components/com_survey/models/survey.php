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


jimport('joomla.application.component.modellist');
jimport('joomla.utilities.date');


class SurveyModelSurvey extends JModelList{
	var $_attributes;
	var $_attribute;
	var $_id = null;
	var $_total = 0;
	var $total = 0;
	var $_pagination = null;
	protected $_context = 'com_survey.survey';

	function __construct () {
		global $option;
		parent::__construct();
		$cids = JRequest::getVar('cid', 0, '', 'array');
		$this->setId((int)$cids[0]);
	}
	
	function populateState(){
		$app = JFactory::getApplication('administrator');
		$this->setState('list.start', $app->getUserStateFromRequest($this->_context . '.list.start', 'limitstart', 0, 'int'));
		$this->setState('list.limit', $app->getUserStateFromRequest('global.list.limit', 'limit', $app->getCfg('list_limit'), 'int'));
		$this->setState('selected', JRequest::getVar('cid', array()));	
	}
	
	public function getTable($type = 'Survey', $prefix = 'SurveyTable', $config = array()) 
	{
		return JTable::getInstance($type, $prefix, $config);
	}
	
	function getPagination(){
		$pagination=parent::getPagination();
		$pagination->total=$this->total;
		if($pagination->total%$pagination->limit>0){
			$nr_pages=intval($pagination->total/$pagination->limit)+1;
		}	
		else{ 
			$nr_pages=intval($pagination->total/$pagination->limit);
		}	
		$pagination->set('pages.total',$nr_pages);
		$pagination->set('pages.stop',$nr_pages);		
		return $pagination;
	}
	
	function getItems(){
		$app = JFactory::getApplication('administrator');
		$limistart = $app->getUserStateFromRequest($this->context.'.list.start', 'limitstart');
		$limit = $app->getUserStateFromRequest('global.list.limit', 'limit', $app->getCfg('list_limit'));
		$db =& JFactory::getDBO();
		$query = $db->getQuery(true);
		$query = $this->getListQuery();
		$db->setQuery($query);
		$db->query();
		$result	= $db->loadAssocList();
		$this->total = count($result);
		$db->setQuery($query, $limistart, $limit);
		$db->query();
		$result	= $db->loadAssocList();
		return $result;
	}

	
	function setId($id) {
		$this->_id = $id;
		$this->_attribute = null;
	}

	function delete(){
		$db =& JFactory::getDBO();
		$cids = JRequest::getVar('cid', 0, '', 'array');
		$return = "";
		if(isset($cids) && is_array($cids) && count($cids) > 0){
			foreach($cids as $key=>$id){
				$sql = "delete from #__survey where id=".intval($id);
				$db->setQuery($sql);
				if(!$db->query()){
					return false;
				}
			}
		}
		return $return;
	}

	function getSurveyList(){	
		$app = JFactory::getApplication('administrator');
		$limit		= $app->getUserStateFromRequest( 'limit', 'limit', $app->getCfg('list_limit'), 'int' );
		$limitstart = $app->getUserStateFromRequest('limitstart', 'limitstart', 0, 'int' );		
		$limit_cond = "";
		if($limit!=0){
			$limit_cond = " LIMIT ".$limitstart.",".$limit." ";
		}	
		$db =& JFactory::getDBO();
		$sql = "";
		$sqlSurvey = "";
		$getProjectID = JRequest::getVar('project_id','');
		$user = JFactory::getUser();
		/*Check User LoggedIn*/
		$checkUser = $this->checkUserLoggedIn();
		/*
		if($checkUser=='8'){
			if(empty($getProjectID)){
				$sql =  "SELECT count(*) FROM #__survey ORDER BY `name` ASC ";
				$sqlSurvey = "SELECT s.* , p.name as project_name FROM #__survey as s LEFT JOIN #__projects as p ON p.id = s.project_id  ORDER BY s.`name` ASC ".$limit_cond;				
			} else {
				$sql =  "SELECT count(*) FROM #__survey ORDER BY `name` WHERE project_id ='".$getProjectID."' ASC ";
				$sqlSurvey = "SELECT s.* , p.name as project_name FROM #__survey as s LEFT JOIN #__projects as p ON p.id = s.project_id  WHERE s.project_id ='".$getProjectID."' ORDER BY s.`name` ASC ".$limit_cond;				
			}
		} else if($checkUser=='7') {
			if(empty($getProjectID)){
				$sql =  "SELECT count(*) FROM #__survey ORDER BY `name` WHERE user_id= '".$user->id."' ASC ";
				$sqlSurvey = "SELECT s.* , p.name as project_name FROM #__survey as s LEFT JOIN #__projects as p ON p.id = s.project_id  WHERE s.user_id= '".$user->id."' ORDER BY s.`name` ASC ".$limit_cond;	
			} else {
				$sql =  "SELECT count(*) FROM #__survey ORDER BY `name` WHERE project_id ='".$getProjectID."' AND user_id= '".$user->id."' ASC ";
				$sqlSurvey = "SELECT s.* , p.name as project_name FROM #__survey as s LEFT JOIN #__projects as p ON p.id = s.project_id  WHERE s.project_id ='".$getProjectID."' AND s.user_id= '".$user->id."' ORDER BY s.`name` ASC ".$limit_cond;				
			} 
		}
		*/
		if(empty($getProjectID)){
			$sql =  "SELECT count(*) FROM #__survey ORDER BY `name` ASC ";
			$sqlSurvey = "SELECT s.* , p.name as project_name FROM #__survey as s LEFT JOIN #__projects as p ON p.id = s.project_id  ORDER BY s.`name` ASC ".$limit_cond;				
		} else {
			$sql =  "SELECT count(*) FROM #__survey ORDER BY `name` WHERE project_id ='".$getProjectID."' ASC ";
			$sqlSurvey = "SELECT s.* , p.name as project_name FROM #__survey as s LEFT JOIN #__projects as p ON p.id = s.project_id  WHERE s.project_id ='".$getProjectID."' ORDER BY s.`name` ASC ".$limit_cond;				
		}
	
		$db->setQuery($sql);
		$db->query();
		$this->_total = $db->loadResult();	
		$db->setQuery($sqlSurvey);
		$db->query();
		
		$result = $db->loadAssocList();
		return $result;
	}	
	
	function checkUserLoggedIn(){
		$user = & JFactory::getUser();
		$db = JFactory::getDBO();
		/*Find User Group*/
		$sql = "SELECT * FROM #__user_usergroup_map WHERE user_id='".$user->id."'";
		$db->setQuery($sql);
		$getData = $db->loadobject();
		if(count($getData)>0){
			/*Group ID (8,7)*/
			return $getData->group_id;
		}
	}
	
	function getListQuery(){
		$app = JFactory::getApplication('administrator');
		$limit = $app->getUserStateFromRequest( 'global.list.limit', 'limit', $app->getCfg('list_limit'), 'int' );
		$limitstart = $app->getUserStateFromRequest( 'limitstart', 'limitstart', 0, 'int' );
		
		$limit_cond = "";
		if($limit!=0){
			$limit_cond = " LIMIT ".$limitstart.",".$limit." ";
		}
		$sql = "";
		$sqlSurvey = "";
		$getProjectID = JRequest::getVar('project_id','');
		$user = JFactory::getUser();
		/*Check User LoggedIn*/
		$checkUser = $this->checkUserLoggedIn();
		/*
		if($checkUser=='8'){
			if(empty($getProjectID)){
				$sql =  "SELECT count(*) FROM #__survey ORDER BY `name` ASC ";
				$sqlSurvey = "SELECT s.* , p.name as project_name FROM #__survey as s LEFT JOIN #__projects as p ON p.id = s.project_id  ORDER BY s.`name` ASC ";				
			} else {
				$sql =  "SELECT count(*) FROM #__survey ORDER BY `name` WHERE project_id ='".$getProjectID."' ASC ";
				$sqlSurvey = "SELECT s.* , p.name as project_name FROM #__survey as s LEFT JOIN #__projects as p ON p.id = s.project_id  WHERE s.project_id ='".$getProjectID."' ORDER BY s.`name` ASC ";				
			}
		} else if($checkUser=='7') {
			if(empty($getProjectID)){
				$sql =  "SELECT count(*) FROM #__survey ORDER BY `name` WHERE user_id= '".$user->id."' ASC ";
				$sqlSurvey = "SELECT s.* , p.name as project_name FROM #__survey as s LEFT JOIN #__projects as p ON p.id = s.project_id  WHERE s.user_id= '".$user->id."' ORDER BY s.`name` ASC ";	
			} else {
				$sql =  "SELECT count(*) FROM #__survey ORDER BY `name` WHERE project_id ='".$getProjectID."' AND user_id= '".$user->id."' ASC ";
				$sqlSurvey = "SELECT s.* , p.name as project_name FROM #__survey as s LEFT JOIN #__projects as p ON p.id = s.project_id  WHERE s.project_id ='".$getProjectID."' AND s.user_id= '".$user->id."' ORDER BY s.`name` ASC ";				
			} 
		}*/
		if(empty($getProjectID)){
				$sql =  "SELECT count(*) FROM #__survey ORDER BY `name` ASC ";
				$sqlSurvey = "SELECT s.* , p.name as project_name FROM #__survey as s LEFT JOIN #__projects as p ON p.id = s.project_id  ORDER BY s.`name` ASC ";				
			} else {
				$sql =  "SELECT count(*) FROM #__survey ORDER BY `name` WHERE project_id ='".$getProjectID."' ASC ";
				$sqlSurvey = "SELECT s.* , p.name as project_name FROM #__survey as s LEFT JOIN #__projects as p ON p.id = s.project_id  WHERE s.project_id ='".$getProjectID."' ORDER BY s.`name` ASC ";				
			}
		$db =& JFactory::getDBO();
		//$sql =  "SELECT count(*) FROM #__survey ORDER BY `name` ASC ";
		$db->setQuery($sql);
		$db->query();
		$this->_total = $db->loadResult();	    
		//$sql = "SELECT s.* , p.name as project_name FROM #__survey as s LEFT JOIN #__projects as p ON p.id = s.project_id  ORDER BY s.`name` ASC";	
		$db->setQuery($sqlSurvey);
		$db->query();
		$result = $db->loadAssocList();		
		return $sqlSurvey;
			
	}
	
	function getSurveyDetails(){
		$db =& JFactory::getDBO();
		$survey_id = "";
		$id_val = JRequest::getVar("cid", "", "post", "array");
		if(is_array($id_val) && count($id_val) > 0 && $id_val["0"] != ""){
			$cids = JRequest::getVar("cid", "", "post", "array");
			$survey_id = $cids[0];
		}
		else{
			$survey_id = JRequest::getVar("id", "0", "", "int");		
		}
		$result = new StdClass();
		if($survey_id > 0){
			$sql = "SELECT * FROM #__survey WHERE id=".$survey_id;
			$db->setQuery($sql);
			$db->query();
			$result = $db->loadObject();			
			$result->id = $survey_id;					
		}
		else{
			$get = JRequest::get();
			foreach($get as $key => $val){
				$result->$key = $val;
			}
		}
		if(!isset($result->id)){
			$result->id = 0;
		}
		if(!isset($result->name)){
			$result->name = "";
		}
		
		if(!isset($result->description)){
			$result->description = "";
		}
		
		if(!isset($result->image)){
			$result->image = "";
		}	
		if(!isset($result->amount)){
			$result->amount = "";
		}
		if(!isset($result->project_id)){
			$result->project_id = "";
		}		
		return $result;
	}
	
	function save($data){
		$db =& JFactory::getDBO();
		$item =& $this->getTable('Survey');	
		
		if (!$item->bind($data)){
			echo $item->getError().' - 1';
			return false;
		}
		if (!$item->check()) {
			echo $item->getError().' - 2';
			return false;
		}			
		if (!$item->store()) {
			echo $item->getError().' - 3';
			return false;
		}
		return $item->id;
	}
	
	function getProjectList(){
		$db = JFactory::getDBO();
		$sql = "SELECT * FROM #__projects ORDER BY `name` ASC";
		$db->setQuery($sql);
		return $db->loadObjectList();
	}
	
	
	function getProjectDetail($projectID){
		$db = JFactory::getDBO();
		$sql = "SELECT * FROM #__projects WHERE id='".$projectID."'";
		$db->setQuery($sql);
		return $db->loadObject();
	}
	
	function getQuestionList($surveyID){
		$db =& JFactory::getDBO();
		$sql = "SELECT * FROM #__question WHERE survey_id = '".$surveyID."'";
		$db->setQuery($sql);
		return $db->loadObjectList();
	}
	
	function getExpertListBySurveyAns($surveyID){
		$db =& JFactory::getDBO();
		$sql = "SELECT e.id , e.name FROM s1b9p_survey_question_answer as qa LEFT JOIN  s1b9p_expert as e ON e.id = qa.expert_id LEFT JOIN  s1b9p_question as q ON q.id = qa.ques_id LEFT JOIN  s1b9p_survey as s ON s.id = q.survey_id WHERE qa.showed = 0 AND q.survey_id = '".$surveyID."' GROUP BY qa.target , e.name ORDER BY e.name ASC";
		$db->setQuery($sql);
		return $db->loadObjectList();
	}
	
	function answerList($surveyID,$expertID){
		$db= & JFactory::getDBO();	
		$sql = "SELECT q.* , qa.id as answerID, qa.answer as answer, qa.supporting_document as supporting_document, qa.publish FROM #__question as q LEFT JOIN `#__survey_question_answer` qa ON q.id = qa.ques_id WHERE q.survey_id='".$surveyID."' AND qa.expert_id='".$expertID."' ORDER BY q.id ASC";		
		$db->setQuery($sql);
		return $db->loadObjectList();
	}
	
	function getClaimDateToExpert($claimID){
		$db = JFactory::getDBO();
		$sql = "SELECT *  FROM #__message_send WHERE survey_id='".$claimID."'";
		$db->setQuery($sql);
		return $db->loadObject();
	}
	
	function getClaimsSendToExpertSuccess($claimID){
		/*Email Or Notification Send to An Expert*/
		$db = JFactory::getDBO();
		$sql = "SELECT count(*) as emailSend FROM #__expert WHERE id IN(SELECT es.expert_id FROM `#__email_send` as es LEFT JOIN #__survey as s ON s.id = es.survey_id WHERE s.id = '".$claimID."' AND es.status = 0 GROUP BY es.expert_id ,es.survey_id)";		
		$db->setQuery($sql);
		return $db->loadObject();
	}
	
	function getClaimsSendToExpertFailed($claimID){
		/*Email Or Notification Send to An Expert*/
		$db = JFactory::getDBO();
		$sql = "SELECT count(*) as emailSend FROM #__expert WHERE id IN(SELECT es.expert_id FROM `#__email_send` as es LEFT JOIN #__survey as s ON s.id = es.survey_id WHERE s.id = '".$claimID."' AND es.status = 1 GROUP BY es.expert_id ,es.survey_id)";		
		$db->setQuery($sql);
		return $db->loadObject();
	}
	
	function claimSoldReport($surveyID){
		$db = JFactory::getDBO();
		$sql = "SELECT * FROM #__transactions WHERE survey_id = '".$surveyID."' AND type= 0 AND success = 'Paid'";		
		$db->setQuery($sql);
		return $db->loadObjectList();
	}
	
	function getLastQuestionClaim($surveyID){
		$db = JFactory::getDBO();
		$sql = "SELECT * FROM #__question WHERE survey_id = '".$surveyID."' ORDER BY id DESC";		
		$db->setQuery($sql);
		return $db->loadObject();
	}
	
	function getSurveyOrderedDate($surveyID){
		$db = JFactory::getDBO();
		$sql = "SELECT t.* FROM #__projects as p  LEFT JOIN #__survey as s ON s.project_id = p.id LEFT JOIN #__transactions as t ON t.survey_id = p.id WHERE s.id = '".$surveyID."' AND t.type= 1 AND t.success='Paid'";		
		$db->setQuery($sql);
		return $db->loadAssoc();
	}
	
	function surveyEmailExpertList($surveyID,$status){
		$db = JFactory::getDBO();
		$sql = "SELECT em.* , e.name , e.email FROM #__email_send as em LEFT JOIN #__expert as e ON e.id = em.expert_id WHERE em.survey_id = '".$surveyID."' AND em.status='".$status."' GROUP BY em.expert_id";		
		$db->setQuery($sql);
		return $db->loadAssocList();
	}
	
	function getInProcessClaim($surveyID){
		$db = JFactory::getDBO();
		$sql = "SELECT count(*) as inProcess FROM `#__survey_question_answer` as qa LEFT JOIN #__question as q ON q.id = qa.ques_id LEFT JOIN #__survey as s ON s.id = q.survey_id WHERE qa.showed=1 AND s.id = '".$surveyID."' GROUP BY qa.target";
		$db->setQuery($sql);
		return $db->loadObject();
	}
}	
?>
