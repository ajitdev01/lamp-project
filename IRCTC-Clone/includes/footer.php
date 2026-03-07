<style>
    :root {
        --footer-bg: linear-gradient(135deg, #0f172a 0%, #1e293b 100%);
        --footer-accent: #f59e0b;
        --footer-text: #94a3b8;
        --footer-text-light: #cbd5e1;
        --footer-border: rgba(148, 163, 184, 0.1);
    }

    /* Footer Base */
    .footer-pro {
        background: var(--footer-bg);
        color: var(--footer-text);
        position: relative;
        overflow: hidden;
    }

    .footer-pro::before {
        content: '';
        position: absolute;
        top: 0;
        left: 0;
        right: 0;
        height: 1px;
        background: linear-gradient(90deg, transparent, var(--footer-accent), transparent);
    }

    /* Brand Section */
    .footer-logo {
        width: 60px;
        height: 60px;
        background: linear-gradient(135deg, var(--footer-accent), #fbbf24);
        border-radius: 16px;
        display: flex;
        align-items: center;
        justify-content: center;
        color: white;
        box-shadow: 0 10px 25px rgba(245, 158, 11, 0.3);
    }

    /* Trust Badges */
    .trust-badges {
        display: flex;
        gap: 0.75rem;
    }

    .badge-trust {
        background: rgba(255, 255, 255, 0.1);
        backdrop-filter: blur(10px);
        border: 1px solid rgba(255, 255, 255, 0.1);
        color: var(--footer-text-light);
        padding: 0.5rem 1rem;
        border-radius: 50px;
        font-size: 0.85rem;
        font-weight: 500;
        display: inline-flex;
        align-items: center;
        gap: 0.5rem;
    }

    /* Newsletter Form */
    .newsletter-form .form-control {
        background: rgba(255, 255, 255, 0.05);
        border: 1px solid rgba(255, 255, 255, 0.1);
        color: white;
        border-radius: 12px 0 0 12px;
        padding: 0.75rem 1rem;
        border-right: none;
    }

    .newsletter-form .form-control:focus {
        background: rgba(255, 255, 255, 0.08);
        border-color: var(--footer-accent);
        box-shadow: none;
        color: white;
    }

    .newsletter-form .btn {
        border-radius: 0 12px 12px 0;
        padding: 0.75rem 1.5rem;
        font-weight: 600;
    }

    /* Footer Titles */
    .footer-title {
        color: white;
        font-weight: 700;
        font-size: 1.1rem;
        position: relative;
        padding-bottom: 0.75rem;
        margin-bottom: 1.5rem;
    }

    .footer-title::after {
        content: '';
        position: absolute;
        bottom: 0;
        left: 0;
        width: 40px;
        height: 3px;
        background: var(--footer-accent);
        border-radius: 3px;
    }

    /* Footer Links */
    .footer-links {
        list-style: none;
        padding: 0;
        margin: 0;
    }

    .footer-links li {
        margin-bottom: 0.75rem;
    }

    .footer-links a {
        color: var(--footer-text);
        text-decoration: none;
        font-weight: 500;
        font-size: 0.95rem;
        display: flex;
        align-items: center;
        transition: all 0.3s ease;
        padding: 0.25rem 0;
    }

    .footer-links a:hover {
        color: var(--footer-accent);
        transform: translateX(5px);
    }

    .footer-links i {
        width: 20px;
        font-size: 0.9rem;
        opacity: 0.7;
    }

    /* Support Card */
    .support-card {
        background: rgba(255, 255, 255, 0.05);
        backdrop-filter: blur(10px);
        border: 1px solid rgba(255, 255, 255, 0.1);
        border-radius: 16px;
        padding: 1.5rem;
    }

    .support-icon {
        width: 48px;
        height: 48px;
        background: linear-gradient(135deg, #10b981, #059669);
        border-radius: 12px;
        display: flex;
        align-items: center;
        justify-content: center;
        color: white;
        font-size: 1.25rem;
    }

    .contact-info {
        display: flex;
        flex-direction: column;
        gap: 1rem;
    }

    .contact-item {
        display: flex;
        align-items: center;
        gap: 1rem;
        padding: 0.75rem;
        background: rgba(255, 255, 255, 0.03);
        border-radius: 12px;
        text-decoration: none;
        transition: all 0.3s ease;
        color: var(--footer-text-light);
    }

    .contact-item:hover {
        background: rgba(255, 255, 255, 0.08);
        transform: translateY(-2px);
        color: white;
    }

    .contact-item i {
        font-size: 1.25rem;
        opacity: 0.9;
    }

    .contact-item small {
        display: block;
        font-size: 0.75rem;
        opacity: 0.7;
        margin-bottom: 0.25rem;
    }

    /* App Buttons */
    .app-buttons {
        display: flex;
        gap: 1rem;
    }

    .app-btn {
        display: flex;
        align-items: center;
        padding: 0.75rem 1.25rem;
        border-radius: 12px;
        text-decoration: none;
        transition: all 0.3s ease;
        border: 1px solid rgba(255, 255, 255, 0.1);
        background: rgba(255, 255, 255, 0.05);
    }

    .app-btn:hover {
        transform: translateY(-3px);
        box-shadow: 0 10px 20px rgba(0, 0, 0, 0.2);
    }

    .app-btn.google-play:hover {
        background: #4285f4;
        border-color: #4285f4;
        color: white;
    }

    .app-btn.app-store:hover {
        background: #000;
        border-color: #000;
        color: white;
    }

    .app-icon {
        font-size: 1.75rem;
        margin-right: 0.75rem;
    }

    .app-text {
        line-height: 1.2;
    }

    .app-text small {
        font-size: 0.7rem;
        opacity: 0.8;
        display: block;
    }

    .app-text span {
        font-weight: 700;
        font-size: 1rem;
    }

    /* Social Icons */
    .social-icons {
        display: flex;
        align-items: center;
    }

    .social-icon {
        width: 40px;
        height: 40px;
        border-radius: 50%;
        background: rgba(255, 255, 255, 0.05);
        display: flex;
        align-items: center;
        justify-content: center;
        color: var(--footer-text);
        margin-right: 0.75rem;
        text-decoration: none;
        transition: all 0.3s ease;
        border: 1px solid rgba(255, 255, 255, 0.1);
    }

    .social-icon:hover {
        background: var(--footer-accent);
        color: white;
        transform: translateY(-3px);
        border-color: var(--footer-accent);
    }

    /* Payment Methods */
    .payment-methods {
        display: flex;
        align-items: center;
        justify-content: center;
    }

    .payment-icon {
        font-size: 1.5rem;
        color: var(--footer-text);
        margin: 0 0.5rem;
        transition: color 0.3s ease;
    }

    .payment-icon:hover {
        color: var(--footer-accent);
    }

    /* Back to Top Button */
    .btn-back-to-top {
        position: fixed;
        bottom: 30px;
        right: 30px;
        width: 50px;
        height: 50px;
        background: var(--footer-accent);
        color: white;
        border: none;
        border-radius: 50%;
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 1.25rem;
        cursor: pointer;
        opacity: 0;
        visibility: hidden;
        transform: translateY(20px);
        transition: all 0.3s ease;
        z-index: 1000;
        box-shadow: 0 5px 20px rgba(245, 158, 11, 0.3);
    }

    .btn-back-to-top.visible {
        opacity: 1;
        visibility: visible;
        transform: translateY(0);
    }

    .btn-back-to-top:hover {
        background: #fbbf24;
        transform: translateY(-5px);
        box-shadow: 0 10px 25px rgba(245, 158, 11, 0.4);
    }

    /* Responsive Design */
    @media (max-width: 992px) {
        .footer-pro {
            text-align: center;
        }

        .footer-title::after {
            left: 50%;
            transform: translateX(-50%);
        }

        .footer-links a:hover {
            transform: translateX(0);
        }

        .app-buttons {
            flex-direction: column;
        }

        .social-icons {
            justify-content: center;
        }

        .payment-methods {
            justify-content: center;
            margin: 1rem 0;
        }
    }

    @media (max-width: 768px) {
        .trust-badges {
            justify-content: center;
        }

        .contact-item {
            justify-content: center;
            text-align: center;
        }

        .contact-item div {
            text-align: center;
        }

        .btn-back-to-top {
            bottom: 20px;
            right: 20px;
            width: 45px;
            height: 45px;
        }
    }
</style>
<!-- Professional Footer -->
<footer class="footer-pro py-5 mt-auto">
    <div class="container">
        <!-- Main Footer Grid -->
        <div class="row g-5">

            <!-- Brand & About -->
            <div class="col-xl-4 col-lg-5">
                <div class="brand-section mb-4">
                    <div class="d-flex align-items-center mb-4">
                        <div class="footer-logo">
                            <i class="fas fa-train-subway fa-2x"></i>
                        </div>
                        <div class="ms-3">
                            <h3 class="fw-bold mb-0 text-white"><?= SITENAME ?></h3>
                            <p class="text-light mb-0 small">IRCTC Authorized Partner</p>
                        </div>
                    </div>
                    <p class="text-light opacity-75 lh-lg mb-4">
                        India's leading railway booking platform. Experience seamless ticket booking with
                        <span class="text-warning fw-semibold">100% confirmation guarantee</span>,
                        zero convenience fees, and 24/7 customer support.
                    </p>

                    <!-- Trust Badges -->
                    <div class="trust-badges d-flex flex-wrap gap-2 mb-4">
                        <span class="badge-trust">
                            <i class="fas fa-shield-check"></i> 100% Secure
                        </span>
                        <span class="badge-trust">
                            <i class="fas fa-bolt"></i> Instant Booking
                        </span>
                        <span class="badge-trust">
                            <i class="fas fa-headset"></i> 24/7 Support
                        </span>
                    </div>
                </div>

                <!-- Newsletter -->
                <div class="newsletter-section">
                    <h6 class="text-white fw-semibold mb-3">Stay Updated</h6>
                    <p class="text-light opacity-75 small mb-3">Get travel offers, discounts & updates</p>
                    <form class="newsletter-form">
                        <div class="input-group">
                            <input type="email" class="form-control" placeholder="Your email address" required>
                            <button class="btn btn-warning" type="submit">
                                <i class="fas fa-paper-plane"></i>
                            </button>
                        </div>
                        <div class="form-text text-light opacity-75 small mt-2">
                            <i class="fas fa-lock me-1"></i> We respect your privacy
                        </div>
                    </form>
                </div>
            </div>

            <!-- Quick Links -->
            <div class="col-xl-2 col-lg-2 col-md-4 col-6">
                <h5 class="footer-title mb-4">Quick Links</h5>
                <ul class="footer-links">
                    <li><a href="index.php"><i class="fas fa-home me-2"></i> Home</a></li>
                    <li><a href="book.php"><i class="fas fa-ticket-alt me-2"></i> Book Ticket</a></li>
                    <li><a href="pnr.php"><i class="fas fa-search me-2"></i> PNR Status</a></li>
                    <li><a href="schedule.php"><i class="fas fa-calendar-alt me-2"></i> Train Schedule</a></li>
                    <li><a href="fare.php"><i class="fas fa-rupee-sign me-2"></i> Fare Enquiry</a></li>
                    <li><a href="#"><i class="fas fa-train me-2"></i> Live Status</a></li>
                </ul>
            </div>

            <!-- Company -->
            <div class="col-xl-2 col-lg-2 col-md-4 col-6">
                <h5 class="footer-title mb-4">Company</h5>
                <ul class="footer-links">
                    <li><a href="about.php"><i class="fas fa-info-circle me-2"></i> About Us</a></li>
                    <li><a href="contact.php"><i class="fas fa-envelope me-2"></i> Contact Us</a></li>
                    <li><a href="#"><i class="fas fa-briefcase me-2"></i> Careers</a></li>
                    <li><a href="blog.php"><i class="fas fa-blog me-2"></i> Blog</a></li>
                    <li><a href="privacy.php"><i class="fas fa-shield-alt me-2"></i> Privacy Policy</a></li>
                    <li><a href="terms.php"><i class="fas fa-file-contract me-2"></i> Terms</a></li>
                </ul>
            </div>

            <!-- Contact & App -->
            <div class="col-xl-4 col-lg-3 col-md-4">
                <div class="contact-section">
                    <h5 class="footer-title mb-4">Contact & Support</h5>

                    <!-- Support Card -->
                    <div class="support-card mb-4">
                        <div class="d-flex align-items-start mb-3">
                            <div class="support-icon">
                                <i class="fas fa-headset"></i>
                            </div>
                            <div class="ms-3">
                                <h6 class="text-white fw-semibold mb-1">24/7 Customer Support</h6>
                                <p class="text-light opacity-75 small mb-0">We're here to help you anytime</p>
                            </div>
                        </div>
                        <div class="contact-info">
                            <a href="tel:+917808982006" class="contact-item">
                                <i class="fas fa-phone-alt text-success"></i>
                                <div>
                                    <small>Toll Free</small>
                                    <div class="fw-semibold">+91 78089 82006</div>
                                </div>
                            </a>
                            <a href="mailto:<?= strtolower(str_replace(' ', '', CONTACT_EMAIL)) ?>.com" class="contact-item">
                                <i class="fas fa-envelope text-warning"></i>
                                <div>
                                    <small>Email Support</small>
                                    <p class="fw-semibold"><?= strtolower(str_replace(' ', '', CONTACT_EMAIL)) ?>.com</p>
                                </div>
                            </a>
                        </div>
                    </div>

                    <!-- Mobile Apps -->
                    <div class="apps-section">
                        <h6 class="text-white fw-semibold mb-3">Download Our App</h6>
                        <p class="text-light opacity-75 small mb-3">Book faster, get exclusive offers</p>
                        <div class="app-buttons d-flex flex-column gap-2">
                            <a href="#" class="app-btn google-play">
                                <div class="app-icon">
                                    <i class="fab fa-google-play"></i>
                                </div>
                                <div class="app-text">
                                    <small>GET IT ON</small>
                                    <span>Google Play</span>
                                </div>
                            </a>
                            <a href="#" class="app-btn app-store">
                                <div class="app-icon">
                                    <i class="fab fa-apple"></i>
                                </div>
                                <div class="app-text">
                                    <small>Download on the</small>
                                    <span>App Store</span>
                                </div>
                            </a>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Social & Bottom Bar -->
        <div class="footer-bottom mt-5 pt-4 border-top border-light border-opacity-10">
            <div class="row align-items-center">
                <!-- Social Media -->
                <div class="col-lg-4 mb-3 mb-lg-0">
                    <div class="social-icons">
                        <span class="text-light opacity-75 me-3">Follow us:</span>
                        <a href="#" class="social-icon" title="Facebook">
                            <i class="fab fa-facebook-f"></i>
                        </a>
                        <a href="#" class="social-icon" title="Twitter">
                            <i class="fab fa-twitter"></i>
                        </a>
                        <a href="https://www.instagram.com/anonymous_king_2506" class="social-icon" title="Instagram">
                            <i class="fab fa-instagram"></i>
                        </a>
                        <a href="https://www.linkedin.com/in/ajit-k-0b9b46288/" class="social-icon" title="LinkedIn">
                            <i class="fab fa-linkedin-in"></i>
                        </a>
                        <a href="#" class="social-icon" title="YouTube">
                            <i class="fab fa-youtube"></i>
                        </a>
                    </div>
                </div>

                <!-- Payment Methods -->
                <div class="col-lg-4 mb-3 mb-lg-0">
                    <div class="payment-methods text-center">
                        <span class="text-light opacity-75 me-2">We accept:</span>
                        <i class="fab fa-cc-visa payment-icon"></i>
                        <i class="fab fa-cc-mastercard payment-icon"></i>
                        <i class="fab fa-cc-amex payment-icon"></i>
                        <i class="fab fa-cc-paypal payment-icon"></i>
                        <i class="fas fa-university payment-icon"></i>
                        <i class="fas fa-rupee-sign payment-icon"></i>
                    </div>
                </div>

                <!-- Copyright -->
                <div class="col-lg-4 text-lg-end">
                    <div class="copyright">
                        <p class="text-light opacity-75 mb-0">
                            © <?= date('Y') ?> <?= SITENAME ?>. All rights reserved.
                            <span class="d-block d-md-inline">
                                Made with <i class="fas fa-heart text-danger"></i> by
                                <a href="#" class="text-warning fw-semibold text-decoration-none">Brainzima</a>
                            </span>
                        </p>
                    </div>
                </div>
            </div>
        </div>
    </div>
</footer>

<!-- Bootstrap JS Bundle (MUST BE ADDED) -->
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
<script>
    // Newsletter Form Submission
    document.querySelector('.newsletter-form').addEventListener('submit', function(e) {
        e.preventDefault();
        const email = this.querySelector('input[type="email"]').value;

        // Show success message
        const form = this;
        const originalHTML = form.innerHTML;
        form.innerHTML = `
            <div class="text-success text-center py-3">
                <i class="fas fa-check-circle fa-2x mb-2"></i>
                <p class="mb-0">Thank you for subscribing!</p>
                <small>We've sent a confirmation to ${email}</small>
            </div>
        `;

        // Reset form after 3 seconds
        setTimeout(() => {
            form.innerHTML = originalHTML;
            form.querySelector('input[type="email"]').value = '';
        }, 3000);
    });

    // Smooth scroll for anchor links
    document.querySelectorAll('a[href^="#"]').forEach(anchor => {
        anchor.addEventListener('click', function(e) {
            const href = this.getAttribute('href');
            if (href !== '#' && !href.startsWith('#')) return;

            e.preventDefault();
            const targetId = href === '#' ? 'body' : href;
            const targetElement = document.querySelector(targetId);

            if (targetElement) {
                targetElement.scrollIntoView({
                    behavior: 'smooth',
                    block: 'start'
                });
            }
        });
    });
</script>