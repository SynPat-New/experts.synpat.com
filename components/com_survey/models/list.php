<?php
// No direct access to this file
defined('_JEXEC') or die('Restricted access');
 
// import Joomla modelitem library
jimport('joomla.application.component.modelitem');
 
/**
 * HelloWorld Model
 */
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
	protected function populateState(){
		$app = JFactory::getApplication();
		$this->setState('list.start', $app->getUserStateFromRequest($this->_context . '.list.start', 'limitstart', 0, 'int'));
		$this->setState('list.limit', $app->getUserStateFromRequest('global.list.limit', 'limit', $app->getCfg('list_limit'), 'int'));
		$this->setState('selected', JRequest::getVar('cid', array()));	
		parent::populateState();
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
		$sql = "SELECT s.* , p.name as project_name FROM #__survey as s LEFT JOIN #__projects as p ON p.id = s.project_id  ORDER BY s.`name` ASC";	
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
	public function getTable($type = 'Survey', $prefix = 'SurveyTable', $config = array()) 
	{
		return JTable::getInstance($type, $prefix, $config);
	}
 
	/**
	 * Get the message
	 * @return object The message to be displayed to the user
	 */
	
}
