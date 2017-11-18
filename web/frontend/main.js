/**
 * Created by deepson on 17.11.17.
 */
!(function ($) {

    if (typeof jQuery === 'undefined') {
        throw new Error('You must include the jquery.js (https://jquery.com/download/)');
    }
    $(function () {
        $('#shortifier_form').on('submit', function (event) {

            event.preventDefault();

            const block = document.getElementById('js-alert');
            block.innerHTML = '';

            $.ajax({
                method: 'GET',
                url: 'add',
                data: $('#inp_link').serialize(),
                success: data => {
                    $('#response_placeholder').prepend(data);
                },
                error: msg => {

                    block.innerHTML = msg.responseText;
                }
            });

        });
        $('#inp_link').on('focus', function (event) {
            $('.input_wrap').addClass('js-input-focus');
        });
        $('#inp_link').on('focusout', function (event) {
            $('.input_wrap').removeClass('js-input-focus');
        });
    });

})(jQuery);