<?php 
/**
 * Plugin Name: PluginlySpeaking Expandable Floating Div
 * Plugin URI: http://pluginlyspeaking.com/plugins/floating-div/
 * Description: Create a simple div that you can expand or collapse, floating up and down when the user is scrolling
 * Author: PluginlySpeaking
 * Version: 1.1
 * Author URI: http://www.pluginlyspeaking.com
 * License: GPL2
 */

require_once dirname( __FILE__ ) . '/class-tgm-plugin-activation.php';

add_action( 'tgmpa_register', 'exp_float_div_register_required_plugins' );

function exp_float_div_register_required_plugins() {

	$plugins = array(
		array(
			'name'      => 'CMB2',
			'slug'      => 'cmb2',
			'required'  => true,
		),
	);

	$config = array(
		'id'           => 'exp-float-div',                 // Unique ID for hashing notices for multiple instances of TGMPA.
		'default_path' => '',                      // Default absolute path to bundled plugins.
		'menu'         => 'tgmpa-install-plugins', // Menu slug.
		'capability'   => 'manage_options',    // Capability needed to view plugin install page, should be a capability associated with the parent menu used.
		'has_notices'  => true,                    // Show admin notices or not.
		'dismissable'  => false,                    // If false, a user cannot dismiss the nag message.
		'dismiss_msg'  => 'Without CMB2, Expandable Floating Div won\'t work.',                      // If 'dismissable' is false, this message will be output at top of nag.
		'is_automatic' => true,                   // Automatically activate plugins after installation or not.
		'message'      => '',                      // Message to output right before the plugins table.
	);

	tgmpa( $plugins, $config );
}

function add_exp_float_div_cmb2_ps() {
	if ( is_plugin_active( WP_PLUGIN_DIR . '/cmb2/init.php' ) ) {
		require_once WP_PLUGIN_DIR . '/cmb2/init.php';
	}
}

add_action( 'admin_init', 'add_exp_float_div_cmb2_ps' );

add_action( 'wp_enqueue_scripts', 'add_exp_float_div_script' );

function add_exp_float_div_script() {
	wp_enqueue_style( 'expfloatingdiv_css', plugins_url('css/ps_exp_floating_div.css', __FILE__));
	wp_enqueue_script( 'expfloatingdiv', plugins_url('js/floating-1.12.js', __FILE__), array( 'jquery' ));
	wp_enqueue_script("jquery");
	wp_enqueue_script("jquery-ui-core");
}


function create_exp_float_div_type() {
  register_post_type( 'exp_float_div_ps',
    array(
      'labels' => array(
        'name' => 'Expandable Floating Div',
        'singular_name' => 'Expandable Floating Div'
      ),
      'public' => true,
      'has_archive' => false,
      'hierarchical' => false,
      'supports'           => array( 'title' ),
      'menu_icon'    => 'dashicons-plus',
    )
  );
}

add_action( 'init', 'create_exp_float_div_type' );


function exp_float_div_admin_css() {
    global $post_type;
    $post_types = array( 
                        'exp_float_div_ps',
                  );
    if(in_array($post_type, $post_types))
    echo '<style type="text/css">#edit-slug-box, #post-preview, #view-post-btn{display: none;} div[class*="-disabled-"] .cmb2-metabox-description {color: #00b783;background-image: url(\''.plugins_url('img/disabled.png', __FILE__).'\');background-repeat: no-repeat;padding-left: 30px;display: block;}</style>';
}

function remove_view_link_exp_float_div( $action ) {

    unset ($action['view']);
    return $action;
}

add_filter( 'post_row_actions', 'remove_view_link_exp_float_div' );
add_action( 'admin_head-post-new.php', 'exp_float_div_admin_css' );
add_action( 'admin_head-post.php', 'exp_float_div_admin_css' );


