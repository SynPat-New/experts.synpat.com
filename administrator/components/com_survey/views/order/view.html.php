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

jimport ("joomla.application.component.view");

class SurveyViewOrder extends JView {
	
	function display ($tpl =  null ){			
		JToolBarHelper::title(JText::_( 'Order Lists'));
		/*JToolBarHelper::deleteList('Are you sure want to delete question','order.delete');*/
		JToolBarHelper::cancel();		
		$projectList =& $this->get('Items');
		$pagination = & $this->get( 'Pagination' );		
		$this->assignRef('authorList', $projectList);
		$this->assignRef('pagination', $pagination);		
		parent::display($tpl);

	}
	
	

}

?>
