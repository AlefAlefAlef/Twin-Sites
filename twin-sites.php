<?php
/**
 * @package twin_sites
 * @version 1.1
 */
/*
Plugin Name: Twin Sites
Plugin URI: https://wordpress.org/plugins/twin-sites/
Description: Adds a drop-down to the admin bar with links to the current page in your other site/s.
Author: Avraham Cornfeld & Reuven Karasik
Version: 1.0
Author URI: https://alefalefalef.co.il
Text Domain: twin-sites

<select onchange="window.open(this.options[this.selectedIndex].value,'_top')" id="">
	<option value=""><?php _e( 'Switch to:', 'twin_sites' ); ?></option>
	<?php foreach ($variable as $key => $value) : ?>
		<option value="<?=url?>"><?=title()?></option>
	<php endforeach; ?>
</select>

*/

class TwinSites {
	public $current_site;

	function __construct() {

		//  (can only be one, containing URLS to other WordPress installations)
		register_nav_menu( 'twin-sites', __( 'TwinSites Menu', 'twin-sites' ) );

		$this->current_site = get_bloginfo( 'name' );

		add_action( 'admin_bar_menu', array( $this, 'add_toolbar_items' ), 100 );
	}

	protected function get_url( $base_url ) {
		$current_page = $_SERVER['REQUEST_URI'];
		if ( '/' === substr( $current_page, 0, 1 ) ) {
			$current_page = substr( $current_page, 1 );
		}
		return trailingslashit( $base_url ) . $current_page;
	}

	public function add_toolbar_items( $admin_bar ) {
		$admin_bar->add_menu(
			array(
				'id'    => 'twin-sites',
				// TRANSLATORS: %s: the current site's name
				'title' => sprintf( __( 'On: %s', 'twin-sites' ), $this->current_site ),
				'href'  => '#',
			)
		);
		if ( ( $locations = get_nav_menu_locations() ) && isset( $locations['twin-sites'] ) ) {
			$menu = get_term( $locations['twin-sites'], 'nav_menu' );
			$menu_items = wp_get_nav_menu_items( $menu->term_id );
			foreach ( $menu_items as $link ) {
				$admin_bar->add_menu(
					array(
						'id'    => 'twin-sites-' . $link->ID,
						'parent' => 'twin-sites',
						'title' => $link->post_title . ' ⇱',
						'href'  => $this->get_url( $link->url ),
						'meta'  => array(
							'title' => $link->post_title . " ({$link->url})",
							'target' => '_blank',
						),
					)
				);
			}
		}
	}

}

add_action( 'init', 'run_twin_sites' );
function run_twin_sites() {
	new TwinSites();
}

require 'plugin-update-checker/plugin-update-checker.php';
$update_checker = Puc_v4_Factory::buildUpdateChecker(
	'https://github.com/alefalefalef/twin-sites/',
	__FILE__,
	'twin-sites'
);

//Optional: Set the branch that contains the stable release.
$update_checker->setBranch( 'master' );


