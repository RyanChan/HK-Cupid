<style>
    .form-register {
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
    .form-register .form-register-heading,
    .form-register .checkbox {
        margin-bottom: 10px;
    }
    .form-register input[type="text"],
    .form-register input[type="password"] {
        font-size: 16px;
        height: auto;
        width:310px;
        margin-bottom: 15px;
        padding: 7px 9px;
    }
</style>

<div class="container">
    <form class="form-register" action="{geturl action="details"}" method="POST">
        {formhash hash=$hash}
        <fieldset>
            <legend>{translate name="Personal Info"}</legend>

            <label for="nickname">{translate name="Nickname"}</label>
            <input type="text" id="nickname" name="nickname" placeholder="{translate name="Nickname"}" value="{$user->getProfile('nickname')|escape}" />

            <label for="email">{translate name="Email Address"}</label>
            <input type="text" id="email" name="email" placeholder="{translate name="Email Address"}" value="{$user->getProfile('email')|escape}" />

            <label for="mobile">{translate name="Mobile"}</label>
            <input type="text" id="mobile" name="mobile" placeholder="{translate name="Mobile Number"}" value="{$user->getProfile('mobile')|escape}" />

            <label for="intro">{translate name="Intro"}</label>
            <textarea class="ckeditor editor-html" name="intro" id="intro" placeholder="Intro">{$user->getProfile('intro')|escape}</textarea>

            <br />
        </fieldset>
        <fieldset>
            <legend>{translate name="Dating Info"}</legend>

            <label for="gender">{translate name="Gender"}</label>
            <label class="radio inline">
                <input type="radio" id="gender" name="gender" value="1" {if $user->getProfile('gender') == 1} checked {/if} /> {translate name="Male"}
            </label>
            <label class="radio inline">
                <input type="radio" id="gender" name="gender" value="2" {if $user->getProfile('gender') == 2} checked {/if} /> {translate name="Female"}
            </label>

            <br /><br />

            <label for="birthday">{translate name="Birthday"}</label>
            {html_select_date prefix="birthday_" time=$user->getProfile('birthday') start_year=-100}

            <label for="relationship">{translate name="Relationship"}</label>
            {relationship default=$user->getProfile('relationship')}

            <label for="bodytype">{translate name="Body Type"}</label>
            {bodytype default=$user->getProfile('bodytype')}

            <label for="smoking">{translate name="Smoke"}</label>
            {smoking default=$user->getProfile('smoking')}

            <label for="drinking">{translate name="Drinking"}</label>
            {drinking default=$user->getProfile('drinking')}

            <label for="resting">{translate name="Resting"}</label>
            {resting default=$user->getProfile('resting')}

            <label for="cartag">{translate name="Car tag"}</label>
            {cartag default=$user->getProfile('cartag')}

            <label for="maxconsume">{translate name="Max Consume"}</label>
            {maxconsume default=$user->getProfile('maxconsume')}

            <label for="romance">{translate name="Romance"}</label>
            {romance default=$user->getProfile('romance')}

            <label for="location">{translate name="Location"}</label>
            <input type="text" id="location" name="location" placeholder="Location" value="{$user->getProfile('location')|escape}" />

            <label for="house_tag">{translate name="House Tag"}</label>
            {housetag default=$user->getProfile('house_tag')}

            <label for="education">{translate name="Education"}</label>
            {educationlist default=$user->getProfile('education')}

            <label for="personalincome">{translate name="Personal Income"}</label>
            {personalincome default=$user->getProfile('personalincome')}

            <label for="profession">{translate name="Profession"}</label>
            {profession default=$user->getProfile('profession')}

            <label for="occupation">{translate name="Occupation"}</label>
            {occupation default=$user->getProfile('occupation')}
        </fieldset>
        <div class="form-actions">
            <button type="submit" class="btn btn-primary pull-right">{translate name="Save changes"}</button>
            <a href="{geturl action="profile"}" class="btn">{translate name="Cancel"}</a>
        </div>
    </form>
</div>