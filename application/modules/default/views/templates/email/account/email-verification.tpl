Hello, {$user->getProfile('first_name')}.

Thanks for your registration at {translate name="Champs"}.

Please click the below link to activate your account.
<a href="http://podot.icoderdev.com/account/confirm/?action=email&id={$user->id}&key={$user->getProfile('activate_account_key')}">
    http://podot.icoderdev.com/account/confirm/?action=email&id={$user->id}&key={$user->getProfile('activate_account_key')}
</a>

&copy; {translate name="Champs"} 2012.