<div class="page login-page">
    <div class="container d-flex align-items-center">
        <div class="form-holder has-shadow">
            <div class="row">
                <!-- Logo & Information Panel-->
                <div class="col-lg-6 login-left-panel d-flex align-items-center">
                    <div class="login-left-content m-auto">
                        <h1>Welcome to LKI</h1>
                    </div>
                </div>
                <!-- Form Panel    -->
                <div class="col-lg-6 bg-white">
                    <div class="form d-flex align-items-center">
                        <div class="content">
                            <!-- Logo Perusahaan -->
                            <div class="text-center mb-4">
                                <img src="<?= BASE_URL ?>assets/img/logo/logo.png" alt="Logo" class="login-logo">
                            </div>
                            <form method="post" class="form-validate" action="">
                                <input type="hidden" name="<?= $this->security->get_csrf_token_name() ?>" value="<?= $this->security->get_csrf_hash() ?>">
                                <div class="form-group">
                                    <input id="login-username" type="text" name="username" required
                                        data-msg="Please enter your username" class="input-material">
                                    <label for="login-username" class="label-material">User Name</label>
                                </div>
                                <div class="form-group" style="position: relative;">
                                    <input id="login-password" type="password" name="password" required
                                        data-msg="Please enter your password" class="input-material"
                                        style="padding-right: 40px;">
                                    <label for="login-password" class="label-material">Password</label>
                                    <span class="toggle-login-password"
                                        style="position: absolute; right: 10px; top: 10px; cursor: pointer; user-select: none;">
                                        <i class="fa fa-eye" style="color: #999;"></i>
                                    </span>
                                </div>
                                <button type="submit" id="login" href="" class="btn btn-primary">Login</button>
                                <!-- This should be submit button but I replaced it with <a> for demo purposes-->
                            </form>
                            <div>
                                <?= get_msg(); ?>
                            </div>
                            <a href="<?= BASE_URL ?>auth/forgot_password" class="forgot-pass">Forgot
                                Password?</a><br><small>Do not have an account?</small><a
                                href="<?= BASE_URL ?>auth/register" class="signup">Sign Up</a>
                        </div>

                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="copyrights text-center text-dark">
        <p>Powered by <strong>gasindogroup</strong></p>
    </div>
</div>

<script>
    // Hold to show password on login page - using vanilla JS + jQuery fallback
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