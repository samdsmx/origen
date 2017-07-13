jQuery(document).ready(function() {
    $('.btn-cse-reset').on('click', function(e) {
        $(this).closest('form').parent().find('.cse-search-results').html('');
    });

    !function(d, s, id) {
        var js, fjs = d.getElementsByTagName(s)[0];
        p = /^http:/.test(d.location) ? 'http' : 'https';

        if (!d.getElementById(id)) {
            js = d.createElement(s);
            js.id = id;
            js.src = p + '://platform.twitter.com/widgets.js';
            fjs.parentNode.insertBefore(js, fjs);
        }
    }(document, "script", "twitter-wjs");

    $("#imageLoad").fileinput({
        showCaption: true,
        showRemove: false,
        showUpload: false,
        maxFileSize: 5000,
        previewFileType: "image",
        browseClass: "btn btn-info",
        browseLabel: "Examinar",
        browseIcon: "<i class=\"fa fa-folder fa-lg\"></i> "
    });
    
    $("#archivoLoad").fileinput({
        showCaption: true,
        showRemove: false,
        showUpload: false,
        maxFileSize: 5000,
        previewFileType: "text",
        browseClass: "btn btn-info",
        browseLabel: "Examinar",
        browseIcon: "<i class=\"fa fa-folder fa-lg\"></i> "
    });

    $('.navigate-top a').click(function() {
        $('body,html').animate({
            scrollTop: 0
        }, 800);

        return false;
    });

    $(function() {
        $("[data-toggle=\'tooltip\']").tooltip();
    });

    $(function() {
        $("[data-toggle=\'popover\']").popover();
    });

    $('body').on('click', function(e) {
        if ($(e.target).data('toggle') !== 'popover' && $(e.target).parents('.popover.in').length === 0) {
            $('[data-toggle="popover"]').popover('hide');
        }
    });

    if ($('.adsbygoogle').filter(':visible').length == 0) {
        $('.adblock-msg').slideDown('slow');
    }

    $('.adblock-msg .close').on('click', function(e) {
        $('.adblock-msg').slideUp('slow');
    });
});