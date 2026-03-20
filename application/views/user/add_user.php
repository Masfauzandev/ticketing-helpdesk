<section class="forms">
    <div class="container-fluid">
        <div class="row">
            <div class="col-lg-12">
                <div class="card">
                    <div class="card-header d-flex align-items-center">
                        <h3 class="h4"><?= $title ?></h3>
                    </div>
                    <div class="card-body">

                        <!-- Show Messages -->
                        <?php get_msg(); ?>

                        <form method="post" action="">
                            <input type="hidden" name="<?= $this->security->get_csrf_token_name() ?>" value="<?= $this->security->get_csrf_hash() ?>">

                            <!-- Employee Biodata -->
                            <div class="card mb-4">
                                <div class="card-header bg-primary text-white">
                                    <strong>Employee Biodata</strong>
                                </div>
                                <div class="card-body">
                                    <!-- Row 1: Full Name & Call Name -->
                                    <div class="row mb-3">
                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <label>Full Name</label><code>*</code>
                                                <input type="text" name="full_name" class="form-control"
                                                    placeholder="Enter Full Name" required>
                                            </div>
                                        </div>
                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <label>Call Name</label>
                                                <input type="text" name="call_name" class="form-control"
                                                    placeholder="Enter Call Name">
                                            </div>
                                        </div>
                                    </div>

                                    <!-- Row 2: Gender & Employee ID -->
                                    <div class="row mb-3">
                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <label>Gender</label><code>*</code>
                                                <select name="gender" class="form-control" required>
                                                    <option value="">-- Choose Gender --</option>
                                                    <?php if (!empty($list_gender)): ?>
                                                        <?php foreach ($list_gender as $jk): ?>
                                                            <option value="<?= $jk->id; ?>"><?= $jk->nama; ?></option>
                                                        <?php endforeach; ?>
                                                    <?php endif; ?>
                                                </select>
                                            </div>
                                        </div>
                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <label>Employee ID</label><code>*</code>
                                                <input type="text" name="employee_id" class="form-control"
                                                    placeholder="Example : 2332311" required>
                                            </div>
                                        </div>
                                    </div>

                                    <!-- Row 3: Divisi & Cabang -->
                                    <div class="row mb-3">
                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <label>Divisi</label><code>*</code>
                                                <select name="divisi" class="form-control" required>
                                                    <option value="">-- Choose Divisi --</option>
                                                    <?php if (!empty($list_divisi)): ?>
                                                        <?php foreach ($list_divisi as $j): ?>
                                                            <option value="<?= $j->id ?>"><?= $j->nama_divisi ?></option>
                                                        <?php endforeach; ?>
                                                    <?php endif; ?>
                                                </select>
                                            </div>
                                        </div>
                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <label>Cabang</label><code>*</code>
                                                <select name="cabang" class="form-control" required>
                                                    <option value="">-- Choose Cabang --</option>
                                                    <?php if (!empty($list_cabang)): ?>
                                                        <?php foreach ($list_cabang as $c): ?>
                                                            <option value="<?= $c->id ?>"><?= $c->nama_cabang ?></option>
                                                        <?php endforeach; ?>
                                                    <?php endif; ?>
                                                </select>
                                            </div>
                                        </div>
                                    </div>

                                    <!-- Row 4: No HP & Email -->
                                    <div class="row mb-3">
                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <label>No HP</label><code>*</code>
                                                <input type="text" name="mobile" class="form-control"
                                                    placeholder="081234567890" required>
                                            </div>
                                        </div>
                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <label>Office Email</label><code>*</code>
                                                <input type="email" name="email" class="form-control"
                                                    placeholder="example : it@gasindogroup.com" required>
                                            </div>
                                        </div>
                                    </div>

                                    <!-- Row 5: User Type (Admin Only) -->
                                    <div class="row mb-3">
                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <label>User Type</label><code>*</code>
                                                <select name="type" class="form-control" required>
                                                    <option value="10">Member</option>
                                                    <option value="60">Agent</option>
                                                    <option value="80">Manager</option>
                                                    <option value="100">Admin</option>
                                                </select>
                                            </div>
                                        </div>
                                    </div>

                                </div>
                            </div>

                            <!-- Account -->
                            <div class="card mb-4">
                                <div class="card-header bg-primary text-white">
                                    <strong>Account</strong>
                                </div>
                                <div class="card-body">
                                    <div class="row mb-3">
                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <label>Username</label><code>*</code>
                                                <input type="text" name="username" class="form-control"
                                                    placeholder="Enter username" required>
                                            </div>
                                        </div>
                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <label>Password</label><code>*</code>
                                                <input type="password" name="password" class="form-control"
                                                    placeholder="Minimum 6 characters" required>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <div class="form-group p-3">
                                <input type="submit" value="Add User" class="btn btn-primary pull-right">
                            </div>

                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>