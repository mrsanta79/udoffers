// Global variables
let fieldsTable,
    offersTable,
    usersTable;

const app = new Vue({
    el: '#app',
    data: {
        isProcessing: false,
        isFetchingData: false,
        offers: null,
        offerForm: {
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
        this.getAllOffers();
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
                    notifier.show('Oops!', response.message, 'danger', '', 7000);
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

            // this.isFetchingData = true;
            axios.delete(url).then(response => {
                response = response.data;
                notifier.show('Success!', response.message, 'success', '', 7000);

                setTimeout(() => {
                    window.location.reload();
                }, 2000);
            });
        },

        // Fields
        createField: function(e) {
            const url = e.target.action;
            const post = e.target.method;
        }
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