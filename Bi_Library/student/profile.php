<?php
include "includes/header.php";
include "includes/sidebar.php";
$msg = '';
$ref = $_SESSION['st_id'];
$pQry = "SELECT * FROM students_tbl WHERE st_id=$ref";
$data = mysqli_fetch_assoc(mysqli_query($conn, $pQry));
if (isset($_POST['pUpdate'])) {
    $cPass = $_POST['current_password'];
    $nPass = password_hash($_POST['new_password'], PASSWORD_DEFAULT);
    if (password_verify($cPass, $data['st_password'])) {
        $puQry = "UPDATE students_tbl SET st_password='$nPass' WHERE st_id=$ref";
        if (mysqli_query($conn, $puQry)) {
            $msg = '<div class="alert alert-success">Password Updated Successfully!</div>';
        } else {
            $msg = "Failed!";
        }
    } else {
        $msg = '<div class="alert alert-danger">Current Password is incorrect!</div>';
    }
}
if (isset($_POST['imgUpdate'])) {
    if (empty($_FILES['image']['name'])) {
        $imgname = 'user.webp';
    } else {
        $imgname = time() . "_" . $_FILES['image']['name'];
        $tmpname = $_FILES['image']['tmp_name'];
        move_uploaded_file($tmpname, '../assets/students/' . $imgname);
    }

    $iuQry = "UPDATE students_tbl SET st_image='$imgname' WHERE st_id=$ref";
    if (mysqli_query($conn, $iuQry)) {
        unlink('../assets/students/' . $_SESSION['st_image']);
        $_SESSION['st_image'] = $imgname;
        $msg = '<div class="alert alert-success">Image Updated Successfully!</div>';
        header("Location: profile.php");
    } else {
        $msg = "Failed!";
    }
}
?>

