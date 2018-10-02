<?php
/**
 * @package twin_sites
 * @version 0.1
 */
/*
Plugin Name: Twin Sites
Plugin URI: https://wordpress.org/plugins/twin-sites/
Description: This plugin adds a drop-down to site with links to the current page in your other site/s.
Author: Avraham Cornfeld & Reuven Karasik
Version: 0.11
Author URI: https://alefalefalef.co.il
Text Domain: twin-sites

<select onchange="window.open(this.options[this.selectedIndex].value,'_top')" id="">
	<option value=""><?php _e( 'Switch to:', 'twin_sites' ); ?></option>
	<?php foreach ($variable as $key => $value) : ?>
		<option value="<?=url?>"><?=title()?></option>
	<php endforeach; ?>
</select>

*/


//add link to site/s admin on top
add_action( 'admin_notices', 'link_to_twin_sites' );

//add link to site/s in bottom of page
add_action('wp_footer', 'link_to_twin_sites');

function link_to_twin_sites() {
	$site_name = 'פונטימונים';
	$site_url = 'https://fontimonim.co.il';
	$url = $site_url . $_SERVER['REQUEST_URI'];
	if (is_admin())
	echo '<a id="twin_sites" href="' . $url . '" target="_blank"><i class="icon" data-icon="ℶ"></i> <?php echo $site_name; ?> ⇱</a>';
} 


// We need some CSS to position the paragraph
function twin_sites_css() {
	// This makes sure that the positioning is also good for right-to-left languages
	$x = is_rtl() ? 'left' : 'right';

	echo "
	<style type='text/css'>
	#twin_sites {
		float: $x;
		text-decoration: none;
		display: inline-block;
		background: #fff;
		border: 1px solid #23e;
		color: #23e;
		margin-top: 0.1em;
		margin-$x: 0.3em;
		padding: 0 0.4em;
		border-radius: 0.4em;	
	}
	</style>
	";
}

add_action( 'admin_head', 'twin_sites_css' );




