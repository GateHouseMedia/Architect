<?php
/**
 * The template for displaying the footer
 *
 * Contains the closing of the #content div and several scripts that run on every page.
 *
 * @link https://developer.wordpress.org/themes/basics/template-files/#template-partials
 *
 * @package GatehouseProjects
 */

?>

	</div><!-- #content -->

<?php wp_footer(); ?>

<!-- Adds appropriate Google Analytics tag to footer of document. Notice the $GLOBALS analytics variable -- this comes from /site/newspaper.com as well as site-data-js.js -->
	<script>
		(function (i, s, o, g, r, a, m)
	    {
	        i['GoogleAnalyticsObject'] = r; i[r] = i[r] || function ()
	        {
	            (i[r].q = i[r].q || []).push(arguments)
	        }, i[r].l = 1 * new Date(); a = s.createElement(o),
	        m = s.getElementsByTagName(o)[0]; a.async = 1; a.src = g; m.parentNode.insertBefore(a, m)
	    })(window, document, 'script', '//www.google-analytics.com/analytics.js', 'ga');
	    <?php echo $GLOBALS['ghAnalytics'] ?>
	</script>

<script>

		// Functions unique to Architect -- this first one looks at the menu height to decide whether it should layer on top of the hero image or 'push' the image down. The menu bar layers at the menu's smallest height (56 px) but pushes the content down at all other heights.
		
		function fixMenu() {
		var menuHeight = jQuery('.river-nav').outerHeight()
		if (menuHeight > 56) {
			jQuery('.river-nav').css('top','0');
			jQuery('#content').css('margin-top', menuHeight + 'px')
		}
		else {
			if (jQuery('#content').css('margin-top') != null) {
				jQuery('#content').css('margin-top','0px')
			}
		}
		}

		jQuery(document).ready(function() {
			fixMenu();
		})

		var doit;
		window.onresize = function(){
		  clearTimeout(doit);
		  doit = setTimeout(fixMenu, 100);
		};

		// Balances headlines 
		balanceText();

		// The magic sticky function. At desktop breakpoints, it runs through all of the copy widgets and collects their height, then runs through the sidebar widgets and adds the same height to that side. Then, it uses the css position: sticky attribute (and a polyfill) to create the sticky effect. 

		if (jQuery(window).width() > 780) {
			var allCopy = jQuery('div.body-copy')
			var allStickies = jQuery('.stickybox')
			var navHeight = jQuery('.river-nav').outerHeight()

			for (var i = 0; i <= allCopy.length; i++) {
				var currentHeight = allCopy.eq(i).height()
				var currentStickyContainer = allStickies.eq(i)
				var currentSticky = currentStickyContainer.children('div:first')
				currentStickyContainer.height(currentHeight)
				currentSticky.addClass('sticky')
				currentSticky.css('top', navHeight + 25)
				currentSticky.css('margin-top', '25px')
			}
			var elements = jQuery('.sticky');
			Stickyfill.add(elements);
		}

		// Checks to see if an ad is present, if so, appends the ad script to the content that calls DFP.
		if (jQuery('.ad').index() > 0) {
            addScript();
		}
		

		
</script>

<!-- Support for a plugin called image grid -- adds the site URL to the grid images. -->

<?php
	global $wp_query;
	if(isset($wp_query->query_vars['site'])) {
		if(!empty($wp_query->query_vars['site'])) {
			$siteUrl = $wp_query->query_vars['site'];
			?>
			<script>
			let siteUrl = '<?php echo $siteUrl; ?>';
			let gridImages = document.querySelectorAll('.sow-image-grid-image');
			for( let g = 0; g < gridImages.length; g++ ){
				gridImages[g].childNodes[1].href = gridImages[g].childNodes[1].href + '?site=' + siteUrl;
			}
			</script>
			<?php
		}
	}
?>
<?php echo get_theme_mod( 'ghp_custom_footer_setting' ); ?>
</body>
</html>
