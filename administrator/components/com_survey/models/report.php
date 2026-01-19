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


class SurveyModelReport extends JModelList{
	var $_attributes;
	var $_attribute;
	var $_id = null;
	var $_total = 0;
	var $total = 0;
	var $_pagination = null;
	protected $_context = 'com_survey.report';

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
	

	function getListQuery(){
		$app = JFactory::getApplication('administrator');
		$limit = $app->getUserStateFromRequest( 'global.list.limit', 'limit', $app->getCfg('list_limit'), 'int' );
		$limitstart = $app->getUserStateFromRequest( 'limitstart', 'limitstart', 0, 'int' );
		
		$limit_cond = "";
		if($limit!=0){
			$limit_cond = " LIMIT ".$limitstart.",".$limit." ";
		}	
		$db =& JFactory::getDBO();
		$sql = "SELECT p.name as ProjectName , p.id as projectID , s.id as surveyID, s.combine_name as combineName ,qa.target as target, qa.expert_id as expertID, e.name as expertName FROM `#__survey_question_answer` as qa LEFT JOIN #__question as q ON q.id = qa.ques_id LEFT JOIN #__survey as s ON s.id = q.survey_id LEFT JOIN #__projects as p ON p.id = s.project_id LEFT JOIN #__expert as e ON e.id = qa.expert_id WHERE qa.showed=0 GROUP BY qa.target";		
		$db->setQuery($sql);
		$db->query();
		$this->_total = $db->loadResult();
		return $sql;	
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
		$sql = "SELECT count(*) as emailSend FROM #__expert WHERE id IN(SELECT es.expert_id FROM `#__email_send` as es LEFT JOIN #__survey as s ON s.id = es.survey_id WHERE s.project_id = '".$projectID."' AND es.status = 0 GROUP BY es.expert_id ,es.survey_id)";		
		$db->setQuery($sql);
		return $db->loadObject();
	}
	
	function getReportsCreatedByExpert($projectID){
		/* Answer by Expert for each Claim under Project*/
		$db = JFactory::getDBO();
		$sql = "SELECT count(*) as countReports FROM #__expert as e WHERE e.id IN(SELECT qa.expert_id FROM `#__survey_question_answer` as qa LEFT JOIN #__question as q ON q.id = qa.ques_id LEFT JOIN #__survey as s ON s.id = q.survey_id WHERE qa.showed=0 AND s.project_id = '".$projectID."' GROUP BY qa.target , s.project_id)";
		$db->setQuery($sql);
		return $db->loadObject();
	}
	
	function getClaimOrderDate($projectID){
		$db = JFactory::getDBO();
		$sql = "SELECT * FROM #__transactions WHERE survey_id = '".$projectID."' AND type=1 AND success='Paid'";
		$db->setQuery($sql);
		return $db->loadObject();
	}
	function getClaimDateToExpert($claimID){
		$db = JFactory::getDBO();
		$sql = "SELECT *  FROM #__message_send WHERE survey_id='".$claimID."'";
		$db->setQuery($sql);
		return $db->loadObject();
	}
	
	function getQuestionAnswerList($surveyID , $expertID , $target){
		$db = JFactory::getDBO();
		$sql = "SELECT q.id as qID , qa.id as qaID , qa.created_date as created_date FROM #__question as q LEFT JOIN #__survey_question_answer as qa ON qa.ques_id = q.id WHERE q.survey_id='".$surveyID."' AND qa.showed=0 AND qa.expert_id='".$expertID."' AND qa.target='".$target."'  ORDER BY qa.id" ;
		$db->setQuery($sql);
		return $db->loadObjectList();
	}
	
	function getPriceSetByExpertForSurvey($expertID,$surveyID,$target){
		$db = JFactory::getDBO();
		$sql = "SELECT *  FROM #__survey_amount_expert WHERE survey_id='".$surveyID."' AND expert_id='".$expertID."' AND target ='".$target."'";
		$db->setQuery($sql);
		return $db->loadObject();
	}
	
	function getSurveyPurchaseTransaction($surveyID){
		$db = JFactory::getDBO();
		$sql = "SELECT * FROM #__transactions WHERE survey_id = '".$surveyID."' AND type=0 AND success='Paid'";
		$db->setQuery($sql);
		return $db->loadObjectList();	
	}
	
	function getReport($surveyID,$expertID){
		$db = JFactory::getDBO();
		$sql = "SELECT qa.* , q.id as quesID , q.description as description FROM #__question as q LEFT JOIN #__survey_question_answer as qa ON qa.ques_id = q.id WHERE q.survey_id = '".$surveyID."' AND qa.expert_id = '".$expertID."'";
		$db->setQuery($sql);
		return $db->loadAssocList();	
	}
	
}	
?>
