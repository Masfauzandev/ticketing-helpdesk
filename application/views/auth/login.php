<div class="page login-page">
    <div class="container d-flex align-items-center">
        <div class="form-holder">
            <div class="row">
                <!-- Left Panel - Branding -->
                <div class="col-lg-6 login-left-panel d-flex align-items-center">
                    <div class="login-left-content m-auto">
                        <div class="left-brand-icon">
                            <i class="fa fa-headphones"></i>
                        </div>
                        <h1>Welcome to LKI</h1>
                        <p class="left-subtitle">Helpdesk & Ticketing System<br>Layanan support terpadu untuk kebutuhan Anda</p>
                        <ul class="left-features">
                            <li><i class="fa fa-ticket"></i> Buat dan kelola tiket dengan mudah</li>
                            <li><i class="fa fa-clock-o"></i> Pantau progress secara real-time</li>
                            <li><i class="fa fa-users"></i> Kolaborasi tim yang efisien</li>
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

                <!-- Right Panel - Login Form -->
                <div class="col-lg-6 login-right-panel">
                    <div class="login-form-wrapper">
                        <div class="login-form-card">
                            <!-- Logo -->
                            <div class="login-logo-wrap">
                                <img src="<?= BASE_URL ?>assets/img/logo/logo.png" alt="Logo" class="login-logo">
                            </div>

                            <!-- Form Header -->
                            <div class="login-form-header">
                                <h2>Sign In</h2>
                                <p>Masukkan kredensial Anda untuk melanjutkan</p>
                            </div>

                            <!-- Login Form -->
                            <form method="post" class="form-validate" action="">
                                <input type="hidden" name="<?= $this->security->get_csrf_token_name() ?>" value="<?= $this->security->get_csrf_hash() ?>">
                                
                                <!-- Username -->
                                <div class="login-input-group">
                                    <i class="fa fa-user input-icon"></i>
                                    <input id="login-username" type="text" name="username" required
                                        placeholder="Username" data-msg="Please enter your username">
                                </div>

                                <!-- Password -->
                                <div class="login-input-group">
                                    <i class="fa fa-lock input-icon"></i>
                                    <input id="login-password" type="password" name="password" required
                                        placeholder="Password" data-msg="Please enter your password"
                                        style="padding-right: 48px;">
                                    <span class="toggle-password toggle-login-password">
                                        <i class="fa fa-eye"></i>
                                    </span>
                                </div>

                                <!-- Login Button -->
                                <button type="submit" id="login" class="login-btn">
                                    <i class="fa fa-sign-in" style="margin-right: 8px;"></i>Sign In
                                </button>
                            </form>

                            <!-- Messages -->
                            <div class="login-messages">
                                <?= get_msg(); ?>
                            </div>

                            <!-- Links -->
                            <div class="login-links">
                                <a href="<?= BASE_URL ?>auth/forgot_password" class="forgot-link">Lupa Password?</a>
                                <span class="divider"></span>
                                <span class="signup-text">Belum punya akun?<a href="<?= BASE_URL ?>auth/register" class="signup-link">Daftar</a></span>
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

<script>
    // Hold to show password on login page
    (function() {
        function initPasswordToggle() {
            var passwordInput = document.getElementById('login-password');
            var toggleIcon = document.querySelector('.toggle-login-password');
            
            if (!passwordInput || !toggleIcon) {
                console.error('Password elements not found');
                return;
            }
            
            var eyeIcon = toggleIcon.querySelector('i');
            
            // Mouse events (for desktop)
            toggleIcon.addEventListener('mousedown', function(e) {
                e.preventDefault();
                passwordInput.type = 'text';
                eyeIcon.classList.remove('fa-eye');
                eyeIcon.classList.add('fa-eye-slash');
            });
            
            toggleIcon.addEventListener('mouseup', function(e) {
                e.preventDefault();
                passwordInput.type = 'password';
                eyeIcon.classList.remove('fa-eye-slash');
                eyeIcon.classList.add('fa-eye');
            });
            
            toggleIcon.addEventListener('mouseleave', function(e) {
                e.preventDefault();
                passwordInput.type = 'password';
                eyeIcon.classList.remove('fa-eye-slash');
                eyeIcon.classList.add('fa-eye');
            });
            
            // Touch events (for mobile)
            toggleIcon.addEventListener('touchstart', function(e) {
                e.preventDefault();
                passwordInput.type = 'text';
                eyeIcon.classList.remove('fa-eye');
                eyeIcon.classList.add('fa-eye-slash');
            });
            
            toggleIcon.addEventListener('touchend', function(e) {
                e.preventDefault();
                passwordInput.type = 'password';
                eyeIcon.classList.remove('fa-eye-slash');
                eyeIcon.classList.add('fa-eye');
            });
            
            console.log('Password toggle initialized');
        }
        
        // Try to initialize when DOM is ready
        if (document.readyState === 'loading') {
            document.addEventListener('DOMContentLoaded', initPasswordToggle);
        } else {
            initPasswordToggle();
        }
    })();
</script>