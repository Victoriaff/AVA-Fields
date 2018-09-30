

AVAFields.addHandler( 'text', {
    get: function(group) {
        return group.find('input').val();
    }
});