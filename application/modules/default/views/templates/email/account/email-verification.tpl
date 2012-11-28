Hello, {$user->getProfile('first_name')}.<br /><br/>

Thanks for your registration at {translate name="Champs"}.<br/><br/>

Please click the below link to activate your account.<br/>
<a href="http://podot.icoderdev.com/account/confirm/?action=email&id={$user->id}&key={$user->getProfile('activate_account_key')}">
    http://podot.icoderdev.com/account/confirm/?action=email&id={$user->id}&key={$user->getProfile('activate_account_key')}
</a>
<br/><br/>
&copy; {translate name="Champs"} 2012.