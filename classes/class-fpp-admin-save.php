<?php
if ( ! class_exists( 'FPP_admin_save' ) && defined( 'ABSPATH' ) ) {

	class FPP_admin_save {

		public function __construct() {
			self::set_filters();
		}

		public function set_filters() {
			add_action('init', array($this,'fpp_save_forms'));
			
		}

		function fpp_save_forms() {
			if(isset($_POST['fpp_action'])) {
				switch($_POST['fpp_action']) {
					case 'add_new_user':
						break;
					default:
						break;
				}
				echo json_encode($result);
				exit;
			}
		}

	}

	new FPP_admin_save();
}
