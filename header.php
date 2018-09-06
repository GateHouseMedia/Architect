<?php
/**
 * The header for our theme.
 *
 * This is the template that displays all of the <head> section and everything up until <div id="content">
 *
 * @link https://developer.wordpress.org/themes/basics/template-files/#template-partials
 *
 * @package GatehouseProjects
 */
?><!DOCTYPE html>
<!-- Mostly required WP stuff, calls our Google Fonts -->
<html <?php language_attributes(); ?>>
<head>
<meta charset="<?php bloginfo( 'charset' ); ?>">
<meta name="viewport" content="width=device-width, initial-scale=1">
<link rel="profile" href="http://gmpg.org/xfn/11">
<link href="https://fonts.googleapis.com/css?family=Adamina|Roboto:300,700" rel="stylesheet">
<!-- Google Tag Manager // Adds tracker for the Projects roll-up view -->
<script>(function(w,d,s,l,i){w[l]=w[l]||[];w[l].push({'gtm.start':
new Date().getTime(),event:'gtm.js'});var f=d.getElementsByTagName(s)[0],
j=d.createElement(s),dl=l!='dataLayer'?'&l='+l:'';j.async=true;j.src=
'https://www.googletagmanager.com/gtm.js?id='+i+dl;f.parentNode.insertBefore(j,f);
})(window,document,'script','dataLayer','YOUR-AD-TAG-HERE');</script>
<!-- End Google Tag Manager -->
<?php wp_head(); ?>
<?php 
global $post;
$GLOBALS['ghDomain'] = 'http://gatehouseprojects.com';
$GLOBALS['ghAnalytics'] = "ga('create', 'YOUR-AD-TAG-HERE', {'name':'firstTracker',});
	ga('create', 'YOUR-AD-TAG-HERE', {'name':'secondTracker',});
	ga('create', 'YOUR-AD-TAG-HERE', {'name':'fourthTracker',});
	ga('firstTracker.send', 'pageview');
	ga('secondTracker.send', 'pageview');
	ga('fourthTracker.send', 'pageview');";
// Next line replaces an empty logo variable with GateHouse -- change as needed
$GLOBALS['ghLogo'] = "GateHouse Media";
$shareLink = get_permalink();
$pageSlug = $post->post_name;
global $wp_query;

// The following is the call to the GateHouse site-data.js to process the necessary variables. If you're non-GateHouse, feel free to delete this section or replace the URL + JSON unfurl with a similar page hosted on your own newspaper website.

if(isset($wp_query->query_vars['site'])) {
	if(!empty($wp_query->query_vars['site'])) {
		$GLOBALS['ghSite'] = $wp_query->query_vars['site'];
		// Special consideration for Daytona's URL redirect
		if (strpos($GLOBALS['ghSite'], 'news-jrnl.com') !== false) {
			$GLOBALS['ghSite'] = 'news-journalonline.com';
		}
		// If there's a slash after the link, we know to append the /site/newspaper.com for all pages.
		if(home_url() . "/" == $shareLink) {
			$shareLink = get_permalink() . "{$pageSlug}/site/{$GLOBALS['ghSite']}";
		} else {
			$shareLink = get_permalink() . "site/{$GLOBALS['ghSite']}";
		}
		
		$jsonURL = "http://{$GLOBALS['ghSite']}/section/site-data-js.js?map=gatehouseprojects_default";
		$ghSiteContent = file_get_contents("http://{$GLOBALS['ghSite']}/section/site-data-js.js?map=gatehouseprojects_default");
		$ghSiteContent = explode(';', $ghSiteContent);
		$ghSiteContent = str_replace('var __gh__coreData = ', '', $ghSiteContent[0]);
		$ghSiteContent = str_replace(',}', '}', $ghSiteContent);
		$json = json_decode($ghSiteContent);
		if(isset($json->siteData->logoURL)){
			$siteLogo = $json->siteData->logoURL;
			$GLOBALS['ghDomain'] = "http://{$GLOBALS['ghSite']}";
			echo "<script>var $ = jQuery;</script>";
		}
		if(isset($json->{'3rdPartyData'}->analytics->google->ua)) {
			$GLOBALS['ghAnalytics'] = "ga('create', 'YOUR-GA-TAG', {'name':'firstTracker',});
			ga('create', 'YOUR-GA-TAG', {'name':'secondTracker',});
			ga('create', '{$json->{'3rdPartyData'}->analytics->google->ua}', {'name':'thirdTracker',});
			ga('create', 'YOUR-GA-TAG', {'name':'fourthTracker',}); 
			ga('firstTracker.send', 'pageview'); 
			ga('secondTracker.send', 'pageview');
			ga('thirdTracker.send', 'pageview'); 
			ga('fourthTracker.send', 'pageview');";
        }

        // Check to make sure the hyphen appears in Register-Guard (can likely be removed)
        $GLOBALS['ghLogo'] = $json->siteData->siteTitle;
		if (strpos($GLOBALS['ghLogo'], 'The Register Guard') !== false) {
			$GLOBALS['ghLogo'] = 'The Register-Guard';
		}

		// Get the DFP ID to run into the ad script
        $GLOBALS['dfpID'] = $json->{'3rdPartyData'}->ads->dfp->id;
	}
}

