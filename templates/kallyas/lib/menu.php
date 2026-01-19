<?php
/*------------------------------------------------------------------------
# author    Marius Hogas
# copyright Copyright © 2013 hogash.com. All rights reserved.
# @license  Commercial License http://themeforest.net/licenses/regular_extended
# Website   http://www.hogash.com
-------------------------------------------------------------------------*/

// No direct access.
defined('_JEXEC') or die;

?>

<ul class="sf-menu sprf clearfix">
<?php
foreach ($list as $i => &$item) :
	$class = 'item-'.$item->id;
	if ($item->id == $active_id) {
		$class .= ' current';
	}

	if (in_array($item->id, $path)) {
		$class .= ' active';
	}
	elseif ($item->type == 'alias') {
		$aliasToId = $item->params->get('aliasoptions');
		if (count($path) > 0 && $aliasToId == $path[count($path) - 1]) {
			$class .= ' active';
		}
		elseif (in_array($aliasToId, $path)) {
			$class .= ' alias-parent-active';
		}
	}

	if ($item->type == 'separator') {
		$class .= ' divider';
	}

	if ($item->deeper) {
		$class .= ' deeper';
	}

	if ($item->parent) {
		$class .= ' parent';
	}

	if (!empty($class)) {
		$class = ' class="'.trim($class) .'"';
	}
	
	

		echo '<li'.$class.'>';
	
		// Render the menu item.
		switch ($item->type) :
			case 'separator':
			case 'url':
			case 'component':
			case 'heading':
				require dirname(__FILE__).'/menu_'.$item->type.'.php';
				break;
	
			default:
				//require JModuleHelper::getLayoutPath('mod_menu', 'default_url');
				require dirname(__FILE__).'/menu_url.php';
				break;
		endswitch;
	
		// The next item is deeper.
		if ($item->deeper) {
			echo '<ul class="nav-child unstyled small">';
		}
		// The next item is shallower.
		elseif ($item->shallower) {
			echo '</li>'."\n";
			echo str_repeat('</ul></li>', $item->level_diff);
		}
		// The next item is on the same level.
		else {
			echo '</li>'."\n";
		}

	
endforeach;
?>
 <?php      
    $getExpertSession = JFactory::getUser();
	
 ?>

	<?php      
		if((int) $getExpertSession->id ==0):
			$isMobile = (bool)preg_match('#\b(ip(hone|od)|android\b.+\bmobile|opera m(ob|in)i|windows (phone|ce)|blackberry'.
                    '|s(ymbian|eries60|amsung)|p(alm|rofile/midp|laystation portable)|nokia|fennec|htc[\-_]'.
                    '|up\.browser|[1-4][0-9]{2}x[1-4][0-9]{2})\b#i', $_SERVER['HTTP_USER_AGENT'] );
			if($isMobile===false):
	 ?>
		<!--<li><a href="#login_panel" data-rel="prettyPhoto[login_panel]"><?php echo JText::_('TPL_KALLYAS_LOGIN'); ?></a> </li>-->
		<li><a href="<?php echo JUri::base();?>profile" ><?php echo JText::_('TPL_KALLYAS_LOGIN'); ?></a> </li>
	<?php 
			else:
	?>
			<li><a href="<?php  echo JRoute::_('index.php?option=com_users&view=login');?>" ><?php echo JText::_('TPL_KALLYAS_LOGIN'); ?></a> </li>
	<?php
	
			endif;
		else: 
			$db = JFactory::getDBO();
			$sql = "SELECT * FROM #__expert WHERE user_id='" . $getExpertSession->id. "'";
			$db->setQuery($sql);
			$userData = $db->loadObject();
			if(JRequest::getVar('view')!='featured'):
	?>
				<!--<li>
							<a href="index.php?option=com_users&task=user.logout&<?php echo JUtility::getToken(); ?>=1">LOGOUT</a>
						</li>-->
						<li><a href="<?php      echo JRoute::_('index.php?option=com_survey&task=customer.expertProfile&display='.$userData->id);?>">PROFILE</a></li>
	<?php 	else: 
		
	?> 
			<li><a href="<?php      echo JRoute::_('index.php?option=com_survey&task=customer.expertProfile&display='.$userData->id);?>">PROFILE</a></li>
	<?php 	endif;
		endif;
	?>
	
</ul>

<script type="text/javascript"> 
jQuery(document).ready(function(){ 
	/* Activate Superfish Menu */
	jQuery('#main_menu > ul').supersubs({ 
		minWidth:    12,   // minimum width of sub-menus in em units 
		maxWidth:    27,   // maximum width of sub-menus in em units 
		extraWidth:  1     // extra width can ensure lines don't sometimes turn over 
	}).superfish({
		animation: <?php echo $animation; ?>,
		delay:<?php echo $delay; ?>,
		dropShadows:false,
		autoArrows:<?php echo $autoarrows ?> ,
		speed:'<?php echo $speed; ?>'
	})<?php if($mobilemenu && $isresponsive) echo ".mobileMenu({ switchWidth: 979, topOptionText: document.mobileMenuText, indentString: '&nbsp;-&nbsp;'})"; ?>;
});  
</script>
