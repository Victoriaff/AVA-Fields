AVAFields.addHandler( 'text', {
    get: function(group) {
        return group.find('input').val();
    }
});

AVAFields.addHandler( 'textarea', {
    get: function(group) {
        return group.find('textarea').val();
    }
});

AVAFields.addHandler('checkbox', {
    get: function ($group) {
        if ($group.find('input:checked').length > 0) {
            return 'yes';
        } else {
            return 'no';
        }
    }
});

AVAFields.addHandler('radio', {
    get: function ($group) {
        var $radio = $group.find('input:checked');

        if ($radio.length > 0) {
            return $radio.val();
        } else {
            return '';
        }
    }
});

AVAFields.addHandler('select', {
    get: function ($group) {
        return  $group.find('select').val();
    }
});

