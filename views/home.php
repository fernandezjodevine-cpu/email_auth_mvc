<?php include 'views/templates/header.php'; ?>

<div class="card home-box">
    
    <h2>Welcome!</h2>
    <p>Hello, <strong><?php echo htmlspecialchars($_SESSION['fullname']); ?></strong></p>
    <p>You have successfully logged in.</p>

    <form method="POST" action="index.php?action=logout">
        <button type="submit" class="logout-btn">Logout</button>
    </form>
</div>

<?php include 'views/templates/footer.php'; ?>