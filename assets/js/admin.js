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
            background: '#424242'
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

            // Validate background color

            if(!validateHexCode(this.entryForm.background)) {
                notifier.show('Oops!', 'Invalid hex color code. Please try again.', 'danger', '', 7000);
                return false;
            }

            this.isProcessing = true;

            let data = new FormData();
            data.append('name', this.entryForm.name);
            data.append('background', this.entryForm.background);

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
                        notifier.show('Success!', response.message, 'success',
                            '', 7000);

                        setTimeout(() => {
                            window.location.reload();
                        }, 2000);
                    });
                }
            });
        },
    }
});

// jQuery operations
$(document).ready(function() {

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

// Check if document is loaded fully
const stateCheck = setInterval(() => {
    if (document.readyState === 'complete') {
        clearInterval(stateCheck);
        const pageLoader = document.getElementById('page-loader');
        pageLoader.parentNode.removeChild(pageLoader);
    }
}, 100);