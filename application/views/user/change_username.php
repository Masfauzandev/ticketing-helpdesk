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
                                <div class="col-md-3">Current Username</div>
                                <div class="col-md-4"><input type="text" id="current_username" class="form-control"
                                        value="<?= $current_username ?>" readonly></div>
                            </div>
                        </div>
                        <div class="col-md-12 p-2">
                            <div class="row ">
                                <div class="col-md-3">New Username</div>
                                <div class="col-md-4"><input type="text" id="new_username" class="form-control"></div>
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
                                <button type="button" class="btn btn-success pull-left" id="change_username">Update
                                    Username</button>
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
        console.log('Change username page loaded');
        console.log('Button exists:', $('#change_username').length);

        $("#change_username").on('click', function () {
            console.log('Change username button clicked!');
            var password = $('#confirm_password').val();
            var new_username = $('#new_username').val();

            if (!new_username || !password) {
                showNotification('error', 'All fields are required');
                return;
            }

            $.ajax({
                type: 'POST',
                url: BASE_URL + 'API/User/change_username',
                dataType: 'text',
                data: { 'password': password, 'new_username': new_username },
                success: function (response) {
                    console.log('Response:', response);
                    if (response) {
                        showNotification('success', 'Username changed successfully');
                        setTimeout(function () {
                            window.location.href = BASE_URL + 'user/profile';
                        }, 1500);
                    }
                    else {
                        showNotification('error', 'Username could not be changed.');
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