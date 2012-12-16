{include file="header.tpl" title="Authenticate"}

<div class="container clearfix">
    <div class="eleven columns bottom-2">
        <h2 class="title">
            {translate name="Authentication"}
            <span class="line"></span>
        </h2>


        <div id="horizontal-tabs">
            <ul class="tabs">
                <li id="tab1">{translate name="ID"}</li>
                <li id="tab2">{translate name="Mobile"}</li>
                <li id="tab3">{translate name="Email"}</li>
            </ul>

            <div class="contents">
                <div id="content1" class="tabscontent">
                    <form id="basic-normal-form" action="{geturl action="auth"}" method="POST" class="form-elements">
                        <fieldset>
                            <label for="hk_identity">{translate name="Hong Kong ID"}</label>
                            <input type="text" name="hk_identity" value="{$user->getProfile('hkid')}" />
                            <input type="submit" value="{translate name="Validate"}" class="button small color" />
                        </fieldset>
                        <div class="clear"></div>
                    </form>
                </div>
                <div id="content2" class="tabscontent">
                    <form id="basic-normal-form" action="{geturl action="auth"}" method="POST" class="form-elements">
                        <fieldset>
                            <label for="mobile_identity">{translate name="Mobile"}</label>
                            <input type="text" name="mobile_identity" value="{$user->getProfile('mobile')}" />
                            <input type="submit" value="{translate name="Validate"}" class="button small color" />
                        </fieldset>
                        <div class="clear"></div>
                    </form>
                </div>
                <div id="content3" class="tabscontent">
                    <form id="basic-normal-form" action="{geturl action="auth"}" method="POST" class="form-elements">
                        <fieldset>
                            <label for="email_identity">{translate name="Email"}</label>
                            <input type="text" name="email_identity" value="{$user->getProfile('email')}" />
                            <input type="submit" value="{translate name="Validate"}" class="button small color" />
                        </fieldset>
                        <div class="clear"></div>
                    </form>
                </div>
            </div>
        </div>
    </div>
    {include file="user/navigation.tpl"}
</div>

{include file="footer.tpl"}