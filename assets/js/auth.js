const app = new Vue({
    el: '#app',
    data: {
        isProcessing: false,
        isPasswordSent: false,
        isNewAccount: false,
        authType: '',
        loginWithEmail: {
            email: '',
            password: '',
            name: ''
        },
        loginWithGoogle: {
            email: '',
            name: '',
            avatar: ''
        }
    },
    created() {

    },
    methods: {
        loginType: function(type = 'email') {
            this.authType = type;
        },
        continueWithEmail: function(e) {
            const url = e.target.action;

            if(this.loginWithEmail.email.trim() === '') {
                notifier.show('Info', 'Email is required', 'danger', '', 7000);
                return;
            }

            this.isProcessing = true;
            let data = new FormData();
            data.append('email', this.loginWithEmail.email);

            axios.post(url, data).then(response => {
                response = response.data;

                this.isProcessing = false;

                if(!response.success) {
                    notifier.show('Oops!', response.message, 'danger', '', 7000);
                    return false;
                }

                this.isPasswordSent = true;
                this.isNewAccount = response.data.is_new_account;
                notifier.show('Success', response.message, 'success', '', 7000);
            }).catch(err => {
                notifier.show('Oops!', err.response.data.message, 'danger', '', 7000);
                this.isProcessing = false;
            });
        },
        authenticate: function(e) {
            const url = e.target.action;

            if(this.loginWithEmail.email.trim() === '') {
                notifier.show('Info', 'Password is required', 'danger', '', 7000);
                return;
            }
            if(this.isNewAccount && this.loginWithEmail.name.trim() === '') {
                notifier.show('Info', 'Your name is required', 'danger', '', 7000);
                return;
            }

            this.isProcessing = true;
            let data = new FormData();
            data.append('email', this.loginWithEmail.email);
            data.append('password', this.loginWithEmail.password);
            if(this.isNewAccount) {
                data.append('name', this.loginWithEmail.name);
            }

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
        }
    }
});

// Google Login
function continueWithGoogle(googleUser) {
    if(app.authType !== 'google') {
        return;
    }

    const profile = googleUser.getBasicProfile();
    const url = document.querySelector('.g-signin2').getAttribute('data-url');

    const data = new FormData();
    data.append('name', profile.getName());
    data.append('email', profile.getEmail());
    data.append('avatar', profile.getImageUrl());

    axios.post(url, data).then(response => {
        response = response.data;

        if(!response.success) {
            notifier.show('Oops!', response.message, 'danger', '', 7000);
            return false;
        }

        notifier.show('Success', response.message, 'success', '', 7000);
        setTimeout(() => {
            window.location.reload();
        }, 2000);
    }).catch(err => {
        notifier.show('Oops!', err.response.data.message, 'danger', '', 7000);
    });
}

// Facebook login
window.fbAsyncInit = function() {
    const APP_ID = document.querySelector('meta[name=facebook-app_id]').getAttribute('content');

    FB.init({
        appId: APP_ID,
        autoLogAppEvents: true,
        xfbml: true,
        version: 'v8.0'
    });
}

function continueWithFacebook(resp) {
    app.authType = 'facebook';
    if (resp.authResponse) {
        FB.api('/me?fields=id,name,email,picture', 'GET', {}, response => {
            // Start processing
            app.authType = 'facebook';

            const url = document.querySelector('.fb-login-button').getAttribute('data-url');

            const data = new FormData();
            data.append('name', response.name);
            data.append('email', response.email);
            data.append('avatar', response.picture.data.url);

            axios.post(url, data).then(data => data.data).then(response => {
                if(!response.success) {
                    notifier.show('Oops!', response.message, 'danger', '', 7000);
                    return false;
                }

                notifier.show('Success', response.message, 'success', '', 7000);
                setTimeout(() => {
                    window.location.reload();
                }, 2000);
            }).catch(err => {
                notifier.show('Oops!', err.response.data.message, 'danger', '', 7000);
            });
        });
    }
}

// Trigger google login button on click continue with google button
document.getElementById('continue-with-google').addEventListener('click', (event) => {
    event.preventDefault();

    const loginWithGoogleButton = document.querySelector('.g-signin2 > .abcRioButton');

    loginWithGoogleButton.click();
});

// Check if Facebook plugin is loaded or not
window.onload = function() {
    FB.Event.subscribe('xfbml.render', function(response) {
        const loader = document.querySelector('.buttons-container');
        loader.classList.remove('processing-auth');
    });
};