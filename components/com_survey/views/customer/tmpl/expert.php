<?php
// no direct access
defined('_JEXEC') or die;
$expertData = $this->expertData;
//print_r($expertData);
$document = JFactory::getDocument();
$document->addScript('/templates/kallyas/js/jquery.isotope.min.js');
$document->addScriptDeclaration('
    (function($){ 
		$(window).load(function(){
			if ($("ul#thumbs").length > 0){
				var $container = $("ul#thumbs");
				$container.isotope({
				  itemSelector : ".item",
				  animationEngine : "jquery",
				  animationOptions: {
					  duration: 250,
					  easing: "easeOutExpo",
					  queue: false
				  },
				  
				  sortAscending : true,
				  getSortData : {
					  name : function ( $elem ) {
						  return $elem.find("span.name").text();
					  },
					  date : function ( $elem ) {
						  return $elem.attr("data-date");
					  }
				  },
				  sortBy: "date"
				});
				
			}
		});
	})(jQuery);
');
?>

<div class="span12">
	<div class="hg-portfolio-sortable ">
	<?php 
		if($expertData['count']==0):
	?>
	<p class='alert alert-danger'>No expert found with keyword you entered.</p>
	<?php else:?>
	<div id="sorting" class="clearfix">
		<span class="sortTitle"> Sort by: </span>
		<ul id="sortBy" class="option-set " data-option-key="sortBy">
			<li><a href="#sortBy=name" data-option-value="name" class="selected">Name</a></li>
			<li><a href="#sortBy=date" data-option-value="date" class="">Date</a></li>
		</ul>
		<span class="sortTitle"> Direction:: </span>
		<ul id="sort-direction" class="option-set " data-option-key="sortAscending">
		  <li><a href="#sortAscending=true" data-option-value="true" class="selected">ASC</a></li>
		  <li><a href="#sortAscending=false" data-option-value="false" class="">DESC</a></li>
		</ul>
	</div>
	<!--<ul id="portfolio-nav" class="clearfix"><li class="current"><a href="#" data-filter="*">All</a></li><li class=""><a href="#" data-filter=".websites">Websites</a></li><li class=""><a href="#" data-filter=".print">Print</a></li><li class=""><a href="#" data-filter=".logo">Logo</a></li></ul>-->
	<div class="clear"></div>
	<ul id="thumbs" class="clearfix isotope">
		<?php 
			$i=0;
			foreach($expertData['data'] as $expert){
		?>
			<li class="item  websites <?php echo ($i%2==0)?'even':'odd';?> isotope-item" data-date="2013/03/22">
				<div class="inner-item">
					<a data-type="link" class="hoverLink aCenter" href="<?php echo JRoute::_('index.php?option=com_survey&task=customer.expertProfile&display='.$expert->id)?>">
					<?php 
						/*Find Image from Profile Desc field*/
						preg_match_all('/<img.+src=[\'"]([^\'"]+)[\'"].*>/i', $expert->profile_desc, $matches);
						$first_img = $matches[1][0];
						if(!empty($first_img)){
						?>
							<img src="<?php echo $first_img;?>" style="width:260px;height:161px"/>
						<?php
						} else {
					?>
						<img src="<?php echo JUri::base();?>components/com_survey/images/expert.png" />
					<?php
						}
					?>
						<span class="icon_wrap" style="opacity: 0;"><span class="icon link"></span></span>
					</a>
					<h4 class="title">
						<a <?php echo JRoute::_('index.php?option=com_survey&task=customer.expertProfile&display='.$expert->id)?>><span class="name"><?php echo $expert->name;?></span></a>
					</h4>
				</div>
				<span class="moduleDesc">
					<p></p>
				</span>
				<div class="clear"></div>
			</li>
		<?php
				$i++;
			}
		?>
	</ul>
	<?php
		endif;
	?>
	</div>
</div>