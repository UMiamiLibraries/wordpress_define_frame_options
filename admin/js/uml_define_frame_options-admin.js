(function( $ ) {
	'use strict';

    $(window).load(function () {
        $.post(admin_url.ajax_url, { action: 'get_info'}).done(function(data) {
			var info = JSON.parse(data);

			if (info.length > 0) {
				var option = info[0].option;
                $("ul").find("[case='" + option + "'] input").prop('checked', true);

                if (option === 'ALLOW-FROM'){
                    var allow_from = info[0].allow_from;
                    $("#url").val(allow_from);
                }
            }
        });

        $("li").on('click', function(){
            $('[type=radio]:checked').prop('checked', false);
            $(this).find('input').prop('checked', true);

            $('#save_changes').text('Save changes');
            $('#save_changes').removeClass("inactive_button");
            $('#save_changes').removeAttr('disabled');
        });

        $("#save_changes").on('click', function(){
        	var option = $('input:checked').parent().attr("case");
        	var trusted_url = $('#url').val();

        	if (option === 'ALLOW-FROM'){
        		if (!trusted_url){
        			alert('Please insert a trusted URL');
        			return;
				}
			}
            $.post(admin_url.ajax_url, { action: 'save_option', case: option.toUpperCase(), trusted_url: trusted_url}).done(function(data) {

                $('#save_changes').text('Saved!');
                $('#save_changes').addClass('inactive_button');
            });
        });
    });



})( jQuery );
