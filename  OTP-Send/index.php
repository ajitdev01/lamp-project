<?php
session_start();
ini_set('display_errors', 1);
error_reporting(E_ALL);

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

require __DIR__ . '/PHPMailer/src/Exception.php';
require __DIR__ . '/PHPMailer/src/PHPMailer.php';
require __DIR__ . '/PHPMailer/src/SMTP.php';

// -------------------------------------------------------
// CONFIG — move these to a .env file or config.php
// and NEVER commit credentials to version control
// -------------------------------------------------------
define('SMTP_HOST',      'smtp.hostinger.com');
define('SMTP_USER',      'Enter Your Eamil'); // enter your email and save .env file better
define('SMTP_PASS',      'Enter Your password');   // enter your pass and save .env file better 
define('SMTP_PORT',      465);
define('MAIL_FROM',      'Enter Your Eamil');
define('MAIL_FROM_NAME', 'Rexvel Team');

// Generate CSRF token once per session
if (empty($_SESSION['csrf_token'])) {
    $_SESSION['csrf_token'] = bin2hex(random_bytes(32));
}

$error = '';

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['send'])) {

    // --- CSRF check ---
    if (
        empty($_POST['csrf_token']) ||
        !hash_equals($_SESSION['csrf_token'], $_POST['csrf_token'])
    ) {
        $error = 'Invalid request. Please refresh the page and try again.';
    } else {

        // --- Sanitize & validate email ---
        $remail = filter_var(trim($_POST['remail'] ?? ''), FILTER_SANITIZE_EMAIL);

        if (!filter_var($remail, FILTER_VALIDATE_EMAIL)) {
            $error = 'Please enter a valid email address.';
        } else {

            // Use cryptographically secure OTP
            $genotp = str_pad(random_int(0, 999999), 6, '0', STR_PAD_LEFT);

            $mail = new PHPMailer(true);

            try {
                $mail->isSMTP();
                $mail->Host       = SMTP_HOST;
                $mail->SMTPAuth   = true;
                $mail->Username   = SMTP_USER;
                $mail->Password   = SMTP_PASS;
                $mail->SMTPSecure = PHPMailer::ENCRYPTION_SMTPS;
                $mail->Port       = SMTP_PORT;

                // ⚠️ REMOVE this block in production — for localhost only
                $mail->SMTPOptions = [
                    'ssl' => [
                        'verify_peer'       => false,
                        'verify_peer_name'  => false,
                        'allow_self_signed' => true,
                    ],
                ];

                $mail->setFrom(MAIL_FROM, MAIL_FROM_NAME);
                $mail->addAddress($remail);
                $mail->isHTML(true);
                $mail->Subject = 'Your Verification Code';
                $mail->Body    = "
                    <div style='font-family:sans-serif;max-width:480px;margin:0 auto;padding:32px;background:#0a0a0a;color:#fff;border-radius:16px;'>
                        <h2 style='margin:0 0 8px;font-size:22px;'>Your verification code</h2>
                        <p style='color:#888;margin:0 0 24px;font-size:14px;'>Use this code to complete sign-in. It expires in 10 minutes.</p>
                        <div style='background:#1a1a1a;border:1px solid #333;border-radius:12px;padding:24px;text-align:center;letter-spacing:12px;font-size:36px;font-weight:700;color:#e8ff57;'>$genotp</div>
                        <p style='color:#555;font-size:12px;margin:24px 0 0;'>If you did not request this, you can safely ignore this email.</p>
                    </div>";
                $mail->AltBody = "Your verification code is: $genotp — It expires in 10 minutes.";

                $mail->send();

             // Store OTP and related data in the session only AFTER the email is successfully sent.
            // This ensures we don't save an OTP that the user never received.

           // Save the generated OTP in the session (temporary storage for verification)
            $_SESSION['otp'] = $genotp;

                  // Save the user's email so we know which email the OTP was sent to
               $_SESSION['email'] = $remail;

             // Set OTP expiration time (current time + 10 minutes)
                 // After this time the OTP will be considered invalid
                 $_SESSION['otp_expires'] = time() + 600;
                header('Location: verify.php');
                exit();

            } catch (Exception $e) {
                // Log real error server-side; show safe message to user
                error_log('PHPMailer Error: ' . $mail->ErrorInfo);
                $error = 'Could not send the code. Please try again later.';
            }
        }
    }
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Verify Your Email — Rexvel</title>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link href="https://fonts.googleapis.com/css2?family=Syne:wght@400;600;700;800&family=DM+Sans:wght@300;400;500&display=swap" rel="stylesheet">
    <style>
        *, *::before, *::after { box-sizing: border-box; margin: 0; padding: 0; }

        :root {
            --bg:        #0a0a0a;
            --surface:   #111111;
            --border:    #222222;
            --accent:    #e8ff57;
            --accent-dim:#b8cc3a;
            --text:      #f0f0f0;
            --muted:     #666666;
            --error-bg:  #1a0a0a;
            --error-bd:  #4a1a1a;
            --error-txt: #ff6b6b;
        }

        html, body {
            min-height: 100vh;
            background: var(--bg);
            display: flex;
            align-items: center;
            justify-content: center;
            font-family: 'DM Sans', sans-serif;
            color: var(--text);
            padding: 24px;
        }

        body::before {
            content: '';
            position: fixed;
            inset: 0;
            background-image:
                linear-gradient(rgba(255,255,255,0.03) 1px, transparent 1px),
                linear-gradient(90deg, rgba(255,255,255,0.03) 1px, transparent 1px);
            background-size: 48px 48px;
            pointer-events: none;
            z-index: 0;
        }

        .card {
            position: relative;
            z-index: 1;
            width: 100%;
            max-width: 420px;
            background: var(--surface);
            border: 1px solid var(--border);
            border-radius: 20px;
            padding: 40px 36px;
            animation: slideUp 0.5s cubic-bezier(0.16,1,0.3,1) both;
        }

        @keyframes slideUp {
            from { opacity: 0; transform: translateY(24px); }
            to   { opacity: 1; transform: translateY(0); }
        }

        .icon-wrap {
            width: 52px;
            height: 52px;
            border-radius: 14px;
            background: rgba(232,255,87,0.1);
            border: 1px solid rgba(232,255,87,0.2);
            display: flex;
            align-items: center;
            justify-content: center;
            margin-bottom: 24px;
        }

        .icon-wrap svg { width: 24px; height: 24px; stroke: var(--accent); }

        h1 {
            font-family: 'Syne', sans-serif;
            font-size: 26px;
            font-weight: 800;
            color: var(--text);
            line-height: 1.1;
            margin-bottom: 8px;
            letter-spacing: -0.5px;
        }

        .subtitle {
            font-size: 14px;
            color: var(--muted);
            margin-bottom: 32px;
            line-height: 1.5;
        }

        .error-box {
            display: flex;
            align-items: flex-start;
            gap: 10px;
            background: var(--error-bg);
            border: 1px solid var(--error-bd);
            border-radius: 10px;
            padding: 12px 14px;
            margin-bottom: 24px;
            font-size: 13px;
            color: var(--error-txt);
            animation: shake 0.3s ease;
        }

        @keyframes shake {
            0%,100% { transform: translateX(0); }
            25%      { transform: translateX(-6px); }
            75%      { transform: translateX(6px); }
        }

        .error-box svg { width: 16px; height: 16px; flex-shrink: 0; margin-top: 1px; stroke: var(--error-txt); }

        .form-group { margin-bottom: 20px; }

        label {
            display: block;
            font-size: 12px;
            font-weight: 500;
            color: var(--muted);
            text-transform: uppercase;
            letter-spacing: 0.08em;
            margin-bottom: 8px;
        }

        input[type="email"] {
            width: 100%;
            padding: 13px 16px;
            background: var(--bg);
            border: 1px solid var(--border);
            border-radius: 10px;
            color: var(--text);
            font-family: 'DM Sans', sans-serif;
            font-size: 15px;
            outline: none;
            transition: border-color 0.2s, box-shadow 0.2s;
        }

        input[type="email"]::placeholder { color: #444; }

        input[type="email"]:focus {
            border-color: var(--accent);
            box-shadow: 0 0 0 3px rgba(232,255,87,0.08);
        }

        .btn {
            width: 100%;
            padding: 14px;
            margin-top: 4px;
            background: var(--accent);
            color: #0a0a0a;
            font-family: 'Syne', sans-serif;
            font-size: 15px;
            font-weight: 700;
            border: none;
            border-radius: 10px;
            cursor: pointer;
            display: flex;
            align-items: center;
            justify-content: center;
            gap: 10px;
            transition: background 0.2s, transform 0.1s, opacity 0.2s;
            letter-spacing: 0.02em;
        }

        .btn:hover  { background: var(--accent-dim); }
        .btn:active { transform: scale(0.98); }
        .btn:disabled { opacity: 0.6; cursor: not-allowed; }

        .spinner {
            display: none;
            width: 18px;
            height: 18px;
            border: 2px solid rgba(0,0,0,0.2);
            border-top-color: #0a0a0a;
            border-radius: 50%;
            animation: spin 0.7s linear infinite;
        }

        @keyframes spin { to { transform: rotate(360deg); } }

        .footer {
            margin-top: 28px;
            text-align: center;
            font-size: 12px;
            color: #333;
        }

        .footer strong { color: #555; }
    </style>
</head>
<body>

<div class="card">
    <div class="icon-wrap">
        <svg fill="none" viewBox="0 0 24 24" stroke-width="1.8" stroke="currentColor">
            <path stroke-linecap="round" stroke-linejoin="round" d="M21.75 6.75v10.5a2.25 2.25 0 01-2.25 2.25h-15a2.25 2.25 0 01-2.25-2.25V6.75m19.5 0A2.25 2.25 0 0019.5 4.5h-15a2.25 2.25 0 00-2.25 2.25m19.5 0v.243a2.25 2.25 0 01-1.07 1.916l-7.5 4.615a2.25 2.25 0 01-2.36 0L3.32 8.91a2.25 2.25 0 01-1.07-1.916V6.75" />
        </svg>
    </div>

    <h1>Verify your email</h1>
    <p class="subtitle">Enter your email address and we'll send you a 6-digit verification code.</p>

    <?php if ($error): ?>
        <div class="error-box">
            <svg fill="none" viewBox="0 0 24 24" stroke-width="2">
                <path stroke-linecap="round" stroke-linejoin="round" d="M12 9v3.75m-9.303 3.376c-.866 1.5.217 3.374 1.948 3.374h14.71c1.73 0 2.813-1.874 1.948-3.374L13.949 3.378c-.866-1.5-3.032-1.5-3.898 0L2.697 16.126zM12 15.75h.007v.008H12v-.008z" />
            </svg>
            <span><?php echo htmlspecialchars($error); ?></span>
        </div>
    <?php endif; ?>

    <form method="post" id="otpForm">
        <input type="hidden" name="csrf_token" value="<?php echo htmlspecialchars($_SESSION['csrf_token']); ?>">

        <div class="form-group">
            <label for="remail">Email Address</label>
            <input
                type="email"
                id="remail"
                name="remail"
                placeholder="you@example.com"
                required
                autocomplete="email"
                value="<?php echo htmlspecialchars($_POST['remail'] ?? ''); ?>"
            >
        </div>

        <button type="submit" name="send" class="btn" id="submitBtn">
            <span id="btnText">Send Code</span>
            <div class="spinner" id="spinner"></div>
        </button>
    </form>

    <p class="footer">Secured by <strong>Rexvel Team</strong></p>
</div>

<script>
    const form    = document.getElementById('otpForm');
    const btn     = document.getElementById('submitBtn');
    const spinner = document.getElementById('spinner');
    const btnText = document.getElementById('btnText');

    form.addEventListener('submit', function () {
        // Delay disable so browser includes name="send" in POST data
        setTimeout(() => { btn.disabled = true; }, 100);
        spinner.style.display = 'block';
        btnText.textContent = 'Sending…';
    });
</script>

</body>
</html>