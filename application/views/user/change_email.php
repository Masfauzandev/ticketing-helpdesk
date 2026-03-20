<!-- Dashboard Counts Section-->
<section class="">
    <div class="container-fluid">
        <div class="row">
            <div class="col-lg-12">
                <div class="card">
                    <div class="card-header d-flex align-items-center">
                        <h3 class="h4"><i class="fa fa-envelope"></i>
                            <?= $title ?>
                        </h3>
                    </div>
                    <div class="card-body">
                        <div class="col-md-12 p-2">
                            <div class="row ">
                                <div class="col-md-3">Current Email</div>
                                <div class="col-md-4"><input type="text" id="current_email" class="form-control"
                                        value="<?= $current_email ?>" readonly></div>
                            </div>
                        </div>
                        <div class="col-md-12 p-2">
                            <div class="row ">
                                <div class="col-md-3">New Email</div>
                                <div class="col-md-4"><input type="email" id="new_email" class="form-control"></div>
                            </div>
                        </div>
                        <div class="col-md-12 p-2">
                            <div class="row ">
                                <div class="col-md-3">Confirm Password</div>
                                <div class="col-md-4"><input type="password" id="confirm_password" class="form-control">
                                </div>
                            </div>
                        </div>
                        <hr>
                        <div class="col-md-12 p-2">
                            <div class="form group ">
                                <a href="<?= BASE_URL ?>user/profile" class="btn btn-secondary pull-left mr-3"><i
                                        class="fa fa-arrow-left"></i> Back to profile</a>
                                <button type="button" class="btn btn-success pull-left" id="change_email">Update
                                    Email</button>
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
        $("#change_email").on('click', function () {
            var password = $('#confirm_password').val();
            var new_email = $('#new_email').val();

            if (!new_email || !password) {
                showNotification('error', 'All fields are required');
                return;
            }

            $.ajax({
                type: 'POST',
                url: BASE_URL + 'API/User/change_email',
                dataType: 'text',
                data: { 'password': password, 'new_email': new_email },
                success: function (response) {
                    if (response) {
                        showNotification('success', 'Email changed successfully');
                        setTimeout(function () {
                            window.location.href = BASE_URL + 'user/profile';
                        }, 1500);
                    }
                    else {
                        showNotification('error', 'Email could not be changed.');
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