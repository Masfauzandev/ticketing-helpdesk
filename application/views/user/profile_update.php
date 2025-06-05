<!-- Bagian View (readonly) -->
<div id="profile_view">
    <div class="col-md-12 p-2">
        <div class="row">
            <div class="col-md-3 font-weight-bold">Name</div>
            <div class="col-md-9"><?= $user_details['name'] ?></div>
        </div>
    </div>
    <div class="col-md-12 p-2">
        <div class="row">
            <div class="col-md-3 font-weight-bold">Email</div>
            <div class="col-md-9"><?= $user_details['email'] ?></div>
        </div>
    </div>
    <div class="col-md-12 p-2">
        <div class="row">
            <div class="col-md-3 font-weight-bold">Mobile</div>
            <div class="col-md-9"><?= $user_details['mobile'] ?></div>
        </div>
    </div>
    <div class="col-md-12 p-2">
        <div class="row">
            <div class="col-md-3 font-weight-bold">Username</div>
            <div class="col-md-9"><?= $user_details['username'] ?></div>
        </div>
    </div>

    <div class="col-md-12 p-2 text-right">
        <button class="btn btn-primary" id="edit_profile_btn">Edit Profile</button>
    </div>
</div>

<!-- Bagian Form Edit -->
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

<!-- Script Toggle -->
<script>
    document.getElementById('edit_profile_btn').addEventListener('click', function () {
        document.getElementById('profile_view').style.display = 'none';
        document.getElementById('profile_edit').style.display = 'block';
    });
</script>
