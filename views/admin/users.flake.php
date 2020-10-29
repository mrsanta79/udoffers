<?= load_layout('admin/layouts/header', null, $page_name) ?>

    <div id="app">
        <div class="container-fluid">
            <div class="page-heading d-flex justify-content-between">
                <h1><?= trans('common.menu.users') ?></h1>
            </div>

            <div class="responsive-table mt-5">
                <div class="text-center" :class="!isFetchingData ? 'd-none' : ''">
                    <i class="fa fa-spinner fa-spin" style="font-size: 40px;"></i>
                    <br>
                    <h4 class="mt-3"><?= trans('common.loading_data') ?></h4>
                </div>
                <table class="table table-hover card" id="users-table" style="display: none" :class="!isFetchingData ? 'd-table' : ''" v-if="users" data-users-url="<?= api('/admin/users') ?>">
                    <thead>
                        <tr>
                            <th><?= trans('pages.users.name') ?></th>
                            <th><?= trans('pages.users.email') ?></th>
                            <th><?= trans('pages.users.account_type') ?></th>
                            <th><?= trans('pages.users.user_type') ?></th>
                            <th><?= trans('pages.users.registered_on') ?></th>
                            <th class="actions"><?= trans('common.actions') ?></th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr v-for="(user, index) in users" :data-id="user.id">
                            <td>
                                {{ user.name }}
                                <i v-if="user.is_admin" class="fas fa-crown text-warning ml-2"></i>
                            </td>
                            <td>{{ user.email }}</td>
                            <td>
                                {{
                                    user.is_facebook
                                    ? 'Facebook Account'
                                    : user.is_google
                                        ? 'Google Account'
                                        : 'Email Account'
                                }}
                            </td>
                            <td>{{ user.is_admin ? 'Administrator' : '-' }}</td>
                            <td>{{ dateFormat(user.created_at) }}</td>
                            <td class="actions">
                                <a href="<?= api('/admin/users/delete?id=') ?>" type="button" class="btn-floating icon-btn delete-user" :data-id="user.id" @click.prevent="deleteUser">
                                    <i class="fas fa-trash waves-effect" aria-hidden="true"></i>
                                </a>
                            </td>
                        </tr>
                    </tbody>
                </table>
                <div class="text-center" style="display: none" :class="isFetchingData ? 'd-none' : 'd-block'" v-if="!users">
                    <h4 class="mt-3"><?= trans('pages.users.no_user_found') ?></h4>
                </div>
            </div>
        </div>

        <?= load_layout('admin/layouts/ad-script-modal', $data) ?>

    </div>
<?= load_layout('admin/layouts/footer') ?>