<?php
require '/var/www/house-778/vendor/autoload.php';
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

if (isset($_POST['helpInput'])) {
    $helpMessage = $_POST['helpInput'];
    if (isset($_POST['helpUser'])) {
        $helpUser = $_POST['helpUser'];
    }
} else {
    echo 'No help input received.';
    exit;
}


$mail = new PHPMailer(true);

try {
    $mail->isSMTP();
    $mail->SMTPDebug = 0;
    $mail->Host = 'smtp.gmail.com';
    $mail->SMTPAuth = true;
    $mail->Username = 'coworange9@gmail.com';
    $mail->Password = getenv('GMAIL_APP_PASS');
    $mail->SMTPSecure = PHPMailer::ENCRYPTION_SMTPS;
    $mail->Port = 465;

    $mail->setFrom('coworange9@gmail.com', 'House-778');
    $mail->addAddress('coworange9@gmail.com');
    
    $mail->isHTML(true);
    $mail->Subject = 'Help request';

    $mail->Body = <<<EOT
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Email Template</title>
</head>
<body style="font-family: Arial, sans-serif; background-color: #f4f4f4; margin: 0; padding: 0;">
    <div style="text-align: center; width: 100%; max-width: 600px; margin: 30px auto; border-radius: 10px; background-color: #ffffff; padding: 20px; box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);">
        <div style="padding: 20px; line-height: 1.6; color: #333333;">
            <h1 style="font-size: 24px; margin-bottom: 20px;">Help request</h1>
            <p style="font-size: 16px; margin-bottom: 20px;">Dear Me</p>
            <p style="font-size: 16px; margin-bottom: 20px;">{$helpMessage}</p>
            <p style="font-size: 16px; margin-bottom: 20px;">{$helpUser}</p>
            <p style="font-size: 16px; margin-bottom: 20px;">Best regards,</p>
            <p style="font-size: 16px; margin-bottom: 20px;">The Bluffball Team</p>
            <p style="font-size: 12px; margin-top: 20px; color: #777777;">This is an automated email. Please do not reply.</p>
        </div>
    </div>
</body>
</html>
EOT;

    $mail->AltBody = 'Help request';
    $mail->send();
    $mail->clearAddresses(); 
    

    echo 'Messages have been sent';
} catch (Exception $e) {
    echo "Messages could not be sent. Mailer Error: {$mail->ErrorInfo}";
}
?>
