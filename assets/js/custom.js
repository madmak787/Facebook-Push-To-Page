jQuery(document).ready(function() {

    checkHash();

    fpp_companies();

    fpp_posts();

    jQuery('#mai-navbar-collapse .nav-link:not(.logout-link)').click(function(e) {
        e.preventDefault();
        fppShowScreen( jQuery(this).attr('href') );
    });

    jQuery(document).on('submit','#search',function(e) {
        e.preventDefault();
        fpp_companies();
    });

    jQuery('select[name="filter-company_id"], input[name="filter-from"], input[name="filter-to"]').change(function(e) {
        e.preventDefault();
        fpp_posts();
    });
    jQuery('.fpp-filter').click(function(e) {
        e.preventDefault();
        fpp_posts();
    });

    jQuery('body').on('keyup','.fpp-key',function() {
        var parent = jQuery(this).parent().parent();
        var key = jQuery(this).val();
        jQuery(this).attr('name','fppkey[]');
        parent.find('.shortcode').attr('name','fppshortcode['+key+']').val('['+key+']');
        parent.find('.value').attr('name','fppvalue['+key+']');
    });

    jQuery('#add-company').submit(function(e) {
        e.preventDefault();
        var frm = jQuery(this);
        frm.find('.btn-primary[type="submit"]').prop('disabled',true).append('<div id="loader"></div>');
        var data = frm.serialize();
        jQuery.post( admin_ajax, data, function(response) {
            var r = jQuery.parseJSON(response);
            if(r.success) {
                notice(r.message,'Success');
                jQuery('#s').val('');
                fpp_companies();
                fppShowScreen( '#companies' );
            } else {
                notice(r.message,'Error');
            }
            frm.find('.btn-primary[type="submit"]').prop('disabled',false).html('Add Company');
            setTimeout(function() {
                frm.trigger("reset");
            },500);
        });
    });

    jQuery('body').on('click','.delete-company',function() {
        if(confirm('Do you really want to delete this company?')) {
            var post_id = jQuery(this).parent().parent().data('id');
            jQuery(this).parent().parent().slideUp();
            notice('Company Deleted Successfully.');
            var data = {
                action: 'fpp_delete_company',
                post_id: post_id
            };
            jQuery.post( admin_ajax, data, function(response) {
                var r = jQuery.parseJSON(response);
                console.log('Company Delete Response:',r.message);
            });
        }
    });

    jQuery('body').on('click','.edit-company',function() {
        jQuery('#edit-company-fields').html('<div id="loader"></div>');
        var post_id = jQuery(this).parent().parent().data('id');
        jQuery('#md-default').modal('show');
        var data = {
            action: 'fpp_edit_company_html',
            post_id: post_id
        };
        jQuery.post( admin_ajax, data, function(response) {
            var r = jQuery.parseJSON(response);
            jQuery('#edit-company-fields').html(r.html);
        });
    });

    jQuery('body').on('click','.delete-post',function() {
        if(confirm('Do you really want to delete this post?')) {
            jQuery(this).html('<div id="loader"></div>');
            var ele = jQuery(this).parent().parent();
            var post_id = ele.data('id');
            var data = {
                action: 'fpp_delete_post',
                post_id: post_id
            };
            jQuery.post( admin_ajax, data, function(response) {
                var r = jQuery.parseJSON(response);
                notice('Post Deleted Successfully.');
                ele.hide();
            });
        }
    });

    jQuery('#update-company').submit(function(e) {
        e.preventDefault();
        var frm = jQuery(this);
        frm.find('.btn-primary[type="submit"]').prop('disabled',true).append('<div id="loader"></div>');
        var data = frm.serialize();
        jQuery.post( admin_ajax, data, function(response) {
            var r = jQuery.parseJSON(response);
            if(r.success) {
                notice(r.message,'Success');
                jQuery('#s').val('');
                fpp_companies();
                fppShowScreen( '#companies' );
                jQuery('#md-default').modal('hide');
            } else {
                notice(r.message,'Error');
            }
            frm.find('.btn-primary[type="submit"]').prop('disabled',false).html('Update');
            setTimeout(function() {
                frm.trigger("reset");
            },500);
        });
    });

    if(jQuery('#fpp-posts').length) {
        jQuery(".select2").select2({
			width: "100%"
		});
        jQuery(".datepicker").datepicker({
			autoclose: !0
		})
    }

    jQuery('#fpp-post').submit(function(e) {
        e.preventDefault();
        var frm = jQuery(this);
        frm.find('.btn-primary[type="submit"]').prop('disabled',true).append('<div id="loader"></div>');
        var data = frm.serialize();
        jQuery.post( admin_ajax, data, function(response) {
            var r = jQuery.parseJSON(response);
            if(r.success) {
                notice(r.message,'Success');
                jQuery('#s').val('');
                fpp_posts();
                fppShowScreen( '#posts' );
            } else {
                notice(r.message,'Error');
            }
            frm.find('.btn-primary[type="submit"]').prop('disabled',false).html('Post To Facebook');
            setTimeout(function() {
                frm.trigger("reset");
            },500);
        });
    });


    /*Theme Fixes*/
    // Find your wrapper HTMLElement
    jQuery('.mai-wrapper .navbar-nav a[property="item"] > li').unwrap();
});

