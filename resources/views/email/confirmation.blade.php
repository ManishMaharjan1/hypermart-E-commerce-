<html>
    <head>
        <title>Confirm Email</title>
    </head>
    <body>
        <table>
            <tr><td>Dear,{{ $name }}</td></tr>
            <tr><td>&nbsp;</td></tr>
            <tr><td>Please click on below link to activate your account:<br>
            Your account information is as below with new password:</td></tr>
            <tr><td>&nbsp;</td></tr>
            <tr><td><a href="{{ url('confirm/' .$code) }}">Confirm Account</a></td></tr>
            <tr><td>&nbsp;</td></tr>
            <tr><td>Thanks & Regards,</td></tr>
            <tr><td>Hypermart online shopping Website</td></tr>
        </table>
    </body>
</html>