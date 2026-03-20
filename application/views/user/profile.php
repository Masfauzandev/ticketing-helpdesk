<!-- Dashboard Counts Section-->
<section class="">
    <div class="container-fluid">
        <div class="row">
            <div class="col-lg-12">
                <div class="card">
                    <div class="card-header d-flex align-items-center">
                        <h3 class="h4"><i class="fa fa-user"></i> <?= $title ?></h3>
                    </div>
                    <div class="card-body">
                        <div class="col-md-12 p-2">
                            <div class="row ">
                                <div class="col-md-3  font-weight-bold">Name</div>
                                <div class="col-md-9">
                                    <?= $user_details['name'] ?>
                                    <a href="<?= BASE_URL ?>user/change_name" class="ml-2" title="Edit Name">
                                        <i class="fa fa-edit text-success"></i>
                                    </a>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-12 p-2">
                            <div class="row">
                                <div class="col-md-3  font-weight-bold">Email</div>
                                <div class="col-md-9">
                                    <?= $user_details['email'] ?>
                                    <a href="<?= BASE_URL ?>user/change_email" class="ml-2" title="Edit Email">
                                        <i class="fa fa-edit text-info"></i>
                                    </a>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-12 p-2">
                            <div class="row">
                                <div class="col-md-3  font-weight-bold">Mobile</div>
                                <div class="col-md-9">
                                    <?= $user_details['mobile'] ?>
                                    <a href="<?= BASE_URL ?>user/change_mobile" class="ml-2" title="Edit Mobile">
                                        <i class="fa fa-edit text-warning"></i>
                                    </a>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-12 p-2">
                            <div class="row">
                                <div class="col-md-3  font-weight-bold">Username</div>
                                <div class="col-md-9">
                                    <?= $user_details['username'] ?>
                                    <a href="<?= BASE_URL ?>user/change_username" class="ml-2" title="Edit Username">
                                        <i class="fa fa-edit text-primary"></i>
                                    </a>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-12 p-2">
                            <div class="row">
                                <div class="col-md-3 font-weight-bold">User Type</div>
                                <div class="col-md-9">
                                    <span class="user-type" data-value="<?= $user_details['type'] ?>"></span>
                                    <?php if ($this->Session->getUserType() == USER_ADMIN): ?>
                                        <a href="<?= BASE_URL ?>user/change_type" class="ml-2" title="Edit Type">
                                            <i class="fa fa-edit text-danger"></i>
                                        </a>
                                    <?php endif; ?>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-12 p-2">
                            <div class="row">
                                <div class="col-md-3 font-weight-bold">Employee ID</div>
                                <div class="col-md-9">
                                    <?= $user_details['employee_id'] ?>
                                    <a href="<?= BASE_URL ?>user/change_employee_id" class="ml-2"
                                        title="Edit Employee ID">
                                        <i class="fa fa-edit text-danger"></i>
                                    </a>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-12 p-2">
                            <div class="row">
                                <div class="col-md-3 font-weight-bold">Cabang</div>
                                <div class="col-md-9">
                                    <?= $user_details['cabang_name'] ?>
                                    <a href="<?= BASE_URL ?>user/change_cabang" class="ml-2" title="Edit Cabang">
                                        <i class="fa fa-edit text-info"></i>
                                    </a>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-12 p-2">
                            <div class="row">
                                <div class="col-md-3 font-weight-bold">Divisi</div>
                                <div class="col-md-9">
                                    <?= $user_details['divisi_name'] ?>
                                    <a href="<?= BASE_URL ?>user/change_divisi" class="ml-2" title="Edit Divisi">
                                        <i class="fa fa-edit text-primary"></i>
                                    </a>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-12 p-2">
                            <div class="row">
                                <div class="col-md-3  font-weight-bold">Created On</div>
                                <div class="col-md-9"><span class="rel-time"
                                        data-value="<?= $user_details['created'] ?>000"></span></div>
                            </div>
                        </div>
                        <div class="col-md-12 p-2">
                            <div class="row">
                                <div class="col-md-3  font-weight-bold">Last Updated</div>
                                <div class="col-md-9"><span class="rel-time"
                                        data-value="<?= $user_details['updated'] ?>000"></span></div>
                            </div>
                        </div>
                        <hr>
                        <div class="col-md-12 p-2">
                            <div class="row p-2 ">
                                <a href="<?= BASE_URL ?>user/change_password"
                                    class="btn btn-secondary pull-right mr-3">Change Password</a>
                            </div>
                        </div>

                    </div>
                </div>
            </div>
        </div>
    </div>
</section>