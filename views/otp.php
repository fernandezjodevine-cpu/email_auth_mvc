<?php include 'views/templates/header.php'; ?>

<div class="card">
    <h2>Enter OTP</h2>

    <!-- Display error -->
    <?php if (isset($error)): ?>
        <div class="message error"><?php echo $error; ?></div>
    <?php endif; ?>

    <!-- Display success message (like after resending) -->
    <?php if (isset($_SESSION['otp_message'])): ?>
        <div class="message success"><?php echo $_SESSION['otp_message']; unset($_SESSION['otp_message']); ?></div>
    <?php endif; ?>

    <!-- OTP form -->
    <form method="POST" action="index.php?action=otp">
        <input type="text" name="otp" placeholder="Enter 6-digit OTP" required maxlength="6" pattern="\d{6}">
        <button type="submit">Verify OTP</button>
    </form>

    <!-- Resend OTP -->
    <form method="POST" action="index.php?action=resendOTP" style="margin-top: 10px;">
        <button type="submit">Resend OTP</button>
    </form>

    <!-- Countdown Timer -->
    <p id="timer" style="margin-top: 10px; color:#555;">OTP expires in: <span id="countdown">05:00</span></p>
</div>

<script>
// 5-minute countdown
let timeLeft = 300; // seconds (5 min)
const countdownEl = document.getElementById('countdown');

const timer = setInterval(() => {
    let minutes = Math.floor(timeLeft / 60);
    let seconds = timeLeft % 60;
    countdownEl.textContent = `${minutes.toString().padStart(2,'0')}:${seconds.toString().padStart(2,'0')}`;
    timeLeft--;

    if (timeLeft < 0) {
        clearInterval(timer);
        countdownEl.textContent = "Expired! Click Resend OTP.";
    }
}, 1000);
</script>


<?php include 'views/templates/footer.php'; ?>