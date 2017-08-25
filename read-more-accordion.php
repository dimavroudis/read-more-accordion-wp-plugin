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
                $title = esc_attr($instance['title']);
                $above_fold = esc_textarea($instance['above_fold']);
                $below_fold = esc_textarea($instance['below_fold']);
                $read_more_text = esc_attr($instance['read_more_text']);
                $read_less_text = esc_attr($instance['read_less_text']);
            } else {
                $title = '';
                $above_fold = '';
                $below_fold = '';
                $read_more_text = 'Read More';
                $read_less_text = 'Read Less';
            } ?>

            <p>
                <label for="<?php echo $this->get_field_id('title'); ?>"><?php _e('Widget Title', 'read_more_accordion'); ?></label>
                <input class="widefat" id="<?php echo $this->get_field_id('title'); ?>" name="<?php echo $this->get_field_name('title'); ?>" type="text" value="<?php echo $title; ?>" />
            </p>

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
        $instance['title'] = strip_tags($new_instance['title']);
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
        $title = apply_filters('widget_title', $instance['title']);
        $text = $instance['text'];
        $above_fold = $instance['above_fold'];
        $below_fold = $instance['below_fold'];
        $read_more_text = $instance['read_more_text'];
        $read_less_text = $instance['read_less_text'];
        echo $before_widget; ?>
            <div id="above_fold" class="above-fold-panel">
              <?php echo $above_fold ?>
            </div>
            <div class="accordion">
                <div class="read-more-line"></div>
                <div class="read-more-text"><?php echo $read_more_text ?></div>
                <div class="read-less-text"><?php echo $read_less_text ?></div>
                <div class="read-more-line"></div>
            </div>
            <div id="below_fold" class="below-fold-panel">
              <?php echo $below_fold ?>
            </div><?php
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

?>