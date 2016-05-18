<?php
/**
 * @package WPSEO\Admin\Options\Tabs
 */

/**
 * Class WPSEO_Option_Tabs_Formatter
 */
class WPSEO_Option_Tabs_Formatter {

	/**
	 * @param WPSEO_Option_Tabs $option_tabs Option Tabs to get base from.
	 * @param WPSEO_Option_Tab  $tab         Tab to get name from.
	 *
	 * @return string
	 */
	public function get_tab_view( WPSEO_Option_Tabs $option_tabs, WPSEO_Option_Tab $tab ) {
		return WPSEO_PATH . 'admin/views/tabs/' . $option_tabs->get_base() . '/' . $tab->get_name() . '.php';
	}

	/**
	 * @param WPSEO_Option_Tabs $option_tabs Option Tabs to get tabs from.
	 * @param Yoast_Form        $yform       Yoast Form which is being used in the views.
	 * @param array             $options     Options which are being used in the views.
	 */
	public function run( WPSEO_Option_Tabs $option_tabs, Yoast_Form $yform, $options = array() ) {
		echo '<h2 class="nav-tab-wrapper" id="wpseo-tabs">';
		foreach ( $option_tabs->get_tabs() as $tab ) {
			printf( '<a class="nav-tab" id="%1$s-tab" href="#top#%1$s">%2$s</a>', $tab->get_name(), $tab->get_label() );
		}
		echo '</h2>';

		foreach ( $option_tabs->get_tabs() as $tab ) {
			// prepare the help center for each tab
			$help_center = new WPSEO_Help_Center( $option_tabs->get_base(), $tab );

			$identifier = $tab->get_name();
			printf( '<div id="%s" class="wpseotab">', $identifier );

			// output the help center
			$help_center->draw_help_center();

			// output the settings view for all tabs
			$tab_view = $this->get_tab_view( $option_tabs, $tab );
			if ( is_file( $tab_view ) ) {
				require_once $tab_view;
			}
			echo '</div>';
		}
	}
}
