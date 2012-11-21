<header>
    <div class="container clearfix">

        <div class="one-third column">
            <div class="logo">
                <a href="{geturl module="default"}">
                    <img src="/images/logo2.png" alt="Crevision - Creative Template" />
                </a>
            </div>
        </div><!-- End Logo -->

        <div class="two-thirds column">
            <nav id="menu" class="navigation">
                <ul id="nav">
                    <li><a href="{geturl module="default" controller="index" action="index"}" class="active">{translate name="Home"}</a></li>
                    <li><a href="#" >{translate name="dating"}</a></li>
                </ul>
            </nav>
        </div><!-- End Menu -->

        <div class="sixteen columns"><hr /></div>

    </div><!-- End Container -->
</header><!-- <<< End Header >>> -->

{if $title == 'Home'}
    {include file="slider.tpl"}
{/if}