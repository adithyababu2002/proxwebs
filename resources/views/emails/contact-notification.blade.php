<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>New contact request</title>
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
                            <p style="margin:0 0 8px;color:#ff695f;font-size:13px;font-weight:700;letter-spacing:0.08em;text-transform:uppercase;">New enquiry</p>
                            <h1 style="margin:0 0 16px;font-size:26px;line-height:1.3;color:#2a2a2a;">New contact form submission</h1>
                            <p style="margin:0 0 22px;font-size:15px;line-height:1.8;color:#7a7a7a;">
                                A visitor submitted the contact form on {{ $siteName }}. Details are below.
                            </p>

                            <table role="presentation" width="100%" cellspacing="0" cellpadding="0" style="border-collapse:collapse;">
                                <tr>
                                    <td style="padding:12px 0;border-bottom:1px solid #eef3f7;width:140px;font-size:13px;font-weight:700;color:#2a2a2a;vertical-align:top;">Name</td>
                                    <td style="padding:12px 0;border-bottom:1px solid #eef3f7;font-size:15px;color:#7a7a7a;vertical-align:top;">{{ $submission->name }}</td>
                                </tr>
                                <tr>
                                    <td style="padding:12px 0;border-bottom:1px solid #eef3f7;font-size:13px;font-weight:700;color:#2a2a2a;vertical-align:top;">Email</td>
                                    <td style="padding:12px 0;border-bottom:1px solid #eef3f7;font-size:15px;color:#7a7a7a;vertical-align:top;">
                                        <a href="mailto:{{ $submission->email }}" style="color:#03a4ed;text-decoration:none;">{{ $submission->email }}</a>
                                    </td>
                                </tr>
                                <tr>
                                    <td style="padding:12px 0;border-bottom:1px solid #eef3f7;font-size:13px;font-weight:700;color:#2a2a2a;vertical-align:top;">Phone</td>
                                    <td style="padding:12px 0;border-bottom:1px solid #eef3f7;font-size:15px;color:#7a7a7a;vertical-align:top;">
                                        {{ $submission->phone ?: '—' }}
                                    </td>
                                </tr>
                                <tr>
                                    <td style="padding:12px 0;border-bottom:1px solid #eef3f7;font-size:13px;font-weight:700;color:#2a2a2a;vertical-align:top;">Source</td>
                                    <td style="padding:12px 0;border-bottom:1px solid #eef3f7;font-size:15px;color:#7a7a7a;vertical-align:top;">{{ $submission->source }}</td>
                                </tr>
                                <tr>
                                    <td style="padding:12px 0;font-size:13px;font-weight:700;color:#2a2a2a;vertical-align:top;">Description</td>
                                    <td style="padding:12px 0;font-size:15px;line-height:1.8;color:#7a7a7a;vertical-align:top;white-space:pre-wrap;">{{ $submission->description }}</td>
                                </tr>
                            </table>

                            <div style="margin-top:28px;">
                                <a href="mailto:{{ $submission->email }}" style="display:inline-block;background:#03a4ed;color:#ffffff;text-decoration:none;padding:12px 24px;border-radius:23px;font-size:15px;font-weight:500;">
                                    Reply to customer
                                </a>
                            </div>
                        </td>
                    </tr>
                    <tr>
                        <td style="padding:28px 32px 32px;border-top:1px solid #eef3f7;">
                            <p style="margin:0;font-size:13px;line-height:1.7;color:#9aa3ab;text-align:center;">
                                Submitted {{ $submission->created_at?->format('d M Y, h:i A') }} · {{ $siteName }}
                            </p>
                        </td>
                    </tr>
                </table>
            </td>
        </tr>
    </table>
</body>
</html>
