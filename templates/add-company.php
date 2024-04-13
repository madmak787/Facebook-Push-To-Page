
<div class="card card-default">
	<div class="card-header card-header-divider">Add New Company</div>
	<div class="card-body pl-sm-5">
		<form method="post" action="#" id="add-company">
			
			<div class="form-group row">
				<label class="col-12 col-sm-3 col-form-label text-sm-right">Company Title</label>
				<div class="col-12 col-sm-8 col-lg-6">
					<input class="form-control" type="text" name="title" value="">
				</div>
			</div>
			<div class="form-group row">
				<label class="col-12 col-sm-3 col-form-label text-sm-right">Facebook Page ID</label>
				<div class="col-12 col-sm-8 col-lg-6">
					<input class="form-control" type="text" name="fb_page_id" value="">
				</div>
			</div>
			<div class="form-group row">
				<div class="col-12">
					<span class="card-subtitle">Shortcodes & Values: </span>
					<table class="table table-striped table-hover shortcodes">
						<thead>
							<tr>
								<th style="width:33.33%;">Key</th>
								<th style="width:33.33%;">Shortcode</th>
								<th style="width:33.33%;">Value</th>
							</tr>
						</thead>
						<tbody>
							<?php
							$defaults = get_option('fpp_shortcodes');
							foreach($defaults as $key) {
								?>
								<tr>
									<td><input name="fppkey[]" type="text" id="<?=$key?>" value="<?=$key?>" class="form-control fpp-key" autocomplete="off" /></td>
									<td><input name="fppshortcode[<?=$key?>]" type="text" value="[<?=$key?>]" class="form-control shortcode" readonly="readonly" /></td>
									<td><input name="fppvalue[<?=$key?>]" type="text" value="" class="form-control value" autocomplete="off" /></td>
								</tr>
								<?php
            				}
							?>
						</tbody>
						<tfoot>
							<tr>
								<td colspan="3">
									<button class="btn btn-xs btn-color btn-pinterest" type="button" onclick="deleteFppValue();"><i class="icon s7-close"></i></button>
									<button class="btn btn-xs btn-color btn-behance" type="button" onclick="addFppValue()"><i class="icon s7-plus"></i></button>
								</td>
							</tr>
						</tfoot>
					</table>
				</div>
			</div>
			<div class="form-group row">
				<div class="col-12 col-sm-12 col-lg-12">
					<p class="text-right">
						<input type="hidden" name="action" value="fpp_add_company">
						<button type="reset" class="btn btn-outline-secondary btn-space">Reset</button>
						<button type="submit" class="btn btn-space btn-primary">Add Company</button>
					</p>
				</div>
			</div>
			
		</form>
	</div>
</div>