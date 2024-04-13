<?php
if(isset($_GET['edit'])) {
    $user = get_user_by('id', $_GET['edit']);
} else {
    $user = (object) array();
    $user->user_email = '';
    $user->user_login = '';
    $user->first_name = '';
    $user->last_name = '';
}
?>
<div class="container">
    <div class="row justify-content-center">
        <div class="col-lg-12">
            <div class="card shadow-lg border-0 rounded-lg mt-5">
                <div class="card-header"><h3 class="text-center font-weight-light my-4"><?=isset($_GET['edit'])?'Update User':'Add New User'?></h3></div>
                <div class="card-body">
                    <form id="adduser" action="" method="POST">
                        <div class="mb-3">
                            <label for="user-email">Email address <em>*</em></label>
                            <input class="form-control" type="email" id="user-email" name="user-email" placeholder="name@example.com" value="<?=$user->user_email?>" />
                        </div>
                        <div class="row mb-3">
                            <div class="col-md-6">
                                <label for="inputLastName">Username <em>*</em></label>
                                <input class="form-control" id="user-username" name="user-username" type="text" placeholder="Enter username" value="<?=$user->user_login?>" <?=isset($_GET['edit'])?'disabled="disabled"':''?> />
                            </div>
                            <div class="col-md-6">
                                <label for="inputPassword">Password <em>*</em></label>
                                <div class="input-group">
                                    <input class="form-control" id="password" name="user-password" type="text" placeholder="<?=isset($_GET['edit'])?'Leave empty for unchanged':'Create a password'?>" value="" />
                                    <button class="btn btn-primary" id="generatePassword" type="button" title="Generate Password"><i class="fa fa-sync"></i></button>
                                </div>
                            </div>
                        </div>
                        <div class="row mb-3">
                            <div class="col-md-6">
                                <label for="inputFirstName">First name</label>
                                <input class="form-control" id="firstname" name="user-firstname" type="text" placeholder="Enter first name" value="<?=$user->first_name?>" />
                            </div>
                            <div class="col-md-6">
                                <label for="inputLastName">Last name</label>
                                <input class="form-control" id="lastname" name="user-lastname" type="text" placeholder="Enter last name" value="<?=$user->last_name?>" />
                            </div>
                        </div>
                        <?php
                        if(empty($_GET['edit'])) {?>
                        <div class="mb-3 form-check">
                            <input class="form-check-input" type="checkbox" name="notify-user" value="1" checked>
                            <label class="form-check-label" for="notify-user">Send the new user an email about their account.</label>
                        </div>
                        <?php } else {?>
                            <input type="hidden" name="user_id" value="<?=$_GET['edit']?>" >
                        <?php }?>
                        <div class="mt-4 mb-0">
                            <input type="hidden" name="action" value="fpp_add_user" >
                            <div class="d-grid"><button type="submit" class="btn btn-primary btn-block" name="fpp_action" value="<?=isset($_GET['edit'])?'update_user':'add_new_user'?>"><?=isset($_GET['edit'])?'Update User':'Add New User'?></button></div>
                        </div>
                    </form>
                </div>
                
            </div>
        </div>
    </div>
</div>
