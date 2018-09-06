<?
/** 
 * Create widgets bundle
 */
function despace_add_widget_tabs($tabs) {
    $tabs[] = array(
        'title' => __('Architect', 'architect_theme'),
        'filter' => array(
            'groups' => array('architect_theme')
        )
    );

    return $tabs;
}
add_filter('siteorigin_panels_widget_dialog_tabs', 'despace_add_widget_tabs', 20);

/**
 * Adds Despace_DFP_Leaderboard widget.
 */
class Architect_DFP_Leaderboard_Ad extends WP_Widget {

	/**
	 * Register widget with WordPress.
	 */
	function __construct() {
		parent::__construct(
			'Architect_DFP_Leaderboard_Ad', // Base ID
			esc_html__( 'Architect | DFP Top Leaderboard Ad', 'text_domain' ), // Name
            array( 'description' => esc_html__( 'Adds a wide leaderboard ad from DFP. Must be used as the first ad.', 'text_domain' ), 'classname' => 'Architect_DFP_Leaderboard_Ad', 'panels_groups' => array('architect_theme') ), // Args
            add_action('admin_enqueue_scripts', array($this, 'scripts'))
		);
    }
    
    public function scripts() {
    }

	/**
	 * Front-end display of widget.
	 *
	 * @see WP_Widget::widget()
	 *
	 * @param array $args     Widget arguments.
	 * @param array $instance Saved values from database.
	 */
	
	// NOTE: Non-GateHouse will want to carefully look at that addScript() function since it uses some GateHouse-standard classes for the ads. Replace with your own values as necessary.
	public function widget( $args, $instance ) {
            ?>
            <div class="ad ad-billboard ad-lazy text-center" data-gh-lazy-ad-bucket-targeting='{"ad-type":"standard","slot":"View Plus Leaderboard","sov":"base ROS"}' data-dimensions="[[728,90],[970,90]]" data-size-mapping="baseLeaderboard" data-gh-lazy-ad-loaded="false"></div>
            <script>
                function addScript() {
                    var siteName = '<?php echo $GLOBALS['ghSite']; ?>';
                    var tag = "<?php echo $instance['tag']; ?>";
                    var src = 'http://' + siteName + '/section/site-data-js.js?tag=' + tag + '&templatetype=headerOnly';
                    var s = document.createElement( 'script' );
                    s.setAttribute( 'src', src );
                    document.getElementById('content').appendChild(s);
                }
                addScript();
            </script>
            <?
	}

	/**
	 * Back-end widget form.
	 *
	 * @see WP_Widget::form()
	 *
	 * @param array $instance Previously saved values from database.
	 */
	public function form( $instance ) {
        $tag = ! empty( $instance['tag'] ) ? $instance['tag'] : esc_html__( 'Tag for ad', 'text_domain' );
		?>
		<p>
		<label for="<?php echo esc_attr( $this->get_field_id( 'tag' ) ); ?>"><?php esc_attr_e( 'Ad tag:', 'text_domain' ); ?></label> 
		<input class="widefat" id="<?php echo esc_attr( $this->get_field_id( 'tag' ) ); ?>" name="<?php echo esc_attr( $this->get_field_name( 'tag' ) ); ?>" type="text" value="<?php echo esc_attr( $tag ); ?>">
        </p>
		<?php 
	}

	/**
	 * Sanitize widget form values as they are saved.
	 *
	 * @see WP_Widget::update()
	 *
	 * @param array $new_instance Values just sent to be saved.
	 * @param array $old_instance Previously saved values from database.
	 *
	 * @return array Updated safe values to be saved.
	 */
	public function update( $new_instance, $old_instance ) {
		$instance = array();
        $instance['tag'] = ( ! empty( $new_instance['tag'] ) ) ? strip_tags( $new_instance['tag'] ) : '';
		return $instance;
	}

} // class Architect_DFP_Leaderboard_Ad

/**
 * Adds Despace_DFP_Leaderboard widget.
 */
class Architect_DFP_Leaderboard_Secondary extends WP_Widget {

    /**
     * Register widget with WordPress.
     */
    function __construct() {
        parent::__construct(
            'Architect_DFP_Leaderboard_Secondary', // Base ID
            esc_html__( 'Architect | DFP Secondary Leaderboard Ad', 'text_domain' ), // Name
            array( 'description' => esc_html__( 'Adds a wide leaderboard ad from DFP. Must follow the "DFP First Leaderboard Ad"', 'text_domain' ), 'classname' => 'Architect_DFP_Leaderboard_Secondary', 'panels_groups' => array('architect_theme') ), // Args
            add_action('admin_enqueue_scripts', array($this, 'scripts'))
        );
    }
    
    public function scripts() {
    }

    /**
     * Front-end display of widget.
     *
     * @see WP_Widget::widget()
     *
     * @param array $args     Widget arguments.
     * @param array $instance Saved values from database.
     */
    public function widget( $args, $instance ) {
            ?>
            <div class="ad ad-billboard ad-lazy text-center" data-gh-lazy-ad-bucket-targeting='{"ad-type":"standard","slot":"View Plus Leaderboard","sov":"base ROS"}' data-dimensions="[[728,90],[970,90]]" data-size-mapping="baseLeaderboard"></div>
            <?
    }

    /**
     * Back-end widget form.
     *
     * @see WP_Widget::form()
     *
     * @param array $instance Previously saved values from database.
     */
    public function form( $instance ) {
        $tag = ! empty( $instance['tag'] ) ? $instance['tag'] : esc_html__( 'Tag for ad (the same for all ads)', 'text_domain' );
        ?>
        <p>
            Including this in your Site Builder will add a leaderboard ad wherever it is placed. Be sure to include the 'Top Leaderboard Ad' first.
        </p>
        <?php 
    }

    /**
     * Sanitize widget form values as they are saved.
     *
     * @see WP_Widget::update()
     *
     * @param array $new_instance Values just sent to be saved.
     * @param array $old_instance Previously saved values from database.
     *
     * @return array Updated safe values to be saved.
     */
    public function update( $new_instance, $old_instance ) {
        $instance = array();
        $instance['tag'] = ( ! empty( $new_instance['tag'] ) ) ? strip_tags( $new_instance['tag'] ) : '';
        return $instance;
    }

} // class Architect_DFP_Leaderboard_Secondary


