jQuery( document ).ready( function ($) {
	//'use strict';

	// Instantiates the variable that holds the media library frame.
    var $wpmedia;
    var $parent;
 
    // Runs when the image button is clicked.
    jQuery('.wallpaperbug-upload-image').click(function(e){
        // Prevents the default action from occuring.
        e.preventDefault();
        
        $parent = $(this);
 
        // If the frame already exists, re-open it.
        if ( $wpmedia ) {
            $wpmedia.open();
            return;
        }
 
        // Sets up the media library frame
        $wpmedia = wp.media.frames.$wpmedia = wp.media({
            title: "Select Wallpaper",
            button: { text:  "Select" },
            library: { type: 'image' }
        });
 
        // Runs when an image is selected.
        $wpmedia.on('select', function(){
 
            // Grabs the attachment selection and creates a JSON representation of the model.
            var $attachment = $wpmedia.state().get('selection').first().toJSON();
 
            // Sends the attachment URL to our custom image input field.
            $($parent).siblings(".wallpaperbug_attachment_url").val($attachment.url);
            $($parent).siblings(".wallpaperbug_attachment_id").val($attachment.id);
            $($parent).siblings(".wallpaperbug_image").css({
                "background-image" : "url(" + $attachment.url + ")"
            });
        });
 
        // Opens the media library frame.
        $wpmedia.open();
    });

});
