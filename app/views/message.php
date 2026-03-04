<!DOCTYPE html>
<html>
<head>
    <title>Message</title>
    <style>
        body {
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            background-color: #f0f2f5;
            margin: 0;
            padding: 0;
            display: flex;
            justify-content: center;
            align-items: center;
            min-height: 100vh;
        }

        .container {
            max-width: 400px;
            padding: 30px;
            background-color: #fff;
            border-radius: 12px;
            box-shadow: 0 8px 24px rgba(0,0,0,0.15);
            text-align: center;
        }

        h3 {
            color: #333;
            margin-bottom: 20px;
        }

        .message-success {
            color: #1a7f1a;
            margin-bottom: 20px;
        }

        .message-error {
            color: #d93025;
            margin-bottom: 20px;
        }

        a.button {
            display: inline-block;
            padding: 12px 20px;
            background-color: #6a5acd;
            color: #fff;
            text-decoration: none;
            border-radius: 8px;
            transition: background 0.3s;
        }

        a.button:hover {
            background-color: #5848b0;
        }
    </style>
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