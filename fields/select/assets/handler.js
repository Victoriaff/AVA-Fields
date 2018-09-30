AVAFields.addHandler('select', {
    get: function ($group) {
        return  $group.find('select').val();
    }
});