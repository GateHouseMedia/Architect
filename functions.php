<?
require_once(get_stylesheet_directory() . '/inc/child_widgets.php');
function gatehouse_projects_architect_scripts() {
    wp_enqueue_script( 'architect_balancetext', '//cdnjs.cloudflare.com/ajax/libs/balance-text/3.2.0/balancetext.min.js', array('jquery') );
    wp_enqueue_script( 'architect_stickyfill', '//despace.design/projects-backend/libs/stickyfill.min.js', array('jquery') );
    // Custom call to stylesheet created once for Gastonia -- same function could be used to add things using tags on other projects.
    if ( has_tag( 'gaston-data-page') ) {
  		wp_enqueue_style( 'gaston_datapage', '//web.gastongazette.com/interactive/educating-assets/profile-style.css');
	}
}
add_action( 'wp_enqueue_scripts', 'gatehouse_projects_architect_scripts' );
?>
