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
                                <div class="col-md-3">Current Divisi</div>
                                <div class="col-md-4"><input type="text" class="form-control"
                                        value="<?= $current_divisi_name ?>" readonly></div>
                            </div>
                        </div>
                        <div class="col-md-12 p-2">
                            <div class="row ">
                                <div class="col-md-3">New Divisi</div>
                                <div class="col-md-4">
                                    <select id="new_divisi_id" class="form-control">
                                        <option value="">- Select Divisi -</option>
                                        <?php foreach ($list_divisi as $d): ?>
                                            <option value="<?= $d->id ?>" <?= $current_divisi_id == $d->id ? 'selected' : '' ?>>
                                                <?= $d->nama_divisi ?>
                                            </option>
                                        <?php endforeach; ?>
                                    </select>
                                </div>
                            </div>
                        </div>
                        <hr>
                        <div class="col-md-12 p-2">
                            <div class="form group ">
                                <a href="<?= BASE_URL ?>user/profile" class="btn btn-secondary pull-left mr-3"><i
                                        class="fa fa-arrow-left"></i> Back to profile</a>
                                <button type="button" class="btn btn-success pull-left" id="change_divisi">Update
                                    Divisi</button>
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
        $("#change_divisi").on('click', function () {
            var new_divisi_id = $('#new_divisi_id').val();

            if (!new_divisi_id) {
                showNotification('error', 'All fields are required');
                return;
            }

            $.ajax({
                type: 'POST',
                url: BASE_URL + 'API/User/change_divisi',
                dataType: 'json',
                data: { 'new_divisi_id': new_divisi_id },
                success: function (response) {
                    if (response) {
                        showNotification('success', 'Divisi changed successfully');
                        setTimeout(function () {
                            window.location.href = BASE_URL + 'user/profile';
                        }, 1500);
                    }
                    else {
                        showNotification('error', 'Divisi could not be changed (Wrong password?)');
                    }
                },
                error: function (xhr, status, error) {
                    showNotification('error', 'An error occurred: ' + error);
                }
            });
        });
    });
</script>