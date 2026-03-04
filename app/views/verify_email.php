<?php include 'app/views/templates/header.php'; ?>
<div class="card">
<h2>Email Verification</h2>
<?php 
if(isset($message)) echo "<p>$message</p>"; 
if(isset($error)) echo "<p>$error</p>"; 
?>
<p><a href="index.php?action=login">Go to Login</a></p>
</div>
<?php include 'app/views/templates/footer.php'; ?>