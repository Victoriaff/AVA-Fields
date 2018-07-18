(function ($) {
    "use strict";

    // Change section
    $('body').on('click', '.avaf-nav-item:not(.active)', function(e) {
        e.preventDefault();

        var $container = $(this).parents('.avaf-container');
        var section = $(this).data('section');

        $container.find('.avaf-nav-item, .avaf-section').removeClass('active');
        $container.find('.avaf-nav-item[data-section='+section+'], .avaf-section[data-section='+section+']').addClass('active');
    });

    function get_value($this) {
        if ($this.is('input')) return $this.val();
        if ($this.is('textarea')) return $this.val();
    }

    // Save data
    $('body').on('click', '.avaf-save', function(e) {
        e.preventDefault();

        var $container = $(this).parents('.avaf-container');

        var data = {};

        $container.find('.avaf-section.active').find('.avafl-save').each( function() {
            var name = $(this).attr('name');
            var option = $(this).data('option');
            if (option==undefined) option = name;
            //console.log(option);


            if (name==option) {
                data[option] = get_value($(this));
            } else {
                data[option] = {};
                data[option][name] = get_value($(this));
            }
        });

        console.log(data);
        console.log(JSON.stringify(data));
        var c = JSON.stringify(data);
        console.log(c);



        var data = {
            'action': 'avaf-save',
            'option_name': $container.data('option_name'),
            'data': JSON.stringify(data),
            //'_ajax_nonce': EHAccountPanel._ajax_nonce
        };
        console.log(data);

        //return;

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

