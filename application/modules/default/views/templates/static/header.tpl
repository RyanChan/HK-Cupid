<header>
    <div class="container clearfix">

        <div class="one-third column">
            <div class="logo">
                <a href="{geturl controller="index" action="index"}">
                    <img src="/images/logo2.png" alt="Crevision - Creative Template" />
                </a>
            </div>
        </div><!-- End Logo -->

        <div class="two-thirds column">
            <nav id="menu" class="navigation">
                <ul id="nav">
                    <li><a href="{geturl controller="index" action="index"}" {if $controller == "index"} class="active"{/if}>{translate name="Home"}</a></li>
                    <li><a href="#">{translate name="dating"}</a></li>
                    <li>
                        <a href="{geturl controller="account" action="index"}" {if $controller == "account"} class="active"{/if}>{translate name="Account"}</a>
                        <ul>
                            {if $authenticated}
                                <li><a href="{geturl controller="account" action="logout"}">{translate name="logout"}</a></li>
                            {else}
                                <li><a href="{geturl controller="account" action="login"}">{translate name="Login"}</a></li>
                                <li><a href="{geturl controller="account" action="register"}">{translate name="Register"}</a></li>
                            {/if}
                        </ul>
                    </li>
                </ul>
            </nav>
        </div><!-- End Menu -->

        <div class="sixteen columns"><hr /></div>

    </div><!-- End Container -->
</header><!-- <<< End Header >>> -->

{if $title == 'Home'}
    {include file="slider.tpl"}
{/if}