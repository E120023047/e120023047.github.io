'use strict';
/*
window.REMODAL_GLOBALS = {
   NAMESPACE: 'remodal',
   DEFAULTS: {
      hashTracking: false
   }
};
*/

window.ModalResponsive = {


    loadURL: function(url, width, name) {

        if (!name)
            name = '';

        var $HTML = $('<div class="' + name + '"><button data-remodal-action="close" class="remodal-close"></button><div class="remodal-content"><p style="font-size:12px;line-height:1.2;margin:18px 0 0 0;">Chargement en cours</p><img src="/assets/images/loader/load.gif"></div></div>');

        if (!isNaN(width) && width > 0)
            $HTML.css('max-width', width);

        var popup = $HTML.remodal();
        popup.open();
        $HTML.one('closed', function() {
            popup.destroy();
        });

        // setTimeout( function() {
        $('.remodal-content', $HTML).load(url, function(response, status, xhr) {
            if (status == "error")
                $(this).html('<p class="bold">Une erreur est survenue lors du chargement !</p>');
            else if (!$.trim($(this).html()))
                $(this).html('<p class="bold">Aucun contenu n\'a été trouvé !</p>');
        });
        // }, 2000);
    }

};


$(function() {
    $('.modal-r-link').on('click', function(e) {
        e.preventDefault();
        ModalResponsive.loadURL(
            decodeURI($(this).data('modal-link') || $(this).prop('href')),
            parseInt($(this).data('modal-width') || 0, 10),
            $(this).data('modal-name') || ''
        );
    });
});