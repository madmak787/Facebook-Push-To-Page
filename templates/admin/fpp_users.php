<?php
if(isset($_GET['delete'])) {
    wp_delete_user( $_GET['delete'] );
    echo success('User deleted successfully.');
}

$args = array(
    'role'    => 'fpp',
    'orderby' => 'user_nicename',
    'order'   => 'ASC'
);
$users = get_users( $args );
?>
<div class="container-fluid px-4">
    <h1 class="mt-4">Registered Users</h1>
</div>
<div class="container">
    <div class="row justify-content-center">
        <div class="col-lg-12">

            <div class="card mb-4">
                <div class="card-header">
                    <i class="fas fa-table me-1"></i>
                    Registered FPP Users
                </div>
                <div class="card-body">
                    <table class="datatable-table">
                        <thead>
                            <tr>
                                <th>Name</th>
                                <th>Username</th>
                                <th>Email</th>
                                <th>Created date</th>
                                <th>Action</th>
                            </tr>
                        </thead>
                        <tfoot>
                            <tr>
                                <th>Name</th>
                                <th>Username</th>
                                <th>Email</th>
                                <th>Created date</th>
                                <th>Action</th>
                            </tr>
                        </tfoot>
                        <tbody>
                            <?php
                            foreach($users as $user) {
                            ?>
                            <tr>
                                <td><?=$user->display_name?></td>
                                <td><?=$user->user_login?></td>
                                <td><?=$user->user_email?></td>
                                <td><?=$user->user_registered?></td>
                                <td>
                                    <a href="<?=admin_url( 'admin.php?page=add-user.php&edit='.$user->ID )?>" class="btn btn-secondary"><i class="fa fa-pencil-alt"></i></a>
                                    <a href="<?=admin_url( 'admin.php?page=fpp-users.php&delete='.$user->ID )?>" class="btn btn-danger"><i class="fa fa-trash-alt"></i></a>
                                </td>
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
</div>