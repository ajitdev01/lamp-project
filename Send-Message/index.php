
<?php

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;
use PHPMailer\PHPMailer\SMTP;

require 'PHPMailer/src/Exception.php';
require 'PHPMailer/src/PHPMailer.php';
require 'PHPMailer/src/SMTP.php';


if (isset($_POST['send'])) {
    $remail = $_POST['remail'];
    $msubject = $_POST['msubject'];
    $cmessage = $_POST['cmessage'];

    // phpmailer code
    //Create an instance; passing `true` enables exceptions
    $mail = new PHPMailer(true);

    try {
        //Server settings
       // $mail->SMTPDebug = SMTP::DEBUG_SERVER;                      //Enable verbose debug output
        $mail->isSMTP();                                            //Send using SMTP
        $mail->Host       = 'smtp.hostinger.com';                     //Set the SMTP server to send through
        $mail->SMTPAuth   = true;                                   //Enable SMTP authentication
        $mail->Username   = 'Enter Your Email';                     //SMTP username
        $mail->Password   = 'Enter Your Password';                               //SMTP password
        $mail->SMTPSecure = PHPMailer::ENCRYPTION_SMTPS;            //Enable implicit TLS encryption
        $mail->Port       = 465;                                    //TCP port to connect to; use 587 if you have set `SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS`

        //Recipients
        $mail->setFrom('Enter Your Email', 'Rexvel Team');
        $mail->addAddress($remail);     //Add a recipient
      //  $mail->addAddress('ellen@example.com');               //Name is optional
       // $mail->addReplyTo('info@example.com', 'Information');
       // $mail->addCC('cc@example.com');
       // $mail->addBCC('bcc@example.com');

        //Attachments
       // $mail->addAttachment('/var/tmp/file.tar.gz');         //Add attachments
        //$mail->addAttachment('/tmp/image.jpg', 'new.jpg');    //Optional name

        //Content
        $mail->isHTML(true);                                  //Set email format to HTML
        $mail->Subject = $msubject;
        $mail->Body    = $cmessage.'<br><b>Thank You!</b>';
        $mail->AltBody = $cmessage;

        $mail->send();
        $msg = '<div class="alert alert-success">Message has been sent</div>';
    } catch (Exception $e) {
        echo "Message could not be sent. Mailer Error: {$mail->ErrorInfo}";
    }
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>BiMail • compose with clarity</title>
  <!-- Tailwind via CDN + Font Awesome 6 (free) -->
  <script src="https://cdn.tailwindcss.com"></script>
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
  <!-- subtle inter font fallback (tailwind uses system fonts by default, but we keep it crisp) -->
  <style>
    /* tiny extra smoothness for placeholder & focus */
    input, textarea { transition: border-color 0.2s ease, box-shadow 0.2s ease; }
    textarea { min-height: 200px; resize: vertical; }
    /* optional: better card shadow depth */
    .mail-card-hover { transition: transform 0.2s ease, box-shadow 0.2s ease; }
    .mail-card-hover:hover { box-shadow: 0 25px 50px -12px rgba(0,0,0,0.25); }
  </style>
</head>
<body class="bg-slate-100 font-sans antialiased flex items-center justify-center min-h-screen p-5 m-0">

  <!-- main container: centered, soft background, subtle pattern (optional) -->
  <div class="w-full max-w-2xl">
    <!-- glass-morphism like card with generous padding -->
    <div class="bg-white/90 backdrop-blur-sm rounded-2xl shadow-xl p-8 md:p-10 border border-white/20 mail-card-hover">
      
      <!-- header with icon & brand -->
      <div class="flex items-center justify-center gap-3 mb-8">
        <i class="fa-regular fa-envelope text-4xl text-indigo-600"></i>
        <h1 class="text-4xl font-bold text-slate-800 tracking-tight">BiMail</h1>
      </div>

      <!-- dynamic message placeholder (like php $msg) 
           we simulate with a hidden demo, but keep it as a flexible alert slot -->
      <div id="demo-message" class="mb-6 hidden items-center gap-2 bg-emerald-50 text-emerald-700 p-4 rounded-xl border border-emerald-200">
        <i class="fa-regular fa-circle-check text-lg"></i>
        <span class="text-sm font-medium">✓ Your message has been sent .</span>
      </div>
      
      <!-- optional: show a demo hint (since it's static) – can be removed if $msg appears -->
      <div class="mb-5 text-xs text-slate-400 flex justify-end items-center gap-1 border-b border-slate-200/60 pb-2">
        <i class="fa-regular fa-keyboard"></i>
        <span>clean & ready • all fields are demo</span>
      </div>

      <!-- main form – identical structure but with tailwind & icons inside inputs (optional style) -->
      <form action="" method="post" class="space-y-6">
        <!-- recipient field with left icon -->
        <div class="relative">
          <i class="fa-regular fa-user absolute left-4 top-1/2 -translate-y-1/2 text-slate-400 text-lg pointer-events-none"></i>
          <input type="email" name="remail" id="recipientEmail" required
                 class="w-full pl-12 pr-5 py-4 rounded-xl border border-slate-200 bg-slate-50/80 placeholder:text-slate-400 text-slate-700 text-base focus:bg-white focus:ring-4 focus:ring-indigo-200/50 focus:border-indigo-400 outline-none transition"
                 placeholder="Recipient email">
        </div>

        <!-- subject field with left icon -->
        <div class="relative">
          <i class="fa-regular fa-pen-to-square absolute left-4 top-1/2 -translate-y-1/2 text-slate-400 text-lg pointer-events-none"></i>
          <input type="text" name="msubject" id="subject"
                 class="w-full pl-12 pr-5 py-4 rounded-xl border border-slate-200 bg-slate-50/80 placeholder:text-slate-400 text-slate-700 text-base focus:bg-white focus:ring-4 focus:ring-indigo-200/50 focus:border-indigo-400 outline-none transition"
                 placeholder="Subject">
        </div>

        <!-- compose area with larger icon at top-left (align self-start) -->
        <div class="relative">
          <i class="fa-regular fa-message absolute left-4 top-5 text-slate-400 text-lg pointer-events-none"></i>
          <textarea name="cmessage" id="composeBody" rows="7"
                    class="w-full pl-12 pr-5 py-4 rounded-xl border border-slate-200 bg-slate-50/80 placeholder:text-slate-400 text-slate-700 text-base focus:bg-white focus:ring-4 focus:ring-indigo-200/50 focus:border-indigo-400 outline-none transition"
                    placeholder="Compose your email..."></textarea>
        </div>

        <!-- send button with icon & micro-interaction -->
        <div class="pt-2">
          <button type="submit" name="send"
                  class="w-full bg-indigo-600 hover:bg-indigo-700 text-white font-semibold py-4 px-6 rounded-xl shadow-lg shadow-indigo-200/50 hover:shadow-xl hover:shadow-indigo-300/50 flex items-center justify-center gap-3 text-lg transition-all duration-200 group">
            <i class="fa-regular fa-paper-plane group-hover:scale-110 group-hover:-translate-y-0.5 transition-transform duration-200"></i>
            <span>Send Email</span>
          </button>
        </div>

        <!-- subtle note: php integration ready -->
        <input type="hidden" name="demo" value="tailwind+fontawesome">
      </form>

      <!-- extra clean footer (optional) -->
      <div class="mt-8 text-xs text-center text-slate-400 border-t border-slate-100 pt-5 flex items-center justify-center gap-2">
        <i class="fa-regular fa-star"></i>
        <span>BiMail — minimal, modern, ready for backend</span>
        <i class="fa-regular fa-star"></i>
      </div>
    </div>
  </div>

  <!-- tiny script to simulate message display (just for demonstration - you can remove it) 
       if you want to see how $msg would appear, click send (prevents actual submit for demo) -->
  <script>
    (function() {
      const form = document.querySelector('form');
      const msgBox = document.getElementById('demo-message');
      
      form.addEventListener('submit', (e) => {
        e.preventDefault();  // remove this line to allow real POST
        // show simulated feedback (like php flash message)
        if (msgBox) {
          msgBox.classList.remove('hidden');
          msgBox.classList.add('flex');
          // hide after 4 seconds
          setTimeout(() => {
            msgBox.classList.add('hidden');
            msgBox.classList.remove('flex');
          }, 4000);
        }
        // you can optionally reset or keep values
      });
    })();
  </script>
  <!-- optional: remove demo script in production; the design works perfectly with php -->
</body>
</html>