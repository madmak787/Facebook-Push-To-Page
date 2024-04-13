<?php
global $wpdb;
$table_company = $wpdb->prefix . FPP_TABLE_COMPANY;
if(isset($_GET['delete'])) {
    $wpdb->delete($table_company, array('id'=>$_GET['delete']));
    echo success('Company deleted successfully.');
}
$sql = "SELECT * FROM $table_company";
$companies = $wpdb->get_results($sql, ARRAY_A);
?>
<div class="container-fluid px-4">
    <h1 class="mt-4">All Companies</h1>
</div>
<div class="container">
    <div class="row justify-content-center">
        <div class="col-lg-12">

            <div class="card mb-4">
                <div class="card-header">
                    <i class="fas fa-table me-1"></i>
                    Companies
                </div>
                <div class="card-body">
                    <table class="datatable-table">
                        <thead>
                            <tr>
                                <th>Name</th>
                                <th>FB Page ID</th>
                                <th>Associated User</th>
                                <th>Created date</th>
                                <th>Action</th>
                            </tr>
                        </thead>
                        <tfoot>
                            <tr>
                                <th>Name</th>
                                <th>FB Page ID</th>
                                <th>Associated User</th>
                                <th>Created date</th>
                                <th>Action</th>
                            </tr>
                        </tfoot>
                        <tbody>
                            <?php
                            foreach($companies as $company) {
                                $user = get_user_by('id', $company['user_id']);
                            ?>
                            <tr>
                                <td><?=$company['title']?></td>
                                <td><?=$company['facebook_page_id']?></td>
                                <td><?=$user->user_login?></td>
                                <td><?=$company['created_date']?></td>
                                <td>
                                    <a href="<?=admin_url( 'admin.php?page=fpp-new-company.php&edit='.$company['id'] )?>" class="btn btn-secondary"><i class="fa fa-pencil-alt"></i></a>
                                    <a href="<?=admin_url( 'admin.php?page=fpp-companies.php&delete='.$company['id'] )?>" class="btn btn-danger"><i class="fa fa-trash-alt"></i></a>
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