function exp_float_div_metabox() {
	$prefix = '_exp_float_div_';
	
	$cmb_group = new_cmb2_box( array(
		'id'           => $prefix . 'metabox',
		'title'        => __( 'Expandable Floating Div', 'exp_float_div_ps' ),
		'object_types' => array( 'exp_float_div_ps' ),
	) );
	
	$cmb_group->add_field( array(
		'name' => 'Div Content',
		'desc' => 'Write the content of the div',
		'id' => $prefix . 'content',
		'type' => 'wysiwyg'
	) );
	
	$cmb_group->add_field( array(
		'name'             => 'Div Position',
		'id' => 'disabled_1',
		'desc' => 'Available in the PRO Version',
		'type'             => 'select',
		'show_option_none' => false,
		'default'          => 'none',
		'options'          => array(
			'top_right' => __( 'Top Right', 'cmb2' ),
		),
		'attributes'  => array(
			'readonly' => 'readonly',
			'disabled' => 'disabled',
		),
	) );
	
	$cmb_group->add_field( array(
		'name'             => 'Div Direction',
		'id' => 'disabled_2',
		'desc' => 'Available in the PRO Version',
		'type'             => 'radio_inline',
		'default'          => 'vertical',
		'options'          => array(
			'vertical' => __( 'Vertical', 'cmb2' ),
		),
		'attributes'  => array(
			'readonly' => 'readonly',
			'disabled' => 'disabled',
		),
	) );
	
	$cmb_group->add_field( array(
		'name' => 'Visible Div Height',
		'id' => 'disabled_3',
		'desc' => 'Available in the PRO Version',
		'default' => '175',
		'type' => 'text',
		'attributes'  => array(
			'readonly' => 'readonly',
			'disabled' => 'disabled',
		),
	) );
	
	$cmb_group->add_field( array(
		'name' => 'Visible Div Width',
		'id' => 'disabled_4',
		'desc' => 'Available in the PRO Version',
		'default' => '32',
		'type' => 'text',
		'attributes'  => array(
			'readonly' => 'readonly',
			'disabled' => 'disabled',
		),
	) );
	
	$cmb_group->add_field( array(
		'name' => 'Content Div Height',
		'id' => 'disabled_5',
		'desc' => 'Available in the PRO Version',
		'default' => '175',
		'type' => 'text',
		'attributes'  => array(
			'readonly' => 'readonly',
			'disabled' => 'disabled',
		),
	) );
	
	$cmb_group->add_field( array(
		'name' => 'Content Div Width',
		'id' => 'disabled_6',
		'desc' => 'Available in the PRO Version',
		'default' => '300',
		'type' => 'text',
		'attributes'  => array(
			'readonly' => 'readonly',
			'disabled' => 'disabled',
		),
	) );
	
	$cmb_group->add_field( array(
		'name'             => 'Arrow Style',
		'id' => 'disabled_7',
		'desc' => 'Available in the PRO Version',
		'type'             => 'radio_inline',
		'default'          => 'dark',
		'options'          => array(
			'dark' => __( 'Dark', 'cmb2' ),
		),
		'attributes'  => array(
			'readonly' => 'readonly',
			'disabled' => 'disabled',
		),
	) );
	
	$cmb_group->add_field( array(
		'name'             => 'Rounded Corners',
		'id' => 'disabled_8',
		'desc' => 'Available in the PRO Version',
		'type'             => 'select',
		'show_option_none' => false,
		'default'          => '0px',
		'options'          => array(
			'0px' => __( 'No', 'cmb2' ),
		),
		'attributes'  => array(
			'readonly' => 'readonly',
			'disabled' => 'disabled',
		),
	) );
	
	$cmb_group->add_field( array(
		'name' => 'Background Color',
		'id' => 'disabled_9',
		'desc' => 'Available in the PRO Version',
		'type'    => 'colorpicker',
		'default' => '#ffffff',
		'attributes'  => array(
			'readonly' => 'readonly',
			'disabled' => 'disabled',
		),
	) );
	
	$cmb_group->add_field( array(
		'name' => 'Border Color',
		'id' => 'disabled_10',
		'desc' => 'Available in the PRO Version',
		'type'    => 'colorpicker',
		'default' => '#ffffff',
		'attributes'  => array(
			'readonly' => 'readonly',
			'disabled' => 'disabled',
		),
	) );
}

add_action( 'cmb2_init', 'exp_float_div_metabox' );

add_action( 'manage_exp_float_div_ps_posts_custom_column' , 'exp_float_div_custom_columns', 10, 2 );

