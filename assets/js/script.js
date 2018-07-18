(function ($) {
    "use strict";

    // Change secction
    $('body').on('click', '.avaf-nav-item:not(.active)', function(e) {
        e.preventDefault();

        var section = $(this).data('section');
        $('.avaf-nav-item, .avaf-section').removeClass('active');
        $('.avaf-nav-item[data-section='+section+'], .avaf-section[data-section='+section+']').addClass('active');
    });

    // Save data
    $('body').on('click', '.avaf-save', function(e) {
        e.preventDefault();

        var container = $(this).data('container'),
            data = $('.avaf-form[data-container='+container+']').serialize(),
            $form = $(this).parents('form'),
            container = $form.data('container');

        console.log(data);

        var data = {
            'action': 'avaf-save',
            'container': container,
            'data': data,
            //'_ajax_nonce': EHAccountPanel._ajax_nonce
        };
        console.log(data);

        //$checked = ehCoreFront.hl_required($form);

        var $checked = true;

        if ( $checked ) {
            $.ajax({
                url: '/wp-admin/admin-ajax.php',
                type: 'POST',
                dataType: 'json',
                cache: false,
                data: data,
                beforeSend: function () {
                    
                },
                success: function (response) {

                    console.log(response);
                    if (response.result == 'ok') {
                       

                    } else {
                       
                    }
                }
            });
        }
        
        

        
    });



    // Change information
    /*
    $('body').on('click', '.change-details-btn', function(e) {
        e.preventDefault();
        var $this = $(this), $form = $this.parents('form'), params = $form.serialize(), $checked;
        var $data = {
            'action': 'eh_info',
            'params': params,
            '_ajax_nonce': EHAccountPanel._ajax_nonce
        };

        $checked = ehCoreFront.hl_required($form);

        if ( $checked ) {
            $.ajax({
                url: '/wp-admin/admin-ajax.php',
                type: 'POST',
                dataType: 'json',
                cache: false,
                data: $data,
                beforeSend: function () {
                    $this.addClass('btn-disabled');
                    $this.attr('disabled', 'disabled');
                },
                success: function (response) {

                    if (response.result == 'ok') {
                        ehCoreFront.modal(response);
                        setTimeout(function() {
                            window.location = response.redirect;
                        }, 2000);

                    } else {
                        ehCoreFront.modal(response);

                        $this.removeClass('btn-disabled');
                        $this.attr('disabled', false);
                    }
                }
            });
        }

        return false;
    });
    */

})(window.jQuery);