function fppShowScreen(hash='#companies') {
    history.pushState({}, "", hash);

    var nav = jQuery('#mai-navbar-collapse .nav-link[href="'+hash+'"]');
    var i = nav.parent().index();

    jQuery('#mai-navbar-collapse .nav-item').removeClass('open');
    nav.parent().addClass('open');
    jQuery('#mai-navbar-tabs .mai-tab-content').hide();
    jQuery(hash).fadeIn();
    setTimeout(function() {
        jQuery('#mai-navbar-tabs .mai-tab-content').removeClass('active');
        jQuery(hash).addClass('active');
    },1000);
}

function checkHash() {
    if(window.location.hash != '') {
        fppShowScreen(window.location.hash);
    }
}

function fpp_login() {
    var data = {
        action: 'fpp_login',
        username: jQuery('#username').val(),
        password: jQuery('#password').val(),
        remember: jQuery('#remember').val(),
    };
    jQuery.post( admin_ajax, data, function(response) {
        var r = jQuery.parseJSON(response);
        if(r.success) {
            notice(r.message,'Success');
            window.location.reload();
        } else {
            notice(r.message,'Error');
        }
    });
}

function fpp_posts() {
    jQuery('#fpp_posts').html('<tr><td colspan="5"><div id="loader"></div></td></tr>');
    var data = {
        action: 'fpp_posts_list',
        company_id: jQuery('select[name="filter-company_id"]').val(),
        from: jQuery('input[name="filter-from"]').val(),
        to: jQuery('input[name="filter-to"]').val(),
        title: jQuery('input[name="filter-title"]').val(),
    };
    jQuery.post( admin_ajax, data, function(response) {
        var r = jQuery.parseJSON(response);
        if(r.success) {
            jQuery('#fpp_posts').html(r.result);
        } else {
            notice(r.message,'Error');
        }
    });
}

function fpp_companies() {
    jQuery('#companies-data').html('<tr><td colspan="6"><div id="loader"></div></td></tr>');
    var data = {
        action: 'fpp_company_list',
        s: jQuery('#search .form-control').val()
    };
    jQuery.post( admin_ajax, data, function(response) {
        var r = jQuery.parseJSON(response);
        if(r.success) {
            jQuery('#companies-data').html(r.result);
        } else {
            notice(r.message,'Error');
        }
    });
}

function addFppValue(ele='page') {
    var cls = '.shortcodes';
    if(ele=='modal') {
        cls = '.modal-shortcodes';
    }
    var html = jQuery( cls+' tbody tr:last-child' ).clone();
    jQuery( cls+' tbody' ).append( html );
    jQuery( cls+' tbody tr:last-child' ).find( 'input' ).val( '' ).removeAttr( 'id' ).removeAttr( 'name' );
}

function deleteFppValue(ele='page') {
    var cls = '.shortcodes';
    if(ele=='modal') {
        cls = '.modal-shortcodes';
    }
    if( confirm('This shortcode may have been used in another company. Are you sure to delete it (You can leave Value blank if not sure.)') ) {
        jQuery( cls+' tbody tr:last-child' ).remove();
    }
}

function fppCopy(text) {
    notice('"'+text+'" copied to clipboard.')
    navigator.clipboard.writeText(text);
}

function notice(msg,title='Notice') {
    jQuery.extend(jQuery.gritter.options, {
        position: "bottom-right"
    }), 
    jQuery.gritter.add({
        title: title,
        text: msg,
        icon: !0,
        class_name: "gritter-social facebook"
    });
    /*
    jQuery('.mai-wrapper .alert').remove();
    var html = `<div class="alert alert-theme alert-info alert-dismissible" role="alert">
            <button class="close" type="button" data-dismiss="alert" aria-label="Close"><span class="s7-close" aria-hidden="true"></span></button>
            <div class="icon"><span class="s7-info"></span></div>
            <div class="message">${msg}</div>
        </div>`;
    jQuery('.mai-wrapper .main-content').prepend(html);
    */
}