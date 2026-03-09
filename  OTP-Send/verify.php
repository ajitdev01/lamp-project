<?php
session_start();

// Basic security: if no email in session, send them back to start
if (!isset($_SESSION['email'])) {
    header("Location: index.php");
    exit();
}

$msg = "";
if (isset($_POST['verify'])) {
    $user_otp = $_POST['uotp'];
    
    if ($user_otp == $_SESSION['otp']) {
        $msg = "<span class='text-green-600'>✅ Success! Email verified.</span>";
    $_SESSION["verified"] = true;
    header("Location: dashboard.php");
    exit();
    } else {
        $msg = "❌ Invalid OTP code. Please try again.";
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Verify OTP | BiMail</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="bg-slate-50 flex items-center justify-center min-h-screen p-4">

    <div class="w-full max-w-md bg-white rounded-3xl shadow-2xl p-8 border border-slate-100">
        <div class="text-center mb-10">
            <div class="inline-flex items-center justify-center w-20 h-20 bg-indigo-100 text-indigo-600 rounded-2xl rotate-3 mb-6">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-10 w-10" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m5.618-4.016A11.955 11.955 0 0112 2.944a11.955 11.955 0 01-8.618 3.04A12.02 12.02 0 003 9c0 5.591 3.824 10.29 9 11.622 5.176-1.332 9-6.03 9-11.622 0-1.042-.133-2.052-.382-3.016z" />
                </svg>
            </div>
            <h1 class="text-3xl font-extrabold text-slate-900 tracking-tight">Enter Code</h1>
            <p class="text-slate-500 mt-3 text-balance leading-relaxed">
                We sent a 6-digit code to <br>
                <span class="font-semibold text-slate-900"><?php echo htmlspecialchars($_SESSION['email']); ?></span>
            </p>
        </div>

        <?php if(!empty($msg)): ?>
            <div class="mb-6 p-4 bg-red-50 border-l-4 border-red-500 text-red-700 text-sm rounded-r-lg animate-pulse">
                <?php echo $msg; ?>
            </div>
        <?php endif; ?>

        <form action="" method="post" id="otp-form">
            <input type="hidden" name="uotp" id="final_otp">

            <div class="flex justify-between gap-2 mb-8" id="otp-inputs">
                <?php for($i=0; $i<6; $i++): ?>
                <input type="text" maxlength="1" 
                    class="otp-field w-12 h-14 text-center text-2xl font-bold bg-slate-50 border-2 border-slate-200 rounded-xl focus:border-indigo-500 focus:ring-4 focus:ring-indigo-100 transition-all outline-none" 
                    pattern="\d*" inputmode="numeric" required>
                <?php endfor; ?>
            </div>

            <button type="submit" name="verify" class="w-full bg-slate-900 hover:bg-black text-white font-bold py-4 rounded-2xl transition-all shadow-xl active:scale-[0.98]">
                Verify & Continue
            </button>
        </form>

        <div class="mt-8 text-center">
            <p class="text-sm text-slate-500">
                Didn't get the code? 
                <span id="timer-container">
                    Wait <span id="timer" class="font-bold text-indigo-600">30</span>s
                </span>
                <a href="index.php" id="resend-link" class="hidden text-indigo-600 font-semibold hover:underline decoration-2 underline-offset-4">Resend Code</a>
            </p>
        </div>
    </div>

    <script>
        const inputs = document.querySelectorAll('.otp-field');
        const finalInput = document.getElementById('final_otp');
        const form = document.getElementById('otp-form');

        // 1. Handle Input Logic (Auto-focus & Backspace)
        inputs.forEach((input, index) => {
            input.addEventListener('input', (e) => {
                if (e.target.value.length > 1) e.target.value = e.target.value.slice(0, 1);
                if (e.target.value !== "" && index < inputs.length - 1) inputs[index + 1].focus();
                updateFinalValue();
            });

            input.addEventListener('keydown', (e) => {
                if (e.key === "Backspace" && e.target.value === "" && index > 0) inputs[index - 1].focus();
            });
            
            // Allow pasting a 6-digit code
            input.addEventListener('paste', (e) => {
                const data = e.clipboardData.getData('text').slice(0, 6);
                if (/^\d+$/.test(data)) {
                    data.split('').forEach((char, i) => {
                        if (inputs[i]) inputs[i].value = char;
                    });
                    updateFinalValue();
                }
            });
        });

        function updateFinalValue() {
            let otp = "";
            inputs.forEach(input => otp += input.value);
            finalInput.value = otp;
        }

        // 2. Resend Timer Logic
        let timeLeft = 30;
        const timerEl = document.getElementById('timer');
        const timerContainer = document.getElementById('timer-container');
        const resendLink = document.getElementById('resend-link');

        const countdown = setInterval(() => {
            timeLeft--;
            timerEl.innerText = timeLeft;
            if (timeLeft <= 0) {
                clearInterval(countdown);
                timerContainer.classList.add('hidden');
                resendLink.classList.remove('hidden');
            }
        }, 1000);
    </script>
</body>
</html>