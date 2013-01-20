<div class="navbar navbar-inverse navbar-fixed-top">
    <div class="navbar-inner">
        <div class="container">
            <a class="btn btn-navbar" data-toggle="collapse" data-target=".nav-collapse">
                <span class="icon-bar"></span>
                <span class="icon-bar"></span>
                <span class="icon-bar"></span>
            </a>
            <a class="brand" href="/">{translate name="Champs"}</a>
            <div class="nav-collapse collapse">
                <ul class="nav">
                    <li class="divider-vertical"></li>
                    <li class="{if $controller == "index"}active{/if}">
                        <a href="/">{translate name="Home"}</a>
                    </li>
                    <li class="dropdown {if $controller == "dating" || $controller == "album"}active{/if}">
                        <a href="{geturl controller="dating"}" class="dropdown-toggle" data-toggle="dropdown">
                            {translate name="Dating"}
                            <b class="caret"></b>
                        </a>
                        <ul class="dropdown-menu">
                            <li class="nav-header">{translate name="Find your target"}</li>
                            <li><a href="{geturl controller="dating" action="browse" parameters=['view' => 'newest']}">{translate name="Newest Member"}</a></li>
                            <li><a href="{geturl controller="dating" action="browse" parameters=['view' => 'hottest']}">{translate name="Hottest Member"}</a></li>
                            <li class="divider"></li>
                            <li><a href="{geturl controller="dating" action="online" parameters=['view' => 'male']}">{translate name="Male Member"}</a></li>
                            <li><a href="{geturl controller="dating" action="online" parameters=['view' => 'female']}">{translate name="Female Member"}</a></li>
                            <li class="divider"></li>
                            <li class="nav-header">{translate name="Album Shares"}</li>
                            <li><a href="{geturl controller="album" action="browse" parameters=['view' => 'newest']}">{translate name="Newest Albums"}</a></li>
                            <li><a href="{geturl controller="album" action="browse" parameters=['view' => 'hottest']}">{translate name="Hottest Albums"}</a></li>
                            <li class="divider"></li>
                            <li><a href="{geturl controller="album" action="browse" parameters=['view' => 'male']}">{translate name="Male"}</a></li>
                            <li><a href="{geturl controller="album" action="browse" parameters=['view' => 'female']}">{translate name="Female"}</a></li>

                        </ul>
                    </li>
                    <li class="dropdown {if $controller == "deals"}active{/if}">
                        <a href="{geturl controller="deals"}" class="dropdown-toggle" data-toggle="dropdown">
                            {translate name="Deals"}
                            <b class="caret"></b>
                        </a>
                        <ul class="dropdown-menu">
                            <li><a href="{geturl controller="deals" action="browse" parameters=['view' => 'newest']}">{translate name="Newest Product"}</a></li>
                            <li><a href="{geturl controller="deals" action="browse" parameters=['view' => 'hottest']}">{translate name="Hottest Product"}</a></li>
                            <li><a href="{geturl controller="deals" action="browse" parameters=['view' => 'featured']}">{translate name="Featured Product"}</a></li>
                        </ul>
                    </li>
                </ul>
                <form class="navbar-search pull-left" action="">
                    <input type="text" class="search-query span3" placeholder="Search" />
                </form>
                {if $authenticated}
                    <ul class="nav pull-right">
                        <li class="dropdown {if $controller == "account"}active{/if}">
                            <a href="{geturl controller="account"}" class="dropdown-toggle" data-toggle="dropdown">
                                {translate name="Account"}
                                <b class="caret"></b>
                            </a>
                            <ul class="dropdown-menu">
                                {if $authenticated}
                                    <li class="nav-header">{translate name="Dating"}</li>

                                    <li class="divider"></li>
                                    <li class="nav-header">{translate name="Album"}</li>
                                    <li><a href="/{$identity->nickname|escape}/albums">{translate name="Albums"}</a></li>
                                    <li class="divider"></li>
                                    <li class="nav-header">{translate name="Deals"}</li>
                                    <li><a href="/{$identity->nickname|escape}/products">{translate name="Products"}</a></li>
                                    <li class="divider"></li>
                                    <li class="nav-header">{translate name="Profile"}</li>
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
                {else}
                    <form class="navbar-form pull-right" method="POST" action="{geturl controller="account" action="login"}">
                        {formhash hash=$hash}
                        <input class="span2" name="username" type="text" placeholder="Username">
                        <input class="span2" name="password" type="password" placeholder="Password">
                        <div class="btn-group">
                            <button class="btn">{translate name="Sign In"}</button>
                            <button class="btn dropdown-toggle" data-toggle="dropdown">
                                <span class="caret"></span>
                            </button>
                            <ul class="dropdown-menu">
                                <li><a href="{geturl controller="account" action="register"}">{translate name="Register"}</a></li>
                            </ul>
                        </div>
                    </form>
                {/if}
            </div><!--/.nav-collapse -->
        </div>
    </div>
</div>