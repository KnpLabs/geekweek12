(function($){

    $('.table-hover TR[data-url]').click(function()
    {
        document.location.href = $(this).data('url');
    });

})(jQuery);