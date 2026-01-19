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


class SurveyModelOrder extends JModelList{
	var $_attributes;
	var $_attribute;
	var $_id = null;
	var $_total = 0;
	var $total = 0;
	var $_pagination = null;
	protected $_context = 'com_survey.order';

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
	
	public function getTable($type = 'Order', $prefix = 'SurveyTable', $config = array()) 
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
		$sql = "SELECT t.* , p.name as projectName , p.id as projectID , s.id as surveyID , s.name as surveyName , s.combine_name as combineName , s.deadline  FROM #__transactions as t LEFT JOIN #__projects as p ON p.id = t.survey_id  LEFT JOIN #__survey as s ON s.project_id = p.id WHERE t.type=1 AND t.success = 'Paid' GROUP BY projectID ORDER BY id DESC ";	
*/		
		$sql = "SELECT t.* , p.name as projectName,p.description , p.id as projectID , s.id as surveyID , s.name as surveyName , s.combine_name as combineName , s.deadline, s.specific_expert  FROM #__transactions as t LEFT JOIN #__projects as p ON p.id = t.survey_id  LEFT JOIN #__survey as s ON s.project_id = p.id WHERE t.type=1 GROUP BY projectID ORDER BY id DESC ";
		$db->setQuery($sql);
		$db->query();
		$this->_total = $db->loadResult();
		return $sql;	
	}
	
	function getQuestionaresPrepared($projectID){
		$db = JFactory::getDBO();
		$sql = "SELECT count(*) as countQuestionare FROM #__question as q LEFT JOIN #__survey as s ON s.id = q.survey_id LEFT JOIN #__projects as p ON p.id = s.project_id WHERE p.id='".$projectID."' GROUP BY s.project_id";
		$db->setQuery($sql);
		return $db->loadObject();		
	}
	
	function getSurveyList(){
		$db =& JFactory::getDBO();
		$sql = "SELECT * FROM #__survey ORDER BY name ASC";
		$db->setQuery($sql);
		return $db->loadObjectList();
	}
	function getPatentList($projectID){
		$db =& JFactory::getDBO();
		$sql = "SELECT * FROM #__survey WHERE project_id='".$projectID."' ORDER BY name ASC";
		$db->setQuery($sql);
		return $db->loadObjectList();
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
	
	function getClaimsSendToExpert($projectID){
		/*Email Or Notification Send to An Expert*/
		$db = JFactory::getDBO();
		$sql = "SELECT count(*) as emailSend  FROM `#__email_send` as es LEFT JOIN #__survey as s ON s.id = es.survey_id WHERE s.project_id = '".$projectID."' AND es.status = 0 ";		
		$db->setQuery($sql);
		return $db->loadObject();
	}
	
	function getReportsCreatedByExpert($projectID){
		/* Answer by Expert for each Claim under Project*/
		$db = JFactory::getDBO();
		$sql = "SELECT qa.expert_id FROM `#__survey_question_answer` as qa LEFT JOIN #__question as q ON q.id = qa.ques_id LEFT JOIN #__survey as s ON s.id = q.survey_id WHERE qa.showed=0 AND s.project_id = '".$projectID."' GROUP BY qa.target,s.project_id";
		$db->setQuery($sql);
		return $db->loadObjectList();
	}
	
	function getCCInProcess($projectID){
		$db = JFactory::getDBO();
		$sql = "SELECT count(*) as inProcess FROM `#__survey_question_answer` as qa LEFT JOIN #__question as q ON q.id = qa.ques_id LEFT JOIN #__survey as s ON s.id = q.survey_id WHERE qa.showed=1 AND s.project_id = '".$projectID."' GROUP BY qa.target,s.project_id";
		$db->setQuery($sql);
		return $db->loadObject();
	}
	
}	
?>
