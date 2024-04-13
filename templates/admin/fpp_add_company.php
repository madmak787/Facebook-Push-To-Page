<?php
if(isset($_GET['edit'])) {
    global $wpdb;
    $table_company = $wpdb->prefix . FPP_TABLE_COMPANY;
    $sql = "SELECT * FROM $table_company WHERE `id`='".$_GET['edit']."'";
    $company = $wpdb->get_row($sql, ARRAY_A);
} else {
    $company = array(
        'title'=>'',
        'facebook_page_id'=>'',
        'user_id'=>'',
        'shortcodes'=>'',
    );
}
?>
<div class="container">
    <div class="row justify-content-center">
        <div class="col-lg-12">
            <div class="card shadow-lg border-0 rounded-lg mt-5">
                <div class="card-header"><h3 class="text-center font-weight-light my-4"><?=isset($_GET['edit'])?'Update Company':'Add New Company'?></h3></div>
                <div class="card-body">
                    <form id="addcompany" action="" method="POST">
                        <div class="row mb-3">
                            <div class="col-md-6">
                                <label for="user-email">Company Name <em>*</em></label>
                                <input class="form-control" type="text" name="title" value="<?=$company['title']?>" />
                            </div>
                            <div class="col-md-6">
                                <label for="inputLastName">Facebook Page ID <em>*</em></label>
                                <input class="form-control" type="text" name="facebook_page_id" value="<?=$company['facebook_page_id']?>" />
                            </div>
                        </div>
                        <div class="row mb-3">
                            <div class="col-md-12">
                                <table class="shortcodes table table-striped">
                                    <thead>
                                        <tr>
                                            <th width="33.33%">Key</th>
                                            <th width="33.33%">Shortcode</th>
                                            <th width="33.33%">Value</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                    <?php
                                    if( isset($_GET['edit']) && $results = unserialize($company['shortcodes']) ) {
                                        foreach($results as $key=>$value) {
                                            ?>
                                            <tr>
                                                <td><input name="fppkey[]" type="text" id="<?=$key?>" value="<?=$key?>" class="regular-text fpp-key" autocomplete="off" /></td>
                                                <td><input name="fppshortcode[<?=$key?>]" type="text" value="[<?=$key?>]" class="regular-text shortcode" readonly="readonly" /></td>
                                                <td><input name="fppvalue[<?=$key?>]" type="text" value="<?=$value?>" class="regular-text value" autocomplete="off" /></td>
                                            </tr>
                                            <?php
                                        }
                                    } else {
                                        $defaults = get_option('fpp_shortcodes');
                                        foreach($defaults as $key) {
                                            ?>
                                            <tr>
                                                <td><input name="fppkey[]" type="text" id="<?=$key?>" value="<?=$key?>" class="regular-text fpp-key" autocomplete="off" /></td>
                                                <td><input name="fppshortcode[<?=$key?>]" type="text" value="[<?=$key?>]" class="regular-text shortcode" readonly="readonly" /></td>
                                                <td><input name="fppvalue[<?=$key?>]" type="text" value="" class="regular-text value" autocomplete="off" /></td>
                                            </tr>
                                            <?php
                                        }
                                    }
                                    ?>
                                    </tbody>
                                    <tfoot>
                                        <tr>
                                            <td colspan="3">
                                                <input type="button" value="Delete" class="button" onclick="deleteFppValue();">
                                                <input type="button" value="Add" class="button button-primary button-large" onclick="addFppValue()">
                                            </td>
                                        </tr>
                                    </tfoot>
                                </table>
                            </div>
                        </div>
                        <?php
                        if(isset($_GET['edit'])) {?>
                            <input type="hidden" name="company_id" value="<?=$_GET['edit']?>" >
                        <?php }
                        ?>
                        <div class="mt-4 mb-0">
                            <input type="hidden" name="action" value="fpp_admin_add_company" >
                            <div class="d-grid"><button type="submit" class="btn btn-primary btn-block" name="fpp_action" value="<?=isset($_GET['edit'])?'update_company':'add_new_company'?>"><?=isset($_GET['edit'])?'Update Company':'Add New Company'?></button></div>
                        </div>
                    </form>
                </div>
                
            </div>
        </div>
    </div>
</div>
