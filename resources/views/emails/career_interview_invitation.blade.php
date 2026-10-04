<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>{{ $emailSubject }}</title>
</head>
<body style="margin: 0; padding: 0; background-color: #f4f7fb; font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif; color: #334155;">

    <table border="0" cellpadding="0" cellspacing="0" width="100%" style="background-color: #f4f7fb; padding: 30px 15px;">
        <tr>
            <td align="center">
                
                <!-- Main Container -->
                <table border="0" cellpadding="0" cellspacing="0" width="100%" style="max-width: 620px; background-color: #ffffff; border-radius: 16px; overflow: hidden; box-shadow: 0 4px 20px rgba(0,0,0,0.06); border: 1px solid #e2e8f0;">
                    
                    <!-- Header -->
                    <tr>
                        <td style="background: linear-gradient(135deg, #071B33 0%, #168CFF 100%); padding: 32px 30px; text-align: left;">
                            <div style="display: inline-block; padding: 6px 12px; background: rgba(255, 255, 255, 0.2); border-radius: 20px; color: #ffffff; font-size: 11px; font-weight: bold; text-transform: uppercase; letter-spacing: 1.5px; margin-bottom: 8px;">
                                Interview Invitation
                            </div>
                            <h1 style="margin: 0; color: #ffffff; font-size: 22px; font-weight: 800; letter-spacing: -0.5px;">
                                Adonis Chemical Industries Ltd.
                            </h1>
                            <p style="margin: 4px 0 0 0; color: #dbeafe; font-size: 13px;">
                                Candidate Recruitment Desk — Reference: {{ $application->reference }}
                            </p>
                        </td>
                    </tr>

                    <!-- Body Content -->
                    <tr>
                        <td style="padding: 35px 30px 25px 30px;">
                            
                            <!-- Custom Rendered Message Body -->
                            <div style="font-size: 14px; line-height: 1.7; color: #334155; margin-bottom: 24px;">
                                {!! nl2br(e($emailBody)) !!}
                            </div>

                            @if(!empty($interviewDate) || !empty($interviewTime) || !empty($interviewLocation))
                                <!-- Highlighted Interview Schedule Card -->
                                <div style="background: linear-gradient(135deg, #f0fdf4 0%, #e0f2fe 100%); border: 1px solid #bae6fd; padding: 20px; border-radius: 12px; margin-bottom: 24px;">
                                    <h4 style="margin: 0 0 12px 0; color: #0369a1; font-size: 14px; font-weight: 800; text-transform: uppercase; letter-spacing: 0.5px;">
                                        🗓️ Interview Schedule Summary
                                    </h4>
                                    <table border="0" cellpadding="0" cellspacing="0" width="100%" style="font-size: 13px;">
                                        @if(!empty($interviewDate))
                                            <tr>
                                                <td style="padding: 4px 0; color: #475569; width: 120px; font-weight: 600;">Date:</td>
                                                <td style="padding: 4px 0; color: #0f172a; font-weight: 700;">{{ $interviewDate }}</td>
                                            </tr>
                                        @endif
                                        @if(!empty($interviewTime))
                                            <tr>
                                                <td style="padding: 4px 0; color: #475569; font-weight: 600;">Time:</td>
                                                <td style="padding: 4px 0; color: #0f172a; font-weight: 700;">{{ $interviewTime }}</td>
                                            </tr>
                                        @endif
                                        @if(!empty($interviewLocation))
                                            <tr>
                                                <td style="padding: 4px 0; color: #475569; font-weight: 600;">Location / Link:</td>
                                                <td style="padding: 4px 0; color: #0f172a; font-weight: 600;">{{ $interviewLocation }}</td>
                                            </tr>
                                        @endif
                                        <tr>
                                            <td style="padding: 4px 0; color: #475569; font-weight: 600;">Position:</td>
                                            <td style="padding: 4px 0; color: #0f172a; font-weight: 600;">{{ $application->job->title ?? 'N/A' }}</td>
                                        </tr>
                                    </table>
                                </div>
                            @endif

                            <div style="border-top: 1px solid #e2e8f0; padding-top: 20px; margin-top: 24px;">
                                <p style="font-size: 13px; color: #475569; margin: 0 0 4px 0;">
                                    Sincerely,
                                </p>
                                <p style="font-size: 14px; font-weight: bold; color: #071B33; margin: 0 0 2px 0;">
                                    Human Resources & Recruitment Committee
                                </p>
                                <p style="font-size: 12px; color: #64748b; margin: 0;">
                                    Adonis Chemical Industries Ltd. | A Concern of Adonis Group
                                </p>
                            </div>

                        </td>
                    </tr>

                    <!-- Footer -->
                    <tr>
                        <td style="background-color: #07182D; padding: 24px 30px; text-align: center; color: #94a3b8; font-size: 12px; line-height: 1.5;">
                            <p style="margin: 0 0 6px 0; color: #cbd5e1; font-weight: 600;">
                                Adonis Chemical Industries Ltd. — Savar Plant
                            </p>
                            <p style="margin: 0 0 8px 0;">
                                Genda, Karnapara, Savar, Dhaka-1340, Bangladesh
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
