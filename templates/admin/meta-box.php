<table class="form-table" role="presentation">
    <tbody>
        <tr>
            <th scope="row"><label>Facebook Page ID</label></th>
            <td><input name="fb_page_id" type="text" id="fb_page_id" value="<?=get_post_meta($_GET['post'], "fb_page_id", true)?>" class="regular-text"></td>
        </tr>
    </tbody>
</table>
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
        if( isset($_GET['post']) && $results = get_post_meta($_GET['post'], "fpp_value", true) ) {
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
                <input type="button" value="Delete" class="button" onclick="deleteFppValue();" />
                <input type="button" value="Add" class="button button-primary button-large" onclick="addFppValue()" />
            </td>
        </tr>
    </tfoot>
</table>