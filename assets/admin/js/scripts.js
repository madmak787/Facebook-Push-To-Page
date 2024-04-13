window.addEventListener('DOMContentLoaded', event => {

    // Toggle the side navigation
    const sidebarToggle = document.body.querySelector('#sidebarToggle');
    if (sidebarToggle) {
        // Uncomment Below to persist sidebar toggle between refreshes
        // if (localStorage.getItem('sb|sidebar-toggle') === 'true') {
        //     document.body.classList.toggle('sb-sidenav-toggled');
        // }
        sidebarToggle.addEventListener('click', event => {
            event.preventDefault();
            document.body.classList.toggle('sb-sidenav-toggled');
            localStorage.setItem('sb|sidebar-toggle', document.body.classList.contains('sb-sidenav-toggled'));
        });
    }

});

jQuery(document).ready(function() {

    jQuery('#template').on('submit', function(e){
        e.preventDefault();
        jQuery('#message').html('');
        jQuery('#fpp-save').prop('disabled',true);
        jQuery('#fpp-save').val('Saving...');
        var data = jQuery(this).serialize();
        jQuery.post( admin_ajax, data, function(response) {
            var r = jQuery.parseJSON(response);
            if(r.success) {
                success( r.message );
            } else {
                error( r.message );
            }
            jQuery('#fpp-save').prop('disabled',false);
            jQuery('#fpp-save').val('Save changes');
        });
    });
    
    // Generate username
    jQuery('#user-email').change(function(e) {
        var value = jQuery(this).val();
        var parts = value.split('@');
        var parts_2 = parts[1].split('.');
        var user = parts[0]+parts_2[0];
        var username = user.replace(/[^a-z\d]+/ig, '');
        jQuery('#user-username').val(username);
    });

    // Generate password
    jQuery('#generatePassword').click(function() {
        var gpb = jQuery(this);
        gpb.addClass('loading');
        var data = {
            'action' : 'fpp_generate_password'
        }
        jQuery.post( admin_ajax, data, function(response) {
            gpb.parent().find('input').val(response);
            gpb.removeClass('loading');
        });
    });

    // Register new user
    jQuery('#adduser').submit(function(e) {
        e.preventDefault();
        var auf = jQuery(this);
        auf.find('button[name="fpp_action"]').addClass('loading');
        var data = auf.serialize();
        jQuery.post( admin_ajax, data, function(response) {
            var r = jQuery.parseJSON(response);
            if(r.success) {
                success(r.message);
                if(typeof r.result.redirect != 'undefined') {
                    window.location.href = r.result.redirect;
                }
            } else {
                error(r.message);
            }
            auf.find('button[name="fpp_action"]').removeClass('loading');
        });
    });

    // Register new company
    jQuery('#addcompany').submit(function(e) {
        e.preventDefault();
        var auf = jQuery(this);
        auf.find('button[name="fpp_action"]').addClass('loading');
        var data = auf.serialize();
        jQuery.post( admin_ajax, data, function(response) {
            var r = jQuery.parseJSON(response);
            if(r.success) {
                success(r.message);
                if(typeof r.result.redirect != 'undefined') {
                    window.location.href = r.result.redirect;
                }
            } else {
                error(r.message);
            }
            auf.find('button[name="fpp_action"]').removeClass('loading');
        });
    });
});

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

function success(str) {
    var html = `<div class="alert alert-success" role="alert">${str}<button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button></div>`;
    jQuery('#wpbody-content').prepend(html);
}

function error(str) {
    var html = `<div class="alert alert-danger" role="alert">${str}<button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button></div>`;
    jQuery('#wpbody-content').prepend(html);
}