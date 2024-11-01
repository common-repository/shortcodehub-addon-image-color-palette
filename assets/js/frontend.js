(function($){

	"use strict";

	console.log( 'ok' );
	let Sh_Addon_ICP = {

		frame: '',

		init: function()
		{
			// Once images are loaded, process them.
			var colorThief = new ColorThief();

			$('.sh-image-palette-image').each(function(index, el) {

				var parent    	  = $( el ).parents('.sh-addon-icp'),
					primary_color = parent.find('.sh-addon-icp-primary-color'),
					three_colors  = parent.find('.sh-addon-icp-three-colors'),
					five_colors   = parent.find('.sh-addon-icp-five-colors'),
					all_palettes  = parent.find('.sh-addon-icp-palettes-all');

				// Primary color.
				if( primary_color.length ) {
					var result = colorThief.getColor( el );
					var output = '<span class="color-wrap"><span class="color" style="background-color: rgb('+ result.toString() + ');"></span><span class="color-code">rgb('+ result.toString() +')</span></span>';
					primary_color.find('.colors').html( output );
				}

				// Three color.
				if( three_colors.length ) {
					var palettes = colorThief.getPalette( el, 3 );
					if( palettes ) {
						var output = '';
						palettes.forEach((color) => {
						output += '<span class="color-wrap"><span class="color" style="background-color: rgb('+color.toString() + ');"></span><span class="color-code">rgb('+color.toString() + ')</span></span>';
						});
						three_colors.find('.colors').html( output );
					}
				}

				// Five Palettes.
				if( five_colors.length ) {
					var palettes = colorThief.getPalette( el, 5 );
					if( palettes ) {
						var output = '';
						palettes.forEach((color) => {
						output += '<span class="color-wrap"><span class="color" style="background-color: rgb('+color.toString() + ');"></span><span class="color-code">rgb('+color.toString() + ')</span></span>';
						});
						five_colors.find('.colors').html( output );
					}
				}

				// All Palettes.
				if( all_palettes.length ) {
					var palettes = colorThief.getPalette( el );
					if( palettes ) {
						var output = '';
						palettes.forEach((color) => {
						output += '<span class="color-wrap"><span class="color" style="background-color: rgb('+color.toString() + ');"></span><span class="color-code">rgb('+color.toString() + ')</span></span>';
						});
						all_palettes.find('.colors').html( output );
					}
				}

			});
		}

	};

	/**
	 * Initialize Sh_Addon_ICP
	 */
	$(function(){
		Sh_Addon_ICP.init();
	});

})(jQuery);