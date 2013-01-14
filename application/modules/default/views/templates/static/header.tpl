<header>
    <div class="container clearfix">

        <div class="one-third column">
            <div class="logo">
                <a href="{geturl controller="index" action="index"}">
                    <img src="/images/logo2.png" alt="{translate name="Podot"}" />
                </a>
            </div>
        </div><!-- End Logo -->

        <div class="two-thirds column">
            <nav id="menu" class="navigation">
                <ul id="nav">
                    <li><a href="{geturl controller="index"}" {if $controller == "index"} class="active"{/if}>{translate name="Home"}</a></li>
                    <li>
                        <a href="{geturl controller="dating"}" {if $controller == "dating"} class="active"{/if}>{translate name="Online Dating"}</a>
                        <ul>
                            <li><a href="{geturl controller="dating" action="browse" parameters=['view' => 'newest']}">{translate name="Newest Member"}</a></li>
                            <li><a href="{geturl controller="dating" action="browse" parameters=['view' => 'hottest']}">{translate name="Hottest Member"}</a></li>
                            <li>
                                <a href="{geturl controller="dating" action="online"}">{translate name="Online Member"}</a>
                                <ul>
                                    <li><a href="{geturl controller="dating" action="online" parameters=['view' => 'male']}">{translate name="Male Member"}</a></li>
                                    <li><a href="{geturl controller="dating" action="online" parameters=['view' => 'female']}">{translate name="Female Member"}</a></li>
                                </ul>
                            </li>
                            <li>
                                <a href="{geturl controller="album"}">{translate name="Album Shares"}</a>
                                <ul>
                                    <li><a href="{geturl controller="album" action="browse" parameters=['view' => 'newest']}">{translate name="Newest Albums"}</a></li>
                                    <li><a href="{geturl controller="album" action="browse" parameters=['view' => 'hottest']}">{translate name="Hottest Albums"}</a></li>
                                    <li>
                                        <a href="{geturl controller="album" action="browse"}">{translate name="Albums"}</a>
                                        <ul>
                                            <li><a href="{geturl controller="album" action="browse" parameters=['view' => 'male']}">{translate name="Male"}</a></li>
                                            <li><a href="{geturl controller="album" action="browse" parameters=['view' => 'female']}">{translate name="Female"}</a></li>
                                        </ul>
                                    </li>
                                </ul>
                            </li>
                        </ul>
                    </li>
                    <li>
                        <a href="{geturl controller="deals"}" {if $controller == "deals"} class="active"{/if}>{translate name="Deals Center"}</a>
                        <ul>
                            <li><a href="{geturl controller="deals" parameters=['view' => 'newest']}">{translate name="Newest Product"}</a></li>
                            <li><a href="{geturl controller="deals" parameters=['view' => 'hottest']}">{translate name="Hottest Product"}</a></li>
                            <li><a href="{geturl controller="deals" parameters=['view' => 'featured']}">{translate name="Featured Product"}</a></li>
                        </ul>
                    </li>
                    <li>
                        <a href="{geturl controller="account"}" {if $controller == "account"} class="active"{/if}>{translate name="Account"}</a>
                        <ul>
                            {if $authenticated}
                                <li><a href="{geturl controller="account" action="profile"}">{translate name="Profile"}</a></li>
                                <li><a href="{geturl controller="account" action="details"}">{translate name="Details"}</a></li>
                                <li><a href="{geturl controller="account" action="settings"}">{translate name="Settings"}</a></li>
                                <li><a href="{geturl controller="account" action="logout"}">{translate name="Logout"}</a></li>
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