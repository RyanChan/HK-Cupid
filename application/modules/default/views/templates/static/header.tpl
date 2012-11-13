<header>
    <div class="container clearfix">

        <div class="one-third column">
            <div class="logo">
                <a href="{geturl controller="index" action="index"}">
                    <img src="/images/logo.png" alt="Crevision - Creative Template" />
                </a>
            </div>
        </div><!-- End Logo -->

        <div class="two-thirds column">
            <nav id="menu" class="navigation">
                <ul id="nav">
                    <li><a href="{geturl controller="index" action="index"}" class="active">Home</a>
                    </li>
                </ul>
            </nav>
        </div><!-- End Menu -->

        <div class="sixteen columns"><hr /></div>
    </div><!-- End Container -->
</header><!-- <<< End Header >>> -->

{if $title="index"}
    {include file="slider.tpl"}
{/if}