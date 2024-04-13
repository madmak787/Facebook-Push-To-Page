<div class="splash-container row">
    <div class="col-md-6 user-message">
        <span class="splash-message text-right">Hello!<br> Please login<br>to access<br>the panel.</span>
    </div>
    <div class="col-md-6 form-message">
        <span class="splash-description text-center mt-5 mb-5">Login to your account</span>
        <form>
            <div class="form-group">
                <div class="input-group">
                    <div class="input-group-prepend"><i class="icon s7-user"></i></div>
                    <input class="form-control" id="username" type="text" placeholder="Username" autocomplete="off">
                </div>
            </div>
            <div class="form-group">
                <div class="input-group">
                    <div class="input-group-prepend"><i class="icon s7-lock"></i></div>
                    <input class="form-control" id="password" type="password" placeholder="Password">
                </div>
            </div>
            <div class="form-group login-submit">
                <button type="button" class="btn btn-lg btn-primary btn-block" onclick="fpp_login()">Login</button>
            </div>
            <div class="form-group row login-tools">
                <div class="col-sm-6 login-remember">
                    <label class="custom-control custom-checkbox mt-2">
                        <input class="custom-control-input" type="checkbox" id="remember">
                        <span class="custom-control-label">Remember me</span>
                    </label>
                </div>
            </div>
        </form>
        <div class="out-links"><a href="#">© <?=date('Y')?> <?=bloginfo('name')?></a></div>
    </div>
</div>