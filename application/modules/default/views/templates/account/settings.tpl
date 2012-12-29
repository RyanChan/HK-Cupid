{include file="header.tpl" title="Settings"}

<div class="container clearfix">

    <div class="eleven columns bottom">
        <h2 class="title">
            {translate name="Settings"}
            <span class="line"></span>
        </h2>
        
        <div class="box">
            <form id="setting-form" method="POST" action="{geturl action="settings"}" class="form-elements">
                <fieldset>
                    <label for="activation">{translate name="Activation"}</label>
                </fieldset>
            </form>
        </div>
    </div>
    
    {include file="user/navigation.tpl"}
</div>

{include file="footer.tpl"}