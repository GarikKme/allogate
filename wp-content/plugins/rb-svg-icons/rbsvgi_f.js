(function ($) {
'use strict';

	$(document).ready(function(e) {
		$('style[id^="rbsvgi_"]').each(function(){
			var svg = this.parentNode.getElementsByTagName('svg')[0];
			if (undefined !== svg){
				var percents = this.innerText.match(/transform-origin: (\d+)% (\d+)%/);
				if (percents) {
					var px = percents[1]*svg.viewBox.baseVal.width/100;
					var py = percents[2]*svg.viewBox.baseVal.height/100;
					this.innerText = this.innerText.replace(/transform-origin: (\d+)% (\d+)%/g, 'transform-origin: '+px+'px '+py+'px');
				}
			}
		});

		$('i[id^="rbsvgi_"][data-atype="hover-rev"] svg *, i[id^="rbsvgi_"][data-atype="hover-rev"] svg').on('animationend', function(e){
			var parent_i = $(this).closest('i');
			if (parent_i.hasClass('out')) {
				parent_i.removeClass('out');
			}
		});

		$('i[id^="rbsvgi_"][data-atype="hover-rev"]').on('mouseleave', function(e){
			$(this).addClass('out');
		});

	});

	$(document).scroll(function() {
		$('i[id^="rbsvgi_"][data-atype="scroll"]').each(function(){
			var y = $(document).scrollTop() + (window.innerHeight * 3/4);
			var t = this.offsetTop;
			if (y > t) {
				$(this).addClass('rbsvgi_animate');
			} else {
				$(this).removeClass('rbsvgi_animate');
			}
		});
	});

})( window.jQuery );