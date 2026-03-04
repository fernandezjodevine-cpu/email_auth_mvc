<?php

require_once __DIR__ . '/../models/User.php';

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

class AuthController {

    public $userModel;

    public function __construct() {
        $this->userModel = new User();
        date_default_timezone_set('Asia/Manila'); // ensure timezone matches DB
    }

    // ================== SEND VERIFICATION EMAIL ==================
    private function sendVerificationEmail($email, $token)
    {
        $mail = new PHPMailer(true);
        try {
            $mail->isSMTP();
            $mail->Host       = 'smtp.gmail.com';
            $mail->SMTPAuth   = true;
            $mail->Username   = 'yna09fernandez@gmail.com';
            $mail->Password   = 'esbtjdtkgjoffnyk'; 
            $mail->SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS;
            $mail->Port       = 587;

            $verificationLink = "http://localhost/email_auth_mvc/index.php?action=verify&token=$token";

            $mail->setFrom('yna09fernandez@gmail.com', 'Email Auth System');
            $mail->addAddress($email);

            $mail->isHTML(true);
            $mail->Subject = 'Verify Your Email';
            $mail->Body    = "
                <h2>Email Verification</h2>
                <p>Click the button below to verify your email:</p>
                <a href='$verificationLink'
                   style='padding:10px 20px;background:#6a5acd;color:white;text-decoration:none;border-radius:5px;'>
                   Verify Email
                </a>
            ";

            $mail->send();
            return true;

        } catch (Exception $e) {
            echo "Mailer Error: " . $mail->ErrorInfo;
            return false;
        }
    }

    // ================== SEND OTP EMAIL ==================
    private function sendOTPEmail($email, $otp)
    {
        $mail = new PHPMailer(true);
        try {
            $mail->isSMTP();
            $mail->Host       = 'smtp.gmail.com';
            $mail->SMTPAuth   = true;
            $mail->Username   = 'yna09fernandez@gmail.com';
            $mail->Password   = 'esbtjdtkgjoffnyk'; 
            $mail->SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS;
            $mail->Port       = 587;

            $mail->setFrom('yna09fernandez@gmail.com', 'Email Auth System');
            $mail->addAddress($email);

            $mail->isHTML(true);
            $mail->Subject = 'Your OTP Code';
            $mail->Body    = "
                <h2>Your OTP Code</h2>
                <h1 style='color:#6a5acd;'>$otp</h1>
                <p>This code expires in 5 minutes.</p>
            ";

            $mail->send();
            return true;

        } catch (Exception $e) {
            echo "Mailer Error: " . $mail->ErrorInfo;
            return false;
        }
    }

    // ================== REGISTER ==================
    public function register() {
    if($_SERVER['REQUEST_METHOD'] === 'POST') {
        $fullname = $_POST['fullname'];
        $email    = $_POST['email'];
        $password = $_POST['password'];

        $userId = $this->userModel->register($fullname, $email, $password);

        if($userId) {
            $token = bin2hex(random_bytes(32));
            $this->userModel->storeToken($userId, $token);

            $this->sendVerificationEmail($email, $token);

            // Instead of echo, render a styled success page
            $message = "Registration successful! Please check your email to verify your account.";
            require __DIR__ . '/../views/message.php'; // create message.php as a styled card page
            exit();
        } else {
            $error = "Registration failed! Email may already exist.";
        }
    }

    require __DIR__ . '/../views/register.php';
}

    // ================== VERIFY EMAIL ==================
    public function verify() {
        if(isset($_GET['token'])) {
            $token = $_GET['token'];
            if($this->userModel->verifyEmail($token)) {
                $message = "Email verified successfully! You can now login.";
            } else {
                $error = "Invalid or expired verification link.";
            }
        } else {
            $error = "No token provided!";
        }

        require __DIR__ . '/../views/verify_email.php';
    }

    // ================== LOGIN ==================
    public function login() {
        if($_SERVER['REQUEST_METHOD'] === 'POST') {
            $email    = $_POST['email'];
            $password = $_POST['password'];

            $userResult = $this->userModel->login($email);
            $user = $userResult ? $userResult->fetch_assoc() : null;

            if(!$user) {
                $error = "Email not found or not verified!";
                require __DIR__ . '/../views/login.php';
                return;
            }

            if(!password_verify($password, $user['password'])) {
                $error = "Incorrect password!";
                require __DIR__ . '/../views/login.php';
                return;
            }

            // Generate OTP
            $otp = rand(100000, 999999);
            $expiry = date('Y-m-d H:i:s', strtotime('+5 minutes'));

            // Save OTP (deletes old OTP automatically)
            $this->userModel->saveOTP($user['id'], $otp, $expiry);

            $_SESSION['user_id'] = $user['id'];
            $_SESSION['fullname'] = $user['fullname'];
            $_SESSION['email'] = $user['email'];

            $this->sendOTPEmail($email, $otp);

            header("Location: index.php?action=otp");
            exit();
        }

        require __DIR__ . '/../views/login.php';
    }

    // ================== OTP ==================
    public function otp() {
        if($_SERVER['REQUEST_METHOD'] === 'POST') {
            $otpInput = trim($_POST['otp']);
            $user_id = $_SESSION['user_id'] ?? null;

            if(!$user_id) {
                header("Location: index.php?action=login");
                exit();
            }

            if($this->userModel->verifyOTP($user_id, $otpInput)) {
                header("Location: index.php?action=home");
                exit();
            } else {
                $error = "Invalid or expired OTP.";
            }
        }

        require __DIR__ . '/../views/otp.php';
    }

    // ================== RESEND OTP ==================
    public function resendOTP() {
        $user_id = $_SESSION['user_id'] ?? null;
        $email = $_SESSION['email'] ?? null;

        if(!$user_id || !$email) {
            header("Location: index.php?action=login");
            exit();
        }

        $otp = rand(100000, 999999);
        $expiry = date('Y-m-d H:i:s', strtotime('+5 minutes'));
        $this->userModel->saveOTP($user_id, $otp, $expiry);
        $this->sendOTPEmail($email, $otp);

        $_SESSION['otp_message'] = "A new OTP has been sent to your email.";
        header("Location: index.php?action=otp");
        exit();
    }

    // ================== HOME ==================
    public function home() {
        if(!isset($_SESSION['user_id'])) {
            header("Location: index.php?action=login");
            exit();
        }
        require __DIR__ . '/../views/home.php';
    }

    // ================== LOGOUT ==================
    public function logout() {
        session_destroy();
        header("Location: index.php?action=login");
        exit();
    }
}