class Architect_Hero_Widget extends WP_Widget {

    /**
     * Register widget with WordPress.
     */
    function __construct() {
        parent::__construct(
            'architect_hero_widget', // Base ID
            esc_html__( 'Architect | Text and Image Hero', 'text_domain' ), // Name
            array( 'description' => esc_html__( 'Adds a full-width image with a centered headline and subhead on top', 'text_domain' ), 'classname' => 'architect_hero_widget_image', 'panels_groups' => array('architect_theme') ), // Args
            add_action('admin_enqueue_scripts', array($this, 'scripts'))
        );
    }
    
    public function scripts() {
       wp_enqueue_script( 'media-upload' );
       wp_enqueue_media();
       wp_enqueue_script('ds_image', get_template_directory_uri() . '/js/ghpImage.js', array('jquery'), '1.0', true);
    }

    /**
     * Front-end display of widget.
     *
     * @see WP_Widget::widget()
     *
     * @param array $args     Widget arguments.
     * @param array $instance Saved values from database.
     */
    public function widget( $args, $instance ) {
        if ( ! empty( $instance['headline'] ) ) {
            ?>
            <div class="river-hero" style="background-image: url('<? echo $instance['image_uri'] ?>');">
                <div class="river-hed">
                    <h1><? echo $instance['headline']; ?></h1>
                    <p><? echo $instance['subhead']; ?></p>
                </div>
            </div>
            <div class="image-caption image-caption-hero"><p><? echo $instance['image_caption']; ?></p>
            </div>
            <?
        }
    }

    /**
     * Back-end widget form.
     *
     * @see WP_Widget::form()
     *
     * @param array $instance Previously saved values from database.
     */
    public function form( $instance ) {
        $headline = ! empty( $instance['headline'] ) ? $instance['headline'] : esc_html__( 'New headline', 'text_domain' );
        $subhead = ! empty( $instance['subhead'] ) ? $instance['subhead'] : esc_html__( 'New subhead', 'text_domain' );
        $imageURI = ! empty( $instance['image_uri'] ) ? $instance['image_uri'] : esc_html__( '', 'text_domain' );
        $imageCaption = ! empty( $instance['image_caption'] ) ? $instance['image_caption'] : esc_html__( '', 'text_domain' );
        ?>
        <p>This creates a full-width, full-height hero image with text over the top. The text is displayed in white with an 80% transparency.</p>
        <p>
        <label for="<?php echo esc_attr( $this->get_field_id( 'headline' ) ); ?>"><?php esc_attr_e( 'Headline:', 'text_domain' ); ?></label> 
        <input class="widefat" id="<?php echo esc_attr( $this->get_field_id( 'headline' ) ); ?>" name="<?php echo esc_attr( $this->get_field_name( 'headline' ) ); ?>" type="text" value="<?php echo esc_attr( $headline ); ?>">
        </p>
        <p>
        <label for="<?php echo esc_attr( $this->get_field_id( 'subhead' ) ); ?>"><?php esc_attr_e( 'Subhead:', 'text_domain' ); ?></label> 
        <input class="widefat" id="<?php echo esc_attr( $this->get_field_id( 'subhead' ) ); ?>" name="<?php echo esc_attr( $this->get_field_name( 'subhead' ) ); ?>" type="text" value="<?php echo esc_attr( $subhead ); ?>">
        </p>
        <p>
          <label for="<?php echo $this->get_field_id('image_uri'); ?>">Image:</label><br />
          <input type="text" class="img widefat" name="<?php echo $this->get_field_name('image_uri'); ?>" id="<?php echo $this->get_field_id('image_uri'); ?>" value="<?php echo $instance['image_uri']; ?>" name="<?php echo $this->get_field_name( 'image_uri' ); ?>" />
          <label style='margin-top:10px;' for="<?php echo $this->get_field_id('image_caption'); ?>"><?php _e( 'Caption:' ); ?></label><br />
          <input type="text" class="caption widefat" name="<?php echo $this->get_field_name('image_caption'); ?>" id="<?php echo $this->get_field_id('image_caption'); ?>" value="<?php echo $instance['image_caption']; ?>" name="<?php echo $this->get_field_name( 'image_caption' ); ?>" />
          <input style='margin-top:10px' type="button" class="select-img upload_image_button button button-primary" value="Select Image" />
        </p>
        <?php 
    }

    /**
     * Sanitize widget form values as they are saved.
     *
     * @see WP_Widget::update()
     *
     * @param array $new_instance Values just sent to be saved.
     * @param array $old_instance Previously saved values from database.
     *
     * @return array Updated safe values to be saved.
     */
    public function update( $new_instance, $old_instance ) {
        $instance = array();
        $instance['headline'] = ( ! empty( $new_instance['headline'] ) ) ? strip_tags( $new_instance['headline'] ) : '';
        $instance['subhead'] = ( ! empty( $new_instance['subhead'] ) ) ? strip_tags( $new_instance['subhead'] ) : '';
        $instance['image_uri'] = ( ! empty( $new_instance['image_uri'] ) ) ? $new_instance['image_uri'] : '';
        $instance['image_caption'] = ( ! empty( $new_instance['image_caption'] ) ) ? $new_instance['image_caption'] : '';

        return $instance;
    }

} // class Architect_Hero_Widget


class Architect_Text_Widget extends WP_Widget
{
    public function __construct() {
        parent::__construct( 'Architect_Text_Widget', __( 'Architect | Text Widget', 'rich_text_widget' ), array(
                'classname' => 'Architect_Text_Widget',
                'description' => __('Standard text/&lsquo;body copy&rsquo; widget', 'text_domain'),
                'panels_groups' => array('architect_theme')
            )
        );
    }

    public function widget( $args, $instance ) {
		if ( ! empty( $instance['body_copy'] ) ) {
            ?>
            <div class="body-leadin">
            	<h1 class="balance-text"><? echo $instance['body_leadin'] ?></h1>
            </div>
            <div class="body-byline">
            	<p><? echo $instance['body_byline'] ?></p>
            </div>
            <div class="body-copy">
	            <? echo $instance['body_copy'] ?>
        	</div>
            <?
       	// wp_enqueue_script('calc-height', get_stylesheet_directory_uri() . '/inc/js/calc-height.js', array('jquery'), true);
		}

    }

