<?php
include 'config/config.php';
session_start();

// LOGIN CHECK
if (!isset($_SESSION['user_id'])) {

  // collect train_id safely
  $ref = isset($_GET['train_id']) ? $_GET['train_id'] : '';

  // encode redirect URL
  $redirect = urlencode("booking.php?train_id=" . $ref);

  // redirect to login
  header("Location: login.php?redirect=" . $redirect);
  exit();
}

// FETCH TRAIN DETAILS
$data = null;

if (isset($_GET['train_id'])) {

  $train_id = mysqli_real_escape_string($conn, $_GET['train_id']);

  $sql = "
        SELECT
            t.train_id,
            t.train_number,
            t.train_name,
            t.train_ac_capacity,
            t.train_sl_capacity,
            t.train_gn_capacity,
            t.train_total_capacity,
            t.train_stime,
            t.train_etime,
            r.route_id,
            r.route_start,
            r.route_end,
            r.route_distance,
            t.created_at AS train_created,
            t.updated_at AS train_updated,
            r.created_at AS route_created,
            r.updated_at AS route_updated
        FROM trains_tbl t
        INNER JOIN routes_tbl r
            ON t.train_route_id = r.route_id
        WHERE t.train_id = '$train_id'
        LIMIT 1
    ";

  $result = mysqli_query($conn, $sql);

  if ($result && mysqli_num_rows($result) > 0) {
    $data = mysqli_fetch_assoc($result);
  }
}
?>
<?php include "./includes/header.php"; ?>

