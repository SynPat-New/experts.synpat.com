<?php
// No direct access to this file
defined('_JEXEC') or die('Restricted access');
 
// import Joomla modelitem library
jimport('joomla.application.component.modellist');
jimport('joomla.application.component.helper');
 

class SurveyModelSurvey extends JModelList
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
	 /*
	protected function populateState() 
	{
		$app = JFactory::getApplication();
		// Get the message id
		$id = JRequest::getInt('id');
		$this->setState('survey.id', $id);
 
		// Load the parameters.
		$params = $app->getParams();
		$this->setState('params', $params);
		parent::populateState();
	}
	*/
	/*
	protected function populateState(){
		$app = JFactory::getApplication();
		$this->setState('list.start', $app->getUserStateFromRequest($this->_context . '.list.start', 'limitstart', 0, 'int'));
		$this->setState('list.limit', $app->getUserStateFromRequest('global.list.limit', 'limit', $app->getCfg('list_limit'), 'int'));
		$this->setState('selected', JRequest::getVar('cid', array()));	
		parent::populateState();
	}
	*/
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
		$app = JFactory::getApplication();
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
	
	function getListQuery(){
		$app = JFactory::getApplication();
		$limit = $app->getUserStateFromRequest( 'global.list.limit', 'limit', $app->getCfg('list_limit'), 'int' );
		$limitstart = $app->getUserStateFromRequest( 'limitstart', 'limitstart', 0, 'int' );
		
		$limit_cond = "";
		if($limit!=0){
			$limit_cond = " LIMIT ".$limitstart.",".$limit." ";
		}	
		$db =& JFactory::getDBO();
		$sql =  "SELECT count(*) FROM #__survey ORDER BY `name` ASC ";
		$db->setQuery($sql);
		$db->query();
		$this->_total = $db->loadResult();	    
		$param = JRequest::getVar('ps');
		$getQueryString = base64_decode($param);
		$getStringArray = explode('@',$getQueryString);
		$projectID = 0;
		if(count($getStringArray)==3){
			$projectID = $getStringArray[1];
		}
		if($projectID!=0){
			$sqlUpdate = "UPDATE #__notification SET status=1 WHERE survey_id IN(SELECT id FROM #__survey WHERE project_id='".$projectID."')";
			$db->setQuery($sqlUpdate);
			$db->query();
			$sql = "SELECT s.* , p.name as project_name , p.id as projectID  FROM #__survey as s LEFT JOIN #__projects as p ON p.id = s.project_id WHERE s.project_id='".$projectID."'  ORDER BY s.`name` ASC";	
			$db->setQuery($sql);
			$db->query();
			$result = $db->loadAssocList();		
			return $sql;
		} else{
			$app = JFactory::getApplication();
			$app->redirect('index.php?option=com_survey&task=survey.login');
			jexit;
		}
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
	public function getTable($type = 'Survey', $prefix = 'SurveyTable', $config = array()) 
	{
		return JTable::getInstance($type, $prefix, $config);
	}
 
	/**
	 * Get the message
	 * @return object The message to be displayed to the user
	 */
	public function checkExperExist($expertID){
		$db = & JFactory::getDBO();
		$sql = "SELECT * FROM #__expert WHERE id=".$expertID;
		$db->setQuery($sql);
		return $db->loadObject();		
	}
	
	public function userLogin($username,$password){
		$db = & JFactory::getDBO();
		$sql = "SELECT * FROM #__expert WHERE username='".$username."' AND password='".md5($password)."' AND published=1";
		$db->setQuery($sql);
		return $db->loadObject();		
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
	
	function delete($surveyID){
		$db =& JFactory::getDBO();
		$cids = JRequest::getVar('cid', 0, '', 'array');
		$return = "";
		$sql = "DELETE FROM #__survey where id=".intval($surveyID);
		$db->setQuery($sql);
		if(!$db->query()){
			return false;
		}
		return $return;
	}
	
	function expertUserData($expertID){
		$db = JFactory::getDBO();
		$sql = "SELECT * FROM #__expert WHERE user_id='" . (int) $expertID. "'";
		$db->setQuery($sql);
		return $db->loadObject();
	}
	
	function findCoupon($couponCode){
		$db = JFactory::getDBO();
		$sql = "SELECT * FROM #__discount WHERE (coupon_code='".$couponCode."') AND '".date('Y-m-d')."' BETWEEN start_date AND end_date";
		$db->setQuery($sql);
		return $db->loadObject();
	}
}
