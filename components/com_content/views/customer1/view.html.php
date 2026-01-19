<?php
/**
 * @copyright	Copyright (C) 2005 - 2014 Open Source Matters, Inc. All rights reserved.
 * @license		GNU General Public License version 2 or later; see LICENSE.txt
 */

defined('_JEXEC') or die;

/**
 * HTML Article View class for the Content component
 *
 * @package		Joomla.Site
 * @subpackage	com_content
 * @since		1.5
 */
class ContentViewCustomer extends JViewLegacy
{
	public function display($tpl = null){
		// Initialise variables.
		echo "Ad";
		
		die;
		$segments = explode('/', trim(parse_url(JURI::current(), PHP_URL_PATH), '/'));
		$numSegments = count($segments); 
		$currentSegment = $segments[$numSegments - 1];
		$currentSegment = str_replace('__','.',$currentSegment);
		$userData = $this->getModel()->getUserWithUsername($currentSegment);
		if(count($userData)==0){
			JError::raiseError(403, JText::_('JERROR_ALERTNOAUTHOR'));
			return false;
		} else {
			$app	= JFactory::getApplication();
			$app->redirect('component/survey/?task=customer.expertProfile&display='.$getSession->id);
			exit;
		}
		echo "page not found";die;
		$getRatingData = $this->getModel()->expertRatingData($userData->id);	
		$this->assignRef('id',$userData->id);		
		$this->assignRef('expert',$userData);
		$this->assignRef('rating',$getRatingData);				
		parent::display($tpl);
	}

	
}
