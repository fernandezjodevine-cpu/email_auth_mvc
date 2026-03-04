<?php include 'app/views/templates/header.php'; ?>

<div class="card home-box">
    <h2>Welcome!</h2>
    <p>Hello, <strong><?php echo htmlspecialchars($_SESSION['fullname']); ?></strong></p>
    <p>You have successfully logged in.</p>

    <form method="POST" action="index.php?action=logout">
        <button type="submit" class="logout-btn">Logout</button>
    </form>
</div>

<style>
/* Home page styling to match login/register/OTP pages */
.home-box p {
    margin: 15px 0;
    font-size: 16px;
    color: #333;
}

.logout-btn {
    width: 100%;
    padding: 12px;
    background-color: #6a5acd;
    color: #fff;
    border: none;
    border-radius: 8px;
    cursor: pointer;
    font-size: 16px;
    transition: background 0.3s;
    margin-top: 15px;
}

.logout-btn:hover {
    background-color: #5848b0;
}
</style>

<?php include 'app/views/templates/footer.php'; ?>