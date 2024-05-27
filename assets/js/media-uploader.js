jQuery(document).ready(function($){
    function handleMediaUploader(buttonClass, hiddenFieldId, previewDivId, removeLinkId) {
        $( 'body' ).on( 'click', buttonClass, function( event ){
            event.preventDefault();
            const button = $(this);
            const imageId = $(hiddenFieldId).val();
            const customUploader = wp.media({
                title: 'Insert image',
                library : { type : 'image' },
                button: { text: 'Use this image' },
                multiple: false
            }).on( 'select', function() {
                const attachment = customUploader.state().get( 'selection' ).first().toJSON();
                $(hiddenFieldId).val( attachment.url );
                $(previewDivId).html( '<img src="' + attachment.url + '" style="width: 30px; height: 30px;">');
                $(removeLinkId).show();
            });

            customUploader.on( 'open', function() {
                if( imageId ) {
                    const selection = customUploader.state().get( 'selection' );
                    const attachment = wp.media.attachment( imageId );
                    attachment.fetch();
                    selection.add( attachment ? [attachment] : [] );
                }
            });

            customUploader.open();
        });

        $( 'body' ).on( 'click', removeLinkId, function( event ){
            event.preventDefault();
            $(hiddenFieldId).val('');
            $(previewDivId).html('');
            $(this).hide();
        });
    }

    handleMediaUploader('.rudr-upload#upload_top_button_icon', '#top_button_icon_url', '#top_button_icon_preview', '#remove_top_button_icon');
    handleMediaUploader('.rudr-upload#upload_down_button_icon', '#down_button_icon_url', '#down_button_icon_preview', '#remove_down_button_icon');
});
