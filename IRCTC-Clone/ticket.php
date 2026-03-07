<?php
session_start();

// Login check
if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit;
}

include "includes/header.php";
include "./config/config.php";

// Validate booking_tbl parameter
if (empty($_GET['booking_tbl'])) {
    echo "<p>Error: booking_tbl parameter is missing.</p>";
    exit;
}

$ref = mysqli_real_escape_string($conn, $_GET['booking_tbl']);

// Fetch booking + route + train details
$sql = "SELECT t.*, r.*, b.*
        FROM bookings_tbl AS b
        JOIN routes_tbl AS r ON b.route_id = r.route_id
        JOIN trains_tbl AS t ON b.train_id = t.train_id
        WHERE b.booking_tbl = '$ref'
        LIMIT 1";

$result = mysqli_query($conn, $sql);

// Validate result
if (!$result || mysqli_num_rows($result) === 0) {
    echo "<p>No booking found for Booking ID: $ref</p>";
    exit;
}

$data = mysqli_fetch_assoc($result);

// Decode passengers safely
$passengers = json_decode($data['passengers_info'] ?? '[]', true);

// Format date and time
$doj = date("d M Y, D", strtotime($data['doj']));
$booking_date = date("d M Y, h:i A", strtotime($data['created_at']));
$departure_time = date("h:i A", strtotime($data['train_stime']));
$arrival_time = date("h:i A", strtotime($data['train_etime']));

// Calculate journey duration
if (!empty($data['train_stime']) && !empty($data['train_etime'])) {
    $start = strtotime($data['train_stime']);
    $end = strtotime($data['train_etime']);
    if ($end < $start) $end += 86400; // Add a day if arrival is next day
    $hours = floor(($end - $start) / 3600);
    $minutes = floor((($end - $start) % 3600) / 60);
    $duration = $hours . "h " . $minutes . "m";
} else {
    $duration = "N/A";
}