    public function form( $instance ) {

        $bodyCopy = esc_attr($instance['body_copy']);
        $body_leadin = ! empty( $instance['body_leadin'] ) ? $instance['body_leadin'] : esc_html__( '', 'text_domain' );
        $body_byline = ! empty( $instance['body_byline'] ) ? $instance['body_byline'] : esc_html__( '', 'text_domain' );
        ?>
        <p>This widget creates a text block. It is useful for body copy. The sidebar widget, which creates items that stick as you scroll, measures the height of the contents in this widget to determine how long something should 'stick' on screen.</p>
        <p><label for="<?php echo $this->get_field_id('body_leadin'); ?>"><?php _e('Text leadin — this can be used as a subhead or lead in for the story that follows it'); ?> <textarea class="widefat" type="text" value="" name="<?php echo $this->get_field_name('body_leadin'); ?>" id="<?php echo $this->get_field_id('body_leadin'); ?>"><?php echo $body_leadin?></textarea></label></p>
		<p>
		<label for="<?php echo esc_attr( $this->get_field_id( 'body_byline' ) ); ?>"><?php esc_attr_e( 'Byline for this section (optional)', 'text_domain' ); ?></label> 
		<input class="widefat" id="<?php echo esc_attr( $this->get_field_id( 'body_byline' ) ); ?>" name="<?php echo esc_attr( $this->get_field_name( 'body_byline' ) ); ?>" type="text" value="<?php echo esc_attr( $body_byline ); ?>">
        </p>
        <div><label for="<?php echo $this->get_field_id('body_copy'); ?>"><?php _e('Copy for the story here'); ?> <textarea class="widefat" type="text" value="" name="<?php echo $this->get_field_name('body_copy'); ?>" id="<?php echo $this->get_field_id('body_copy'); ?>"><?php echo $bodyCopy?></textarea></label></div>

        <script type="text/javascript">
            if (window.tinyMCE) {
                jQuery(document).ready(function(){
                    //set up editor in the textarea of the custom plugin
                    tinyMCE.init({
                        resize: 'vertical',
                    content_css: [
                        '//fonts.googleapis.com/css?family=Adamina',
                        ],
                        height : '300',
                        selector: '#<?php echo $this->get_field_id('body_copy'); ?>',
                        plugins: 'link image paste', 
                        image_caption: true,
                        image_description: false,
                        image_dimensions: false,
                        image_title: false,
                        style_formats: [
                                { title: 'Drop cap', inline: 'span', styles: { 'font-size': '35px', 'line-height': '1', 'margin-right': '3px', }},
                                { title: 'Paragraph', inline: 'p' },
                            ],
                        toolbar: 'undo redo | styleselect removeformat | bold italic | link image | alignleft aligncenter alignright alignjustify | bullist numlist outdent indent | table',
                        table_row_class_list: [
                          {title: 'Header Row', value: 'header-row'}
                        ],
                        menu: {},
                        relative_urls : 0,
                        file_browser_callback: function(field_name, url, type, win) {

                            jQuery('#mce-modal-block').hide();
                            jQuery('.mce-container.mce-floatpanel').hide();

                            var $input = jQuery('#'+field_name);

                            // Create the media frame.
                            var file_frame = wp.media.frames.file_frame = wp.media({
                                title: 'Select or upload image',
                                library: { // remove these to show all
                                    type: 'image' // specific mime
                                },
                                button: {
                                    text: 'Select'
                                },
                                multiple: false  // Set to true to allow multiple files to be selected
                            });

                            // When an image is selected, run a callback.
                            file_frame.on('select', function () {
                                // We set multiple to false so only get one image from the uploader

                                var attachment = file_frame.state().get('selection').first().toJSON();

                                jQuery('#mce-modal-block').show();
                                jQuery('.mce-container.mce-floatpanel').show();

                                $input.val(attachment.url);

                            });

                            file_frame.on('close', function () {
                                jQuery('#mce-modal-block').show();
                                jQuery('.mce-container.mce-floatpanel').show();
                            });

                            // Finally, open the modal
                            file_frame.open();

                        }
                    });
                });

                //click done btn to save contents of editor back to the db
                jQuery( ".button-primary.so-close" ).click(function() {
                    var richTextContent = tinymce.activeEditor.getContent();
                    document.getElementById("<?php echo $this->get_field_id('body_copy'); ?>").value = richTextContent;
                });
            }
        </script>

        <?php
    }

    public function update( $new_instance, $old_instance ) {
        $instance = $old_instance;
        $instance['body_copy'] = $new_instance['body_copy'];
        $instance['body_leadin'] = $new_instance['body_leadin'];
        $instance['body_byline'] = $new_instance['body_byline'];

        return $instance;
    }

}


class Architect_Sticky_Side_Widget extends WP_Widget {

    /**
     * Register widget with WordPress.
     */
    function __construct() {
        parent::__construct(
            'Architect_Sticky_Side_Widget', // Base ID
            esc_html__( 'Architect | Sidebar Widget', 'text_domain' ), // Name
            array( 'description' => esc_html__( 'Add an object (image, HTML, video or quote) that will stick in the right panel on scroll', 'text_domain' ), 'classname' => 'Architect_Sticky_Side_Widget', 'panels_groups' => array('architect_theme') ), // Args
            add_action('admin_enqueue_scripts', array($this, 'scripts'))
        );
    }
    
    public function scripts() {
       wp_enqueue_script( 'media-upload' );
       wp_enqueue_media();
       wp_enqueue_script('ds_image', get_template_directory_uri() . '/js/ghpImage.js', array('jquery'), '1.0', true);
       wp_enqueue_script('tab_switch', get_stylesheet_directory_uri() . '/inc/js/tabSwitch.js', array('jquery'), '1.0', true);
    }

