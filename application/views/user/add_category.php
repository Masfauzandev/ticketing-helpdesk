<section class="forms">
    <div class="container-fluid">
        <div class="row">
            <div class="col-lg-12">
                <div class="card">
                    <div class="card-header d-flex align-items-center">
                        <h3 class="h4">Add Category</h3>
                    </div>
                    <div class="card-body">
                        <div class="form-group">
                            <input type="hidden" id="edit_id">
                            <label>Category Name</label><code>*</code>
                            <input type="text" id="name" class="form-control" placeholder="Enter Category Name">
                        </div>
                        <div class="form-group">
                            <button id="btn_save" class="btn btn-primary">Save</button>
                            <a href="<?= BASE_URL ?>user/add_category" class="btn btn-secondary">Cancel/Reset</a>
                        </div>
                    </div>
                </div>

                <!-- List Category -->
                <div class="card mt-4">
                    <div class="card-header">Existing Categories</div>
                    <div class="card-body">
                        <table class="table table-striped">
                            <thead>
                                <tr>
                                    <th style="font-size: 1.2rem;">#</th>
                                    <th style="font-size: 1.2rem;">Category Name</th>
                                    <th style="font-size: 1.2rem;">Action</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php if (!empty($list_category)): ?>
                                    <?php foreach ($list_category as $c): ?>
                                        <tr>
                                            <td style="font-size: 1.2rem;"><?= $c->id ?></td>
                                            <td style="font-size: 1.2rem;"><?= $c->name ?></td>
                                            <td>
                                                <button class="btn btn-warning btn-sm edit-item" data-id="<?= $c->id ?>"
                                                    data-name="<?= $c->name ?>"><i class="fa fa-edit"></i></button>
                                                <button class="btn btn-danger btn-sm delete-item" data-id="<?= $c->id ?>"><i
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
            var nama = $("#name").val();
            var edit_id = $("#edit_id").val();

            if (!nama) {
                showNotification('error', 'Category Name is required');
                return;
            }

            var url = BASE_URL + 'API/Master/add_category';
            var data = { 'name': nama };

            if (edit_id) {
                url = BASE_URL + 'API/Master/update_category';
                data.id = edit_id;
            }

            $.ajax({
                type: 'POST',
                url: url,
                dataType: 'json',
                data: data,
                success: function (response) {
                    if (response.result) {
                        var msg = edit_id ? 'Category updated successfully' : 'Category added successfully';
                        showNotification('success', msg);
                        $("#name").val('');
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
            var name_val = $(this).data('name');
            $("#edit_id").val(id);
            $("#name").val(name_val);
            $("#btn_save").text('Update');
            // Scroll to top
            $('html, body').animate({ scrollTop: 0 }, 'fast');
        });

        $(document).on('click', '.delete-item', function () {
            var id = $(this).data('id');
            if (!confirm('Are you sure you want to delete this item?')) return;

            $.ajax({
                type: 'POST',
                url: BASE_URL + 'API/Master/delete_category',
                dataType: 'json',
                data: { 'id': id },
                success: function (response) {
                    if (response.result) {
                        showNotification('success', 'Category deleted');
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
