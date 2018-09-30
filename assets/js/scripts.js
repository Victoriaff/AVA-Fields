var AVAFields = {
    data: {},
    handlers: {},

    addHandler: function ( id, handler ) {
        this.handlers[id] = handler;
    },

    init: function () {
    }
}
AVAFields.init();




/*
AVAFields.handlers['textarea'] = function() {
    console.log(1);
};
AVAFields.handlers[handler](3);
*/


(function ($) {
    "use strict";

    // Change section
    $('body').on('click', '.avaf-nav-item:not(.active)', function (e) {
        e.preventDefault();

        var $container = $(this).parents('.avaf-container'),
            section = $(this).data('section');

        $container.find('.avaf-nav-item, .avaf-section').removeClass('active');
        $container.find('.avaf-nav-item[data-section=' + section + '], .avaf-section[data-section=' + section + ']').addClass('active');
    });

    function get_value($this) {
        if ($this.is('input')) return $this.val();
        if ($this.is('textarea')) return $this.val();
    }

    // Save data
    $('body').on('click', '.avaf-save', function (e) {
        e.preventDefault();

        var $container = $(this).parents('.avaf-container');

        AVAFields.data = {};

        $container.find('.avaf-section.active').find('.avaf-group').each(function () {
            var $this = $(this),
                group = $this.data('group'),
                type = $this.data('type');

            console.log(type);

            if (typeof AVAFields.handlers[type] == 'object' ) {

                console.log(AVAFields.handlers[type]);
                AVAFields.data[group] = AVAFields.handlers[type].get($this);
            }
        });
        console.log(AVAFields.data);


        var data = {
            'action': 'avaf-save',
            'option_name': $container.data('option_name'),
            'options': AVAFields.data,
            //'_ajax_nonce': EHAccountPanel._ajax_nonce
        };
        console.log(data);


        //$checked = ehCoreFront.hl_required($form);

        var $checked = true;

        if ($checked) {
            $.ajax({
                url: '/wp-admin/admin-ajax.php',
                type: 'POST',
                dataType: 'json',
                cache: false,
                data: data,
                beforeSend: function () {
                    $('.avaf-preloader').fadeIn();
                },
                success: function (response) {

                    console.log(response);
                    if (response.result == 'ok') {


                    } else {

                    }
                },
                complete: function() {
                    $('.avaf-preloader').fadeOut("slow");
                }
            });
        }


    });


})(window.jQuery);

