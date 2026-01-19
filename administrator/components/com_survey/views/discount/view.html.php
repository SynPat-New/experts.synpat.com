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

class SurveyViewDiscount extends JView {
	
	function display ($tpl =  null ){			
		JToolBarHelper::title(JText::_( 'Discount Lists'));
		/*JToolBarHelper::deleteList('Are you sure want to delete question','order.delete');*/
		JToolBarHelper::addNew('discount.new','Create New Coupon');
		JToolBarHelper::cancel();		
		$projectList =& $this->get('Items');
		$pagination = & $this->get( 'Pagination' );		
		$this->assignRef('authorList', $projectList);
		$this->assignRef('pagination', $pagination);		
		parent::display($tpl);

	}
	
	function editform($tpl = null){
		JToolBarHelper::title(JText::_('New Discount Coupon'));
		JToolBarHelper::save('discount.save');
		JToolBarHelper::cancel('discount.cancelSave');	
		parent::display($tpl);
	
	}

}

?>
