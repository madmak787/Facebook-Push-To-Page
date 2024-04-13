<?php
//https://stackoverflow.com/questions/11130528/malformed-facebook-access-token
// https://diliprajbaral.com/2014/07/16/facebook-php-sdk-4-0-re-asking-declined-permissions/

// Include required libraries
use Facebook\Facebook;
use Facebook\Exceptions\FacebookResponseException;
use Facebook\Exceptions\FacebookSDKException;

global $wpdb;
$table_company = $wpdb->prefix . FPP_TABLE_COMPANY;
$login_url = '';

if (isset($options['settings']['app_id']) && $options['settings']['app_id'] != '') {
	/*
	 * Configuration and setup Facebook SDK
	 */
	$appId = $options['settings']['app_id'];
	$appSecret = $options['settings']['app_secret'];
	$redirectURL = $options['settings']['callback_url'];
	// $fbPermissions = ['public_profile', 'email']; //Facebook permission
	$fbPermissions = ['pages_show_list', 'pages_read_engagement', 'pages_manage_posts']; //Facebook permission

	$facebook = new Facebook(
		array(
			'app_id' => $appId,
			'app_secret' => $appSecret,
			'default_graph_version' => 'v16.0',
		)
	);
	$helper = $facebook->getRedirectLoginHelper();
	// $login_url = $helper->getLoginUrl($redirectURL, $fbPermissions, '&', );
	$login_url = $helper->getReRequestUrl($redirectURL, $fbPermissions);
	if ($fpp_code = get_user_meta(get_current_user_id(), 'fpp_code', true)) {
		// First get facebook token (short lived token)
		// then get long lived token from short lived token
		// Reference https://github.com/facebookarchive/php-graph-sdk/blob/5.x/docs/examples/facebook_login.md
		// get short lived access token from code.
		$token_url = "https://graph.facebook.com/oauth/access_token?" . "client_id=" . $appId . "&redirect_uri=" . urlencode($redirectURL) . "&client_secret=" . $appSecret . "&code=" . $fpp_code;
		$response = wp_remote_get($token_url);
		$response = wp_remote_retrieve_body($response);
		$response = json_decode($response, true);
		if (isset($response['access_token'])) {
			$oAuth2Client = $facebook->getOAuth2Client();
			// Exchanges a short-lived access token for a long-lived one
			$fbAccessToken = $response['access_token'];
			$fbAccessToken = (string) $oAuth2Client->getLongLivedAccessToken($fbAccessToken);
			update_user_meta(get_current_user_id(), 'fpp_fb_access_token', $fbAccessToken);

			// Get allowed pages list and create Companies in backend
			$token_url = "https://graph.facebook.com/v19.0/me/accounts?access_token=" . $fbAccessToken;
			$res = wp_remote_get($token_url);
			$res = wp_remote_retrieve_body($res);
			$res = json_decode($res, true);
			if (isset($res['data'])) { // Read all pages list and loop to add pages in admin
				foreach ($res['data'] as $page ) {
					$companydata = array(
						'title' 	=> $page['name'],
						'facebook_page_id' 	=> $page['id'],
						'facebook_page_name' 	=> $page['name'],
						'facebook_page_token' 	=> $page['access_token'],
						'shortcodes' 	=> get_option('fpp_shortcodes'),
						'user_id' 	=> get_current_user_id(),
						'created_date' 	=> date("Y-m-d h:i:s A"),
					);
					$company_id = $wpdb->insert($table_company, $companydata);
				}
			}
		}
	}

}
?>
<div class="row">
	<div class="col-12 col-sm-8">
		<div class="card card-default">
			<div class="card-header card-header-divider">Settings</div>
			<div class="card-body pl-sm-5">
				<form>
					<?php
					if(isset($_GET['error'])) {
						echo '<div class="alert alert-danger" role="alert">User denied permission.</div>';
					}
					?>
					<div class="form-group row">
						<label class="col-12 col-sm-3 col-form-label text-sm-right">Authorize</label>
						<div class="col-12 col-sm-9 col-lg-8">
							<?php
							if ($fbAccessToken = get_user_meta(get_current_user_id(), 'fpp_fb_access_token', true)) {
								try {
									$response = $facebook->get('/me', $fbAccessToken);
								} catch (FacebookResponseException $e) {
									// When Graph returns an error
									echo 'Graph returned an error: ' . $e->getMessage();
									exit;
								} catch (FacebookSDKException $e) {
									// When validation fails or other local issues
									echo 'Facebook SDK returned an error: ' . $e->getMessage();
									exit;
								}

								$me = $response->getGraphUser();
								echo 'Logged in as <strong>' . $me->getName() . '</strong>';
								$logout_url = $helper->getLogoutUrl($fbAccessToken, $redirectURL.'&fb-logout=true');
								echo ' <a href="' . $logout_url . '">Logout</a>';
								echo '<br>';
								echo 'You can revoke access from below button.';
							}
							?>
							<a href="<?php echo $login_url; ?>">
								<img src="<?= FPP_PLUGIN_URL . '/assets/img/fb-btn.png' ?>">
							</a>

							<div style="display:none">
								<h2>For Debugging Only:</h2>
								<p><strong>Code:</strong></p> <?=get_user_meta(get_current_user_id(), 'fpp_code', true)?>
								<p><strong>Access Token:</strong></p> <?=get_user_meta(get_current_user_id(), 'fpp_fb_access_token', true)?>
							</div>
						</div>
					</div>

					<div class="form-group row">
						<div class="col-11">
							<p class="text-right">
								<button class="btn btn-space btn-primary">Save Changes</button>
							</p>
						</div>
					</div>

				</form>
			</div>
		</div>
	</div>
	<div class="col-12 col-sm-4">
		<div class="card">
			<div class="card-header card-header-divider">
				Information
				<span class="card-subtitle">Mauris vestibulum libero.</span>
			</div>
			<div class="card-body">
				<ul>
					<li>Lorem ipsum dolor sit amet</li>
					<li>Consectetur adipiscing elit</li>
					<li>Integer molestie lorem at massa</li>
					<li>Facilisis in pretium nisl aliquet</li>
					<li>Nulla volutpat aliquam velit
						<ul>
							<li>Phasellus iaculis neque</li>
							<li>Purus sodales ultricies</li>
							<li>Vestibulum laoreet porttitor sem</li>
							<li>Ac tristique libero volutpat at</li>
						</ul>
					</li>
					<li>Faucibus porta lacus fringilla vel</li>
					<li>Aenean sit amet erat nunc</li>
					<li>Eget porttitor lorem</li>
				</ul>
			</div>
		</div>
	</div>
</div>