    /**
     * Front-end display of widget.
     *
     * @see WP_Widget::widget()
     *
     * @param array $args     Widget arguments.
     * @param array $instance Saved values from database.
     */
    public function widget( $args, $instance ) {

        extract( $args );
        $placeholder_check = $instance [ 'placeholder_check' ] ? 'true' : 'false' ;
        $ad_check = $instance [ 'ad_check' ] ? 'true' : 'false' ;

        if( $instance[ 'placeholder_check' ] == 'on' ) { ?>
            <div class="stickybox">
                <div>
                </div>
            </div>
            <?
        }

        if ( ! empty( $instance['sticky_image_url'] ) ) {
                if ( ! empty( $instance['sticky_image_link'] ) ) {
                    ?>
                    <div class="stickybox">
                        <div class="image-panel">
                            <figure>
                            <a target="_blank" href="<? echo $instance['sticky_image_link']; ?>"><img src="<? echo $instance['sticky_image_url']; ?>">
                            <figcaption><? echo $instance['sticky_image_caption']; ?></figcaption>
                            </a>
                            </figure>
                        </div>
                    </div>
                    <?
                }

                else {
            ?>
            <div class="stickybox">
                <div class="image-panel">
                    <figure>
                    <img src="<? echo $instance['sticky_image_url']; ?>"></img>
                    <figcaption><? echo $instance['sticky_image_caption']; ?></figcaption>
                    </figure>
                </div>
            </div>
            <?
            }
        }
        if ( ! empty( $instance['sticky_custom_html'] ) ) {
            ?>
            <div class="stickybox">
                <div class="sticky customHTML">
                    <? echo $instance['sticky_custom_html']; ?>
                </div>
            </div>
            <?
        }
        if ( ! empty( $instance['sticky_video'] ) ) {
            ?>
            <div class="stickybox">
                <div>
                <div class='embed-container'><iframe src="https://www.youtube.com/embed/<? echo $instance['sticky_video'] . '?rel=0&amp;controls=0&amp;showinfo=0'; ?>" frameborder="0"></iframe></div>
                <div class="image-caption"><? echo $instance['sticky_video_caption']; ?></div>
                </div>
            </div>
            <?
        }

        if ( ! empty( $instance['sticky_quote'] ) ) {
            ?>
            <div class="stickybox">
                <div class="pullquote">
                    <h1><? echo $instance['sticky_quote'] ?></h1>
                    <p><? echo $instance['sticky_quote_attrib'] ?></p>
                    <div class="pullquote-share">
                    Share: 
                    <a href="http://www.facebook.com/sharer.php?u=<?php the_permalink();?>&t=<?php the_title(); ?>" target="_blank">Facebook </a>
                    <a target="_blank" href="https://twitter.com/share?url=<?echo $encodedURL?>&text=<?echo $instance['sticky_quote']?>">Twitter</a>
                    </div>
                </div>
            </div>
            <?
        }

        if ( ! empty( $instance['sticky_subscribe_link'] ) ) {
            ?>
            <div class="stickybox">
                <div class='subscribe-text'>                
                    <hr>
                <p><? echo $instance['sticky_subscribe_text'] ?></p>
                <a class="btn btn-primary subscribe-link" href="<? echo $instance['sticky_subscribe_link']?>" target="_blank">Subscribe</a>
                <hr>
                </div>
            </div>
            <?
        }

        if( $instance[ 'ad_check' ] == 'on' ) { ?>
            <div class="stickybox">
                <div class="ad ad-lazy" data-gh-lazy-ad-bucket-targeting='{"ad-type":"standard","slot":"View Plus Med Rec","sov":"base ROS"}' data-dimensions="[300,250]" data-gh-lazy-ad-loaded="false"></div>
            </div>
            <?
        }

    }

