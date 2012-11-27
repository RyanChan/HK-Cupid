{include file="header.tpl" title="Register"}

<div class="container clearfix">

    <div class="sixteen columns bottom-2">
        <h2 class="title">Register to {translate name="Champs"}<span class="line"></span></h2>

        <form action="{geturl action="register"}" method="POST" class="form-elements2">
            <fieldset>
                <label id="first_name">First Name</label>
                <input type="text" name="first_name" id="first_name" />
            </fieldset>
            <fieldset>
                <label id="last_name">Last Name</label>
                <input type="text" name="last_name" id="last_name" />
            </fieldset>
            <fieldset>
                <label id="email">Email Address</label>
                <input type="text" name="email" id="email" />
            </fieldset>
            <fieldset>
                <label id="password">Password</label>
                <input type="password" name="password" id="password" />
            </fieldset>
            <fieldset>
                <input type="submit" class="button small color" value="Register" />
                <input type="reset" class="button small gray" value="Reset" />
            </fieldset>
        </form>
    </div>
    {if $fp->hasError()}
        {include file="error.tpl" error=$fp->getErrors()}
    {/if}
</div>

{include file="footer.tpl"}