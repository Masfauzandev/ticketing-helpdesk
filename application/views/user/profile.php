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

                    <?php if ($this->session->flashdata('success')): ?>
                        <div class="alert alert-success alert-dismissible fade show" role="alert">
                            <?= $this->session->flashdata('success') ?>
                            <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                            </button>
                        </div>
                        <?php endif; ?>

                        <!-- View Mode -->
                        <div id="profile_view">
                            <div class="col-md-12 p-2">
                                <div class="row ">
                                    <div class="col-md-3  font-weight-bold">Name</div>
                                    <div class="col-md-9"><?= $user_details['name'] ?></div>
                                </div>
                            </div>
                            <div class="col-md-12 p-2">
                                <div class="row">
                                    <div class="col-md-3  font-weight-bold">Email</div>
                                    <div class="col-md-9"><?= $user_details['email'] ?></div>
                                </div>
                            </div>
                            <div class="col-md-12 p-2">
                                <div class="row">
                                    <div class="col-md-3  font-weight-bold">Mobile</div>
                                    <div class="col-md-9"><?= $user_details['mobile'] ?></div>
                                </div>
                            </div>
                            <div class="col-md-12 p-2">
                                <div class="row">
                                    <div class="col-md-3  font-weight-bold">Username</div>
                                    <div class="col-md-9"><?= $user_details['username'] ?></div>
                                </div>
                            </div>
                            <div class="col-md-12 p-2">
                                <div class="row">
                                    <div class="col-md-3 font-weight-bold">User Type</div>
                                    <div class="col-md-9"><span class="user-type" data-value="<?= $user_details['type'] ?>"></span></div>
                                </div>
                            </div>
                            <div class="col-md-12 p-2">
                                <div class="row">
                                    <div class="col-md-3  font-weight-bold">Created On</div>
                                    <div class="col-md-9"><span class="rel-time" data-value="<?= $user_details['created'] ?>000"></span></div>
                                </div>
                            </div>
                            <div class="col-md-12 p-2">
                                <div class="row">
                                    <div class="col-md-3  font-weight-bold">Last Updated</div>
                                    <div class="col-md-9"><span class="rel-time" data-value="<?= $user_details['updated'] ?>000"></span></div>
                                </div>
                            </div>
                            <hr>
                            <div class="col-md-12 p-2 text-left">
                            <a href="<?= BASE_URL ?>user/change_password" class="btn btn-secondary mr-2">Change Password</a>
                            <button type="button" class="btn btn-danger" id="edit_profile_btn">Edit Profile</button>
                            </div>
                        </div>

                        <!-- Edit Mode -->
                        <div id="profile_edit" style="display: none;">
                            <form method="POST" action="<?= base_url('User/profile_save') ?>">
                                <div class="col-md-12 p-2">
                                    <div class="row">
                                        <div class="col-md-3 font-weight-bold">Name</div>
                                        <div class="col-md-9">
                                            <input type="text" name="name" class="form-control" value="<?= $user_details['name'] ?>" required>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-12 p-2">
                                    <div class="row">
                                        <div class="col-md-3 font-weight-bold">Email</div>
                                        <div class="col-md-9">
                                            <input type="email" name="email" class="form-control" value="<?= $user_details['email'] ?>" required>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-12 p-2">
                                    <div class="row">
                                        <div class="col-md-3 font-weight-bold">Mobile</div>
                                        <div class="col-md-9">
                                            <input type="text" name="mobile" class="form-control" value="<?= $user_details['mobile'] ?>">
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-12 p-2">
                                    <div class="row">
                                        <div class="col-md-3 font-weight-bold">Username</div>
                                        <div class="col-md-9">
                                            <input type="text" name="username" class="form-control" value="<?= $user_details['username'] ?>" required>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-12 p-2 text-right">
                                    <button type="submit" class="btn btn-success">Simpan</button>
                                </div>
                            </form>
                        </div>

                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

<!-- Toggle Script -->
<script>
document.addEventListener("DOMContentLoaded", function () {
    const editBtn = document.getElementById('edit_profile_btn');
    const viewSection = document.getElementById('profile_view');
    const editSection = document.getElementById('profile_edit');

    if (editBtn && viewSection && editSection) {
        editBtn.addEventListener('click', function () {
            viewSection.style.display = 'none';
            editSection.style.display = 'block';
        });
    }
});
</script>
