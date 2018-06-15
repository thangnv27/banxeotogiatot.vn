/**
 * @Author: Ngo Van Thang
 * @Email: ngothangit@gmail.com
 */
var shortname = "ppo";
function uploadByField(field){
    jQuery(document).ready(function($){
        var custom_uploader;

        //If the uploader object has already been created, reopen the dialog
        if (custom_uploader) {
            custom_uploader.open();
            return;
        }

        //Extend the wp.media object
        custom_uploader = wp.media.frames.file_frame = wp.media({
            title: 'Choose Image',
            button: {
                text: 'Choose Image'
            },
            multiple: false
        });

        //When a file is selected, grab the URL and set it as the text field's value
        custom_uploader.on('select', function() {
            attachment = custom_uploader.state().get('selection').first().toJSON();
            $('#' + field).val(attachment.url);
        });

        //Open the uploader dialog
        custom_uploader.open();
    });
}

// Run
jQuery(document).ready(function($){
//    $("select.chosen-select").chosen({width: "38%"});

    $("#ppo_useUberMenu").change(function (){
        if($(this).is(':checked') && !$("#ppo_menuEnabled").is(':checked')){
            $("#ppo_menuEnabled").attr('checked', true);
        }
    });
    
    $('#' + shortname + '_primaryColor, #' + shortname + '_primaryBigColor, #' + shortname + '_primaryBigBgColor, #' + shortname + '_linkColor, #' + shortname + '_linkHVColor, #' + shortname + '_secondaryColor, #' + shortname + '_linkMenu, #' + shortname + '_linkHVMenu,#' + shortname + '_footerColor,#' + shortname + '_footerBgColor, #' + shortname + '_bgColor, #tag_meta_color').each(function(){
        var $el = $(this);
        $el.css({
            width: 100,
            height:36,
            'float':'left',
            margin:'0 0 0 -3px'
        })
        .before('<div class="colorSelector"><div style="background-color:#' + $el.val() + '"></div></div>')
        .after('<div style="clear:both;"></div>')
        .ColorPicker({
            onSubmit: function(hsb, hex, rgb, el) {
                $(el).val(hex);
                $(el).ColorPickerHide();
            },
            onBeforeShow: function () {
                $(this).ColorPickerSetColor(this.value);
                $(this).prev('div.colorSelector').children('div').css('backgroundColor', '#' + this.value);
            },
            onChange: function (hsb, hex, rgb) {
                $el.val(hex).prev('div.colorSelector').children('div').css('backgroundColor', '#' + hex);
            }
        })
        .bind('keyup', function(){
            $(this).ColorPickerSetColor(this.value);
            $(this).prev('div.colorSelector').children('div').css('backgroundColor', '#' + this.value);
        })
        .prev('div.colorSelector').click(function(){
            $(this).next('input').click();
        });
    });
    
});