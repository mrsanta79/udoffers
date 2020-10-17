const app = new Vue({
    el: '#app',
    data: {

    },
    created() {

    },
    methods: {

    }
});

// jQuery operations
$(document).ready(function() {

    // Toggle sidenav bar
    $(document).on('click', '#toggle-sidenav', function(e) {
        e.preventDefault();
        const $sideNav = $('.sidenav');
        const $topNav = $('.navbar');
        const $bodyContainer = $('.container-fluid');

        $sideNav.toggleClass('expanded');
        if($(window).width() >= 767) {
            $topNav.toggleClass('expanded');
            $bodyContainer.toggleClass('expanded');
        }
    });
});