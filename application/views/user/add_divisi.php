<section class="forms">
    <div class="container-fluid">
        <div class="row">
            <div class="col-lg-12">
                <div class="card">
                    <div class="card-header d-flex align-items-center">
                        <h3 class="h4">Add Divisi</h3>
                    </div>
                    <div class="card-body">
                        <div class="form-group">
                            <input type="hidden" id="edit_id">
                            <label>Nama Divisi</label><code>*</code>
                            <input type="text" id="nama_divisi" class="form-control" placeholder="Enter Nama Divisi">
                        </div>
                        <div class="form-group">
                            <button id="btn_save" class="btn btn-primary">Save</button>
                            <a href="<?= BASE_URL ?>user/add_divisi" class="btn btn-secondary">Cancel/Reset</a>
                        </div>
                    </div>
                </div>

                <!-- List Divisi -->
                <div class="card mt-4">
                    <div class="card-header">Existing Divisi</div>
                    <div class="card-body">
                        <table class="table table-striped">
                            <thead>
                                <tr>
                                    <th style="font-size: 1.2rem;">#</th>
                                    <th style="font-size: 1.2rem;">Nama Divisi</th>
                                    <th style="font-size: 1.2rem;">Action</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php if (!empty($list_divisi)): ?>
                                    <?php foreach ($list_divisi as $d): ?>
                                        <tr>
                                            <td style="font-size: 1.2rem;"><?= $d->id ?></td>
                                            <td style="font-size: 1.2rem;"><?= $d->nama_divisi ?></td>
                                            <td>
                                                <button class="btn btn-warning btn-sm edit-item" data-id="<?= $d->id ?>"
                                                    data-name="<?= $d->nama_divisi ?>"><i class="fa fa-edit"></i></button>
                                                <button class="btn btn-danger btn-sm delete-item" data-id="<?= $d->id ?>"><i
                                                        class="fa fa-trash"></i></button>
                                            </td>
                                        </tr>
                                    <?php endforeach; ?>
                                <?php else: ?>
                                    <tr>
                                        <td colspan="3">No data found</td>
                                    </tr>
                                <?php endif; ?>
                            </tbody>
                        </table>
                    </div>
                </div>

            </div>
        </div>
    </div>
</section>

<script>
    $(document).ready(function () {
        $("#btn_save").click(function () {
            var nama = $("#nama_divisi").val();
            var edit_id = $("#edit_id").val();

            if (!nama) {
                showNotification('error', 'Nama Divisi is required');
                return;
            }

            var url = BASE_URL + 'API/Master/add_divisi';
            var data = { 'nama_divisi': nama };

            if (edit_id) {
                url = BASE_URL + 'API/Master/update_divisi';
                data.id = edit_id;
            }

            $.ajax({
                type: 'POST',
                url: url,
                dataType: 'json',
                data: data,
                success: function (response) {
                    if (response.result) {
                        var msg = edit_id ? 'Divisi updated successfully' : 'Divisi added successfully';
                        showNotification('success', msg);
                        $("#nama_divisi").val('');
                        $("#edit_id").val('');
                        $("#btn_save").text('Save');
                        setTimeout(function () { location.reload(); }, 1000);
                    } else {
                        showNotification('error', response.message || 'Unknown error occurred.');
                    }
                },
                error: function (xhr, status, error) {
                    showNotification('error', 'Error: ' + error);
                }
            });
        });

        $(document).on('click', '.edit-item', function () {
            var id = $(this).data('id');
            var name = $(this).data('name');
            $("#edit_id").val(id);
            $("#nama_divisi").val(name);
            $("#btn_save").text('Update');
            // Scroll to top
            $('html, body').animate({ scrollTop: 0 }, 'fast');
        });

        $(document).on('click', '.delete-item', function () {
            var id = $(this).data('id');
            if (!confirm('Are you sure you want to delete this item?')) return;

            $.ajax({
                type: 'POST',
                url: BASE_URL + 'API/Master/delete_divisi',
                dataType: 'json',
                data: { 'id': id },
                success: function (response) {
                    if (response.result) {
                        showNotification('success', 'Divisi deleted');
                        setTimeout(function () { location.reload(); }, 1000);
                    } else {
                        showNotification('error', response.message || 'Error deleting');
                    }
                },
                error: function () { showNotification('error', 'Error deleting'); }
            });
        });
    });
</script>