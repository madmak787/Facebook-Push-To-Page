<?php
if ( ! class_exists( 'FPP_ajax' ) && defined( 'ABSPATH' ) ) {

	class FPP_ajax {

		public function __construct() {
			self::set_filters();
		}

		public function set_filters() {
			add_action('wp_ajax_nopriv_fpp_login', array($this, 'fpp_login'));
			
            add_action('wp_ajax_fpp_company_list', array($this, 'fpp_company_list'));
			add_action('wp_ajax_fpp_add_company', array($this, 'fpp_add_company'));
			add_action('wp_ajax_fpp_delete_company', array($this, 'fpp_delete_company'));
			add_action('wp_ajax_fpp_edit_company_html', array($this, 'fpp_edit_company_html'));
			add_action('wp_ajax_fpp_update_company', array($this, 'fpp_update_company'));
			
            add_action('wp_ajax_fpp_posts_list', array($this, 'fpp_posts_list'));
            add_action('wp_ajax_fpp_post', array($this, 'fpp_post'));
            add_action('wp_ajax_fpp_delete_post', array($this, 'fpp_delete_post'));
		}

        function fpp_login() {
            $output = array(
                'success'   => true,
                'message'   => 'Logged in successfully. Redirecting...'
            );
            
            $creds = array(
                'user_login'    => $_POST['username'],
                'user_password' => $_POST['password'],
                'remember'      => isset($_POST['remember'])?true:false,
            );
        
            $user = wp_signon( $creds, false );
        
            if ( is_wp_error( $user ) ) {
                $output['success'] = false;
                $output['message'] = $user->get_error_message();
            }
            echo json_encode($output);
            exit;
        }

        function fpp_company_list() {
            global $wpdb;
            $table_company = $wpdb->prefix . FPP_TABLE_COMPANY;
            $output = array(
                'success'   => false,
                'result'   => '',
                'message'   => 'Some error occurred.'
            );
            $sql = "SELECT * FROM $table_company WHERE `user_id` = '".get_current_user_id()."'";
            if(isset($_POST['s']) && $_POST['s']!='') {
                $sql .= " AND `title` LIKE '%".$_POST['s']."%'";
            }
            $companies = $wpdb->get_results($sql, ARRAY_A);
            // The Loop
            foreach($companies as $company) {
                $user = get_user_by('id', $company['user_id']);
                $shortcodes = unserialize($company['shortcodes']);
                $output['result'] .= '<tr data-id="'.$company['id'].'">
                    <td class="cell-detail"><span>'.$company['title'].'</span></td>
                    <td class="cell-detail"><span>'.$company['facebook_page_id'].'</span></td>
                    <td class="cell-detail"><span>'.$shortcodes['city'].'</span></td>
                    <td class="cell-detail"><span>'.$shortcodes['state'].'</span></td>
                    <td class="cell-detail"><span>'.$shortcodes['emailaddress'].'</span></td>
                    <td class="text-right">
                        <button class="btn btn-xs btn-color btn-social btn-primary edit-company"><i class="icon icon-left s7-pen"></i></button>
                        <button class="btn btn-xs btn-color btn-social btn-danger delete-company"><i class="icon icon-left s7-trash"></i></button>
                    </td>
                </tr>';
            }
            $output['success'] = true;
            $output['message'] = '';
            
            echo json_encode($output);
            exit;
        }

        function fpp_add_company() {
            global $wpdb;
            $table_company = $wpdb->prefix . FPP_TABLE_COMPANY;
            $output = array(
                'success'   => false,
                'message'   => 'Some error occurred.'
            );
            $companydata = array(
                'title' 	=> $_POST['title'],
                'facebook_page_id' 	=> $_POST['fb_page_id'],
                'shortcodes' 	=> serialize($_POST['fppvalue']),
                'user_id' 	=> get_current_user_id(),
                'created_date' 	=> date("Y-m-d h:i:s A"),
            );
            update_option( 'fpp_shortcodes', $_POST['fppkey'] );

            $company_id = $wpdb->insert($table_company, $companydata);
            $output['success'] = true;
            $output['message'] = 'Company Added Successfully.';
            echo json_encode($output);
            exit;
        }

        function fpp_delete_company() {
            global $wpdb;
            $table_company = $wpdb->prefix . FPP_TABLE_COMPANY;
            $output = array(
                'success'   => true,
                'message'   => 'Company deleted successfully.'
            );
            $wpdb->delete($table_company, array('id'=>$_POST['post_id']));
            echo json_encode($output);
            exit;
        }

        function fpp_edit_company_html() {
            $post_id = $_POST['post_id'];
            global $wpdb;
            $table_company = $wpdb->prefix . FPP_TABLE_COMPANY;
            $sql = "SELECT * FROM $table_company WHERE `id`='".$post_id."'";
            $company = $wpdb->get_row($sql, ARRAY_A);
            $html = '<div class="form-group row">
                        <label class="col-12 col-sm-3 col-form-label text-sm-right">Company Title</label>
                        <div class="col-12 col-sm-8 col-lg-6">
                            <input class="form-control" type="text" name="title" value="'.$company['title'].'">
                            <input type="hidden" name="post_id" value="'.$post_id.'">
                            <input type="hidden" name="action" value="fpp_update_company">
                        </div>
                    </div>
                    <div class="form-group row">
                        <label class="col-12 col-sm-3 col-form-label text-sm-right">Facebook Page ID</label>
                        <div class="col-12 col-sm-8 col-lg-6">
                            <input class="form-control" type="text" name="fb_page_id" value="'.$company['facebook_page_id'].'">
                        </div>
                    </div>
                    <div class="form-group row">
                        <div class="col-12">
                            <span class="card-subtitle">Shortcodes & Values: </span>
                            <table class="table table-striped table-hover modal-shortcodes">
                                <thead>
                                    <tr>
                                        <th style="width:33.33%;">Key</th>
                                        <th style="width:33.33%;">Shortcode</th>
                                        <th style="width:33.33%;">Value</th>
                                    </tr>
                                </thead>
                                <tbody>';
            if( $results = unserialize($company['shortcodes']) ) {
                foreach($results as $key=>$value) {

                    $html .= '<tr>
                        <td><input name="fppkey[]" type="text" id="'.$key.'" value="'.$key.'" class="form-control fpp-key" autocomplete="off" /></td>
                        <td><input name="fppshortcode['.$key.']" type="text" value="['.$key.']" class="form-control shortcode" readonly="readonly" /></td>
                        <td><input name="fppvalue['.$key.']" type="text" value="'.$value.'" class="form-control value" autocomplete="off" /></td>
                    </tr>';
                    
                }
            } else {
                $defaults = get_option('fpp_shortcodes');
                foreach($defaults as $key) {
                    $html .= '<tr>
                        <td><input name="fppkey[]" type="text" id="'.$key.'" value="'.$key.'" class="form-control fpp-key" autocomplete="off" /></td>
                        <td><input name="fppshortcode['.$key.']" type="text" value="['.$key.']" class="form-control shortcode" readonly="readonly" /></td>
                        <td><input name="fppvalue['.$key.']" type="text" value="" class="form-control value" autocomplete="off" /></td>
                    </tr>';
                }
            }
                                    
            $html .= '</tbody>
                        <tfoot>
                            <tr>
                                <td colspan="3">
                                    <button class="btn btn-xs btn-color btn-pinterest" type="button" onclick="deleteFppValue(\'modal\');"><i class="icon s7-close"></i></button>
                                    <button class="btn btn-xs btn-color btn-behance" type="button" onclick="addFppValue(\'modal\')"><i class="icon s7-plus"></i></button>
                                </td>
                            </tr>
                        </tfoot>
                    </table>
                </div>
            </div>';
            $output = array(
                'success'   => true,
                'html'   => $html,
                'message'   => 'Company details.'
            );
            echo json_encode($output);
            exit;
        }

        function fpp_update_company() {
            $post_id = $_POST['post_id'];
            global $wpdb;
            $table_company = $wpdb->prefix . FPP_TABLE_COMPANY;
            $output = array(
                'success'   => false,
                'message'   => 'Some error occurred.'
            );
            $companydata = array(
                'title' 	=> $_POST['title'],
                'facebook_page_id' 	=> $_POST['fb_page_id'],
                'shortcodes' 	=> serialize($_POST['fppvalue']),
                'user_id' 	=> get_current_user_id(),
                'created_date' 	=> date("Y-m-d h:i:s A"),
            );
            update_option( 'fpp_shortcodes', $_POST['fppkey'] );

            $wpdb->update($table_company, $companydata, array('id'=>$post_id));

            $output['success'] = true;
            $output['message'] = 'Company updated successfully.';

            echo json_encode($output);
            exit;
        }

		function fpp_post() {
            unset($_POST['action']);
            global $wpdb;
            $table = $wpdb->prefix . FPP_TABLE;
            $table_company = $wpdb->prefix . FPP_TABLE_COMPANY;
            
            $output = array(
                'success'   => false,
                'message'   => ''
            );

            foreach( $_POST['fpp_company'] as $post_id ) {
                $sql = "SELECT * FROM $table_company WHERE `id`='".$post_id."'";
                $company = $wpdb->get_row($sql, ARRAY_A);


                $fppvalue = unserialize($company['shortcodes']);
                // echo '<pre>'; print_r($fppvalue); echo '<pre>';
                $body = $_POST["fpp_body"];

                foreach($fppvalue as $key => $value) {
                    $body = str_replace('['.$key.']', $value, $body);
                }
                
                // Configure curl options
                $params = [
                    'message' => $body,
                    // 'link'  => '',
                    'url' => $_POST["fpp_image"],
                    'published' => true,
                ];
                $ch = curl_init();
                if(isset($_POST["fpp_image"]) && $_POST["fpp_image"]!='') {
                    $params['path_to_photo'] = $_POST["fpp_image"];
                    curl_setopt($ch, CURLOPT_URL, 'https://graph.facebook.com/v19.0/'.$company['facebook_page_id'].'/photos?access_token='.$company['facebook_page_token']);
                } else {
                    curl_setopt($ch, CURLOPT_URL, 'https://graph.facebook.com/v19.0/'.$company['facebook_page_id'].'/feed?access_token='.$company['facebook_page_token']);
                }
                
                curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
                curl_setopt($ch, CURLOPT_POST, 1);
                curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($params));
                $headers = array();
                $headers[] = 'Content-Type: application/json';
                curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
                $response = curl_exec($ch);
                if (curl_errno($ch)) {
                    echo 'Error:' . curl_error($ch);
                }
                curl_close($ch);
                $result = json_decode($response, true);
                // echo '<pre>'.print_r($result, true).'</pre>'; exit;
                if(isset($result['post_id'])) {
                    $fb_post_id = $result['id'];
                } else {
                    $fb_post_id = $result['post_id'];
                }
                
                // Insert to WP
                $data = array(
                    'company_id' => $post_id,
                    'title' => $_POST["fpp_title"],
                    'image' => $_POST["fpp_image"],
                    'post' => $body,
                    'facebook_post_id' => $fb_post_id,
                    'facebook_page_id' => $company['facebook_page_id'],
                    'created_date' => date("Y-m-d h:i:s A"),
                );
                $insert_id = $wpdb->insert( $table, $data );
                //$result = json_decode($data, true);
                $output['success'] = true;
            }

            $output['message'] = '#'.count($_POST['fpp_company']).' posted successfully.';

            echo json_encode($output);
            exit;
        }

        function fpp_delete_post() {
            global $wpdb;
            $table = $wpdb->prefix . FPP_TABLE;
            $table_company = $wpdb->prefix . FPP_TABLE_COMPANY;
            $output = array(
                'success'   => true,
                'message'   => 'Post deleted successfully.'
            );
            // Get post for facebook post page id
            $sql = "SELECT * FROM $table WHERE `id`='".$_POST['post_id']."'";
            $post = $wpdb->get_row($sql, ARRAY_A);

            // Get post company for facebook page access token
            $sql = "SELECT * FROM $table_company WHERE `facebook_page_id`='".$post['facebook_page_id']."'";
            $company = $wpdb->get_row($sql, ARRAY_A);
            
            // Delete on Facebook account
            $ch = curl_init();
            curl_setopt($ch, CURLOPT_URL, 'https://graph.facebook.com/v19.0/'.$post['facebook_post_id'].'?access_token='.$company['facebook_page_token']);
            curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
            curl_setopt($ch, CURLOPT_CUSTOMREQUEST, 'DELETE');
            $response = curl_exec($ch);
            if (curl_errno($ch)) {
                echo 'Error:' . curl_error($ch);
            }
            curl_close($ch);
            $result = json_decode($response, true);
            // echo '<pre>'.print_r($company, true).print_r($result, true).print_r($post, true).'</pre>'; exit;
            
            // Delete from WP
            $wpdb->delete($table, array('id'=>$_POST['post_id']));
            echo json_encode($output);
            exit;
        }

        function fpp_posts_list() {
            global $wpdb;
            $table = $wpdb->prefix . FPP_TABLE;
            $table_company = $wpdb->prefix . FPP_TABLE_COMPANY;

            $output = array(
                'success'   => false,
                'result'   => '',
                'message'   => 'Some error occurred.'
            );
            $where = '';
            if(!empty($_POST['company_id'])) {
                $whr = " `company_id`='".$_POST['company_id']."' ";
                $where .= $whr;
            }
            if(!empty($_POST['from'])) {
                $whr = " `created_date`>'".date("Y-m-d h:i:s A", strtotime($_POST['from']))."' ";
                if($where != '') {
                    $where .= 'AND'.$whr;
                } else {
                    $where .= $whr;
                }
            }
            if(!empty($_POST['to'])) {
                $whr = " `created_date`<'".date("Y-m-d h:i:s A", strtotime($_POST['to']))."' ";
                if($where != '') {
                    $where .= 'AND'.$whr;
                } else {
                    $where .= $whr;
                }
            }
            if(!empty($_POST['title'])) {
                $whr = " `title` LIKE '%".$_POST['title']."%'";
                if($where != '') {
                    $where .= 'AND'.$whr;
                } else {
                    $where .= $whr;
                }
            }
            if($where) {
                $where = ' WHERE '.$where;
            }
            $sql = "SELECT * FROM $table".$where;
            $results = $wpdb->get_results( $sql, ARRAY_A );
            
            // The Loop
            if ( $results ) :
                foreach ( $results as $result ) :
                    $sql = "SELECT * FROM $table_company WHERE `id`='".$result['company_id']."'";
                    $company = $wpdb->get_row($sql, ARRAY_A);

                    $output['result'] .= '<tr data-id="'.$result['id'].'">
                        <td class="cell-detail"><span>'.$company['title'].'</span></td>
                        <td class="cell-detail"><span>'.$result['title'].'</span></td>
                        <td class="cell-detail"><span><img src="'.$result['image'].'" height="50" width="50" /></span></td>
                        <td class="cell-detail"><span>'.date("l d, Y",strtotime($result['created_date'])).'</span></td>
                        <td class="text-right">
                            <button class="btn btn-xs btn-color btn-social btn-danger delete-post"><i class="icon icon-left s7-trash"></i></button>
                        </td>
                    </tr>';
                endforeach;
            else:
                $output['result'] .= '<tr><td colspan="5" class="cell-detail"><span>No posts yet.</span></td></tr>';
            endif;
            $output['success'] = true;
            $output['message'] = '';

            echo json_encode($output);
            exit;
        }

	}

	new FPP_ajax();
}
