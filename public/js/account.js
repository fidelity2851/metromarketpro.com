$(document).ready(function () {

    // Toggle Menu Container
    $('#open_menu').click(function () {
        // $('#menu_con') .css('position', 'absolute')
        $('#menu_con').show()
    })
    $('#close_menu').click(function () {
        // $('#menu_con') .css('position', 'relative')
        $('#menu_con').hide()
    })


    $('.drop_menu_link_con').click(function () {
        $(this).find(".drop_menu_link_cont").slideToggle();
    });

    // Referral Copy to Clipboard
    $('#referral_btn').click(function () {
        var $temp = $("<input>");
        $("body").append($temp);

        // Get Referral Link
        $temp.val($('#referral_link').text()).select();

        // Copy the text to Clipboard 
        document.execCommand("copy");
        $temp.remove();

        // Turn Copy text to Copied
        $('#referral_btn').text('Copied!')

        // Reverse the text to Default after 2 Secs
        setTimeout(function () {
            $('#referral_btn').text('Copy Link')
        }, 2000)
    })




    
});