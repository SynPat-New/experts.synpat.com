jQuery(window).load(function($) {

	"use strict";
	// todo:
	// responsive
	// vimeo
	// youtube
	// self hosted
	// atasat cumva la slide sa dea pauza
	// animatie play pauza
	// mute btn

	function doMedElem(mediaElement, domObject) { 

		var dObj = jQuery(domObject),
			meHeight = mediaElement.height,
			meParentIos = dObj.parents('.item'),
			offParent = dObj.parents('.mejs-container');

		// if the video is heigher than the container, vertically center it
		if(meParentIos.length) {
			var meParentIosHeight = meParentIos.height(),
				difHeight = (meHeight > meParentIosHeight) ? ((meHeight - meParentIosHeight) / 2) : 0;
			jQuery(offParent).css('margin-top', -difHeight);
		}

		doOverlay(offParent, mediaElement);

	} // doMedElem

	function doOverlay(element, meElement, isVimeo, froogaloop) {

		if(element.hasClass('hasOverlay')){
			
			froogaloop = (typeof froogaloop === "undefined") ? null : froogaloop;
			isVimeo = (typeof isVimeo === "undefined") ? false : true;

			var helper = jQuery('<div class="kl-video-helper"></div>');
			element.after( helper );

			if(!isVimeo)
				if(!meElement.autoplay) helper.addClass('paused');

			helper.on('click', function() {

				if(helper.hasClass('paused')) {
					if(isVimeo) froogaloop.api('play');
					else meElement.play();
					helper.removeClass('paused');
				} else {
					if(isVimeo) froogaloop.api('pause');
					else meElement.pause();
					helper.addClass('paused');
				}
					
			});

		}
	} // doOverlay

	jQuery('.mevideo').each(function(index, el) {

		var $el = jQuery(el),
			isVimeo = $el.hasClass('vimeo-video');
		
		// Check if it's Vimeo Video and play with it's own API
		if(isVimeo) {

			var player = $el,
    			froogaloop = $f(player.get(0));
    		
    		// Do the overlay
    		doOverlay(player, null, isVimeo, froogaloop);

    		// Play with sound
			if(player.hasClass('startMute'))
				froogaloop.api('setVolume', 0);

		} else {

			var $player = $el.mediaelementplayer({
			//var $player = new MediaElementPlayer( $el , {
				videoWidth: '100%',
				videoHeight: '100%',
				features: [],
				success: function(mediaElement, domObject){

					doMedElem(mediaElement, domObject);

					//do it on resize aswell
					jQuery(window).resize(function(event) {
						doMedElem(mediaElement, domObject);
					});

				}
			});

		}

	});

});