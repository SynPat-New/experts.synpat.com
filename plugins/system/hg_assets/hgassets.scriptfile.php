<?php
/**
 * HOGASH TEMPLATES ASSETS PLUGIN
 * Copyright (c)2013 Hogash.com
**/
// No direct access to this file
defined('_JEXEC') or die('Restricted access');

/**
* Script file of HGAssets plugin
*/

class plgSystemHG_AssetsInstallerScript 
{ 
  function install($parent) { 
     // I activate the plugin
    $db = JFactory::getDbo();

    $query = $db->getQuery(true);

    // Fields to update.
    $fields = array(
        $db->quoteName('enabled') . '=1'
    );

    // Conditions for which records should be updated.
    $conditions = array(
        $db->quoteName('type') . '=\'plugin\'', 
        $db->quoteName('element') . '=\'hg_assets\''
    );

    $query->update($db->quoteName('#__extensions'))->set($fields)->where($conditions);

    $db->setQuery($query);
    $db->query();


     echo '<p>'. JText::_('HG Assets succesfully enabled!') .'</p>';    
  } 
}
?>