<!-- Dashboard Counts Section-->
<section class="">
    <div class="container-fluid">
        <div class="row">
            <div class="col-lg-12">
                <div class="card">
                    <div class="card-header d-flex align-items-center">
                        <h3 class="h4"><i class="fa fa-user-edit"></i> <?= $title ?> - <?= $user_details['username'] ?>
                        </h3>
                    </div>
                    <div class="card-body">
                        <input type="hidden" id="user_id" value="<?= $user_details['id'] ?>">

                        <div class="col-md-12 p-2">
                            <div class="row">
                                <div class="col-md-3 font-weight-bold">Name</div>
                                <div class="col-md-6">
                                    <input type="text" id="name" class="form-control"
                                        value="<?= $user_details['name'] ?>">
                                </div>
                            </div>
                        </div>

                        <div class="col-md-12 p-2">
                            <div class="row">
                                <div class="col-md-3 font-weight-bold">Email</div>
                                <div class="col-md-6">
                                    <input type="email" id="email" class="form-control"
                                        value="<?= $user_details['email'] ?>">
                                </div>
                            </div>
                        </div>

                        <div class="col-md-12 p-2">
                            <div class="row">
                                <div class="col-md-3 font-weight-bold">Mobile</div>
                                <div class="col-md-6">
                                    <input type="tel" id="mobile" class="form-control"
                                        value="<?= $user_details['mobile'] ?>">
                                </div>
                            </div>
                        </div>

                        <div class="col-md-12 p-2">
                            <div class="row">
                                <div class="col-md-3 font-weight-bold">Username</div>
                                <div class="col-md-6">
                                    <input type="text" id="username" class="form-control"
                                        value="<?= $user_details['username'] ?>">
                                </div>
                            </div>
                        </div>

                        <div class="col-md-12 p-2">
                            <div class="row">
                                <div class="col-md-3 font-weight-bold">Employee ID</div>
                                <div class="col-md-6">
                                    <input type="text" id="employee_id" class="form-control"
                                        value="<?= isset($user_details['employee_id']) ? $user_details['employee_id'] : '' ?>">
                                </div>
                            </div>
                        </div>

                        <div class="col-md-12 p-2">
                            <div class="row">
                                <div class="col-md-3 font-weight-bold">Cabang</div>
                                <div class="col-md-6">
                                    <select id="cabang_id" class="form-control">
                                        <option value="">- Select -</option>
                                        <?php if (isset($list_cabang) && is_array($list_cabang)): ?>
                                            <?php foreach ($list_cabang as $c): ?>
                                                <option value="<?= $c->id ?>" <?= isset($user_details['cabang_id']) && $user_details['cabang_id'] == $c->id ? 'selected' : '' ?>>
                                                    <?= $c->nama_cabang ?></option>
                                            <?php endforeach; ?>
                                        <?php endif; ?>
                                    </select>
                                </div>
                            </div>
                        </div>

                        <div class="col-md-12 p-2">
                            <div class="row">
                                <div class="col-md-3 font-weight-bold">Divisi</div>
                                <div class="col-md-6">
                                    <select id="divisi_id" class="form-control">
                                        <option value="">- Select -</option>
                                        <?php if (isset($list_divisi) && is_array($list_divisi)): ?>
                                            <?php foreach ($list_divisi as $d): ?>
                                                <option value="<?= $d->id ?>" <?= isset($user_details['divisi_id']) && $user_details['divisi_id'] == $d->id ? 'selected' : '' ?>>
                                                    <?= $d->nama_divisi ?></option>
                                            <?php endforeach; ?>
                                        <?php endif; ?>
                                    </select>
                                </div>
                            </div>
                        </div>

                        <div class="col-md-12 p-2">
                            <div class="row">
                                <div class="col-md-3 font-weight-bold">User Type</div>
                                <div class="col-md-6">
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
                                </div>
                            </div>
                        </div>

                        <div class="col-md-12 p-2">
                            <div class="row">
                                <div class="col-md-3 font-weight-bold">Status</div>
                                <div class="col-md-6">
                                    <select id="status" class="form-control">
                                        <option value="1" <?= $user_details['status'] == 1 ? 'selected' : '' ?>>Active</option>
                                        <option value="0" <?= $user_details['status'] == 0 ? 'selected' : '' ?>>Inactive</option>
                                    </select>
                                </div>
                            </div>
                        </div>

                        <div class="col-md-12 p-2">
                            <div class="row">
                                <div class="col-md-3 font-weight-bold">Created On</div>
                                <div class="col-md-9"><span class="rel-time"
                                        data-value="<?= $user_details['created'] ?>000"></span></div>
                            </div>
                        </div>

                        <div class="col-md-12 p-2">
                            <div class="row">
                                <div class="col-md-3 font-weight-bold">Last Updated</div>
                                <div class="col-md-9"><span class="rel-time"
                                        data-value="<?= $user_details['updated'] ?>000"></span></div>
                            </div>
                        </div>

                        <hr>
                        <div class="col-md-12 p-2">
                            <div class="row p-2">
                                <a href="<?= BASE_URL ?>user/list" class="btn btn-secondary pull-right mr-3">
                                    <i class="fa fa-arrow-left"></i> Back to List
                                </a>
                                <button type="button" class="btn btn-success pull-right" id="update_user">
                                    <i class="fa fa-save"></i> Update User
                                </button>
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
        // renderCustomHTML(); // No longer needed for type as it is a select now

        $("#update_user").on('click', function () {
            var user_id = $('#user_id').val();
            var name = $('#name').val();
            var email = $('#email').val();
            var mobile = $('#mobile').val();
            var username = $('#username').val();
            var type = $('#type').val(); // Get selected type
            var status = $('#status').val(); // Get selected status
            var employee_id = $('#employee_id').val();
            var cabang_id = $('#cabang_id').val();
            var divisi_id = $('#divisi_id').val();

            console.log('Updating user:', { user_id, name, email, mobile, username, type, status });

            if (!name || !email || !username) {
                showNotification('error', 'Name, email, and username are required');
                return;
            }

            $.ajax({
                type: 'POST',
                url: BASE_URL + 'API/User/update_user_by_admin',
                dataType: 'json',
                data: {
                    'user_id': user_id,
                    'name': name,
                    'email': email,
                    'mobile': mobile,
                    'username': username,
                    'type': type,
                    'status': status,
                    'employee_id': employee_id,
                    'cabang_id': cabang_id,
                    'divisi_id': divisi_id
                },
                success: function (response) {
                    console.log('Response:', response);

                    if (response && response.data) {
                        // Success if result is true OR raw_result >= 0
                        if (response.data.result === true || response.data.raw_result >= 0) {
                            showNotification('success', 'User updated successfully');
                            setTimeout(function () {
                                window.location.href = BASE_URL + 'user/list';
                            }, 1500);
                        } else {
                            var msg = response.data.message || 'User could not be updated.';
                            showNotification('error', msg);
                            console.error('Update failed logic:', response);
                        }
                    }
                    else {
                        showNotification('error', 'Invalid server response');
                        console.error('Invalid response:', response);
                    }
                },
                error: function (xhr, status, error) {
                    console.error('AJAX error:', xhr.responseText);
                    showNotification('error', 'An error occurred: ' + error);
                }
            });
        });
    });
</script>