    /**
     * Back-end widget form.
     *
     * @see WP_Widget::form()
     *
     * @param array $instance Previously saved values from database.
     */
    public function form( $instance ) {
        $defaults = array( 'placeholder_check' => 'off');
        $defaults = array( 'ad_check' => 'off');
        $sticky_image_url = ! empty( $instance['sticky_image_url'] ) ? $instance['sticky_image_url'] : esc_html__( 'Image URL', 'text_domain' );
        $sticky_image_caption = ! empty( $instance['sticky_image_caption'] ) ? $instance['sticky_image_caption'] : esc_html__( '', 'text_domain' );
        $sticky_image_link = ! empty( $instance['sticky_image_link'] ) ? $instance['sticky_image_link'] : esc_html__( '', 'text_domain' );
        $sticky_video = ! empty( $instance['sticky_video'] ) ? $instance['sticky_video'] : esc_html__( '', 'text_domain' );
        $sticky_video_caption = ! empty( $instance['sticky_video_caption'] ) ? $instance['sticky_video_caption'] : esc_html__( '', 'text_domain' );
        $sticky_quote = ! empty( $instance['sticky_quote'] ) ? $instance['sticky_quote'] : esc_html__( '', 'text_domain' );
        $sticky_quote_attrib = ! empty( $instance['sticky_quote'] ) ? $instance['sticky_quote'] : esc_html__( '', 'text_domain' );
        $sticky_subscribe_link = ! empty( $instance['sticky_subscribe_link'] ) ? $instance['sticky_subscribe_link'] : esc_html__( '', 'text_domain' );
        $sticky_subscribe_text = ! empty( $instance['sticky_subscribe_text'] ) ? $instance['sticky_subscribe_text'] : esc_html__( '', 'text_domain' );
        $sticky_custom_html = ! empty( $instance['sticky_custom_html'] ) ? $instance['sticky_custom_html'] : wp_kses_post( '', 'text_domain' );
        $placeholder_check = ! empty( $instance['placeholder_check'] ) ? $instance['placeholder_check'] : wp_kses_post( '', 'text_domain' );
        $ad_check = ! empty( $instance['ad_check'] ) ? $instance['ad_check'] : wp_kses_post( '', 'text_domain' );
        ?>
        <h2 class="nav-tab-wrapper">
            <a href="#" onclick="tabSwitch('image')" class="nav-tab nav-tab-active imageTab">Image</a>
            <a href="#" onclick="tabSwitch('video')" class="nav-tab videoTab">YouTube Video</a>
            <a href="#" onclick="tabSwitch('ad')" class="nav-tab adTab">DFP 300x250 ad</a>
            <a href="#" onclick="tabSwitch('quote')" class="nav-tab quoteTab">Pull Quote</a>
            <a href="#" onclick="tabSwitch('subscribe')" class="nav-tab subscribeTab">Subscribe Button</a>
            <a href="#" onclick="tabSwitch('html')" class="nav-tab htmlTab">Embed/Custom HTML</a>
            <a href="#" onclick="tabSwitch('placeholder')" class="nav-tab htmlTab">Placeholder</a>
        </h2>

        <div class="imageTabfield sticky-field">
            <h3>Image and caption</h3>
            <p>This allows you to place and image and caption that will 'stick' as the reader scrolls. It sticks for the height of the item next to it. You should pair this image with a text block that makes sense with it.</p>
            <p>
          <label for="<?php echo $this->get_field_id('sticky_image_url'); ?>">Image:</label><br />
          <input type="text" class="img widefat" name="<?php echo $this->get_field_name('sticky_image_url'); ?>" id="<?php echo $this->get_field_id('sticky_image_url'); ?>" value="<?php echo $instance['sticky_image_url']; ?>" name="<?php echo $this->get_field_name( 'sticky_image_url' ); ?>" />
          <label style='margin-top:10px;' for="<?php echo $this->get_field_id('sticky_image_caption'); ?>"><?php _e( 'Caption:' ); ?></label><br />
          <input type="text" class="caption widefat" name="<?php echo $this->get_field_name('sticky_image_caption'); ?>" id="<?php echo $this->get_field_id('sticky_image_caption'); ?>" value="<?php echo $sticky_image_caption; ?>" name="<?php echo $this->get_field_name( 'sticky_image_caption' ); ?>" />
          <input style='margin-top:10px' type="button" class="select-img upload_image_button button button-primary" value="Select Image" />
            </p>

          <label style='margin-top:10px;' for="<?php echo $this->get_field_id('sticky_image_link'); ?>"><?php _e( '(Optional) If you want the image to link to something, put the address it should link to here: ' ); ?></label><br />
          <input type="text" class="caption widefat" name="<?php echo $this->get_field_name('sticky_image_link'); ?>" id="<?php echo $this->get_field_id('sticky_image_link'); ?>" value="<?php echo $sticky_image_link; ?>" name="<?php echo $this->get_field_name( 'sticky_image_link' ); ?>" />
            <p style="font-style: italic">Make sure to clear this field if you decide to switch to another content type!</p>
        </div>

        <div class="videoTabfield sticky-field" style="display:none">
            <h3>YouTube video and caption</h3>
            <p>This allows you to place a YouTube video and caption that will 'stick' as the reader scrolls. It sticks for the height of the item next to it. You should pair this image with a text block that makes sense with it. Please use only the YouTube video ID, not the entire video URL.</p>
          <label for="<?php echo $this->get_field_id('sticky_video'); ?>">YouTube Video ID:</label><br />
          <input type="text" class="img widefat" name="<?php echo $this->get_field_name('sticky_video'); ?>" id="<?php echo $this->get_field_id('sticky_video'); ?>" value="<?php echo $instance['sticky_video']; ?>" name="<?php echo $this->get_field_name( 'sticky_video' ); ?>" />
          <label style='margin-top:10px;' for="<?php echo $this->get_field_id('sticky_video_caption'); ?>"><?php _e( 'Caption:' ); ?></label><br />
          <input type="text" class="caption widefat" name="<?php echo $this->get_field_name('sticky_video_caption'); ?>" id="<?php echo $this->get_field_id('sticky_video_caption'); ?>" value="<?php echo $sticky_video_caption; ?>" name="<?php echo $this->get_field_name( 'sticky_video_caption' ); ?>" />
            <p style="font-style: italic">Make sure to clear this field if you decide to switch to another content type!</p>
        </div>

        <div class="adTabfield sticky-field" style="display:none">
        <h3>DFP 300x250 ad</h3>
        <p>Check the box below to add a 300x250 ad from DFP that will 'stick' as the reader scrolls. If applicable, you can pass an ad tag using the field below. Note that the same tag must be used for all ads on a site, so if you change this here, it will change for all of the ads. The field is optional though — ads will serve if it is blank.</p> 
        <p>
        <input class="checkbox" type="checkbox" <?php checked( $instance[ 'ad_check' ], 'on' ); ?> id="<?php echo $this->get_field_id( 'ad_check' ); ?>" name="<?php echo $this->get_field_name( 'ad_check' ); ?>" /> 
        <label for="<?php echo $this->get_field_id( 'ad_check' ); ?>">Check this to confirm placement of an ad.</label>
        </p>
        <p>

        </div>

        <div class="quoteTabfield sticky-field" style="display:none">
            <p>
            <h3>Pull quote</h3>
            <p>This creates a styled pull quote that will 'stick' as the reader scrolls. It includes a large quote mark on the left side, so you don't need to include that in the copy. This also adds two share links after the quote, one for Facebook and Twitter. The Twitter share link creates a tweet that includes the pull quote text and a link to your site.</p>
              <label for="<?php echo $this->get_field_id('sticky_quote'); ?>">Pull quote text:</label><br />
              <input type="text" class="widefat" name="<?php echo $this->get_field_name('sticky_quote'); ?>" id="<?php echo $this->get_field_id('sticky_quote'); ?>" value="<?php echo $instance['sticky_quote']; ?>" name="<?php echo $this->get_field_name( 'sticky_quote' ); ?>" />
              <label for="<?php echo $this->get_field_id('sticky_quote_attrib'); ?>">Pull quote attribution:</label><br />
              <input type="text" class="widefat" name="<?php echo $this->get_field_name('sticky_quote_attrib'); ?>" id="<?php echo $this->get_field_id('sticky_quote_attrib'); ?>" value="<?php echo $instance['sticky_quote_attrib']; ?>" name="<?php echo $this->get_field_name( 'sticky_quote_attrib' ); ?>" />
            <p style="font-style: italic">Make sure to clear this field if you decide to switch to another content type!</p>
            </p>
        </div>

        <div class="subscribeTabfield sticky-field" style="display:none">
            <p>
            <h3>Subscribe button</h3>
            <p>This creates a button to direct readers to your subscription site. It also creates a space for you to put a 'call to action' or some text encouraging readers to click through to the subscribe link.</p>
              <label for="<?php echo $this->get_field_id('sticky_subscribe_link'); ?>">Link to subscription site:</label><br />
              <input type="text" class="widefat" name="<?php echo $this->get_field_name('sticky_subscribe_link'); ?>" id="<?php echo $this->get_field_id('sticky_subscribe_link'); ?>" value="<?php echo $instance['sticky_subscribe_link']; ?>" name="<?php echo $this->get_field_name( 'sticky_subscribe_link' ); ?>" />
              <label style='margin-top:10px;' for="<?php echo $this->get_field_id('sticky_subscribe_text'); ?>">Text to include before subscribe button:</label><br />
              <input type="text" class="widefat" name="<?php echo $this->get_field_name('sticky_subscribe_text'); ?>" id="<?php echo $this->get_field_id('sticky_subscribe_text'); ?>" value="<?php echo $sticky_subscribe_text; ?>" name="<?php echo $this->get_field_name( 'sticky_subscribe_text' ); ?>" />
            <p style="font-style: italic">Make sure to clear this field if you decide to switch to another content type!</p>
            </p>
        </div>

        <div class="htmlTabfield sticky-field" style="display:none">
            <h3>Embed or Custom HTML</h3>
            <p>In this widget, you can paste or write custom HTML that will display as a sticky sidebar wherever you place it. This tool is helpful for Google Maps, Omny embeds, Infogram, or any other HTML object not found in the template.</p>
            <p>
              <label for="<?php echo $this->get_field_id('sticky_custom_html'); ?>">Custom HTML:</label><br />
              <textarea type="text" class="widefat" style="font-family:monospace;height:300px" name="<?php echo $this->get_field_name('sticky_custom_html'); ?>" id="<?php echo $this->get_field_id('sticky_custom_html'); ?>" name="<?php echo $this->get_field_name( 'sticky_custom_html' ); ?>"><?php echo esc_html__($instance['sticky_custom_html']); ?></textarea>
            </p>
            <p style="font-style: italic">Make sure to clear this field if you decide to switch to another content type!</p>
        </div>

        <div class="placeholderTabfield sticky-field" style="display:none">
            <h3>Placeholder</h3>
            <p>If you want to have a text section without a sidebar visual, click the checkbox below and an "empty" sidebar will be created.</p>
            <p>
            <input class="checkbox" type="checkbox" <?php checked( $instance[ 'placeholder_check' ], 'on' ); ?> id="<?php echo $this->get_field_id( 'placeholder_check' ); ?>" name="<?php echo $this->get_field_name( 'placeholder_check' ); ?>" /> 
            <label for="<?php echo $this->get_field_id( 'placeholder_check' ); ?>">Check this to create a placeholder space in the sidebar.</label>
            </p>
        </div>

        <?php 
    }

