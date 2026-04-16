<?php
$msg = '';
if (isset($_POST['add'])) {
    $name = $_POST['name'];
    $email = $_POST['email'];
    $password = $_POST['password'];
    $hashedPass = password_hash($password, PASSWORD_DEFAULT);

    $query = "INSERT INTO librarian_tbl (lb_name, lb_email, lb_password, lb_status) VALUES('$name', '$email', '$hashedPass', 'Active')";
    if (mysqli_query($conn, $query)) {
        $msg = '<div class="alert alert-success">Librarian Added Successfully!</div>';
    } else {
        $msg = '<div class="alert alert-danger">Librarian Added Failed!</div>';
    }
}
?>

<div class="container py-4">
    <div class="row justify-content-center">
        <div class="col-lg-8 col-xl-7">
            <!-- Modern Card -->
            <div class="card border-0 shadow-lg rounded-4 overflow-hidden">
                <!-- Card Header with Gradient -->
                <div class="card-header bg-white border-0 pt-4 px-4 pb-0">
                    <div class="d-flex align-items-center gap-3 mb-2">
                        <div class="bg-primary bg-opacity-10 rounded-3 p-3">
                            <i class="fas fa-user-plus fs-3 text-primary"></i>
                        </div>
                        <div>
                            <h3 class="fw-bold mb-0" style="color: #1e293b;">Add New Librarian</h3>
                            <p class="text-muted small mb-0">Register a new librarian to manage the library system</p>
                        </div>
                    </div>
                </div>

                <!-- Dynamic Message Display -->
                <?php if (isset($msg) && !empty($msg)): ?>
                    <div class="px-4 pt-3">
                        <div class="alert alert-modern alert-dismissible fade show d-flex align-items-center gap-2"
                            style="background: #f0fdf4; border-left: 4px solid #22c55e; border-radius: 16px;">
                            <i class="fas fa-check-circle text-success fs-5"></i>
                            <span class="small"><?= $msg ?></span>
                            <button type="button" class="btn-close ms-auto" data-bs-dismiss="alert"></button>
                        </div>
                    </div>
                <?php endif; ?>

                <!-- Form Body -->
                <div class="card-body p-4 p-xl-5">
                    <form action="" method="post" enctype="multipart/form-data">
                        <!-- Full Name Field -->
                        <div class="mb-4">
                            <label class="form-label fw-semibold text-secondary mb-2">
                                <i class="fas fa-user me-1 text-primary"></i> Full Name <span class="text-danger">*</span>
                            </label>
                            <div class="input-group">
                                <span class="input-group-text bg-light border-end-0 rounded-start-3">
                                    <i class="fas fa-user-circle text-muted"></i>
                                </span>
                                <input type="text" name="name" placeholder="Enter librarian's full name"
                                    class="form-control form-control-lg border-start-0 rounded-end-3"
                                    style="border: 1.5px solid #e2e8f0; padding: 0.75rem 1rem;"
                                    required>
                            </div>
                            <small class="text-muted">Full name as per official records</small>
                        </div>

                        <!-- Email Field -->
                        <div class="mb-4">
                            <label class="form-label fw-semibold text-secondary mb-2">
                                <i class="fas fa-envelope me-1 text-primary"></i> Email Address <span class="text-danger">*</span>
                            </label>
                            <div class="input-group">
                                <span class="input-group-text bg-light border-end-0 rounded-start-3">
                                    <i class="fas fa-envelope text-muted"></i>
                                </span>
                                <input type="email" name="email" placeholder="librarian@example.com"
                                    class="form-control form-control-lg border-start-0 rounded-end-3"
                                    style="border: 1.5px solid #e2e8f0; padding: 0.75rem 1rem;"
                                    required>
                            </div>
                            <small class="text-muted">Valid email address for login and communication</small>
                        </div>

                        <!-- Password Field -->
                        <div class="mb-4">
                            <label class="form-label fw-semibold text-secondary mb-2">
                                <i class="fas fa-lock me-1 text-primary"></i> Password <span class="text-danger">*</span>
                            </label>
                            <div class="position-relative">
                                <div class="input-group">
                                    <span class="input-group-text bg-light border-end-0 rounded-start-3">
                                        <i class="fas fa-key text-muted"></i>
                                    </span>
                                    <input type="password" name="password" id="password" placeholder="Create a strong password"
                                        class="form-control form-control-lg border-start-0 rounded-end-3"
                                        style="border: 1.5px solid #e2e8f0; padding: 0.75rem 1rem;"
                                        required>
                                    <button type="button" class="btn btn-outline-secondary rounded-end-3" id="togglePassword">
                                        <i class="fas fa-eye-slash"></i>
                                    </button>
                                </div>
                            </div>
                            <div class="password-strength mt-2">
                                <div class="progress" style="height: 4px;">
                                    <div class="progress-bar" id="passwordStrengthBar" style="width: 0%;"></div>
                                </div>
                                <small class="text-muted" id="passwordStrengthText">Minimum 6 characters with letters and numbers</small>
                            </div>
                        </div>

                        <!-- Profile Image Field (Optional) -->
                        <div class="mb-4">
                            <label class="form-label fw-semibold text-secondary mb-2">
                                <i class="fas fa-image me-1 text-primary"></i> Profile Image
                            </label>
                            <div class="file-upload-wrapper" onclick="document.getElementById('profileImage').click()">
                                <input type="file" name="image" id="profileImage" class="file-input-hidden" accept="image/*">
                                <div class="upload-label text-center">
                                    <i class="fas fa-cloud-upload-alt fa-2x text-primary mb-2 d-block"></i>
                                    <p class="mb-0 text-muted">Click or drag to upload</p>
                                    <small class="text-muted">JPG, PNG or GIF (Max 2MB)</small>
                                </div>
                                <div id="imagePreview" class="mt-2 text-center"></div>
                            </div>
                        </div>

                        <!-- Status Selection -->
                        <div class="mb-4">
                            <label class="form-label fw-semibold text-secondary mb-2">
                                <i class="fas fa-toggle-on me-1 text-primary"></i> Account Status
                            </label>
                            <select name="status" class="form-select form-select-lg rounded-3" style="border: 1.5px solid #e2e8f0; padding: 0.75rem 1rem;">
                                <option value="active">Active</option>
                                <option value="inactive">Inactive</option>
                            </select>
                            <small class="text-muted">Set the librarian's account status</small>
                        </div>

                        <!-- Submit Button -->
                        <div class="d-grid gap-2 mt-4">
                            <button type="submit" name="add" class="btn btn-gradient-primary btn-lg rounded-pill">
                                <i class="fas fa-save me-2"></i> Register Librarian
                            </button>
                            <a href="?page=librarians" class="btn btn-outline-secondary rounded-pill">
                                <i class="fas fa-arrow-left me-2"></i> Back to Librarians List
                            </a>
                        </div>
                    </form>
                </div>

                <!-- Card Footer with Info -->
                <div class="card-footer bg-white border-0 pb-4 px-4 px-xl-5">
                    <div class="d-flex align-items-center justify-content-center gap-3 flex-wrap">
                        <small class="text-muted d-flex align-items-center gap-1">
                            <i class="fas fa-shield-alt text-success"></i> Secure Registration
                        </small>
                        <small class="text-muted d-flex align-items-center gap-1">
                            <i class="fas fa-database text-info"></i> Data Encrypted
                        </small>
                        <small class="text-muted d-flex align-items-center gap-1">
                            <i class="fas fa-clock text-warning"></i> Instant Access
                        </small>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<style>
    /* Form styling */
    .form-control,
    .input-group-text,
    .form-select {
        transition: all 0.2s ease;
    }

    .form-control:focus,
    .form-select:focus {
        border-color: #3b82f6 !important;
        box-shadow: 0 0 0 4px rgba(59, 130, 246, 0.1);
        outline: none;
    }

    .input-group:focus-within .input-group-text {
        border-color: #3b82f6;
        background-color: #eff6ff;
    }

    /* Gradient button */
    .btn-gradient-primary {
        background: linear-gradient(135deg, #3b82f6 0%, #2563eb 100%);
        border: none;
        font-weight: 600;
        transition: all 0.2s ease;
        box-shadow: 0 4px 12px rgba(37, 99, 235, 0.25);
    }

    .btn-gradient-primary:hover {
        transform: translateY(-2px);
        box-shadow: 0 8px 20px rgba(37, 99, 235, 0.35);
    }

    .btn-gradient-primary:active {
        transform: translateY(0);
    }

    /* File upload styling */
    .file-upload-wrapper {
        border: 2px dashed #cbd5e1;
        border-radius: 16px;
        padding: 1.5rem;
        text-align: center;
        transition: all 0.2s ease;
        cursor: pointer;
        background: #fafcff;
    }

    .file-upload-wrapper:hover {
        border-color: #3b82f6;
        background: #eff6ff;
    }

    .file-input-hidden {
        display: none;
    }

    .upload-label {
        cursor: pointer;
    }

    .preview-image {
        max-width: 100px;
        max-height: 100px;
        margin-top: 1rem;
        border-radius: 12px;
        box-shadow: 0 2px 8px rgba(0, 0, 0, 0.1);
        object-fit: cover;
    }

    /* Alert styling */
    .alert-modern {
        border-radius: 16px;
        padding: 0.875rem 1.25rem;
    }

    /* Password strength */
    .password-strength .progress {
        background-color: #e2e8f0;
        border-radius: 4px;
        overflow: hidden;
    }

    /* Responsive */
    @media (max-width: 768px) {
        .card-body {
            padding: 1.5rem !important;
        }

        .btn-gradient-primary,
        .btn-outline-secondary {
            font-size: 0.9rem;
            padding: 0.6rem 1rem;
        }
    }
</style>

<!-- Font Awesome CDN -->
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css">

<script>
    // Image preview functionality
    document.getElementById('profileImage')?.addEventListener('change', function(e) {
        const preview = document.getElementById('imagePreview');
        if (this.files && this.files[0]) {
            const reader = new FileReader();
            reader.onload = function(e) {
                preview.innerHTML = `<img src="${e.target.result}" class="preview-image" alt="Preview">`;
            }
            reader.readAsDataURL(this.files[0]);
        } else {
            preview.innerHTML = '';
        }
    });

    // Password visibility toggle
    const togglePassword = document.getElementById('togglePassword');
    const passwordInput = document.getElementById('password');

    if (togglePassword && passwordInput) {
        togglePassword.addEventListener('click', function() {
            const type = passwordInput.getAttribute('type') === 'password' ? 'text' : 'password';
            passwordInput.setAttribute('type', type);
            this.innerHTML = type === 'password' ? '<i class="fas fa-eye-slash"></i>' : '<i class="fas fa-eye"></i>';
        });
    }

    // Password strength checker
    if (passwordInput) {
        passwordInput.addEventListener('input', function() {
            const password = this.value;
            const strengthBar = document.getElementById('passwordStrengthBar');
            const strengthText = document.getElementById('passwordStrengthText');
            let strength = 0;

            if (password.length >= 6) strength += 25;
            if (password.match(/[a-z]/)) strength += 25;
            if (password.match(/[A-Z]/)) strength += 25;
            if (password.match(/[0-9]/)) strength += 25;

            strengthBar.style.width = strength + '%';

            if (strength <= 25) {
                strengthBar.className = 'progress-bar bg-danger';
                strengthText.innerHTML = '<i class="fas fa-exclamation-triangle"></i> Weak password - use at least 6 characters';
            } else if (strength <= 50) {
                strengthBar.className = 'progress-bar bg-warning';
                strengthText.innerHTML = '<i class="fas fa-info-circle"></i> Fair password - add uppercase letters';
            } else if (strength <= 75) {
                strengthBar.className = 'progress-bar bg-info';
                strengthText.innerHTML = '<i class="fas fa-thumbs-up"></i> Good password - add numbers for better security';
            } else {
                strengthBar.className = 'progress-bar bg-success';
                strengthText.innerHTML = '<i class="fas fa-check-circle"></i> Strong password!';
            }

            if (password.length === 0) {
                strengthBar.style.width = '0%';
                strengthText.innerHTML = 'Minimum 6 characters with letters and numbers';
            }
        });
    }
</script>

<!-- Bootstrap JS for alerts -->
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/js/bootstrap.bundle.min.js"></script>