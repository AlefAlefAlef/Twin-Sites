<?php
/**
 * @package Link_Other_Sites
 * @version 1.0
 */
/*
Plugin Name: Link to your other site's admins
Plugin URI: https://wordpress.org/plugins/hello-dolly/
Description: This plugin adds a drop-down to each of your site's admins with links to the current page in your other sites.
Author: Avraham Cornfeld
Version: 1.0
Author URI: https://alefalefalef.co.il
Text Domain: hello-dolly

				<select onchange="window.open(this.options[this.selectedIndex].value,'_top')" id="">
					<option value="">החלפת אתר</option>
					<?php foreach ($variable as $key => $value) : ?>
						<option value="<?=url?>"><?=title()?></option>
					<php endforeach; ?>
				</select>

*/


//add link to fontimonim admin on top
add_action( 'admin_notices', 'link_to_twin_sites' );

//add link to site after <body> tag opening
add_action('wp_footer', 'link_to_twin_sites');

function link_to_twin_sites() {
	$url = 'https://fontimonim.co.il' . $_SERVER['REQUEST_URI'];
	if (is_admin())
	echo '<a id="twin_sites" href="' . $url . '" target="_blank"><i class="icon" data-icon="ℶ"></i> אל פונטימונים ⇱</a>';
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




