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

            $.ajax({
                method: 'GET',
                url: 'add',
                data: $('#inp_link').serialize(),
                success: data => {
                    $('#response_placeholder').prepend(data);
                },
            });

        });
    });
})(jQuery);