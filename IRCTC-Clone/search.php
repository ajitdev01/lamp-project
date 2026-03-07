<?php include "includes/header.php"; ?>
<?php
if (isset($_POST['search'])) {
    $from = mysqli_real_escape_string($conn, $_POST['fromStation']);
    $to = mysqli_real_escape_string($conn, $_POST['toStation']);
    $date = $_POST['journeyDate'] ?? date('Y-m-d');
    $class = $_POST['class'] ?? '';

    $sql = "SELECT t.*, r.* FROM trains_tbl AS t 
            JOIN routes_tbl AS r ON t.train_route_id = r.route_id 
            WHERE r.route_start LIKE '%$from%' 
            AND r.route_end LIKE '%$to%'";

    $result = mysqli_query($conn, $sql);
    $trainCount = mysqli_num_rows($result);
}
?>
<style>
    /* Hero Section */
    .search-results-hero {
        background: linear-gradient(135deg, #236cfeff 0%, #032896ff 100%);
        color: white;
        padding: 4rem 0 2rem;
        margin-bottom: 3rem;
        border-radius: 0 0 30px 30px;
        position: relative;
        overflow: hidden;
    }

    .search-results-hero::before {
        content: '';
        position: absolute;
        top: 0;
        left: 0;
        right: 0;
        bottom: 0;
        background: url('data:image/svg+xml,<svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 1440 320"><path fill="rgba(255,255,255,0.1)" d="M0,224L48,213.3C96,203,192,181,288,181.3C384,181,480,203,576,192C672,181,768,139,864,138.7C960,139,1056,181,1152,186.7C1248,192,1344,160,1392,144L1440,128L1440,320L1392,320C1344,320,1248,320,1152,320C1056,320,960,320,864,320C768,320,672,320,576,320C480,320,384,320,288,320C192,320,96,320,48,320L0,320Z"></path></svg>') bottom/cover no-repeat;
    }

    .search-results-hero .container {
        position: relative;
        z-index: 2;
    }

    /* Search Summary Card */
    .search-summary {
        background: white;
        border-radius: 15px;
        padding: 1.5rem;
        box-shadow: 0 5px 20px rgba(0, 0, 0, 0.1);
        margin-bottom: 2rem;
    }

    .route-display {
        display: flex;
        align-items: center;
        justify-content: center;
        gap: 1rem;
        margin: 1rem 0;
    }

    .route-arrow {
        color: #2222e6ff;
        font-size: 1.5rem;
    }

    /* Train Cards */
    .train-card {
        background: white;
        border-radius: 12px;
        border: 1px solid #e0e0e0;
        transition: all 0.3s ease;
        margin-bottom: 1.5rem;
        overflow: hidden;
    }

    .train-card:hover {
        transform: translateY(-5px);
        box-shadow: 0 10px 30px rgba(0, 0, 0, 0.15);
        border-color: #4955fbff;
    }

    .train-header {
        background: linear-gradient(135deg, #f8f9fa 0%, #e9ecef 100%);
        padding: 1.5rem;
        border-bottom: 1px solid #e0e0e0;
    }

    .train-number {
        font-size: 1.8rem;
        font-weight: 800;
        color: #222fe6ff;
    }

    .train-name {
        font-size: 1.2rem;
        font-weight: 600;
        color: #2c3e50;
    }

    .train-type {
        display: inline-block;
        background: #2229e6ff;
        color: white;
        padding: 0.25rem 0.75rem;
        border-radius: 20px;
        font-size: 0.8rem;
        font-weight: 500;
    }

    .train-details {
        padding: 1.5rem;
    }

    .time-display {
        font-size: 1.5rem;
        font-weight: 700;
        color: #2c3e50;
    }

    .station-name {
        color: #666;
        font-size: 0.9rem;
        margin-top: 0.25rem;
    }

    .duration-badge {
        background: #f8f9fa;
        border: 1px solid #dee2e6;
        border-radius: 20px;
        padding: 0.5rem 1rem;
        font-weight: 500;
        color: #2c3e50;
    }

    .availability-badge {
        display: inline-flex;
        align-items: center;
        gap: 0.5rem;
        padding: 0.5rem 1rem;
        border-radius: 20px;
        font-weight: 500;
        font-size: 0.9rem;
    }

    .availability-badge.available {
        background: rgba(46, 204, 113, 0.1);
        color: #27ae60;
        border: 1px solid #27ae60;
    }

    .availability-badge.waiting {
        background: rgba(241, 196, 15, 0.1);
        color: #1912f3ff;
        border: 1px solid #f39c12;
    }

    .availability-badge.full {
        background: rgba(231, 76, 60, 0.1);
        color: #e74c3c;
        border: 1px solid #e74c3c;
    }

    .availability-dot {
        width: 8px;
        height: 8px;
        border-radius: 50%;
        display: inline-block;
    }

    .availability-dot.available {
        background: #27ae60;
    }

    .availability-dot.waiting {
        background: #121df3ff;
    }

    .availability-dot.full {
        background: #e74c3c;
    }

    .btn-book-now {
        background: linear-gradient(135deg, #270fffff 0%, #be28ffff 100%);
        color: white;
        border: none;
        padding: 0.75rem 1.5rem;
        border-radius: 8px;
        font-weight: 600;
        transition: all 0.3s ease;
        width: 100%;
    }

    .btn-book-now:hover {
        transform: translateY(-2px);
        box-shadow: 0 5px 15px rgba(230, 126, 34, 0.3);
        color: white;
    }

    .btn-book-now:disabled {
        background: #95a5a6;
        cursor: not-allowed;
        transform: none;
        box-shadow: none;
    }

    .class-info {
        color: #666;
        font-size: 0.9rem;
    }

    .class-price {
        font-size: 1.2rem;
        font-weight: 700;
        color: #27ae60;
    }

    /* No Results State */
    .no-results-card {
        background: white;
        border-radius: 15px;
        padding: 3rem;
        text-align: center;
        box-shadow: 0 5px 20px rgba(0, 0, 0, 0.1);
        margin: 2rem 0;
    }

    .no-results-icon {
        font-size: 4rem;
        color: #222ce6ff;
        margin-bottom: 1.5rem;
    }

    /* Filters */
    .filters-section {
        background: white;
        border-radius: 10px;
        padding: 1.5rem;
        margin-bottom: 2rem;
        box-shadow: 0 3px 15px rgba(0, 0, 0, 0.08);
    }

    .filter-btn {
        border: 1px solid #dee2e6;
        background: white;
        color: #495057;
        padding: 0.5rem 1rem;
        border-radius: 6px;
        transition: all 0.3s ease;
    }

    .filter-btn:hover,
    .filter-btn.active {
        background: #2f22e6ff;
        color: white;
        border-color: #3c22e6ff;
    }

    /* Responsive */
    @media (max-width: 768px) {
        .search-results-hero {
            padding: 3rem 0 2rem;
            border-radius: 0 0 20px 20px;
        }

        .route-display {
            flex-direction: column;
            gap: 0.5rem;
        }

        .train-header {
            padding: 1rem;
        }

        .train-number {
            font-size: 1.5rem;
        }

        .train-name {
            font-size: 1rem;
        }

        .time-display {
            font-size: 1.2rem;
        }
    }
</style>

<!-- Hero Section -->
<section class="search-results-hero">
    <div class="container">
        <div class="text-center text-white mb-4">
            <h1 class="display-5 fw-bold mb-3">🚆 Available Trains</h1>
            <p class="lead">Book your journey in just a few clicks</p>
        </div>

        <!-- Search Summary -->
        <div class="search-summary">
            <div class="row align-items-center">
                <div class="col-md-8">
                    <div class="d-flex align-items-center justify-content-center">
                        <div class="text-center">
                            <div class="fw-bold text-dark"><?= htmlspecialchars($_POST['fromStation'] ?? 'Select Station') ?></div>
                            <div class="text-muted small">Departure</div>
                        </div>

                        <div class="px-4">
                            <i class="fas fa-long-arrow-alt-right route-arrow"></i>
                        </div>

                        <div class="text-center">
                            <div class="fw-bold text-dark"><?= htmlspecialchars($_POST['toStation'] ?? 'Select Station') ?></div>
                            <div class="text-muted small">Arrival</div>
                        </div>
                    </div>

                    <div class="text-center mt-3">
                        <span class="badge bg-primary bg-opacity-10 text-primary px-3 py-2 me-2">
                            <i class="far fa-calendar me-1"></i>
                            <?= date('d M Y', strtotime($_POST['journeyDate'] ?? date('Y-m-d'))) ?>
                        </span>
                        <span class="badge bg-primary bg-opacity-10 text-primary px-3 py-2">
                            <i class="fas fa-chair me-1"></i>
                            <?= $_POST['class'] ? htmlspecialchars($_POST['class']) : 'All Classes' ?>
                        </span>
                    </div>
                </div>

                <div class="col-md-4 text-center text-md-end mt-3 mt-md-0">
                    <a href="index.php" class="btn btn-outline-primary">
                        <i class="fas fa-search me-2"></i> New Search
                    </a>
                </div>
            </div>
        </div>
    </div>
</section>

<!-- Main Content -->
<section class="container mb-5">
    <!-- Results Header -->
    <div class="d-flex justify-content-between align-items-center mb-4">
        <div>
            <h3 class="fw-bold mb-0">Available Trains</h3>
            <p class="text-muted mb-0"><?= $trainCount ?? 0 ?> train(s) found</p>
        </div>

        <!-- Quick Filters -->
        <div class="filters-section d-none d-md-block">
            <span class="me-2">Sort by:</span>
            <button class="filter-btn me-2 active">Departure Time</button>
            <button class="filter-btn me-2">Duration</button>
            <button class="filter-btn">Price</button>
        </div>
    </div>

    <?php if (!empty($result) && mysqli_num_rows($result) > 0): ?>
        <!-- Train Results -->
        <div class="row">
            <?php while ($data = mysqli_fetch_assoc($result)):
                $start = new DateTime($data['train_stime']);
                $end   = new DateTime($data['train_etime']);
                $diff  = $start->diff($end);
                $duration = $diff->h . "h " . $diff->i . "m";

                // Simulate availability (in real app, fetch from database)
                $availability = ['available', 'waiting', 'full'][rand(0, 2)];
                $availabilityText = [
                    'available' => 'Seats Available',
                    'waiting' => 'WL Only',
                    'full' => 'No Seats'
                ][$availability];

                // Simulate price (in real app, fetch from database)
                $price = rand(500, 5000);
            ?>
                <div class="col-12 mb-3">
                    <div class="train-card">
                        <!-- Train Header -->
                        <div class="train-header">
                            <div class="row align-items-center">
                                <div class="col-md-3">
                                    <div class="train-number">#<?= $data['train_number'] ?></div>
                                    <div class="train-name"><?= htmlspecialchars($data['train_name']) ?></div>
                                </div>
                                <div class="col-md-3">
                                    <span class="train-type">
                                        <i class="fas fa-train me-1"></i> Express
                                    </span>
                                </div>
                                <div class="col-md-6 text-end">
                                    <div class="availability-badge <?= $availability ?>">
                                        <span class="availability-dot <?= $availability ?>"></span>
                                        <?= $availabilityText ?>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- Train Details -->
                        <div class="train-details">
                            <div class="row align-items-center">
                                <!-- Departure -->
                                <div class="col-md-3 text-center mb-3 mb-md-0">
                                    <div class="time-display">
                                        <?= date('h:i A', strtotime($data['train_stime'])) ?>
                                    </div>
                                    <div class="station-name">
                                        <?= htmlspecialchars($data['route_start']) ?>
                                    </div>
                                </div>

                                <!-- Duration -->
                                <div class="col-md-2 text-center mb-3 mb-md-0">
                                    <div class="duration-badge">
                                        <i class="far fa-clock me-1"></i>
                                        <?= $duration ?>
                                    </div>
                                    <div class="text-muted small mt-1">Journey Time</div>
                                </div>

                                <!-- Arrival -->
                                <div class="col-md-3 text-center mb-3 mb-md-0">
                                    <div class="time-display">
                                        <?= date('h:i A', strtotime($data['train_etime'])) ?>
                                    </div>
                                    <div class="station-name">
                                        <?= htmlspecialchars($data['route_end']) ?>
                                    </div>
                                </div>

                                <!-- Price & Action -->
                                <div class="col-md-4">
                                    <div class="d-flex align-items-center justify-content-between">
                                        <div>
                                            <div class="class-info">Starting from</div>
                                            <div class="class-price">₹<?= number_format($price) ?></div>
                                        </div>
                                        <div>
                                            <?php if ($availability === 'available'): ?>
                                                <a href="booking.php?train_id=<?= $data['train_id'] ?>&date=<?= $_POST['journeyDate'] ?? date('Y-m-d') ?>&class=<?= $_POST['class'] ?? '' ?>"
                                                    class="btn btn-book-now">
                                                    <i class="fas fa-ticket-alt me-2"></i> Book Now
                                                </a>
                                            <?php else: ?>
                                                <button class="btn btn-book-now" disabled>
                                                    <i class="fas fa-ban me-2"></i>
                                                    <?= $availability === 'waiting' ? 'Waitlist' : 'Not Available' ?>
                                                </button>
                                            <?php endif; ?>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            <?php endwhile; ?>
        </div>

        <!-- Mobile Filters -->
        <div class="filters-section d-block d-md-none mt-4">
            <div class="text-center mb-2">Sort by:</div>
            <div class="d-flex justify-content-center gap-2">
                <button class="filter-btn">Departure</button>
                <button class="filter-btn">Duration</button>
                <button class="filter-btn">Price</button>
            </div>
        </div>

    <?php else: ?>
        <!-- No Results State -->
        <div class="no-results-card">
            <div class="no-results-icon">
                <i class="fas fa-train"></i>
            </div>
            <h3 class="fw-bold mb-3">No Trains Found</h3>
            <p class="text-muted mb-4">Sorry, we couldn't find any trains for your selected route.</p>
            <div class="d-flex justify-content-center gap-3">
                <a href="index.php" class="btn btn-primary">
                    <i class="fas fa-search me-2"></i> Search Again
                </a>
                <a href="schedule.php" class="btn btn-outline-primary">
                    <i class="fas fa-calendar-alt me-2"></i> View Schedule
                </a>
            </div>
        </div>
    <?php endif; ?>
</section>

<!-- JavaScript for Interactivity -->
<script>
    document.addEventListener('DOMContentLoaded', function() {
        // Filter buttons functionality
        document.querySelectorAll('.filter-btn').forEach(btn => {
            btn.addEventListener('click', function() {
                // Remove active class from all buttons
                document.querySelectorAll('.filter-btn').forEach(b => {
                    b.classList.remove('active');
                });
                // Add active class to clicked button
                this.classList.add('active');

                // Here you would implement actual sorting logic
                // For now, just show a message
                console.log('Sorting by:', this.textContent);
            });
        });

        // Simulate loading state on book buttons
        document.querySelectorAll('.btn-book-now:not(:disabled)').forEach(btn => {
            btn.addEventListener('click', function(e) {
                // Add loading animation
                this.innerHTML = '<i class="fas fa-spinner fa-spin me-2"></i> Loading...';
                this.disabled = true;

                // In production, remove this timeout and handle actual navigation
                setTimeout(() => {
                    // The actual navigation happens via href
                    // This timeout is just for demo loading effect
                }, 1000);
            });
        });

        // Update train count display
        const trainCount = <?= $trainCount ?? 0 ?>;
        if (trainCount === 0) {
            document.querySelector('h3').textContent = 'No Trains Found';
        }
    });
</script>

<?php include "includes/footer.php"; ?>