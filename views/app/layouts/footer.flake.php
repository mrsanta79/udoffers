    <small id="footer">
        <div>
            Copyright &copy;
            <?= date('Y') ?>.
            <a href="<?= url('/') ?>" class="text-white font-weight-bold"><?= env('APP_NAME') ?></a>.
            All Rights Reserved.
            CREATED BY
            <a href="https://roidnet.com/">
                <strong>
                    <span style="color: red;">ROID</span>NET
                </strong>
            </a>
        </div>
        <div>
            <a href="<?= url('/about-us') ?>">
                <?= trans('dashboard.links.who_we_are') ?>
            </a>
            <span class="seperator mx-2"></span>
            <a href="<?= url('/privacy-policy') ?>">
                <?= trans('dashboard.links.privacy_policy') ?>
            </a>
            <span class="seperator mx-2"></span>
            <a href="<?= url('/terms') ?>">
                <?= trans('dashboard.links.terms_conditions') ?>
            </a>
        </div>
    </small>
    <!-- SCRIPTS -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/2.5.3/umd/popper.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.1.1/js/bootstrap.bundle.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/4.5.0/js/bootstrap.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/mdbootstrap/4.19.1/js/mdb.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap-select@1.13.14/dist/js/bootstrap-select.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/vue/2.6.12/vue.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/axios/0.20.0/axios.min.js"></script>
    <script src="<?= assets('libs/notifier/js/notifier.js') ?>"></script>
    <script src="<?= assets('js/dashboard.js') ?>"></script>
</body>
</html>
