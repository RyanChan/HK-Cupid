{include file="header.tpl" title="Confirmation"}

<div class="container clearfix">
    <div class="sixteen columns bottom-2">
        <div class="welcome">
            {if $action == 'email'}
                {if $errors|count == 0}
                    <p>
                        Your account have been activated. Please login to your account or <a href="{geturl action="login"}">Click here</a> to redirect to login page.
                    </p>
                {else}
                    <p>
                        Your account can not be activated. Please contact our service center.
                    </p>
                {/if}
            {/if}
        </div>
    </div>
</div>

{include file="footer.tpl"}