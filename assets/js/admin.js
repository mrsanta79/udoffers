const app = new Vue({
    el: '#app',
    data: {
        isCreatingField: false,
        isCreatingOffer: false,
        createOfferForm: {
            date: '',
            country: '',
            entry_type: '',
            winners_count: '',
            shop: '',
            discount: '',
            information: '',
            map_link: ''
        }
    },
    created() {

    },
    methods: {
        createOffer: function(e) {
            const url = e.target.action;
            const post = e.target.method;
        },
        createField: function(e) {
            const url = e.target.action;
            const post = e.target.method;
        }
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