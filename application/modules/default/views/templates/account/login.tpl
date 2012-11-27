{include file="header.tpl" title="Login"}

<div class="container clearfix">
    <div class="sixteen columns bottom-2">
        <h2 class="title">Login to {translate name="Champs"}<span class="line"></span></h2>
        <form action="{geturl action="login"}" method="POST" class="form-elements2">
            <fieldset>
                <label id="username">Username</label>
                <input type="text" name="username" id="username" />
            </fieldset>
            <fieldset>
                <label id="password">Password</label>
                <input type="password" name="password" id="password" />
            </fieldset>
            <fieldset>
                <input type="submit" class="button small color" value="Login" />
            </fieldset>
        </form>
    </div>
    <div class="clearfix"></div>
    {include file="error.tpl" error=$errors}
</div>

{include file="footer.tpl"}