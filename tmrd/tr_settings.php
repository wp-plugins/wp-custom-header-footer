<?php 


/****************************************************************

* Enqueue Script
***********************************************************************/

// enqueue needed assets (for tinymce actualy)
function tr_options_page_enqueue() {
    wp_enqueue_script('common');
    wp_enqueue_script('jquery-color');
    wp_print_scripts('editor');
    if (function_exists('add_thickbox')) add_thickbox();
    wp_print_scripts('media-upload');
    if (function_exists('wp_editor()')) wp_editor();
    wp_admin_css();
    wp_enqueue_script('utils');
    do_action("admin_print_styles-post-php");
    do_action('admin_print_styles');

    // handling upload_button for logo
    ?>
    <script type="text/javascript">
    jQuery(document).ready(function($) {
        var upload_field, upload_preview;
        if ($('.upload_button').length) {
            $('.upload_button').live('click', function(e) {
                upload_field = $(this).closest('td').find('input.upload_field:first');
                upload_preview = $(this).closest('td').find('img.upload_preview:first');
                window.send_to_editor=window.send_to_editor_clone;
                tb_show('','media-upload.php?TB_iframe=true');
                return false;
            });
            window.original_send_to_editor = window.send_to_editor;
            window.send_to_editor_clone = function(html){
                file_url = jQuery('img',html).attr('src');
                if (!file_url) { file_url = jQuery(html).attr('href'); }
                tb_remove();
                upload_field.val(file_url);
                upload_preview.attr('src', file_url);
            }
        }

        $('.upload_clear').live('click', function(e) {
            $(this).closest('td').find('input.upload_field:first').val('');
            $(this).closest('td').find('img.upload_preview:first').hide();
            return false;
        });
    });
    </script>
    <?php
}





add_action( 'admin_enqueue_scripts', 'tmrd_add_color_picker' );
function tmrd_add_color_picker( $hook ) {
 
    if( is_admin() ) { 
     
        // Add the color picker css file       
        wp_enqueue_style( 'wp-color-picker' ); 
         
        // Include our custom jQuery file with WordPress Color Picker dependency
        wp_enqueue_script( 'custom-script-handle', plugins_url( 'color-picker/custom-script.js', __FILE__ ), array( 'wp-color-picker' ), false, true ); 
    }
}





/*
****************************************************************
*
* Default Value
***********************************************************************/

//Default theme options Value
function tr_default_option_value() {
    $options = array(
        'text_ex' => 'TR Options Text Box Demo',
        'tynemce_ex' => 'TR Options TyneMce Demo',
        'copyright' => 'All rights reserverd.',
        'logo_demo' => '',
    );
    return $options;
}


/*
****************************************************************
*
* Helper Function to Get Value
***********************************************************************/



function get_tmrd_option($name) {
    $options = get_option('tr_theme_options', tr_default_option_value());

    return $options[$name];
}
function tmrd_option($name) {
    echo get_tmrd_option($name);
}




/*
****************************************************************
*
*Add Menu Settings Page
***********************************************************************/


function tmrd_menu_options() {
    // page title, menu title, access rules, url slug, render callback function
    $page = add_menu_page('TR Options', 'Header Footer', 'edit_theme_options', 'demo_options', 'tr_theme_options_callback');
    add_action('admin_print_scripts-' . $page, 'tr_options_page_enqueue');
}
add_action('admin_menu', 'tmrd_menu_options');


/*
****************************************************************
*
* Register Settings
***********************************************************************/

function tr_settings_api_init() {
    // retrieve settings, if settings not set, save options
    if(false === get_option('tr_theme_options', tr_default_option_value()))
        add_option('tr_theme_options', tr_default_option_value());

    //group name (can be any, see settings_fields() call in tr_theme_options_render_page()), option name (look at add_option, get_option), validate function callback
    register_setting('tr_options', 'tr_theme_options', 'tr_theme_options_validate');

    // id, title, render callback function, url slug
    add_settings_section('general', '', '__return_false', 'demo_options');
    // $options[KEY], label, render callback function, url slug, settings_section id

    add_settings_field('textarea_demo', 'Insert Css in Header', 'tr_settings_field_demo_textarea', 'demo_options', 'general');
    add_settings_field('header_js', 'Insert js in Header', 'tr_settings_field_header_js', 'demo_options', 'general');
    add_settings_field('footer_js', 'Insert js in Footer', 'tr_settings_field_footer_js', 'demo_options', 'general');

    
    

   
   
    
}
add_action('admin_init', 'tr_settings_api_init');




/*
****************************************************************
*
*Render Demo  Field
***********************************************************************/
 




function tr_settings_field_demo_textarea() { $options = get_option('tr_theme_options', tr_default_option_value()); ?>
		<textarea cols='40' rows='10' name='tr_theme_options[textarea_demo]'> 
		<?php echo $options['textarea_demo']; ?>
 		</textarea>
<?php }

function tr_settings_field_header_js() { $options = get_option('tr_theme_options', tr_default_option_value()); ?>
        <textarea cols='40' rows='10' name='tr_theme_options[header_js]'> 
        <?php echo $options['header_js']; ?>
        </textarea>
<?php }
function tr_settings_field_footer_js() { $options = get_option('tr_theme_options', tr_default_option_value()); ?>
        <textarea cols='40' rows='10' name='tr_theme_options[footer_js]'> 
        <?php echo $options['footer_js']; ?>
        </textarea>
<?php }






/*
****************************************************************
*
*validation callbackd
***********************************************************************/


function tr_theme_options_validate($input) {
    $output = $defaults = tr_default_option_value();


    $output['textarea_demo'] = empty($input['textarea_demo']) ? $defaults['textarea_demo'] : $input['textarea_demo'];
    $output['header_js'] = empty($input['header_js']) ? $defaults['header_js'] : $input['header_js'];
    $output['footer_js'] = empty($input['footer_js']) ? $defaults['footer_js'] : $input['footer_js'];



    return $output;
}

// render page callback
function tr_theme_options_callback() { ?>
    <div class="wrap">
        <?php screen_icon(); ?>
        <h2>TR options</h2>
        <?php settings_errors(); ?>

        <form method="post" action="options.php">
            <?php
                settings_fields('tr_options');
                do_settings_sections('demo_options');
                submit_button();
        
            ?>
        </form>
    </div>
<?php }




