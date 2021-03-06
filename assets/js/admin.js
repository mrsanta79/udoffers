// Global variables
let offersTable,
    usersTable;

const app = new Vue({
    el: '#app',
    data: {
        isProcessing: false,
        isFetchingData: false,
        offers: null,
        users: null,
        adScript: '',
        offerForm: {
            date: '',
            city: '',
            entry_type: '',
            winners_count: '',
            shop: '',
            discount: '',
            information: '',
            map_link: ''
        },
        cityForm: {
            name: '',
        },
        entryForm: {
            name: '',
            // background: '#424242'
            background: ''
        }
    },
    created() {
        this.getAllOffers();
        this.getAllUsers();
    },
    methods: {
        // Offers
        getAllOffers: function(e) {
            const $table = document.getElementById('offers-table');
            const $tableJq = '#offers-table';

            // Run only on specific page
            if($table === null) {
                return false;
            }

            // Get URL from table via data-attribute
            const url = $table.getAttribute('data-offers-url');

            this.isFetchingData = true;
            let dataTable = [];

            axios.get(url).then(response => {
                response = response.data;

                if(!response.success) {
                    this.isFetchingData = false;
                    return false;
                }

                // Assign fetched data to variable
                this.offers = response.data;
                dataTable = response.data !== null ? response.data : [];
                this.isFetchingData = false;

                // Init datatable
                Vue.nextTick(function () {
                    if(typeof(offersTable) !== 'undefined') {
                        offersTable.destroy();
                    }
                    if(typeof(dataTable) !== 'undefined' && dataTable.length > 0) {
                        offersTable = $($tableJq).DataTable({
                            bSort: false,
                            language: {
                                paginate: {
                                    previous: '<i class="fas fa-chevron-left"></i>',
                                    next: '<i class="fas fa-chevron-right"></i>'
                                }
                            }
                        });
                    }
                    $($tableJq).wrap('<div class="responsive-table"></div>');
                })
            }).catch(err => {
                notifier.show('Oops!', err.response.data.message, 'danger', '', 7000);
                this.isFetchingData = false;
            });
        },
        createOffer: function(e) {
            const url = e.target.action;

            // Re-init date
            this.offerForm.date = document.getElementById('date').value;

            if(!validateUrl(this.offerForm.map_link)) {
                notifier.show('Oops!', 'Please enter a valid map link', 'danger', '', 7000);
                return false;
            }

            this.isProcessing = true;

            let data = new FormData();
            $.each(this.offerForm, (key, value) => {
                data.append(key, value);
            });

            axios.post(url, data).then(response => {
                response = response.data;

                if(!response.success) {
                    this.isProcessing = false;
                    notifier.show('Oops!', response.message, 'danger', '', 7000);
                    return false;
                }

                notifier.show('Success', response.message, 'success', '', 7000);
                setTimeout(() => {
                    window.location.reload();
                }, 2000);
            }).catch(err => {
                notifier.show('Oops!', err.response.data.message, 'danger', '', 7000);
                this.isProcessing = false;
            });
        },
        deleteOffer: function(e) {
            const id = e.currentTarget.getAttribute('data-id');
            const url = e.currentTarget.href + id;
            const $table = document.getElementById('#offers-table');

            swal({
                title: "Are you sure?",
                text: "Once deleted, you will not be able to recover this offer!",
                icon: "warning",
                buttons: ['Cancel', 'Proceed'],
                dangerMode: true,
            })
            .then((willDelete) => {
                if (willDelete) {
                    axios.delete(url).then(response => {
                        response = response.data;
                        notifier.show('Success!', response.message, 'success',
                            '', 7000);

                        setTimeout(() => {
                            window.location.reload();
                        }, 2000);
                    });
                }
            });
        },

        // Users
        getAllUsers: function(e) {
            const $table = document.getElementById('users-table');
            const $tableJq = '#users-table';

            // Run only on specific page
            if($table === null) {
                return false;
            }

            // Get URL from table via data-attribute
            const url = $table.getAttribute('data-users-url');

            this.isFetchingData = true;
            let dataTable = [];

            axios.get(url).then(response => {
                response = response.data;

                if(!response.success) {
                    this.isFetchingData = false;
                    return false;
                }

                // Assign fetched data to variable
                this.users = response.data;
                dataTable = response.data !== null ? response.data : [];
                this.isFetchingData = false;

                // Init datatable
                Vue.nextTick(function () {
                    if(typeof(usersTable) !== 'undefined') {
                        usersTable.destroy();
                    }
                    if(typeof(dataTable) !== 'undefined' && dataTable.length > 0) {
                        usersTable = $($tableJq).DataTable({
                            bSort: false,
                            language: {
                                paginate: {
                                    previous: '<i class="fas fa-chevron-left"></i>',
                                    next: '<i class="fas fa-chevron-right"></i>'
                                }
                            }
                        });
                    }
                    $($tableJq).wrap('<div class="responsive-table"></div>');
                })
            }).catch(err => {
                notifier.show('Oops!', err.response.data.message, 'danger', '', 7000);
                this.isFetchingData = false;
            });
        },
        deleteUser: function(e) {
            const id = e.currentTarget.getAttribute('data-id');
            const url = e.currentTarget.href + id;
            const $table = document.getElementById('#users-table');

            swal({
                title: "Are you sure?",
                text: "Once deleted, you will not be able to recover this account!",
                icon: "warning",
                buttons: ['Cancel', 'Proceed'],
                dangerMode: true,
            })
            .then((willDelete) => {
                if (willDelete) {
                    axios.delete(url).then(response => {
                        response = response.data;
                        notifier.show('Success!', response.message, 'success',
                            '', 7000);

                        setTimeout(() => {
                            window.location.reload();
                        }, 2000);
                    });
                }
            });
        },

        // City
        createCity: function(e) {
            const url = e.target.action;

            this.isProcessing = true;

            let data = new FormData();
            data.append('name', this.cityForm.name);

            axios.post(url, data).then(response => {
                response = response.data;

                if(!response.success) {
                    this.isProcessing = false;
                    notifier.show('Oops!', response.message, 'danger', '', 7000);
                    return false;
                }

                notifier.show('Success', response.message, 'success', '', 7000);
                setTimeout(() => {
                    window.location.reload();
                }, 2000);
            }).catch(err => {
                notifier.show('Oops!', err.response.data.message, 'danger', '', 7000);
                this.isProcessing = false;
            });
        },
        deleteCity: function(e) {
            const id = e.currentTarget.getAttribute('data-id');
            const url = e.currentTarget.href + id;
            const $table = document.getElementById('#cities-table');

            swal({
                title: "Are you sure?",
                text: "Once deleted, you will not be able to recover this city!",
                icon: "warning",
                buttons: ['Cancel', 'Proceed'],
                dangerMode: true,
            })
            .then((willDelete) => {
                if (willDelete) {
                    axios.delete(url).then(response => {
                        response = response.data;
                        notifier.show('Success!', response.message, 'success',
                            '', 7000);

                        setTimeout(() => {
                            window.location.reload();
                        }, 2000);
                    });
                }
            });
        },

        // Entry
        createEntry: function(e) {
            const url = e.target.action;
            const backgroundFile = document.querySelector('form[name=create-entry] input[name=background]').files[0];

            // Validate background color
            // if(!validateHexCode(this.entryForm.background)) {
            //     notifier.show('Oops!', 'Invalid hex color code. Please try again.', 'danger', '', 7000);
            //     return false;
            // }

            this.isProcessing = true;

            let data = new FormData();
            data.append('name', this.entryForm.name);
            // data.append('background', this.entryForm.background);
            data.append('background', backgroundFile);

            axios.post(url, data).then(response => {
                response = response.data;

                if(!response.success) {
                    this.isProcessing = false;
                    notifier.show('Oops!', response.message, 'danger', '', 7000);
                    return false;
                }

                notifier.show('Success', response.message, 'success', '', 7000);
                setTimeout(() => {
                    window.location.reload();
                }, 2000);
            }).catch(err => {
                notifier.show('Oops!', err.response.data.message, 'danger', '', 7000);
                this.isProcessing = false;
            });
        },
        deleteEntry: function(e) {
            const id = e.currentTarget.getAttribute('data-id');
            const url = e.currentTarget.href + id;
            const $table = document.getElementById('#entries-table');

            swal({
                title: "Are you sure?",
                text: "Once deleted, you will not be able to recover this entry!",
                icon: "warning",
                buttons: ['Cancel', 'Proceed'],
                dangerMode: true,
            })
            .then((willDelete) => {
                if (willDelete) {
                    axios.delete(url).then(response => {
                        response = response.data;
                        if(!response.success) {
                            this.isProcessing = false;
                            notifier.show('Oops!', response.message, 'danger', '', 7000);
                            return false;
                        }

                        notifier.show('Success!', response.message, 'success', '', 7000);

                        setTimeout(() => {
                            window.location.reload();
                        }, 2000);
                    });
                }
            });
        },

        // Ads Script
        updateAdScript: function(e) {
            const url = e.target.action;
            const top_script = document.querySelector('form[name=update-ad-script] textarea#top_script').value;
            const bottom_script = document.querySelector('form[name=update-ad-script] textarea#bottom_script').value;
            const left_script = document.querySelector('form[name=update-ad-script] textarea#left_script').value;
            const right_script = document.querySelector('form[name=update-ad-script] textarea#right_script').value;

            let data = new FormData();
            data.append('top_script', top_script);
            data.append('bottom_script', bottom_script);
            data.append('left_script', left_script);
            data.append('right_script', right_script);

            this.isProcessing = true;

            axios.post(url, data).then(data => data.data).then(response => {
                if(!response.success) {
                    this.isProcessing = false;
                    notifier.show('Oops!', response.message, 'danger', '', 7000);
                    return false;
                }

                notifier.show('Success!', response.message, 'success', '', 7000);

                setTimeout(() => {
                    window.location.reload();
                }, 2000);
            });
        }
    }
});

