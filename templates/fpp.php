<div class="row">
	<div class="col-12 col-sm-9">
		<div class="card card-default">
			<div class="card-header card-header-divider">Facebook Post Push</div>
			<div class="card-body pl-sm-5">
				<form action="#" method="post" id="fpp-post">
					
					<div class="form-group row">
						<label class="col-12 col-sm-3 col-form-label text-sm-right">Title for Facebook</label>
						<div class="col-12 col-sm-9 col-lg-8">
							<input class="form-control" type="text" name="fpp_title" value="">
						</div>
					</div>
					<div class="form-group row">
						<label class="col-12 col-sm-3 col-form-label text-sm-right">Body</label>
						<div class="col-12 col-sm-9 col-lg-8">
							<textarea class="form-control post-body" name="fpp_body"></textarea>
						</div>
					</div>
					<div class="form-group row">
						<label class="col-12 col-sm-3 col-form-label text-sm-right">Image</label>
						<div class="col-12 col-sm-9 col-lg-8">
							<input class="form-control" type="text" name="fpp_image" value="">
						</div>
					</div>
					<div class="form-group row">
						<label class="col-12 col-sm-3 col-form-label text-sm-right">Companies</label>
						<div class="col-12 col-sm-9 col-lg-8">
							<div class="custom-controls-stacked mt-2">
								<?php
								global $wpdb;
								$table_company = $wpdb->prefix . FPP_TABLE_COMPANY;
								$sql = "SELECT * FROM $table_company WHERE `user_id` = '".get_current_user_id()."'";
								$companies = $wpdb->get_results($sql, ARRAY_A);
								// The Loop
								foreach($companies as $company) {
								?>
									<label class="custom-control custom-checkbox">
										<input class="custom-control-input" type="checkbox" name="fpp_company[]" value="<?=$company['id']?>"><span class="custom-control-label custom-control-color"><?=$company['title']?></span>
									</label>
								<?php 
								}
								?>
							</div>
						</div>
					</div>
					<div class="form-group row">
						<div class="col-11">
							<p class="text-right">
								<input type="hidden" name="action" value="fpp_post">
								<button class="btn btn-outline-secondary btn-space" type="reset">Reset</button>
								<button type="submit" class="btn btn-space btn-primary">Post To Facebook</button>
							</p>
						</div>
					</div>
					
				</form>
			</div>
		</div>
	</div>
	<div class="col-12 col-sm-3">
		<div class="card card-default">
			<div class="card-header card-header-divider">Available Shortcodes<span class="card-subtitle">Click on it to copy.</span></div>
			<div class="card-body">
				<table id="shortcodes" class="no-border no-strip skills">
					<tbody class="no-border-x no-border-y">
					<?php            
					$defaults = get_option('fpp_shortcodes');
					foreach($defaults as $key) {
						?>
						<tr>
							<td><a href="javascript:fppCopy('[<?=$key?>]')" data-toggle="tooltip" data-placement="top" title="Click To Copy">[<?=$key?>]</a></td>
						</tr>
						<?php
					}
					?>
					</tbody>
				</table>
			</div>
		</div>
	</div>
</div>