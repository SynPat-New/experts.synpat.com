<?php

defined ('_JEXEC') or die ("Go away.");


jimport('joomla.application.component.modellist');
jimport('joomla.utilities.date');


class SurveyModelQuestion extends JModelList{
	var $_attributes;
	var $_attribute;
	var $_id = null;
	var $_total = 0;
	var $total = 0;
	var $_pagination = null;
	protected $_context = 'com_survey.question';

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
	
	public function getTable($type = 'Question', $prefix = 'SurveyTable', $config = array()) 
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
				$sql = "DELETE FROM #__question where id=".intval($id);
				$db->setQuery($sql);
				if(!$db->query()){
					return false;
				}
			}
		}
		return $return;
	}

	function getQuestionList(){	
		$app = JFactory::getApplication('administrator');
		$limit		= $app->getUserStateFromRequest( 'limit', 'limit', $app->getCfg('list_limit'), 'int' );
		$limitstart = $app->getUserStateFromRequest('limitstart', 'limitstart', 0, 'int' );		
		$limit_cond = "";
		if($limit!=0){
			$limit_cond = " LIMIT ".$limitstart.",".$limit." ";
		}	
		$db =& JFactory::getDBO();
		$sql = "";
		$sqlQuestion = "";
		$checkUser = $this->checkUserLoggedIn();
		$userLogged = JFactory::getUser();
		$getSurveyID = JRequest::getVar('survey_id','');
		/*
		if($checkUser=='8'){
			if(empty($getSurveyID)){
				$sql =  "SELECT count(*) FROM #__question ORDER BY `id` DESC ";
				$sqlQuestion = "SELECT q.* , s.name as survey_name FROM #__question as q LEFT JOIN #__survey as s ON s.id = q.survey_id ORDER BY q.`id` DESC ".$limit_cond;
			} else {
				$sql =  "SELECT count(*) FROM #__question as q LEFT JOIN #__survey as s ON s.id = q.survey_id WHERE  q.survey_id='".$getSurveyID."' ORDER BY q.`id` DESC  ";
				$sqlQuestion = "SELECT q.* , s.name as survey_name FROM #__question as q LEFT JOIN #__survey as s ON s.id = q.survey_id WHERE q.survey_id='".$getSurveyID."' ORDER BY q.`id` DESC ".$limit_cond;
			}
		} else if($checkUser=='7') {
			if(empty($getSurveyID)){
				$sql =  "SELECT count(*) FROM #__question as q LEFT JOIN #__survey as s ON s.id = q.survey_id WHERE s.user_id='".$userLogged->id."' ORDER BY q.`id` DESC ";
				$sqlQuestion = "SELECT q.* , s.name as survey_name FROM #__question as q LEFT JOIN #__survey as s ON s.id = q.survey_id WHERE s.user_id='".$userLogged->id."' ORDER BY q.`id` DESC ".$limit_cond;
			} else {
				$sql =  "SELECT count(*) FROM #__question as q LEFT JOIN #__survey as s ON s.id = q.survey_id WHERE  q.survey_id='".$getSurveyID."' AND s.user_id='".$userLogged->id."' ORDER BY q.`id` DESC  ";
				$sqlQuestion = "SELECT q.* , s.name as survey_name FROM #__question as q LEFT JOIN #__survey as s ON s.id = q.survey_id WHERE q.survey_id='".$getSurveyID."' AND s.user_id='".$userLogged->id."' ORDER BY q.`id` DESC ".$limit_cond;
			} 
		}
		*/
		if(empty($getSurveyID)){
				$sql =  "SELECT count(*) FROM #__question ORDER BY `question_order` ASC ";
				$sqlQuestion = "SELECT q.* , s.name as survey_name FROM #__question as q LEFT JOIN #__survey as s ON s.id = q.survey_id ORDER BY q.`question_order` ASC ".$limit_cond;
			} else {
				$sql =  "SELECT count(*) FROM #__question as q LEFT JOIN #__survey as s ON s.id = q.survey_id WHERE  q.survey_id='".$getSurveyID."' ORDER BY q.`question_order` ASC  ";
				$sqlQuestion = "SELECT q.* , s.name as survey_name FROM #__question as q LEFT JOIN #__survey as s ON s.id = q.survey_id WHERE q.survey_id='".$getSurveyID."' ORDER BY q.`question_order` ASC ".$limit_cond;
			}
		//$sql =  "SELECT count(*) FROM #__question ORDER BY `name` ASC ";
		$db->setQuery($sql);
		$db->query();
		$this->_total = $db->loadResult();	    
		//$sql =  "SELECT q.* , s.name as survey_name FROM #__question as q LEFT JOIN #__survey as s ON s.id = q.survey_id ORDER BY q.`id` DESC ".$limit_cond;						
		$db->setQuery($sqlQuestion);
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
		$db =& JFactory::getDBO();
		$sql = "";
		$sqlQuestion = "";
		$checkUser = $this->checkUserLoggedIn();
		$userLogged = JFactory::getUser();
		
		$getSurveyID = JRequest::getVar('survey_id','');
		/*
		if($checkUser=='8'){
			if(empty($getSurveyID)){
				$sql =  "SELECT count(*) FROM #__question ORDER BY `id` DESC ";
				$sqlQuestion = "SELECT q.* , s.name as survey_name, s.combine_name as combineName FROM #__question as q LEFT JOIN #__survey as s ON s.id = q.survey_id ORDER BY q.`id` DESC ";
			} else {
				$sql =  "SELECT count(*) FROM #__question as q LEFT JOIN #__survey as s ON s.id = q.survey_id WHERE  q.survey_id='".$getSurveyID."' ORDER BY q.`id` DESC  ";
				$sqlQuestion = "SELECT q.* , s.name as survey_name, s.combine_name as combineName FROM #__question as q LEFT JOIN #__survey as s ON s.id = q.survey_id WHERE q.survey_id='".$getSurveyID."' ORDER BY q.`id` DESC ";
			}
		} else if($checkUser=='7') {
			if(empty($getSurveyID)){
				$sql =  "SELECT count(*) FROM #__question as q LEFT JOIN #__survey as s ON s.id = q.survey_id WHERE s.user_id='".$userLogged->id."' ORDER BY q.`id` DESC ";
				$sqlQuestion = "SELECT q.* , s.name as survey_name,  s.combine_name as combineName FROM #__question as q LEFT JOIN #__survey as s ON s.id = q.survey_id WHERE s.user_id='".$userLogged->id."' ORDER BY q.`id` DESC ";
			} else {
				$sql =  "SELECT count(*) FROM #__question as q LEFT JOIN #__survey as s ON s.id = q.survey_id WHERE  q.survey_id='".$getSurveyID."' AND s.user_id='".$userLogged->id."' ORDER BY q.`id` DESC  ";
				$sqlQuestion = "SELECT q.* , s.name as survey_name, s.combine_name as combineName FROM #__question as q LEFT JOIN #__survey as s ON s.id = q.survey_id WHERE q.survey_id='".$getSurveyID."' AND s.user_id='".$userLogged->id."' ORDER BY q.`id` DESC ";
			} 
		}
		*/
		if(empty($getSurveyID)){
				$sql =  "SELECT count(*) FROM #__question ORDER BY `question_order` ASC ";
				$sqlQuestion = "SELECT q.* , s.name as survey_name, s.combine_name as combineName FROM #__question as q LEFT JOIN #__survey as s ON s.id = q.survey_id ORDER BY q.`question_order` ASC ";
			} else {
				$sql =  "SELECT count(*) FROM #__question as q LEFT JOIN #__survey as s ON s.id = q.survey_id WHERE  q.survey_id='".$getSurveyID."' ORDER BY q.`question_order` ASC  ";
				$sqlQuestion = "SELECT q.* , s.name as survey_name, s.combine_name as combineName FROM #__question as q LEFT JOIN #__survey as s ON s.id = q.survey_id WHERE q.survey_id='".$getSurveyID."' ORDER BY q.`question_order` ASC ";
			}
		
		//$sql =  "SELECT count(*) FROM #__question ORDER BY `name` ASC ";
		$db->setQuery($sql);
		$db->query();
		$this->_total = $db->loadResult();	    
		//$sql =  "SELECT q.* , s.name as survey_name FROM #__question as q LEFT JOIN #__survey as s ON s.id = q.survey_id ORDER BY q.`id` DESC ";
		$db->setQuery($sqlQuestion);
		//echo $sqlQuestion;
		$db->query();
		$result = $db->loadAssocList();		
		return $sqlQuestion;	
	}
	
	function getSurveyList(){
		$db =& JFactory::getDBO();
		$sql = "SELECT * FROM #__survey ORDER BY name ASC";
		$db->setQuery($sql);
		return $db->loadObjectList();
	}
	
	function getSurveyData($ID){
		$db =& JFactory::getDBO();
		$sql = "SELECT * FROM #__survey WHERE id='".$ID."'";
		$db->setQuery($sql);
		return $db->loadObject();
	}
	function getProjectSurveyData($surveyID){
		$db =& JFactory::getDBO();
		$sql = "SELECT p.* FROM #__survey as s LEFT JOIN #__projects as p ON p.id = s.project_id WHERE s.id='".$surveyID."'";
		$db->setQuery($sql);
		return $db->loadObject();
	}
	function getQuestionUpdateList($surveyID){
		if($surveyID>0){
			$db = JFactory::getDBO();
			$sql = "SELECT * FROM #__question WHERE survey_id='".$surveyID."' ORDER BY question_order ASC";
			$db->setQuery($sql);
			return $db->loadObjectList();
		} else {
			return array();
		}
	}
	
	function insertNotification($surveyID,$expertID){
		$db = JFactory::getDBO();
		$sql = "INSERT INTO #__notification (`survey_id`,`expert_id`,`created_date`) VALUES ('".$surveyID."','".$expertID."','".date('Y-m-d H:i:s',strtotime('now'))."')";
		$db->setQuery($sql);
		$db->query();
	}
	
	function getQuestionDetails(){
		$db =& JFactory::getDBO();
		$question_id = "";
		$id_val = JRequest::getVar("cid", "", "post", "array");
		if(is_array($id_val) && count($id_val) > 0 && $id_val["0"] != ""){
			$cids = JRequest::getVar("cid", "", "post", "array");
			$question_id = $cids[0];
		}
		else{
			$question_id = JRequest::getVar("id", "0", "", "int");		
		}		
		$result = new StdClass();
		if($question_id > 0){
			$sql = "SELECT q.* , s.name as survey_name , s.id as survey_id FROM #__question as q LEFT JOIN #__survey as s ON s.id = q.survey_id WHERE q.id=".$question_id;
			$db->setQuery($sql);
			$db->query();
			$result = $db->loadObject();			
			$result->id = $question_id;					
		} else{
			$get = JRequest::get();
			foreach($get as $key => $val){
				$result->$key = $val;
			}
		}
		if(!isset($result->id)){
			$result->id = 0;
		}
		if(!isset($result->survey_id)){
			$result->survey_id = "";
		}
		
		if(!isset($result->description)){
			$result->description = "";
		}					
		return $result;
	}
	
	function getAreaExpertise(){
		$db =& JFactory::getDBO();
		$sql = "SELECT * FROM #__expertisearea WHERE `parent`=0 ORDER BY name DESC";
		$db->setQuery($sql);
		return $db->loadObjectList();
	}
	
	function findExpertWithCode($code,$mode){
		$db = JFactory::getDBO();
		if($mode==2){
		$sql = "SELECT distinct(ma.expert_id),u.email,e.name, e.id FROM #__expertisearea as ea INNER JOIN #__map_area_expertise as ma ON ma.area_id = ea.id INNER JOIN #__expert as e ON e.id = ma.expert_id INNER JOIN #__users as u ON u.id = e.user_id  WHERE ea.name LIKE '%".$code."%'";
		} else {
			$sql = "SELECT count(distinct(ma.expert_id)) as countData FROM #__expertisearea as ea INNER JOIN #__map_area_expertise as ma ON ma.area_id = ea.id INNER JOIN #__expert as e ON e.id = ma.expert_id INNER JOIN #__users as u ON u.id = e.user_id  WHERE ea.name LIKE '%".$code."%'";
		} 
		$db->setQuery($sql);
		if($mode==2){
			return $db->loadObjectList();			
		} else {
			$getData = $db->loadObject();				
			return $getData->countData;
		}
	}
	
	function save($data){
		$db =& JFactory::getDBO();
		$item =& $this->getTable('Question');		
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
	
	function findExpertAccToArea($areasIDs){
		$db = JFactory::getDBO();
		$sql = "SELECT * FROM #__map_area_expertise as me LEFT JOIN #__expert as e ON me.expert_id = e.id WHERE me.area_id IN(".$areasIDs.") GROUP BY e.id";
		$db->setQuery($sql);
		return $db->loadObjectList();
	}
	
	function deleteInsertAreaSurvey($surveyID,$areaExpertise){
		$db = JFactory::getDBO();
		$sql =" DELETE FROM #__area_survey WHERE survey_id ='".$surveyID."'";
		$db->setQuery($sql);
		if($db->query()){
			if(count($areaExpertise)>0){
				for($i=0;$i<count($areaExpertise);$i++){
					$sql = "INSERT INTO #__area_survey (`survey_id`,`area_id`) VALUES ('".$surveyID."','".$areaExpertise[$i]."')";
					$db->setQuery($sql);
					$db->query();
				}
			}
		}
	}
	
	function getAreaExpertiseForSurvey($surveyID){
		$db = JFactory::getDBO();
		$sql = "SELECT * FROM #__area_survey WHERE survey_id='".$surveyID."'";
		$db->setQuery($sql);
		return $db->loadObjectList();
	}
	
	function surveyDetail($surveyID){
		$db = JFactory::getDBO();
		$sql = "SELECT * FROM #__survey WHERE id = '".$surveyID."'";
		$db->setQuery($sql);
		return $db->loadObject();
	}
	
	function insertEmailSend($surveyID,$expertID,$status){
		$db = JFactory::getDBO();
		$sql = "INSERT INTO #__email_send (`survey_id`,`expert_id`,`status`,`send_date`) VALUES ('".$surveyID."','".$expertID."','".$status."','".date('Y-m-d H:i:s',strtotime('now'))."') ";
		$db->setQuery($sql);
		$db->query();		
	}
	
	function insertMessageSend($surveyID){
		$db = JFactory::getDBO();
		$sql = "SELECT * FROM #__message_send WHERE survey_id ='".$surveyID."'";
		$db->setQuery($sql);
		$getData = $db->loadObject();
		if(count($getData)==0){
		 	$sql = "INSERT INTO #__message_send(survey_id ,send_date  )VALUES('".$surveyID."','".date('Y-m-d H:i:s',strtotime('now'))."')";
			$db->setQuery($sql);
			$db->query();
		}
	}
	
	function getClaimSendReport($surveyID){
		$db = JFactory::getDBO();
		$sql = "SELECT count(*) FROM #__email_send WHERE survey_id='".$surveyID."'";
		$db->setQuery($sql);
		return $db->loadObject();
	}
	
	function deleteQuestionare($surveyID){
		$db = JFactory::getDBO();
		$sql = "DELETE FROM #__question WHERE survey_id='".$surveyID."'";
		$db->setQuery($sql);
		if($db->query()){
			return 1;
		} else {
			return 0;
		}
	}
	
	function getChildExpertise($parentID){
		$db = JFactory::getDBO();
		$sql = "SELECT * FROM #__expertisearea WHERE parent='".$parentID."' ORDER BY id ASC";
		$db->setQuery($sql);
		return $db->loadObjectList();
	}
	
	function getAllExpertByAreaID($expertAreaID){
		$db = JFactory::getDBO();
		$sql = "SELECT e.id , e.name , e.email FROM #__expert as e INNER JOIN #__map_area_expertise as mae ON mae.expert_id = e.id WHERE mae.area_id IN(".$expertAreaID.") GROUP BY e.id";
		$db->setQuery($sql);
		return $db->loadObjectList();
	}
        
    function getSingleExpert($id){
		$db = JFactory::getDBO();
		$sql = "SELECT * FROM #__expert WHERE id = $id";
		$db->setQuery($sql);
		return $db->loadObject();
	}
	
}	
?>
