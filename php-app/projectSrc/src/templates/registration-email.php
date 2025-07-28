<html>
<body>
    <h1>Hello, <?= htmlspecialchars($username) ?>!</h1>
    <p>Your verification PIN is: <strong><?= htmlspecialchars($pin) ?></strong></p>

    <?php if ($qrcode): ?>
        <p>Scan the QR code below to continue:</p>
        <img src="<?= htmlspecialchars($qrcode) ?>" alt="QR Code" >
    <?php endif; ?>
</body>
</html>