
<div class="mai-wrapper alignfull">

	<?php
	if (is_user_logged_in()) {
		include FPP_PLUGIN_PATH . 'templates/navbar.php';
	}
	?>

	<div class="main-content container">
		
		<div class="row">
			<div class="col-sm-12">
				<?php
				if(is_user_logged_in()) {
					?>
					<div id="mai-navbar-tabs">
						<div id="companies" class="mai-tab-content active">
							<?php
							include FPP_PLUGIN_PATH.'templates/company-list.php';
							?>
						</div>
						<div id="add-company" class="mai-tab-content">
							<?php
							include FPP_PLUGIN_PATH.'templates/add-company.php';
							?>
						</div>
						<div id="posts" class="mai-tab-content">
							<?php
							include FPP_PLUGIN_PATH.'templates/posts.php';
							?>
						</div>
						<div id="fpp" class="mai-tab-content">
							<?php
							include FPP_PLUGIN_PATH.'templates/fpp.php';
							?>
						</div>
						<div id="settings" class="mai-tab-content">
							<?php
							include FPP_PLUGIN_PATH.'templates/settings.php';
							?>
						</div>
					</div>
					<?php
				} else {
					include FPP_PLUGIN_PATH.'templates/login.php';
				}
				?>

			</div>
		</div>

	</div>

	<?php
	include FPP_PLUGIN_PATH.'templates/modal.php';
	?>
</div>