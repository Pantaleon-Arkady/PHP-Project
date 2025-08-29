<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <title>Order Invoice</title>
</head>
<body style="margin: 0; padding: 0; font-family: Arial, sans-serif; background-color: #f9f9f9;">

    <table width="100%" cellpadding="0" cellspacing="0" style="background-color: #f9f9f9; padding: 20px;">
        <tr>
            <td align="center">
                <table width="100%" style="max-width: 600px; background-color: #ffffff; padding: 30px; border-radius: 8px; box-shadow: 0 0 5px rgba(0,0,0,0.1);">
                    
                    <!-- Greeting -->
                    <tr>
                        <td align="center" style="padding-bottom: 20px;">
                            <h1 style="margin: 0; color: #333;">Hi, <?= htmlspecialchars($username) ?>!</h1>
                        </td>
                    </tr>

                    <!-- Intro -->
                    <tr>
                        <td style="font-size: 16px; color: #555;">
                            <p>Thank you for trusting our service for your online shopping! Here are your order details:</p>
                        </td>
                    </tr>

                    <!-- Order items -->
                    <tr>
                        <td>
                            <table width="100%" cellpadding="8" cellspacing="0" style="border-collapse: collapse; margin-top: 10px;">
                                <thead>
                                    <tr style="background-color: #f2f2f2; text-align: left;">
                                        <th style="border-bottom: 1px solid #ddd;">Product</th>
                                        <th style="border-bottom: 1px solid #ddd;">Price</th>
                                        <th style="border-bottom: 1px solid #ddd;">Quantity</th>
                                        <th style="border-bottom: 1px solid #ddd;">Total</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php $grandTotal = 0; ?>
                                    <?php foreach ($orderData as $item): ?>
                                        <tr>
                                            <td style="border-bottom: 1px solid #eee;"><?= htmlspecialchars($item['name']) ?></td>
                                            <td style="border-bottom: 1px solid #eee;">$<?= number_format($item['price'], 2) ?></td>
                                            <td style="border-bottom: 1px solid #eee;"><?= (int)$item['quantity'] ?></td>
                                            <td style="border-bottom: 1px solid #eee;">$<?= number_format($item['totalPrice'], 2) ?></td>
                                        </tr>
                                        <?php $grandTotal += $item['totalPrice']; ?>
                                    <?php endforeach; ?>
                                </tbody>
                                <tfoot>
                                    <tr>
                                        <td colspan="3" align="right" style="padding-top: 10px; font-weight: bold;">Grand Total:</td>
                                        <td style="padding-top: 10px; font-weight: bold;">$<?= number_format($grandTotal, 2) ?></td>
                                    </tr>
                                </tfoot>
                            </table>
                        </td>
                    </tr>

                    <!-- Footer -->
                    <tr>
                        <td style="padding-top: 30px; font-size: 12px; color: #999; text-align: center;">
                            <p>This message was sent from our shop operating system. If you did not initiate this action, please <a href="#">appeal here</a>.</p>
                        </td>
                    </tr>

                </table>
            </td>
        </tr>
    </table>

</body>
</html>
