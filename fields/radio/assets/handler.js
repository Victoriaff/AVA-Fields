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