// Function

// Open sidenav bar function
const openSideNav = (event) => {
    // event.preventDefault();

    const $sideNav = $('.sidenav');
    const $sideNavBackdrop = $('#sidenav-backdrop');
    const $topNav = $('.navbar');
    const $bodyContainer = $('.container-fluid');

    $sideNav.toggleClass('expanded');
    $sideNavBackdrop.css({
        display: 'block',
        opacity: 1
    });
    if($(window).width() >= 767) {
        $topNav.toggleClass('expanded');
        $bodyContainer.toggleClass('expanded');
    }
}

// jQuery operations
$(document).ready(function() {

    let initialTouch;

    $('.datepicker').datepicker({
        autoclose: true,
        format: 'dd/mm/yyyy',
        startDate: '0d',
        todayHighlight: true,
    });

    // On change date inside New Offer Modal
    $('form[name=create-offer] .datepicker').on('changeDate', function(ev) {
        app.offerForm.date = $(this).val();
    });

    // Init static data tables
    $('.datatable').DataTable({
        bSort: false,
        language: {
            paginate: {
                previous: '<i class="fas fa-chevron-left"></i>',
                next: '<i class="fas fa-chevron-right"></i>'
            }
        }
    });
    $('.datatable').wrap('<div class="responsive-table"></div>');

    // Open sidenav bar
    $(document).on('click', '#toggle-sidenav', openSideNav);

    // Close sidenav bar
    $(document).on('click', '#sidenav-backdrop', function(e) {
        e.preventDefault();
        const $sideNav = $('.sidenav');
        const $sideNavBackdrop = $('#sidenav-backdrop');
        const $topNav = $('.navbar');
        const $bodyContainer = $('.container-fluid');

        $sideNav.removeClass('expanded');
        $sideNavBackdrop.css({
            display: 'none',
            opacity: 0
        });
        if($(window).width() >= 767) {
            $topNav.removeClass('expanded');
            $bodyContainer.removeClass('expanded');
        }
    });

    // Swipe to open sidenav
    $(document).on('touchstart', function(e) {
        const $sideNav = $('.sidenav');

        // Activate swipe if sidebar is not expanded and screen width is less than 767px
        if(!$sideNav.hasClass('expanded') && $(window).width() <= 767) {

            // Cache initial touch
            if($('body').attr('dir') === 'rtl') {
                // For RTL
                initialTouch = $(window).width() - e.touches[0].clientX;
            } else {
                // For LTR
                initialTouch = e.touches[0].clientX;
            }
        }
    });
    $(document).on('touchend', function(e) {
        const $sideNav = $('.sidenav');
        const sideNavWidth = $sideNav.width();
        const maxSwipeRange = 30;
        const swipeMaxPixel = sideNavWidth / 2;

        // Activate swipe if sidebar is not expanded and screen width is less than 767px
        if(!$sideNav.hasClass('expanded') && $(window).width() <= 767) {
            let swippedX = e.changedTouches[0].clientX;

            // Expand sidebar if swipped more than 100px
            if(initialTouch <= maxSwipeRange && swippedX - initialTouch >= swipeMaxPixel) {
                openSideNav();
            }
        }
    });
});