function exp_float_div_custom_columns( $column, $post_id ) {
    switch ( $column ) {
	case 'shortcode' :
		global $post;
		$pre_slug = '' ;
		$pre_slug = $post->post_title;
		$slug = sanitize_title($pre_slug);
    	$shortcode = '<span style="border: solid 3px lightgray; background:white; padding:7px; font-size:17px; line-height:40px;">[exp_float_div_ps name="'.$slug.'"]</strong>';
	    echo $shortcode; 
	    break;
    }
}

function add_exp_float_div_columns($columns) {
    return array_merge($columns, 
              array('shortcode' => __('Shortcode'),
                    ));
}
add_filter('manage_exp_float_div_ps_posts_columns' , 'add_exp_float_div_columns');

function ps_exp_float_div_get_wysiwyg_output( $meta_key, $post_id = 0 ) {
    global $wp_embed;

    $post_id = $post_id ? $post_id : get_the_id();

    $content = get_post_meta( $post_id, $meta_key, 1 );
    $content = $wp_embed->autoembed( $content );
    $content = $wp_embed->run_shortcode( $content );
    $content = do_shortcode( $content );
    $content = wpautop( $content );

    return $content;
}

function exp_float_div_shortcode($atts) {
	extract(shortcode_atts(array(
		"name" => ''
	), $atts));
		
	global $post;
    $args = array('post_type' => 'exp_float_div_ps', 'numberposts'=>-1);
    $custom_posts = get_posts($args);
	$output = '';
	foreach($custom_posts as $post) : setup_postdata($post);
	$sanitize_title = sanitize_title($post->post_title);
	if ($sanitize_title == $name)
	{
	$prefix = '_exp_float_div_';
    $div_content = get_post_meta( get_the_id(), $prefix . 'content', true );
	
	$postid = get_the_ID();
	
	$output = '';
	$output .= '<div id="exp_floatdiv_'.$postid.'" class="exp_floatdiv_container" >';
	$output .= '<div class="exp_floatdiv_header">';
	$output .= '<img id="exp_floatdiv_img_'.$postid.'" src="'.plugins_url( 'img/left-dark.png', __FILE__ ) .'"/>';
	$output .= '</div>';
	$output .= '<div class="exp_floatdiv_content">';
	$output .= ''. ps_exp_float_div_get_wysiwyg_output( $prefix . 'content', get_the_ID() )  .'';
	$output .= '</div>';
	$output .= '</div>';
	
	$output .= '<script type="text/javascript">';
	$output .= '$j=jQuery.noConflict();';
	
	$output .= '$j(".exp_floatdiv_header").click(function () {';
	$output .= '	$exp_floatdiv_header = $j(this);';
	$output .= '	$content = $exp_floatdiv_header.next();';
	$output .= '    $content.slideToggle(0, function () {';
	$output .= 'if ($content.is(":visible"))';
	$output .= '{';
	$output .= 'document.getElementById("exp_floatdiv_img_'.$postid.'").src="'.plugins_url( 'img/right-dark.png', __FILE__ ) .'";';
	$output .= '}';
	$output .= 'else';
	$output .= '{';
	$output .= 'document.getElementById("exp_floatdiv_img_'.$postid.'").src="'.plugins_url( 'img/left-dark.png', __FILE__ ) .'";';
	$output .= '}';
	$output .= '});';
	$output .= '});';
	
	$output .= 'var container = document.getElementById("exp_floatdiv_'.$postid.'");';
	$output .= 'document.body.appendChild(container); ';
	$output .= '$j(document).ready(function()';
	$output .= '{';
	$output .= '	floatingMenu.add(\'exp_floatdiv_'.$postid.'\',';  
	$output .= '		{';   

	$output .= '			targetRight: 0,';    
	$output .= '			targetTop: 100,';  

	$output .= '			snap: false'; 
	
	$output .= '		});';  
	$output .= '});';
	$output .= '</script>';
	
	}
	endforeach; wp_reset_query();
	return $output;
}
add_shortcode( 'exp_float_div_ps', 'exp_float_div_shortcode' );


	
?>