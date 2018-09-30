
AVAFields.addHandler( 'textarea', {
    get: function(group) {
        return group.find('textarea').val();
    }
});