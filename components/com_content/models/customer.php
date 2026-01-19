<?php
/**
 * @copyright	Copyright (C) 2005 - 2014 Open Source Matters, Inc. All rights reserved.
 * @license		GNU General Public License version 2 or later; see LICENSE.txt
 */

defined('_JEXEC') or die;

jimport('joomla.application.component.modellist');

/**
 * This models supports retrieving lists of article categories.
 *
 * @package		Joomla.Site
 * @subpackage	com_content
 * @since		1.6
 */
class ContentModelCustomer extends JModelList
{
	
	public function getUserWithUsername($username){
		$query = 'SELECT e.*, p.paypal_id,u.username FROM #__users as u INNER JOIN #__expert as e ON e.user_id = u.id LEFT JOIN #__expert_payment as p ON p.expert_id = e.id WHERE u.username = "'.$username.'"';
		$db = JFactory::getDBO();
		$db->setQuery($query);
		$userData = $db->loadObject();
		return $userData;
	}
	function expertRatingData($expertID)
    {
        $db = JFactory::getDBO();
        $sql = "SELECT sum(er.rating) as rating, count(er.survey_id) as countSurvey , s.id as surveyID , s.name as surveyName,e.id,e.name as expertName ,  e.linkedin_pic as linkedin_pic, e.linkedin_profile_url as linkedin_profile_url FROM #__expertrating as er LEFT JOIN #__expert as e ON e.id = er.expert_id LEFT JOIN #__survey as s ON s.id = er.survey_id WHERE er.expert_id='" . $expertID . "' GROUP BY er.survey_id";
        $db->setQuery($sql);
        return $db->loadObjectList();
    }
	
}