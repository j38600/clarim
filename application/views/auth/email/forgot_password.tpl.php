<html>
<body>
    <h1><?php echo sprintf(lang('email_forgot_password_heading'), $identity);?></h1>
    <p><?php echo sprintf(lang('email_forgot_password_subheading'), anchor('auth/resetPassword/'. $forgotten_password_code, lang('email_forgot_password_link')));?></p>
</body>
</html>