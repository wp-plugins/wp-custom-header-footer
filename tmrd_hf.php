<?php 


/**
 * Plugin Name: WP Custom Header Footer
 * Plugin URI: http://nakshighor.com/plugins/
 * Description: WP Custom header Footer plugin allows you to easily add cusom css or js files in your sites  by using this plugin easily.So, no need to editing your theme files to add custom js or css files. So, enjoy easy site maintaing and always keep with us using our plugin and don't forget to rate us.
 
 * Version:  1.0.0
 * Author: Theme Road
 * Author URI: http://nakshighor.com/plugins/
 * License:  GPL2
 *Text Domain: tmrd
 *  Copyright 2015 GIN_AUTHOR_NAME  (email : BestThemeRoad@gmail.com)
 *
 *	This program is free software; you can redistribute it and/or modify
 *	it under the terms of the GNU General Public License, version 2, as
 *	published by the Free Software Foundation.
 *
 *	This program is distributed in the hope that it will be useful,
 *	but WITHOUT ANY WARRANTY; without even the implied warranty of
 *	MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
 *	GNU General Public License for more details.
 *
 *	You should have received a copy of the GNU General Public License
 *	along with this program; if not, write to the Free Software
 *	Foundation, Inc., 51 Franklin St, Fifth Floor, Boston, MA  02110-1301  USA
 *
 */






require_once( 'tmrd/tr_settings.php' );







function tmrd_css_header(){

	 $options = get_option('tr_theme_options', tr_default_option_value());

?>

<style type="text/css">
	
	<?php echo $options['textarea_demo'];?>
</style>


<?php

}
add_action('wp_head','tmrd_css_header');


function tmrd_js_header(){

 $options = get_option('tr_theme_options', tr_default_option_value());

?>

<script type="text/javascript">
	
	<?php echo $options['header_js'];?>
</script>


<?php

}
add_action('wp_head','tmrd_js_header');


function tmrd_js_footer(){

 $options = get_option('tr_theme_options', tr_default_option_value());

?>

<script type="text/javascript">
	
	<?php echo $options['footer_js'];?>
</script>


<?php

}
add_action('wp_footer','tmrd_js_footer');




