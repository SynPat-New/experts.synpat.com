
function checkVideos(args) {

	var prevSlide = jQuery(args.sliderObject).find('.item:eq(' + (args.prevSlideNumber-1) + ') .video-js');
		thisSlide = jQuery(args.sliderObject).find('.item:eq(' + (args.currentSlideNumber-1) + ') .video-js');

	if(typeof prevSlide[0] !== 'undefined')
		videojs(prevSlide[0]).ready(function(){
			this.pause();
		});

	if(typeof thisSlide[0] !== 'undefined')
		videojs(thisSlide[0]).ready(function(){
			this.play();
		});
}

function negTopMargin(domObject) { 

	var dObj = jQuery(domObject),
		vjsHeight = dObj.height(),
		vjsParentIos = dObj.parents('.item');

	// if the video is heigher than the container, vertically center it
	var vjsParentIosHeight = vjsParentIos.height(),
		difHeight = (vjsHeight > vjsParentIosHeight) ? ((vjsHeight - vjsParentIosHeight) / 2) : 0;
	
	jQuery(dObj.closest('.video-wrapper')).css('margin-top', -difHeight);

} // negTopMargin

	

jQuery(document).ready(function($) {

	"use strict";

	// todo:
	// responsive
	// animatie play pauza

	jQuery('.iosSlider .kl-video').each(function(index, el) {

		var elem = jQuery(el),
			elm = elem[0];

		// vertically align it
		negTopMargin(elem);

		//do it on resize aswell
		jQuery(window).resize(function() {
			negTopMargin(elem);
		});

		if(typeof elm !== 'undefined') {

			var dsAttr = elm.getAttribute("data-setup"),
				hgjvs_controls = elem.closest('.video-wrapper').next('.hgvjs_controls'),
				volBtn = hgjvs_controls.find('.audio-btn'),
				playPauseBtn = hgjvs_controls.find('.playpause-btn'),
				fullscreenBtn = hgjvs_controls.find('.fullscreen-btn'),
				dataSetup = JSON.parse(dsAttr),
				isYoutube,
				tOrd;

			tOrd = (typeof dataSetup.techOrder !== 'undefined') ? dataSetup.techOrder : false;
			isYoutube = (tOrd && tOrd[0] == 'youtube') ? true : false;
			var isVimeo = (tOrd && tOrd[0] == 'vimeo') ? true : false;

			videojs(elm, dataSetup).ready(function(){

				var myplayer = this;

				// if( myplayer.volume() == 0.01 && myplayer.volume() == 0 ) volBtn.addClass('muted');
				
				volBtn.on('click', function() {
					if(myplayer.volume() != 0.01 && myplayer.volume() != 0){
						if(isYoutube) myplayer.volume(0.01);
						else myplayer.volume(0);
						volBtn.addClass('muted');
					} else {
						myplayer.volume(1);
						volBtn.removeClass('muted');
					}
				});
				playPauseBtn.on('click', function() {
					if( myplayer.paused() ){
						myplayer.play();
						playPauseBtn.removeClass('paused');
					} else {
						myplayer.pause();
						playPauseBtn.addClass('paused');
					}
				});
				fullscreenBtn.on('click', function() {
					myplayer.requestFullScreen();
				});

			});

		}
	});

});
