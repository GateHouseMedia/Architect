// TODO:
// Make function in js that calculates height of row to make siblings for scrollmagic
// Add this js to inc/js and then in functions use get_stylesheet_directory from below
// Create widgets that style text, images and captions the way we want 
// get_stylesheet_directory (child)
// get_template_directory (parent)

var controller = new ScrollMagic.Controller();

var scene = []

jQuery(function () { // wait for document ready
    var allHeights = jQuery('.body-copy')
    for (var i = 0; i <= allHeights.length; i++) {
    	scene[i] = new ScrollMagic.Scene({triggerElement: jQuery('.body-copy').eq(i), duration: jQuery('.body-copy').eq(i).height()})
					.setPin(jQuery('.widget_media_image').eq(i))
					.addTo(controller);	
    }
});