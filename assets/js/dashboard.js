const app = new Vue({
    el: '#app',
    data: {
        isProcessing: false,
        currentTime: '...',
        selectedCities: [],
    },
    created() {
        setInterval(this.countdown, 1000);
        this.adjustTextColors();
    },
    mounted() {
        // Remove page loader
        this.removePageLoader();
    },
    methods: {
        countdown: function() {
            const today = new Date();
            // const timeout = new Date(document.getElementById('countdown').getAttribute('data-timeout') * 1000);
            let hours = today.getHours();
            let minutes = today.getMinutes();
            let seconds = today.getSeconds();
            let ampm = hours >= 12 ? 'PM' : 'AM';
            hours = hours % 12;
            hours = hours ? hours : 12; // the hour '0' should be '12'
            minutes = minutes < 10 ? '0' + minutes : minutes;
            seconds = seconds < 10 ? '0' + seconds : seconds;
            const time = hours + ':' + minutes + ':' + seconds + ' ' + ampm;
            this.currentTime = time;
        },
        getOffersByCity: function(event) {
            const url = window.location.href;
            this.selectedCities = [];

            event.target.options.forEach((option, key) => {
                if(option.selected) {
                    this.selectedCities.push(option.value);
                }
            });
        },
        updateCities: function(event) {
            const url = document.getElementById('btn-update-cities').getAttribute('data-url');

            if(this.selectedCities.length < 1) {
                notifier.show('Oops!', 'Nothing to update!', 'danger', '', 7000);
                return;
            }

            // Data
            let data = new FormData();
            data.append('cities', this.selectedCities);

            this.isProcessing = true;
            axios.post(url, data).then(data => data.data).then(response => {
                if(!response.success) {
                    notifier.show('Oops!', response.message, 'danger', '', 7000);
                    this.isProcessing = false;
                    return false;
                }

                notifier.show('Success', response.message, 'success', '', 7000);
                setTimeout(() => {
                    window.location.reload();
                }, 2000);
            });
        },
        isDark: function(color) {

            // Variables for red, green, blue values
            let r, g, b, hsp;

            // Check the format of the color, HEX or RGB?
            if (color.match(/^rgb/)) {

                // If RGB --> store the red, green, blue values in separate variables
                color = color.match(/^rgba?\((\d+),\s*(\d+),\s*(\d+)(?:,\s*(\d+(?:\.\d+)?))?\)$/);

                r = color[1];
                g = color[2];
                b = color[3];
            } else {
                // If hex --> Convert it to RGB: http://gist.github.com/983661
                color = +("0x" + color.slice(1).replace(color.length < 5 && /./g, '$&$&'));

                r = color >> 16;
                g = color >> 8 & 255;
                b = color & 255;
            }

            // HSP (Highly Sensitive Poo) equation from http://alienryderflex.com/hsp.html
            hsp = Math.sqrt(
                0.299 * (r * r) +
                0.587 * (g * g) +
                0.114 * (b * b)
            );

            // Using the HSP value, determine whether the color is light or dark
            if (hsp > 127.5) {
                return false;
            } else {
                return true;
            }
        },
        adjustTextColors: function() {
            const $card = document.getElementById('offer-card');
            const background = window.getComputedStyle($card, null).getPropertyValue('background-color');

            if(this.isDark(background)) {
                // $card.style.color = '#fff';
                $card.classList.add('text-white');
            } else {
                $card.classList.remove('text-white');
            }
        },
        removePageLoader: function() {
            const pageLoader = document.getElementById('page-loader');
            setTimeout(() => {
                pageLoader.parentNode.removeChild(pageLoader);
            }, 500);
        }
    }
});

// jQuery Operations
$(document).ready(function() {
    // Init multi-select
    $('.multiselect').selectpicker();
    $('.multiselect').click();

    // Customize multi-select button
    $('.bootstrap-select button').removeClass('btn-light').addClass('btn-narrow color-secondary text-white');
})