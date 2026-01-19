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


class SurveyModelEmail extends JModelList{
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
	
	function findExpertFromUserName($userName){
		$db = jFactory::getDBO();
		$sql = "SELECT e.* FROM #__expert as e INNER JOIN #__users as u ON u.id = e.user_id WHERE u.username='".$userName."'";
		$db->setQuery($sql);
		return $db->loadObject();
	}
	
	function expertListAccAreaInClaim($surveyID){
		$db = JFactory::getDBO();
		$sql = "SELECT * FROM #__map_area_expertise as me LEFT JOIN #__expert as e ON me.expert_id = e.id WHERE me.area_id IN(SELECT area_id FROM #__area_survey WHERE survey_id = '".$surveyID."') GROUP BY e.name";
		$db->setQuery($sql);
		return $db->loadObjectList();
	}
	
	function allExpert(){
		$db = JFactory::getDBO();
		$sql = "SELECT * FROM #__expert as e ORDER BY e.name";
		$db->setQuery($sql);
		return $db->loadObjectList();
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
	
	function getParentExpertise(){
		$db = JFactory::getDBO();
		$sql = "SELECT * FROM #__expertisearea WHERE parent=0 ORDER BY id DESC";
		$db->setQuery($sql);
		return $db->loadObject();
	}
	function getChildExpertise($parentID){
		$db = JFactory::getDBO();
		$sql = "SELECT * FROM #__expertisearea WHERE parent='".$parentID."' ORDER BY id ASC";
		$db->setQuery($sql);
		return $db->loadObjectList();
	}
}	
?>