<style>
    body {
        background: linear-gradient(135deg, #f5f7fb 0%, #eef2f7 100%);
        font-family: 'Inter', system-ui, -apple-system, sans-serif;
    }

    .profile-card {
        border: none;
        border-radius: 24px;
        box-shadow: 0 10px 30px rgba(0, 0, 0, 0.08);
        transition: transform 0.3s ease, box-shadow 0.3s ease;
        background: white;
    }

    .profile-card:hover {
        transform: translateY(-4px);
        box-shadow: 0 20px 40px rgba(0, 0, 0, 0.12);
    }

    .profile-img {
        width: 140px;
        height: 140px;
        object-fit: cover;
        border-radius: 50%;
        border: 4px solid #fff;
        box-shadow: 0 8px 20px rgba(0, 0, 0, 0.15);
        transition: transform 0.3s ease;
    }

    .profile-img:hover {
        transform: scale(1.02);
    }

    .label-title {
        font-weight: 600;
        color: #475569;
        min-width: 130px;
        display: inline-block;
        font-size: 0.9rem;
    }

    .info-value {
        color: #1e293b;
        font-weight: 500;
    }

    /* Modern form styling */
    .form-control-modern {
        border: 1.5px solid #e2e8f0;
        border-radius: 14px;
        padding: 0.75rem 1rem;
        transition: all 0.2s ease;
        font-size: 0.95rem;
    }

    .form-control-modern:focus {
        border-color: #3b82f6;
        box-shadow: 0 0 0 4px rgba(59, 130, 246, 0.1);
        outline: none;
    }

    /* Custom buttons */
    .btn-gradient-primary {
        background: linear-gradient(135deg, #3b82f6 0%, #2563eb 100%);
        border: none;
        border-radius: 40px;
        padding: 0.6rem 1.8rem;
        font-weight: 600;
        transition: all 0.2s ease;
        box-shadow: 0 4px 12px rgba(37, 99, 235, 0.25);
    }

    .btn-gradient-primary:hover {
        transform: translateY(-2px);
        box-shadow: 0 8px 20px rgba(37, 99, 235, 0.35);
    }

    .btn-gradient-warning {
        background: linear-gradient(135deg, #f59e0b 0%, #d97706 100%);
        border: none;
        border-radius: 40px;
        padding: 0.6rem 1.8rem;
        font-weight: 600;
        color: white;
        transition: all 0.2s ease;
        box-shadow: 0 4px 12px rgba(217, 119, 6, 0.25);
    }

    .btn-gradient-warning:hover {
        transform: translateY(-2px);
        box-shadow: 0 8px 20px rgba(217, 119, 6, 0.35);
        color: white;
    }

    /* Stat badges */
    .stat-badge {
        background: linear-gradient(135deg, #10b981 0%, #059669 100%);
        padding: 0.5rem 1.2rem;
        border-radius: 40px;
        font-weight: 500;
        font-size: 0.85rem;
    }

    /* Info row styling */
    .info-row {
        padding: 0.75rem 0;
        border-bottom: 1px solid #f1f5f9;
    }

    .info-row:last-child {
        border-bottom: none;
    }

    /* File upload styling */
    .file-upload-wrapper {
        position: relative;
        border: 2px dashed #cbd5e1;
        border-radius: 16px;
        padding: 1rem;
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
        display: inline-block;
    }

    .preview-image {
        max-width: 100px;
        max-height: 100px;
        margin-top: 1rem;
        border-radius: 12px;
        box-shadow: 0 2px 8px rgba(0, 0, 0, 0.1);
    }

    /* Alert styling */
    .alert-modern {
        border-radius: 16px;
        border-left: 4px solid;
        padding: 1rem 1.25rem;
        margin-bottom: 1.5rem;
    }

    /* Responsive */
    @media (max-width: 768px) {
        .profile-img {
            width: 110px;
            height: 110px;
        }

        .label-title {
            min-width: 100px;
            font-size: 0.85rem;
        }

        .profile-card {
            padding: 1.25rem !important;
        }
    }
</style>

<div class="container-fluid px-4 py-3">
    <!-- Modern Header Section -->
    <div class="d-flex flex-wrap align-items-center justify-content-between mb-4">
        <div>
            <h1 class="display-6 fw-bold mb-1" style="color: #1e293b;">
                <i class="fas fa-user-circle me-2 text-primary" style="font-size: 2rem;"></i>Profile Management
            </h1>
            <nav aria-label="breadcrumb">
                <ol class="breadcrumb mb-0">
                    <li class="breadcrumb-item"><a href="index.php" class="text-decoration-none">Dashboard</a></li>
                    <li class="breadcrumb-item active fw-semibold text-primary">My Profile</li>
                </ol>
            </nav>
        </div>
        <div class="mt-2 mt-sm-0">
            <span class="badge stat-badge text-white shadow-sm">
                <i class="fas fa-calendar-alt me-1"></i> <?= date('l, F j, Y') ?>
            </span>
        </div>
    </div>

    <!-- Main Card -->
    <div class="card border-0 rounded-4 shadow-sm mb-4 overflow-hidden">
        <div class="card-body p-0">
            <div class="container-fluid p-4 p-lg-5">

                <!-- Dynamic Message Display -->
                <?php if (isset($msg) && !empty($msg)): ?>
                    <div class="alert alert-modern alert-dismissible fade show d-flex align-items-center gap-2"
                        style="background: #f0fdf4; border-left-color: #22c55e; color: #166534;">
                        <i class="fas fa-check-circle fs-5"></i>
                        <span><?= $msg ?></span>
                        <button type="button" class="btn-close ms-auto" data-bs-dismiss="alert"></button>
                    </div>
                <?php endif; ?>

                <div class="row g-4">
                    <!-- Profile Details Card -->
                    <div class="col-lg-5">
                        <div class="profile-card p-4 p-xl-5 h-100">
                            <!-- Profile Header -->
                            <div class="text-center mb-4 position-relative">
                                <div class="position-relative d-inline-block">
                                    <img src="../assets/students/<?= htmlspecialchars($data['st_image']) ?>"
                                        alt="Profile Image"
                                        class="profile-img mb-3"
                                        onerror="this.src='../assets/students/default-avatar.png'">
                                    <div class="position-absolute bottom-0 end-0 bg-success rounded-circle p-1 border border-2 border-white">
                                        <i class="fas fa-check-circle text-white" style="font-size: 12px;"></i>
                                    </div>
                                </div>
                                <h3 class="fw-bold mb-1 mt-2" style="color: #1e293b;"><?= htmlspecialchars($data['st_name']) ?></h3>
                                <span class="badge stat-badge text-white mt-2 shadow-sm">
                                    <i class="fas fa-check-circle me-1"></i> Active Member
                                </span>
                            </div>

                            <!-- Profile Information -->
                            <div class="mt-4">
                                <div class="info-row d-flex flex-wrap align-items-center">
                                    <span class="label-title">
                                        <i class="fas fa-id-card me-2 text-primary"></i>Student ID:
                                    </span>
                                    <span class="info-value">#<?= str_pad($data['st_id'], 6, '0', STR_PAD_LEFT) ?></span>
                                </div>
                                <div class="info-row d-flex flex-wrap align-items-center">
                                    <span class="label-title">
                                        <i class="fas fa-user me-2 text-primary"></i>Full Name:
                                    </span>
                                    <span class="info-value"><?= htmlspecialchars($data['st_name']) ?></span>
                                </div>
                                <div class="info-row d-flex flex-wrap align-items-center">
                                    <span class="label-title">
                                        <i class="fas fa-envelope me-2 text-primary"></i>Email Address:
                                    </span>
                                    <span class="info-value"><?= htmlspecialchars($data['st_email']) ?></span>
                                </div>
                                <div class="info-row d-flex flex-wrap align-items-center">
                                    <span class="label-title">
                                        <i class="fas fa-calendar-plus me-2 text-primary"></i>Joined On:
                                    </span>
                                    <span class="info-value"><?= date('d M Y, h:i A', strtotime($data['created_at'])) ?></span>
                                </div>
                                <div class="info-row d-flex flex-wrap align-items-center">
                                    <span class="label-title">
                                        <i class="fas fa-edit me-2 text-primary"></i>Last Modified:
                                    </span>
                                    <span class="info-value"><?= date('d M Y, h:i A', strtotime($data['updated_at'])) ?></span>
                                </div>
                            </div>

                            <!-- Quick Stats -->
                            <div class="mt-4 pt-3 border-top">
                                <div class="row g-2 text-center">
                                    <div class="col-6">
                                        <div class="bg-light rounded-3 p-2">
                                            <small class="text-muted d-block">Books Borrowed</small>
                                            <strong class="fs-5 text-primary">0</strong>
                                        </div>
                                    </div>
                                    <div class="col-6">
                                        <div class="bg-light rounded-3 p-2">
                                            <small class="text-muted d-block">Books Returned</small>
                                            <strong class="fs-5 text-success">0</strong>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Update Forms Section -->
                    <div class="col-lg-7">
                        <!-- Update Profile Image Card -->
                        <div class="profile-card p-4 p-xl-5 mb-4">
                            <div class="d-flex align-items-center gap-3 mb-4">
                                <div class="bg-primary bg-opacity-10 rounded-3 p-3">
                                    <i class="fas fa-camera-retro fs-4 text-primary"></i>
                                </div>
                                <div>
                                    <h4 class="fw-bold mb-0" style="color: #1e293b;">Update Profile Image</h4>
                                    <p class="text-muted small mb-0">Change your profile picture (JPG, PNG, GIF)</p>
                                </div>
                            </div>

                            <form action="" method="POST" enctype="multipart/form-data">
                                <div class="mb-4">
                                    <label class="form-label fw-semibold text-secondary mb-2">
                                        <i class="fas fa-image me-1"></i> Choose New Image
                                    </label>
                                    <div class="file-upload-wrapper" onclick="document.getElementById('profileImage').click()">
                                        <input type="file" name="image" id="profileImage" class="file-input-hidden" accept="image/*" required>
                                        <div class="upload-label">
                                            <i class="fas fa-cloud-upload-alt fa-2x text-primary mb-2 d-block"></i>
                                            <p class="mb-0 text-muted">Click or drag to upload</p>
                                            <small class="text-muted">Max size: 5MB</small>
                                        </div>
                                        <div id="imagePreview" class="mt-2"></div>
                                    </div>
                                </div>

                                <button type="submit" name="imgUpdate" class="btn btn-gradient-primary">
                                    <i class="fas fa-upload me-2"></i> Update Image
                                </button>
                            </form>
                        </div>

                        <!-- Change Password Card -->
                        <div class="profile-card p-4 p-xl-5">
                            <div class="d-flex align-items-center gap-3 mb-4">
                                <div class="bg-warning bg-opacity-10 rounded-3 p-3">
                                    <i class="fas fa-lock fs-4 text-warning"></i>
                                </div>
                                <div>
                                    <h4 class="fw-bold mb-0" style="color: #1e293b;">Change Password</h4>
                                    <p class="text-muted small mb-0">Keep your account secure with a strong password</p>
                                </div>
                            </div>

                            <form action="" method="POST">
                                <div class="mb-3">
                                    <label class="form-label fw-semibold text-secondary">
                                        <i class="fas fa-key me-1"></i> Current Password
                                    </label>
                                    <div class="input-group">
                                        <span class="input-group-text bg-light border-end-0 rounded-start-3">
                                            <i class="fas fa-shield-alt text-muted"></i>
                                        </span>
                                        <input type="password" name="current_password" class="form-control form-control-modern border-start-0"
                                            placeholder="Enter your current password" required>
                                    </div>
                                </div>

                                <div class="mb-4">
                                    <label class="form-label fw-semibold text-secondary">
                                        <i class="fas fa-key me-1"></i> New Password
                                    </label>
                                    <div class="input-group">
                                        <span class="input-group-text bg-light border-end-0 rounded-start-3">
                                            <i class="fas fa-lock text-muted"></i>
                                        </span>
                                        <input type="password" name="new_password" class="form-control form-control-modern border-start-0"
                                            placeholder="Enter new password" required>
                                    </div>
                                    <div class="form-text mt-2">
                                        <i class="fas fa-info-circle"></i> Password must be at least 6 characters
                                    </div>
                                </div>

                                <button type="submit" name="pUpdate" class="btn btn-gradient-warning">
                                    <i class="fas fa-save me-2"></i> Update Password
                                </button>
                            </form>

                            <!-- Password Tips -->
                            <div class="mt-4 pt-3 border-top">
                                <small class="text-muted d-flex align-items-center gap-2">
                                    <i class="fas fa-shield-alt text-success"></i>
                                    <span>Tips: Use a mix of letters, numbers, and special characters for a strong password</span>
                                </small>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Image Preview Script -->
<script>
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
</script>

<?php include "includes/footer.php"; ?>