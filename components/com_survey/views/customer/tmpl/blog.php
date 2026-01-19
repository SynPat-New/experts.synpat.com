<?php 
// No direct access to this file
defined('_JEXEC') or die('Restricted access');
$blogs = $this->blogList;
$expert = $this->expert;
$profileUser = JFactory::getUser();

$sessionEXpertID = 0;
if (is_object($profileUser) && $profileUser->id > 0) {

    $sessionEXpertID = $expert->id;
}

JHtml::addIncludePath(JPATH_BASE.'/components/com_content/helpers/html');

require_once dirname(__FILE__).'/../../../../../templates/kallyas/lib/icon_helper.php';
	
?>

<div id="profileData">
										
	<dl class="article-info clearfix">
		<dd class="active category-name"><a href="<?php echo JRoute::_('index.php?option=com_survey&task=customer.expertProfile&display='.JRequest::getInt('display'))?>">Profile</a></dd>
		<?php if($sessionEXpertID>0):?>
		<dd class="createdby"><a href="<?php echo JRoute::_('index.php?option=com_survey&task=customer.expertOpportunites&display='.JRequest::getInt('display'))?>" >Opportunities</a></dd>
		<?php endif;?>
		<dd class="createdby"><a href="<?php echo JRoute::_('index.php?option=com_survey&task=customer.expertProcess&display='.JRequest::getInt('display'))?>">In Process</a></dd>
		<dd class="createdby"><a href="<?php echo JRoute::_('index.php?option=com_survey&task=customer.expertReport&display='.JRequest::getInt('display'))?>">My Report</a></dd>			
		<?php if($sessionEXpertID>0):?>
		<dd class="createdby"><a href="<?php echo JRoute::_('index.php?option=com_survey&task=customer.expertArea&display='.JRequest::getInt('display'))?>" >My Experties</a></dd>
		<?php endif;?>
		<dd class="published"><a href="<?php echo JRoute::_('index.php?option=com_survey&task=customer.blog&display='.JRequest::getInt('display'))?>">My Blog</a></dd>
		<dd class="published"><a href="<?php echo JRoute::_('index.php?option=com_survey&task=customer.expertFeedback&display='.JRequest::getInt('display'))?>">Feedback</a></dd>
		<?php if($sessionEXpertID>0):?>
		<dd class="createdby"><a href="index.php/add-blog" >Add Blog Article</a></dd>
		<dd class="createdby" ><a style='color:#cd2122' href="<?php echo JRoute::_('index.php?option=com_users&task=user.logout&'.JUtility::getToken().'=1');?>" >Logout</a></dd>
		<?php endif;?>
	</dl>
	<div class="viewControl">
		<?php 
			if($blogs['count']->blogCount==0){
		?>
			<p class='alert alert-danger'>No content found!</p>
		<?php
			} else {
		?>
			<div class="itemListView clearfix eBlog ">
				<div class="itemList">
		<?php
				foreach($blogs['blog'] as $i => $item){
		?>
					<div class="items-row cols-1 row-<?php echo $i;?>">
						<div class="item column-1">
							<div class="itemContainer">
								<div class="itemHeader">
									<h3 class="itemTitle">
									<?php $title = $item->category_title;
										$url = '<a href="index.php?option=com_content&view=article&id=' .$item->id. '">' . $title . '</a>'; ?>
										<a href="index.php?option=com_content&view=article&id=<?php echo $item->id;?>">
										<?php echo $item->title; ?></a>
									</h3>
									<div class="post_details catListing">
										<ul class="actions">
											
											<li class="print-icon">
												<a href="/index.php/blog/<?php echo $item->id;?>-<?php echo $item->alias;?>?tmpl=component&amp;print=1&amp;layout=default&amp;page=" data-rel="tooltip" title="" onclick="window.open(this.href,'win2','status=no,toolbar=no,scrollbars=yes,titlebar=no,menubar=no,resizable=yes,width=640,height=480,directories=no,location=no'); return false;" rel="nofollow" data-original-title="Print"><span class="icon-print icon-white"></span></a>
											</li>
											
											
											<li class="email-icon">
												<a href="/index.php/component/mailto/?tmpl=component&amp;template=kallyas&amp;link=<?php echo base64_encode('/index.php/blog/'.$item->id.'-'.$item->alias);?>" title="" data-rel="tooltip" onclick="window.open(this.href,'win2','width=400,height=350,menubar=yes,resizable=yes'); return false;" data-original-title="Email"><span class="icon-envelope icon-white"></span></a>
											</li>
											
											<?php if ($item->created_by==$profileUser->id) : ?>
											<li class="edit-icon">
												<a href="/index.php/blog?task=article.edit&amp;a_id=<?php echo $item->id;?>&amp;return=<?php echo base64_encode(JRoute::_('index.php?option=com_survey&task=customer.blog&display='.$sessionEXpertID));?>" data-rel="tooltip" title="" data-original-title="Edit Article :: Published<br /><?php echo date('l, d F Y',strtotime($item->created));?><br />Written by <?php echo $item->author;?>"><span class="icon-edit icon-white"></span></a>
											</li>
											<li class="edit-icon">
												<a href="/index.php/blog?task=article.delete&amp;a_id=<?php echo $item->id;?>&amp;return=<?php echo base64_encode(JRoute::_('index.php?option=com_survey&task=customer.blog&display='.$sessionEXpertID));?>" data-rel="tooltip" title="" data-original-title="Edit Article :: Published<br /><?php echo date('l, d F Y',strtotime($item->created));?><br />Written by <?php echo $item->author;?>"><span class="icon-remove icon-white"></span></a>
											</li>
											<?php endif; ?>
										</ul>
										<dl class="article-info fixclear">
											<dd class="published">
												<span class="icon-calendar"></span>
												<?php echo JHtml::_('date', $item->created, JText::_('DATE_FORMAT_LC2')); ?>
											</dd>
											<dd class="createdby">
												WRITTEN BY: <?php echo $item->author; ?>
											</dd>
											<dd class="hits">
												HITS: <?php echo $item->hits; ?>
											</dd>
										</dl>
									</div>
								</div>
								<div class="itemBody">
									<div class="itemIntroText"><?php echo nl2br($item->introtext); ?></div>
									<div class="clear"></div>
								</div>
								<ul class="itemLinks clearfix">
									<li class="itemCategory">
										<span class="icon-folder-close"></span>
										CATEGORY:<?php echo $item->category_title;?>
									</li>
								</ul>
							</div>
						</div>
					</div>
		<?php
				}
		?>
				</div>
			</div>
		<?php
			}
		?>
	</div>
</div>