    /**
     * Sanitize widget form values as they are saved.
     *
     * @see WP_Widget::update()
     *
     * @param array $new_instance Values just sent to be saved.
     * @param array $old_instance Previously saved values from database.
     *
     * @return array Updated safe values to be saved.
     */
    public function update( $new_instance, $old_instance ) {
        $instance = array();
        $instance['sticky_image_url'] = ( ! empty( $new_instance['sticky_image_url'] ) ) ? $new_instance['sticky_image_url'] : '';
        $instance['sticky_image_caption'] = ( ! empty( $new_instance['sticky_image_caption'] ) ) ? $new_instance['sticky_image_caption'] : '';
        $instance['sticky_image_link'] = ( ! empty( $new_instance['sticky_image_link'] ) ) ? $new_instance['sticky_image_link'] : '';
        $instance['sticky_video'] = ( ! empty( $new_instance['sticky_video'] ) ) ? $new_instance['sticky_video'] : '';
        $instance['sticky_video_caption'] = ( ! empty( $new_instance['sticky_video_caption'] ) ) ? $new_instance['sticky_video_caption'] : '';
        $instance['sticky_quote'] = ( ! empty( $new_instance['sticky_quote'] ) ) ? $new_instance['sticky_quote'] : '';
        $instance['sticky_quote_attrib'] = ( ! empty( $new_instance['sticky_quote_attrib'] ) ) ? $new_instance['sticky_quote_attrib'] : '';
        $instance['sticky_subscribe_link'] = ( ! empty( $new_instance['sticky_subscribe_link'] ) ) ? $new_instance['sticky_subscribe_link'] : '';
        $instance['sticky_subscribe_text'] = ( ! empty( $new_instance['sticky_subscribe_text'] ) ) ? $new_instance['sticky_subscribe_text'] : '';
        $instance['sticky_custom_html'] = ( ! empty( $new_instance['sticky_custom_html'] ) ) ? $new_instance['sticky_custom_html'] : '';
        $instance['placeholder_check'] = ( ! empty( $new_instance['placeholder_check'] ) ) ? $new_instance['placeholder_check'] : '';
        $instance['ad_check'] = ( ! empty( $new_instance['ad_check'] ) ) ? $new_instance['ad_check'] : '';

        return $instance;
    }

} // class Architect_Sticky_Side_Widget

class Architect_Full_Width_Widget extends WP_Widget {

	/**
	 * Register widget with WordPress.
	 */
	function __construct() {
		parent::__construct(
			'architect_full_width_widget', // Base ID
			esc_html__( 'Architect | Full-Width Image', 'text_domain' ), // Name
            array( 'description' => esc_html__( 'Full-width image for use in stories. This breaks the split-screen and does not stick.', 'text_domain' ), 'classname' => 'architect_full_width_widget', 'panels_groups' => array('architect_theme') ), // Args
            add_action('admin_enqueue_scripts', array($this, 'scripts'))
		);
    }
    
    public function scripts() {
       wp_enqueue_script( 'media-upload' );
       wp_enqueue_media();
       wp_enqueue_script('ds_image', get_template_directory_uri() . '/js/ghpImage.js', array('jquery'), '1.0', true);
    }

	/**
	 * Front-end display of widget.
	 *
	 * @see WP_Widget::widget()
	 *
	 * @param array $args     Widget arguments.
	 * @param array $instance Saved values from database.
	 */
	public function widget( $args, $instance ) {
		if ( ! empty( $instance['full_width_image'] ) ) {
            ?>
            <div class="full-width-image">
                <img src="<? echo $instance['full_width_image']; ?>"></img>
            <div class="image-caption image-caption-hero"><? echo $instance['full_width_image_caption']; ?></div>
        	</div>
            <?
		}
	}

