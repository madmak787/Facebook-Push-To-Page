<?php
// Include the autoloader provided in the SDK
require_once FPP_PLUGIN_PATH.'vendor/autoload.php';

if ( ! class_exists( 'FPP_shortcode' ) && defined( 'ABSPATH' ) ) {
	
	class FPP_shortcode {

		public function __construct() {
			self::set_filters();
		}

		public function set_filters() {
			add_action( 'init', array( $this, 'fpp_callback_helper') );
			add_action( 'wp_enqueue_scripts', array( $this, 'fpp_enqueue_scripts') );

			add_shortcode( 'fpp-dashboard', array( $this, 'fpp_dashboard' ), 10, 0 );
		}

		function fpp_enqueue_scripts() {
			wp_register_style( 'fpp-stroke-7', FPP_PLUGIN_URL.'assets/lib/stroke-7/style.css', array(), time(), 'all' );
			wp_register_style( 'fpp-select2', FPP_PLUGIN_URL.'assets/lib/select2/css/select2.min.css', array(), time(), 'all' );
			wp_register_style( 'fpp-bootstrap-slider', FPP_PLUGIN_URL.'assets/lib/bootstrap-slider/css/bootstrap-slider.min.css', array(), time(), 'all' );
			wp_register_style( 'fpp-datepicker3', FPP_PLUGIN_URL.'assets/lib/datepicker/css/bootstrap-datepicker3.min.css', array(), time(), 'all' );
			wp_register_style( 'fpp-jquery.gritter', FPP_PLUGIN_URL.'assets/lib/jquery.gritter/css/jquery.gritter.css', array(), time(), 'all' );
			wp_register_style( 'fpp-font-awesome', FPP_PLUGIN_URL.'assets/lib/font-awesome/css/font-awesome.min.css', array(), time(), 'all' );

			wp_register_style( 'fpp-style', FPP_PLUGIN_URL.'assets/css/style.css', array(), time(), 'all' );
			wp_register_style( 'fpp-custom', FPP_PLUGIN_URL.'assets/css/custom.css', array(), time(), 'all' );
			
			wp_register_script('fpp-bootstrap', FPP_PLUGIN_URL.'assets/lib/bootstrap/dist/js/bootstrap.bundle.min.js', array(), false, true );
			
			wp_register_script('fpp-jquery-ui', FPP_PLUGIN_URL.'assets/lib/jquery-ui/jquery-ui.min.js', array(), false, true );
			wp_register_script('fpp-select2', FPP_PLUGIN_URL.'assets/lib/select2/js/select2.min.js', array(), false, true );
			wp_register_script('fpp-select2.full', FPP_PLUGIN_URL.'assets/lib/select2/js/select2.full.min.js', array(), false, true );
			wp_register_script('fpp-bootstrap-slider', FPP_PLUGIN_URL.'assets/lib/bootstrap-slider/bootstrap-slider.min.js', array(), false, true );
			wp_register_script('fpp-datepicker', FPP_PLUGIN_URL.'assets/lib/datepicker/js/bootstrap-datepicker.min.js', array(), false, true );
			wp_register_script('fpp-jquery.gritter', FPP_PLUGIN_URL.'assets/lib/jquery.gritter/js/jquery.gritter.js', array(), false, true );
			
			wp_register_script('fpp-custom', FPP_PLUGIN_URL.'assets/js/custom.js', array(), false, true );

			$admin_ajax = admin_url('admin-ajax.php');
			wp_add_inline_script( 'fpp-custom', "var admin_ajax = '".$admin_ajax."'" );
		}

		function fpp_dashboard() {
			wp_enqueue_style( 'fpp-stroke-7' );
			wp_enqueue_style( 'fpp-select2' );
			wp_enqueue_style( 'fpp-bootstrap-slider' );
			wp_enqueue_style( 'fpp-datepicker3' );
			wp_enqueue_style( 'fpp-jquery.gritter' );
			wp_enqueue_style( 'fpp-font-awesome' );

			wp_enqueue_style( 'fpp-style' );
			wp_enqueue_style( 'fpp-custom' );
			
			wp_enqueue_script('jquery');
			wp_enqueue_script('fpp-bootstrap');
			wp_enqueue_script('fpp-jquery-ui');
			wp_enqueue_script('fpp-select2');
			wp_enqueue_script('fpp-select2.full');
			wp_enqueue_script('fpp-bootstrap-slider');
			wp_enqueue_script('fpp-datepicker');
			wp_enqueue_script('fpp-jquery.gritter');

			wp_enqueue_script('fpp-custom');

			$options = get_option('fpp_option');
			// delete_user_meta(get_current_user_id(  ), 'fpp_code' );
			// delete_user_meta(get_current_user_id(  ), 'fpp_fb_access_token' );
			ob_start();
			include FPP_PLUGIN_PATH.'templates/fpp-main.php';
			$html = ob_get_contents();
			ob_end_clean();
			return $html;
		}

		function fpp_callback_helper() {
			// echo '<pre>'.print_r($_REQUEST,true).'</pre>'; exit;

			$options = get_option('fpp_option');
			if(isset($options['settings']['hide_admin_bar']) && !empty($options['settings']['hide_admin_bar'])) {
				if (current_user_can('administrator')) {
					// defaults
				} else {
					show_admin_bar(false);
				}
			}

			if(isset($_REQUEST['code']) && isset($_REQUEST['state'])) {
				
				$fpp_code = $_GET['code'];
				update_user_meta(get_current_user_id(  ), 'fpp_code', $fpp_code);
				$query = new WP_Query( "s=fpp-dashboard" );
				$arr = array();
				if ($query->have_posts()){
					while ( $query->have_posts() ) { $query->the_post();
						wp_redirect(get_permalink( get_the_ID() ).'#settings');
						exit;
					}
				}
			}

			if(isset($_REQUEST['fb-logout'])) {
				delete_user_meta(get_current_user_id(  ), 'fpp_code' );
				delete_user_meta(get_current_user_id(  ), 'fpp_fb_access_token' );
				$query = new WP_Query( "s=fpp-dashboard" );
				$arr = array();
				if ($query->have_posts()){
					while ( $query->have_posts() ) { $query->the_post();
						wp_redirect(get_permalink( get_the_ID() ).'?logout=true#settings');
						exit;
					}
				}
			}

			if(isset($_REQUEST['error']) && isset($_REQUEST['error_reason'])) {
				$query = new WP_Query( "s=fpp-dashboard" );
				$arr = array();
				if ($query->have_posts()){
					while ( $query->have_posts() ) { $query->the_post();
						wp_redirect(get_permalink( get_the_ID() ).'?error=Denied#settings');
						exit;
					}
				}
			}
		}

	}

	new FPP_shortcode();
}
