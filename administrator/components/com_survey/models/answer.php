<?php
// No direct access to this file
defined('_JEXEC') or die('Restricted access');
 
// import Joomla modelform library
jimport('joomla.application.component.modellist');jimport('joomla.utilities.date');
 
/**
 * HelloWorld Model
 */
class SurveyModelAnswer extends JModelList
{	function __construct () {		global $option;		parent::__construct();			}
	/**
	 * Method override to check if you can edit an existing record.
	 *
	 * @param	array	$data	An array of input data.
	 * @param	string	$key	The name of the key for the primary key.
	 *
	 * @return	boolean
	 * @since	1.6
	 */
	
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
	/**
	 * Method to get the record form.
	 *
	 * @param	array	$data		Data for the form.
	 * @param	boolean	$loadData	True if the form is to load its own data (default case), false if not.
	 * @return	mixed	A JForm object on success, false on failure
	 * @since	1.6
	 */
	
	/**
	 * Method to get the script that have to be included on the form
	 *
	 * @return string	Script files
	 */
	
	/**
	 * Method to get the data that should be injected in the form.
	 *
	 * @return	mixed	The data for the form.
	 * @since	1.6
	 */
	function save($data){		$db =& JFactory::getDBO();		$item =& $this->getTable('Answer');				if (!$item->bind($data)){			echo $item->getError().' - 1';			return false;		}		if (!$item->check()) {			echo $item->getError().' - 2';			return false;		}					if (!$item->store()) {			echo $item->getError().' - 3';			return false;		}		return $item->id;	}
}