	/**
	 * Back-end widget form.
	 *
	 * @see WP_Widget::form()
	 *
	 * @param array $instance Previously saved values from database.
	 */
	public function form( $instance ) {
        $full_width_image = ! empty( $instance['full_width_image'] ) ? $instance['full_width_image'] : esc_html__( 'Image URL', 'text_domain' );
        $full_width_image_caption = ! empty( $instance['full_width_image_caption'] ) ? $instance['full_width_image_caption'] : esc_html__( 'Image caption', 'text_domain' );
		?>
        <p>This creates an image and caption that fill the entire width of the browser window. Make sure that the image you select is a high enough resolution to look crisp in the space.</p>
        <p>
          <label for="<?php echo $this->get_field_id('full_width_image'); ?>">Image:</label><br />
          <input type="text" class="img widefat" name="<?php echo $this->get_field_name('full_width_image'); ?>" id="<?php echo $this->get_field_id('full_width_image'); ?>" value="<?php echo $instance['full_width_image']; ?>" name="<?php echo $this->get_field_name( 'full_width_image' ); ?>" />
          <label style='margin-top:10px;' for="<?php echo $this->get_field_id('full_width_image_caption'); ?>"><?php _e( 'Caption:' ); ?></label><br />
          <input type="text" class="caption widefat" name="<?php echo $this->get_field_name('full_width_image_caption'); ?>" id="<?php echo $this->get_field_id('full_width_image_caption'); ?>" value="<?php echo $full_width_image_caption; ?>" name="<?php echo $this->get_field_name( 'full_width_image_caption' ); ?>" />
          <input style='margin-top:10px' type="button" class="select-img upload_image_button button button-primary" value="Select Image" />
        </p>
		<?php 
	}

	/**
	 * Sanitize widget form values as they are saved.
	 *
	 * @see WP_Widget::update()
	 *
	 * @param array $new_instance Values just sent to be saved.
	 * @param array $old_instance Previously saved values from database.
	 *
	 * @return array Updated safe values to be saved.
	 */
	public function update( $new_instance, $old_instance ) {
		$instance = array();
        $instance['full_width_image'] = ( ! empty( $new_instance['full_width_image'] ) ) ? $new_instance['full_width_image'] : '';
        $instance['full_width_image_caption'] = ( ! empty( $new_instance['full_width_image_caption'] ) ) ? $new_instance['full_width_image_caption'] : '';

		return $instance;
	}

} // class Despace_Full_Width_Widget

class Architect_Full_Width_Video_Widget extends WP_Widget {

    /**
     * Register widget with WordPress.
     */
    function __construct() {
        parent::__construct(
            'architect_full_width_video_widget', // Base ID
            esc_html__( 'Architect | Full-Width Video', 'text_domain' ), // Name
            array( 'description' => esc_html__( 'Elegant, full-width YouTube embed. Requires video ID with optional caption.', 'text_domain' ), 'classname' => 'architect_full_width_video_widget', 'panels_groups' => array('architect_theme') ), // Args
            add_action('admin_enqueue_scripts', array($this, 'scripts'))
        );
    }
    
    public function scripts() {
    }

    /**
     * Front-end display of widget.
     *
     * @see WP_Widget::widget()
     *
     * @param array $args     Widget arguments.
     * @param array $instance Saved values from database.
     */
    public function widget( $args, $instance ) {
        if ( ! empty( $instance['full_width_video'] ) ) {
            ?>
            <div class='embed-container'><iframe src="https://www.youtube.com/embed/<? echo $instance['full_width_video'] . '?rel=0&amp;controls=0&amp;showinfo=0'; ?>" frameborder="0" allowfullscreen></iframe></div>
            <div class="image-caption image-caption-hero"><? echo $instance['full_width_video_caption']; ?></div>
            <?
        }
    }

    /**
     * Back-end widget form.
     *
     * @see WP_Widget::form()
     *
     * @param array $instance Previously saved values from database.
     */
    public function form( $instance ) {
        $full_width_video = ! empty( $instance['full_width_video'] ) ? $instance['full_width_video'] : esc_html__( '', 'text_domain' );
        $full_width_video_caption = ! empty( $instance['full_width_video_caption'] ) ? $instance['full_width_video_caption'] : esc_html__( '', 'text_domain' );
        ?>
        <p>Similar to the full-width image, but this widget expects a YouTube ID and presents a full-width video with a caption.</p>
        <p>
          <label for="<?php echo $this->get_field_id('full_width_video'); ?>">YouTube video ID:</label><br />
          <input type="text" class="img widefat" name="<?php echo $this->get_field_name('full_width_video'); ?>" id="<?php echo $this->get_field_id('full_width_video'); ?>" value="<?php echo $instance['full_width_video']; ?>" name="<?php echo $this->get_field_name( 'full_width_video' ); ?>" />
          <label style='margin-top:10px;' for="<?php echo $this->get_field_id('full_width_video_caption'); ?>"><?php _e( 'Video caption (optional):' ); ?></label><br />
          <input type="text" class="caption widefat" name="<?php echo $this->get_field_name('full_width_video_caption'); ?>" id="<?php echo $this->get_field_id('full_width_video_caption'); ?>" value="<?php echo $full_width_video_caption; ?>" name="<?php echo $this->get_field_name( 'full_width_video_caption' ); ?>" />
        </p>
        <?php 
    }

    /**
     * Sanitize widget form values as they are saved.
     *
     * @see WP_Widget::update()
     *
     * @param array $new_instance Values just sent to be saved.
     * @param array $old_instance Previously saved values from database.
     *
     * @return array Updated safe values to be saved.
     */
    public function update( $new_instance, $old_instance ) {
        $instance = array();
        $instance['full_width_video'] = ( ! empty( $new_instance['full_width_video'] ) ) ? $new_instance['full_width_video'] : '';
        $instance['full_width_video_caption'] = ( ! empty( $new_instance['full_width_video_caption'] ) ) ? $new_instance['full_width_video_caption'] : '';

        return $instance;
    }

} // class Despace_Full_Width_Video


class Architect_Full_Width_Text_Widget extends WP_Widget {

    /**
     * Register widget with WordPress.
     */
    function __construct() {
        parent::__construct(
            'architect_full_width_text_widget', // Base ID
            esc_html__( 'Architect | Full-Width Text', 'text_domain' ), // Name
            array( 'description' => esc_html__( 'Text widget that spans both columns — good for introductions', 'text_domain' ), 'classname' => 'architect_full_width_text_widget', 'panels_groups' => array('architect_theme') ), // Args
            add_action('admin_enqueue_scripts', array($this, 'scripts'))
        );
    }
    
