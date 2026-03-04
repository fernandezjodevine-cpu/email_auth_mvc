<!DOCTYPE html>
<html>
<head>
    <title>Message</title>
    <link rel="stylesheet" href="public/styles.css">
</head>
<body>
<div class="container">
    <?php if(isset($message)): ?>
        <div class="message-success"><?php echo $message; ?></div>
    <?php endif; ?>

    <?php if(isset($error)): ?>
        <div class="message-error"><?php echo $error; ?></div>
    <?php endif; ?>
</div>
</body>
</html>