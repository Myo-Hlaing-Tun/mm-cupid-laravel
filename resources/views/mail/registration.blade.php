<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>{{ $mailData['company_name'] }}Account Activation</title>
    <style>
        .button {
            background-color: #dc3545;
            color: #ffffff !important;
            font-weight: bold;
            font-size: 1rem;
            padding: 8px 0;
            width: 90%;
            border: none;
            cursor: pointer !important;
            text-align: center;
            display: inline-block;
            text-decoration: none;
            border-radius: 5px;
        }

        .button:hover {
            background-color: #ffffff;
            color:#dc3545  !important;  /* Optional hover effect */
        }
        @media(min-width: 768px) {
            #container {
                width: 40% !important;
            }
        }
    </style>
</head>

<body>
    <div id="container" style="margin:0 auto; width: 80%;">
        <div style="margin: 20px;">
            <div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 16px;">
                <div style="margin-right: 20px;">
                    <h3 style="font-size: 1.25rem;">Please verify your email</h3>
                </div>
                <div style="padding-top: 12px;">
                    <img style="border-radius: 50%; box-shadow: 0 0 10px rgba(0, 0, 0, 0.1); width: 40px; height: 40px;"
                        src="https://t3.ftcdn.net/jpg/01/03/47/46/360_F_103474653_V0uJ6bx4r62TYIg7oZYPZo57FR0rCmkY.jpg" alt="">
                </div>
            </div>
            <div style="margin: 20px 0;">
                <div style="font-size: 0.9rem;">Please take a second to make sure we've got your email right.</div>
                <div style="text-align: center; margin: 35px 0;">
                    <a href="{{ url('/confirm-email?code=' . $mailData['email_confirm_code']) }}" class="button" target="_blank">
                        Confirm your email
                    </a>
                </div>
                <div style="font-size: 0.9rem;">Didn't sign up for <span
                        style="color: #dc3545; font-weight: bold;">{{ $mailData['company_name'] }}</span> ?<span
                        style="color: #0d6efd;"> Let us know.</span></div>
            </div>
            <div style="margin-top: 40px; background-color: #f8f9fa; padding: 16px;">
                <div style="display: flex; align-items: center; margin-bottom: 12px;">
                    <div style="margin-right: 12px; padding-top: 3px;">
                        <img style="border-radius: 50%; box-shadow: 0 0 10px rgba(0, 0, 0, 0.1); width: 40px; height: 40px;"
                            src="https://t3.ftcdn.net/jpg/01/03/47/46/360_F_103474653_V0uJ6bx4r62TYIg7oZYPZo57FR0rCmkY.jpg" alt="">
                    </div>
                    <div>
                        <h3 style="color: #dc3545; font-weight: bold;">{{ $mailData['company_name'] }}</h3>
                    </div>
                </div>
                <div style="font-size: 11px;">
                    <a href="" style="color: #6c757d; text-decoration: none;">Help Center</a> .
                    <a href="" style="color: #6c757d; text-decoration: none;">Privacy Policy</a> .
                    <a href="" style="color: #6c757d; text-decoration: none;">Terms & Conditions</a>
                    <a href="" style="color: #6c757d; text-decoration: none; display: block;">Unsubscribe {{ $mailData['email'] }} from this email</a>
                </div>
            </div>
        </div>
    </div>
</body>

</html>