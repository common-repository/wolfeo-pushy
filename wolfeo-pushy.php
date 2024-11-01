<?php

/**
 * The plugin bootstrap file
 *
 * This file is read by WordPress to generate the plugin information in the plugin
 * admin area. This file also includes all of the dependencies used by the plugin,
 * registers the activation and deactivation functions, and defines a function
 * that starts the plugin.
 *
 * @link              https://wolfeo.me/public
 * @since             1.0.0
 * @package           Wolfeo_Pushy
 *
 * @wordpress-plugin
 * Plugin Name:       Wolfeo Pushy
 * Plugin URI:        wolfeo-pushy
 * Description:       Use Wolfeo's Pushy notifications on your Wordpress pages & posts.
 * Version:           1.1
 * Author:            Wolfeo
 * Author URI:        https://wolfeo.me/public
 * License:           GPL-2.0+
 * License URI:       http://www.gnu.org/licenses/gpl-2.0.txt
 * Text Domain:       wolfeo-pushy
 * Domain Path:       /languages
 */

// If this file is called directly, abort.
if ( ! defined( 'WPINC' ) ) {
    die;
}

/**
 * The code that runs during plugin activation.
 * This action is documented in includes/class-wolfeo-pushy-activator.php
 */
function activate_wolfeo_pushy() {
    require_once plugin_dir_path( __FILE__ ) . 'includes/class-wolfeo-pushy-activator.php';
    Wolfeo_Pushy_Activator::activate();
}

/**
 * The code that runs during plugin deactivation.
 * This action is documented in includes/class-wolfeo-pushy-deactivator.php
 */
function deactivate_wolfeo_pushy() {
    require_once plugin_dir_path( __FILE__ ) . 'includes/class-wolfeo-pushy-deactivator.php';
    Wolfeo_Pushy_Deactivator::deactivate();
}

register_activation_hook( __FILE__, 'activate_wolfeo_pushy' );
register_deactivation_hook( __FILE__, 'deactivate_wolfeo_pushy' );

/**
 * The core plugin class that is used to define internationalization,
 * admin-specific hooks, and public-facing site hooks.
 */
require plugin_dir_path( __FILE__ ) . 'includes/class-wolfeo-pushy.php';

/**
 * Begins execution of the plugin.
 *
 * Since everything within the plugin is registered via hooks,
 * then kicking off the plugin from this point in the file does
 * not affect the page life cycle.
 *
 * @since    1.0.0
 */
function run_wolfeo_pushy() {

    $plugin = new Wolfeo_Pushy();
    $plugin->run();

}
run_wolfeo_pushy();

add_action( 'admin_menu', 'wolfwp_plugin_menu' );

$api_check = get_option( 'wolf_api_id' );
if (empty($api_check)) {
    add_action( 'admin_notices', 'wolfwp_setup_api_alert' );
}

function wolfwp_plugin_menu() {
    $hook_suffix = add_options_page( 'Wolfeo Pushy Settings', 'Wolfeo Pushy', 'manage_options', 'wolfeo-pushy', 'wolfwp_pushy_options' );
    add_action( 'load-' . $hook_suffix , 'wolfwp_check_location' );
}

function wolfwp_check_location() {
    remove_action( 'admin_notices', 'wolfwp_setup_alert' );
}

function wolfwp_setup_api_alert() {
    $pushy_admin = admin_url('options-general.php?page=wolfeo-pushy'); 
    echo "<div id='notice' class='notice notice-warning fade'><p>You need to enter your API key in order to retreive your Wolfeo Pushy data and start using your notifications. Please enter a valid API key in the <a href='$pushy_admin'>settings panel</a>.</p></div>\n";
}

