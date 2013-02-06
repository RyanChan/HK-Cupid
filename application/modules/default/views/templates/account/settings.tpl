<style>
    .form {
        max-width: 700px;
        padding: 19px 29px 29px;
        margin: 0 auto 20px;
        background-color: #fff;
        border: 1px solid #e5e5e5;
        -webkit-border-radius: 5px;
        -moz-border-radius: 5px;
        border-radius: 5px;
        -webkit-box-shadow: 0 1px 2px rgba(0,0,0,.05);
        -moz-box-shadow: 0 1px 2px rgba(0,0,0,.05);
        box-shadow: 0 1px 2px rgba(0,0,0,.05);
    }
    .form .form-heading,
    .form .checkbox {
        margin-bottom: 10px;
    }
    .form input[type="text"],
    .form input[type="password"] {
        font-size: 16px;
        height: auto;
        width:310px;
        margin-bottom: 15px;
        padding: 7px 9px;
    }
</style>
<div class="container">
    <div class="row-fluid">
        <div class="span6">
            <form class="form" action="{geturl action="general"}" method="POST" id="form-general">
                {if $form_general_errors|count > 0}
                    <div class="alert alert-error">
                        <button type="button" class="close" data-dismiss="alert">&times;</button>
                        <h4>{translate name="Error"}</h4>
                        {foreach from=$form_general_errors item=error}
                            {$error|escape}
                        {/foreach}
                    </div>
                {/if}

                {formhash hash=$hash}
                <fieldset>
                    <legend>{translate name="General"}</legend>
                    <label for="first_name">{translate name="First Name"}</label>
                    <input type="text" name="first_name" value="{$user->getProfile("first_name")|escape}" />
                    <label for="last_name">{translate name="Last Name"}</label>
                    <input type="text" name="last_name" value="{$user->getProfile("last_name")|escape}" />
                    <label for="email">{translate name="Email Address"}</label>
                    <input type="text" name="email" value="{$user->getProfile('email')|escape}" disabled/>
                </fieldset>
                <hr />
                <fieldset>
                    <label for="current_password">{translate name="Current Password"}</label>
                    <input type="password" name="current_password" id="current_password" />
                    <label for="new_password">{translate name="New Password"}</label>
                    <input type="password" name="new_password" id="new_password" />
                    <label for="retype_password">{translate name="Re-type New"}</label>
                    <input type="password" name="retype_password" id="retype_password" />
                </fieldset>
                <hr />
                <fieldset>
                    <label for="locale">{translate name="Language"}</label>
                    {locale default=$user->getProfile('locale')}
                </fieldset>
                <div class="form-actions">
                    <button type="submit" class="btn btn-primary pull-right">{translate name="Update"}</button>
                </div>
            </form>
        </div>
        <div class="span6">
            <form class="form" action="{geturl action="profile"}" method="POST" id="form-profile">
                {if $form_profile_errors|count > 0}
                    <div class="alert alert-error">
                        <button type="button" class="close" data-dismiss="alert">&times;</button>
                        <h4>{translate name="Error"}</h4>
                        {foreach from=$form_profile_errors item=error}
                            {$error|escape}
                        {/foreach}
                    </div>
                {/if}

                {formhash hash=$hash}
                <fieldset>
                    <legend>{translate name="About You"}</legend>
                    <textarea class="ckeditor editor-html" name="intro" id="intro" placeholder="Intro">{$user->getProfile('intro')}</textarea>
                </fieldset>

                <div class="form-actions">
                    <button type="submit" class="btn btn-primary pull-right">{translate name="Update"}</button>
                </div>
            </form>
        </div>
        <div class="span6">
            <form class="form" action="{geturl action="notification"}" method="POST">
                {formhash hash=$hash}
                <fieldset>
                    <legend>{translate name="Notification"}</legend>
                    <label>{translate name="On HK-Cupid"}</label>
                    <label class="checkbox">
                        <input type="checkbox" name="receive_all_notification_on_web" {if $user->getProfile('receive_all_notification_on_web')}checked{else}checked{/if} disabled />
                        {translate name="All Notification"}
                    </label>
                </fieldset>
                <hr />
                <fieldset>
                    <label>{translate name="Email"}</label>
                    <label class="radio">
                        <input type="radio" name="receive_all_notification_by_email" value="0" {if $user->getProfile('receive_all_notification_by_email')}checked{else}checked{/if} disabled />
                        {translate name="Receive all notifications by email"}
                    </label>
                </fieldset>
                <div class="form-actions">
                    <button type="submit" class="btn btn-primary pull-right">{translate name="Update"}</button>
                </div>
            </form>
        </div>
    </div>

    <div class="row-fluid">
        <div class="span6">
            <form class="form" action="{geturl action="basicinfo"}" method="POST">
                <fieldset>
                    <legend>{translate name="Basic Info"}</legend>
                    <label for="birthday">{translate name="Birthday"}</label>
                    {html_select_date prefix="birthday_" time=$user->getProfile('birthday') start_year=-100 class="span4"}
                    {birthday_format default=$user->getProfile('birthday_format')}
                    <hr />
                    <label for="gender">{translate name="Gender"}</label>
                    <label class="radio inline">
                        <input type="radio" id="gender" name="gender" value="1" {if $user->getProfile('gender') == 1} checked {/if} /> {translate name="Male"}
                    </label>
                    <label class="radio inline">
                        <input type="radio" id="gender" name="gender" value="2" {if $user->getProfile('gender') == 2} checked {/if} /> {translate name="Female"}
                    </label>
                    <hr />
                    <label for="blood_type">{translate name="Blood Type"}</label>
                    {blood_type default=$user->getProfile('blood_type')}
                    <hr />
                    <label for="interested_in">{translate name="Interested In"}</label>
                    {interested_in default=$user->getProfile('interested_in')}
                </fieldset>
                <div class="form-actions">
                    <button type="submit" class="btn btn-primary pull-right">{translate name="Update"}</button>
                </div>
            </form>
        </div>

        <div class="span6">
            <form class="form" action="{geturl action="privacy"}" method="POST">
                {formhash hash=$hash}
                <fieldset>
                    <legend>{translate name="Privacy"}</legend>
                    <label for="public_search">{translate name="Public Search"}</label>
                    <label class="checkbox">
                        <input type="checkbox" name="public_search" {if $user->getProfile('public_search')}checked name="0"{else}name="1"{/if} /> {translate name="Allow search from public"}
                    </label>
                    <label for="send_message_permission">{translate name="Send you message"}</label>
                    <label class="checkbox">
                        <input type="checkbox" name="send_message_permission" {if $user->getProfile('send_message_permission')}checked name="0"{else}name="1"{/if} /> {translate name="Who can send you private message"}
                    </label>
                </fieldset>
                <div class="form-actions">
                    <button type="submit" class="btn btn-primary pull-right">{translate name="Update"}</button>
                </div>
            </form>
        </div>

        <div class="span6">
            <form class="form form-horizontal" action="{geturl action="security"}" method="POST">
                {formhash hash=$hash}
                <fieldset>
                    <legend>{translate name="Security"}</legend>
                    <label for="secure_browsing">{translate name="Secure Browsing"}</label>
                    <label class="checkbox">
                        <input type="checkbox" name="secure_browsing" id="secure_browsing" {if $user->getProfile('secure_browsing')}checked name="0"{else}name="1"{/if} />&nbsp;{translate name="Enable?"}
                    </label>
                </fieldset>
                <hr />
                <fieldset>
                    <label for="login_notification">{translate name="Login Notification"}</label>
                    <label class="checkbox">
                        <input type="checkbox" name="login_notification_email" {if $user->getProfile('login_notification_email')}checked name="0"{else}name="1"{/if} />&nbsp;{translate name="Email"}
                    </label>
                    <label for="checkbox">
                        <input type="checkbox" name="login_notification_sms" {if $user->getProfile('login_notification_sms')}checked name="0"{else}name="1"{/if} />&nbsp;{translate name="SMS"}
                    </label>
                </fieldset>
                <div class="form-actions">
                    <button type="submit" class="btn btn-primary pull-right">{translate name="Update"}</button>
                </div>
            </form>
        </div>
    </div>
</div>
<script src="/js/cupid-form-settings.js" type="text/javascript"></script>