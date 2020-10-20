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