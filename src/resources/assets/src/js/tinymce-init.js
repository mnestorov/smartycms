$(function () {
    tinymce.init({
        oninit : "setPlainText",
        selector:'.htmlEditor',
        plugins: ["lists link charmap code media table image paste textcolor"],
        fontsize_formats: "8px 10px 12px 13px 14px 15px 16px 18px 24px 36px",
        toolbar1: "styleselect | fontsizeselect | forecolor bold italic | alignleft aligncenter alignright alignjustify | bullist numlist | link unlink table media image uploadimage | charmap code",
        menubar : false,
        branding: false,
        mobile: {
            theme: 'mobile',
            plugins: [ 'autosave', 'lists', 'autolink', 'image', 'paste', 'textcolor', 'media' ]
        },        
        relative_urls : true,
        convert_urls: true,
        remove_script_host : true,
        document_base_url : _baseUrl+'/',
        setup: function(editor) {
            editor.addButton('uploadimage', {
                title: 'Upload image',
                text: '+',
                icon: false,
                onclick: function() {
                    tinyUploadImage(editor);
                }
            });
        }
    });

    function tinyUploadImage(editor){
        var overlay = $("<div>").addClass("tiny-upload-overlay").css({
            position: 'fixed',
            width: '100%',
            height: '100%',
            top: 0,
            left: 0,
            background: "rgba(0,0,0,0.4)",
            zIndex: 9999
        });

        overlay.append('<iframe src="tiny-images?editor_id='+editor.id+'&page_name='+$('#'+editor.id).data('page-name')+'&page_id='+$('#'+editor.id).data('page-id')+'" frameborder="0" style="width:100%;height:100%">');

        overlay.find("iframe").scroll(function(event) {
            event.stopPropagation();
        });

        $("body").append(overlay);
    }
});