<div class="container">
    <div class="hero-unit">
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