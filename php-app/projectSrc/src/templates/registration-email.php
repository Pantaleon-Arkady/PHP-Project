<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <title>Registration Email</title>
</head>
<body style="margin: 0; padding: 0; font-family: Arial, sans-serif; background-color: #f9f9f9;">

    <table width="100%" cellpadding="0" cellspacing="0" style="background-color: #f9f9f9; padding: 20px;">
        <tr>
            <td align="center">
                <table width="100%" style="max-width: 600px; background-color: #ffffff; padding: 30px; border-radius: 8px; box-shadow: 0 0 5px rgba(0,0,0,0.1);">
                    <tr>
                        <td align="center" style="padding-bottom: 20px;">
                            <h1 style="margin: 0; color: #333;">Welcome, <?= htmlspecialchars($username) ?>!</h1>
                        </td>
                    </tr>
                    <tr>
                        <td style="font-size: 16px; color: #555;">
                            <p>Thank you for registering. To verify your account, use the PIN below:</p>
                            <p style="font-size: 24px; font-weight: bold; color: #000;"><?= htmlspecialchars($pin) ?></p>
                        </td>
                    </tr>

                    <?php if ($qrcode): ?>
                    <tr>
                        <td align="center" style="padding-top: 20px;">
                            <p style="font-size: 16px; color: #555;">Or scan this QR code:</p>
                            <img src="<?= htmlspecialchars($qrcode) ?>" alt="QR Code" style="max-width: 180px; height: auto; display: block; margin: 10px auto; border: 1px solid #ccc; padding: 8px; border-radius: 4px;">
                        </td>
                    </tr>
                    <?php endif; ?>

                    <tr>
                        <td style="padding-top: 30px; font-size: 12px; color: #999; text-align: center;">
                            <p>This message was sent from our registration system. If you did not initiate this request, please ignore this email.</p>
                        </td>
                    </tr>
                </table>
            </td>
        </tr>
    </table>

</body>
</html>