wp_reset_query();
?>
<style type="text/css">
	<?php
	if( get_theme_mod( 'ghp_custom_logo_setting' ) != '' ) {
	?>
	@media (max-width: 799px) {
		.navbar-brand { display:none; }
		.navbar-logo { margin: 0; }
	}
	<?php
	}
	?>
</style>
</head>

<body <?php body_class(); ?>>
<!-- Google Tag Manager (noscript) -->
<noscript><iframe src="https://www.googletagmanager.com/ns.html?id=YOUR-GA-TAG"
height="0" width="0" style="display:none;visibility:hidden"></iframe></noscript>
<!-- End Google Tag Manager (noscript) -->
<div id="page" class="site">
	<header id="masthead" class="site-header" role="banner">
		<div class="site-branding">
			<?php
			if ( is_front_page() && is_home() ) : ?>
				
			<?php else : ?>
				
			<?php endif; ?>
		</div><!-- .site-branding -->
	</header><!-- #masthead -->

	<!-- Creation of the top nav takes place here. Requires WP 'primary navigation' -->
    
    <div class="river-nav">
            <a class="river-nav-branding" href="http://<? echo $GLOBALS['ghSite'] ?>"><? echo $GLOBALS['ghLogo']; ?></a>
            <?php /* Primary navigation */
                wp_nav_menu( array(
                  'theme_location' => '',
                  'depth'          => 2,
                  'container'      => false,
                  'menu_class'     => '',
                  'walker'		 => new wp_bootstrap_navwalker()
                  )
                );
            ?>
    </div> <!-- river-nav -->
    
    
	<script>
		var nav = jQuery('.nav.navbar-nav ul');
		if(nav.hasClass('nav')) {

		} else {
			nav.addClass('nav');
			nav.addClass('navbar-nav');
		}
	</script>

	<!-- These share links are not used in Architect but are used in the original parent theme, GateHouse projects, and are along for the ride out of longevity. It's also handy because it shows the construction of social sites share links. -->
    <div id="share-links-container">
		<div id="share-links-fixed-container">
			<div id="share-head">SHARE</div>
			<a href="https://www.facebook.com/sharer/sharer.php?u=<?php echo $shareLink; ?>" class="share-button" target="_blank"><div class="fb-share"></div></a>
			<a href="https://twitter.com/intent/tweet?url=<?php echo $shareLink; ?>" class="share-button" target="_blank"><div class="twitter-share"></div></a>
			<a href="https://plus.google.com/share?url=<?php echo $shareLink; ?>" class="share-button" target="_blank"><div class="gp-share"></div></a>
			<a href="https://www.linkedin.com/shareArticle?mini=true&url=<?php echo $shareLink; ?>&title=<?php echo bloginfo('name'); ?>&source=Gatehouse%20Projects" class="share-button" target="_blank"><div class="li-share"></div></a>
			<a href="mailto:?subject=<?php echo bloginfo('name'); ?>&body=<?php echo $shareLink; ?>" class="share-button"><div class="email-share"></div></a>
		</div>
	</div>

	<!-- Begin site content below. -->
	<div id="content" class="site-content">
