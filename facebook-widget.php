<?php
/*
 * Plugin name: Wiaw Facebook Media Plugin Widget
 * Plugin URI: http://website-in-a-weekend.net/
 * Description: Demonstrating how to add a WordPress widget with a plugin.
 * Version: 0.1
 * Author: Dave Doolin
 * Author URI: http://website-in-a-weekend.net/
 */

$images = WP_PLUGIN_URL.'/wp-facebook-widget/images/';

$sm_copy = <<<EOF
<table class="wiaw-facebook-media">
<tr>

<td class="twitter">
<a id="twitter" href="http://twitter.com/websiteweekend"><img src="$images/facebook-icons-packed.png" alt="Twitter" name="Twitter" class="facebook_twitter"</a>
</td>

<td class="facebook">
<a id="facebook" href="http://facebook.com/WebsiteInAWeekend"><img src="$images/facebook-icons-packed.png" alt="Facebook" name="Facebook" class="facebook_facebook"</a>
</td>

<td class="linkedin">
<a id="linkedin" href="http://linkedin.com/in/davidmdoolin"><img src="$images/facebook-icons-packed.png" alt="Linkedin" name="Linkedin" class="facebook_linkedin"</a>
</td>

<td class="rss">
<a id="rss" href="http://website-in-a-weekend.net/feed"><img src="$images/facebook-icons-packed.png" alt="RSS" name="RSS" class="facebook_rss"</a>
</td>


</tr>
</table>
EOF;

$css_url = WP_PLUGIN_URL.'/wp-facebook-widget/css/sm.css';
$css_file = WP_PLUGIN_DIR.'/wp-facebook-widget/css/sm.css';

if (file_exists($css_file)) {
	wp_register_style('sm_stylesheet', $css_url);
	wp_enqueue_style('sm_stylesheet');
}

if (!class_exists("sm_plugin_widget")) {

	class sm_plugin_widget extends WP_Widget {
			
		function sm_plugin_widget() {
			$widget_ops = array('classname' => 'widget_sm_links', 'description' => 'WiaW Social Media' );
			$this->WP_Widget('sm_links', 'WiaW Social Media', $widget_ops);
		}

		

		/* This is the code that gets displayed on the UI side,
		 * what readers see.
		 */
		function widget($args, $instance) {
		   global $sm_copy;
			extract($args, EXTR_SKIP);

			echo $before_widget;
			$title = empty($instance['title']) ? '&nbsp;' : apply_filters('widget_title', $instance['title']);
			$entry_title = empty($instance['entry_title']) ? '&nbsp;' : apply_filters('widget_entry_title', $instance['entry_title']);
			$comments_title = empty($instance['comments_title']) ? '&nbsp;' : apply_filters('widget_comments_title', $instance['comments_title']);

			if (!empty($title)) { 
				echo $before_title . $title . $after_title; 
			}

         echo $sm_copy;
         echo $after_widget;
		}

		function update($new_instance, $old_instance) {
			$instance = $old_instance;
			$instance['title'] = strip_tags($new_instance['title']);
			$instance['entry_title'] = strip_tags($new_instance['entry_title']);
			return $instance;
		}

		/* Back end, the interface shown in Appearance -> Widgets
		 * administration interface.
		 */
		function form($instance) {
			$instance = wp_parse_args( (array) $instance, array( 'title' => '', 'entry_title' => '', 'comments_title' => '' ) );
			$title = strip_tags($instance['title']);
			$entry_title = strip_tags($instance['entry_title']);
			?>

<p><label for="<?php echo $this->get_field_id('title'); ?>">Title: <input
	class="widefat" id="<?php echo $this->get_field_id('title'); ?>"
	name="<?php echo $this->get_field_name('title'); ?>" type="text"
	value="<?php echo attribute_escape($title); ?>" /></label></p>


<p><label for="<?php echo $this->get_field_id('entry_title'); ?>">Title
for entry feed: <input class="widefat"
	id="<?php echo $this->get_field_id('entry_title'); ?>"
	name="<?php echo $this->get_field_name('entry_title'); ?>" type="text"
	value="<?php echo attribute_escape($entry_title); ?>" /></label></p>

			<?php
		}			
	}

	function demo_widget_init() {
		register_widget('sm_plugin_widget');
	}
	add_action('widgets_init', 'demo_widget_init');

}

$wpdpd = new sm_plugin_widget();

?>
