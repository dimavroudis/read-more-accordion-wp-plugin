<?php
/*
Plugin Name: Read More Accordion Widget
Description: A simple widget to create accorrdion style "Read More"
Version: 1.0
Author: Dimitris Mavroudis
Author URI: http://dimitrismavroudis.gr
License: GPLv2 or later
*/

class read_more_accordion extends WP_Widget {

	// constructor
    function __construct() {
		parent::__construct(
			'read_more_accordion', // Base ID
			esc_html__( 'Read More Accordion', 'read_more_accordion' ), // Name
			array( 'description' => esc_html__( 'A simple widget to create accorrdion style "Read More"', 'read_more_accordion' ), ) // Args
		);
	}

	// widget form creation
	function form($instance) {	
            if( $instance) {
                $above_fold = esc_textarea($instance['above_fold']);
                $below_fold = esc_textarea($instance['below_fold']);
                $read_more_text = esc_attr($instance['read_more_text']);
                $read_less_text = esc_attr($instance['read_less_text']);
            } else {
                $above_fold = '';
                $below_fold = '';
                $read_more_text = __('Read More', 'read-more-accordion');
                $read_less_text = __('Read Less', 'read-more-accordion');
            } ?>

            <p>
                <label for="<?php echo $this->get_field_id('above_fold'); ?>"><?php _e('Above Fold (basic HTML allowed):', 'read_more_accordion'); ?></label>
                <textarea class="widefat" id="<?php echo $this->get_field_id('above_fold'); ?>" name="<?php echo $this->get_field_name('above_fold'); ?>"><?php echo $above_fold; ?></textarea>
            </p>

            <p>
                <label for="<?php echo $this->get_field_id('below_fold'); ?>"><?php _e('Below Fold (basic HTML allowed):', 'read_more_accordion'); ?></label>
                <textarea class="widefat" id="<?php echo $this->get_field_id('below_fold'); ?>" name="<?php echo $this->get_field_name('below_fold'); ?>"><?php echo $below_fold; ?></textarea>
            </p> 
            <p>
                <label for="<?php echo $this->get_field_id('read_more_text'); ?>"><?php _e('"Read More" Text', 'read_more_accordion'); ?></label>
                <input class="widefat" id="<?php echo $this->get_field_id('read_more_text'); ?>" name="<?php echo $this->get_field_name('read_more_text'); ?>" type="text" value="<?php echo $read_more_text; ?>" />
            </p>           
            <p>
                <label for="<?php echo $this->get_field_id('read_less_text'); ?>"><?php _e('"Read Less" Text', 'read_more_accordion'); ?></label>
                <input class="widefat" id="<?php echo $this->get_field_id('read_less_text'); ?>" name="<?php echo $this->get_field_name('read_less_text'); ?>" type="text" value="<?php echo $read_less_text; ?>" />
            </p><?php
	}

	// widget update
	function update($new_instance, $old_instance) {
		$instance = $old_instance;
        // Fields
        $instance['above_fold'] = strip_tags($new_instance['above_fold'], '<p><span><a><b><i><img><br>');
        $instance['below_fold'] = strip_tags($new_instance['below_fold'], '<p><span><a><b><i><img><br>');
        $instance['read_more_text'] = strip_tags($new_instance['read_more_text']);
        $instance['read_less_text'] = strip_tags($new_instance['read_less_text']);
        return $instance;
	}

	// widget display
	function widget($args, $instance) {
        extract( $args );
        // these are the widget options
        $above_fold = $instance['above_fold'];
        $below_fold = $instance['below_fold'];
        $read_more_text = $instance['read_more_text'];
        $read_less_text = $instance['read_less_text'];
        echo $before_widget;
		read_more_accordion_front($above_fold, $below_fold,  $read_more_text,$read_less_text);
        echo $after_widget;
	}
}

if (! function_exists('enqueue_read_more_accordion_css')) {
    function enqueue_read_more_accordion_css() {
        wp_enqueue_style( 'read-more-accordion-css', plugins_url( 'style.css', __FILE__ ) );
    }
    add_action( 'wp_enqueue_scripts', 'enqueue_read_more_accordion_css' );
}

if (! function_exists('enqueue_read_more_accordion_js')) {
    function enqueue_read_more_accordion_js() {
        wp_enqueue_script('read-more-accordion-js', plugins_url('read-more-accordion.js', __FILE__), array('jquery'), '', true);
    }
    add_action( 'wp_enqueue_scripts', 'enqueue_read_more_accordion_js' );
}

// register read_more_accordion widget
function register_read_more_accordion() {
    register_widget( 'read_more_accordion' );
}
add_action( 'widgets_init', 'register_read_more_accordion' );

function read_more_shortcode( $atts ) {
	$attr = shortcode_atts( array(
		'above_fold' => '',
		'below_fold' => '',
		'read_more' => __('Read More', 'read-more-accordion'),
		'read_less' => __('Read Less', 'read-more-accordion'),
	), $atts );

	return read_more_accordion_front($attr['above_fold'], $attr['below_fold'], $attr['read_more'], $attr['read_less']);
}
add_shortcode( 'read_more', 'read_more_shortcode' );


function read_more_accordion_front( $above_fold, $below_fold, $read_more_text, $read_less_text){
	$html = '<div id="above_fold" class="above-fold-panel">' .  $above_fold . '</div> <div class="accordion"><div class="read-more-line"></div> <div class="read-more-text">' . $read_more_text .
			'</div><div class="read-less-text">' . $read_less_text . '</div><div class="read-more-line"></div></div><div id="below_fold" class="below-fold-panel">' . $below_fold . '</div>';
	return $html;
}
?>