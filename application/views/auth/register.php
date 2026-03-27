<div class="page login-page register-page">
    <div class="container d-flex align-items-center">
        <div class="form-holder">
            <div class="row">
                <!-- Left Panel - Branding -->
                <div class="col-lg-5 login-left-panel d-flex align-items-center">
                    <div class="login-left-content m-auto">
                        <div class="left-brand-icon">
                            <i class="fa fa-user-plus"></i>
                        </div>
                        <h1>Join Us</h1>
                        <p class="left-subtitle">Buat akun baru untuk mulai menggunakan<br>sistem helpdesk & ticketing kami</p>
                        <ul class="left-features">
                            <li><i class="fa fa-check-circle"></i> Akses penuh ke sistem ticketing</li>
                            <li><i class="fa fa-comments"></i> Komunikasi langsung dengan tim support</li>
                            <li><i class="fa fa-bar-chart"></i> Dashboard monitoring personal</li>
                        </ul>
                    </div>
                    <!-- Decorative elements -->
                    <div class="login-left-decor-sm"></div>
                    <div class="login-left-decor-dots">
                        <span></span><span></span><span></span><span></span><span></span>
                        <span></span><span></span><span></span><span></span><span></span>
                        <span></span><span></span><span></span><span></span><span></span>
                    </div>
                </div>

                <!-- Right Panel - Register Form -->
                <div class="col-lg-7 login-right-panel register-right-panel">
                    <div class="login-form-wrapper register-form-wrapper">
                        <div class="login-form-card">
                            <!-- Logo -->
                            <div class="login-logo-wrap">
                                <img src="<?= BASE_URL ?>assets/img/logo/logo.png" alt="Logo" class="login-logo">
                            </div>

                            <!-- Form Header -->
                            <div class="login-form-header">
                                <h2>Create Account</h2>
                                <p>Lengkapi data di bawah ini untuk membuat akun baru</p>
                            </div>

                            <!-- Register Form -->
                            <form action="#" method="post" class="form-validate">
                                <input type="hidden" name="<?= $this->security->get_csrf_token_name() ?>" value="<?= $this->security->get_csrf_hash() ?>">

                                <!-- Messages -->
                                <div class="login-messages" style="margin-top:0; margin-bottom:12px;">
                                    <?php get_msg(); ?>
                                </div>

                                <!-- Section: Employee Biodata -->
                                <div class="register-section">
                                    <div class="register-section-header">
                                        <i class="fa fa-id-card"></i> Employee Biodata
                                    </div>
                                    <div class="register-section-body">
                                        <div class="row">
                                            <div class="col-md-6">
                                                <div class="login-input-group">
                                                    <i class="fa fa-user input-icon"></i>
                                                    <input type="text" name="full_name" required placeholder="Full Name *">
                                                </div>
                                            </div>
                                            <div class="col-md-6">
                                                <div class="login-input-group">
                                                    <i class="fa fa-user-o input-icon"></i>
                                                    <input type="text" name="call_name" placeholder="Call Name">
                                                </div>
                                            </div>
                                        </div>
                                        <div class="row">
                                            <div class="col-md-6">
                                                <div class="login-input-group register-select-group">
                                                    <i class="fa fa-venus-mars input-icon"></i>
                                                    <select name="gender" required>
                                                        <option value="">-- Gender * --</option>
                                                        <?php if (!empty($data['list_gender'])): ?>
                                                            <?php foreach ($data['list_gender'] as $jk): ?>
                                                                <option value="<?= $jk->id; ?>"><?= $jk->nama; ?></option>
                                                            <?php endforeach; ?>
                                                        <?php endif; ?>
                                                    </select>
                                                </div>
                                            </div>
                                            <div class="col-md-6">
                                                <div class="login-input-group">
                                                    <i class="fa fa-id-badge input-icon"></i>
                                                    <input type="text" name="employee_id" required placeholder="Employee ID *">
                                                </div>
                                            </div>
                                        </div>
                                        <div class="row">
                                            <div class="col-md-6">
                                                <div class="login-input-group register-select-group">
                                                    <i class="fa fa-sitemap input-icon"></i>
                                                    <select name="divisi" required>
                                                        <option value="">-- Divisi * --</option>
                                                        <?php foreach ($data['list_divisi'] as $j): ?>
                                                            <option value="<?= $j->id ?>"><?= $j->nama_divisi ?></option>
                                                        <?php endforeach; ?>
                                                    </select>
                                                </div>
                                            </div>
                                            <div class="col-md-6">
                                                <div class="login-input-group register-select-group">
                                                    <i class="fa fa-building input-icon"></i>
                                                    <select name="cabang" required>
                                                        <option value="">-- Cabang * --</option>
                                                        <?php foreach ($data['list_cabang'] as $c): ?>
                                                            <option value="<?= $c->id ?>"><?= $c->nama_cabang ?></option>
                                                        <?php endforeach; ?>
                                                    </select>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="row">
                                            <div class="col-md-6">
                                                <div class="login-input-group">
                                                    <i class="fa fa-phone input-icon"></i>
                                                    <input type="text" name="no_hp" required placeholder="No HP *">
                                                </div>
                                            </div>
                                            <div class="col-md-6">
                                                <div class="login-input-group">
                                                    <i class="fa fa-envelope input-icon"></i>
                                                    <input type="email" name="office_email" required placeholder="Office Email *">
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>

                                <!-- Section: Account -->
                                <div class="register-section">
                                    <div class="register-section-header">
                                        <i class="fa fa-lock"></i> Account
                                    </div>
                                    <div class="register-section-body">
                                        <div class="row">
                                            <div class="col-md-12">
                                                <div class="login-input-group">
                                                    <i class="fa fa-user-circle input-icon"></i>
                                                    <input type="text" name="username" required placeholder="Username *">
                                                </div>
                                            </div>
                                        </div>
                                        <div class="row">
                                            <div class="col-md-6">
                                                <div class="login-input-group">
                                                    <i class="fa fa-lock input-icon"></i>
                                                    <input type="password" name="password" required placeholder="Password *">
                                                </div>
                                            </div>
                                            <div class="col-md-6">
                                                <div class="login-input-group">
                                                    <i class="fa fa-lock input-icon"></i>
                                                    <input type="password" name="password_confirm" required placeholder="Confirm Password *">
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>

                                <!-- Submit Button -->
                                <button type="submit" class="login-btn">
                                    <i class="fa fa-user-plus" style="margin-right: 8px;"></i>Daftar Akun
                                </button>
                            </form>

                            <!-- Links -->
                            <div class="login-links">
                                <span class="divider"></span>
                                <span class="signup-text">Sudah punya akun? <a href="<?= URL_LOGIN ?>" class="signup-link">Sign In</a></span>
                            </div>
                        </div>

                        <!-- Copyright -->
                        <div class="login-copyright">
                            <p>Powered by <strong>gasindogroup</strong></p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
