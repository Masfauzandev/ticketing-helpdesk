<div class="page login-page">
    <div class="container d-flex align-items-center">
        <div class="form-holder">
            <div class="row">
                <!-- Left Panel - Branding -->
                <div class="col-lg-6 login-left-panel d-flex align-items-center">
                    <div class="login-left-content m-auto">
                        <div class="left-brand-icon">
                            <i class="fa fa-key"></i>
                        </div>
                        <h1>Forgot Password?</h1>
                        <p class="left-subtitle">Jangan khawatir, kami akan membantu Anda<br>mereset password akun Anda</p>
                        <ul class="left-features">
                            <li><i class="fa fa-envelope"></i> Masukkan username & email terdaftar</li>
                            <li><i class="fa fa-shield"></i> Verifikasi identitas Anda</li>
                            <li><i class="fa fa-refresh"></i> Dapatkan password baru</li>
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

                <!-- Right Panel - Forgot Password Form -->
                <div class="col-lg-6 login-right-panel">
                    <div class="login-form-wrapper">
                        <div class="login-form-card">
                            <!-- Logo -->
                            <div class="login-logo-wrap">
                                <img src="<?= BASE_URL ?>assets/img/logo/logo.png" alt="Logo" class="login-logo">
                            </div>

                            <!-- Form Header -->
                            <div class="login-form-header">
                                <h2>Reset Password</h2>
                                <p>Masukkan username dan email yang terdaftar</p>
                            </div>

                            <!-- Forgot Password Form -->
                            <form method="post" class="form-validate" action="<?php echo base_url('auth/process_forgot') ?>" enctype="multipart/form-data">
                                <input type="hidden" name="<?= $this->security->get_csrf_token_name() ?>" value="<?= $this->security->get_csrf_hash() ?>">

                                <!-- Username -->
                                <div class="login-input-group">
                                    <i class="fa fa-user input-icon"></i>
                                    <input id="forgot-username" type="text" name="username" required
                                        placeholder="Username" data-msg="Please enter your username">
                                </div>

                                <!-- Email -->
                                <div class="login-input-group">
                                    <i class="fa fa-envelope input-icon"></i>
                                    <input id="forgot-email" type="text" name="email" required
                                        placeholder="Email" data-msg="Please enter your email">
                                </div>

                                <!-- Submit Button -->
                                <button type="submit" class="login-btn">
                                    <i class="fa fa-paper-plane" style="margin-right: 8px;"></i>Kirim Reset Link
                                </button>
                            </form>

                            <!-- Messages -->
                            <div class="login-messages">
                                <?= get_msg(); ?>
                            </div>

                            <!-- Links -->
                            <div class="login-links">
                                <span class="divider"></span>
                                <span class="signup-text">Ingat password Anda? <a href="<?= URL_LOGIN ?>" class="signup-link">Sign In</a></span>
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