function wolfwp_pushy_options() {
    if (!current_user_can('manage_options'))
    {
      wp_die( __('You do not have sufficient permissions to access this page.') );
    }

    $opt_name = 'wolf_pushy_id';
    $hidden_field_name = 'wolf_pushy_hidden';
    $data_field_name = 'wolf_pushy_id';
    $opt_id_name = 'wolf_id_list';
    $api_id = 'wolf_api_id';
    $opt_val = get_option( $opt_name );
    $opt_id_val = get_option( $opt_id_name );
    $api_val = get_option( $api_id );

    if( isset($_POST[ $hidden_field_name ]) && $_POST[ $hidden_field_name ] == 'Y' && wp_verify_nonce( $_POST['wolf_nonce'], 'wolf_post' ) ) {
        $opt_val = sanitize_text_field( $_POST[ $data_field_name ] );
        $opt_id_val = sanitize_text_field( $_POST[ $opt_id_name ] );
        $api_val = sanitize_text_field( $_POST[ $api_id ] );
        
if ( 
    ! isset( $_POST['wolf_nonce'] ) 
    || ! wp_verify_nonce( $_POST['wolf_nonce'], 'wolf_post' ) 
) {

   ?><br /><div class="error"><p><strong><?php _e('Sorry, there was a validation error. Please try logging out and then logging back in to create a new session.', 'menu-test' ); ?></strong></p></div><?php
   exit;

} else {
        update_option( $opt_name, $opt_val );
        update_option( $opt_id_name, $opt_id_val );
        update_option( $api_id, $api_val );
}

?>
<div class="updated"><p><strong><?php _e('Pushy settings saved.', 'menu-test' ); ?></strong></p></div>
<?php

    }

    echo '<div class="wrap">';
    echo "<h2>" . __( 'Pushy Settings', 'menu-test' ) . "</h2>";
    
    ?>
<?php $id_list = esc_attr( (get_option( 'wolf_id_list' ) ) ); ?>
        <script>
            jQuery(function(){
                jQuery("#multiselect_page").multiselect();
                jQuery("#multiselect_post").multiselect();
            });
        </script>
<form name="form1" method="post" action="">
<?php wp_nonce_field( 'wolf_post', 'wolf_nonce' ); ?>
<input type="hidden" name="<?php echo $hidden_field_name; ?>" value="Y">
<input type="hidden" name="<?php echo $opt_id_name; ?>" id="id_list_field" value="<?php echo $id_list; ?>">
<p><?php _e("<h3>Step 1: Enter Your API Key</h3>", 'menu-test' ); ?></p>
<p class="intro">If you don't have a Wolfeo account, <a href="https://wolfeo.net" target="_blank">click here</a> to register and begin marketing automation today. If you already have a Wolfeo account, login to your account and go to your <a href="https://www.wolfeo.me/api" target="_blank">API menu</a> to retrieve your API key and enter it here.</p>
<p><input type="text" name="<?php echo $api_id; ?>" id="<?php echo $api_id; ?>" value="<?php echo $api_val; ?>" size="50"><input type="submit" name="Submit" class="button-primary formsend floatsend" value="<?php esc_attr_e('Update API Key') ?>" />
</p><hr />
<?php
$post_url = 'https://www.wolfeo.me/api/v1';

// Data to send to API
$api_check = get_option( 'wolf_api_id' );
if (!empty($api_check)) {
$fields = array();
$fields['action'] = 'get_pushy_campaigns';
$fields['api_key'] = $api_val;

$fields_string = '';
foreach($fields as $key=>$value) { $fields_string .= $key.'='.$value.'&'; }
rtrim($fields_string, '&');

$ch = curl_init();
curl_setopt($ch, CURLOPT_URL, $post_url);
curl_setopt($ch, CURLOPT_POST, json_encode($fields));
curl_setopt($ch, CURLOPT_POSTFIELDS, $fields_string);
curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);

$result = curl_exec($ch);
curl_close($ch);

$decode = json_decode($result, true);
$campaigns = $decode['campaigns'];
echo '<h3>Step 2: Select Your Campaign</h3>';
echo '<select name="campaigns" id="wolf_campaigns">';
foreach ($campaigns as $campaign){
$token = $campaign['token'];
$title = $campaign['title'];
echo '<option value="' . $token . '">' . $title . '</option>';
}
echo '</select><input type="submit" name="Submit" class="button-primary formsend floatsend" value="Save Campaign Selection" />';

update_option( $opt_name, $token );
?>
<input type="hidden" name="<?php echo $data_field_name; ?>" value="<?php echo $token; ?>" size="50">
</p><hr />
<h3>Step 3: Page &amp; Post Selection</h3>
<p><?php _e("Select the pages to include your Pushy notifications on:", 'menu-test' ); ?></p>
<?php 
$wpb_all_query = new WP_Query(array('post_type'=>'page', 'post_status'=>'publish', 'posts_per_page'=>-1)); ?>

<?php if ( $wpb_all_query->have_posts() ) : ?>

    <?php
        $id_list = esc_attr( (get_option( 'wolf_id_list' ) ) );
        $id_match = explode(",", $id_list);
        $id_unique = array_unique($id_match); 
    ?>
    <select multiple="multiple" id="multiselect_page" name="multiselect">
    <?php while ( $wpb_all_query->have_posts() ) : $wpb_all_query->the_post(); ?>
        <?php if (in_array(get_the_id(), $id_unique)) { ?>
        <option class="checkid checkpage" id="<?php the_id(); ?>" name="<?php the_id(); ?>" value="<?php the_id(); ?>" selected="selected"><?php the_title(); ?></option>
        <?php } else { ?>
        <option class="checkid checkpage" id="<?php the_id(); ?>" name="<?php the_id(); ?>" value="<?php the_id(); ?>"><?php the_title(); ?></option>
        <?php } ?>    
    <?php endwhile; ?>
    </select>
</li>
    <?php wp_reset_postdata(); ?>

<?php else : ?>
    <p><?php _e( 'Sorry, no pages matched your criteria.' ); ?></p>
<?php endif; ?>
<br />
<hr />
<?php $opt_val = get_option( $opt_name );
if (!empty($api_check)) { ?>
<p><?php _e("Select the posts to include your Pushy notifications on:", 'menu-test' ); ?></p>
<?php 
$wpb_all_query = new WP_Query(array('post_type'=>'post', 'post_status'=>'publish', 'posts_per_page'=>-1)); ?>

<?php if ( $wpb_all_query->have_posts() ) : ?>

    <?php
        $id_list = esc_attr( (get_option( 'wolf_id_list' ) ) );
        $id_match = explode(",", $id_list);
        $id_unique = array_unique($id_match); 
    ?>
    <select multiple="multiple" id="multiselect_post" name="multiselect">
    <?php while ( $wpb_all_query->have_posts() ) : $wpb_all_query->the_post(); ?>
        <?php if (in_array(get_the_id(), $id_unique)) { ?>
        <option class="checkid checkpost" id="<?php the_id(); ?>" name="<?php the_id(); ?>" value="<?php the_id(); ?>" selected="selected"><?php the_title(); ?></option>
        <?php } else { ?>
        <option class="checkid checkpost" id="<?php the_id(); ?>" name="<?php the_id(); ?>" value="<?php the_id(); ?>"><?php the_title(); ?></option>
        <?php } ?>    
    <?php endwhile; ?>
    </select>
    <?php wp_reset_postdata(); ?>

<?php else : ?>
    <p><?php _e( 'Sorry, no posts matched your criteria.' ); ?></p>
<?php endif; ?>
<p class="submit">
<input type="submit" name="Submit" class="button-primary formsend" value="<?php esc_attr_e('Save Settings') ?>" />
</p>
<?php }} ?>
</form>
</div>

<?php
 
}