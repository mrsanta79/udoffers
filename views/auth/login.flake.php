<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <meta name="google-signin-client_id" content="<?= env('GOOGLE_CLIENT_ID') ?>">

    <title><?= env('APP_NAME') . ' - Login' ?></title>

    <!-- CSS -->
    <link href="https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/4.5.0/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/mdbootstrap/4.19.1/css/mdb.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.14.0/css/all.min.css">
    <link rel="stylesheet" href="<?= assets('libs/notifier/css/notifier.css') ?>">
    <link rel="stylesheet" href="<?= assets('css/auth.css') ?>">
</head>
<body>

    <div id="app">
        <div class="container">
            <div id="fb-root"></div>
            <div class="card">
                <a href="<?= url('/') ?>" class="logo">
                    <img src="<?= assets('images/logo.jpeg') ?>" alt="">
                </a>

                <div class="buttons-container" :class="authType !== '' && authType !== 'email' ? 'processing-auth' : ''">
                    <button type="button" class="btn color-secondary text-white" @click="loginType('email')" :class="authType === 'email' ? 'd-none' : ''">
                        <i class="fas fa-envelope mr-3"></i>
                        Continue with Email
                    </button>

                    <button type="button" class="btn text-white" id="continue-with-google" style="background: #4081ee" @click="loginType('google')" :class="authType === 'email' ? 'd-none' : ''">
                        <i class="fab fa-google mr-3"></i>
                        Continue with Google
                    </button>

                    <button class="g-signin2 d-none" data-onsuccess="continueWithGoogle" data-theme="dark" data-url="<?= api('/auth/google') ?>"></button>

                    <button type="button" class="btn text-white" style="background: #395794" @click="loginType('facebook')" :class="authType === 'email' ? 'd-none' : ''">
                        <i class="fab fa-facebook-square mr-3"></i>
                        Continue with Facebook
                    </button>
    <!--                <div class="fb-login-button" data-size="large" data-button-type="continue_with" data-layout="rounded" data-auto-logout-link="false" data-use-continue-as="true" data-width=""></div>-->
                </div>

                <!-- Continue with email form -->
                <form action="<?= api('/auth') ?>" name="continue-with-email" method="post" style="display: none" @submit.prevent="continueWithEmail" :class="authType === 'email' && !isPasswordSent ? 'd-block' : ''">
                    <div class="md-form mt-0">
                        <input type="email" id="email" name="email" class="form-control" v-model="loginWithEmail.email">
                        <label for="email">Email</label>
                    </div>
                    <div class="md-form mt-0">
                        <button type="submit" class="btn color-secondary text-white" :class="isProcessing ? 'disabled' : ''" style="transition: none">
                            <i class="fa fa-spinner fa-spin" v-if="isProcessing"></i>
                            <span class="font-weight-bold" v-if="!isProcessing">
                                Continue
                                <i class="fas fa-chevron-right ml-3"></i>
                            </span>
                        </button>
                    </div>
                </form>

                <!-- Login with email password -->
                <form action="<?= api('/auth/email') ?>" name="continue-with-email" method="post" style="display: none;" @submit.prevent="authenticate" :class="isPasswordSent ? 'd-block' : ''">
                    <div class="md-form mt-0">
                        <input type="email" id="email-login" name="email" class="form-control disabled" v-model="loginWithEmail.email" disabled>
                    </div>
                    <div class="md-form mt-0" style="display: none" :class="isNewAccount ? 'd-block' : ''">
                        <input type="text" id="name" name="name" class="form-control" v-model="loginWithEmail.name">
                        <label for="name">Your Name</label>
                    </div>
                    <div class="md-form mt-0">
                        <input type="password" id="password" name="password" class="form-control" v-model="loginWithEmail.password">
                        <label for="password">Password</label>
                    </div>
                    <div class="md-form mt-0">
                        <button type="submit" class="btn color-secondary text-white" :class="isProcessing ? 'disabled' : ''">
                            <i class="fa fa-spinner fa-spin" v-if="isProcessing"></i>
                            <span class="font-weight-bold" v-if="!isProcessing">
                                Authenticate
                                <i class="fas fa-unlock-alt ml-3"></i>
                            </span>
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <!-- SCRIPTS -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/4.5.0/js/bootstrap.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/mdbootstrap/4.19.1/js/mdb.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/vue/2.6.12/vue.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/axios/0.20.0/axios.min.js"></script>
    <script src="https://apis.google.com/js/platform.js" async defer></script>
<!--    <script async defer crossorigin="anonymous" src="https://connect.facebook.net/en_GB/sdk.js#xfbml=1&version=v8.0" nonce="0iT6IU08"></script>-->
    <script src="<?= assets('libs/notifier/js/notifier.js') ?>"></script>
    <script src="<?= assets('js/auth.js') ?>"></script>
    <script type="text/javascript">

        // Facebook login
        // window.fbAsyncInit = function() {
        //     FB.init({
        //         appId      : '{your-app-id}',
        //         cookie     : true,
        //         xfbml      : true,
        //         version    : '{api-version}'
        //     });
        //     FB.AppEvents.logPageView();
        // };
        //
        // (function(d, s, id){
        //     var js, fjs = d.getElementsByTagName(s)[0];
        //     if (d.getElementById(id)) {return;}
        //     js = d.createElement(s); js.id = id;
        //     js.src = "https://connect.facebook.net/en_US/sdk.js";
        //     fjs.parentNode.insertBefore(js, fjs);
        // }(document, 'script', 'facebook-jssdk'));
        //
        // // Check if user is logged in already
        // FB.getLoginStatus(function(response) {
        //     statusChangeCallback(response);
        // });
    </script>
</body>
</html>