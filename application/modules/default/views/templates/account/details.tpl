{include file="header.tpl" title="Details"}

<div class="container clearfix">

    <div class="eleven columns bottom-2">
        <h2 class="title">
            {translate name="Details"}
            <span class="line"></span>
        </h2>
        <form id="basic-normal-form" action="{geturl action="details"}" method="POST" class="form-elements">
            <fieldset>
                <label for="nickname">{translate name="Nickname"}</label>
                <input type="text" id="nickname" name="nickname" value="{$user->getProfile('nickname')|escape}" />
            </fieldset>
            <fieldset>
                <label for="email">{translate name="Email"}</label>
                <input type="text" id="email" name="email" value="{$user->getProfile('email')|escape}" />
            </fieldset>
            <fieldset>
                <label for="birthday">{translate name="Birthday"}</label>
                {html_select_date prefix="birthday_" time=$user->getProfile('birthday') start_year=-100}
            </fieldset>
            <fieldset>
                <label for="location">{translate name="Location"}</label>
                <input type="text" id="location" name="location" value="{$user->getProfile('location')|escape}" />
            </fieldset>
            <fieldset>
                <label for="mobile">{translate name="Mobile"}</label>
                <input type="text" id="mobile" name="mobile" value="{$user->getProfile('mobile')|escape}" />
            </fieldset>
            <fieldset>
                <label for="education">{translate name="Education"}</label>
                {educationlist default=$user->getProfile('education')}
            </fieldset>
            <fieldset>
                <label for="personalincome">{translate name="Personal Income"}</label>
                {personalincome default=$user->getProfile('personalincome')}
            </fieldset>
            <fieldset>
                <label for="profession">{translate name="Profession"}</label>
                {profession default=$user->getProfile('profession')}
            </fieldset>
            <fieldset>
                <label for="occupation">{translate name="Occupation"}</label>
                {occupation default=$user->getProfile('occupation')}
            </fieldset>
            <fieldset>
                <label for="intro">{translate name="Intro"}</label>
                <textarea name="intro">{$user->getProfile('intro')|escape}</textarea>
            </fieldset>
            <fieldset>
                <input type="submit" value="{translate name="Update"}" class="button small color" />
                <input type="submit" value="{translate name="Reset"}" class="button small gray" />
            </fieldset>
            <div class="clear"></div>
        </form>
    </div>

    {include file="user/navigation.tpl"}
    
    {if $form->hasError()}
        {include file="error.tpl" error=$form->getErrors()}
    {/if}
</div>

{include file="footer.tpl"}