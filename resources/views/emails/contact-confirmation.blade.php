<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Message received</title>
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
                            <p style="margin:0 0 8px;color:#03a4ed;font-size:13px;font-weight:700;letter-spacing:0.08em;text-transform:uppercase;">Message sent</p>
                            <h1 style="margin:0 0 16px;font-size:26px;line-height:1.3;color:#2a2a2a;">Thanks, {{ $submission->name }}!</h1>
                            <p style="margin:0 0 18px;font-size:15px;line-height:1.8;color:#7a7a7a;">
                                We received your message and our team will get back to you soon — usually within one business day.
                            </p>
                            <table role="presentation" width="100%" cellspacing="0" cellpadding="0" style="background:#f8fbfd;border-radius:16px;margin:24px 0;">
                                <tr>
                                    <td style="padding:22px 20px;">
                                        <p style="margin:0 0 10px;font-size:13px;font-weight:700;color:#2a2a2a;text-transform:uppercase;letter-spacing:0.04em;">Your message</p>
                                        <p style="margin:0;font-size:15px;line-height:1.8;color:#7a7a7a;white-space:pre-wrap;">{{ $submission->description }}</p>
                                    </td>
                                </tr>
                            </table>
                            <p style="margin:0 0 24px;font-size:15px;line-height:1.8;color:#7a7a7a;">
                                If you need to add anything, just reply to this email or contact us again through the website.
                            </p>
                            <a href="{{ $siteUrl }}" style="display:inline-block;background:#ff695f;color:#ffffff;text-decoration:none;padding:12px 24px;border-radius:23px;font-size:15px;font-weight:500;">
                                Visit Proxwebs
                            </a>
                        </td>
                    </tr>
                    <tr>
                        <td style="padding:28px 32px 32px;border-top:1px solid #eef3f7;">
                            <p style="margin:0;font-size:13px;line-height:1.7;color:#9aa3ab;text-align:center;">
                                © {{ date('Y') }} {{ $siteName }}. Beyond tomorrow.<br>
                                This is an automated confirmation of your contact request.
                            </p>
                        </td>
                    </tr>
                </table>
            </td>
        </tr>
    </table>
</body>
</html>
