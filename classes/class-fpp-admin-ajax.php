<?php
if ( ! class_exists( 'FPP_admin_ajax' ) && defined( 'ABSPATH' ) ) {

	class FPP_admin_ajax {

		public function __construct() {
			self::set_filters();
		}

		public function set_filters() {
			add_action('wp_ajax_fpp_settings', array($this, 'fpp_settings'));
			add_action('wp_ajax_nopriv_fpp_settings', array($this, 'fpp_settings'));
			
            add_action('wp_ajax_fpp_add_user', array($this, 'fpp_add_user'));
			add_action('wp_ajax_nopriv_fpp_add_user', array($this, 'fpp_add_user'));
            
            add_action('wp_ajax_fpp_admin_add_company', array($this, 'fpp_add_company'));
			add_action('wp_ajax_nopriv_fpp_admin_add_company', array($this, 'fpp_add_company'));
			
            add_action('wp_ajax_fpp_generate_password', array($this, 'fpp_generate_password'));
			add_action('wp_ajax_nopriv_fpp_generate_password', array($this, 'fpp_generate_password'));
		}

        function fpp_add_user() {
            $userdata = array(
                'user_email' 	=> $_POST['user-email'],
                'first_name' 	=> $_POST['user-firstname'],
                'last_name' 	=> $_POST['user-lastname'],
            );
            if(isset($_POST['user_id'])) {
                $userdata['ID'] = $_POST['user_id'];
                if(!empty($_POST['user-password'])) {
                    $userdata['user_pass'] = $_POST['user-password'];
                }
                $user_id = wp_update_user( $userdata );
                $result = array( 'success'=>true, 'message'=>'User details updated successfully.', 'result'=> ['user_id'=>$user_id] );
            } else {
                $userdata['user_login'] = $_POST['user-username'];
                $userdata['user_pass'] = $_POST['user-password'];
                $userdata['role'] = 'fpp';
                $url = admin_url( 'admin.php?page=fpp-users.php' );
                if( $user_id = username_exists( $userdata['user_login'] ) ) {
                    $result = array( 'success'=>false, 'message'=>'Username already exists.', 'result'=> ['user_id'=>$user_id] );
                } else {
                    $user_id = wp_insert_user( $userdata ) ;
                    $result = array( 'success'=>true, 'message'=>'User created successfully.', 'result'=> ['user_id'=>$user_id, 'redirect'=>$url] );
                }
                if(isset($_POST['notify-user'])) {
                    $user_full_name = $userdata['first_name'] . ' ' . $userdata['last_name'];
                    $to = $userdata['user_email'];
                    $subject = "Hi " . $user_full_name . ", welcome to our site | ". get_bloginfo( 'name' );
                    $body = '
                            <h1>Dear ' . $user_full_name . ',</h1></br>
                            <p>Thank you for joining our site. Your account is now active.</p>
                            <p>Please go ahead and navigate around your account.</p>
                            <p>Use following details to login:</p>
                            <p><strong>Username:</strong> '.$userdata['user_login'].'</p>
                            <p><strong>Password:</strong> '.$userdata['user_pass'].'</p>
                            <p></p>
                            <p>Let me know if you have further questions, We are here to help.</p>
                            <p>Enjoy the rest of your day!</p>
                            <p>Kind Regards,</p>
                            <p>' . get_bloginfo( 'name' ) . '</p>
                    ';
                    $headers = array('Content-Type: text/html; charset=UTF-8');
                    wp_mail($to, $subject, $body, $headers);
                }
            }
            echo json_encode($result);
			exit;
        }

        function fpp_add_company() {
            global $wpdb;
            $table_company = $wpdb->prefix . FPP_TABLE_COMPANY;
            $companydata = array(
                'title' 	=> $_POST['title'],
                'facebook_page_id' 	=> $_POST['facebook_page_id'],
                'shortcodes' 	=> serialize($_POST['fppvalue']),
                'user_id' 	=> get_current_user_id(),
                'created_date' 	=> date("Y-m-d h:i:s A"),
            );
            update_option( 'fpp_shortcodes', $_POST['fppkey'] );

            if(isset($_POST['company_id'])) {
                $company_id = $_POST['company_id'];
                $wpdb->update($table_company, $companydata, array('id'=>$company_id));
                $result = array( 'success'=>true, 'message'=>'Company details updated successfully.', 'result'=> ['company_id'=>$company_id] );
            } else {
                $url = admin_url( 'admin.php?page=fpp-companies.php' );
                $company_id = $wpdb->insert($table_company, $companydata);
            }
            $result = array( 'success'=>true, 'message'=>'Company inserted successfully.', 'result'=> ['company_id'=>$company_id, 'redirect'=>$url] );
            echo json_encode($result);
			exit;
        }

		function fpp_generate_password() {
            // wp_generate_password( int $length = 12, bool $special_chars = true, bool $extra_special_chars = false ): string
            echo wp_generate_password( 12, true, false);
            exit;
        }

        function fpp_settings() {
            $options = get_option('fpp_option');
            $options['settings'] = array(
                'app_id' => $_POST['app_id'],
                'app_secret' => $_POST['app_secret'],
                'callback_url' => $_POST['callback_url'],
                'hide_admin_bar' => isset($_POST['hide_admin_bar'])?true:false,
            );
            update_option('fpp_option', $options);
            $output = array(
                'success' => true,
                'message' => 'Settings updated.',
                'result' => $options
            );
            echo json_encode($output);
            exit;
        }

	}

	new FPP_admin_ajax();
}
