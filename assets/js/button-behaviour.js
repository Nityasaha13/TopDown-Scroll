jQuery(document).ready(function($) {
    var $topButton = $('#td-scroll-to-top');
    var $downButton = $('#td-scroll-to-down');

    function toggleScrollButtons() {
        var scrollTop = $(window).scrollTop();
        var documentHeight = $(document).height();
        var windowHeight = $(window).height();
        var scrollPercent = (scrollTop / (documentHeight - windowHeight)) * 100;

        // Show the top button if scrolled more than 10%
        if (scrollPercent > 15) {
            $topButton.show();
        } else {
            $topButton.hide();
        }

        // Show the down button if not within bottom 10%
        if (scrollPercent < 85) {
            $downButton.show();
        } else {
            $downButton.hide();
        }
    }

    // Initial check
    toggleScrollButtons();

    // Check on scroll
    $(window).on('scroll', function() {
        toggleScrollButtons();
    });
});
