<?php
// No direct access to this file
defined('_JEXEC') or die('Restricted access');
 
// Include dependancy of the main model form
jimport('joomla.application.component.modellist');
jimport('joomla.application.component.helper');

class SurveyModelProject extends JModelList
{
		protected $item;
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
		$sql =  "SELECT count(*) FROM #__projects as p ORDER BY p.`name` ASC ";
		$db->setQuery($sql);
		$db->query();
		$this->_total = $db->loadResult();	    
		$sql = "SELECT * FROM #__projects as p ORDER BY p.`name` ASC";	
		$db->setQuery($sql);
		$db->query();
		$result = $db->loadAssocList();		
		return $sql;	
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
	public function getTable($type = 'Project', $prefix = 'SurveyTable', $config = array()) 
	{
		return JTable::getInstance($type, $prefix, $config);
	}
	
	public function expertFromSession(){
		$session = JFactory::getSession();
		$getSession = $session->get('expertSession');
		//print_r($getSession);
		return $getSession;
	}
	
	function delete($projectID){
		$db =& JFactory::getDBO();
		$cids = JRequest::getVar('cid', 0, '', 'array');
		$return = "";
		$sql = "delete from #__projects where id=".intval($projectID);
		$db->setQuery($sql);
		if(!$db->query()){
			return false;
		}
		return $return;
	}
	
	function save($data){
		$db =& JFactory::getDBO();
		$item =& $this->getTable('Projects');		
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
	
	function getExpertAreaOfExpertise($expertID){
		$db = JFactory::getDBO();
		$sql = "SELECT ae.* , ea.name FROM #__map_area_expertise as ae INNER JOIN #__expertisearea as ea.id = ae.area_id WHERE ae.expert_id='".$expertID."'";
		$db->setQuery($sql);
		return $db->loadObjectList();
	}
	
	function getAreaOfExpertise(){
		$db = JFactory::getDBO();
		$sql = "SELECT * FROM #__expertisearea ORDER BY name ASC";
		$db->setQuery($sql);
		return $db->loadObjectList();
	}
}
