 define(
    [
        'jquery', 'debounce', 'preparetransition', 'slick'
    ],
    function ($) {
window.GoodwinSlider = {};

function onYouTubeIframeAPIReady() {
	GoodwinSlider.bnsliderVideo.loadVideos();
}

function keepScale(slider) {
	var $bnsliderNoScale = slider;
	var wW = $(window).width();
	var mobileBreikpoint = 480;
	if ($bnsliderNoScale.hasClass("keep-scale") && !$bnsliderNoScale.hasClass("bnslider--fullheight")) {
		$bnsliderNoScale.css({
			'height': '',
			'min-height': ''
		});
		var bnrH;
		if (wW <= mobileBreikpoint && parseInt($bnsliderNoScale.attr('data-start-mwidth')) > 0 && parseInt($bnsliderNoScale.attr('data-start-mheight')) > 0) {
			var bnrH = parseInt($bnsliderNoScale.attr('data-start-mheight'), 10) / parseInt($bnsliderNoScale.attr('data-start-mwidth'), 10) * wW;
			$bnsliderNoScale.css({
				'height': bnrH + 'px',
				'min-height': bnrH + 'px'
			});
		} else if (parseInt($bnsliderNoScale.attr('data-start-width')) > 0 && parseInt($bnsliderNoScale.attr('data-start-height')) > 0) {
			var bnrH = parseInt($bnsliderNoScale.attr('data-start-height'), 10) / parseInt($bnsliderNoScale.attr('data-start-width'), 10) * wW;
			if ($bnsliderNoScale.closest("div[class^='col-'],div[class*=' col-']").length) {
				var colW = ($bnsliderNoScale.closest("div[class^='col-'],div[class*=' col-']").width()) * 100 / wW;
				bnrH = bnrH * colW / 100;
			} else if ($bnsliderNoScale.closest(".holder.boxed").length) {
				var colW = ($bnsliderNoScale.closest(".container").width()) * 100 / wW;
				bnrH = bnrH * colW / 100;
			}
			$bnsliderNoScale.css({
				'height': bnrH + 'px',
				'min-height': bnrH + 'px'
			});
		} else return false;
	}
}

GoodwinSlider.bnslider = (function () {
	this.$bnslider = null;
	var classes = {
		wrapper: 'bnslider-wrapper',
		bnslider: 'bnslider',
		currentSlide: 'slick-current',
		video: 'bnslider-video',
		videoBackground: 'bnslider-video--background',
		closeVideoBtn: 'bnslider-video-control--close',
		pauseButton: 'bnslider-pause',
		isPaused: 'is-paused',
		animatedText: "[class^='bnslider-text'],[class*=' bnslider-text'],.btn-wrap,.btn-decor,.btn-line"
	};
	function bnslider(el) {
		this.$bnslider = $(el);
		this.bnslider = el;
		this.$wrapper = this.$bnslider.closest('.' + classes.wrapper);
		this.$pause = this.$wrapper.find('.' + classes.pauseButton);
		var $textBlock = $(classes.animatedText, $bnslider);
		var arrowsplace = this.$wrapper.find('.bnslider-arrows > div');
		var dotsplace = this.$wrapper.find('.bnslider-dots');
		$textBlock.each(function () {
			var $this = $(this),
				thisInlineStyle = '';
			var thisStyle = $this.data();
			for (data in thisStyle) {
				if (data == 'fontcolor') {
					thisInlineStyle += 'color:' + $this.data('fontcolor') + ';'
				}
				if (data == 'fontfamily') {
					thisInlineStyle += 'font-family:' + $this.data('fontfamily') + ';'
				}
				if (data == 'fontsize') {
					thisInlineStyle += 'font-size:' + $this.data('fontsize') + 'px;'
				}
				if (data == 'fontline') {
					thisInlineStyle += 'line-height:' + $this.data('fontline') + 'em;'
				}
				if (data == 'fontweight') {
					thisInlineStyle += 'font-weight:' + $this.data('fontweight') + ';'
				}
				if (data == 'bgcolor') {
					thisInlineStyle += 'background-color:' + $this.data('bgcolor') + ';'
				}
				if (data == 'ypos') {
					var ypos = $this.data('ypos');
					if (ypos == 'center') {
						$this.addClass('vertical-align')
					} else thisInlineStyle += 'top:' + $this.data('ypos') + '%;'
				}
				if (data == 'xpos') {
					var xpos = $this.data('xpos');
					if (xpos == 'center') {
						$this.addClass('horisontal-align')
					} else if (xpos == 'left') {
						thisInlineStyle += 'left:0;right:auto;'
					} else if (xpos == 'right') {
						thisInlineStyle += 'left:auto;right:0;'
					} else thisInlineStyle += 'left:' + $this.data('xpos') + '%;'
				}
				if (data == 'otherstyle') {
					thisInlineStyle += $this.data("otherstyle") + ';';

				}
			}
			if (thisInlineStyle.length > 0) {
				$this.attr('style', thisInlineStyle).addClass('data-ini');
			}
		})

		this.$bnslider.on('beforeChange', beforeChange.bind(this));
		this.$bnslider.on('init', bnsliderA11y.bind(this));

		this.settingsTabs = {
			accessibility: true,
			fade: true,
			draggable: true,
			touchThreshold: 20,
			autoplay: this.$bnslider.data('autoplay'),
			autoplaySpeed: this.$bnslider.data('speed'),
			customPaging: function (slider, i) {
				var text = $(slider.$slides[i]).data('text');
				return '<span>' + text + '</span>';
			}
		};

		this.settings = {
			appendArrows: arrowsplace,
			appendDots: dotsplace,
			accessibility: true,
			fade: true,
			draggable: true,
			touchThreshold: 20,
			autoplay: this.$bnslider.data('autoplay'),
			autoplaySpeed: this.$bnslider.data('speed'),
			prevArrow: '<button type="button" data-role="none" class="slick-prev slick-arrow" aria-label="Previous" role="button"><span></span>Prev</button>',
			nextArrow: '<button type="button" data-role="none" class="slick-next slick-arrow" aria-label="Next" role="button"><span></span>Next</button>',
			responsive: [{
				breakpoint: 768,
				settings: {
					dots: false
				}
			}]
		};
		if (this.$bnslider.hasClass('bnslider-with-tabs')) {
			this.$bnslider.slick(this.settingsTabs);
			$('.js-bnslider-tabs').on('click', function () {

			})
		} else this.$bnslider.slick(this.settings);
		this.$pause.on('click', this.togglePause.bind(this));
	}

	function bnsliderA11y(event, obj, currentSlide, nextSlide) {
		var $slider = obj.$slider;
		var $header = $('.page-header');
		var $list = obj.$list;
		var $wrapper = this.$wrapper;
		var autoplay = this.settings.autoplay;
		var $currentSlide = $slider.find('.' + classes.currentSlide);
		var $animatingElements = $currentSlide.find('[data-animation]');

		if (isVideoInSlide($currentSlide)) {
			var $video = $currentSlide.find('.' + classes.video);
			var videoId = $video.attr('id');
			var isBackground = $video.hasClass(classes.videoBackground);
			if (isBackground) {
				GoodwinSlider.bnsliderVideo.playVideo(videoId);
			} else {
				$video.attr('tabindex', '0');
			}
		}
		keepScale($slider);
		doAnimations($animatingElements);
		$slider.closest('.block').addClass('block--loaded');
		if ($header.hasClass('.hdr-transparent')) {
			$header.addClass('visible')
		}
		$wrapper.on('focusin', function (evt) {
			if (!$wrapper.has(evt.target).length) {
				return;
			}
			$list.attr('aria-live', 'polite');
			if (autoplay) {
				$slider.slick('slickPause');
			}
		});
		$wrapper.on('focusout', function (evt) {
			if (!$wrapper.has(evt.target).length) {
				return;
			}
			$list.removeAttr('aria-live');
			if (autoplay) {
				if ($(evt.target).hasClass(classes.closeVideoBtn)) {
					return;
				}
				$slider.slick('slickPlay');
			}
		});
	}

	// Slider Animation
	function doAnimations(elements) {
		var animationEndEvents = 'webkitAnimationEnd mozAnimationEnd MSAnimationEnd oanimationend animationend';
		elements.each(function () {
			var $this = $(this);
			var $animationDelay = $this.data('animation-delay');
			var $animationType = 'animated ' + $this.data('animation');
			$this.css({
				'animation-delay': $animationDelay,
				'-webkit-animation-delay': $animationDelay
			});
			$this.addClass($animationType).one(animationEndEvents, function () {
				$this.removeClass($animationType);
			});
			if ($this.hasClass('animate')) {
				$this.removeClass('animation');
			}
		});
	}

	function setCurrentSlideNumber(slider, currentSlide, slideCount) {
		var $prev = slider.parent().find('.slick-prev > span'),
			$next = slider.parent().find('.slick-next > span'),
			prevText = currentSlide == 0 ? slideCount : currentSlide,
			nextText = currentSlide + 1 >= slideCount ? 1 : currentSlide + 2;
		$prev.text(prevText < 10 ? '0' + prevText : prevText);
		$next.text(nextText < 10 ? '0' + nextText : nextText);
	};

	function beforeChange(event, slick, currentSlide, nextSlide) {
		var $slider = slick.$slider;
		var $currentSlide = $slider.find('.' + classes.currentSlide);
		var $nextSlide = $slider.find('.bnslider-slide[data-slick-index="' + nextSlide + '"]');
		if (isVideoInSlide($currentSlide)) {
			var $currentVideo = $currentSlide.find('.' + classes.video);
			var currentVideoId = $currentVideo.attr('id');
			GoodwinSlider.bnsliderVideo.pauseVideo(currentVideoId);
			$currentVideo.attr('tabindex', '-1');
		}
		if (isVideoInSlide($nextSlide)) {
			var $video = $nextSlide.find('.' + classes.video);
			var videoId = $video.attr('id');
			var isBackground = $video.hasClass(classes.videoBackground);
			if (isBackground) {
				GoodwinSlider.bnsliderVideo.playVideo(videoId);
			} else {
				$video.attr('tabindex', '0');
			}
		}
		var $animatingElements = $nextSlide.find('[data-animation]');
		doAnimations($animatingElements);
	}

	function isVideoInSlide($slide) {
		return $slide.find('.' + classes.video).length;
	}

	bnslider.prototype.togglePause = function () {
		var bnsliderSelector = getbnsliderId(this.$pause);
		if (this.$pause.hasClass(classes.isPaused)) {
			this.$pause.removeClass(classes.isPaused);
			$(bnsliderSelector).slick('slickPlay');
		} else {
			this.$pause.addClass(classes.isPaused);
			$(bnsliderSelector).slick('slickPause');
		}
	};

	function getbnsliderId($el) {
		return '#bnslider-' + $el.data('id');
	}

	return bnslider;
})();

GoodwinSlider.bnsliderVideo = (function () {
	var autoplayCheckComplete = false;
	var autoplayAvailable = false;
	var playOnClickChecked = false;
	var playOnClick = false;
	var youtubeLoaded = false;
	var videos = {};
	var videoPlayers = [];
	var videoOptions = {
		ratio: 16 / 9,
		playerVars: {
			// eslint-disable-next-line camelcase
			iv_load_policy: 3,
			modestbranding: 1,
			autoplay: 0,
			controls: 0,
			showinfo: 0,
			wmode: 'opaque',
			branding: 0,
			autohide: 0,
			rel: 0
		},
		events: {
			onReady: onPlayerReady,
			onStateChange: onPlayerChange
		}
	};
	var classes = {
		playing: 'video-is-playing',
		paused: 'video-is-paused',
		loading: 'video-is-loading',
		loaded: 'video-is-loaded',
		bnsliderWrapper: 'bnslider-wrapper',
		slide: 'bnslider-slide',
		slideBackgroundVideo: 'bnslider-slide--background-video',
		slideDots: 'slick-dots',
		videoBox: 'bnslider-video--box',
		videoBackground: 'bnslider-video--background',
		playVideoBtn: 'bnslider-video-control--play',
		closeVideoBtn: 'bnslider-video-control--close',
		currentSlide: 'slick-current',
		slickClone: 'slick-cloned',
		supportsAutoplay: 'autoplay',
		supportsNoAutoplay: 'no-autoplay'
	};

	function init($video) {
		if (!$video.length) {
			return;
		}
		videos[$video.attr('id')] = {
			id: $video.attr('id'),
			videoId: $video.data('id'),
			type: $video.data('type'),
			status: $video.data('type') === 'box' ? 'closed' : 'background', // closed, open, background
			videoSelector: $video.attr('id'),
			$parentSlide: $video.closest('.' + classes.slide),
			$parentbnsliderWrapper: $video.closest('.' + classes.bnsliderWrapper),
			controls: $video.data('type') === 'background' ? 0 : 1,
			bnslider: $video.data('bnslider')
		};
		if (!youtubeLoaded) {
			// This code loads the IFrame Player API code asynchronously.
			var tag = document.createElement('script');
			tag.src = 'https://www.youtube.com/iframe_api';
			var firstScriptTag = document.getElementsByTagName('script')[0];
			firstScriptTag.parentNode.insertBefore(tag, firstScriptTag);
		}
	}

	function customPlayVideo(playerId) {
		// Do not autoplay just because the bnslider asked you to.
		// If the bnslider asks to play a video, make sure
		// we have done the playOnClick check first
		if (!playOnClickChecked && !playOnClick) {
			return;
		}
		if (playerId && typeof videoPlayers[playerId].playVideo === 'function') {
			privatePlayVideo(playerId);
		}
	}

	function pauseVideo(playerId) {
		if (videoPlayers[playerId] && typeof videoPlayers[playerId].pauseVideo === 'function') {
			videoPlayers[playerId].pauseVideo();
		}
	}

	function loadVideos() {
		for (var key in videos) {
			if (videos.hasOwnProperty(key)) {
				var args = $.extend({}, videoOptions, videos[key]);
				args.playerVars.controls = args.controls;
				videoPlayers[key] = new YT.Player(key, args);
			}
		}
		initEvents();
		youtubeLoaded = true;
	}

	function loadVideo(key) {
		if (!youtubeLoaded) {
			return;
		}
		var args = $.extend({}, videoOptions, videos[key]);
		args.playerVars.controls = args.controls;
		videoPlayers[key] = new YT.Player(key, args);
		initEvents();
	}

	function privatePlayVideo(id, clicked) {
		var videoData = videos[id];
		var player = videoPlayers[id];
		var $slide = videos[id].$parentSlide;
		if (!autoplayCheckComplete) {
			autoplayCheckFunction(player, $slide);
		}
		if (playOnClick) {
			setAsPlaying(videoData);
		} else if (clicked || (autoplayCheckComplete && autoplayAvailable)) {
			$slide.removeClass(classes.loading);
			setAsPlaying(videoData);
			player.playVideo();
			return;
		}
	}

	function setAutoplaySupport(supported) {
		var supportClass = supported ? classes.supportsAutoplay : classes.supportsNoAutoplay;
		$(document.documentElement).addClass(supportClass);
		if (!supported) {
			playOnClick = true;
		}
		autoplayCheckComplete = true;
	}

	function autoplayCheckFunction(player, $slide) {
		var supports_video_autoplay = function (callback) {
			if (typeof callback !== "function") return false;
			var v = document.createElement("video");
			v.paused = true;
			var p = "play" in v && v.play();
			callback(!v.paused || ("Promise" in window && p instanceof Promise));
		};
		supports_video_autoplay(function (supported) {
			autoplayCheckComplete = true;
			$slide.removeClass(classes.loading);
			if (supported) {
				setAutoplaySupport(true);
				autoplayAvailable = true;
			} else {
				setAutoplaySupport(false);
				player.stopVideo();
			}
		});
	}

	function autoplayTest(player) {
		var deferred = $.Deferred();
		var wait;
		var timeout;
		wait = setInterval(function () {
			if (player.getCurrentTime() <= 0) {
				return;
			}
			autoplayAvailable = true;
			clearInterval(wait);
			clearTimeout(timeout);
			deferred.resolve();
		}, 500);
		timeout = setTimeout(function () {
			clearInterval(wait);
			deferred.reject();
		}, 4000);
		return deferred;
	}

	function playOnClickCheck() {
		if (playOnClickChecked) {
			return;
		}
		if ($(window).width() < 750) {
			playOnClick = true;
		} else if (window.mobileCheck()) {
			playOnClick = true;
		}
		if (playOnClick) {
			setAutoplaySupport(false);
		}
		playOnClickChecked = true;
	}

	function onPlayerReady(evt) {
		evt.target.setPlaybackQuality('hd1080');
		var videoData = getVideoOptions(evt);
		playOnClickCheck();
		$('#' + videoData.id).attr('tabindex', '-1');
		sizeBackgroundVideos();
		switch (videoData.type) {
			case 'background-box':
			case 'background':
				evt.target.mute();
				// Only play the video if it is in the active slide
				if (videoData.$parentSlide.hasClass(classes.currentSlide)) {
					privatePlayVideo(videoData.id);
				}
				break;
		}
		videoData.$parentSlide.addClass(classes.loaded);
	}

	function onPlayerChange(evt) {
		var videoData = getVideoOptions(evt);
		switch (evt.data) {
			case 0: // ended
				setAsFinished(videoData);
				break;
			case 1: // playing
				setAsPlaying(videoData);
				break;
			case 2: // paused
				setAsPaused(videoData);
				break;
		}
	}

	function setAsFinished(videoData) {
		switch (videoData.type) {
			case 'background':
				videoPlayers[videoData.id].seekTo(0);
				break;
			case 'background-box':
				videoPlayers[videoData.id].seekTo(0);
				closeVideo(videoData.id);
				break;
			case 'box':
				closeVideo(videoData.id);
				break;
		}
	}

	function setAsPlaying(videoData) {
		var $bnslider = videoData.$parentbnsliderWrapper;
		var $slide = videoData.$parentSlide;
		$slide.removeClass(classes.loading);
		if (videoData.status === 'background') {
			return;
		}
		$('#' + videoData.id).attr('tabindex', '0');
		switch (videoData.type) {
			case 'box':
			case 'background-box':
				$bnslider
					.removeClass(classes.paused)
					.addClass(classes.playing);
				$slide
					.removeClass(classes.paused)
					.addClass(classes.playing);
				break;
		}
		$slide.find('.' + classes.closeVideoBtn).focus();
	}

	function setAsPaused(videoData) {
		var $bnslider = videoData.$parentbnsliderWrapper;
		var $slide = videoData.$parentSlide;
		if (videoData.type === 'background-box') {
			closeVideo(videoData.id);
			return;
		}
		if (videoData.status !== 'closed' && videoData.type !== 'background') {
			$bnslider.addClass(classes.paused);
			$slide.addClass(classes.paused);
		}
		if (videoData.type === 'box' && videoData.status === 'closed') {
			$bnslider.removeClass(classes.paused);
			$slide.removeClass(classes.paused);
		}
		$bnslider.removeClass(classes.playing);
		$slide.removeClass(classes.playing);
	}

	function closeVideo(playerId) {
		var videoData = videos[playerId];
		var $bnslider = videoData.$parentbnsliderWrapper;
		var $slide = videoData.$parentSlide;
		var classesToRemove = [classes.pause, classes.playing].join(' ');
		$('#' + videoData.id).attr('tabindex', '-1');
		videoData.status = 'closed';
		switch (videoData.type) {
			case 'background-box':
				videoPlayers[playerId].mute();
				setBackgroundVideo(playerId);
				break;
			case 'box':
				videoPlayers[playerId].stopVideo();
				setAsPaused(videoData); // in case the video is already paused
				break;
		}
		$bnslider.removeClass(classesToRemove);
		$slide.removeClass(classesToRemove);
	}

	function getVideoOptions(evt) {
		return videos[evt.target.h.id];
	}

	function startVideoOnClick(playerId) {
		var videoData = videos[playerId];
		// add loading class to slide
		videoData.$parentSlide.addClass(classes.loading);
		videoData.status = 'open';
		switch (videoData.type) {
			case 'background-box':
				unsetBackgroundVideo(playerId, videoData);
				videoPlayers[playerId].unMute();
				privatePlayVideo(playerId, true);
				break;
			case 'box':
				privatePlayVideo(playerId, true);
				break;
		}
		$(document).on('keydown.videoPlayer', function (evt) {
			if (evt.keyCode === 27) {
				closeVideo(playerId);
			}
		});
	}

	function sizeBackgroundVideos() {
		$('.' + classes.videoBackground).each(function (index, el) {
			sizeBackgroundVideo($(el));
		});
	}

	function sizeBackgroundVideo($player) {
		var $slide = $player.closest('.' + classes.slide);
		// Ignore cloned slides
		if ($slide.hasClass(classes.slickClone)) {
			return;
		}
		var slideWidth = $slide.width();
		var playerWidth = $player.width();
		var playerHeight = $player.height();
		if (slideWidth / videoOptions.ratio < playerHeight) {
			playerWidth = Math.ceil(playerHeight * videoOptions.ratio);
			if ($('body').hasClass('rtl')) {
				$player.width(playerWidth).height(playerHeight).css({
					right: (slideWidth - playerWidth) / 2,
					top: 0
				});
			} else {
				$player.width(playerWidth).height(playerHeight).css({
					left: (slideWidth - playerWidth) / 2,
					top: 0
				});
			}

		} else {
			playerHeight = Math.ceil(slideWidth / videoOptions.ratio);
			$player.width(slideWidth).height(playerHeight).css({
				left: 0,
				right: '',
				top: (playerHeight - playerHeight) / 2
			});
		}
		$player
			.prepareTransition()
			.addClass(classes.loaded);
	}

	function unsetBackgroundVideo(playerId) {
		$('#' + playerId)
			.removeAttr('style')
			.removeClass(classes.videoBackground)
			.addClass(classes.videoBox);

		videos[playerId].$parentbnsliderWrapper
			.removeClass(classes.slideBackgroundVideo)
			.addClass(classes.playing);

		videos[playerId].$parentSlide
			.removeClass(classes.slideBackgroundVideo)
			.addClass(classes.playing);

		videos[playerId].status = 'open';
	}

	function setBackgroundVideo(playerId) {
		var $player = $('#' + playerId)
			.addClass(classes.videoBackground)
			.removeClass(classes.videoBox);

		videos[playerId].$parentSlide
			.addClass(classes.slideBackgroundVideo);

		videos[playerId].status = 'background';
		sizeBackgroundVideo($player);
	}

	function initEvents() {
		$(document).on('click.videoPlayer', '.' + classes.playVideoBtn, function (evt) {
			var playerId = $(evt.currentTarget).data('controls');
			startVideoOnClick(playerId);
		});

		$(document).on('click.videoPlayer', '.' + classes.closeVideoBtn, function (evt) {
			var playerId = $(evt.currentTarget).data('controls');
			closeVideo(playerId);
		});

		$(window).on('resize.videoPlayer', $.debounce(250, function () {
			if (youtubeLoaded) {
				sizeBackgroundVideos();
			}
		}));
	}

	function removeEvents() {
		$(document).off('.videoPlayer');
		$(window).off('.videoPlayer');
	}

	return {
		init: init,
		loadVideos: loadVideos,
		loadVideo: loadVideo,
		playVideo: customPlayVideo,
		pauseVideo: pauseVideo,
		removeEvents: removeEvents
	};
})();

$(function () {
	GoodwinSlider.bnsliders = {};
	$('.bnslider-video').each(function () {
		var $el = $(this);
		GoodwinSlider.bnsliderVideo.init($el);
		GoodwinSlider.bnsliderVideo.loadVideo($el.attr('id'));
	});
	$('.bnslider').each(function () {
		var $el = $(this);
		var bnslider = "#" + $el.attr('id');
		GoodwinSlider.bnsliders[bnslider] = new GoodwinSlider.bnslider(bnslider);
	});
	$(window).on('resize', $.debounce(250, function () {
		$('.bnslider').each(function () {
			keepScale($(this));
		});
	}));
});
});