// Calculate fare breakdown
$base_fare = $data['base_fare'] ?? 0;
$tax_fee = $data['tax_fee'] ?? 0;
$total_amt = $data['total_amt'] ?? 0;
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <style>
        /* Print Specific Styles */
        @media print {

            /* Hide unnecessary elements */
            body * {
                visibility: hidden;
            }

            /* Show only ticket container */
            .ticket-container,
            .ticket-container * {
                visibility: visible;
            }

            /* Position ticket for print */
            .ticket-container {
                position: absolute;
                left: 0;
                top: 0;
                width: 100%;
                max-width: 100%;
                margin: 0;
                padding: 0;
                border: 2px solid #000;
                box-shadow: none;
                background: white;
                -webkit-print-color-adjust: exact;
                print-color-adjust: exact;
            }

            /* Hide non-printable elements */
            .no-print,
            .no-print * {
                display: none !important;
            }

            /* Better typography for print */
            body {
                font-size: 11pt !important;
                line-height: 1.2 !important;
                background: white !important;
                color: black !important;
            }

            /* Ensure tables don't break across pages */
            table {
                page-break-inside: avoid !important;
            }

            .ticket-section {
                page-break-inside: avoid !important;
            }

            /* Optimize spacing */
            .ticket-section {
                padding: 8px 15px !important;
                margin: 0 !important;
            }

            /* Make watermark visible */
            .watermark {
                display: block !important;
                opacity: 0.08 !important;
                z-index: 9999;
            }
        }

        /* Screen Styles */
        @media screen {
            .ticket-container {
                max-width: 850px;
                margin: 30px auto;
                border: 2px solid #333;
                border-radius: 10px;
                background: white;
                position: relative;
                overflow: hidden;
                box-shadow: 0 10px 30px rgba(0, 0, 0, 0.1);
            }

            body {
                background: linear-gradient(135deg, #f5f7fa 0%, #c3cfe2 100%);
                min-height: 100vh;
                padding-bottom: 50px;
            }
        }

        /* Common Ticket Styles */
        .railway-header {
            background: linear-gradient(90deg, #FF671F 0%, #FFFFFF 33%, #FFFFFF 66%, #046A38 100%);
            color: #000;
            padding: 12px 25px;
            position: relative;
            border-bottom: 3px solid #000;
        }

        .railway-header h4 {
            color: #000;
            font-weight: 800;
            margin: 0;
            letter-spacing: 0.5px;
        }

        .header-strip {
            background: #1a1a1a;
            color: white;
            padding: 10px 25px;
            font-size: 13px;
            display: flex;
            justify-content: space-between;
            align-items: center;
            border-bottom: 2px solid #333;
        }

        .irctc-logo {
            width: 55px;
            height: auto;
            position: absolute;
            right: 25px;
            top: 12px;
            filter: drop-shadow(1px 1px 2px rgba(0, 0, 0, 0.3));
        }

        .ticket-section {
            border-bottom: 2px dashed #ccc;
            padding: 15px 25px;
            position: relative;
            background: white;
        }

        .ticket-section:last-child {
            border-bottom: none;
        }

        .train-number {
            background: #046A38;
            color: white;
            padding: 4px 12px;
            border-radius: 5px;
            font-weight: bold;
            font-size: 14px;
            display: inline-block;
            margin-right: 10px;
        }

        .status-badge {
            background: linear-gradient(135deg, #28a745, #20c997);
            color: white;
            padding: 5px 15px;
            border-radius: 20px;
            font-size: 12px;
            font-weight: bold;
            box-shadow: 0 2px 5px rgba(0, 0, 0, 0.2);
        }

        .station-box {
            border: 2px solid #e0e0e0;
            border-radius: 6px;
            padding: 12px;
            margin: 8px 0;
            background: #f9f9f9;
        }

        .from-station {
            border-left: 4px solid #28a745;
        }

        .to-station {
            border-left: 4px solid #dc3545;
        }

        .passenger-table {
            font-size: 12px;
        }

        .passenger-table th {
            background: #2c3e50;
            color: white;
            font-weight: 600;
            border: 1px solid #34495e;
            padding: 8px 10px;
        }

        .passenger-table td {
            padding: 8px 10px;
            vertical-align: middle;
            border: 1px solid #dee2e6;
        }

        .fare-table {
            background: linear-gradient(135deg, #f8f9fa 0%, #e9ecef 100%);
            border-radius: 8px;
            border: 1px solid #dee2e6;
        }

        .watermark {
            position: fixed;
            top: 50%;
            left: 50%;
            transform: translate(-50%, -50%) rotate(-45deg);
            font-size: 90px;
            color: rgba(0, 0, 0, 0.05);
            pointer-events: none;
            font-weight: 900;
            white-space: nowrap;
            z-index: -1;
            letter-spacing: 5px;
        }

        .journey-timeline {
            display: flex;
            align-items: center;
            justify-content: space-between;
            margin: 15px 0;
            padding: 15px;
            background: linear-gradient(135deg, #f8f9fa 0%, #e9ecef 100%);
            border-radius: 8px;
            border: 1px solid #dee2e6;
        }

        .timeline-point {
            width: 16px;
            height: 16px;
            border-radius: 50%;
            position: relative;
            border: 3px solid white;
            box-shadow: 0 0 0 2px;
        }

        .start-point {
            background: #28a745;
            box-shadow: 0 0 0 2px #28a745;
        }

        .end-point {
            background: #dc3545;
            box-shadow: 0 0 0 2px #dc3545;
        }

        .timeline-line {
            flex: 1;
            height: 3px;
            background: linear-gradient(90deg, #28a745, #dc3545);
            margin: 0 20px;
            position: relative;
        }

        .duration-badge {
            background: #6c757d;
            color: white;
            padding: 3px 10px;
            border-radius: 15px;
            font-size: 11px;
            font-weight: bold;
            position: absolute;
            top: -10px;
            left: 50%;
            transform: translateX(-50%);
        }

        .journey-station {
            text-align: center;
            min-width: 150px;
        }

        .journey-time {
            font-size: 11px;
            color: #666;
            margin-top: 3px;
        }

        .section-title {
            background: #2c3e50;
            color: white;
            padding: 8px 15px;
            border-radius: 5px;
            font-size: 14px;
            font-weight: 600;
            margin: -15px -25px 15px -25px;
        }

        .instruction-icon {
            width: 20px;
            text-align: center;
            margin-right: 8px;
        }

        .barcode-placeholder {
            width: 150px;
            height: 60px;
            background: #f8f9fa;
            border: 1px dashed #ccc;
            display: flex;
            align-items: center;
            justify-content: center;
            color: #666;
            font-size: 10px;
            margin: 10px auto;
        }

        .print-optimize {
            /* Additional styles for print optimization */
        }
    </style>
</head>

<body>
    <div class="ticket-container">
        <!-- Watermark (Only shows in print) -->
        <div class="watermark print-optimize">IRCTC E-TICKET</div>

        <!-- Header -->
        <div class="railway-header">
            <h4>
                <span style="color: #0978ffff">INDIAN</span>
                <span style="color: #b701ffff"> RAILWAYS</span>
                <span style="color: #00f780ff"> E-TICKET</span>
            </h4>
            <small style="color: #000; font-weight: 500">Electronic Reservation Slip (ERS)</small>
            <img src="https://upload.wikimedia.org/wikipedia/en/thumb/8/83/Indian_Railways.svg/1200px-Indian_Railways.svg.png"
                class="irctc-logo" alt="IRCTC Logo" onerror="this.style.display='none'">
        </div>

        <!-- PNR and Status Strip -->
        <div class="header-strip">
            <div>
                <strong>PNR:</strong> <?= htmlspecialchars($data['pnr_no'] ?? 'N/A') ?>
                &nbsp;&nbsp;|&nbsp;&nbsp;
                <strong>Booking ID:</strong> <?= htmlspecialchars($ref) ?>
                &nbsp;&nbsp;|&nbsp;&nbsp;
                <strong>Class:</strong> <?= isset($passengers[0]['coach']) ? strtoupper($passengers[0]['coach']) : 'GENERAL' ?>
            </div>
            <div>
                <span class="status-badge">CONFIRMED - <?= date('d M Y') ?></span>
            </div>
        </div>

        <!-- Train Details -->
        <div class="ticket-section">
            <div class="section-title">Train & Journey Details</div>

            <div class="row align-items-center">
                <div class="col-md-5">
                    <p class="mb-1"><strong>Train Number & Name</strong></p>
                    <h5 class="mb-3">
                        <span class="train-number"><?= htmlspecialchars($data['train_no'] ?? 'N/A') ?></span>
                        <span style="font-weight: 600"><?= htmlspecialchars($data['train_name'] ?? 'N/A') ?></span>
                    </h5>

                    <div class="row">
                        <div class="col-6">
                            <p class="mb-1"><strong>Date of Journey</strong></p>
                            <p class="text-muted mb-2"><?= $doj ?></p>
                        </div>
                        <div class="col-6">
                            <p class="mb-1"><strong>Quota</strong></p>
                            <p class="text-muted mb-2">GENERAL</p>
                        </div>
                    </div>
                </div>

                <div class="col-md-7">
                    <div class="journey-timeline">
                        <div class="journey-station">
                            <div class="timeline-point start-point"></div>
                            <p class="mb-0 mt-2"><strong><?= htmlspecialchars($data['route_start'] ?? 'N/A') ?></strong></p>
                            <p class="journey-time">Dep: <?= $departure_time ?></p>
                        </div>

                        <div class="timeline-line">
                            <span class="duration-badge"><?= $duration ?></span>
                        </div>

                        <div class="journey-station">
                            <div class="timeline-point end-point"></div>
                            <p class="mb-0 mt-2"><strong><?= htmlspecialchars($data['route_end'] ?? 'N/A') ?></strong></p>
                            <p class="journey-time">Arr: <?= $arrival_time ?></p>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Passenger Details -->
        <div class="ticket-section">
            <div class="section-title">Passenger Details</div>

            <div class="table-responsive print-optimize">
                <table class="table table-bordered passenger-table mb-0">
                    <thead>
                        <tr>
                            <th width="5%">S.No</th>
                            <th width="25%">Passenger Name</th>
                            <th width="15%">Gender/Age</th>
                            <th width="15%">Coach No</th>
                            <th width="15%">Seat/Berth</th>
                            <th width="25%">Status</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach ($passengers as $index => $p): ?>
                            <tr>
                                <td><strong><?= $index + 1 ?></strong></td>
                                <td><strong><?= htmlspecialchars($p['name'] ?? 'N/A') ?></strong></td>
                                <td><?= htmlspecialchars($p['gender'] ?? '') ?>/<?= htmlspecialchars($p['age'] ?? '') ?></td>
                                <td><?= isset($p['coach']) ? strtoupper($p['coach']) : '--' ?></td>
                                <td><?= isset($p['seat']) ? $p['seat'] : '--' ?></td>
                                <td>
                                    <span class="badge bg-success" style="font-size: 11px">CONFIRMED</span>
                                    <small class="text-muted d-block">CNF/GN</small>
                                </td>
                            </tr>
                        <?php endforeach; ?>
                    </tbody>
                </table>
            </div>

            <!-- Barcode Placeholder for Print -->
            <div class="barcode-placeholder print-optimize" style="display: none;">
                <!-- In production, generate actual barcode here -->
                <span>BARCODE: <?= $data['pnr_no'] ?? $ref ?></span>
            </div>
        </div>

        <!-- Fare and Payment Details -->
        <div class="ticket-section">
            <div class="row">
                <div class="col-md-8">
                    <div class="section-title">Fare Details</div>
                    <div class="fare-table p-3">
                        <table class="table table-sm table-borderless mb-0">
                            <tr>
                                <td>Base Fare (<?= count($passengers) ?> Passengers)</td>
                                <td class="text-end">₹ <?= number_format($base_fare, 2) ?></td>
                            </tr>
                            <tr>
                                <td>Reservation Charges</td>
                                <td class="text-end">₹ <?= number_format($tax_fee * 0.6, 2) ?></td>
                            </tr>
                            <tr>
                                <td>Superfast Charges</td>
                                <td class="text-end">₹ <?= number_format($tax_fee * 0.2, 2) ?></td>
                            </tr>
                            <tr>
                                <td>GST & Other Taxes</td>
                                <td class="text-end">₹ <?= number_format($tax_fee * 0.2, 2) ?></td>
                            </tr>
                            <tr style="border-top: 2px solid #ccc">
                                <td><strong>Total Amount Paid</strong></td>
                                <td class="text-end"><strong>₹ <?= number_format($total_amt, 2) ?></strong></td>
                            </tr>
                            <tr class="text-muted">
                                <td colspan="2" style="font-size: 10px; padding-top: 5px;">
                                    *Inclusive of all applicable taxes and charges
                                </td>
                            </tr>
                        </table>
                    </div>
                </div>

                <div class="col-md-4">
                    <div class="section-title">Transaction Details</div>
                    <div class="p-3">
                        <p class="mb-2">
                            <strong>Payment ID:</strong><br>
                            <small><?= htmlspecialchars($data['payment_id'] ?? 'N/A') ?></small>
                        </p>
                        <p class="mb-2">
                            <strong>Payment Mode:</strong><br>
                            <?= htmlspecialchars($data['payment_ref'] ?? 'N/A') ?>
                        </p>
                        <p class="mb-2">
                            <strong>Booking Date:</strong><br>
                            <?= $booking_date ?>
                        </p>
                        <p class="mb-0">
                            <strong>Chart Status:</strong><br>
                            <span class="badge bg-info">PREPARED</span>
                        </p>
                    </div>
                </div>
            </div>
        </div>

        <!-- Important Instructions -->
        <div class="ticket-section" style="border-bottom: none">
            <div class="section-title">Important Instructions</div>

            <div class="row">
                <div class="col-md-6">
                    <div class="d-flex align-items-start mb-2">
                        <div class="instruction-icon text-success">✓</div>
                        <div>
                            <small><strong>Carry original ID proof</strong> used during booking</small>
                        </div>
                    </div>
                    <div class="d-flex align-items-start mb-2">
                        <div class="instruction-icon text-success">✓</div>
                        <div>
                            <small><strong>Reach station 30 minutes</strong> before departure</small>
                        </div>
                    </div>
                    <div class="d-flex align-items-start mb-2">
                        <div class="instruction-icon text-success">✓</div>
                        <div>
                            <small><strong>E-ticket is valid</strong> for travel without printout</small>
                        </div>
                    </div>
                    <div class="d-flex align-items-start">
                        <div class="instruction-icon text-success">✓</div>
                        <div>
                            <small><strong>SMS/WhatsApp copy</strong> accepted for travel</small>
                        </div>
                    </div>
                </div>

                <div class="col-md-6">
                    <div class="d-flex align-items-start mb-2">
                        <div class="instruction-icon text-danger">✗</div>
                        <div>
                            <small><strong>Tickets are non-transferable</strong> to other persons</small>
                        </div>
                    </div>
                    <div class="d-flex align-items-start mb-2">
                        <div class="instruction-icon text-danger">✗</div>
                        <div>
                            <small><strong>Cancellation charges</strong> apply as per railway rules</small>
                        </div>
                    </div>
                    <div class="d-flex align-items-start mb-2">
                        <div class="instruction-icon text-danger">✗</div>
                        <div>
                            <small><strong>Smoking in trains</strong> is strictly prohibited</small>
                        </div>
                    </div>
                    <div class="d-flex align-items-start">
                        <div class="instruction-icon text-danger">✗</div>
                        <div>
                            <small><strong>Follow all safety</strong> and COVID-19 guidelines</small>
                        </div>
                    </div>
                </div>
            </div>

            <div class="alert alert-info mt-3 mb-0 p-2" style="font-size: 11px">
                <i class="fas fa-info-circle"></i>
                <strong>For assistance:</strong> IRCTC Helpdesk: 139 (Toll Free) | Website: www.irctc.co.in |
                <span class="text-danger">Emergency Contact: 182</span>
            </div>
        </div>

        <!-- Footer Strip -->
        <div class="bg-dark text-white p-2 text-center" style="border-top: 2px solid #333">
            <small style="letter-spacing: 1px">
                <strong>E-TICKET VALID FOR TRAVEL | THIS IS A COMPUTER GENERATED TICKET AND REQUIRES NO SIGNATURE</strong>
            </small>
        </div>
    </div>

    <!-- Action Buttons (Hidden during print) -->
    <div class="container text-center mt-4 mb-5 no-print">
        <div class="btn-group" role="group">
            <button onclick="window.print()" class="btn btn-primary btn-lg me-2">
                <i class="fas fa-print me-2"></i> Print Ticket
            </button>

            <button class="btn btn-success btn-lg me-2" onclick="downloadPDF()">
                <i class="fas fa-file-pdf me-2"></i> Download PDF
            </button>

            <button class="btn btn-info btn-lg" onclick="shareTicket()">
                <i class="fas fa-share-alt me-2"></i> Share
            </button>
        </div>

        <div class="mt-3">
            <small class="text-muted">
                <i class="fas fa-lightbulb me-1"></i>
                Tip: For best print results, use A4 paper in portrait orientation
            </small>
        </div>
    </div>

    <script>
        // Print optimization
        window.onbeforeprint = function() {
            // Show barcode in print
            document.querySelector('.barcode-placeholder').style.display = 'flex';

            // Add print-specific classes
            document.querySelector('.ticket-container').classList.add('print-mode');
        };

        window.onafterprint = function() {
            // Hide barcode after print
            document.querySelector('.barcode-placeholder').style.display = 'none';

            // Remove print classes
            document.querySelector('.ticket-container').classList.remove('print-mode');
        };

        function downloadPDF() {
            // In production, implement with libraries like jsPDF or server-side TCPDF
            alert("PDF download would be available in production. Currently, please use Print → Save as PDF.");

            // Alternative: Open print dialog for PDF save
            // window.print();
        }

        function shareTicket() {
            if (navigator.share) {
                navigator.share({
                    title: 'IRCTC E-Ticket: <?= $data['pnr_no'] ?>',
                    text: 'My train ticket for <?= $data['train_name'] ?> on <?= $doj ?>',
                    url: window.location.href
                });
            } else {
                alert("Copy this URL to share: " + window.location.href);
            }
        }

        // Auto-adjust for print
        document.addEventListener('DOMContentLoaded', function() {
            // Add print-specific styles dynamically
            const printStyles = `
        @media print {
            .ticket-container {
                transform: scale(0.95);
                transform-origin: top center;
            }
            .passenger-table {
                font-size: 10px !important;
            }
        }
    `;

            const styleSheet = document.createElement("style");
            styleSheet.type = "text/css";
            styleSheet.innerText = printStyles;
            document.head.appendChild(styleSheet);
        });
    </script>

    <?php include "./includes/footer.php"; ?>