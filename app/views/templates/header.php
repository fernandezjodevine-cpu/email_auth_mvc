<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>Email Auth System</title>
<style>
    /* Full screen flex container */
    body {
        font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
        background-color: #f0f2f5;
        display: flex;
        justify-content: center;
        align-items: center;
        min-height: 100vh; /* full height */
        margin: 0;
    }

    /* Card container */
    .card {
        background-color: #ffffff;
        padding: 40px 30px;
        border-radius: 12px;
        box-shadow: 0 8px 24px rgba(0,0,0,0.15);
        width: 100%;
        max-width: 360px; /* limit max width */
        text-align: center;
    }

    /* Card title */
    .card h2 {
        margin-bottom: 25px;
        font-size: 24px;
        color: #333;
    }

    /* Inputs */
    input {
        width: 100%;
        padding: 12px 15px;
        margin: 10px 0;
        border: 1px solid #ccc;
        border-radius: 8px;
        font-size: 14px;
        box-sizing: border-box;
    }

    input:focus {
        border-color: #6a5acd;
        outline: none;
        box-shadow: 0 0 5px rgba(106,90,205,0.3);
    }

    /* Button */
    button {
        width: 100%;
        padding: 12px;
        background-color: #6a5acd;
        color: white;
        border: none;
        border-radius: 8px;
        cursor: pointer;
        font-size: 16px;
        margin-top: 10px;
    }

    button:hover {
        background-color: #5848b0;
    }

    .message {
        margin: 10px 0;
        color: red;
        font-size: 14px;
    }

    a {
        color: #6a5acd;
        text-decoration: none;
    }

    a:hover {
        text-decoration: underline;
    }

    p {
        font-size: 14px;
        margin-top: 15px;
    }
</style>
</head>
<body>