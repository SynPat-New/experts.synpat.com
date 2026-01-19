<?php
/**
 * @copyright	Copyright (C) 2005 - 2012 Open Source Matters, Inc. All rights reserved.
 * @license		GNU General Public License version 2 or later; see LICENSE.txt
 */

// No direct access
defined('_JEXEC') or die;

jimport('joomla.application.component.view');

/**
 * HTML View class for the Content component
 *
 * @package		Joomla.Site
 * @subpackage	com_content
 * @since 1.5
 */
class SurveyViewCustomer extends JView
{
	function display()
	{
		$app = JFactory::getApplication();

		$doc	= JFactory::getDocument();
		$doc->setTitle('ClaimCharts.info');
		$params = $app->getParams();
		$feedEmail	= '';
		$siteEmail	= $app->getCfg('mailfrom');
		// Get some data from the model
		$rows		= $this->get('ClaimsFeedsItems');
		
		$doc->link = JRoute::_('index.php');

		foreach ($rows as $row)
		{
			// strip html from feed item title
			$title = $this->escape($row->title);
			$title = html_entity_decode($title, ENT_COMPAT, 'UTF-8');
			// url link to article
			$link = JUri::base();

			// strip html from feed item description text
			// TODO: Only pull fulltext if necessary (actually, just get the necessary fields).
			$description	= $row->description;
			$author			= $row->author;
		
			@$date			= ($row->created ? date('r', strtotime($row->created)) : '');

			// load individual item creator class
			$item = new JFeedItem();
			$item->title		= $title;
			$item->link			= $link;
			$item->description	= $description;
			$item->date			= $date;
			$item->category		= '';
			$item->author		= $author;
			$item->target		= $row->target;
			if ($feedEmail == 'site') {
				$item->authorEmail = $siteEmail;
			}
			else {
				$item->authorEmail = $siteEmail;
			}
			
			// loads item info into rss array
			$doc->addItem($item);
		}
	}
}
