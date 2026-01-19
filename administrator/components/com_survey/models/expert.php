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


class SurveyModelExpert extends JModelList{
	var $_attributes;
	var $_attribute;
	var $_id = null;
	var $_total = 0;
	var $total = 0;
	var $_pagination = null;
	protected $_context = 'com_survey.expert';

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
	
	public function getTable($type = 'Expert', $prefix = 'SurveyTable', $config = array()) 
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
	//	$db->setQuery($query, $limistart, $limit);
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
				$sql = "DELETE FROM #__expert where id=".intval($id);
				$db->setQuery($sql);
				if(!$db->query()){
					return false;
				}
			}
		}
		return $return;
	}

	function getExpertList(){	
		$app = JFactory::getApplication('administrator');
		$limit		= $app->getUserStateFromRequest( 'limit', 'limit', $app->getCfg('list_limit'), 'int' );
		$limitstart = $app->getUserStateFromRequest('limitstart', 'limitstart', 0, 'int' );		
		$limit_cond = "";
		if($limit!=0){
			$limit_cond = " LIMIT ".$limitstart.",".$limit." ";
		}	
		$db =& JFactory::getDBO();
		$sql =  "SELECT count(*) FROM #__expert ORDER BY `name` ASC ";
		$db->setQuery($sql);
		$db->query();
		$this->_total = $db->loadResult();	    
		$sql =  "SELECT * FROM #__expert ORDER BY `name` ASC ".$limit_cond;						
		$db->setQuery($sql);
		$db->query();
		$result = $db->loadAssocList();
		return $result;
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
		$sql =  "SELECT count(*) FROM #__expert ORDER BY `name` ASC ";
		$db->setQuery($sql);
		$db->query();
		$this->_total = $db->loadResult();	    
		$sql =  "SELECT * FROM #__expert ORDER BY `name` ASC ";						
		
		$db->setQuery($sql);
		$db->query();
		$result = $db->loadAssocList();		
		return $sql;	
	}
	
	
	
	
	function getExpertDetails(){
		$db =& JFactory::getDBO();
		$expert_id = "";
		$id_val = JRequest::getVar("cid", "", "post", "array");
		if(is_array($id_val) && count($id_val) > 0 && $id_val["0"] != ""){
			$cids = JRequest::getVar("cid", "", "post", "array");
			$expert_id = $cids[0];
		}
		else{
			$expert_id = JRequest::getVar("id", "0", "", "int");		
		}		
		$result = new StdClass();
		
		if($expert_id > 0){
			$sql = "SELECT * FROM #__expert WHERE id=".$expert_id;
			$db->setQuery($sql);
			$db->query();
			$result = $db->loadObject();			
			$result->id = $expert_id;					
		} else{
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
		return $result;
	}
	
	function save($data){
		$db =& JFactory::getDBO();
		$item =& $this->getTable('Expert');		
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
	
	function expertRatingData($expertID){
		$db = JFactory::getDBO();
		$sql = "SELECT sum(er.rating) as rating, count(er.survey_id) as countSurvey , s.id as surveyID , s.name as surveyName,e.name as expertName ,  e.linkedin_pic as linkedin_pic, e.linkedin_profile_url as linkedin_profile_url FROM #__expertrating as er LEFT JOIN #__expert as e ON e.id = er.expert_id LEFT JOIN #__survey as s ON s.id = er.survey_id WHERE er.expert_id='".$expertID."' GROUP BY er.survey_id";
		$db->setQuery($sql);
		return $db->loadObjectList();
	}
	
	function getSurveyList(){
		$db =& JFactory::getDBO();
		$sql = "SELECT * FROM #__survey ORDER BY `name` ASC";
		$db->setQuery($sql);
		return $db->loadObjectList();
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
	
	function getProjectList(){
		$db =& JFactory::getDBO();
		$userLogged = JFactory::getUser();
		$checUser = $this->checkUserLoggedIn();
		$sql = "";
		if($checUser==8){
			$sql = "SELECT * FROM #__projects ORDER BY `name` ASC";
		} else if($checUser==7) {
			$sql = "SELECT * FROM #__projects WHERE user_id='".$userLogged->id."' ORDER BY `name` ASC";
		}
		$db->setQuery($sql);
		return $db->loadObjectList();
	}
	
	function getExpertSurveySent($expertID){
		$db = JFactory::getDBO();
		$sql = "SELECT count(*) as noOfSurveySend FROM #__email_send as es WHERE es.expert_id ='".$expertID."' Group by survey_id";
		$db->setQuery($sql);
		return $db->loadObject();
	}
	
	function getExpertAreaExpertise($expertID){
		$db = Jfactory::getDBO();
		$sql = "SELECT ma.* , ea.name FROM #__map_area_expertise as ma LEFT JOIN #__expertisearea as ea ON ea.id = ma.area_id WHERE ma.expert_id = '".$expertID."'";
		$db->setQuery($sql);
		return $db->loadObjectList();
	}
	
	function getNoOfReportSubmit($expertID){
		$db = JFactory::getDBO();
		$sql = "SELECT COUNT(*) as surveyCount FROM #__survey as s WHERE id IN (SELECT q.survey_id FROM #__survey_question_answer as qa LEFT JOIN #__question as q ON q.id = qa.ques_id WHERE qa.expert_id ='".$expertID."' Group by q.survey_id)";
		$db->setQuery($sql);
		return $db->loadObject();
	}
	
	function getNoOfReportSold($expertID){
		$db = JFactory::getDBO();
		$sql = "SELECT count(*) as reportSold FROM `#__transactions` WHERE expert_id = '".$expertID."' AND type=0 AND success='Paid' GROUP BY survey_id";
		$db->setQuery($sql);
		return $db->loadObject();
	}
	function getRevenueGenerate($expertID){
		$db = JFactory::getDBO();
		$sql = "SELECT sum(`amount`) as revenueGenerate FROM `#__transactions` WHERE expert_id = '".$expertID."' AND type=0 AND success='Paid' ";
		$db->setQuery($sql);
		return $db->loadObject();
	}
	
	 function publishList($cid = array(), $publish) {
        if (count( $cid ))
         {
             JArrayHelper::toInteger($cid);
             $cids = implode( ',', $cid );
           $query = 'UPDATE #__expert'
                   . ' SET published = '.(int) $publish
                   . ' WHERE id IN ( '.$cids.' )';
                  
              $db = JFactory::getDBO();
             $db->setQuery( $query );
                if (!$db->query()) {
                    $this->setError($db->getErrorMsg());
                    return false;
                 }
           }
           return true;
	}
	
	function getExpertFeedback($expertID){
		$db = JFactory::getDBO();
		$sql = "SELECT er.* , s.combine_name as combineName FROM #__expertrating as er LEFT JOIN #__survey as s ON s.id = er.survey_id WHERE er.expert_id = '".$expertID."' ORDER BY er.id DESC";
		$db->setQuery($sql);
		return $db->loadAssocList();		
	}
	
	function deleteList($cid){
		if (count( $cid ))
         {
             JArrayHelper::toInteger($cid);
             $cids = implode( ',', $cid );
			 $query = 'DELETE FROM #__expertrating WHERE id IN ( '.$cids.' )';
             $db = JFactory::getDBO();
             $db->setQuery( $query );
                if (!$db->query()) {
                    $this->setError($db->getErrorMsg());
                    return false;
                 }
           }
           return true;
	}
	
	function inProcessReport($projectID){
		$db = JFactory::getDBO();
		$sql = "SELECT e.name as name , s.combine_name as combineName , qa.target , e.id as expertID FROM `#__survey_question_answer` as qa LEFT JOIN #__question as q ON q.id = qa.ques_id LEFT JOIN #__survey as s ON s.id = q.survey_id LEFT JOIN #__expert as e ON e.id = qa.expert_id WHERE qa.showed=1 AND s.project_id = '".$projectID."' GROUP BY qa.target,s.project_id";
		$db->setQuery($sql);
		return $db->loadAssocList();	
	}
	
	function getExpertData($expertID){
		$db = JFactory::getDBO();
		$sql = "SELECT * FROM #__expert WHERE id=".$expertID;
		$db->setQuery($sql);
		return $db->loadObject();
	}
}	
?>
