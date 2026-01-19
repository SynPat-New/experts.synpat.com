<?php

// no direct access
defined('_JEXEC') or die;

$slide = $params->get('slides');
$cacheFolder = JURI::base().'cache/';
$modID = $module->id;
$modPath = JURI::base(true).'/modules/mod_hg_iosslider/';
$document = JFactory::getDocument(); 
$firstSlide = (int)$params->get('startAtSlide',1);
$moduleclass_sfx = htmlspecialchars($params->get('moduleclass_sfx'));
$bulletsType = $params->get('bulletsType','bullets');
$fixedWidth = $params->get('fixedWidth', 0);
$startFaded = $params->get('startFaded', 0);
$hasVideos = false;
$scriptsloaded = false;

if($slide) {
	
	$sliderClasses = array();
	$sliderClasses[] = $moduleclass_sfx;
	$sliderClasses[] = $startFaded ? 'faded':'';
	$sliderClasses[] = $fixedWidth ? 'fixed':'';
?>

<?php if($fixedWidth): ?>
	<div class="fluidHeight">
	<div class="sliderContainer ">
<?php endif; ?>

<div class="iosSlider <?php echo implode(' ',$sliderClasses); ?>" id="iosslider<?php echo $modID; ?>">
	<div class="slider">
<?php
// to do
// fullscreen button
// play/pause button


	foreach($slide->vals as $k => $v) {
		
		//$thumb = ModIosSlider::useJImage($slide->img[$k], 60, 60);
		$img = $slide->img[$k];
		$maintitle = $slide->title[$k];
		$bigtitle = $slide->bigtitle[$k];
		$smalltitle = $slide->smalltitle[$k];

		// Url Field
		$url = $slide->url->link[$k];
		$target = $slide->url->target[$k];
		
		$style = $slide->captionstyle[$k];
?>
<div class="item <?php if($k==0) echo 'activeslide'; ?>">
	

	<?php if(isset($slide->video->enabled[$k]) && $slide->video->enabled[$k]):
		$hasVideos = true;
	?>
	<div class="video-wrapper">
		<video id="player<?php echo $k; ?>"
			preload="<?php echo $slide->video->preload[$k]; ?>" 
			<?php echo $slide->video->autoplay[$k] ? 'autoplay="autoplay"':''; ?> 
			<?php echo $slide->video->loop[$k] ? 'loop="loop"':''; ?> 
			<?php echo $slide->video->mute[$k] ? 'muted="muted"':''; ?> 
			<?php if($img): ?>poster="<?php echo $img; ?>"<?php endif; ?> 
			class="video-js vjs-default-skin kl-video <?php echo $slide->video->video_type[$k]; ?>-video <?php echo $slide->video->hasoverlay[$k] ? 'hasOverlay':''; ?>"
			<?php if($slide->video->video_type[$k] == 'vimeo'): ?>
				data-setup='{ "techOrder": ["vimeo"], "src": "//vimeo.com/<?php echo $slide->video->sourceid[$k]; ?>", "portrait": false, "byline": false, "title": false, "badge":false, "rel":false, "api":true }' 
			<?php elseif($slide->video->video_type[$k] == 'youtube'): ?>
				data-setup='{ "techOrder": ["youtube"], "src": "//www.youtube.com/watch?v=<?php echo $slide->video->sourceid[$k]; ?>", "quality": "720p" }' 
			<?php elseif($slide->video->video_type[$k] == 'self_hosted'): ?>
				data-setup='{}'
			<?php endif; ?>
			width="auto" height="auto">
			<?php
			if($slide->video->video_type[$k] == 'self_hosted'):
				$sources = ModIosSlider::getSources($slide->video->sourceid[$k]);
				foreach($sources as $ext)
					echo '<source type="video/'.$ext.'" src="'.JURI::base(true).$slide->video->sourceid[$k].'.'.$ext.'" />';
			endif; ?>
			<p>Video Playback Not Supported</p>
		</video>
	</div>
	<ul class="hgvjs_controls">
		<?php if($params->get('video_playbtn',1)): ?><li><a href="#" class="playpause-btn "></a></li><?php endif; ?>
		<?php if($params->get('video_mutebtn',1)): ?><li><a href="#" class="audio-btn <?php echo $slide->video->mute[$k] ? 'muted':''; ?>"></a></li><?php endif; ?>
		<?php if($params->get('video_fullbtn',1)): ?><li><a href="#" class="fullscreen-btn"></a></li><?php endif; ?>
	</ul>
	<?php  else: ?>
		<?php if($img): ?>
			<img src="<?php echo $img; ?>" alt="<?php echo $maintitle; ?>" />
		<?php endif; ?>
	<?php endif; ?>
	
	<?php if($maintitle or $bigtitle or $smalltitle): ?>
	<div class="caption <?php echo $style; ?> <?php echo $slide->captionposition[$k]; ?>">
		<?php if($maintitle): ?>
			<h2 class="main_title"><?php echo $maintitle; ?></h2>
		<?php endif; ?>
		<?php if($style == 'style3') {
			// style3
			?>
			<?php if($smalltitle): ?>
				<h4 class="title_small"><?php echo $smalltitle; ?></h4>
			<?php endif; ?>
			<?php if($bigtitle): ?>
				<h3 class="title_big"><?php echo $bigtitle; ?></h3>
			<?php endif; ?>
		<?php } else {
			// normal template
			?>
			<?php if($bigtitle): ?>
				<h3 class="title_big"><?php echo $bigtitle; ?></h3>
			<?php endif; ?>
			<?php if($url): ?>
				<a href="<?php echo $url; ?>" target="<?php echo $target; ?>" class="more">
					<img src="<?php echo $modPath; ?>assets/images/arr01.png" alt="<?php echo htmlspecialchars($bigtitle, ENT_COMPAT, 'UTF-8'); ?>">
				</a>
			<?php endif; ?>
			<?php if($smalltitle): ?>
				<h4 class="title_small"><?php echo $smalltitle; ?></h4>
			<?php endif; ?>
		<?php } ?>
	</div>
	<?php endif; ?>
</div><!-- end item -->
<?php
	} // end foreach
?>

	</div><!-- end slider -->

	<div class="prev">
		<div class="btn-label"><?php echo $params->get('prevlabel','PREV'); ?></div>
	</div>
	<div class="next">
		<div class="btn-label"><?php echo $params->get('nextlabel','NEXT'); ?></div>
	</div>
	
	<?php if($params->get('hideBullets','false') == 'false'): ?>
	<div class="selectorsBlock <?php echo $bulletsType; ?>">
		<?php echo ($bulletsType == 'thumbs'? '<a href="#" class="thumbTrayButton"><span class="icon-minus icon-white"></span></a>':''); ?>
		<div class="selectors">
	<?php
	foreach($slide->vals as $k => $v) {
		echo '<div class="item '.(($k+1) == $firstSlide ? ' first selected':'').'">'.($bulletsType == 'thumbs'? '<img src="'.JURI::base(true).'/cache/'.ModIosSlider::createThumb($slide->img[$k], 150, 60).'">' : '').'</div>';
	}
	?>
		</div>
	</div>
	<?php endif; ?>
	
</div><!-- end iosSlider -->
<div class="scrollbarContainer"></div>
<?php if($fixedWidth): ?>
	</div>
	</div>
<?php endif; ?>
<script type="text/javascript">
;(function($){
	$(document).ready(function() {

		$('#iosslider<?php echo $modID; ?>').iosSlider({
			desktopClickDrag: <?php echo $params->get('desktopClickDrag', 'true')."\n";?>
			, keyboardControls: <?php echo $params->get('keyboardControls', 'true')."\n";?>
			, navNextSelector: $('.iosSlider .next')
			, navPrevSelector: $('.iosSlider .prev')
			, navSlideSelector: $('.selectors .item')
			, scrollbar: <?php echo $params->get('scrollbar', 'true')."\n";?>
			, scrollbarContainer: '#slideshow .scrollbarContainer'
			, scrollbarMargin: '0'
			, scrollbarBorderRadius: '4px'
			, onSlideComplete: slideComplete
			, onSliderLoaded: function(args){
				var otherSettings = {
					hideControls : <?php echo $params->get('hideControls', 'true')."\n";?>
					, hideCaptions : <?php echo $params->get('hideCaptions', 'false')."\n";?>
				}
				sliderLoaded(args, otherSettings);
			},
			onSlideChange: function(args){
				slideChange(args);
				if(typeof(checkVideos) == typeof(Function)) checkVideos(args);
			}
			, startAtSlide: <?php echo $firstSlide."\n";?>
			, infiniteSlider: <?php echo $params->get('infiniteSlider', 'true')."\n";?>
			, autoSlide: <?php echo $params->get('autoSlide', 'true')."\n";?>
			, autoSlideTimer: <?php echo $params->get('autoSlideTimer', 5000)."\n";?>
			, autoSlideTransTimer: <?php echo $params->get('autoSlideTransTimer', 750)."\n";?>
			, snapToChildren: <?php echo $params->get('snapToChildren', 'true')."\n";?>
			, snapSlideCenter: <?php echo $params->get('snapSlideCenter', 'false')."\n";?>
			, elasticPullResistance: <?php echo $params->get('elasticPullResistance', 0.6)."\n";?>
			, frictionCoefficient: <?php echo $params->get('frictionCoefficient', 0.92)."\n";?>
			, elasticFrictionCoefficient: <?php echo $params->get('elasticFrictionCoefficient', 0.6)."\n";?>
			, snapFrictionCoefficient: <?php echo $params->get('snapFrictionCoefficient', 0.92)."\n";?>
		});
		
	}); // end doc ready
})(jQuery);
</script>
<?php
// add files
	$document->addStyleSheet($modPath.'assets/css/style.css');  
	$document->addScript($modPath.'assets/js/jquery.iosslider.min.js');
	$document->addScript($modPath.'assets/js/jquery.iosslider.kalypso.js');

	if($hasVideos && !$scriptsloaded) {
		$document->addStyleSheet($modPath.'assets/videojs/video-js.css');
		echo '<script type="text/javascript" src="'.$modPath.'assets/videojs/video.js"></script>';
		echo '<script type="text/javascript" src="'.$modPath.'assets/videojs/plugins/vjs.plugins.js"></script>';
		echo '<script type="text/javascript" src="'.$modPath.'assets/videojs/kl-videos.js"></script>';
		$scriptsloaded = true;
	}

	$proportion = ModIosSlider::getProportion($slide->img[$firstSlide-1]);
	
	$css = '';
	/*$css .= '#slideshow {padding-bottom: '.$proportion.'%;}';*/
	if(!$fixedWidth) 
		$css .= '';
	else
		$css .= '#slideshow {padding-bottom: 0; height:auto;}';	
			
	/*$css .= '#iosslider'.$modID.' .iosSlider {height: '.(int)$params->get('maxheight',800).'px; }';*/
	$css .= '#iosslider'.$modID.' {height: '.(int)$params->get('maxheight',800).'px; }';
	
	$css .= '#slideshow + .slideshow_back {padding-bottom: '.$proportion.'%;}';
	
	$document->addStyleDeclaration($css);
	
} else {
	echo 'Load the slides first!';	
}
?>