    public function scripts() {
    }

    /**
     * Front-end display of widget.
     *
     * @see WP_Widget::widget()
     *
     * @param array $args     Widget arguments.
     * @param array $instance Saved values from database.
     */
    public function widget( $args, $instance ) {
        if ( ! empty( $instance['full_width_headline'] ) ) {
            ?>
            <div class='full-width-text'>
                <h1><? echo $instance['full_width_headline'];?></h1>
                <div class="project-leadin"><? echo $instance['full_width_leadin']?></div>
                <div class="body-byline"><p><? echo $instance['full_width_byline']?></p></div>
                <p><? echo $instance['full_width_text'];?></p>
            </div>
            <?
        } else {
            ?>
            <div class='full-width-text'>
                <div class="project-leadin"><? echo $instance['full_width_leadin']?></div>
                <div class="body-byline"><p><? echo $instance['full_width_byline']?></p></div>
                <p><? echo $instance['full_width_text'];?></p>
            </div>
            <?
        }
    }

    /**
     * Back-end widget form.
     *
     * @see WP_Widget::form()
     *
     * @param array $instance Previously saved values from database.
     */
    public function form( $instance ) {
        $full_width_text = esc_attr($instance['full_width_text']);
        $full_width_headline = ! empty( $instance['full_width_headline'] ) ? $instance['full_width_headline'] : esc_html__( '', 'text_domain' );
        $full_width_byline = ! empty( $instance['full_width_byline'] ) ? $instance['full_width_byline'] : esc_html__( '', 'text_domain' );
        $full_width_leadin = ! empty( $instance['full_width_leadin'] ) ? $instance['full_width_leadin'] : esc_html__( '', 'text_domain' );
        ?>
        <p>This creates a full-width text box with space for a headline, leadin and byline. It does not place the text into a single column like the regular text widget.</p>
        <p>
          <label for="<?php echo $this->get_field_id('full_width_headline'); ?>">Headline:</label><br />
          <input type="text" class="img widefat" name="<?php echo $this->get_field_name('full_width_headline'); ?>" id="<?php echo $this->get_field_id('full_width_headline'); ?>" value="<?php echo $instance['full_width_headline']; ?>" name="<?php echo $this->get_field_name( 'full_width_headline' ); ?>" />
       </p>
        <p>
          <label for="<?php echo $this->get_field_id('full_width_leadin'); ?>">Lead-in:</label><br />
          <input type="text" class="img widefat" name="<?php echo $this->get_field_name('full_width_leadin'); ?>" id="<?php echo $this->get_field_id('full_width_leadin'); ?>" value="<?php echo $instance['full_width_leadin']; ?>" name="<?php echo $this->get_field_name( 'full_width_leadin' ); ?>" />
       </p>
        <p>
          <label for="<?php echo $this->get_field_id('full_width_byline'); ?>">Byline:</label><br />
          <input type="text" class="img widefat" name="<?php echo $this->get_field_name('full_width_byline'); ?>" id="<?php echo $this->get_field_id('full_width_byline'); ?>" value="<?php echo $instance['full_width_byline']; ?>" name="<?php echo $this->get_field_name( 'full_width_byline' ); ?>" />
       </p>
        <div><label for="<?php echo $this->get_field_id('full_width_text'); ?>"><?php _e('Full-width/intro copy here'); ?> <textarea class="widefat" type="text" value="" name="<?php echo $this->get_field_name('full_width_text'); ?>" id="<?php echo $this->get_field_id('full_width_text'); ?>"><?php echo $full_width_text?></textarea></label></div>

        <script type="text/javascript">
            if (window.tinyMCE) {
                jQuery(document).ready(function(){
                    //set up editor in the textarea of the custom plugin
                    tinyMCE.init({
                        resize: 'vertical',
                        height : '300',
                        selector: '#<?php echo $this->get_field_id('full_width_text'); ?>',
                        plugins: 'link paste', 
                        image_caption: true,
                        image_description: false,
                        image_dimensions: false,
                        image_title: false,
                        toolbar: 'undo redo | removeformat | italic | link',
                        menu: {},
                        relative_urls : 0,
                        file_browser_callback: function(field_name, url, type, win) {

                            jQuery('#mce-modal-block').hide();
                            jQuery('.mce-container.mce-floatpanel').hide();

                            var $input = jQuery('#'+field_name);

                            file_frame.on('close', function () {
                                jQuery('#mce-modal-block').show();
                                jQuery('.mce-container.mce-floatpanel').show();
                            });

                            // Finally, open the modal
                            file_frame.open();

                        }
                    });
                });

                //click done btn to save contents of editor back to the db
                jQuery( ".button-primary.so-close" ).click(function() {
                    var richTextContent = tinymce.activeEditor.getContent();
                    document.getElementById("<?php echo $this->get_field_id('full_width_text'); ?>").value = richTextContent;
                });
            }
        </script>
        <?php 
    }

    /**
     * Sanitize widget form values as they are saved.
     *
     * @see WP_Widget::update()
     *
     * @param array $new_instance Values just sent to be saved.
     * @param array $old_instance Previously saved values from database.
     *
     * @return array Updated safe values to be saved.
     */
    public function update( $new_instance, $old_instance ) {
        $instance = $old_instance;
        $instance['full_width_headline'] = $new_instance['full_width_headline'];
        $instance['full_width_byline'] = $new_instance['full_width_byline'];
        $instance['full_width_text'] = $new_instance['full_width_text'];
        $instance['full_width_leadin'] = $new_instance['full_width_leadin'];

        return $instance;
    }

} // class Despace_Full_Width_Video

function register_architect_widgets() {
    register_widget( 'Architect_Hero_Widget' );
    register_widget( 'Architect_Sticky_Side_Widget' );
    register_widget( 'Architect_Text_Widget');
    register_widget( 'Architect_Full_Width_Widget');
    register_widget( 'Architect_DFP_Leaderboard_Ad');
    register_widget( 'Architect_Full_Width_Video_Widget');
    register_widget( 'Architect_Full_Width_Text_Widget');
    register_widget( 'Architect_DFP_Leaderboard_Secondary');
}
add_action( 'widgets_init', 'register_architect_widgets');
