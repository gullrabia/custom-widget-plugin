jQuery(document).ready(function ($) {

    function toggleFields(widget) {
        var value = widget.find('.mcw-display-type').val();

        if (value === 'recent_posts') {
            widget.find('.mcw-post-count').show();
            widget.find('.mcw-message-field').hide();
        } else {
            widget.find('.mcw-post-count').hide();
            widget.find('.mcw-message-field').show();
        }
    }

    // On change
    $(document).on('change', '.mcw-display-type', function () {
        toggleFields($(this).closest('.widget-content'));
    });

    // On load (important!)
    $('.widget-content').each(function () {
        toggleFields($(this));
    });

});
