<nav class="navbar navbar-expand-lg mai-sub-header">
	<div class="container">
		<nav class="navbar navbar-expand-md">
			<button class="navbar-toggler hidden-md-up collapsed" type="button" data-toggle="collapse"
				data-target="#mai-navbar-collapse" aria-controls="mai-navbar-collapse"
				aria-expanded="false" aria-label="Toggle navigation"> <span
					class="icon-bar"><span></span><span></span><span></span></span></button>
			<div class="navbar-collapse collapse mai-nav-tabs" id="mai-navbar-collapse">
				<ul class="nav navbar-nav">
					<li class="nav-item parent open">
						<a class="nav-link" href="#companies">
							<span class="icon s7-culture"></span><span>Companies</span>
						</a>
					</li>
					<li class="nav-item parent">
						<a class="nav-link" href="#add-company">
							<span class="icon s7-note"></span><span>Add Company</span>
						</a>
					</li>
					<li class="nav-item parent">
						<a class="nav-link" href="#posts">
							<span class="icon s7-news-paper"></span><span>Posts</span>
						</a>
					</li>
					<li class="nav-item parent">
						<a class="nav-link" href="#fpp">
							<span class="icon s7-paper-plane"></span><span>FPP</span>
						</a>
					</li>
					<li class="nav-item parent">
						<a class="nav-link" href="#settings">
							<span class="icon s7-tools"></span><span>Settings</span>
						</a>
					</li>
					<li class="nav-item parent logout">
						<a class="nav-link logout-link" href="<?php echo wp_logout_url( get_permalink() ); ?>">
							<span class="icon s7-lock"></span><span>Logout</span>
						</a>
					</li>
				</ul>
			</div>
		</nav>
	</div>
</nav>