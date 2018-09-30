AVAFields.addHandler('checkbox', {
    get: function ($group) {
        if ($group.find('input:checked').length > 0) {
            return 'yes';
        } else {
            return 'no';
        }
    }
});