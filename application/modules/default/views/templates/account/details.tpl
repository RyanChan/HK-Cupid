{include file="header.tpl" title="Details"}

<div class="container clearfix">

    <div class="eleven columns bottom-2">
        <h2 class="title">
            {translate name="Details"}
            <span class="line"></span>
        </h2>
        <form id="basic-normal-form" action="{geturl action="details"}" method="POST" class="form-elements">
            {formhash hash=$hash}
            <fieldset>
                <h3>
                    <label for="nickname">{translate name="Nickname"}</label>
                </h3>
                <input type="text" id="nickname" name="nickname" value="{$user->getProfile('nickname')|escape}" />
            </fieldset>
            <fieldset>
                <h3>
                    <label for="email">{translate name="Email"}</label>
                </h3>
                <input type="text" id="email" name="email" value="{$user->getProfile('email')|escape}" />
            </fieldset>
            <fieldset>
                <h3>
                    <label for="mobile">{translate name="Mobile"}</label>
                </h3>
                <input type="text" id="mobile" name="mobile" value="{$user->getProfile('mobile')|escape}" />
            </fieldset>
            <fieldset>
                <h3>
                    <label for="gender">{translate name="Gender"}</label>
                </h3>
                <input type="radio" id="gender" name="gender" value="1" {if $user->getProfile('gender') == 1} checked {/if} /> {translate name="Male"}
                <input type="radio" id="gender" name="gender" value="2" {if $user->getProfile('gender') == 2} checked {/if} /> {translate name="Female"}
            </fieldset>
            <fieldset>
                <h3>
                    <label for="birthday">{translate name="Birthday"}</label>
                </h3>
                {html_select_date prefix="birthday_" time=$user->getProfile('birthday') start_year=-100}
            </fieldset>
            <fieldset>
                <h3>
                    <label for="relationship">{translate name="Relationship"}</label>
                </h3>
                {relationship default=$user->getProfile('relationship')}
            </fieldset>
            <fieldset>
                <h3>
                    <label for="bodytype">{translate name="Body Type"}</label>
                </h3>
                {bodytype default=$user->getProfile('bodytype')}
            </fieldset>
            <fieldset>
                <h3>
                    <label for="smoking">{translate name="Smoke"}</label>
                </h3>
                {smoking default=$user->getProfile('smoking')}
            </fieldset>
            <fieldset>
                <h3>
                    <label for="drinking">{translate name="Drinking"}</label>
                </h3>
                {drinking default=$user->getProfile('drinking')}
            </fieldset>
            <fieldset>
                <h3>
                    <label for="resting">{translate name="Resting"}</label>
                </h3>
                {resting default=$user->getProfile('resting')}
            </fieldset>
            <fieldset>
                <h3>
                    <label for="cartag">{translate name="Car tag"}</label>
                </h3>
                {cartag default=$user->getProfile('cartag')}
            </fieldset>
            <fieldset>
                <h3>
                    <label for="maxconsume">{translate name="Max Consume"}</label>
                </h3>
                {maxconsume default=$user->getProfile('maxconsume')}
            </fieldset>
            <fieldset>
                <h3>
                    <label for="romance">{translate name="Romance"}</label>
                </h3>
                {romance default=$user->getProfile('romance')}
            </fieldset>
            <fieldset>
                <h3>
                    <label for="location">{translate name="Location"}</label>
                </h3>
                <input type="text" id="location" name="location" value="{$user->getProfile('location')|escape}" />
            </fieldset>
            <fieldset>
                <h3>
                    <label for="house_tag">{translate name="House Tag"}</label>
                </h3>
                {housetag default=$user->getProfile('house_tag')}
            </fieldset>
            <fieldset>
                <h3>
                    <label for="education">{translate name="Education"}</label>
                </h3>
                {educationlist default=$user->getProfile('education')}
            </fieldset>
            <fieldset>
                <h3>
                    <label for="personalincome">{translate name="Personal Income"}</label>
                </h3>
                {personalincome default=$user->getProfile('personalincome')}
            </fieldset>
            <fieldset>
                <h3>
                    <label for="profession">{translate name="Profession"}</label>
                </h3>
                {profession default=$user->getProfile('profession')}
            </fieldset>
            <fieldset>
                <h3>
                    <label for="occupation">{translate name="Occupation"}</label>
                </h3>
                {occupation default=$user->getProfile('occupation')}
            </fieldset>
            <fieldset>
                <h3>
                    <label for="intro">{translate name="Intro"}</label>
                </h3>   
                <textarea class="ckeditor" name="intro">{$user->getProfile('intro')|escape}</textarea>
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