<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Subscribed</title>
</head>
<body style="margin:0;padding:0;background:#f4fbff;font-family:Poppins,Arial,Helvetica,sans-serif;color:#2a2a2a;">
    <table role="presentation" width="100%" cellspacing="0" cellpadding="0" style="background:#f4fbff;padding:32px 12px;">
        <tr>
            <td align="center">
                <table role="presentation" width="600" cellspacing="0" cellpadding="0" style="max-width:600px;width:100%;background:#ffffff;border-radius:20px;overflow:hidden;box-shadow:0 0 15px rgba(0,0,0,0.06);">
                    <tr>
                        <td style="background:#000000;padding:24px 32px;text-align:center;">
                            <img src="{{ $message->embed($logoPath) }}" alt="{{ $siteName }}" style="max-width:280px;width:100%;height:auto;display:inline-block;">
                        </td>
                    </tr>
                    <tr>
                        <td style="padding:36px 32px 12px;">
                            <p style="margin:0 0 8px;color:#03a4ed;font-size:13px;font-weight:700;letter-spacing:0.08em;text-transform:uppercase;">Newsletter</p>
                            <h1 style="margin:0 0 16px;font-size:26px;line-height:1.3;color:#2a2a2a;">You're on the list!</h1>
                            <p style="margin:0 0 18px;font-size:15px;line-height:1.8;color:#7a7a7a;">
                                Thanks for subscribing with <strong style="color:#2a2a2a;">{{ $subscriber->email }}</strong>.
                                We'll share our latest news, ideas, and product updates with you.
                            </p>
                            <a href="{{ $siteUrl }}" style="display:inline-block;background:#ff695f;color:#ffffff;text-decoration:none;padding:12px 24px;border-radius:23px;font-size:15px;font-weight:500;margin-bottom:24px;">
                                Visit Proxwebs
                            </a>
                        </td>
                    </tr>
                </table>
            </td>
        </tr>
    </table>
</body>
</html>
