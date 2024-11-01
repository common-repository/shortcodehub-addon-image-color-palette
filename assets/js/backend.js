(function($){

	"use strict";

	let Sh_Addon_ICP = {

		frame: '',

		init: function()
		{
			$( document ).on( 'click', '.sh-add-image', this.show_popup);
		},

		show_popup: function( event ) {

			event.preventDefault();

			let image_wrap = $( this ).parents('.sh-image-wrap');
    
		    // If the media frame already exists, reopen it.
		    if ( Sh_Addon_ICP.frame ) {
		      Sh_Addon_ICP.frame.open();
		      return;
		    }
		    
		    // Create a new media frame
		    Sh_Addon_ICP.frame = wp.media({
		      title: 'Select or Upload Media Of Your Chosen Persuasion',
		      button: {
		        text: 'Use this media'
		      },
		      multiple: false  // Set to true to allow multiple files to be selected
		    });

		    
		    // When an image is selected in the media frame...
		    Sh_Addon_ICP.frame.on( 'select', function() {
		      
		      // Get media attachment details from the frame state
		      var attachment = Sh_Addon_ICP.frame.state().get('selection').first().toJSON();
		      console.log( attachment );

		      image_wrap.find('.sh-show-image img').attr('src', attachment.url);
		      image_wrap.find('.sh-image-color-palette-id').val( attachment.id );
		      image_wrap.find('.sh-image-color-palette-url').val( attachment.url );

				// alt: ""
				// author: "1"
				// authorName: "Mahesh Waghmare"
				// caption: ""
				// compat: {item: "", meta: ""}
				// context: ""
				// date: Sun Jul 21 2019 12:47:19 GMT+0530 (India Standard Time) {}
				// dateFormatted: "July 21, 2019"
				// description: ""
				// editLink: "http://localhost/dev.test/wp-admin/post.php?post=2009&action=edit"
				// filename: "pexels-photo-1036623.jpeg"
				// filesizeHumanReadable: "67 KB"
				// filesizeInBytes: 68209
				// height: 854
				// icon: "http://localhost/dev.test/wp-includes/images/media/default.png"
				// id: 2009
				// link: "http://localhost/dev.test/pexels-photo-1036623/"
				// menuOrder: 0
				// meta: false
				// mime: "image/jpeg"
				// modified: Sun Jul 21 2019 12:47:19 GMT+0530 (India Standard Time) {}
				// name: "pexels-photo-1036623"
				// nonces: {update: "190e79c102", delete: "be47949c8f", edit: "bdb0bfa741"}
				// orientation: "landscape"
				// sizes: {thumbnail: {…}, medium: {…}, large: {…}, full: {…}}
				// status: "inherit"
				// subtype: "jpeg"
				// title: "pexels-photo-1036623"
				// type: "image"
				// uploadedTo: 0
				// url: "http://localhost/dev.test/wp-content/uploads/2019/07/pexels-photo-1036623.jpeg"
				// width: 1280

		      // // Send the attachment URL to our custom image input field.
		      // imgContainer.append( '<img src="'+attachment.url+'" alt="" style="max-width:100%;"/>' );

		      // // Send the attachment id to our hidden input
		      // imgIdInput.val( attachment.id );

		      // // Hide the add image link
		      // addImgLink.addClass( 'hidden' );

		      // // Unhide the remove image link
		      // delImgLink.removeClass( 'hidden' );
		    });

		    // Finally, open the modal on click
		    Sh_Addon_ICP.frame.open();
		}

	};

	/**
	 * Initialize Sh_Addon_ICP
	 */
	$(function(){
		Sh_Addon_ICP.init();
	});

})(jQuery);