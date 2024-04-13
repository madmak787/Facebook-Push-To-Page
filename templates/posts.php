<div class="row">
	<div class="col-sm-12">
		<div class="card card-default card-table">
			<div class="row table-filters-container" id="fpp-filters">
				<div class="col-12 col-lg-12 col-xl-6">
					<div class="row">
						<div class="col-12 col-md-6 col-lg-6 table-filters pb-0 pb-xl-4">
							<h2>Facebook Posts</h2>
						</div>
						<div class="col-12 col-md-6 col-lg-6 table-filters pb-0 pb-xl-4">
							<span class="table-filter-title">Company</span>
							<div class="filter-container">
								<label class="control-label">Select a company:</label>
								<select class="select2" name="filter-company_id">
									<option value="">All</option>
									<?php
									global $wpdb;
									$table_company = $wpdb->prefix . FPP_TABLE_COMPANY;
									$sql = "SELECT * FROM $table_company WHERE `user_id` = '".get_current_user_id()."'";
									$companies = $wpdb->get_results($sql, ARRAY_A);
									// The Loop
									foreach($companies as $company) {
									?>
										<option value="<?=$company['id']?>"><?=$company['title']?></option>
									<?php 
									}
									?>
								</select>
							</div>
						</div>
					</div>
				</div>
				<div class="col-12 col-lg-12 col-xl-6">
					<div class="row">
						<div class="col-12 col-md-6 col-lg-6 table-filters pb-0 pb-xl-4">
							<span class="table-filter-title">Date</span>
							<div class="filter-container">
								<div class="row">
									<div class="col-6">
										<label class="control-label">Since:</label>
										<input class="form-control datepicker" name="filter-from" type="text">
									</div>
									<div class="col-6">
										<label class="control-label">To:</label>
										<input class="form-control datepicker" name="filter-to" type="text">
									</div>
								</div>
							</div>
						</div>
						<div class="col-12 col-md-6 col-lg-6 table-filters pb-xl-4">
							<span class="table-filter-title">Post Title</span>
							<div class="filter-container">
								<div class="row">
									<div class="col-12 col-sm-12 col-lg-12">
										<label class="control-label">&nbsp;</label>
										<div class="input-group mb-2">
											<input class="form-control" type="text" name="filter-title" placeholder="Post Title...">
											<div class="input-group-append">
												<button class="btn btn-primary fpp-filter" type="button">Go!</button>
											</div>
										</div>
									</div>
								</div>
							</div>
						</div>
					</div>
				</div>
			</div>
			
			<div class="card-body">
				<div class="table-responsive noSwipe">
					<table id="fpp-posts" class="table table-striped table-hover">
						<thead>
							<tr>
								<th style="width:20%;">Company</th>
								<th style="width:17%;">Post Title</th>
								<th style="width:15%;">Image</th>
								<th style="width:10%;">Posted Date</th>
								<th style="width:10%;"></th>
							</tr>
						</thead>
						<tbody id="fpp_posts"></tbody>
					</table>
				</div>
			</div>
		</div>
	</div>
</div>
