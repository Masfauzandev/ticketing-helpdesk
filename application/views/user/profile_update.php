<?php
$is_admin = ($this->Session->getUserType() == USER_ADMIN);
?>
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

                        <!-- ID -->
                        <input type="hidden" id="user_id" value="<?= $user_details['id'] ?>">

                        <!-- Employee Biodata -->
                        <div class="card mb-4">
                            <div class="card-header"><strong>Employee Biodata</strong></div>
                            <div class="card-body">

                                <div class="row m-2">
                                    <div class="col-md-3">Name</div>
                                    <div class="col-md-9">
                                        <input type="text" id="name" class="form-control"
                                            value="<?= $user_details['name'] ?>">
                                    </div>
                                </div>

                                <div class="row m-2">
                                    <div class="col-md-3">Email</div>
                                    <div class="col-md-9">
                                        <input type="email" id="email" class="form-control"
                                            value="<?= $user_details['email'] ?>">
                                    </div>
                                </div>

                                <div class="row m-2">
                                    <div class="col-md-3">Mobile</div>
                                    <div class="col-md-9">
                                        <input type="tel" id="mobile" class="form-control"
                                            value="<?= $user_details['mobile'] ?>">
                                    </div>
                                </div>

                                <div class="row m-2">
                                    <div class="col-md-3">Employee ID</div>
                                    <div class="col-md-9">
                                        <input type="text" id="employee_id" class="form-control"
                                            value="<?= isset($user_details['employee_id']) ? $user_details['employee_id'] : '' ?>">
                                    </div>
                                </div>

                                <div class="row m-2">
                                    <div class="col-md-3">Gender</div>
                                    <div class="col-md-9">
                                        <select id="gender_id" class="form-control">
                                            <option value="">- Select -</option>
                                            <?php foreach ($list_gender as $jk): ?>
                                                <option value="<?= $jk->id ?>" <?= $user_details['gender_id'] == $jk->id ? 'selected' : '' ?>><?= $jk->nama ?></option>
                                            <?php endforeach; ?>
                                        </select>
                                    </div>
                                </div>

                                <div class="row m-2">
                                    <div class="col-md-3">Cabang</div>
                                    <div class="col-md-9">
                                        <select id="cabang_id" class="form-control">
                                            <option value="">- Select -</option>
                                            <?php foreach ($list_cabang as $c): ?>
                                                <option value="<?= $c->id ?>" <?= $user_details['cabang_id'] == $c->id ? 'selected' : '' ?>><?= $c->nama_cabang ?></option>
                                            <?php endforeach; ?>
                                        </select>
                                    </div>
                                </div>

                                <div class="row m-2">
                                    <div class="col-md-3">Divisi</div>
                                    <div class="col-md-9">
                                        <select id="divisi_id" class="form-control">
                                            <option value="">- Select -</option>
                                            <?php foreach ($list_divisi as $d): ?>
                                                <option value="<?= $d->id ?>" <?= $user_details['divisi_id'] == $d->id ? 'selected' : '' ?>><?= $d->nama_divisi ?></option>
                                            <?php endforeach; ?>
                                        </select>
                                    </div>
                                </div>

                            </div>
                        </div>

                        <!-- Account Info -->
                        <div class="card mb-4">
                            <div class="card-header"><strong>Account</strong></div>
                            <div class="card-body">

                                <div class="row m-2">
                                    <div class="col-md-3">Username</div>
                                    <div class="col-md-9">
                                        <input type="text" id="username" class="form-control"
                                            value="<?= $user_details['username'] ?>">
                                    </div>
                                </div>

                                <div class="row m-2">
                                    <div class="col-md-3">User Type</div>
                                    <div class="col-md-9">
                                        <?php if ($is_admin): ?>
                                            <select id="type" class="form-control">
                                                <option value="10" <?= $user_details['type'] == 10 ? 'selected' : '' ?>>Member
                                                </option>
                                                <option value="60" <?= $user_details['type'] == 60 ? 'selected' : '' ?>>Agent
                                                </option>
                                                <option value="80" <?= $user_details['type'] == 80 ? 'selected' : '' ?>>Manager
                                                </option>
                                                <option value="100" <?= $user_details['type'] == 100 ? 'selected' : '' ?>>Admin
                                                </option>
                                            </select>
                                        <?php else: ?>
                                            <span class="user-type" data-value="<?= $user_details['type'] ?>"></span>
                                            <!-- Hidden field so non-admin doesn't change type but type is respected -->
                                            <input type="hidden" id="type" value="">
                                        <?php endif; ?>
                                    </div>
                                </div>

                                <div class="row m-2">
                                    <div class="col-md-3">New Password</div>
                                    <div class="col-md-9">
                                        <input type="password" id="password" class="form-control"
                                            placeholder="Leave blank to keep current password">
                                    </div>
                                </div>

                            </div>
                        </div>

                        <hr>
                        <div class="col-md-12 p-2">
                            <div class="row">
                                <div class="col-md-12 form-group">
                                    <button class="btn btn-success pull-left" id="update_profile">Update
                                        Profile</button>
                                </div>
                            </div>
                        </div>

                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

<script>
    $(document).ready(function () {
        renderCustomHTML(); // Render user type for non-admin

        $("#update_profile").on('click', function () {
            var name = $('#name').val();
            var email = $('#email').val();
            var mobile = $('#mobile').val();
            var username = $('#username').val();
            var employee_id = $('#employee_id').val();
            var gender_id = $('#gender_id').val();
            var cabang_id = $('#cabang_id').val();
            var divisi_id = $('#divisi_id').val();
            var password = $('#password').val();

            // For type, check if select exists (admin) else don't send anything (handled by API)
            var type_val = $('#type').is('select') ? $('#type').val() : null;

            var data = {
                'name': name,
                'email': email,
                'mobile': mobile,
                'username': username,
                'employee_id': employee_id,
                'gender_id': gender_id,
                'cabang_id': cabang_id,
                'divisi_id': divisi_id
            };

            if (password) {
                data.password = password;
            }

            if (type_val) {
                data.type = type_val;
            }

            $.ajax({
                type: 'POST',
                url: BASE_URL + 'API/User/update_profile_complete',
                dataType: 'json',
                data: data,
                success: function (response) {
                    console.log('Update response:', response);
                    if (response && response.data && (response.data.result === true || response.data.raw_result >= 0)) {
                        showNotification('success', 'Profile updated successfully');
                        setTimeout(function () {
                            window.location.reload();
                        }, 1000);
                    } else {
                        var msg = (response && response.data && response.data.message) ? response.data.message : 'Update failed';
                        showNotification('error', msg);
                    }
                },
                error: function (xhr, status, error) {
                    console.error(xhr);
                    showNotification('error', 'Error updating profile');
                }
            });
        });
    });
</script>