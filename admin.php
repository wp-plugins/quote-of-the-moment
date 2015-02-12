<?php
// disallow direct access to this PHP file
defined( 'ABSPATH' ) or die( 'No script kiddies please!' );

// add the admin options page
add_action('admin_menu', 'qotm_admin_add_page');
function qotm_admin_add_page() {
	add_options_page('Quote Of The Moment Settings', 'Quote of the moment', 'manage_options', 'qotm', 'qotm_options_page');
}
?>
<?php // display the qotm_options_page
function qotm_options_page() {
?>
<div>
<h2>Quote Of The Moment Settings</h2>

<form action="options.php" method="post">
<?php settings_fields('qotm_options'); ?>
<?php do_settings_sections('qotm'); ?>
 
<input name="Submit" type="submit" value="<?php esc_attr_e('Save Changes'); ?>" />
</form></div>

<?php
}
?>
<?php // add the admin settings and such
add_action('admin_init', 'qotm_admin_init');
function qotm_admin_init(){
register_setting( 'qotm_options', 'qotm_options', 'qotm_options_validate' );
add_settings_section('qotm_main', 'Main Settings', 'qotm_section_text', 'qotm');
add_settings_field('qotm_url', 'Quote source URL', 'qotm_setting_url', 'qotm', 'qotm_main');
add_settings_field('qotm_poll_interval', 'Poll Interval in ms', 'qotm_setting_poll_interval', 'qotm', 'qotm_main');
}?>
<?php function qotm_section_text() {
echo '<p></p>';
} ?>
<?php function qotm_setting_url() {
$options = get_option('qotm_options');
echo "<input id='qotm_url' name='qotm_options[url]' size='50' type='text' value='{$options['url']}' />* default: http://spoffle.com/qotm/getqotm.php";
} ?>
<?php function qotm_setting_poll_interval() {
$options = get_option('qotm_options');
echo "<input id='qotm_poll_interval' name='qotm_options[poll_interval]' size='5' type='text' value='{$options['poll_interval']}' />* minimum 3000 (3 seconds)";
} ?>
<?php // validate our options
function qotm_options_validate($input) {
$newinput['poll_interval'] = trim($input['poll_interval']);
$newinput['url'] = trim($input['url']);
if($newinput['poll_interval'] <=  3000)
	$newinput['poll_interval'] = 3000;
return $newinput;
}
?>