<style>
  :root {
    --primary: #2563eb;
    --primary-light: #60a5fa;
    --primary-dark: #1e40af;
    --secondary: #8b5cf6;
    --accent: #f59e0b;
    --success: #10b981;
    --danger: #ef4444;
    --warning: #fbbf24;
    --dark: #1f2937;
    --darker: #111827;
    --light: #f9fafb;
    --lighter: #ffffff;
    --gray: #6b7280;
    --border: #e5e7eb;
    --shadow-sm: 0 1px 3px rgba(0, 0, 0, 0.1);
    --shadow-md: 0 4px 6px -1px rgba(0, 0, 0, 0.1);
    --shadow-lg: 0 10px 15px -3px rgba(0, 0, 0, 0.1);
    --shadow-xl: 0 20px 25px -5px rgba(0, 0, 0, 0.1);
    --shadow-2xl: 0 25px 50px -12px rgba(0, 0, 0, 0.25);
    --radius-sm: 8px;
    --radius-md: 12px;
    --radius-lg: 16px;
    --radius-xl: 20px;
  }

  body {
    background: linear-gradient(135deg, #f8fafc 0%, #f1f5f9 100%);
    font-family: 'Inter', 'Poppins', sans-serif;
    min-height: 100vh;
  }

  /* Progress Steps */
  .booking-progress {
    position: fixed;
    top: 80px;
    left: 0;
    right: 0;
    background: var(--lighter);
    z-index: 100;
    box-shadow: var(--shadow-md);
    padding: 1rem 0;
  }

  .progress-steps {
    display: flex;
    justify-content: center;
    gap: 2rem;
    padding: 0 1rem;
    max-width: 1200px;
    margin: 0 auto;
  }

  .progress-step {
    display: flex;
    align-items: center;
    gap: 0.75rem;
  }

  .step-icon {
    width: 36px;
    height: 36px;
    border-radius: 50%;
    background: var(--light);
    border: 2px solid var(--border);
    display: flex;
    align-items: center;
    justify-content: center;
    font-weight: 600;
    color: var(--gray);
    transition: all 0.3s ease;
  }

  .step-icon.active {
    background: var(--primary);
    border-color: var(--primary);
    color: white;
    box-shadow: 0 0 0 4px rgba(37, 99, 235, 0.1);
  }

  .step-text {
    font-weight: 600;
    color: var(--gray);
    white-space: nowrap;
  }

  .step-text.active {
    color: var(--primary);
  }

  /* Main Container */
  .booking-container {
    max-width: 1400px;
    margin: 160px auto 2rem;
    padding: 0 1.5rem;
  }

  /* Train Header Card */
  .train-header-card {
    background: var(--lighter);
    border-radius: var(--radius-lg);
    padding: 2rem;
    margin-bottom: 2rem;
    box-shadow: var(--shadow-xl);
    border: 1px solid var(--border);
    position: relative;
    overflow: hidden;
  }

  .train-header-card::before {
    content: '';
    position: absolute;
    top: 0;
    left: 0;
    right: 0;
    height: 4px;
    background: linear-gradient(90deg, var(--primary), var(--secondary));
  }

  .train-badge {
    position: absolute;
    top: 1rem;
    right: 1rem;
    background: var(--success);
    color: white;
    padding: 0.5rem 1rem;
    border-radius: 50px;
    font-weight: 600;
    font-size: 0.875rem;
    box-shadow: var(--shadow-md);
  }

  /* Journey Timeline */
  .journey-timeline {
    display: flex;
    align-items: center;
    justify-content: space-between;
    position: relative;
    padding: 2rem 0;
  }

  .journey-timeline::before {
    content: '';
    position: absolute;
    top: 50%;
    left: 0;
    right: 0;
    height: 2px;
    background: linear-gradient(90deg, var(--primary-light), var(--border), var(--primary-light));
    z-index: 1;
  }

  .station-point {
    position: relative;
    z-index: 2;
    text-align: center;
    background: var(--lighter);
    padding: 1rem;
    border-radius: var(--radius-md);
    box-shadow: var(--shadow-md);
    min-width: 200px;
  }

  .station-dot {
    width: 16px;
    height: 16px;
    background: var(--primary);
    border: 4px solid var(--lighter);
    border-radius: 50%;
    margin: 0 auto 0.5rem;
    box-shadow: 0 0 0 2px var(--primary);
  }

  .station-name {
    font-weight: 700;
    color: var(--dark);
    font-size: 1.1rem;
  }

  .station-time {
    font-size: 1.25rem;
    font-weight: 800;
    color: var(--primary);
    margin: 0.25rem 0;
  }

  .duration-badge {
    position: absolute;
    top: 50%;
    left: 50%;
    transform: translate(-50%, -50%);
    background: var(--lighter);
    padding: 0.5rem 1.5rem;
    border-radius: 50px;
    font-weight: 600;
    color: var(--dark);
    box-shadow: var(--shadow-md);
    border: 1px solid var(--border);
    z-index: 3;
  }

  /* Booking Cards */
  .booking-card {
    background: var(--lighter);
    border-radius: var(--radius-lg);
    padding: 2rem;
    margin-bottom: 2rem;
    box-shadow: var(--shadow-xl);
    border: 1px solid var(--border);
    transition: all 0.3s ease;
  }

  .booking-card:hover {
    transform: translateY(-2px);
    box-shadow: var(--shadow-2xl);
  }

  .section-title {
    font-size: 1.5rem;
    font-weight: 800;
    color: var(--dark);
    margin-bottom: 1.5rem;
    position: relative;
    padding-bottom: 0.75rem;
  }

  .section-title::after {
    content: '';
    position: absolute;
    bottom: 0;
    left: 0;
    width: 60px;
    height: 4px;
    background: linear-gradient(90deg, var(--primary), var(--secondary));
    border-radius: 2px;
  }

  /* Passenger Cards */
  .passenger-grid {
    display: grid;
    grid-template-columns: repeat(auto-fit, minmax(300px, 1fr));
    gap: 1.5rem;
    margin-bottom: 2rem;
  }

  .passenger-card {
    background: var(--light);
    border-radius: var(--radius-md);
    padding: 1.5rem;
    border: 2px solid transparent;
    transition: all 0.3s ease;
    position: relative;
  }

  .passenger-card:hover {
    border-color: var(--primary-light);
    background: var(--lighter);
    transform: translateY(-2px);
    box-shadow: var(--shadow-md);
  }

  .passenger-header {
    display: flex;
    justify-content: space-between;
    align-items: center;
    margin-bottom: 1rem;
    padding-bottom: 0.75rem;
    border-bottom: 2px solid var(--border);
  }

  .passenger-number {
    font-weight: 700;
    color: var(--primary);
    font-size: 1.1rem;
  }

  .remove-passenger {
    background: var(--danger);
    color: white;
    border: none;
    width: 32px;
    height: 32px;
    border-radius: 50%;
    display: flex;
    align-items: center;
    justify-content: center;
    cursor: pointer;
    transition: all 0.2s ease;
  }

  .remove-passenger:hover {
    background: #dc2626;
    transform: scale(1.1);
  }

  /* Form Elements */
  .form-group {
    margin-bottom: 1.25rem;
  }

  .form-label {
    display: block;
    font-weight: 600;
    color: var(--dark);
    margin-bottom: 0.5rem;
    font-size: 0.95rem;
  }

  .form-control-modern,
  .form-select-modern {
    width: 100%;
    padding: 0.875rem 1rem;
    border: 2px solid var(--border);
    border-radius: var(--radius-md);
    font-size: 1rem;
    font-weight: 500;
    color: var(--dark);
    background: var(--lighter);
    transition: all 0.3s ease;
  }

  .form-control-modern:focus,
  .form-select-modern:focus {
    outline: none;
    border-color: var(--primary);
    box-shadow: 0 0 0 4px rgba(37, 99, 235, 0.1);
  }

  .form-control-modern::placeholder {
    color: var(--gray);
  }

  /* Action Buttons */
  .btn-modern {
    padding: 0.875rem 2rem;
    border-radius: var(--radius-md);
    font-weight: 600;
    font-size: 1rem;
    border: none;
    cursor: pointer;
    transition: all 0.3s ease;
    display: inline-flex;
    align-items: center;
    justify-content: center;
    gap: 0.75rem;
  }

  .btn-primary-modern {
    background: linear-gradient(135deg, var(--primary), var(--primary-dark));
    color: white;
  }

  .btn-primary-modern:hover {
    transform: translateY(-2px);
    box-shadow: var(--shadow-lg);
    background: linear-gradient(135deg, var(--primary-dark), var(--primary));
  }

  .btn-secondary-modern {
    background: var(--lighter);
    color: var(--primary);
    border: 2px solid var(--primary);
  }

  .btn-secondary-modern:hover {
    background: var(--primary);
    color: white;
    transform: translateY(-2px);
    box-shadow: var(--shadow-md);
  }

  /* Fare Summary */
  .fare-summary-card {
    background: linear-gradient(135deg, var(--lighter) 0%, #f8fafc 100%);
    border-radius: var(--radius-lg);
    padding: 2rem;
    box-shadow: var(--shadow-xl);
    border: 1px solid var(--border);
    position: sticky;
    top: 140px;
  }

  .fare-row {
    display: flex;
    justify-content: space-between;
    align-items: center;
    padding: 0.75rem 0;
    border-bottom: 1px solid var(--border);
  }

  .fare-row:last-child {
    border-bottom: none;
  }

  .fare-label {
    color: var(--gray);
    font-weight: 500;
  }

  .fare-value {
    font-weight: 600;
    color: var(--dark);
  }

  .fare-total {
    background: linear-gradient(135deg, var(--primary-light) 0%, var(--primary) 100%);
    color: white;
    padding: 1rem;
    border-radius: var(--radius-md);
    margin-top: 1rem;
  }

  .fare-total .fare-label {
    color: white;
    opacity: 0.9;
  }

  .fare-total .fare-value {
    color: white;
    font-size: 1.5rem;
    font-weight: 800;
  }

  .security-badge {
    background: rgba(16, 185, 129, 0.1);
    border: 1px solid rgba(16, 185, 129, 0.3);
    color: var(--success);
    padding: 0.75rem 1rem;
    border-radius: var(--radius-md);
    text-align: center;
    margin-top: 1.5rem;
    font-weight: 500;
  }

  /* Payment Options */
  .payment-methods {
    display: grid;
    grid-template-columns: repeat(auto-fit, minmax(150px, 1fr));
    gap: 1rem;
    margin: 1.5rem 0;
  }

  .payment-method {
    background: var(--light);
    border: 2px solid var(--border);
    border-radius: var(--radius-md);
    padding: 1rem;
    text-align: center;
    cursor: pointer;
    transition: all 0.3s ease;
  }

  .payment-method:hover,
  .payment-method.active {
    border-color: var(--primary);
    background: rgba(37, 99, 235, 0.05);
  }

  .payment-icon {
    font-size: 2rem;
    margin-bottom: 0.5rem;
    color: var(--dark);
  }

  /* Responsive Design */
  @media (max-width: 1200px) {
    .booking-container {
      max-width: 100%;
    }
  }

  @media (max-width: 992px) {
    .progress-steps {
      gap: 1rem;
      overflow-x: auto;
      justify-content: flex-start;
      padding-bottom: 0.5rem;
    }

    .step-text {
      display: none;
    }

    .journey-timeline {
      flex-direction: column;
      gap: 2rem;
    }

    .journey-timeline::before {
      display: none;
    }

    .duration-badge {
      position: relative;
      top: auto;
      left: auto;
      transform: none;
      margin: 1rem auto;
    }

    .passenger-grid {
      grid-template-columns: 1fr;
    }
  }

  @media (max-width: 768px) {
    .booking-progress {
      top: 60px;
    }

    .booking-container {
      margin-top: 120px;
      padding: 0 1rem;
    }

    .train-header-card,
    .booking-card,
    .fare-summary-card {
      padding: 1.5rem;
    }

    .station-point {
      min-width: 100%;
    }
  }

  /* Animations */
  @keyframes fadeIn {
    from {
      opacity: 0;
      transform: translateY(10px);
    }

    to {
      opacity: 1;
      transform: translateY(0);
    }
  }

  .fade-in {
    animation: fadeIn 0.3s ease;
  }

  @keyframes pulse {
    0% {
      box-shadow: 0 0 0 0 rgba(37, 99, 235, 0.4);
    }

    70% {
      box-shadow: 0 0 0 10px rgba(37, 99, 235, 0);
    }

    100% {
      box-shadow: 0 0 0 0 rgba(37, 99, 235, 0);
    }
  }

  .pulse {
    animation: pulse 2s infinite;
  }
</style>

<!-- Progress Steps -->
<div class="booking-progress">
  <div class="progress-steps">
    <div class="progress-step">
      <div class="step-icon active">
        <i class="fas fa-user-check"></i>
      </div>
      <span class="step-text active">Passenger Details</span>
    </div>
    <div class="progress-step">
      <div class="step-icon">
        <i class="fas fa-credit-card"></i>
      </div>
      <span class="step-text">Payment</span>
    </div>
    <div class="progress-step">
      <div class="step-icon">
        <i class="fas fa-check-circle"></i>
      </div>
      <span class="step-text">Confirmation</span>
    </div>
  </div>
</div>

<!-- Main Container -->
<div class="booking-container">
  <div class="row">
    <!-- Left Column: Main Content -->
    <div class="col-lg-8">
      <!-- Train Header -->
      <div class="train-header-card fade-in">
        <span class="train-badge pulse">
          <i class="fas fa-bolt me-1"></i> Instant Confirmation
        </span>

        <div class="text-center mb-4">
          <h1 class="display-6 fw-bold mb-2"><?= htmlspecialchars($data['train_name'] ?? 'Train') ?></h1>
          <p class="text-muted mb-0">Train No: <span class="fw-bold"><?= $data['train_number'] ?? 'N/A' ?></span></p>
        </div>

        <!-- Journey Timeline -->
        <div class="journey-timeline">
          <div class="station-point">
            <div class="station-dot"></div>
            <div class="station-name"><?= htmlspecialchars($data['route_start'] ?? 'Departure') ?></div>
            <div class="station-time"><?= date('h:i A', strtotime($data['train_stime'] ?? '00:00')) ?></div>
            <div class="text-muted small">Departure</div>
          </div>

          <div class="duration-badge">
            <i class="fas fa-clock me-2"></i>
            <?php
            if ($data) {
              $start = new DateTime($data['train_stime']);
              $end = new DateTime($data['train_etime']);
              $diff = $start->diff($end);
              echo $diff->h . 'h ' . $diff->i . 'm';
            } else {
              echo 'N/A';
            }
            ?>
          </div>

          <div class="station-point">
            <div class="station-dot"></div>
            <div class="station-name"><?= htmlspecialchars($data['route_end'] ?? 'Arrival') ?></div>
            <div class="station-time"><?= date('h:i A', strtotime($data['train_etime'] ?? '00:00')) ?></div>
            <div class="text-muted small">Arrival</div>
          </div>
        </div>
      </div>

      <!-- Passenger Details Card -->
      <div class="booking-card fade-in" style="animation-delay: 0.1s;">
        <div class="d-flex justify-content-between align-items-center mb-4">
          <h2 class="section-title">👤 Passenger Details</h2>
          <span class="badge bg-primary bg-opacity-10 text-primary px-3 py-2">
            <i class="fas fa-users me-1"></i>
            <span id="passengerCountDisplay">1</span> Passenger(s)
          </span>
        </div>

        <form id="bookingForm" method="POST">
          <div class="passenger-grid" id="passengerList">
            <!-- Passenger 1 (Default) -->
            <div class="passenger-card fade-in">
              <div class="passenger-header">
                <div class="passenger-number">Passenger 1 <span class="text-muted">(Primary)</span></div>
                <button type="button" class="remove-passenger" disabled title="Cannot remove primary passenger">
                  <i class="fas fa-lock"></i>
                </button>
              </div>

              <div class="row g-3">
                <div class="col-md-12">
                  <div class="form-group">
                    <label class="form-label">Full Name *</label>
                    <input type="text" class="form-control-modern" name="name[]" placeholder="Enter full name" required>
                  </div>
                </div>

                <div class="col-md-6">
                  <div class="form-group">
                    <label class="form-label">Age *</label>
                    <input type="number" class="form-control-modern" name="age[]" placeholder="Age" min="1" max="120" required>
                  </div>
                </div>

                <div class="col-md-6">
                  <div class="form-group">
                    <label class="form-label">Gender *</label>
                    <select class="form-select-modern" name="gender[]" required>
                      <option value="" selected disabled>Select Gender</option>
                      <option value="Male">Male</option>
                      <option value="Female">Female</option>
                      <option value="Other">Other</option>
                    </select>
                  </div>
                </div>

                <div class="col-md-12">
                  <div class="form-group">
                    <label class="form-label">Coach Preference *</label>
                    <select class="form-select-modern" name="coach[]" required>
                      <option value="" selected disabled>Select Coach Type</option>
                      <option value="AC">AC Sleeper</option>
                      <option value="Sleeper">Sleeper Class</option>
                      <option value="General">General</option>
                    </select>
                  </div>
                </div>
              </div>
            </div>
          </div>

          <div class="d-grid gap-2 d-md-flex justify-content-md-start mb-4">
            <button type="button" class="btn-modern btn-secondary-modern" id="addPassengerBtn">
              <i class="fas fa-plus"></i> Add Another Passenger
            </button>
          </div>

          <!-- Journey Date -->
          <div class="mb-4">
            <h3 class="section-title">📅 Journey Date</h3>
            <div class="form-group">
              <label class="form-label">Select Date of Journey *</label>
              <input type="date" class="form-control-modern" id="dateJourney" required>
            </div>
          </div>
        </form>
      </div>

      <!-- Payment Methods Card (Collapsible) -->
      <div class="booking-card fade-in" style="animation-delay: 0.2s;">
        <h3 class="section-title">💳 Payment Method</h3>
        <div class="payment-methods">
          <div class="payment-method active" data-method="card">
            <div class="payment-icon">
              <i class="fas fa-credit-card"></i>
            </div>
            <div>Credit/Debit Card</div>
          </div>
          <div class="payment-method" data-method="netbanking">
            <div class="payment-icon">
              <i class="fas fa-university"></i>
            </div>
            <div>Net Banking</div>
          </div>
          <div class="payment-method" data-method="upi">
            <div class="payment-icon">
              <i class="fas fa-mobile-alt"></i>
            </div>
            <div>UPI</div>
          </div>
          <div class="payment-method" data-method="wallet">
            <div class="payment-icon">
              <i class="fas fa-wallet"></i>
            </div>
            <div>Wallet</div>
          </div>
        </div>
      </div>
    </div>

    <!-- Right Column: Fare Summary -->
    <div class="col-lg-4">
      <div class="fare-summary-card fade-in" style="animation-delay: 0.3s;">
        <h3 class="section-title">💰 Fare Summary</h3>

        <div class="mb-4">
          <div class="fare-row">
            <span class="fare-label">Base Fare (x<span id="passengerCount">1</span>)</span>
            <span class="fare-value">₹<span id="baseFare">500</span></span>
          </div>
          <div class="fare-row">
            <span class="fare-label">Service Charge</span>
            <span class="fare-value">₹<span id="serviceCharge">0.00</span></span>
          </div>
          <div class="fare-row">
            <span class="fare-label">GST (5%)</span>
            <span class="fare-value">₹<span id="tax">25.00</span></span>
          </div>
          <div class="fare-row">
            <span class="fare-label">Convenience Fee</span>
            <span class="fare-value">₹0.00</span>
          </div>

          <div class="fare-total">
            <div class="fare-row">
              <span class="fare-label">Total Amount</span>
              <span class="fare-value">₹<span id="netPayable">525.00</span></span>
            </div>
          </div>
        </div>

        <div class="security-badge">
          <i class="fas fa-shield-alt me-2"></i>
          100% Secure Payment • SSL Encrypted
        </div>

        <div class="d-grid mt-4">
          <button type="submit" form="bookingForm" class="btn-modern btn-primary-modern">
            <i class="fas fa-lock me-2"></i>
            Pay Securely ₹<span id="payAmount">525.00</span>
          </button>
        </div>

        <div class="text-center mt-3">
          <small class="text-muted">
            <i class="fas fa-undo-alt me-1"></i>
            Free cancellation within 24 hours
          </small>
        </div>

        <!-- Hidden Fields -->
        <input type="hidden" id="doj" name="doj">
        <input type="hidden" id="totalamt" name="totalamt" value="525.00">
        <input type="hidden" id="taxefee" name="taxefee" value="25.00">
        <input type="hidden" id="train_id" name="train_id" value="<?= $data['train_id'] ?? '' ?>">
        <input type="hidden" id="train_no" name="train_no" value="<?= $data['train_number'] ?? '' ?>">
        <input type="hidden" id="route_id" name="route_id" value="<?= $data['route_id'] ?? '' ?>">
        <input type="hidden" id="passenger_count" name="passenger_count" value="1">
        <input type="hidden" id="payment_method" name="payment_method" value="card">

      </div>
    </div>
  </div>
</div>


<script>
  document.addEventListener('DOMContentLoaded', function() {
    // Initialize date picker
    const dateInput = document.getElementById('dateJourney');
    const today = new Date().toISOString().split('T')[0];
    dateInput.min = today;
    dateInput.value = today;

    // Passenger management
    const passengerList = document.getElementById('passengerList');
    const addPassengerBtn = document.getElementById('addPassengerBtn');
    const baseFare = 500;
    let passengerCounter = 1;

    // Update passenger count display
    function updatePassengerCount() {
      const count = document.querySelectorAll('.passenger-card').length;
      document.getElementById('passengerCount').textContent = count;
      document.getElementById('passengerCountDisplay').textContent = count;
      document.getElementById('passenger_count').value = count;
      updateFare();
    }

    // Add passenger
    addPassengerBtn.addEventListener('click', function() {
      passengerCounter++;
      const newPassenger = document.createElement('div');
      newPassenger.className = 'passenger-card fade-in';
      newPassenger.innerHTML = `
                <div class="passenger-header">
                    <div class="passenger-number">Passenger ${passengerCounter}</div>
                    <button type="button" class="remove-passenger" title="Remove passenger">
                        <i class="fas fa-times"></i>
                    </button>
                </div>
                <div class="row g-3">
                    <div class="col-md-12">
                        <div class="form-group">
                            <label class="form-label">Full Name *</label>
                            <input type="text" class="form-control-modern" name="name[]" placeholder="Enter full name" required>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="form-group">
                            <label class="form-label">Age *</label>
                            <input type="number" class="form-control-modern" name="age[]" placeholder="Age" min="1" max="120" required>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="form-group">
                            <label class="form-label">Gender *</label>
                            <select class="form-select-modern" name="gender[]" required>
                                <option value="" selected disabled>Select Gender</option>
                                <option value="Male">Male</option>
                                <option value="Female">Female</option>
                                <option value="Other">Other</option>
                            </select>
                        </div>
                    </div>
                    <div class="col-md-12">
                        <div class="form-group">
                            <label class="form-label">Coach Preference *</label>
                            <select class="form-select-modern" name="coach[]" required>
                                <option value="" selected disabled>Select Coach Type</option>
                                <option value="AC">AC Sleeper</option>
                                <option value="Sleeper">Sleeper Class</option>
                                <option value="General">General</option>
                            </select>
                        </div>
                    </div>
                </div>
            `;
      passengerList.appendChild(newPassenger);
      updatePassengerCount();
    });

    // Remove passenger
    passengerList.addEventListener('click', function(e) {
      if (e.target.closest('.remove-passenger') && !e.target.closest('.remove-passenger').disabled) {
        const card = e.target.closest('.passenger-card');
        if (document.querySelectorAll('.passenger-card').length > 1) {
          card.remove();
          updatePassengerCount();
        } else {
          alert('At least one passenger is required');
        }
      }
    });

    // Update fare calculation
    function updateFare() {
      const count = document.querySelectorAll('.passenger-card').length;
      const totalBase = count * baseFare;
      const tax = totalBase * 0.05;
      const net = totalBase + tax;

      document.getElementById('baseFare').textContent = totalBase.toFixed(2);
      document.getElementById('tax').textContent = tax.toFixed(2);
      document.getElementById('netPayable').textContent = net.toFixed(2);
      document.getElementById('payAmount').textContent = net.toFixed(2);

      // Update hidden fields
      document.getElementById('totalamt').value = net.toFixed(2);
      document.getElementById('taxefee').value = tax.toFixed(2);
    }

    // Payment method selection
    document.querySelectorAll('.payment-method').forEach(method => {
      method.addEventListener('click', function() {
        document.querySelectorAll('.payment-method').forEach(m => m.classList.remove('active'));
        this.classList.add('active');
        document.getElementById('payment_method').value = this.dataset.method;
      });
    });

    // Form validation
    document.getElementById('bookingForm').addEventListener('submit', function(e) {
      e.preventDefault();

      const dateJourney = document.getElementById('dateJourney').value;
      if (!dateJourney) {
        alert('Please select a journey date');
        dateJourneyInput.focus();
        return false;
      }

      // Validate all passenger fields
      let isValid = true;
      document.querySelectorAll('.passenger-card').forEach((card, index) => {
        const inputs = card.querySelectorAll('input[required], select[required]');
        inputs.forEach(input => {
          if (!input.value.trim()) {
            isValid = false;
            input.classList.add('border-danger');
          } else {
            input.classList.remove('border-danger');
          }
        });
      });

      if (!isValid) {
        alert('Please fill all required passenger details');
        return false;
      }

      // Save date
      document.getElementById('doj').value = dateJourney;

      // Initiate payment
      initiatePayment();
    });

    // Initialize
    updatePassengerCount();
  });
</script>

<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script src="https://checkout.razorpay.com/v1/checkout.js"></script>

<script>
  /* ------------------------------------------
     GET PASSENGER DETAILS (Correct jQuery Loop)
  -------------------------------------------*/
  function getPassengers() {
    let passengers = [];

    $('.passenger-card').each(function() {
      passengers.push({
        name: $(this).find('input[name="name[]"]').val(),
        age: $(this).find('input[name="age[]"]').val(),
        gender: $(this).find('select[name="gender[]"]').val(),
        coach: $(this).find('select[name="coach[]"]').val()
      });
    });

    return passengers;
  }

  /* ------------------------------------------
       RAZORPAY ORDER CREATION
  -------------------------------------------*/
  function initiatePayment() {

    const totalamt = parseFloat($("#netPayable").text());
    const amountInPaise = Math.round(totalamt * 100);

    $.ajax({
      type: 'POST',
      url: 'Booking_Order.php',
      data: {
        amount: amountInPaise
      },
      dataType: 'json',

      success: function(order) {
        const options = {
          key: "rzp_test_Rn5bHsJaNwbCNl",
          amount: order.amount,
          currency: "INR",
          name: "Railway Booking System",
          description: "Train Ticket Booking",
          image: "https://cdn-icons-png.flaticon.com/512/2972/2972543.png",
          order_id: order.id,

          handler: function(response) {
            processPayment(response);
          },

          theme: {
            color: "#2563eb"
          },

          modal: {
            ondismiss: function() {
              alert('Payment cancelled. Please try again.');
            }
          }
        };

        new Razorpay(options).open();
      },

      error: function() {
        alert('Could not initiate payment. Please try again.');
      }
    });
  }

  /* ------------------------------------------
       PAYMENT CONFIRM + SAVE BOOKING
  -------------------------------------------*/
  function processPayment(response) {

    const totalamt = parseFloat($("#netPayable").text());
    const passengers = getPassengers(); // GET PASSENGERS HERE
    // console.log(passengers); 

    $.ajax({
      type: 'POST',
      url: 'Booking_Payment.php',

      data: {
        razorpay_payment_id: response.razorpay_payment_id,
        razorpay_order_id: response.razorpay_order_id,
        razorpay_signature: response.razorpay_signature,

        train_id: $("#train_id").val(),
        train_no: $("#train_no").val(),
        route_id: $("#route_id").val(),
        doj: $("#doj").val(),

        totalamt: ($("#totalamt").val() - $("#taxefee").val()),
        taxefee: $("#taxefee").val(),
        passenger_count: $("#passenger_count").val(),
        amount: totalamt,
        payment_method: $("#payment_method").val(),
        // FULL PASSENGER DETAILS (Name, Age, Gender, Coach)
        passengers: JSON.stringify(passengers)
      },

      success: function() {
        window.location.href = "thank_you_user.php";
      },

      error: function() {
        alert('Payment successful but booking failed. Please contact support.');
      }
    });
  }
</script>