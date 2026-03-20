<!-- Dashboard Counts Section-->
<section class="">
    <div class="container-fluid">
        <div class="row">
            <div class="col-lg-12">
                <div class="card">
                    <div class="card-header d-flex align-items-center">
                        <h3 class="h4"><i class="fa fa-user"></i>
                            <?= $title ?>
                        </h3>
                    </div>
                    <div class="card-body">
                        <div class="col-md-12 p-2">
                            <div class="row ">
                                <div class="col-md-3">Current Type</div>
                                <div class="col-md-4">
                                    <span class="user-type" data-value="<?= $current_type ?>"></span>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-12 p-2">
                            <div class="row ">
                                <div class="col-md-3">New Type</div>
                                <div class="col-md-4">
                                    <select id="new_type" class="form-control">
                                        <option value="10" <?= $current_type == 10 ? 'selected' : '' ?>>Member</option>
                                        <option value="60" <?= $current_type == 60 ? 'selected' : '' ?>>Agent</option>
                                        <option value="80" <?= $current_type == 80 ? 'selected' : '' ?>>Manager</option>
                                        <option value="100" <?= $current_type == 100 ? 'selected' : '' ?>>Admin</option>
                                    </select>
                                </div>
                            </div>
                        </div>
                        <hr>
                        <div class="col-md-12 p-2">
                            <div class="form group ">
                                <a href="<?= BASE_URL ?>user/profile" class="btn btn-secondary pull-left mr-3"><i
                                        class="fa fa-arrow-left"></i> Back to profile</a>
                                <button type="button" class="btn btn-success pull-left" id="change_type">Update
                                    Type</button>
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
        renderCustomHTML(); // Render badge for current type

        $("#change_type").on('click', function () {
            var new_type = $('#new_type').val();

            if (!new_type) {
                showNotification('error', 'All fields are required');
                return;
            }

            $.ajax({
                type: 'POST',
                url: BASE_URL + 'API/User/change_type',
                dataType: 'json',
                data: { 'new_type': new_type },
                success: function (response) {
                    if (response) {
                        showNotification('success', 'User Type changed successfully');
                        setTimeout(function () {
                            window.location.href = BASE_URL + 'user/profile';
                        }, 1500);
                    }
                    else {
                        showNotification('error', 'User Type could not be changed (Wrong password?)');
                    }
                },
                error: function (xhr, status, error) {
                    showNotification('error', 'An error occurred: ' + error);
                }
            });
        });
    });
</script>