<?php include "includes/header.php"; ?>

<style>
    /* ===================================
       DESIGN SYSTEM ENHANCEMENTS
    =================================== */
    :root {
        --primary: #2563eb;
        --primary-dark: #1e40af;
        --primary-light: #60a5fa;
        --secondary: #8b5cf6;
        --accent: #f59e0b;
        --success: #10b981;
        --danger: #ef4444;
        --warning: #fbbf24;
        --dark: #1e293b;
        --darker: #0f172a;
        --light: #f8fafc;
        --white: #ffffff;
        --shadow-sm: 0 1px 3px 0 rgba(0, 0, 0, 0.1);
        --shadow-md: 0 4px 6px -1px rgba(0, 0, 0, 0.1);
        --shadow-lg: 0 10px 15px -3px rgba(0, 0, 0, 0.1);
        --shadow-xl: 0 20px 25px -5px rgba(0, 0, 0, 0.1);
        --shadow-2xl: 0 25px 50px -12px rgba(0, 0, 0, 0.25);
        --gradient-primary: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
        --gradient-accent: linear-gradient(135deg, #f093fb 0%, #f5576c 100%);
    }

    /* Smooth scrolling */
    html {
        scroll-behavior: smooth;
    }

    /* ===================================
       ENHANCED HERO SECTION
    =================================== */
    .hero-section {
        position: relative;
        min-height: 100vh;
        padding-top: 80px;
        background: var(--darker);
        overflow: hidden;
    }

    .hero-bg-pattern {
        position: absolute;
        top: 0;
        left: 0;
        right: 0;
        bottom: 0;
        background:
            radial-gradient(circle at 20% 80%, rgba(37, 99, 235, 0.1) 0%, transparent 50%),
            radial-gradient(circle at 80% 20%, rgba(139, 92, 246, 0.1) 0%, transparent 50%),
            linear-gradient(to bottom, var(--darker), #1a202c);
    }

    .hero-bg-image {
        position: absolute;
        top: 0;
        left: 0;
        right: 0;
        bottom: 0;
        background: url('https://images.unsplash.com/photo-1568213816046-0a40d4ae9c77?q=80&w=2070') center/cover;
        opacity: 0.2;
        mix-blend-mode: overlay;
    }

    .hero-title {
        font-size: 3.75rem;
        font-weight: 900;
        line-height: 1.1;
        background: linear-gradient(135deg, var(--white) 0%, var(--primary-light) 100%);
        -webkit-background-clip: text;
        -webkit-text-fill-color: transparent;
        margin-bottom: 1.5rem;
    }

    .hero-subtitle {
        font-size: 1.25rem;
        color: #cbd5e1;
        font-weight: 300;
        margin-bottom: 2rem;
        max-width: 600px;
    }

    .stats-container {
        display: flex;
        gap: 2rem;
        margin-top: 3rem;
    }

    .stat-item {
        display: flex;
        align-items: center;
        gap: 0.75rem;
    }

    .stat-icon {
        width: 48px;
        height: 48px;
        border-radius: 12px;
        background: rgba(255, 255, 255, 0.1);
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 1.5rem;
        color: var(--primary-light);
    }

    .stat-number {
        font-size: 2rem;
        font-weight: 800;
        color: var(--white);
        line-height: 1;
    }

    .stat-label {
        font-size: 0.875rem;
        color: #94a3b8;
        text-transform: uppercase;
        letter-spacing: 1px;
    }

    /* ===================================
       ENHANCED BOOKING CARD
    =================================== */
    .booking-card {
        background: rgba(255, 255, 255, 0.95);
        backdrop-filter: blur(20px);
        border-radius: 28px;
        padding: 2.5rem;
        box-shadow:
            0 20px 40px rgba(0, 0, 0, 0.3),
            inset 0 1px 0 rgba(255, 255, 255, 0.2);
        border: 1px solid rgba(255, 255, 255, 0.3);
        position: relative;
        overflow: hidden;
    }

    .booking-card::before {
        content: '';
        position: absolute;
        top: -50%;
        left: -50%;
        width: 200%;
        height: 200%;
        background: linear-gradient(45deg,
                transparent 30%,
                rgba(255, 255, 255, 0.1) 50%,
                transparent 70%);
        animation: shine 3s infinite linear;
    }

    @keyframes shine {
        0% {
            transform: translateX(-100%) translateY(-100%) rotate(45deg);
        }

        100% {
            transform: translateX(100%) translateY(100%) rotate(45deg);
        }
    }

    /* Enhanced Form Inputs */
    .form-floating-modern {
        position: relative;
        margin-bottom: 1.5rem;
    }

    .form-floating-modern input,
    .form-floating-modern select {
        height: 64px;
        padding: 1.5rem 1rem 0.5rem;
        font-size: 1.1rem;
        border: 2px solid #e2e8f0;
        border-radius: 16px;
        transition: all 0.3s ease;
        background: var(--white);
    }

    .form-floating-modern label {
        padding: 1rem;
        color: #64748b;
        font-weight: 500;
        pointer-events: none;
    }

    .form-floating-modern input:focus,
    .form-floating-modern select:focus {
        border-color: var(--primary);
        box-shadow: 0 0 0 4px rgba(37, 99, 235, 0.1);
        outline: none;
    }

    /* Floating Action Buttons */
    .floating-actions {
        position: fixed;
        right: 2rem;
        bottom: 2rem;
        z-index: 1000;
        display: flex;
        flex-direction: column;
        gap: 1rem;
    }

    .floating-btn {
        width: 56px;
        height: 56px;
        border-radius: 50%;
        background: var(--primary);
        color: var(--white);
        border: none;
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 1.25rem;
        box-shadow: var(--shadow-xl);
        transition: all 0.3s ease;
        cursor: pointer;
        position: relative;
    }

    .floating-btn:hover {
        transform: translateY(-4px);
        box-shadow: var(--shadow-2xl);
    }

    .floating-btn.pulse::before {
        content: '';
        position: absolute;
        width: 100%;
        height: 100%;
        border-radius: 50%;
        background: var(--primary);
        animation: pulse 2s infinite;
        z-index: -1;
    }

    @keyframes pulse {
        0% {
            transform: scale(1);
            opacity: 0.8;
        }

        100% {
            transform: scale(1.5);
            opacity: 0;
        }
    }

    /* ===================================
       ENHANCED FEATURES SECTION
    =================================== */
    .features-section {
        padding: 5rem 0;
        position: relative;
        background: linear-gradient(135deg, #f8fafc 0%, #f1f5f9 100%);
    }

    .feature-card-enhanced {
        background: var(--white);
        border-radius: 24px;
        padding: 2rem;
        transition: all 0.4s cubic-bezier(0.175, 0.885, 0.32, 1.275);
        border: 1px solid rgba(0, 0, 0, 0.05);
        position: relative;
        overflow: hidden;
        height: 100%;
    }

    .feature-card-enhanced::before {
        content: '';
        position: absolute;
        top: 0;
        left: 0;
        right: 0;
        height: 4px;
        background: var(--gradient-primary);
        opacity: 0;
        transition: opacity 0.3s ease;
    }

    .feature-card-enhanced:hover::before {
        opacity: 1;
    }

    .feature-card-enhanced:hover {
        transform: translateY(-10px);
        box-shadow: var(--shadow-2xl);
    }

    .feature-number {
        position: absolute;
        top: 1.5rem;
        right: 1.5rem;
        font-size: 4rem;
        font-weight: 900;
        color: rgba(0, 0, 0, 0.05);
        line-height: 1;
    }

    /* ===================================
       ENHANCED OFFERS SECTION
    =================================== */
    .offers-section {
        padding: 5rem 0;
        background: var(--dark);
        position: relative;
        overflow: hidden;
    }

    .offers-section::before {
        content: '';
        position: absolute;
        top: 0;
        left: 0;
        right: 0;
        height: 1px;
        background: linear-gradient(90deg, transparent, var(--primary), transparent);
    }

    .offer-card-premium {
        background: linear-gradient(135deg, #1e293b 0%, #334155 100%);
        border-radius: 24px;
        overflow: hidden;
        transition: all 0.4s ease;
        border: 1px solid rgba(255, 255, 255, 0.1);
        position: relative;
        height: 100%;
    }

    .offer-card-premium:hover {
        transform: translateY(-12px);
        border-color: var(--primary);
        box-shadow: 0 20px 40px rgba(0, 0, 0, 0.4);
    }

    .offer-ribbon {
        position: absolute;
        top: 20px;
        right: -30px;
        background: var(--danger);
        color: var(--white);
        padding: 0.5rem 3rem;
        transform: rotate(45deg);
        font-weight: 700;
        font-size: 0.875rem;
        box-shadow: 0 2px 10px rgba(0, 0, 0, 0.2);
    }

    /* ===================================
       ENHANCED ROUTES SECTION
    =================================== */
    .routes-section {
        padding: 5rem 0;
        background: var(--white);
    }

    .routes-table-enhanced {
        background: var(--white);
        border-radius: 24px;
        overflow: hidden;
        box-shadow: var(--shadow-xl);
    }

    .routes-table-enhanced thead {
        background: linear-gradient(135deg, var(--primary), var(--secondary));
    }

    .routes-table-enhanced thead th {
        padding: 1.5rem;
        font-weight: 600;
        color: var(--white);
        position: relative;
        overflow: hidden;
    }

    .routes-table-enhanced thead th::after {
        content: '';
        position: absolute;
        bottom: 0;
        left: 0;
        right: 0;
        height: 2px;
        background: rgba(255, 255, 255, 0.2);
    }

    /* ===================================
       NEW: TESTIMONIALS SECTION
    =================================== */
    .testimonials-section {
        padding: 5rem 0;
        background: linear-gradient(135deg, #f8fafc 0%, #e2e8f0 100%);
    }

    .testimonial-card {
        background: var(--white);
        border-radius: 20px;
        padding: 2rem;
        box-shadow: var(--shadow-lg);
        height: 100%;
        position: relative;
    }

    .testimonial-card::before {
        content: '"';
        position: absolute;
        top: -20px;
        left: 2rem;
        font-size: 6rem;
        color: var(--primary-light);
        opacity: 0.1;
        font-family: serif;
    }

    .testimonial-rating {
        color: var(--warning);
        margin-bottom: 1rem;
    }

    /* ===================================
       NEW: DOWNLOAD APP SECTION
    =================================== */
    .app-section {
        padding: 5rem 0;
        background: linear-gradient(135deg, var(--dark), var(--darker));
    }

    .app-card {
        background: rgba(255, 255, 255, 0.05);
        border-radius: 24px;
        padding: 3rem;
        backdrop-filter: blur(10px);
        border: 1px solid rgba(255, 255, 255, 0.1);
    }

    /* ===================================
       ANIMATIONS & EFFECTS
    =================================== */
    .fade-in {
        opacity: 0;
        transform: translateY(20px);
        transition: opacity 0.6s ease, transform 0.6s ease;
    }

    .fade-in.visible {
        opacity: 1;
        transform: translateY(0);
    }

    .hover-lift {
        transition: transform 0.3s ease;
    }

    .hover-lift:hover {
        transform: translateY(-4px);
    }

    /* ===================================
       RESPONSIVE ENHANCEMENTS
    =================================== */
    @media (max-width: 768px) {
        .hero-title {
            font-size: 2.5rem;
        }

        .stats-container {
            flex-wrap: wrap;
            gap: 1.5rem;
        }

        .floating-actions {
            right: 1rem;
            bottom: 1rem;
        }

        .floating-btn {
            width: 48px;
            height: 48px;
            font-size: 1rem;
        }
    }
</style>

<!-- ===================================
     ENHANCED HERO SECTION
=================================== -->
<section class="hero-section">
    <div class="hero-bg-pattern"></div>
    <div class="hero-bg-image"></div>

    <div class="container position-relative z-2">
        <div class="row align-items-center min-vh-100 py-5">
            <div class="col-lg-6">
                <div class="fade-in">
                    <span class="badge bg-primary-light bg-opacity-10 text-primary-light px-3 py-2 rounded-pill mb-3 d-inline-flex align-items-center">
                        <i class="fas fa-star me-2"></i> Trusted by 1M+ Travelers
                    </span>

                    <h1 class="hero-title">
                        Journey Made<br>
                        <span class="text-gradient-primary">Simple & Smart</span>
                    </h1>

                    <p class="hero-subtitle">
                        Book trains in 60 seconds with our AI-powered platform. Get confirmed tickets, real-time updates, and exclusive offers.
                    </p>

                    <div class="d-flex flex-wrap gap-3 mb-4">
                        <a href="#booking" class="btn btn-primary btn-lg px-4 py-3 rounded-pill shadow-lg">
                            <i class="fas fa-ticket-alt me-2"></i> Book Now
                        </a>
                        <a href="#offers" class="btn btn-outline-light btn-lg px-4 py-3 rounded-pill">
                            <i class="fas fa-gift me-2"></i> View Offers
                        </a>
                    </div>

                    <div class="stats-container">
                        <div class="stat-item">
                            <div class="stat-icon">
                                <i class="fas fa-train"></i>
                            </div>
                            <div>
                                <div class="stat-number">50K+</div>
                                <div class="stat-label">Daily Bookings</div>
                            </div>
                        </div>
                        <div class="stat-item">
                            <div class="stat-icon">
                                <i class="fas fa-check-circle"></i>
                            </div>
                            <div>
                                <div class="stat-number">99.8%</div>
                                <div class="stat-label">Success Rate</div>
                            </div>
                        </div>
                        <div class="stat-item">
                            <div class="stat-icon">
                                <i class="fas fa-clock"></i>
                            </div>
                            <div>
                                <div class="stat-number">&lt;60s</div>
                                <div class="stat-label">Avg. Booking Time</div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="col-lg-6 mt-5 mt-lg-0">
                <div class="booking-card fade-in" style="animation-delay: 0.2s;">
                    <div class="text-center mb-4">
                        <h3 class="fw-bold text-dark mb-1">Book Your Journey</h3>
                        <p class="text-muted">Fast, secure, and reliable booking</p>
                    </div>

                    <form id="bookingForm" action="search.php" method="post" class="needs-validation" novalidate>
                        <div class="row g-4">
                            <div class="col-12">
                                <div class="form-floating-modern">
                                    <input type="text" class="form-control" id="fromStation" name="fromStation" placeholder="From Station" required>
                                    <label for="fromStation">
                                        <i class="fas fa-map-marker-alt text-primary me-2"></i> From Station
                                    </label>
                                </div>
                            </div>

                            <div class="col-12 position-relative">
                                <button type="button" id="swapBtn" class="mt-5 btn btn-light shadow-sm position-absolute top-50 start-50 translate-middle z-3"
                                    style="width: 44px; height: 44px; border-radius: 12px;">
                                    <i class="fas fa-exchange-alt"></i>
                                </button>

                                <div class="form-floating-modern">
                                    <input type="text" class="form-control" id="toStation" name="toStation" placeholder="To Station" required>
                                    <label for="toStation">
                                        <i class="fas fa-map-marker-alt text-danger me-2"></i> To Station
                                    </label>
                                </div>
                            </div>

                            <div class="col-12 col-md-6">
                                <div class="form-floating-modern">
                                    <input type="date" class="form-control" id="journeyDate" name="journeyDate" required>
                                    <label for="journeyDate">
                                        <i class="fas fa-calendar-alt text-success me-2"></i> Journey Date
                                    </label>
                                </div>
                            </div>

                            <div class="col-12 col-md-6">
                                <div class="form-floating-modern">
                                    <select class="form-select" id="trainClass" name="class">
                                        <option value="">All Classes</option>
                                        <option value="1A">First AC (1A)</option>
                                        <option value="2A">AC 2 Tier (2A)</option>
                                        <option value="3A">AC 3 Tier (3A)</option>
                                        <option value="SL">Sleeper (SL)</option>
                                        <option value="CC">Chair Car (CC)</option>
                                        <option value="2S">Second Sitting (2S)</option>
                                    </select>
                                    <label for="trainClass">
                                        <i class="fas fa-chair text-warning me-2"></i> Class Preference
                                    </label>
                                </div>
                            </div>

                            <div class="col-12">
                                <div class="form-check mb-3">
                                    <input class="form-check-input" type="checkbox" id="flexiTicket">
                                    <label class="form-check-label text-muted" for="flexiTicket">
                                        <i class="fas fa-shield-alt text-primary me-1"></i> Include Flexi-Ticket (Free Cancellation)
                                    </label>
                                </div>
                            </div>

                            <div class="col-12">
                                <button type="submit" name="search" class="btn btn-primary btn-lg w-100 py-3 rounded-pill shadow-lg hover-lift">
                                    <i class="fas fa-search me-2"></i> Search Trains
                                    <span class="badge bg-light text-primary ms-2">Instant Results</span>
                                </button>
                            </div>
                        </div>
                    </form>

                    <div class="text-center mt-4">
                        <small class="text-muted">
                            <i class="fas fa-lock me-1"></i> Your data is 100% secure
                        </small>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

<!-- Floating Action Buttons -->
<div class="floating-actions">
    <button class="floating-btn pulse" onclick="scrollToBooking()" title="Quick Book">
        <i class="fas fa-bolt"></i>
    </button>
    <button class="floating-btn" onclick="window.open('tel:+91 78089 82006')" title="Call Support">
        <i class="fas fa-phone"></i>
    </button>
    <button class="floating-btn" onclick="openChat()" title="Live Chat">
        <i class="fas fa-comment-dots"></i>
    </button>
</div>

<!-- ===================================
     ENHANCED FEATURES SECTION
=================================== -->
<section id="features" class="features-section">
    <div class="container">
        <div class="text-center mb-5">
            <h2 class="fw-bold display-5 mb-3">Why Choose Us?</h2>
            <p class="text-muted lead">Experience the difference with our premium features</p>
        </div>

        <div class="row g-4">
            <div class="col-lg-3 col-md-6">
                <div class="feature-card-enhanced fade-in">
                    <div class="feature-number">01</div>
                    <div class="feature-icon bg-primary bg-opacity-10 text-primary rounded-3 p-3 mb-4" style="width: 64px; height: 64px;">
                        <i class="fas fa-bolt fa-2x"></i>
                    </div>
                    <h4 class="fw-bold mb-3">Lightning Fast</h4>
                    <p class="text-muted mb-0">Book tickets in under 60 seconds with our optimized platform</p>
                </div>
            </div>

            <div class="col-lg-3 col-md-6">
                <div class="feature-card-enhanced fade-in" style="animation-delay: 0.1s;">
                    <div class="feature-number">02</div>
                    <div class="feature-icon bg-success bg-opacity-10 text-success rounded-3 p-3 mb-4" style="width: 64px; height: 64px;">
                        <i class="fas fa-percent fa-2x"></i>
                    </div>
                    <h4 class="fw-bold mb-3">Zero Fees</h4>
                    <p class="text-muted mb-0">No hidden charges or payment gateway fees ever</p>
                </div>
            </div>

            <div class="col-lg-3 col-md-6">
                <div class="feature-card-enhanced fade-in" style="animation-delay: 0.2s;">
                    <div class="feature-number">03</div>
                    <div class="feature-icon bg-warning bg-opacity-10 text-warning rounded-3 p-3 mb-4" style="width: 64px; height: 64px;">
                        <i class="fas fa-shield-alt fa-2x"></i>
                    </div>
                    <h4 class="fw-bold mb-3">Bank-Grade Security</h4>
                    <p class="text-muted mb-0">256-bit encryption for all your transactions</p>
                </div>
            </div>

            <div class="col-lg-3 col-md-6">
                <div class="feature-card-enhanced fade-in" style="animation-delay: 0.3s;">
                    <div class="feature-number">04</div>
                    <div class="feature-icon bg-info bg-opacity-10 text-info rounded-3 p-3 mb-4" style="width: 64px; height: 64px;">
                        <i class="fas fa-robot fa-2x"></i>
                    </div>
                    <h4 class="fw-bold mb-3">AI-Powered Support</h4>
                    <p class="text-muted mb-0">24/7 AI assistant for instant query resolution</p>
                </div>
            </div>
        </div>
    </div>
</section>

<!-- ===================================
     ENHANCED OFFERS SECTION
=================================== -->
<section id="offers" class="offers-section">
    <div class="container">
        <div class="text-center mb-5">
            <h2 class="fw-bold display-5 text-white mb-3">🎁 Exclusive Offers</h2>
            <p class="text-light opacity-75">Limited time deals curated just for you</p>
        </div>

        <div class="row g-4">
            <div class="col-lg-4 col-md-6">
                <div class="offer-card-premium fade-in">
                    <div class="offer-ribbon">HOT</div>
                    <div class="position-relative">
                        <img src="https://images.unsplash.com/photo-1506905925346-21bda4d32df4?q=80&w=2070"
                            class="img-fluid"
                            alt="Monsoon Offer"
                            style="height: 220px; width: 100%; object-fit: cover;">
                        <div class="position-absolute bottom-0 start-0 end-0 p-4"
                            style="background: linear-gradient(transparent, rgba(0,0,0,0.8))">
                            <span class="badge bg-primary px-3 py-2">UPTO 30% OFF</span>
                        </div>
                    </div>
                    <div class="p-4">
                        <h5 class="text-white fw-bold mb-3">Monsoon Magic Sale</h5>
                        <p class="text-light opacity-75 mb-3">Book AC tickets this monsoon season and enjoy special discounts</p>
                        <div class="d-flex align-items-center justify-content-between">
                            <div>
                                <small class="text-warning">Use Code:</small>
                                <div class="text-white fw-bold">MONSOON30</div>
                            </div>
                            <button class="btn btn-primary rounded-pill px-4">
                                Claim Offer <i class="fas fa-arrow-right ms-2"></i>
                            </button>
                        </div>
                    </div>
                </div>
            </div>

            <div class="col-lg-4 col-md-6">
                <div class="offer-card-premium fade-in" style="animation-delay: 0.1s;">
                    <div class="position-relative">
                        <img src="https://images.unsplash.com/photo-1590523277543-a94d2e4eb00b?q=80&w=2062"
                            class="img-fluid"
                            alt="Weekend Offer"
                            style="height: 220px; width: 100%; object-fit: cover;">
                        <div class="position-absolute bottom-0 start-0 end-0 p-4"
                            style="background: linear-gradient(transparent, rgba(0,0,0,0.8))">
                            <span class="badge bg-success px-3 py-2">WEEKEND DEAL</span>
                        </div>
                    </div>
                    <div class="p-4">
                        <h5 class="text-white fw-bold mb-3">Weekend Special</h5>
                        <p class="text-light opacity-75 mb-3">Flat ₹300 off on all weekend journeys. Perfect for getaways!</p>
                        <div class="d-flex align-items-center justify-content-between">
                            <div>
                                <small class="text-warning">Use Code:</small>
                                <div class="text-white fw-bold">WEEKEND300</div>
                            </div>
                            <button class="btn btn-success rounded-pill px-4">
                                Claim Offer <i class="fas fa-arrow-right ms-2"></i>
                            </button>
                        </div>
                    </div>
                </div>
            </div>

            <div class="col-lg-4 col-md-6">
                <div class="offer-card-premium fade-in" style="animation-delay: 0.2s;">
                    <div class="position-relative">
                        <img src="https://images.unsplash.com/photo-1521791136064-7986c2920216?q=80&w=2069"
                            class="img-fluid"
                            alt="New User Offer"
                            style="height: 220px; width: 100%; object-fit: cover;">
                        <div class="position-absolute bottom-0 start-0 end-0 p-4"
                            style="background: linear-gradient(transparent, rgba(0,0,0,0.8))">
                            <span class="badge bg-warning px-3 py-2">NEW USER</span>
                        </div>
                    </div>
                    <div class="p-4">
                        <h5 class="text-white fw-bold mb-3">Welcome Bonus</h5>
                        <p class="text-light opacity-75 mb-3">Get ₹100 instant discount on your first booking with us</p>
                        <div class="d-flex align-items-center justify-content-between">
                            <div>
                                <small class="text-warning">Use Code:</small>
                                <div class="text-white fw-bold">FIRST100</div>
                            </div>
                            <button class="btn btn-warning rounded-pill px-4">
                                Claim Offer <i class="fas fa-arrow-right ms-2"></i>
                            </button>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

<!-- ===================================
     ENHANCED ROUTES SECTION
=================================== -->
<section id="routes" class="routes-section">
    <div class="container">
        <div class="text-center mb-5">
            <h2 class="fw-bold display-5 mb-3">🚆 Popular Routes</h2>
            <p class="text-muted lead">Most booked trains this week</p>
        </div>

        <div class="routes-table-enhanced shadow-lg">
            <div class="table-responsive">
                <table class="table table-hover mb-0">
                    <thead>
                        <tr>
                            <th class="py-3 px-4">Train & Route</th>
                            <th class="py-3 px-4">Departure</th>
                            <th class="py-3 px-4">Duration</th>
                            <th class="py-3 px-4">Fare From</th>
                            <th class="py-3 px-4">Seats</th>
                            <th class="py-3 px-4"></th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr class="border-bottom">
                            <td class="py-4 px-4">
                                <div class="d-flex align-items-center">
                                    <div class="bg-primary bg-opacity-10 text-primary rounded-2 p-3 me-3">
                                        <i class="fas fa-train fa-lg"></i>
                                    </div>
                                    <div>
                                        <h6 class="fw-bold mb-1">12951 · Mumbai Rajdhani</h6>
                                        <small class="text-muted">Mumbai → Delhi</small>
                                    </div>
                                </div>
                            </td>
                            <td class="py-4 px-4">
                                <div class="fw-bold">17:00 → 08:35</div>
                                <small class="text-muted">Daily</small>
                            </td>
                            <td class="py-4 px-4">
                                <span class="badge bg-light text-dark py-2 px-3">15h 35m</span>
                            </td>
                            <td class="py-4 px-4">
                                <div class="fw-bold fs-5 text-success">₹2,850</div>
                                <small class="text-muted">3A starts from</small>
                            </td>
                            <td class="py-4 px-4">
                                <div class="text-warning fw-bold">
                                    <i class="fas fa-chair me-1"></i> Available
                                </div>
                            </td>
                            <td class="py-4 px-4">
                                <button class="btn btn-primary rounded-pill px-4">
                                    Book <i class="fas fa-arrow-right ms-2"></i>
                                </button>
                            </td>
                        </tr>

                        <!-- Additional rows would follow same pattern -->
                    </tbody>
                </table>
            </div>

            <div class="text-center p-4 border-top">
                <a href="#all-trains" class="text-primary fw-bold text-decoration-none">
                    <i class="fas fa-list me-2"></i> View All Available Trains
                </a>
            </div>
        </div>
    </div>
</section>

<!-- ===================================
     TESTIMONIALS SECTION (NEW)
=================================== -->
<section class="testimonials-section">
    <div class="container">
        <div class="text-center mb-5">
            <h2 class="fw-bold display-5 mb-3">💬 Traveler Stories</h2>
            <p class="text-muted lead">What our customers say about us</p>
        </div>

        <div class="row g-4">
            <div class="col-lg-4 col-md-6">
                <div class="testimonial-card fade-in">
                    <div class="testimonial-rating">
                        <i class="fas fa-star"></i>
                        <i class="fas fa-star"></i>
                        <i class="fas fa-star"></i>
                        <i class="fas fa-star"></i>
                        <i class="fas fa-star"></i>
                    </div>
                    <p class="mb-4">"The booking process was incredibly smooth. I got confirmed tickets in under a minute. Highly recommended!"</p>
                    <div class="d-flex align-items-center">
                        <img src="https://randomuser.me/api/portraits/men/32.jpg"
                            class="rounded-circle me-3"
                            width="48"
                            height="48"
                            alt="User">
                        <div>
                            <h6 class="fw-bold mb-0">RajPut-Jii</h6>
                            <small class="text-muted">Frequent Traveler</small>
                        </div>
                    </div>
                </div>
            </div>

            <div class="col-lg-4 col-md-6">
                <div class="testimonial-card fade-in" style="animation-delay: 0.1s;">
                    <div class="testimonial-rating">
                        <i class="fas fa-star"></i>
                        <i class="fas fa-star"></i>
                        <i class="fas fa-star"></i>
                        <i class="fas fa-star"></i>
                        <i class="fas fa-star-half-alt"></i>
                    </div>
                    <p class="mb-4">"Zero fees is a game-changer! Saved so much on my monthly travel expenses. The app is super intuitive too."</p>
                    <div class="d-flex align-items-center">
                        <img src="https://randomuser.me/api/portraits/women/44.jpg"
                            class="rounded-circle me-3"
                            width="48"
                            height="48"
                            alt="User">
                        <div>
                            <h6 class="fw-bold mb-0">Nilam Rajput</h6>
                            <small class="text-muted">Business Executive</small>
                        </div>
                    </div>
                </div>
            </div>

            <div class="col-lg-4 col-md-6">
                <div class="testimonial-card fade-in" style="animation-delay: 0.2s;">
                    <div class="testimonial-rating">
                        <i class="fas fa-star"></i>
                        <i class="fas fa-star"></i>
                        <i class="fas fa-star"></i>
                        <i class="fas fa-star"></i>
                        <i class="fas fa-star"></i>
                    </div>
                    <p class="mb-4">"24/7 support saved my trip when I had last-minute changes. The team was responsive and helpful."</p>
                    <div class="d-flex align-items-center">
                        <img src="https://randomuser.me/api/portraits/men/67.jpg"
                            class="rounded-circle me-3"
                            width="48"
                            height="48"
                            alt="User">
                        <div>
                            <h6 class="fw-bold mb-0">Saku Raj</h6>
                            <small class="text-muted">Student</small>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>



<script>
    // Enhanced JavaScript for interactivity
    document.addEventListener('DOMContentLoaded', function() {
        // Set today's date as default
        const today = new Date();
        const tomorrow = new Date(today);
        tomorrow.setDate(tomorrow.getDate() + 1);

        document.getElementById('journeyDate').value = tomorrow.toISOString().split('T')[0];
        document.getElementById('journeyDate').min = today.toISOString().split('T')[0];

        // Form Validation
        const form = document.getElementById('bookingForm');
        form.addEventListener('submit', function(e) {
            if (!form.checkValidity()) {
                e.preventDefault();
                e.stopPropagation();
            }
            form.classList.add('was-validated');
        });

        // Swap Stations Functionality
        const swapBtn = document.getElementById('swapBtn');
        const fromStation = document.getElementById('fromStation');
        const toStation = document.getElementById('toStation');

        swapBtn.addEventListener('click', function() {
            const temp = fromStation.value;
            fromStation.value = toStation.value;
            toStation.value = temp;

            // Animation effect
            this.classList.add('rotate');
            setTimeout(() => this.classList.remove('rotate'), 300);
        });

        // Scroll Animations
        const observerOptions = {
            threshold: 0.1,
            rootMargin: '0px 0px -50px 0px'
        };

        const observer = new IntersectionObserver((entries) => {
            entries.forEach(entry => {
                if (entry.isIntersecting) {
                    entry.target.classList.add('visible');
                }
            });
        }, observerOptions);

        // Observe fade-in elements
        document.querySelectorAll('.fade-in').forEach(el => observer.observe(el));

        // Auto-complete for stations (mock data)
        const stations = [
            'New Delhi (NDLS)', 'Mumbai Central (BCT)', 'Chennai Central (MAS)',
            'Howrah Junction (HWH)', 'Bangalore City (SBC)', 'Secunderabad Junction (SC)',
            'Ahmedabad Junction (ADI)', 'Lucknow Junction (LJN)', 'Patna Junction (PNBE)'
        ];

        // Create datalist for stations
        const datalist = document.createElement('datalist');
        datalist.id = 'stationsList';
        stations.forEach(station => {
            const option = document.createElement('option');
            option.value = station;
            datalist.appendChild(option);
        });
        document.body.appendChild(datalist);

        fromStation.setAttribute('list', 'stationsList');
        toStation.setAttribute('list', 'stationsList');

        // Real-time validation feedback
        fromStation.addEventListener('input', function() {
            if (this.value.length > 2) {
                this.classList.add('is-valid');
            } else {
                this.classList.remove('is-valid');
            }
        });

        // Add CSS for swap animation
        const style = document.createElement('style');
        style.textContent = `
            .rotate {
                animation: rotate 0.3s ease;
            }
            @keyframes rotate {
                from { transform: translate(-50%, -50%) rotate(0deg); }
                to { transform: translate(-50%, -50%) rotate(180deg); }
            }
            .is-valid {
                border-color: #10b981 !important;
                background-image: url("data:image/svg+xml,%3csvg xmlns='http://www.w3.org/2000/svg' viewBox='0 0 8 8'%3e%3cpath fill='%2310b981' d='M2.3 6.73L.6 4.53c-.4-1.04.46-1.4 1.1-.8l1.1 1.4 3.4-3.8c.6-.63 1.6-.27 1.2.7l-4 4.6c-.43.5-.8.4-1.1.1z'/%3e%3c/svg%3e");
                background-repeat: no-repeat;
                background-position: right calc(0.375em + 0.1875rem) center;
                background-size: calc(0.75em + 0.375rem) calc(0.75em + 0.375rem);
            }
        `;
        document.head.appendChild(style);
    });

    // Floating Action Button Functions
    function scrollToBooking() {
        document.getElementById('bookingForm').scrollIntoView({
            behavior: 'smooth',
            block: 'center'
        });
    }

    function openChat() {
        alert('Live chat feature coming soon!');
        // In production, this would open a chat widget
    }

    // Real-time clock in booking form
    function updateClock() {
        const now = new Date();
        const timeString = now.toLocaleTimeString([], {
            hour: '2-digit',
            minute: '2-digit'
        });
        const dateString = now.toLocaleDateString('en-IN', {
            weekday: 'long',
            year: 'numeric',
            month: 'long',
            day: 'numeric'
        });

        const clockElement = document.getElementById('liveClock');
        if (clockElement) {
            clockElement.innerHTML = `<i class="fas fa-clock me-2"></i>${timeString} · ${dateString}`;
        }
    }

    // Update clock every second
    setInterval(updateClock, 1000);
    updateClock(); // Initial call
</script>

<?php include "includes/footer.php"; ?>