const dateFormat = (date) => {
    date = new Date(date * 1000);
    let dmyDate = '';
    dmyDate = date.getDate() + '/';
    dmyDate += date.getMonth() + '/';
    dmyDate += date.getFullYear();

    return dmyDate;
}

const validateHexCode = (code) => {
    if(/^#[0-9A-F]{6}$/i.test(code) || /^#([0-9A-F]{3}){1,2}$/i.test(code)) {
        return true;
    } else {
        return false;
    }
}

const validateUrl = (url) => {
    var pattern = new RegExp('^(https?:\\/\\/)?'+ // protocol
        '((([a-z\\d]([a-z\\d-]*[a-z\\d])*)\\.)+[a-z]{2,}|'+ // domain name
        '((\\d{1,3}\\.){3}\\d{1,3}))'+ // OR ip (v4) address
        '(\\:\\d+)?(\\/[-a-z\\d%_.~+]*)*'+ // port and path
        '(\\?[;&a-z\\d%_.~+=-]*)?'+ // query string
        '(\\#[-a-z\\d_]*)?$','i'); // fragment locator
    return !!pattern.test(url);
}

// Check if document is loaded fully
const stateCheck = setInterval(() => {
    if (document.readyState === 'complete') {
        clearInterval(stateCheck);
        const pageLoader = document.getElementById('page-loader');
        pageLoader.parentNode.removeChild(pageLoader);
    }
}, 100);