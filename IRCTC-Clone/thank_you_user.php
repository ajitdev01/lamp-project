<?php include "includes/header.php"; ?>

<?php
// Get booking details from session or query parameters
$booking_id = $_GET['booking_id'] ?? $_SESSION['booking_id'] ?? uniqid('BK');
$train_name = $_GET['train_name'] ?? $_SESSION['train_name'] ?? "Express Train";
$train_number = $_GET['train_no'] ?? $_SESSION['train_no'] ?? "12601";
$route = $_GET['route'] ?? $_SESSION['route'] ?? "Chennai - Bangalore";
$journey_date = $_GET['date'] ?? $_SESSION['journey_date'] ?? date('d M Y');
$passengers = $_GET['passengers'] ?? $_SESSION['passengers'] ?? 1;
$total_amount = $_GET['amount'] ?? $_SESSION['amount'] ?? "525.00";
$booking_time = date('d M Y h:i A');
$pnr_number = substr(strtoupper(uniqid()), 0, 10);

// Save PNR in session if not already saved
if (!isset($_SESSION['pnr_number'])) {
    $_SESSION['pnr_number'] = $pnr_number;
}
?>

<style>
    :root {
        --primary: #2563eb;
        --primary-light: #60a5fa;
        --primary-dark: #1e40af;
        --success: #10b981;
        --success-light: #a7f3d0;
        --warning: #f59e0b;
        --dark: #1f2937;
        --light: #f9fafb;
        --lighter: #ffffff;
        --gray: #6b7280;
        --border: #e5e7eb;
    }

    body {
        background: linear-gradient(135deg, #f8fafc 0%, #f1f5f9 100%);
        font-family: 'Inter', 'Poppins', sans-serif;
    }

    /* Confirmation Hero */
    .confirmation-hero {
        background: linear-gradient(135deg, var(--primary) 0%, var(--primary-dark) 100%);
        color: white;
        padding: 5rem 0 3rem;
        margin-bottom: 3rem;
        border-radius: 0 0 40px 40px;
        position: relative;
        overflow: hidden;
    }

    .confetti {
        position: absolute;
        width: 15px;
        height: 15px;
        background: rgba(255, 255, 255, 0.3);
        border-radius: 50%;
        animation: confetti-fall 5s linear infinite;
    }

    @keyframes confetti-fall {
        0% {
            transform: translateY(-100px) rotate(0deg);
            opacity: 1;
        }

        100% {
            transform: translateY(800px) rotate(360deg);
            opacity: 0;
        }
    }

    .success-icon {
        width: 100px;
        height: 100px;
        background: white;
        border-radius: 50%;
        display: flex;
        align-items: center;
        justify-content: center;
        margin: 0 auto 2rem;
        box-shadow: 0 10px 30px rgba(0, 0, 0, 0.1);
        position: relative;
        animation: pulse 2s infinite;
    }

    .success-icon i {
        font-size: 3.5rem;
        color: var(--success);
    }

    @keyframes pulse {
        0% {
            transform: scale(1);
            box-shadow: 0 10px 30px rgba(0, 0, 0, 0.1);
        }

        50% {
            transform: scale(1.05);
            box-shadow: 0 15px 40px rgba(0, 0, 0, 0.15);
        }

        100% {
            transform: scale(1);
            box-shadow: 0 10px 30px rgba(0, 0, 0, 0.1);
        }
    }

    /* Booking Card */
    .booking-card {
        background: var(--lighter);
        border-radius: 20px;
        padding: 2.5rem;
        margin: 2rem auto;
        max-width: 800px;
        box-shadow: 0 20px 40px rgba(0, 0, 0, 0.1);
        border: 1px solid var(--border);
        position: relative;
        overflow: hidden;
    }

    .booking-card::before {
        content: '';
        position: absolute;
        top: 0;
        left: 0;
        right: 0;
        height: 5px;
        background: linear-gradient(90deg, var(--success), var(--primary));
    }

    .pnr-badge {
        position: absolute;
        top: 2rem;
        right: 2rem;
        background: linear-gradient(135deg, var(--success), #059669);
        color: white;
        padding: 0.75rem 1.5rem;
        border-radius: 50px;
        font-weight: 700;
        font-size: 1.1rem;
        box-shadow: 0 5px 15px rgba(16, 185, 129, 0.3);
        display: flex;
        align-items: center;
        gap: 0.75rem;
    }

    /* Journey Timeline */
    .journey-timeline {
        display: flex;
        align-items: center;
        justify-content: space-between;
        padding: 2rem;
        background: var(--light);
        border-radius: 15px;
        margin: 2rem 0;
        position: relative;
    }

    .journey-timeline::before {
        content: '';
        position: absolute;
        top: 50%;
        left: 15%;
        right: 15%;
        height: 2px;
        background: linear-gradient(90deg, transparent, var(--primary), transparent);
        z-index: 1;
    }

    .station-point {
        position: relative;
        z-index: 2;
        text-align: center;
        background: white;
        padding: 1rem 1.5rem;
        border-radius: 12px;
        box-shadow: 0 5px 15px rgba(0, 0, 0, 0.05);
        min-width: 180px;
    }

    .station-dot {
        width: 12px;
        height: 12px;
        background: var(--primary);
        border: 3px solid white;
        border-radius: 50%;
        margin: 0 auto 0.75rem;
        box-shadow: 0 0 0 3px var(--primary-light);
    }

    .station-name {
        font-weight: 700;
        color: var(--dark);
        font-size: 1.1rem;
    }

    .duration-badge {
        background: white;
        padding: 0.5rem 1.5rem;
        border-radius: 50px;
        font-weight: 600;
        color: var(--dark);
        box-shadow: 0 5px 15px rgba(0, 0, 0, 0.08);
        border: 1px solid var(--border);
        z-index: 3;
    }

    /* Details Grid */
    .details-grid {
        display: grid;
        grid-template-columns: repeat(auto-fit, minmax(250px, 1fr));
        gap: 1.5rem;
        margin: 2rem 0;
    }

    .detail-card {
        background: var(--light);
        border-radius: 12px;
        padding: 1.5rem;
        border-left: 4px solid var(--primary);
    }

    .detail-label {
        font-size: 0.9rem;
        color: var(--gray);
        margin-bottom: 0.5rem;
        font-weight: 500;
    }

    .detail-value {
        font-size: 1.2rem;
        font-weight: 700;
        color: var(--dark);
    }

    /* Action Buttons */
    .action-buttons {
        display: grid;
        grid-template-columns: repeat(auto-fit, minmax(200px, 1fr));
        gap: 1rem;
        margin-top: 3rem;
    }

    .btn-modern {
        padding: 1rem 2rem;
        border-radius: 12px;
        font-weight: 600;
        font-size: 1rem;
        border: none;
        cursor: pointer;
        transition: all 0.3s ease;
        display: flex;
        align-items: center;
        justify-content: center;
        gap: 0.75rem;
        text-decoration: none;
    }

    .btn-primary-modern {
        background: linear-gradient(135deg, var(--primary), var(--primary-dark));
        color: white;
    }

    .btn-primary-modern:hover {
        transform: translateY(-3px);
        box-shadow: 0 10px 25px rgba(37, 99, 235, 0.3);
    }

    .btn-success-modern {
        background: linear-gradient(135deg, var(--success), #059669);
        color: white;
    }

    .btn-success-modern:hover {
        transform: translateY(-3px);
        box-shadow: 0 10px 25px rgba(16, 185, 129, 0.3);
    }

    .btn-outline-modern {
        background: white;
        color: var(--primary);
        border: 2px solid var(--primary);
    }

    .btn-outline-modern:hover {
        background: var(--primary);
        color: white;
        transform: translateY(-3px);
    }

    /* Security Badge */
    .security-badge {
        background: rgba(16, 185, 129, 0.1);
        border: 1px solid rgba(16, 185, 129, 0.3);
        border-radius: 12px;
        padding: 1rem 1.5rem;
        text-align: center;
        margin-top: 2rem;
        display: flex;
        align-items: center;
        justify-content: center;
        gap: 1rem;
    }

    /* Next Steps */
    .next-steps {
        background: white;
        border-radius: 15px;
        padding: 2rem;
        margin-top: 3rem;
        box-shadow: 0 10px 30px rgba(0, 0, 0, 0.05);
    }

    .step-item {
        display: flex;
        align-items: flex-start;
        gap: 1rem;
        margin-bottom: 1.5rem;
        padding-bottom: 1.5rem;
        border-bottom: 1px solid var(--border);
    }

    .step-item:last-child {
        border-bottom: none;
        margin-bottom: 0;
        padding-bottom: 0;
    }

    .step-number {
        width: 32px;
        height: 32px;
        background: var(--primary);
        color: white;
        border-radius: 50%;
        display: flex;
        align-items: center;
        justify-content: center;
        font-weight: 700;
        font-size: 0.9rem;
        flex-shrink: 0;
    }

    /* Responsive */
    @media (max-width: 768px) {
        .confirmation-hero {
            padding: 3rem 0 2rem;
            border-radius: 0 0 30px 30px;
        }

        .booking-card {
            padding: 1.5rem;
            margin: 1rem;
        }

        .pnr-badge {
            position: relative;
            top: auto;
            right: auto;
            margin: 1rem auto;
            justify-content: center;
        }

        .journey-timeline {
            flex-direction: column;
            gap: 2rem;
            padding: 1.5rem;
        }

        .journey-timeline::before {
            display: none;
        }

        .station-point {
            width: 100%;
        }

        .action-buttons {
            grid-template-columns: 1fr;
        }

        .details-grid {
            grid-template-columns: 1fr;
        }
    }

    /* Animation */
    @keyframes fadeInUp {
        from {
            opacity: 0;
            transform: translateY(20px);
        }

        to {
            opacity: 1;
            transform: translateY(0);
        }
    }

    .animate-fade-in-up {
        animation: fadeInUp 0.6s ease;
    }
</style>

<!-- Confetti Effect -->
<div id="confetti-container"></div>

<!-- Confirmation Hero -->
<section class="confirmation-hero">
    <div class="container text-center">
        <div class="success-icon animate-fade-in-up">
            <i class="fas fa-check"></i>
        </div>
        <h1 class="display-5 fw-bold mb-3 animate-fade-in-up">Booking Confirmed!</h1>
        <p class="lead mb-0 animate-fade-in-up">Your train ticket has been successfully booked</p>
        <p class="animate-fade-in-up">Booking ID: <span class="fw-bold"><?= $booking_id ?></span></p>
    </div>
</section>

<!-- Main Content -->
<div class="container mb-5">
    <!-- Booking Card -->
    <div class="booking-card animate-fade-in-up">
        <div class="pnr-badge animate-fade-in-up">
            <i class="fas fa-ticket-alt"></i>
            <span>PNR: <?= $pnr_number ?></span>
        </div>

        <div class="text-center mb-4">
            <h2 class="fw-bold mb-2"><?= htmlspecialchars($train_name) ?></h2>
            <p class="text-muted mb-0">Train No: <?= $train_number ?> • <?= $journey_date ?></p>
        </div>

        <!-- Journey Timeline -->
        <div class="journey-timeline">
            <div class="station-point">
                <div class="station-dot"></div>
                <div class="station-name"><?= explode(' - ', $route)[0] ?? 'Departure' ?></div>
                <div class="text-primary fw-bold">06:00 AM</div>
                <div class="text-muted small">Departure</div>
            </div>

            <div class="duration-badge">
                <i class="fas fa-clock me-2"></i>
                4h 30m Journey
            </div>

            <div class="station-point">
                <div class="station-dot"></div>
                <div class="station-name"><?= explode(' - ', $route)[1] ?? 'Arrival' ?></div>
                <div class="text-primary fw-bold">10:30 AM</div>
                <div class="text-muted small">Arrival</div>
            </div>
        </div>

        <!-- Booking Details Grid -->
        <div class="details-grid">
            <div class="detail-card">
                <div class="detail-label">Passenger Name</div>
                <div class="detail-value"><?= $_SESSION['user_name'] ?? 'Guest User' ?></div>
            </div>

            <div class="detail-card">
                <div class="detail-label">Booking Date & Time</div>
                <div class="detail-value"><?= $booking_time ?></div>
            </div>

            <div class="detail-card">
                <div class="detail-label">No. of Passengers</div>
                <div class="detail-value"><?= $passengers ?> Person(s)</div>
            </div>

            <div class="detail-card">
                <div class="detail-label">Total Amount Paid</div>
                <div class="detail-value">₹<?= number_format($total_amount, 2) ?></div>
            </div>
        </div>

        <!-- Action Buttons -->
        <div class="action-buttons">
            <a href="My_Bookings.php" class="btn-modern btn-primary-modern">
                <i class="fas fa-ticket-alt"></i>
                View My Bookings
            </a>

            <a href="download-ticket.php?pnr=<?= $pnr_number ?>" class="btn-modern btn-success-modern">
                <i class="fas fa-download"></i>
                Download Ticket
            </a>

            <a href="index.php" class="btn-modern btn-outline-modern">
                <i class="fas fa-home"></i>
                Back to Home
            </a>
        </div>

        <!-- Security Badge -->
        <div class="security-badge animate-fade-in-up">
            <i class="fas fa-shield-alt fa-lg text-success"></i>
            <div>
                <strong>Your booking is secure!</strong>
                <p class="mb-0 small">Ticket details have been sent to <?= $_SESSION['user_email'] ?? 'your email' ?></p>
            </div>
        </div>
    </div>

    <!-- Next Steps -->
    <div class="next-steps animate-fade-in-up">
        <h3 class="fw-bold mb-4">📋 What's Next?</h3>

        <div class="step-item">
            <div class="step-number">1</div>
            <div>
                <h5 class="fw-bold mb-1">Check Your Email</h5>
                <p class="text-muted mb-0">We've sent your e-ticket to <?= $_SESSION['user_email'] ?? 'your registered email' ?></p>
            </div>
        </div>

        <div class="step-item">
            <div class="step-number">2</div>
            <div>
                <h5 class="fw-bold mb-1">Print or Save Ticket</h5>
                <p class="text-muted mb-0">Download your ticket or keep the PNR handy for check-in</p>
            </div>
        </div>

        <div class="step-item">
            <div class="step-number">3</div>
            <div>
                <h5 class="fw-bold mb-1">Reach Station 30 Min Early</h5>
                <p class="text-muted mb-0">Arrive at the station 30 minutes before departure for smooth boarding</p>
            </div>
        </div>

        <div class="step-item">
            <div class="step-number">4</div>
            <div>
                <h5 class="fw-bold mb-1">Need Help?</h5>
                <p class="text-muted mb-0">Contact our 24/7 support at <strong>1800-XXX-XXXX</strong> or email support@railbook.com</p>
            </div>
        </div>
    </div>
</div>

<!-- Confetti JavaScript -->
<script>
    document.addEventListener('DOMContentLoaded', function() {
        // Create confetti
        const confettiContainer = document.getElementById('confetti-container');
        const colors = ['#2563eb', '#10b981', '#f59e0b', '#8b5cf6', '#ef4444'];

        for (let i = 0; i < 50; i++) {
            const confetti = document.createElement('div');
            confetti.className = 'confetti';
            confetti.style.left = Math.random() * 100 + 'vw';
            confetti.style.background = colors[Math.floor(Math.random() * colors.length)];
            confetti.style.animationDelay = Math.random() * 5 + 's';
            confetti.style.width = Math.random() * 15 + 10 + 'px';
            confetti.style.height = confetti.style.width;
            confettiContainer.appendChild(confetti);
        }

        // Auto-redirect to bookings after 30 seconds
        setTimeout(() => {
            document.querySelector('.btn-primary-modern').click();
        }, 30000);

        // Add click animation to buttons
        document.querySelectorAll('.btn-modern').forEach(btn => {
            btn.addEventListener('click', function(e) {
                this.style.transform = 'scale(0.95)';
                setTimeout(() => {
                    this.style.transform = '';
                }, 150);
            });
        });

        // Show notification
        if ('Notification' in window && Notification.permission === 'granted') {
            new Notification('Booking Confirmed!', {
                body: 'Your train ticket has been booked successfully. PNR: <?= $pnr_number ?>',
                icon: '/favicon.ico'
            });
        }

        // Print ticket on Ctrl+P
        document.addEventListener('keydown', function(e) {
            if ((e.ctrlKey || e.metaKey) && e.key === 'p') {
                e.preventDefault();
                window.open('download-ticket.php?pnr=<?= $pnr_number ?>', '_blank');
            }
        });
    });

    // Request notification permission
    if ('Notification' in window && Notification.permission === 'default') {
        Notification.requestPermission();
    }
</script>

<?php include "includes/footer.php"; ?>