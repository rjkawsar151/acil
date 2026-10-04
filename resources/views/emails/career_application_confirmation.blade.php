<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Application Received — {{ $application->job->title ?? 'Position' }}</title>
</head>
<body style="margin: 0; padding: 0; background-color: #f4f7fb; font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif; color: #334155;">

    <table border="0" cellpadding="0" cellspacing="0" width="100%" style="background-color: #f4f7fb; padding: 30px 15px;">
        <tr>
            <td align="center">
                
                <!-- Main Container -->
                <table border="0" cellpadding="0" cellspacing="0" width="100%" style="max-width: 600px; background-color: #ffffff; border-radius: 16px; overflow: hidden; box-shadow: 0 4px 20px rgba(0,0,0,0.06); border: 1px solid #e2e8f0;">
                    
                    <!-- Header -->
                    <tr>
                        <td style="background: linear-gradient(135deg, #071B33 0%, #0B5ED7 100%); padding: 32px 30px; text-align: left;">
                            <table border="0" cellpadding="0" cellspacing="0" width="100%">
                                <tr>
                                    <td>
                                        <div style="display: inline-block; padding: 6px 12px; background: rgba(0, 183, 217, 0.2); border-radius: 20px; color: #00B7D9; font-size: 11px; font-weight: bold; text-transform: uppercase; letter-spacing: 1.5px; margin-bottom: 8px;">
                                            Career & Recruitment
                                        </div>
                                        <h1 style="margin: 0; color: #ffffff; font-size: 22px; font-weight: 800; letter-spacing: -0.5px;">
                                            Adonis Chemical Industries Ltd.
                                        </h1>
                                        <p style="margin: 4px 0 0 0; color: #93c5fd; font-size: 13px;">
                                            Application Confirmation Notice
                                        </p>
                                    </td>
                                </tr>
                            </table>
                        </td>
                    </tr>

                    <!-- Body Content -->
                    <tr>
                        <td style="padding: 35px 30px 25px 30px;">
                            
                            <p style="font-size: 16px; font-weight: 600; color: #0f172a; margin-top: 0; margin-bottom: 16px;">
                                Dear {{ $application->name }},
                            </p>

                            <p style="font-size: 14px; line-height: 1.6; color: #475569; margin-bottom: 20px;">
                                Thank you for your interest in joining <strong>Adonis Chemical Industries Ltd.</strong> We have successfully received your application for the position of <strong style="color: #0B5ED7;">{{ $application->job->title ?? 'Applied Position' }}</strong>.
                            </p>

                            <!-- Reference Badge Box -->
                            <div style="background-color: #f8fafc; border-left: 4px solid #0B5ED7; padding: 18px 20px; border-radius: 8px; margin-bottom: 24px;">
                                <table border="0" cellpadding="0" cellspacing="0" width="100%" style="font-size: 13px;">
                                    <tr>
                                        <td style="padding: 4px 0; color: #64748b; width: 140px; font-weight: 600;">Reference No:</td>
                                        <td style="padding: 4px 0; color: #0f172a; font-weight: 700; font-family: monospace; font-size: 14px;">{{ $application->reference }}</td>
                                    </tr>
                                    <tr>
                                        <td style="padding: 4px 0; color: #64748b; font-weight: 600;">Position:</td>
                                        <td style="padding: 4px 0; color: #0f172a; font-weight: 600;">{{ $application->job->title ?? 'N/A' }}</td>
                                    </tr>
                                    <tr>
                                        <td style="padding: 4px 0; color: #64748b; font-weight: 600;">Department:</td>
                                        <td style="padding: 4px 0; color: #0f172a;">{{ $application->job->effective_department_name ?? 'N/A' }}</td>
                                    </tr>
                                    <tr>
                                        <td style="padding: 4px 0; color: #64748b; font-weight: 600;">Location:</td>
                                        <td style="padding: 4px 0; color: #0f172a;">{{ $application->job->location ?? 'Genda, Savar, Dhaka' }}</td>
                                    </tr>
                                    <tr>
                                        <td style="padding: 4px 0; color: #64748b; font-weight: 600;">Submitted On:</td>
                                        <td style="padding: 4px 0; color: #0f172a;">{{ $application->applied_at ? $application->applied_at->format('d M Y, h:i A') : date('d M Y') }}</td>
                                    </tr>
                                    <tr>
                                        <td style="padding: 4px 0; color: #64748b; font-weight: 600;">CV Attached:</td>
                                        <td style="padding: 4px 0; color: #0f172a;">{{ $application->cv_original_name }} ({{ $application->formatted_cv_size }})</td>
                                    </tr>
                                </table>
                            </div>

                            <h3 style="font-size: 14px; font-weight: 700; color: #0f172a; margin-top: 24px; margin-bottom: 10px; text-transform: uppercase; letter-spacing: 0.5px;">
                                Next Steps
                            </h3>
                            <p style="font-size: 13px; line-height: 1.6; color: #475569; margin-bottom: 24px;">
                                Our Human Resources & Recruitment panel is currently screening applications. If your profile matches our criteria and requirements, our HR team will reach out to you with details regarding the interview schedule and further evaluation.
                            </p>

                            <div style="border-top: 1px solid #e2e8f0; padding-top: 20px; margin-top: 24px;">
                                <p style="font-size: 13px; color: #475569; margin: 0 0 4px 0;">
                                    Best regards,
                                </p>
                                <p style="font-size: 14px; font-weight: bold; color: #071B33; margin: 0 0 2px 0;">
                                    Human Resources & Talent Acquisition
                                </p>
                                <p style="font-size: 12px; color: #64748b; margin: 0;">
                                    Adonis Chemical Industries Ltd. (A Concern of Adonis Group)
                                </p>
                            </div>

                        </td>
                    </tr>

                    <!-- Footer -->
                    <tr>
                        <td style="background-color: #07182D; padding: 24px 30px; text-align: center; color: #94a3b8; font-size: 12px; line-height: 1.5;">
                            <p style="margin: 0 0 6px 0; color: #cbd5e1; font-weight: 600;">
                                Plant: Genda, Karnapara, Savar, Dhaka-1340, Bangladesh
                            </p>
                            <p style="margin: 0 0 8px 0;">
                                Contact: {{ \App\Models\Setting::get('contact_phone', '+880 1810-000000') }} | Email: {{ \App\Models\Setting::get('contact_email', 'hr@adonischemical.com') }}
                            </p>
                            <p style="margin: 0; font-size: 11px; color: #64748b;">
                                © {{ date('Y') }} Adonis Chemical Industries Ltd. All rights reserved.
                            </p>
                        </td>
                    </tr>

                </table>

            </td>
        </tr>
    </table>

</body>
</html>
