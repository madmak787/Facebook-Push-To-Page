<div class="wrap">
	<h1>Settings</h1>

    <form id="template" method="post" action="#" novalidate="novalidate" style="float:left;width:50%;">
        <table class="form-table" role="presentation">
            <tbody>
                <tr>
                    <th scope="row"><label>Facebook App ID</label></th>
                    <td><input name="app_id" type="text" value="<?=$options['settings']['app_id']?>" class="large-text"></td>
                </tr>
                <tr>
                    <th scope="row"><label>Facebook App Secret</label></th>
                    <td><input name="app_secret" type="text" value="<?=$options['settings']['app_secret']?>" class="large-text"></td>
                </tr>
                <tr>
                    <th scope="row"><label>Callback URL</label></th>
                    <td><input name="callback_url" type="text" value="<?=$options['settings']['callback_url']?>" class="large-text" /></td>
                </tr>
                <tr>
                    <th scope="row"><label>Hide Admin Bar</label></th>
                    <td><input name="hide_admin_bar" type="checkbox" value="true" <?=$options['settings']['hide_admin_bar']?'checked="checked"':''?> /> Yes</td>
                </tr>
            </tbody>
            <tfoot>
                <tr>
                    <td><input type="hidden" name="action" value="fpp_settings"></td>
                    <td><input type="submit" name="fpp-save" id="fpp-save" class="button button-primary" value="Save changes"></td>
                </tr>
            </tfoot>
        </table>
	</form>

    <div id="templateside" style="width:50%">
        <h2 id="theme-files-label">Information</h2>
        <ul style="padding:25px">
            <li>
                <strong>Login to Facebook and go to developers site.</strong>
                <p>Ensure you are logged into your Facebook account and go to <a href="https://developers.facebook.com/" target="_blank">https://developers.facebook.com/</a></p>
            </li>
            <li>
                <strong>Click on Apps > Register as a Developer.</strong>
                <p>On the Developers site, click on the “Apps” link at the top of the page and then click on “Register as a Developer”</p>
            </li>
            <li>
                <strong>Accept the terms and conditions in the popup.</strong>
                <p>Ensure you are comfortable with the policies of using Facebook Apps and select Yes if you are ready.</p>
            </li>
            <li>
                <strong>Verify Your Account.</strong>
                <p>You need to verify your account by providing a Phone number to receive a text to confirm you are the account holder.  Follow the steps in the box to complete this process. <em>*This step may not show for you if you have previously verified your account*.</em></p>
            </li>
            <li>
                <strong>Confirmation of registration.</strong>
                <p>You should now receive confirmation you are registered as a developer.  Click Done to exit this process.</p>
            </li>
            <li>
                <strong>Create a new App.</strong>
                <p>To create a new App, click on ”My Apps” in the opt right side of the Facebook Developers portal, and then choose “Add a New App“.</p>
            </li>
            <li>
                <strong>Enter a name & Category for your app.</strong>
                <p>On the “Create a New App ID” screen, you need to specify a name, email, & Category for your app.  We recommend using the name of your website with no spaces. So for our sample domain optimizetheme.com, we would use “optimizetheme” as the app name.<br>This allows you to easily recognize your different apps as you create more for different websites in the future.<br>Once you have entered this information, click “Create App ID”.</p>
            </li>
            <li>
                <strong>Load the app for editing.</strong>
                <p>Once you have created your app, you now need to modify one setting within the app.  To do this, go back to <a href="https://developers.facebook.com/" target="_blank">https://developers.facebook.com/</a><br>Click on “Apps” at the top of the page and you should see your app listed in the dropdown.  If you see it listed, you created your app correctly (great work!).<br>Click your app name to load it for editing.</p>
            </li>
            <li>
                <strong>Choose Platform.</strong>
                <p>In step 8 we loaded the app for editing. We need to specify the domain where your app will be used.  On the Dashboard for your app, click on “Choose Platform”.<br>Then, on the next screen we’ll need to click on the “WWW” icon for “Website”.<br>After you do that you’ll only need to enter your URL on the next screen and then click the “Next” button.<br>After you click that, just scroll back to the top of your screen and proceed to the next step.</p>
            </li>
            <li>
                <strong>Add your App Domain.</strong>
                <p>We need to specify the domain where your app will be used.  On the Dashboard for your app, click on “Settings” on the left side menu. Now on the settings page we need to enter the domain where your app will be used.<br>Ensure you DO NOT have any other characters before or after the domain.<br>Once you have entered this, click “Save Changes”.</p>
            </li>
            <li>
                <strong>Copy your App ID & App Secret Key from Facebook.</strong>
                <p>Your app is now fully setup. First you need to copy your App ID from Facebook.  At the top of your Settings page or the Dashboard for your App you should see the App ID number.  Copy this number to a text document or to your computer clipboard (the easiest way to do this is to highlight the number and right-click your mouse and select “Copy”</p>
            </li>
        </ul>
    </div>

</div>
