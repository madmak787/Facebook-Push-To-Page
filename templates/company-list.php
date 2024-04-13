<div class="row">
	<div class="col-sm-12">
		<div class="card card-default card-table">
			<div class="row table-filters-container">
				<div class="col-12 col-lg-12 col-xl-6">
					<div class="row">
						<div class="col-12 col-md-6 col-lg-6 table-filters pb-0 pb-xl-4">
							<h2>Companies List</h2>
						</div>
						<div class="col-12 col-md-6 col-lg-6 table-filters pb-0 pb-xl-4"></div>
					</div>
				</div>
				<div class="col-12 col-lg-12 col-xl-6">
					<div class="row">
						<div class="col-12 col-md-6 col-lg-6 table-filters pb-0 pb-xl-4"></div>
						<div class="col-12 col-md-6 col-lg-6 table-filters pb-xl-4">
							<div class="filter-container">
								<form id="search" action="#" method="POST">
									<div class="row">
										<div class="col-12 col-sm-12 col-lg-12">
											<div class="input-group mb-2">
												<input class="form-control" type="text" id="s" placeholder="Company Name...">
												<div class="input-group-append">
													<button class="btn btn-primary" type="submit">Go!</button>
												</div>
											</div>
										</div>
									</div>
								</form>
							</div>
						</div>
					</div>
				</div>
			</div>
			
			<div class="card-body">
				<div class="table-responsive noSwipe">
					<table class="table table-striped table-hover">
						<thead>
							<tr>
								<th style="width:20%;">Title</th>
								<th style="width:17%;">Facebook Page ID</th>
								<th style="width:15%;">City</th>
								<th style="width:10%;">State</th>
								<th style="width:10%;">Email</th>
								<th style="width:10%;"></th>
							</tr>
						</thead>
						<tbody id="companies-data">
							<tr>
								<td colspan="6"><div id="loader"></div></td>
							</tr>
						</tbody>
					</table>
				</div>
			</div>
		</div>
	</div>
</div>
