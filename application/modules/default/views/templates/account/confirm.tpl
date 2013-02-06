<div class="container">
    <div class="hero-unit">
        {if $errors|count == 0}
            <p>{translate name="Your account have been activated."}</p>
            <p>{translate name="Please login to your account or "}<a href="{geturl action="login"}">{translate name="Click here"}</a>{translate name=" to redirect to login page."}</p>
        {else}
            <p>{translate name="Your account can not be activated. Please contact our service center."}</p>
        {/if}
    </div>
</div>