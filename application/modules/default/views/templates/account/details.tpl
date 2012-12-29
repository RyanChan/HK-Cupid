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
                <label for="mobile">{translate name="Mobile"}</label>
                <input type="text" id="mobile" name="mobile" value="{$user->getProfile('mobile')|escape}" />
            </fieldset>
            <fieldset>
                <label for="gender">{translate name="Gender"}</label>
                <input type="radio" id="gender" name="gender" value="1" {if $user->getProfile('gender') == 1} checked {/if} /> {translate name="Male"}
                <input type="radio" id="gender" name="gender" value="2" {if $user->getProfile('gender') == 2} checked {/if} /> {translate name="Female"}
            </fieldset>
            <fieldset>
                <label for="birthday">{translate name="Birthday"}</label>
                {html_select_date prefix="birthday_" time=$user->getProfile('birthday') start_year=-100}
            </fieldset>
            <fieldset>
                <label for="relationship">{translate name="Relationship"}</label>
                {relationship default=$user->getProfile('relationship')}
            </fieldset>
            <fieldset>
                <label for="bodytype">{translate name="Body Type"}</label>
                {bodytype default=$user->getProfile('bodytype')}
            </fieldset>
            <fieldset>
                <label for="smoking">{translate name="Smoke"}</label>
                {smoking default=$user->getProfile('smoking')}
            </fieldset>
            <fieldset>
                <label for="drinking">{translate name="Drinking"}</label>
                {drinking default=$user->getProfile('drinking')}
            </fieldset>
            <fieldset>
                <label for="resting">{translate name="Resting"}</label>
                {resting default=$user->getProfile('resting')}
            </fieldset>
            <fieldset>
                <label for="cartag">{translate name="Car tag"}</label>
                {cartag default=$user->getProfile('cartag')}
            </fieldset>
            <fieldset>
                <label for="maxconsume">{translate name="Max Consume"}</label>
                {maxconsume default=$user->getProfile('maxconsume')}
            </fieldset>
            <fieldset>
                <label for="romance">{translate name="Romance"}</label>
                {romance default=$user->getProfile('romance')}
            </fieldset>
            <fieldset>
                <label for="location">{translate name="Location"}</label>
                <input type="text" id="location" name="location" value="{$user->getProfile('location')|escape}" />
            </fieldset>
            <fieldset>
                <label for="house_tag">{translate name="House Tag"}</label>
                {housetag default=$user->getProfile('house_tag')}
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