<div class="register-background">
     <!-- <div class="page login-page"> -->
        <div class="container d-flex justify-content-center align-items-center" style="min-height: 100vh;"> 
            <div class="form-holder p-4" style="max-width: 900px; width:100%; border-radius: 20px;">

<!-- Register form -->
<form action="#" method="post">
	<input type="hidden" name="<?= $this->security->get_csrf_token_name() ?>" value="<?= $this->security->get_csrf_hash() ?>">
	<div class="card mb-0  login-card">
		<div class="card-body">
			<div class="text-center mb-3">
				<a href="<?php echo base_url() ?>">
					<div class=" p-picture"></div>
				</a>
				<h2 class="mb-0" style="color:black">Create account</h2>
				<span class="d-block text-muted"
					  style="color:black">Please enter the information below</span>
			</div>

			<?php get_msg(); ?>
			<!-- KOTAK 1: employee biodata -->
				<div class="card mb-4">
					<div class="card-header">
						<strong>Employee Biodata</strong>
					</div>

					<div class="card-body">

						<!-- Baris 1: Nama Lengkap (kiri), Nama Panggilan (kanan) -->
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

						<!-- Baris 2: Jenis Kelamin (kiri), ID Karyawan (kanan) -->
						<div class="row mb-3">
							<div class="col-md-6">
								<div class="form-group">
							
									<label>Gender</label><code>*</code>
									<select name="gender" class="form-control" required>
										<option value="">-- Choose Gender --</option>
										<?php if (!empty($data['list_gender'])): ?>
											<?php foreach ($data['list_gender'] as $jk): ?>
												<option value="<?= $jk->id; ?>"><?= $jk->nama; ?></option>
											<?php endforeach; ?>
										<?php endif; ?>
									</select>
								</div>
							</div>

							<!-- ID Karyawan di sebelah kanan jenis kelamin -->
							<div class="col-md-6">
								<div class="form-group">
									<label>Employee ID</label><code>*</code>
									<input type="text" name="employee_id" class="form-control"
										placeholder="Example : 2332311" required>
								</div>
							</div>

						</div>

						<!-- Baris 3: Jabatan (kiri), Cabang (kanan) -->
						<div class="row mb-3">

							<div class="col-md-6">
								<div class="form-group">
									<label>Divisi</label><code>*</code>
									<select name="divisi" class="form-control" required>
										<option value="">-- Choose Divisi --</option>
										<?php foreach ($data['list_divisi'] as $j): ?>
											<option value="<?= $j->id ?>"><?= $j->nama_divisi ?></option>
										<?php endforeach; ?>
									</select>
								</div>
							</div>

							<div class="col-md-6">
								<div class="form-group">
									<label>Cabang</label><code>*</code>
									<select name="cabang" class="form-control" required>
										<option value="">-- Choose Cabang --</option>
										<?php foreach ($data['list_cabang'] as $c): ?>
											<option value="<?= $c->id ?>"><?= $c->nama_cabang ?></option>
										<?php endforeach; ?>
									</select>
								</div>
							</div>

						</div>

						<!-- Baris 4: No HP (kiri), Email Kantor (kanan) -->
						<div class="row mb-3">

							<div class="col-md-6">
								<div class="form-group">
									<label>No HP</label><code>*</code>
									<input type="text" name="no_hp" class="form-control"
										placeholder="081234567890" required>
								</div>
							</div>

							<div class="col-md-6">
								<div class="form-group">
									<label>Office Email</label><code>*</code>
									<input type="email" name="office_email" class="form-control"
										placeholder="example : it@gasindogroup.com" required>
								</div>
							</div>

						</div>

					</div>
				</div>


				<!-- KOTAK 2: AKUN -->
				<div class="card mb-4">
					<div class="card-header">
						<strong>Account</strong>
					</div>

					<div class="card-body">

						<!-- Username -->
						<div class="row mb-3">
							<div class="col-md-6">
								<div class="form-group">
									<label>Username</label><code>*</code>
									<input type="text" name="username" class="form-control"
										placeholder="Enter username" required>
								</div>
							</div>
						</div>

						<!-- Password -->
						<div class="row mb-3">
							<div class="col-md-6">
								<div class="form-group">
									<label>Password</label><code>*</code>
									<input type="password" name="password" class="form-control"
										placeholder="Minimum 6 karakter" required>
								</div>
							</div>
						</div>

						<!-- Konfirmasi Password -->
						<div class="row mb-1">
							<div class="col-md-6">
								<div class="form-group">
									<label>Confirm Password</label><code>*</code>
									<input type="password" name="password_confirm" class="form-control"
										placeholder="Repeat Password" required>
								</div>
							</div>
						</div>

					</div>
				</div>


			<div class="form-group">
				<button type="submit" class="btn btn-primary btn-block">submit<i
						class="icon-circle-right2 ml-2"></i></button>
			</div>
			<div class="form-group text-center">
				<a href="<?= URL_LOGIN ?>" class="ml-auto">Already have an
					account?</a>
			</div>
			<?PHP include "powered.php"; ?>
		</div>
	</div>

</form>
<!-- /login form -->

			
			</div>
       </div>
    <!-- </div> -->
</div>


