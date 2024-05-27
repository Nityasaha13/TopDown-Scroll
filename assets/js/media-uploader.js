jQuery(document).ready(function($){
    var mediaUploader;
    
    $('#upload_top_button_icon').click(function(e) {
        e.preventDefault();
        mediaUploader = wp.media({
            title: 'Choose Icon',
            button: {
                text: 'Choose Icon'
            },
            multiple: false
        });
        mediaUploader.on('select', function() {
            var attachment = mediaUploader.state().get('selection').first().toJSON();
            $('#top_button_icon_url').val(attachment.url);
            $('#top_button_icon_preview').html('<img src="' + attachment.url + '" style="width: 30px; height: 30px;">');
        });
        mediaUploader.open();
    });
    
    $('#upload_down_button_icon').click(function(e) {
        e.preventDefault();
        mediaUploader = wp.media({
            title: 'Choose Icon',
            button: {
                text: 'Choose Icon'
            },
            multiple: false
        });
        mediaUploader.on('select', function() {
            var attachment = mediaUploader.state().get('selection').first().toJSON();
            $('#down_button_icon_url').val(attachment.url);
            $('#down_button_icon_preview').html('<img src="' + attachment.url + '" style="width: 30px; height: 30px;">');
        });
        mediaUploader.open();
    });
});
