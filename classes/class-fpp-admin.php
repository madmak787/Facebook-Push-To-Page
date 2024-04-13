<?php
if ( ! class_exists( 'FPP_admin' ) && defined( 'ABSPATH' ) ) {

	class FPP_admin {

		public function __construct() {
			self::set_filters();
		}

		public function set_filters() {
			add_action( 'admin_menu', array($this,'fpp_admin_menu_page') );

			add_action( 'admin_enqueue_scripts', array( $this, 'fpp_admin_enqueue_scripts') );
		}

		function fpp_admin_enqueue_scripts() {
			wp_register_style( 'fpp-admin-datatable', 'https://cdn.jsdelivr.net/npm/simple-datatables@latest/dist/style.css', array(), time(), 'all' );
			wp_register_style( 'fpp-admin-styles', FPP_PLUGIN_URL.'/assets/admin/css/styles.css', array(), time(), 'all' );
			
			wp_register_script('fpp-admin-scripts', FPP_PLUGIN_URL.'/assets/admin/js/scripts.js', array(), false, true );
			wp_register_script('fpp-admin-bootstrap', 'https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js', array(), false, true );
			wp_register_script('fpp-admin-fontawesome', 'https://use.fontawesome.com/releases/v6.1.0/js/all.js', array(), false, true );

			$admin_ajax = admin_url('admin-ajax.php');
			wp_add_inline_script( 'fpp-admin-scripts', "var admin_ajax = '".$admin_ajax."'" );
			
			$pages = ['fpp-companies.php', 'fpp-new-company.php', 'fpp-settings.php', 'fpp-users.php', 'add-user.php'];
			if(	
				( isset( $_GET['page'] ) && in_array( $_GET['page'],$pages ) ) ) {
				wp_enqueue_style( 'fpp-admin-datatable' );
				wp_enqueue_style( 'fpp-admin-styles' );
				
				wp_enqueue_script('fpp-admin-fontawesome');
				wp_enqueue_script('fpp-admin-bootstrap');
				wp_enqueue_script('fpp-admin-scripts');
			}
			
		}

		function fpp_admin_menu_page() {
			$parent_slug = FPP_PLUGIN_NAME;
			add_menu_page(
				__( 'FB Post', 'wpspins' ),
				__( 'FB Post', 'wpspins' ),
				'manage_options',
				FPP_PLUGIN_NAME,
				'',
				'data:image/svg+xml;base64,' . base64_encode('<svg xmlns="http://www.w3.org/2000/svg"  viewBox="0 0 50 50" width="50px" height="50px" fill="#fff"><path d="M 25 3 C 12.861562 3 3 12.861562 3 25 C 3 36.019135 11.127533 45.138355 21.712891 46.728516 L 22.861328 46.902344 L 22.861328 29.566406 L 17.664062 29.566406 L 17.664062 26.046875 L 22.861328 26.046875 L 22.861328 21.373047 C 22.861328 18.494965 23.551973 16.599417 24.695312 15.410156 C 25.838652 14.220896 27.528004 13.621094 29.878906 13.621094 C 31.758714 13.621094 32.490022 13.734993 33.185547 13.820312 L 33.185547 16.701172 L 30.738281 16.701172 C 29.349697 16.701172 28.210449 17.475903 27.619141 18.507812 C 27.027832 19.539724 26.84375 20.771816 26.84375 22.027344 L 26.84375 26.044922 L 32.966797 26.044922 L 32.421875 29.564453 L 26.84375 29.564453 L 26.84375 46.929688 L 27.978516 46.775391 C 38.71434 45.319366 47 36.126845 47 25 C 47 12.861562 37.138438 3 25 3 z M 25 5 C 36.057562 5 45 13.942438 45 25 C 45 34.729791 38.035799 42.731796 28.84375 44.533203 L 28.84375 31.564453 L 34.136719 31.564453 L 35.298828 24.044922 L 28.84375 24.044922 L 28.84375 22.027344 C 28.84375 20.989871 29.033574 20.060293 29.353516 19.501953 C 29.673457 18.943614 29.981865 18.701172 30.738281 18.701172 L 35.185547 18.701172 L 35.185547 12.009766 L 34.318359 11.892578 C 33.718567 11.811418 32.349197 11.621094 29.878906 11.621094 C 27.175808 11.621094 24.855567 12.357448 23.253906 14.023438 C 21.652246 15.689426 20.861328 18.170128 20.861328 21.373047 L 20.861328 24.046875 L 15.664062 24.046875 L 15.664062 31.566406 L 20.861328 31.566406 L 20.861328 44.470703 C 11.816995 42.554813 5 34.624447 5 25 C 5 13.942438 13.942438 5 25 5 z"/></svg>')
			);
			add_submenu_page(
				FPP_PLUGIN_NAME,
				__( 'All Companies', 'wpspins' ),
				__( 'All Companies', 'wpspins' ),
				'manage_options',
				'fpp-companies.php',
				array($this,'fpp_companies'),
			);
			add_submenu_page(
				FPP_PLUGIN_NAME,
				__( 'Add New Company', 'wpspins' ),
				__( 'Add New Company', 'wpspins' ),
				'manage_options',
				'fpp-new-company.php',
				array($this,'fpp_new_company'),
			);
			add_submenu_page(
				FPP_PLUGIN_NAME,
				__( 'FPP Users', 'wpspins' ),
				__( 'FPP Users', 'wpspins' ),
				'manage_options',
				'fpp-users.php',
				array($this,'fpp_users'),
			);
			add_submenu_page(
				FPP_PLUGIN_NAME,
				__( 'Add New User', 'wpspins' ),
				__( 'Add New User', 'wpspins' ),
				'manage_options',
				'add-user.php',
				array($this,'fpp_add_user'),
			);
			add_submenu_page(
				FPP_PLUGIN_NAME,
				__( 'FPP Settings', 'wpspins' ),
				__( 'FPP Settings', 'wpspins' ),
				'manage_options',
				'fpp-settings.php',
				array($this,'fpp_settings'),
			);

			remove_submenu_page( FPP_PLUGIN_NAME, FPP_PLUGIN_NAME );
			// remove_submenu_page( FPP_PLUGIN_NAME, 'fpp-new-company.php' );
		}

		function fpp_settings() {
			$options = get_option('fpp_option');
			$options['settings']['app_id'] = empty($options['settings']['app_id'])?'':$options['settings']['app_id'];
			$options['settings']['app_secret'] = empty($options['settings']['app_secret'])?'':$options['settings']['app_secret'];
			$options['settings']['callback_url'] = empty($options['settings']['callback_url'])?home_url('?fpp-callback=true'):$options['settings']['callback_url'];
			$options['settings']['hide_admin_bar'] = isset($options['settings']['hide_admin_bar'])?$options['settings']['hide_admin_bar']:true;
			include_once(FPP_PLUGIN_PATH . '/templates/admin/fpp_settings.php');
		}

		function fpp_companies() {
			$options = get_option('fpp_option');
			include_once(FPP_PLUGIN_PATH . '/templates/admin/fpp_companies.php');
		}

		function fpp_new_company() {
			$options = get_option('fpp_option');
			include_once(FPP_PLUGIN_PATH . '/templates/admin/fpp_add_company.php');
		}

		function fpp_users() {
			$options = get_option('fpp_option');
			include_once(FPP_PLUGIN_PATH . '/templates/admin/fpp_users.php');
		}

		function fpp_add_user() {
			$options = get_option('fpp_option');
			include_once(FPP_PLUGIN_PATH . '/templates/admin/fpp_add_user.php');
		}

	}

	new FPP_admin();
}
